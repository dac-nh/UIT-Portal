<?php

namespace App\Http\Controllers;


use App\Libraries\GeneralConstant;
use Auth;
use File;
use Illuminate\Http\Request;
use App\Repositories\CV\CVInterface as CVInterface;
use Log;
use Monolog\Formatter\LogglyFormatter;
use Storage;
use Validator;


/**
 * @property CVInterface cv
 */
class CVController extends Controller
{
    /**
     * CVController constructor.
     * @param CVInterface $CV
     */
    public function __construct(CVInterface $CV)
    {
        $this->cv = $CV;
    }

    /**
     * @param $student_id
     * @return $this|bool
     */
    public function getListCVView($student_id){
        $numOfCV = 0;
        try{
            $cvs = $this->cv->findBy('student_id',$student_id);
            foreach ($cvs as $cv) {
                $cv->filePath_png = Storage::url('/CV/'.$student_id.'_'.$cv->id.'.png');
//                $cv->filePath_pdf = storage_path().'/app/public/CV_Pdf/'.$student_id.'_'.$cv->id.'.pdf' ;
                $numOfCV ++;
            }
        } catch(\Exception $exception){
            Log::info('[GetListCVVIew]'.$exception);
            return false;
        }
        return view('student.list_CV')->with(['cvs'=>$cvs, 'student_id'=>$student_id,'numOfCV'=>$numOfCV]);
    }

    public function getCVByStudent(Request $request){
        return $this->cv->findBy('student_id',$request->get('student_id'));
    }
    /**
     * @param Request $request
     * @param $student_id
     * @return int
     */
    public function postSaveCV(Request $request, $student_id)
    {
        if($request->hasFile('cvFile') ){
            Validator::make($request->all(), [
                'cvFile' => 'required|mimes:pdf'
            ]);

            $file = $request->file('cvFile');
            $pdf = $file;
            $cvMaxId = $this->cv->findMaxID();
            //$save =  Storage::url('public/CV/'.$student_id.'_'.$cvMaxId.'.png');
            //return $save;
            //save pdf version
            Storage::put('/public/CV_Pdf/'.$student_id.'_'.$cvMaxId.'.pdf', file_get_contents($file->getRealPath())[0]);
            //save png file
            $save =  Storage::url('public/CV/'.$student_id.'_'.$cvMaxId.'.png');
            exec('convert "'.$pdf.'" -colorspace RGB -resize 800 "'.$save.'"', $output, $return_var);
            //insert to CV
            $cv = $this->cv->insert($student_id,$request['cv_name']);
            if(!$cv){
                \Log::info('ERROR: postSaveCV: Can not insert cv');
                return GeneralConstant::RESULT_FALSE;
            }
            return GeneralConstant::RESULT_SUCCESS;
        }
        return GeneralConstant::RESULT_FALSE;
    }

    public function postDeleteCV(Request $request,$student_id){
        if(!isset($request['cvID'])){
            return GeneralConstant::RESULT_FALSE;
        }
//        delete in DB
        if(!$this->cv->deleteCV($request['cvID'])){
            return GeneralConstant::RESULT_FALSE;
        }
        //delete image
        File::delete(public_path().GeneralConstant::LINKSAVECV.$student_id.'_'.$request['cvID'].'.png');
        //delete pdf
        Storage::delete('/public/CV_Pdf/'.$student_id.'_'.$request['cvID'].'.pdf');
        return GeneralConstant::RESULT_SUCCESS;
    }

    public function postEditCV(Request $request){
        if(!isset($request['cvID']) or !isset($request['newName'])){
            return GeneralConstant::RESULT_FALSE;
        }
        //edit in DB
        Log::info($this->cv->editName($request['cvID'],$request['newName']));
        if($this->cv->editName($request['cvID'],$request['newName']))
            return GeneralConstant::RESULT_SUCCESS;
        return GeneralConstant::RESULT_FALSE;
    }
}
