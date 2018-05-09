<?php
/**
 * Created by PhpStorm.
 * User: Dark Wolf
 * Date: 11/18/2016
 * Time: 11:16 AM
 */
namespace App\Repositories\CV;

use App\Libraries\GeneralConstant;
use App\Models\Cv;
use DB;
use League\Flysystem\Exception;
use Log;

class CVRepository implements CVInterface
{
    public $cv;

    function __construct(Cv $cv)
    {
        $this->cv = $cv;
    }

    public function findById($id)
    {
        try {
            $cv = $this->cv->find($id);
        } catch (Exception $exception) {
            Log::info('[CV REPOSITORY] BUG WHILE QUERY FIND BY ID');
            return false;
        }
        return $cv;
    }

    public function findBy($field, $value)
    {
        try {
            $cv = $this->cv->where($field, $value)->get();
        } catch (Exception $exception) {
            Log::info('[CV REPOSITORY] BUG WHILE QUERY FIND BY FIELD and VALUE');
            return false;
        }
        return $cv;
    }

    public function insert($student_id, $filename)
    {
        $cv = new Cv();
        DB::transaction(function() use ($cv,$filename,$student_id){
            try{
                $cv->student_id = $student_id;
                $cv->name = $filename;
                $cv->save();
            }
            catch (\Exception $e){
                Log::info('[CV REPOSITORY] BUG WHILE INSERT CV');
                Log::info($e->getMessage());
                return false;
            }
        });
        return true;
    }

    public function findMaxID(){
        try{
            $maxID = DB::table('INFORMATION_SCHEMA.TABLES')
                ->where('table_name', '=', 'cv')
                ->pluck('auto_increment');
                //->first();
            $maxID = $maxID[0];
            Log::info($maxID[0]);
        }catch (Exception $exception){
            Log::info('[CV REPOSITORY] Can not get max ID');
            return false;
        }
        return $maxID;
    }

    public function deleteCV($id){
        $cv = $this->cv->find($id);
        DB::transaction(function() use ($cv){
            try{
                $cv->delete();
            }
            catch (\Exception $e){
                Log::info('[CV REPOSITORY] BUG WHILE DELET CV');
                Log::info($e->getMessage());
                return false;
            }
        });
        return true;
    }

    public function editName($id,$newName){
        $cv = $this->cv->find($id);
        DB::transaction(function() use ($cv,$newName){
            try{
                $cv->name = $newName;
                $cv->save();
            }
            catch (\Exception $e){
                Log::info('[CV REPOSITORY] BUG WHILE EDIT CV');
                Log::info($e->getMessage());
                return false;
            }
        });
        return $cv;
//        try{
//            $cv = $this->cv->find($id);
//            $cv->name =$newName;
//            $cv->save();
//            DB::table('cv')
//                ->where('id', $id)
//                ->update(['name' => $newName]);
//            DB::commit();
//        }catch (Exception $exception){
//            Log::info('[CV REPOSITORY] Can not update cv in database');
//            DB::rollBack();
//            return false;
//        }
//        return true;
    }
}
