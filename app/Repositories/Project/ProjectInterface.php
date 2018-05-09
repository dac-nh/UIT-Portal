<?php

namespace App\Repositories\Project;

interface ProjectInterface
{
    public function findById($id);

    public function findProjectByUniversityId($uni_id);

    public function whereBy($field, $value);

    public function plusNumOfApplied($project_id);

    // 25-11-2016: Dac: find list project by id
    public function findListProjectById($value);

    public function findProjectInProgress();

    public function findProjectFinished();

    public function createProject($data);
}