<?php

namespace App\Repositories\UserApplyProject;

interface UserApplyProjectInterface
{
    public function findById($id);

    public function findBy($projectId, $studentId);

    public function findByProjectId($id);

    public function insertApply($project_id, $student_id, $student_name, $rating, $cv_id);

    public function cancelApplyProjects($id);

    public function updateApplyWhenConfirmProject($projectid, $studentid);

    public function selectAppliedStudentList($projectid);

    public function selectUserResult($student_id, $project_id);

    public function getAppliedListHiringProjectAPI($project_id);

    public function insertOrUpdateApply($projectId, $studentId, $studentName, $rating, $cvID);
}