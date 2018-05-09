<?php

namespace App\Repositories\LogHistoryUserLogin;

interface LogHistoryUserLoginInterface
{
    public function findById($id);

    public function saveLogHistoryUserLogin($userId);
}