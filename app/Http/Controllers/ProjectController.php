<?php
/**
 * Created by PhpStorm.
 * User: huyentran
 * Date: 04/11/2016
 * Time: 12:53
 */

namespace App\Http\Controllers;

use App\Repositories\Project\ProjectInterface as ProjectInterface;
use App\Repositories\StudentProfiles\StudentProfilesInterface as StudentProfilesInterface;
use App\Repositories\UserApplyProject\UserApplyProjectInterface as UserApplyProjectInterface;
use App\Repositories\CV\CVInterface as CVInterface;
use App\Repositories\User\UserInterface as UserInterface;
use App\Repositories\Company\CompanyInterface as CompanyInterface;
use App\Repositories\UserJoinProject\JoinInterface as JoinInterface;
use App\Repositories\Validation\ValidationInterface as ValidationInterface;
use App\Libraries\GeneralConstant;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Log;
use Validator;
use League\Flysystem\Exception;
/**
 * @property ProjectInterface project
 * @property UserApplyProjectInterface apply
 * @property StudentProfilesInterface studentProfiles
 * @property CVInterface cv
 * @property CompanyInterface company
 * @property UserInterface user
 * @property JoinInterface join
 * @property ValidationInterface validation
 */
class ProjectController extends Controller
{
    /**
     * ProjectController constructor.
     * @param ProjectInterface $project
     * @param UserApplyProjectInterface $apply
     * @param StudentProfilesInterface $studentProfiles
     * @param CVInterface $CV
     * @param CompanyInterface $company
     * @param UserInterface $user
     * @param JoinInterface $join
     * @param ValidationInterface $validation
     */
    public function __construct(ProjectInterface $project, UserApplyProjectInterface $apply, StudentProfilesInterface $studentProfiles,
                                CVInterface $CV, CompanyInterface $company, UserInterface $user, JoinInterface $join, ValidationInterface $validation)
    {
        $this->project = $project;
        $this->apply = $apply;
        $this->studentProfiles = $studentProfiles;
        $this->cv = $CV;
        $this->company = $company;
        $this->user = $user;
        $this->join = $join;
        $this->validation = $validation;
    }

    public function getProjectListAPI(Request $request)
    {
        $projects = $this->project->findProjectByUniversityId($request->user()->university_id);
        return response()->json([
            'projects' => $projects,
        ]);
    }

    public function getProjectDetail(Request $request, $project_id)
    {
        $project = $this->project->findById($project_id);
        $companyLogo = Storage::url('company/logo/' . $project->company_id . '.png');
        if (Auth::guest()) {
            return view('project_detail')->with([
                'project' => $project,
                'company_logo' => $companyLogo
            ]);
        }

        $appliedStudents = $this->apply->findByProjectId($project_id);
        $currentUser = $request->user();
        if ($currentUser->isStudent()) {
            if (!is_null($appliedStudents)) {
                $userResult = $appliedStudents->where('student_id', $request->user()->id)->first();
                if (!is_null($userResult)) {
                    $userResult = $userResult->result;
                    if (!is_null($userResult)) {
                        return view('project_detail')->with([
                            'project' => $project,
                            'company_logo' => $companyLogo,
                            'applied_students' => $appliedStudents,
                            'result' => $userResult
                        ]);
                    }
                }
            }
        }

        return view('project_detail')->with([
            'project' => $project,
            'applied_students' => $appliedStudents,
            'company_logo' => $companyLogo,
        ]);
    }

    public function postAppliedStudentListAPI(Request $request)
    {
        $appliedList = $this->apply->selectAppliedStudentList($request['project_id']);
        return $appliedList;
    }

    public function getApplyProject(Request $request, $project_id)
    {
        //check if user isn't a student
        if (!$request->user()->isStudent())
            return response()->json([
                'message' => 'Only for Student'
            ], 403);
        $currentResult = $this->apply->findBy($project_id, $request->user()->id);

        if (!is_null($currentResult)) {
            $currentResult = $currentResult->result;
            if ($currentResult != 14) {
                return redirect()->back();
            }
        }
        //get student profile with user id
        $profile = $this->studentProfiles->findById($request->user()->id);
        $email = $request->user()->email;
        $rating = $request->user()->rating;
        $cvs = $this->cv->findBy('student_id', $request->user()->id);
        return view('register_project')->with([
            'profile' => $profile,
            'project_id' => $project_id,
            'email' => $email,
            'cvs' => $cvs,
            'rating' => $rating]);
    }

