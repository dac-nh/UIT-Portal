<?php
/**
 * Created by PhpStorm.
 * User: Dark Wolf
 * Date: 10/25/2016
 * Time: 11:12 AM
 */
namespace App\Repositories\User;

use App\Http\Controllers\EmailController;
use App\Libraries\GeneralConstant;
use App\Models\User;
use App\Repositories\LogHistoryUserLogin\LogHistoryUserLoginInterface;
use Auth;
use DB;
use Exception;
use Google_Client;
use Google_Service_Drive;
use Hash;
use Illuminate\Http\Request;
use Log;
use App\Repositories\StudentProfiles\StudentProfilesInterface;

/**
 * @property StudentProfilesInterface studentProfiles
 * @property LogHistoryUserLoginInterface logHistoryUserLogin
 */
class UserRepository implements UserInterface
{
    public $user;

    /**
     * UserRepository constructor.
     * @param User $user
     * @param StudentProfilesInterface $studentProfiles
     * @param LogHistoryUserLoginInterface $logHistoryUserLogin
     */
    function __construct(User $user, StudentProfilesInterface $studentProfiles, LogHistoryUserLoginInterface $logHistoryUserLogin)
    {
        $this->user = $user;
        $this->studentProfiles = $studentProfiles;
        $this->logHistoryUserLogin = $logHistoryUserLogin;
    }

    public function deactivateById($user)
    {
        DB::transaction(function () use ($user) {
            try {
                $user->is_active = GeneralConstant::IS_DEACTIVATE;
                $user->save();
            } catch (Exception $exception) {
                Log::info('[DEACTIVATE USER]');
            }
        });
        return true;
    }

    public function getAll()
    {
        return $this->user->all();
    }

    public function findById($id)
    {
        try {
            $user = $this->user->find($id);
        } catch (Exception $exception) {
            Log::info('[USER REPOSITORY] BUG WHILE QUERY FIND BY ID');
            return false;
        }
        return $user;
    }

    // 10-27-2016: Dac: find user by field
    public function findUserBy($field, $name)
    {
//        return $this->user->where($field, $name)->first();
        // 11-18-2016: Dac: get user
        return $this->user->where($field, $name)->first();
    }

    public function findUserByEmail($email)
    {
        return $this->user->where('email', $email)->first();
    }

    public function findUserByGoogleId($googleId)
    {
        return $this->user->where('google_id', $googleId)->first();
    }

    public function findUserByCompanyId($company_id)
    {
        try {
            $user = $this->user->where('company_id', $company_id)->first();
        } catch (Exception $exception) {
            Log::info('[USER REPOSITORY] BUG WHILE QUERY FIND BY ID');
            return false;
        }
        return $user;
    }

    public function registerUser($name, $email, $password, $googleId)
    {
        if ($googleId == "") {
            $user = new User();
            $result = DB::transaction(function () use ($name, $email, $password, $user) {
                try {
                    //register user
                    $user->name = $name;
                    $user->email = $email;
                    $user->password = $password;
                    $user->save();
                    //student profile
                    $user = $this->findUserByEmail($email); // get new user info
                    if (!$this->studentProfiles->insertStudentProfile($user->id, $user->name)) {
                        DB::rollBack();
                        return false;
                    }
                } catch (\Exception $exception) {
                    Log::info('[USER REPOSITORY] CAN NOT INSERT TO USER WITH EXCEPTION: ' . $exception);
                    return false;
                }
                return $user;
            });
        } else {
            $user = new User();
            $result = DB::transaction(function () use ($name, $email, $password, $googleId, $user) {
                try {
                    //register user
                    $user->name = $name;
                    $user->email = $email;
                    $user->password = $password;
                    $user->google_id = $googleId;
                    $user->save();

                    $user = $this->findUserByEmail($email); // get new user info
                    if (!$this->studentProfiles->insertStudentProfile($user->id, $user->name)) {
                        DB::rollBack();
                        return false;
                    }
                } catch (\Exception $e) {
                    Log::info('[POST GOOGLE] CAN NOT CREATE USER HAS GOOGLE ID' . $e);
                    return false;
                }
                return $user;
            });
        }
        if (!$result) {
            return $result;
        }
        $user = $result;
        return $user;
    }

