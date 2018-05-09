<?php
/**
 * Created by PhpStorm.
 * User: Dark Wolf
 * Date: 11/18/2016
 * Time: 11:42 AM
 */
namespace App\Repositories\StudentProfiles;

use App\Http\Controllers\UserController;
use App\Libraries\GeneralConstant;
use App\Models\StudentProfile;
use DB;
use File;
use Illuminate\Http\Request;
use League\Flysystem\Exception;
use Log;
use Storage;

class StudentProfilesRepository implements StudentProfilesInterface
{
    public $studentProfiles;

    function __construct(StudentProfile $studentProfiles)
    {
        $this->studentProfiles = $studentProfiles;
    }

    public function findById($id)
    {
        try {
            $studentProfiles = $this->studentProfiles->where('student_profile.id', $id)
                ->join('user as user', 'student_profile.id', 'user.id')
                ->select('student_profile.*', 'user.name')
                ->first();
        } catch (Exception $exception) {
            Log::info('[STUDENT PROFILES REPOSITORY] BUG while query find by ID');
            return false;
        }
        return $studentProfiles;
    }

    // 09-12-2016: Dac: update student profile
    public function updateStudentProfile(Request $request, $id)
    {
        Log::info(json_encode($request->has('name')));
        $studentProfile = $this->findById($id);
        if (DB::transaction(function () use ($request, $studentProfile) {
            try {
                $studentProfile->full_name = $request['name'];
                $studentProfile->birthday = $request['birthday'];
                $studentProfile->university_name = $request['university_name'];
                $studentProfile->faculty_name = $request['faculty_name'];
                $studentProfile->major_name = $request['major_name'];
                $studentProfile->academic_year = $request['academic_year'];
                $studentProfile->gpa = $request['gpa'];
                $studentProfile->address = $request['address'];
                $studentProfile->phone = $request['phone'];

                $user = $request->user();
                $user->name = $request['name'];
                $user->university_id = $request['university_id'];
                Log::info($user);

                $user->save();
                $studentProfile->save();
                return true;
            } catch (\Exception $e) {
                Log::info('[UPDATE STUDENT PROFILE] BUG WHILE UPDATE STUDENT PROFILE');
                Log::info($e->getMessage());
                return false;
            }
        })
        ) {
            if ($request->hasFile('file')) {
                $oldAvatarPath = UserController::getAvatarPath($id);
                //                Storage::disk('local_public')->delete($oldAvatarPath);
                $oldStorageAvatarPath = str_replace(Storage::url(''), storage_path('app/public/'), $oldAvatarPath); // public_html
                $oldStorageAvatarPath = str_replace('/', '\\', $oldStorageAvatarPath); // use for local - comment out for online
                FILE::delete($oldStorageAvatarPath);
//                $oldPublicAvatarPath = str_replace(Storage::url(''), public_path('storage/'), $oldAvatarPath); // public_html
//                FILE::delete($oldPublicAvatarPath);
                $file = $request->file('file');
                Storage::disk('public')->putFileAs('/user/avatar', $file, $id . '.' . $file->extension());
//                Storage::disk('local_public')->putFileAs('/storage/user/avatar', $file, $id . '.' . $file->extension());
            }
            return true;
        }
        return false;
    }

    // 09-12-2016: Dac: update student profile intro
    public function updateStudentIntro(Request $request, $id)
    {
        $studentProfile = $this->findById($id);
        if (DB::transaction(function () use ($request, $studentProfile) {
            try {
                $studentProfile->intro = $request['intro'];
                $studentProfile->save();
                return true;
            } catch (\Exception $e) {
                Log::info('[UPDATE STUDENT PROFILE] BUG WHILE UPDATE STUDENT PROFILE');
                Log::info($e->getMessage());
                return false;
            }
        })
        )
            return $studentProfile;
        return false;
    }

    public function updateStudentWhenApplyProject($id, $gpa, $phone, $skypeid)
    {
        $studentProfile = $this->findById($id);
        if (DB::transaction(function () use ($studentProfile, $gpa, $phone, $skypeid) {
            try {
                $studentProfile->gpa = $gpa;
                $studentProfile->phone = $phone;
                $studentProfile->skype_id = $skypeid;
                $studentProfile->save();
                return true;
            } catch (\Exception $e) {
                Log::info('[STUDENT PROFILES REPOSITORY] BUG WHILE UPDATE STUDENT WHEN APPLY PROJECT');
                Log::info($e->getMessage());
                return false;
            }
        })
        )
            return $studentProfile;
        return false;
    }

    public function getMyRank($student_id)
    {
        try {
            // 22-12-2016: Dac: fix rating
            $student = $this->studentProfiles
                ->where('student_profile.id', '=', $student_id)
                ->get();
        } catch (Exception $exception) {
            Log::info('[STUDENT PROFILES REPOSITORY] BUG WHILE UPDATE STUDENT WHEN APPLY PROJECT');
            return false;
        }
        return $student;
    }

    public function searchStudentList($name, $universityName, $ratingFrom, $ratingTo)
    {
        try {
            // 22-12-2016: Dac: fix rating
            $students = $this->studentProfiles->orderBy('rating', 'desc')->where('full_name', 'like', '%' . $name . '%');
            if ($universityName != "") {
                $students = $students->where('university_name', 'like', '%' . $universityName . '%');
            }
            if ($ratingFrom != "") {
                $students = $students->where('rating', '>=', $ratingFrom);
            }
            if ($ratingTo != "") {
                $students = $students->where('rating', '<=', $ratingTo);
            }
        } catch (Exception $exception) {
            Log::info('[STUDENT PROFILES REPOSITORY] BUG WHILE UPDATE STUDENT WHEN APPLY PROJECT');
            return false;
        }
        $students = $students->get();
        foreach ($students as $student) {
            $student->avatar = UserController::getAvatarPath($student->id);
        }
        return $students;
    }

    public function insertStudentProfile($id, $name)
    {
        $studentProfile = new StudentProfile();
        $result = DB::transaction(function () use ($id, $name, $studentProfile) {
            try {
                $studentProfile->id = $id;
                $studentProfile->full_name = $name;
                $studentProfile->save();
                return true;
            } catch (\Exception $exception) {
                Log::info('[INSERT STUDENT PROFILE] BUG WHILE INSERT STUDENT PROFILE' . $exception);
                return false;
            }
        });
        return $result;
    }

    // update rating for student
    public function updateRating($rating, $id, $type)
    {
        $currentStudent = $this->findById($id);
        if (!$currentStudent) return false;
        ($type == GeneralConstant::LECTURER_ROLE || $type == GeneralConstant::AGENT_ROLE)
            ? $rating = $rating * GeneralConstant::VALUE_LECTURER_RATING
            : $rating = $rating & GeneralConstant::VALUE_COMPANY_RATING;

        $currentStudent->num_rate++;
        $currentStudent->total_rate += $rating;
        $currentStudent->rating = number_format($currentStudent->total_rate / $currentStudent->num_rate, 4);
        Log::info(json_encode($currentStudent));
        $result = DB::transaction(function () use ($currentStudent) {
            try {
                $currentStudent->save();
                return true;
            } catch (\Exception $exception) {
                Log::info('[UPDATE RATING STUDENT PROFILE] BUG WHILE UPDATE STUDENT PROFILE' . $exception);
                return false;
            }
        });
        return $result;
    }
}
