<?php
namespace App\Repositories\UserApplyProject;

use App\Libraries\GeneralConstant;
use App\Repositories\Project\ProjectInterface;
use App\Models\UserApplyProject;
use App\Models\Project;
use DB;
use League\Flysystem\Exception;
use Log;


class UserApplyProjectRepository implements UserApplyProjectInterface
{
    public $userApplyProject, $project;

    /**
     * UserApplyProjectRepository constructor.
     * @param UserApplyProject $apply
     * @param ProjectInterface $project
     */
    function __construct(UserApplyProject $apply, ProjectInterface $project)
    {
        $this->userApplyProject = $apply;
        $this->project = $project;
    }

    public function findById($id)
    {
        try {
            $apply = $this->userApplyProject->find($id);
        } catch (Exception $exception) {
            Log::info('[APPLYPROJECTS REPOSITORY] BUG WHILE QUERY FIND BY ID');
            return false;
        }
        return $apply;
    }

    public function findBy($projectId, $studentId)
    {
        try {
            $apply = $this->userApplyProject->where('project_id', $projectId)
                ->where('student_id', $studentId)
                ->first();
        } catch (Exception $exception) {
            Log::info('[APPLYPROJECTS REPOSITORY] BUG WHILE QUERY FIND BY ID');
            return false;
        }
        return $apply;
    }

    public function findByProjectId($id)
    {
        try {
            $apply = $this->userApplyProject->where('project_id', $id)->where('result',10)->get();
        } catch (Exception $exception) {
            Log::info('[APPLYPROJECTS REPOSITORY] BUG WHILE QUERY FIND BY ID');
            return false;
        }
        return $apply;
    }

    public function insertOrUpdateApply($projectId, $studentId, $studentName, $rating, $cvID)
    {
        $application = $this->findBy($projectId, $studentId);

        if ($application != null) {
            try {
                DB::transaction(function () use ($application){
                    $application->result = 10;
                    $application->save();
                });
                $this->project->plusNumOfApplied($projectId);
            } catch (\Exception $e) {
                Log::info('[APPLYPROJECTS REPOSITORY] UPDATE APPLY');
                return false;
            }
        } else {
            // insert this application to user_apply_project
            try {
                $this->insertApply($projectId, $studentId, $studentName, $rating, $cvID);
            } catch (\Exception $e) {
                Log::info('[APPLYPROJECTS REPOSITORY] INSERT APPLY');
                return false;
            }
        }
        DB::commit();
        return true;
    }

    public function insertApply($project_id, $student_id, $student_name, $rating, $cv_id)
    {
        $apply = new UserApplyProject();
        DB::transaction(function() use ($project_id, $student_id, $student_name, $rating, $cv_id,$apply){
            try{
                $apply->project_id = $project_id;
                $apply->student_id = $student_id;
                $apply->student_name = $student_name;
                $apply->student_rating = $rating;
                $apply->result = GeneralConstant::WAITING_COMPANY;
                $apply->cv_id = $cv_id;
                $apply->save();

                $this->project->plusNumOfApplied($project_id);
            }
            catch (\Exception $e){
                Log::info('[APPLYPROJECTS REPOSITORY] BUG WHILE INSERT APPLY');
                Log::info($e->getMessage());
                return false;
            }
        });
        return $apply;
    }

    public function cancelApplyProjects($id)
    {
        $apply = $this->userApplyProject->find($id);
        $project = $this->project->findById($apply->project_id);
        try {
            DB::transaction(function () use ($apply,$project){
                $apply->result = GeneralConstant::CANCELED;
                $apply->save();

                $project->num_of_applied -= 1;
                $project->save();
            });
        } catch (Exception $exception) {
            Log::info('[APPLYPROJECTS REPOSITORY] BUG WHILE DELETE APPLY PROJECT BY ID');
            return false;
        }
        return true;
    }

    public function updateApplyWhenConfirmProject($projectid, $studentid)
    {
        $apply = $this->userApplyProject->where('student_id', $studentid)->where('project_id', $projectid)->first();
        $project = $this->project->findById($projectid);
        try {
            DB::transaction(function () use ($apply,$project){
                $apply->result = GeneralConstant::JOINED;
                $apply->save();

                $project->num_of_applied += 1;
                $project->save();
            });
        } catch (Exception $exception) {
            Log::info('[STUDENT PROFILES REPOSITORY] BUG WHILE UPDATE STUDENT WHEN CONFIRM PROJECT');
            return false;
        }
        return true;
    }

    public function selectAppliedStudentList($projectid)
    {
        try {
            $applylist = $this->userApplyProject->where('project_id', $projectid)
                ->join('student_profile', 'user_apply_project.student_id', '=', 'student_profile.id')
                ->select('student_profile.*')->get();
        } catch (Exception $exception) {
            Log::info('[APPLYPROJECTS REPOSITORY] BUG WHILE SELECT APPLY LISY BY PROJECT ID');
            return false;
        }
        return $applylist;
    }

    public function selectUserResult($student_id, $project_id)
    {
        try {
            $result = $this->userApplyProject->where('student_id', $student_id)
                ->where('project_id', $project_id)
                ->value('result');
        } catch (Exception $exception) {
            Log::info('[APPLYPROJECTS REPOSITORY] BUG WHILE SELECT APPLY LISY BY PROJECT ID');
            return false;
        }
        return $result;
    }

    public function getAppliedListHiringProjectAPI($project_id)
    {
        try {
            $result = $this->userApplyProject->with('studentprofile')
                ->where('project_id', $project_id);
        } catch (Exception $exception) {
            Log::info('[APPLYPROJECTS REPOSITORY] BUG WHILE SELECT APPLY LISY BY PROJECT ID');
            return false;
        }
        return $result;
    }
}