    // GOOGLE
    public function createGoogleClient($guzzleClient, $path)
    {
        try {
            $client = new Google_Client();
            $client->setHttpClient($guzzleClient);
            $client->setAuthConfig($path);
            $client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);
            $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST']);
        } catch (Exception $exception) {
            Log::info('[USER REPOSITORY] CAN NOT CREATE GOOGLE CLIENT');
            return false;
        }
        return $client;
    }

    public function loginGoogle(Request $request, $client)
    {
        $result['status'] = GeneralConstant::RESULT_FALSE;

        // send code to google to check back
        $client->authenticate($request['code']);
        $ticket = $client->verifyIdToken();
        Log::info(json_encode($ticket));
        // register new user automatically
        $googleId = $ticket['sub'];

        Log::info($ticket);
        // when user doesn't have google id yet
        $user = $this->findUserByGoogleId($googleId);
        if ($user == null) {
            $email = $ticket['email'];
            $name = $ticket['name'];
            $password = Hash::make(idate("U"));
            $avatar = $ticket['picture'];
            $user = $this->findUserByEmail($email);
            if ($user != null) {// update user if existed but haven't synced with google account
                if (!$user->isActive()) {
                    return $result;
                }
                Log::info($user);
                if ($user->google_id != $googleId) { // != google id
                    $user['google_id'] = $googleId;
                    try {
                        $user->save();
                    } catch (Exception $exception) {
                        Log::info('[POST GOOGLE] catch a bug: ' . $exception);
                        return $result;
                    }
                }
            } else { // a new account
                $user = $this->registerUser($name, $email, $password, $googleId);
                $user->avatar = $avatar;
                $user->save();
                if (!$user) {
                    Log::info('[POST GOOGLE] catch a bug: ' . $user);
                    return $result;
                }
            }
            EmailController::sendEmailSignUp($request, $user, GeneralConstant::STUDENT_ROLE);
        } else {
            if (!$user->isActive()) return $result; // have been deactivated
        }
        Auth::login($user);
        // Write log user login
        $user = $this->findUserByEmail($email);
        Log::info($user);
        $this->logHistoryUserLogin->saveLogHistoryUserLogin($user->id);
        $result['status'] = GeneralConstant::RESULT_SUCCESS;
        return $result;
    }

    public function userLogin(Request $request)
    {
        // Remeber me is checked
        ($request . hasKey('remember_me')) ? $remember = true : $remember = false;
        $user = $this->findUserByEmail($request['email']);
        if ($user == null) {
            return GeneralConstant::RESULT_FALSE;
        }
        // 13-12-2016: check wrong time
        $countWrong = $user->count_wrong;
        if ($countWrong == GeneralConstant::COUNT_TIME_TO_LOCK) {
            // Lock user
            $user->is_active = GeneralConstant::IS_DEACTIVATE;
            $user->save();
            return GeneralConstant::IS_DEACTIVATE;
        } else if ($countWrong >= GeneralConstant::COUNT_TIME_TO_DELAY) {
            // check waiting time
            $currentTime = date('U');
            $lastUserTry = date('U', strtotime($user->log_in_timestamp));
            if ($currentTime - $lastUserTry < GeneralConstant::DELAY_TIME)
                return GeneralConstant::STILL_IN_DELAY_TIME;
        }
        // login
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']], $remember)) {
            // check active
            if (Auth::check()) {
                if (!Auth::user()->isActive()) {
                    Auth::logout();
                    return GeneralConstant::IS_DEACTIVATE;
                }
            }
        } else {
            if ($user != null) {
                if (DB::transaction(function () use ($user) {
                    try {
                        $user->count_wrong++;
                        $user->log_in_timestamp = date("Y-m-d H:i:s");
                        $user->save();
                        return true;
                    } catch (Exception $exception) {
                        Log::info(['[Count Wrong user login bug] Exception: ' . $exception]);
                        return false;
                    }
                })
                ) return GeneralConstant::RESULT_SUCCESS;
            }
            return GeneralConstant::RESULT_FALSE;
        }
        return GeneralConstant::RESULT_SUCCESS;
    }
}