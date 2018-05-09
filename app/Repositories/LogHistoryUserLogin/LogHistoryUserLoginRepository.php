<?php
namespace App\Repositories\LogHistoryUserLogin;

use App\Libraries\GeneralConstant;
use App\Models\LogHistoryUserLogin;
use DB;
use League\Flysystem\Exception;
use Log;

class LogHistoryUserLoginRepository implements LogHistoryUserLoginInterface
{
    public $logHistoryUserLogin;

    function __construct(LogHistoryUserLogin $logHistoryUserLogin)
    {
        $this->logHistoryUserLogin = $logHistoryUserLogin;
        $this->logHistoryUserLogin->setConnection('mysql2');
    }

    public function findById($id)
    {
        try {
            $logHistoryUserLogin = $this->logHistoryUserLogin->find($id);
        } catch (Exception $exception) {
            Log::info('[$logHistoryUserLogin REPOSITORY] BUG WHILE QUERY FIND BY ID');
            return false;
        }
        return $logHistoryUserLogin;
    }

    public function saveLogHistoryUserLogin($userId)
    {
        $logHistoryUserLogin = new LogHistoryUserLogin();
        $logHistoryUserLogin->setConnection('mysql2');
        DB::transaction(function() use ($logHistoryUserLogin,$userId){
            try{
                $logHistoryUserLogin->user_id = $userId;
                $logHistoryUserLogin->save();
            }
            catch (\Exception $e){
                Log::info('[$logHistoryUserLogin REPOSITORY] BUG WHILE SAVE HISTORY USER LOGIN');
                Log::info($e->getMessage());
                return false;
            }
        });
        return $logHistoryUserLogin;
    }
}