    public function postApplyProject_saveFile(Request $request, $project_id, $student_id)
    {
        //save file gpa detail in /public/storage/GPA_Detail
        if ($request->hasFile('gpadetail')) {
            $validator = Validator::make($request->all(), [
                'gpadetail' => 'required|mimes:pdf'
            ]);
            if ($validator->failed()) {
                return redirect()->back()->with(['message_danger' => 'Định dạng file không hợp lệ']);
            }
            $file = $request->file('gpadetail');
            //$file->move('app/storage/GPA_Detail', 'student_'.$student_id.'-'.'project_'.$project_id.'.pdf');
            Storage::put('/public/GPA_Detail/' . 'student_' . $student_id . '-' . 'project_' . $project_id . '.pdf', file_get_contents($file->getRealPath()));
            return GeneralConstant::RESULT_SUCCESS;
        } else
            return GeneralConstant::RESULT_FALSE;
    }

    public function postApplyProject(Request $request, $projectId)
    {
        //validation
        if (!$this->validation->validateStudentInfoWhenApplyProject($request)) {
            Log::info("Validate fails in controller");
            return GeneralConstant::RESULT_FALSE;
        }
        $currentUser = $request->user();
        if (!$currentUser->isStudent())
            return response()->json([
                'message' => 'Only for Student'
            ], 403);
        try {
            $studentId = $currentUser->id;
            $studentProfiles = $this->studentProfiles->findById($studentId);
            $studentName = $studentProfiles->full_name;
            $rating = $currentUser->rating;
            $cvID = $request['cv_id'];

            if ($request['wantUpdate'] == 1) {
                $this->studentProfiles->updateStudentWhenApplyProject($studentId, $request['gpa'], $request['phone'], $request['skypeid']);
            }
//          Update student profiles or insert this application to user_apply_project
            if (!$this->apply->insertOrUpdateApply($projectId, $studentId, $studentName, $rating, $cvID)) {
                \Log::info('ERROR: postApplyProject: Can not Update student profiles or insert this application to user_apply_project');
                return GeneralConstant::RESULT_FALSE;
            }
            //send mail
            $this->sendEmailToCompanyWhenStudentApplyProject($request, $cvID, $studentProfiles, $projectId);
        } catch (Exception $e) {
            \Log::info('ERROR: apply project', $e);
            return GeneralConstant::RESULT_FALSE;
        }
        return GeneralConstant::RESULT_SUCCESS;
    }

    public function sendEmailToCompanyWhenStudentApplyProject(Request $request, $cvID, $studentProfiles, $projectId)
    {
        //send mail
        $company = $this->project->findById($projectId);
        $companyUser = $this->user->findUserByCompanyId($company->company_id);
        if (is_null($companyUser)) {
            \Log::info('ERROR: Cannot send find company user');
            return response()->json([
                'message' => 'CAN NOT FIND COMPANY USER, PLEASE CHECK COMPANY USER OF THIS PROJECT'
            ], 500);
        }
        $project = $this->project->findById($projectId);

        try {
            if (EmailController::sendEmailToCompanyWhenStudentApply($request, $cvID, $studentProfiles, $companyUser, $project, [
                'full_name' => 'Họ tên: ' . $request['full_name'],
                'phone' => 'Số điện thoại: ' . $request['phone'],
                'email' => 'Email liên hệ: ' . $request['email'],
                'university_name' => 'Trường: ' . $request['university_name'],
                'faculty_name' => 'Khoa: ' . $request['faculty_name'] . ' - ' . 'GPA: ' . $request['gpa'],
                'major_name' => 'Ngành: ' . $request['major_name'] . ' - ' . 'Khóa: ' . $request['academic_year'],
                'intro' => $request['intro']
            ])
            )
                return GeneralConstant::RESULT_SUCCESS;
            return GeneralConstant::RESULT_FALSE;

        } catch (Exception $e) {
            \Log::info('ERROR: Cannot send mail to company', $e);
            return response()->json([
                'message' => 'SERVER ERROR! PLEASE COME BACK LATER!'
            ], 500);
        }
    }

    public function postNominateStudent(Request $request, $project_id)
    {
        $this->validation->validateEmailWhenNominateStudent($request);
        $currentUser = $request->user();
        if (!$currentUser->isLecture())
            return response()->json([
                'message' => 'Only for Lecturer'
            ], 403);

        $project = $this->project->findById($project_id);
        $message = ['message_info' => 'Đã gửi email thành công!'];
        if (strpos($request['email'], ',') !== false) {
            $emailArray = explode(',', $request['email']);
            try {
                if (EmailController::sendEmailNominateToStudent($request, $emailArray, $currentUser, $project, [$request['message']]))
                    return redirect()->back()->with($message);
                $message = ['message_danger' => 'Không thể gửi email! Vui lòng kiểm tra lại email đã điền.'];
                return redirect()->back()->with($message);
            } catch (Exception $e) {
                \Log::info('ERROR: Cannot send mail to student', $e);
                return response()->json([
                    'message' => 'SERVER ERROR! PLEASE COME BACK LATER!'
                ], 500);
            }
        } else {
            $email = $request['email'];
            try {
                if (EmailController::sendEmailNominateToStudent($request, $email, $currentUser, $project, [$request['message']]))
                    return redirect()->back()->with($message);
                $message = ['message_info' => 'Không thể gửi email! Vui lòng kiểm tra lại email đã điền.'];
                return redirect()->back()->with($message);
            } catch (Exception $e) {
                \Log::info('ERROR: Cannot send mail to student', $e);
                return response()->json([
                    'message' => 'SERVER ERROR! PLEASE COME BACK LATER!'
                ], 500);
            }
        }
    }

