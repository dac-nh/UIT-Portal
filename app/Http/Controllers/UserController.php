<?php
/**
 * Created by PhpStorm.
 * User: Dark Wolf
 * Date: 11/03/2016
 * Time: 2:10 PM
 */

namespace App\Http\Controllers;


use App\Repositories\LogHistoryUserLogin\LogHistoryUserLoginInterface;
use App\Repositories\Project\ProjectInterface;
use App\Repositories\StudentProfiles\StudentProfilesInterface as StudentProfilesInterface;
use App\Repositories\Validation\ValidationInterface as ValidationInterface;
use App\Repositories\User\UserInterface as UserInterface;
use App\Libraries\GeneralConstant as GeneralConstant;
use App\Repositories\UserJoinProject\JoinInterface;
use Auth;
use File;
use Hash;
use Illuminate\Http\Request;
use Log;
use Storage;

/**
 * @property UserInterface user
 * @property StudentProfilesInterface studentProfile
 * @property JoinInterface userJoinProject
 * @property ProjectInterface project
 * @property ValidationInterface validate
 * @property LogHistoryUserLoginInterface logHistoryUserLogin
 */
class UserController extends Controller
{


    /**
     * UserController constructor.
     * @param UserInterface $user
     * @param StudentProfilesInterface $studentProfile
     * @param JoinInterface $userJoinProject
     * @param ProjectInterface $project
     * @param LogHistoryUserLoginInterface $logHistoryUserLogin
     * @param ValidationInterface $validation
     */
    public function __construct(UserInterface $user,
                                StudentProfilesInterface $studentProfile,
                                JoinInterface $userJoinProject,
                                ProjectInterface $project,
                                LogHistoryUserLoginInterface $logHistoryUserLogin,
                                ValidationInterface $validation
        //UniversityInterface $university
    )
    {
        $this->user = $user;
//        $this->studentProfiles = app('App\Repositories\StudentProfiles\StudentProfilesInterface');
        $this->studentProfile = $studentProfile;
        $this->userJoinProject = $userJoinProject;
        $this->project = $project;
        $this->logHistoryUserLogin = $logHistoryUserLogin;
        $this->validate = $validation;
//        $this->university = $university;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = $this->user->getAll();
        return view('users.index', ['users' => $users]);
    }

