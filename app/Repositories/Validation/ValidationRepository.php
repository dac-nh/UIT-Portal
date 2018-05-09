<?php
namespace App\Repositories\Validation;

use Log;
use Validator;

class ValidationRepository implements ValidationInterface
{
    public function validateStudentInfoWhenApplyProject($request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'birthday' => 'required|date|before:18 years ago',
            'address' => 'required',
            'skypeid' => 'required',
            'phone' => 'required|regex:/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/',
            'gpa' => 'required|numeric|between:1,10',
            'cv_id' => 'required',
            'email' => 'required|email',
            'university_name' => 'required',
            'faculty_name' => 'required',
            'major_name' => 'required',
            'academic_year' => 'required',
        ]);

        if ($validator->fails()) {
            Log::info('[postApplyProject]validate fails in Repository');
            return false;
        }
        return true;
    }

    public function validateEmailWhenNominateStudent($request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            Log::info('[validateEmailWhenNominateStudent]validate fails');
            return false;
        }
        return true;
//        $this->validate($request,[
//            'email' => 'required'
//        ]);
    }

    public function validateSignUpUser($request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:user',
            'name' => 'required|max:120',
            'password' => 'required|min:4'
        ]);

        if ($validator->fails()) {
            Log::info('[validateSignUpUser]validate fails');
            return false;
        }
        return true;

    }

    public function validateSignIn($request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            Log::info('[validateSignIn]validate fails');
            return false;
        }
        return true;
    }
}