    public function getHiringProjectsView()
    {
        return view('hiring_projects');
    }

    public function getHiringProjectsListAPI(Request $request)
    {
        $hiringProjects = $this->project->whereBy('status', GeneralConstant::PROJECT_HIRING);
        $companyId = $request->get('company_id');
        if ($companyId != "") {
            $hiringProjects = $hiringProjects->where('company_id', $companyId);
        }
        $projectName = $request->get('project_name');
        if ($projectName != "") {
            $hiringProjects = $hiringProjects->where('name', 'LIKE', "%$projectName%");
        }
        $fromDate = $request->get('from_date');
        if ($fromDate != "") {
            $hiringProjects = $hiringProjects->where('start_date', '>=', $fromDate);
        }
        $typeId = $request->get('type_id');
        if ($typeId != "") {
            $hiringProjects = $hiringProjects->where('is_fulltime', $typeId);
        }
        $lengthId = $request->get('length_id');
        if ($lengthId != "") {
            switch ($lengthId) {
                case 0:
                    $hiringProjects = $hiringProjects->where('length', '<', '12');
                    break;
                case 1:
                    $hiringProjects = $hiringProjects->where('length', '>', '12');
                    $hiringProjects = $hiringProjects->where('length', '<=', '24');
                    break;
                case 2:
                    $hiringProjects = $hiringProjects->where('length', '>', '24');
                    break;
            }
        }
        return $hiringProjects->get();
    }

    public function getInProgressProjectsListAPI()
    {
        $hiringProjects = $this->project->findProjectInProgress();
        return $hiringProjects;
    }

    public function getFinishedProjectsListAPI()
    {
        $hiringProjects = $this->project->findProjectFinished();
        return $hiringProjects;
    }

    // cancel project
    public function postCancelRegister(Request $request, $project_id)
    {
        //check if current user is student
        if (!$request->user()->isStudent())
            return GeneralConstant::RESULT_FALSE;

        $project = $this->project->findById($project_id);
        $appliedStudents = $this->apply->findByProjectId($project_id);

        if ($request['wantDelete'] == 1) {
            if (!is_null($appliedStudents)) {
                $userResult = $appliedStudents->where('student_id', $request->user()->id)->first();
                if (!is_null($userResult)) {
                    $id = $userResult->id;
                    if (!is_null($id)) {
                        //cancel application
                        if (!$this->apply->cancelApplyProjects($id)) {
                            \Log::info('ERROR: Cannot update apply when confirm project');
                            return GeneralConstant::CANTUPDATERESULT;
                        }
                    }
                }
            }
            return GeneralConstant::RESULT_SUCCESS;
        }
        return GeneralConstant::RESULT_FALSE;
    }

    // student confirm project
    public function postConfirmRegister(Request $request, $project_id)
    {
        //check if current user is student
        if (!$request->user()->isStudent())
            return GeneralConstant::RESULT_FALSE;
        $appliedStudents = $this->apply->findByProjectId($project_id);
        $currentUser = $request->user();
        $userResult = $this->apply->selectUserResult($request->user()->id, $project_id);

        if ($request['wantConfirm'] == 1) {
            if (!is_null($appliedStudents)) {
                if ($userResult != GeneralConstant::JOINED) {
//                        update result
                    if (!$this->apply->updateApplyWhenConfirmProject($project_id, $currentUser->id)) {
                        \Log::info('ERROR: Cannot update apply when confirm project');
                        return GeneralConstant::CANTUPDATERESULT;
                    }
                    //insert to Joins
                    $startAt = $this->project->whereBy('id', $project_id)->value('start_date');
                    if (!$this->join->insertToJoin($currentUser->id, $project_id, $startAt)) {
                        \Log::info('ERROR: Cannot insert Join when confirm project');
                        return GeneralConstant::CANTINSERT;
                    }
                }
            }
            return GeneralConstant::RESULT_SUCCESS;
        }
        return GeneralConstant::RESULT_FALSE;
    }
}