    public function getSignIn()
    {
        if (Auth::check()) {
            $message = ['message_warning' => GeneralConstant::MESSAGE_LOGGED_IN_ALREADY];
            return redirect()->route('home')->with($message);
        }
        return view('auth.login');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDeactivateUser()
    {
        $this->user->deactivateById(Auth::user());
        Auth::logout();
        $message = ['message_danger' => GeneralConstant::MESSAGE_DEACTIVATE];
        return redirect()->route('sign_up')->with($message);
    }

    /*
     * SET PASSWORD FOR LECTURER AND COMPANY
     */
    /**
     * @param Request $request
     * @param $token
     * @return mixed
     */
    public function getCheckTokenPassword(Request $request, $token)
    {
        if (!$user = $this->user->findUserBy('password', $token)) {
            $message = ['message_danger' => 'Mã này đã bị từ chối!'];
            return redirect()->route('home')->with($message);
        };
        Log::info($token);
        return view('auth\passwords\set_password_token')->with(['token' => $token]);
    }

    // GET AVATAR PATH
    /**
     * @param $id
     * @return string
     */
//    public static function getAvatarPath($id)
//    {
//        // 16-12-2016: Dac: Fix avatar path
//        $extensions = ['.png', '.jpg', '.jpeg'];
//        $avatar_path = Storage::url('/user/avatar/' . GeneralConstant::DEFAULT_AVATAR);
//
//        foreach ($extensions as $item) {
//            Log::info(storage_path('app/public/user/avatar/' . $id . $item));
//            if (FILE::exists(storage_path('app/public/user/avatar/' . $id . $item)))
//                $avatar_path = Storage::url('user/avatar/' . $id . $item);
//        }
//        return $avatar_path;
//    }
    public static function getAvatarPath($id)
    {
        // 16-12-2016: Dac: Fix avatar path
        $extensions = ['.png', '.jpg', '.jpeg'];
        $avatar_path = Storage::url('user/avatar/' . GeneralConstant::DEFAULT_AVATAR);
        foreach ($extensions as $item) {
            Log::info(storage_path('app\public\user\avatar\\' . $id . $item));
            if (FILE::exists(storage_path('app\public\user\avatar\\' . $id . $item)))
                $avatar_path = Storage::url('user/avatar/' . $id . $item);
        }
        return $avatar_path;
    }

    public function getSignUp()
    {
        if (Auth::check()) {
            $message = ['message_warning' => GeneralConstant::MESSAGE_LOGGED_IN_ALREADY];
            return redirect()->route('home')->with($message);
        }
        return view('auth.register');
    }

    /**
     * REGISTER
     * @param Request $request
     * @return mixed
     */
    public function postSignUpUser(Request $request)
    {
        // Validate
        $this->validate->validateSignUpUser($request);

        $email = $request['email'];
        $name = $request['name'];
        $password = Hash::make($request['password']);

        // User have been logged in
        if (Auth::check()) {
            Log::info('[BUGGGGGGGGGGGGGGGGGG][Sign up]Sign up while logging in!');
            $message = ['message_danger' => GeneralConstant::MESSAGE_LOGGED_IN_ALREADY];
            return redirect()->route('home')->with($message);
        };

        $user = $this->user->registerUser($name, $email, $password, "");
        if (!$user) {
            $message = ['message_warning' => 'Đã xảy ra lỗi trong quá trình khởi tạo. Hãy thử lại!'];
            return redirect()->route('sign_up')->with($message);
        }

        Auth::login($user);
        $user = Auth::user();
        EmailController::sendEmailSignUp($request, $user, GeneralConstant::STUDENT_ROLE);
        // Write log user login
        $this->logHistoryUserLogin->saveLogHistoryUserLogin($user->id);
        Log::info('User is create successful');

        return redirect()->route('home');
    }

    /**
     * LOGIN
     * @param Request $request
     * @return mixed
     * @internal param Response $response
     */
    public function postSignIn(Request $request)
    {
        // User have been logged in
        if (Auth::check()) {
            return redirect()->route('home');
        };

        $this->validate->validateSignIn($request);
        switch ($this->user->userLogin($request)) {
            case GeneralConstant::IS_DEACTIVATE:
                $message = ['message_danger' => GeneralConstant::MESSAGE_DEACTIVATE];
                return redirect()->route('sign_in')->with($message);
                break;
            case GeneralConstant::RESULT_FALSE:
                $message = ['message_info' => 'Email/Mật khẩu sai!'];
                return redirect()->route('sign_in')->with($message);
                break;
            case GeneralConstant::STILL_IN_DELAY_TIME:
                $message = ['message_warning' => GeneralConstant::MESSAGE_WRONG_PASSWORD_TIME_TO_DELAY];
                return redirect()->route('sign_in')->with($message);
                break;
        }
        // Write log user login
        $user = Auth::user();
        $this->logHistoryUserLogin->saveLogHistoryUserLogin($user->id);

        return redirect()->route('home');
    }

    /**
     * GOOGLE LOGIN
     * @param Request $request
     * @return int
     */
    public function postGoogle(Request $request)
    {
        $result['status'] = GeneralConstant::RESULT_FALSE;

        // check logged in or not
        if (Auth::check()) {
            return $result['status'] = GeneralConstant::LOGGED_IN_ALREADY;
        }
        // path to google client
        $path = storage_path() . "/json/client_secrets.json";

        $guzzleClient = new \GuzzleHttp\Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false,),));

        $client = $this->user->createGoogleClient($guzzleClient, $path);

        if (!isset($request['code'])) {
            $auth_url = $client->createAuthUrl();
            header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
        } else {
            $result = $this->user->loginGoogle($request, $client);
            Log::info('>>>>>[GOOGLE] REGISTER AND LOG IN GOOGLE SUCCESSFUL!<<<<<');
        }
        return $result;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSetPasswordToken(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:4'
        ]);
        $token = $request['token'];
        if (!$user = $this->user->findUserBy('password', $token)) {
            $message = ['message_danger' => 'Mã này đã bị từ chối!'];
            return redirect()->route('home')->with($message);
        };
        $user->password = Hash::make($request['password']);
        $user->save();
        Auth::login($user);
        $message = ['message_success' => 'Tài khoản của bạn đã khởi tạo mật khẩu thành công!'];
        return redirect()->route('home')->with($message);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function postChangeAvatar(Request $request, $id)
    {
        $result['status'] = GeneralConstant::RESULT_FALSE;
        if (Auth::user()->id != $id) {
            Log::info('[POST CHANGE AVATAR] USER TRY TO CHANGE ANOTHER USER AVATAR');
        }
        if (!$request->hasFile('file')) {
            Log::info('[POST CHANGE AVATAR] Post with no file!');
            return $result;
        }
        $file = $request->file('file');
        Storage::putFileAs('/public/user/avatar', $file, $id . '.' . $file->extension());
        $result['status'] = GeneralConstant::RESULT_SUCCESS;
        $result['avatar'] = self::getAvatarPath($id);
        return $result;
    }
}