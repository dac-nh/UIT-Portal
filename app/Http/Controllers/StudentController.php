<?php
/**
 * Created by PhpStorm.
 * User: huyentran
 * Date: 11/11/2016
 * Time: 14:27
 */

namespace App\Http\Controllers;

use App\Libraries\GeneralConstant;
use App\Models\StudentProfile;
use App\Repositories\RatingStudent\RatingStudentInterface;
use App\Repositories\Project\ProjectInterface;
use App\Repositories\StudentProfiles\StudentProfilesInterface;
use App\Models\UserApplyProject;
use App\Repositories\University\UniversityInterface;
use App\Repositories\User\UserInterface;
use App\Repositories\UserJoinProject\JoinInterface;
use App\Repositories\CV\CVInterface;
use Auth;
use Illuminate\Http\Request;
use Log;
use Storage;

/**
 * @property StudentProfilesInterface studentProfiles
 * @property JoinInterface userJoinProject
 * @property ProjectInterface project
 * @property RatingStudentInterface ratingStudent
 * @property UniversityInterface university
 * @property UserInterface user
 * @property CVInterface cv
 */
class StudentController extends Controller
{
    /**
     * @param UserInterface $user
     * @param StudentProfilesInterface $studentProfiles
     * @param JoinInterface $userJoinProject
     * @param ProjectInterface $project
     * @param RatingStudentInterface $ratingStudent
     * @param UniversityInterface $university
     * @param CVInterface $cv
     */

    public function __construct(UserInterface $user,
                                StudentProfilesInterface $studentProfiles,
                                JoinInterface $userJoinProject,
                                ProjectInterface $project,
                                RatingStudentInterface $ratingStudent,
                                UniversityInterface $university,
                                CVInterface $cv)
    {
        $this->user = $user;
        $this->studentProfiles = $studentProfiles;
        $this->userJoinProject = $userJoinProject;
        $this->project = $project;
        $this->ratingStudent = $ratingStudent;
        $this->university = $university;
        $this->cv = $cv;
    }

    public function getListStudentView()
    {
        return view('list_student');
    }

    public function getListStudent(Request $request)
    {
        $id = $request['user_id'];
        $universityName = $request['university_name'];
        $ratingFrom = $request['rating_from'];
        $ratingTo = $request['rating_to'];
        $name = $request['name'];
        //if user want to get their rank
        if ($id != "") {
            $students = $this->studentProfiles->getMyRank($id);
            return response()->json($students);
        } else {
            $students = $this->studentProfiles->searchStudentList($name, $universityName, $ratingFrom, $ratingTo);
        }
        return response()->json($students);
    }

    public function getStudentInfo($id)
    {
        return;
    }

    public function getManageStudentView()
    {
        $student_profiles = StudentProfile::with('user')->find(Auth::user()->id);
        return view('student.manage_student')->with('student_profiles', $student_profiles);
    }

    public function getAppliedListByStudent(Request $request)
    {
        return UserApplyProject::with('project.companies')->where('student_id', $request->get('student_id'))->get();
    }



