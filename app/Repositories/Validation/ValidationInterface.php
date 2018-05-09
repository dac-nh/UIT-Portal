<?php

namespace App\Repositories\Validation;

interface ValidationInterface
{
    public function validateStudentInfoWhenApplyProject($request);

    public function validateEmailWhenNominateStudent($request);

    public function validateSignUpUser($request);

    public function validateSignIn($request);
}