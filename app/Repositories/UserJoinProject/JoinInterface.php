<?php
/**
 * Created by PhpStorm.
 * User: Dark Wolf
 * Date: 11/18/2016
 * Time: 1:19 PM
 */

namespace App\Repositories\UserJoinProject;

interface JoinInterface
{
    public function findByStudentId($studentId);

    public function findByProjectId($projectId);

    public function insertToJoin($student_id, $project_id, $start_at);
}