    /*
     * USER DETAIL
     */
// 09-12-2016: Dac:
    /**
     * GET STUDENT PROFILE
     * @param $id
     * @return UserController|\Illuminate\View\View
     */
    public function getStudentProfile($id)
    {
        /*
         * USER
         */
        $isCurrentUser = GeneralConstant::NOT_CURRENT_USER;
        if (Auth::check()) {
            $user = Auth::user();
            ($user->id == $id) ?
                $isCurrentUser = GeneralConstant::IS_CURRENT_USER : $user = $this->user->findById($id);

            // Current User
            $currentUser = Auth::user();
            if ($currentUser->university_id != null && !($currentUser->isCompany() || $currentUser->isSuperUser())) {
                $currentUniversity = $this->university->findById($currentUser->university_id);
                //$this->university->findByID($currentUser->university_id);
                $currentUser['university_name'] = $currentUniversity->name;
                $currentUser['url'] = $currentUniversity->url;
            }
            $currentUser['avatar_path'] = UserController::getAvatarPath($currentUser->id); // Get avatar path
        } else {
            $currentUser = null;
            $user = $this->user->findById($id);
        }
        /*
         * STUDENT PROFILE
         */
        $studentProfile = $this->studentProfiles->findById($id);
        // avatar path
        $studentProfile->avatar_path = UserController::getAvatarPath($id);
        $studentProfile->email = $user->email;

        /*
         * Project
         */
        $projectList = $this->userJoinProject->findByStudentId($id);
        $projectListCollect = collect($projectList); // get collect of project list
        // get list project id
        $projectIdList = $projectListCollect->unique('project_id')->pluck('project_id');
        $projectListCollect = $projectListCollect->groupBy('project_id'); // group by project id
        if (count($projectIdList) > 0) {
            $projectList = $this->project->findListProjectById($projectIdList);
        }
        $projects = array();
        // get comment number
        foreach ($projectList as $project) {
            $project->comment_number = count($projectListCollect[$project->id]);
            array_push($projects, $project); // add to array main
        }

        /*
         * COMPANY
         */
        $ratingStudentCompanyList = $this->ratingStudent->findListProjectCompanyByStudentId($id);
        $ratingStudentCompanyCollect = collect($ratingStudentCompanyList);
        $companies = [];
        foreach ($ratingStudentCompanyCollect as $ratingStudent) {
            array_push($companies, $ratingStudent);
        }
        /*
         * LECTURER
         */
        $ratingStudentList = $this->ratingStudent->findListLecturerByStudentId($id);
        $ratingStudentCollect = collect($ratingStudentList); // get lecturer rate student as collect
        $lecturers = [];
        foreach ($ratingStudentCollect as $ratingStudent) {
            $ratingStudent->avatar_path = UserController::getAvatarPath($ratingStudent->id);
            array_push($lecturers, $ratingStudent);
        }
        //CV list
        $cvs = $this->cv->findBy('student_id', $user->id);
        return view('user_detail')
            ->with('is_current_user', $isCurrentUser)
            ->with('student_profile', $studentProfile)
            //->with('projects', $projects)
            ->with('cvs', $cvs)
            ->with('companies', $companies)
            ->with('lecturers', $lecturers)
            ->with('current_user', $currentUser)
            ->with('current_user_id', $id);
    }

    // comment to student profile
    public function postCommentUserDetail($id)
    {
        $message = ['message_warning' => "Bạn bình luận không thành công"];
        if (!$student = $this->studentProfiles->findById($id)) {
            $message['message_warning'] = "Sinh viên này không tồn tại";
            return redirect()->route('home')->with($message);
        };
        $lecturer = Auth::user();
        $body = $_POST['body'];
        $rating = $_POST['rating'];
        $ratingStudent = $this->ratingStudent->insertRatingStudent($body, $rating, $lecturer->id, $student->id, GeneralConstant::LECTURER_ROLE);
        if (!($ratingStudent)) {
            Log::info('[postCommentUserDetail] Catch Exception: ' . $ratingStudent);
            return $message;
        }

        $message = ['message_success' => "Bạn đã bình luận thành công"];
        return redirect()->back()->with($message);
    }
    // update student profile
    /**
     * @param Request $request
     * @param $id
     * @return int
     */
    public function postUpdateStudentProfile(Request $request, $id)
    {
        $result = GeneralConstant::RESULT_FALSE;
        $currentUser = Auth::user();

        if ($currentUser->id != $id) {
            Log::info('[Update Student Profile] Not loggin but want to update user');
            return $result;
        }
        if (!$student = $this->studentProfiles->findById($id)) {
            $result = GeneralConstant::NOT_EXISTED;
            return $result;
        };
        // update student profile
        $this->studentProfiles->updateStudentProfile($request, $id);
        // update user
        $currentUser->name = $_REQUEST['name'];
        $currentUser->save();

        $result = GeneralConstant::RESULT_SUCCESS;
        return $result;
    }

    public function postUpdateIntro(Request $request, $id)
    {
        $result = GeneralConstant::RESULT_FALSE;
        $currentUser = Auth::user();

        if ($currentUser->id != $id) {
            $result = GeneralConstant::NOT_LOGGED_IN;
            Log::info('[Update Student Profile] Not loggin but want to update user');
            return $result;
        }
        if (!$student = $this->studentProfiles->findById($id)) {
            $result = GeneralConstant::NOT_EXISTED;
            return $result;
        };
        // update intro of student
        if (!$this->studentProfiles->updateStudentIntro($request, $id)) {
            return $result;
        };

        $result = GeneralConstant::RESULT_SUCCESS;
        return $result;
    }
}