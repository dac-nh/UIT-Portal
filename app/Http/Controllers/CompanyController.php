<?php

namespace App\Http\Controllers;

use App\Libraries\GeneralConstant;
use App\Models\Project;
use App\Repositories\UserApplyProject\UserApplyProjectInterface as UserApplyProjectInterface;
use App\Repositories\User\UserInterface as UserInterface;
use App\Repositories\Project\ProjectInterface as ProjectInterface;
use App\Repositories\Company\CompanyInterface as CompanyInterface;
use Illuminate\Support\Facades\Storage;
use Auth;
use Illuminate\Http\Request;

/**
 * @property UserApplyProjectInterface userApplyProject
 * @property UserInterface user
 * @property ProjectInterface project
 * @property CompanyInterface company
 */
class CompanyController extends Controller
{
    /**
     * CompanyController constructor.
     * @param UserApplyProjectInterface $userApplyProject
     * @param UserInterface $user
     * @param ProjectInterface $project
     * @param CompanyInterface $company
     */
    public function __construct(UserApplyProjectInterface $userApplyProject,UserInterface $user,ProjectInterface $project,CompanyInterface $company)
    {
        $this->userApplyProject = $userApplyProject;
        $this->user = $user;
        $this->project = $project;
        $this->company = $company;
    }

    public function getListCompanyView(){
        return view('list_company');
    }

    public function postListCompany(Request $request){
        $name = $request['name'];
        $companies = $this->company->searchCompanyList($name);
        return $companies;
    }

    public function getCompanyManagement()
    {
        $companyId = Auth::user()->company_id;
        $company = $this->company->findById($companyId);
        $companyLogo = Storage::url('company/logo/' . $companyId . '.png');
        return view('company/manage_company')
            ->with('company_logo', $companyLogo)
            ->with('company', $company);
    }

    //Project $id ?
    public function getProjectHiring(Project $id)
    {
        return view('company.manage_projects_hiring')->with('project', $id);
    }

    public function getAppliedListHiringProjectAPI(Request $request)
    {
        $projectId = $request->get('project_id');
        $query = $this->userApplyProject->getAppliedListHiringProjectAPI($projectId);
        $status = $request->get('status');
        switch ($status) {
            case 2:
                $query->where('result', GeneralConstant::WAITING_COMPANY);
                break;
            case 3:
                $query->where('result', '!=', GeneralConstant::WAITING_COMPANY);
                break;
        }
        return $query->get();
    }

    public function confirmJoinAPI(Request $request)
    {
        if($request->has('email_content')){
            $rejectMessage = $request->get('email_content');
        }
        else{
            $rejectMessage = "";
        }
        
        $applyId = $request->get('apply_id');
        $apply = $this->userApplyProject->findById($applyId);


        $apply->result = GeneralConstant::NEED_CONFIRM;
        $apply->save();

        $user = $this->user->findById($apply->student_id);
        $project = $this->project->findById($apply->project_id);
        $company = $this->company->findById($project->company_id);

        //send email
        try {
            EmailController::sendEmailApprovedToStudent($request, $user, $company, $project, [
                'reject_message'=>$rejectMessage,
            ]);
        } catch (Exception $e) {
            \Log::info('ERROR: Cannot send mail to user', $e);
            return response()->json([
                'message' => 'SERVER ERROR! PLEASE COME BACK LATER!'
            ], 500);
        }
        //thêm bảng join
    }

    public function rejectApplyAPI(Request $request)
    {
        if($request->has('email_content')){
            $rejectMessage = $request->get('email_content');
        }
        else{
            $rejectMessage = "";
        }
        $applyId = $request->get('apply_id');
        $apply = $this->userApplyProject->findById($applyId);
        $apply->result = GeneralConstant::FAIL;
        $apply->save();

        //send email
        $user = $this->user->findById($apply->student_id);
        $project = $this->project->findById($apply->project_id);
        $company = $this->company->findById($project->company_id);
        try {
            EmailController::sendEmailRejectToStudent($request, $user, $company, $project, [
                'reject_message'=>$rejectMessage,
            ]);
        } catch (Exception $e) {
            \Log::info('ERROR: Cannot send mail to user', $e);
            return response()->json([
                'message' => 'SERVER ERROR! PLEASE COME BACK LATER!'
            ], 500);
        }
    }
}
