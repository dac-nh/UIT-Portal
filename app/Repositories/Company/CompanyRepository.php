<?php
/**
 * Created by PhpStorm.
 * User: Dark Wolf
 * Date: 11/18/2016
 * Time: 11:16 AM
 */
namespace App\Repositories\Company;

use App\Http\Controllers\UserController;
use App\Models\Company;
use League\Flysystem\Exception;
use Log;

class CompanyRepository implements CompanyInterface
{
    public $company;

    function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function findById($id)
    {
        try {
            $company = $this->company->find($id);
        } catch (Exception $exception) {
            Log::info('[COMPANY REPOSITORY] BUG WHILE QUERY FIND BY ID');
            return false;
        }
        return $company;
    }

    public function searchCompanyList($name)
    {
        try {
            $companies = $this->company->where('name', 'like', '%' . $name . '%')->get();
        } catch (Exception $exception) {
            Log::info('[STUDENT PROFILES REPOSITORY] BUG WHILE UPDATE STUDENT WHEN APPLY PROJECT');
            return false;
        }
        foreach ($companies as $company) {
            $company->avatar = UserController::getAvatarPath($company->id);
        }
        return $companies;
    }
}
