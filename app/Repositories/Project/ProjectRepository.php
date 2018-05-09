<?php
namespace App\Repositories\Project;

use App\Libraries\GeneralConstant;
use App\Models\Project;
use App\Models\ProjectSkill;
use DB;
use League\Flysystem\Exception;
use Log;

class ProjectRepository implements ProjectInterface
{
    public $project;

    function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function findById($id)
    {
        try {
            $project = $this->project->find($id);
        } catch (Exception $exception) {
            Log::info('[PROJECT REPOSITORY] BUG WHILE QUERY FIND BY ID');
            return false;
        }
        return $project;
    }

    public function findProjectByUniversityId($uni_id)
    {
        try {
            $project = $this->project->where('university_id', $uni_id)
                ->join('project', 'project_university.project_id', '=', 'project.id')
                ->select('project.*')
                ->get();
        } catch (Exception $exception) {
            Log::info('[PROJECT REPOSITORY] BUG WHILE QUERY FIND BY University ID');
            return false;
        }
        return $project;
    }

    public function whereBy($field, $value)
    {
        try {
            $project = $this->project->where($field, $value);
        } catch (Exception $exception) {
            Log::info('[PROJECT REPOSITORY] BUG WHILE QUERY FIND BY FIELD and VALUE');
            return false;
        }
        return $project;
    }

    public function plusNumOfApplied($project_id)
    {
        $project = $this->project->find($project_id);
        DB::transaction(function() use ($project){
            try{
                $project->num_of_applied +=1;
                $project->save();
            }
            catch (\Exception $e){
                Log::info('[APPLYPROJECTS REPOSITORY] BUG WHILE INSERT APPLY');
                Log::info($e->getMessage());
                return false;
            }
        });
        return $project;
    }

    // 25-11-2016: Dac: find list project by id
    public function findListProjectById($value)
    {
        try {
            $projectList = $this->project->whereIn('id', $value)->get();
        } catch (Exception $exception) {
            Log::info('[PROJECT REPOSITORY] BUG WHILE QUERY FIND BY ID');
            return false;
        }
        return $projectList;
    }

    public function findProjectInProgress()
    {
        //Project::with('company')->where('status',GeneralConstant::PROJECT_IN_PROGRESS)->get();
        try {
            $project = $this->project->with('company')->where('status', GeneralConstant::PROJECT_IN_PROGRESS)->get();
        } catch (Exception $exception) {
            Log::info('[PROJECT REPOSITORY] BUG WHILE QUERY FIND PROJECT IN PROGRESS');
            return false;
        }
        return $project;
    }

    public function findProjectFinished()
    {
        //Project::with('company')->where('status',GeneralConstant::PROJECT_FINISHED)->get();
        try {
            $project = $this->project->with('company')->where('status', GeneralConstant::PROJECT_FINISHED)->get();
        } catch (Exception $exception) {
            Log::info('[PROJECT REPOSITORY] BUG WHILE QUERY FIND PROJECT IN PROGRESS');
            return false;
        }
        return $project;
    }

    public function createProject($data){
        try {
            //Insert new Project
            $project = new Project();
            $project->name = $data['name'];
            $project->company_id = $data['company_id'];
            $project->is_fulltime = $data['is_fulltime'];
            $project->status = $data['status'];
            $project->address = $data['address'];
            $project->length = $data['length'];
            $project->need_min = $data['need_min'];
            $project->need_max = $data['need_max'];
            $project->intro = $data['intro'];
            $project->requirement = $data['requirement'];
            $project->plus_point = $data['plus_point'];
            //$project->extra_file = $data['extra_file'];
            $project->num_of_applied = 0;
            $project->num_of_joined = 0;
            $project->start_date = $data['start_date'];
            $project->publish_date = -1;
            $project->contact_email = $data['contact_email'];
            $project->created_by_agent_id = $data['created_by_agent_id'];
            $project->intro = $data['intro'];
            $project->save();

            //Insert Project-skill
            for($i = 0;$i < count($data['skill']);$i++){
                $project_skill = new ProjectSkill();
                $project_skill->skill_id = $data['skill'][$i]['id'];
                $project_skill->project_id = $project->id;
                $project_skill->save();
            }
        } catch (Exception $exception) {
            Log::info('[PROJECT REPOSITORY] BUG WHILE CREATING PROJECT');
            return false;
        }
        return $project;
    }
}
