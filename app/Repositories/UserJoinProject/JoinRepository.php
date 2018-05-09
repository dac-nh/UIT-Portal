<?php
/**
 * Created by PhpStorm.
 * User: Dark Wolf
 * Date: 11/18/2016
 * Time: 1:20 PM
 */
namespace App\Repositories\UserJoinProject;

use App\Models\UserJoinProject;
use DB;
use Log;

class JoinRepository implements JoinInterface
{
    public $join;

    function __construct(UserJoinProject $join)
    {
        $this->join = $join;
    }

    public function findByStudentId($studentId)
    {
        return $this->join->where('student_id', $studentId)->get();
    }

    public function findByProjectId($projectId)
    {
        return $this->join->where('project_id', $projectId)->get();
    }

    public function insertToJoin($student_id, $project_id, $start_at)
    {
        $join = new UserJoinProject();
        DB::transaction(function() use ($student_id, $project_id, $start_at,$join){
            try{
                $join->project_id = $project_id;
                $join->student_id = $student_id;
                $join->start_at = $start_at;
                $join->body = "";
                $join->rating = 0;
                $join->has_extra_file = 0;
                $join->save();
            }
            catch (\Exception $e){
                Log::info('[USER JOIN PROJECT REPOSITORY] BUG WHILE INSERT TO USER JOIN PROJECT');
                Log::info($e->getMessage());
                return false;
            }
        });
        return true;
    }
}