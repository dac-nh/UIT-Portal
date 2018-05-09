<?php
/**
 * Created by PhpStorm.
 * User: Dark Wolf
 * Date: 11/18/2016
 * Time: 11:12 AM
 */

namespace App\Repositories\Company;

interface CompanyInterface
{
    public function findById($id);

    public function searchCompanyList($name);
}