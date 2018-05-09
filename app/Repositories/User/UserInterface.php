<?php
/**
 * Created by PhpStorm.
 * User: Dark Wolf
 * Date: 10/25/2016
 * Time: 11:11 AM
 */
namespace App\Repositories\User;

use Illuminate\Http\Request;

interface UserInterface
{
    public function deactivateById($id);

    public function getAll();

    public function findById($id);

    public function findUserBy($field, $name);

    public function findUserByEmail($email);

    public function findUserByGoogleId($googleId);

    public function findUserByCompanyId($company_id);

    public function registerUser($name, $email, $password, $googleId);

    public function createGoogleClient($guzzleClient, $path);

    public function loginGoogle(Request $request, $client);

    public function userLogin(Request $request);
}