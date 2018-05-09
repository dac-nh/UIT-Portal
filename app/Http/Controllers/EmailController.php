<?php

namespace App\Http\Controllers;

use App\Libraries\GeneralConstant;
use App\Models\Project;
use App\Models\StudentProfile;
use App\Models\UserApplyProject;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Exception;
use Log;

class EmailController extends Controller
{
    public static function style()
    {
        return [
            /* Layout ------------------------------ */

            'body' => 'margin: 0; padding: 0; width: 100%; background-color: #F2F4F6;',
            'email-wrapper' => 'width: 100%; margin: 0; padding: 0; background-color: #F2F4F6;',

            /* Masthead ----------------------- */

            'email-masthead' => 'padding: 25px 0; text-align: center;',
            'email-masthead_name' => 'font-size: 16px; font-weight: bold; color: #2F3133; text-decoration: none; text-shadow: 0 1px 0 white;',

            'email-body' => 'width: 100%; margin: 0; padding: 0; border-top: 1px solid #EDEFF2; border-bottom: 1px solid #EDEFF2; background-color: #FFF;',
            'email-body_inner' => 'width: auto; max-width: 570px; margin: 0 auto; padding: 0;',
            'email-body_cell' => 'padding: 35px;',

            'email-footer' => 'width: auto; max-width: 570px; margin: 0 auto; padding: 0; text-align: center;',
            'email-footer_cell' => 'color: #AEAEAE; padding: 35px; text-align: center;',

            /* Body ------------------------------ */

            'body_action' => 'width: 100%; margin: 30px auto; padding: 0; text-align: center;',
            'body_sub' => 'margin-top: 25px; padding-top: 25px; border-top: 1px solid #EDEFF2;',

            /* Type ------------------------------ */

            'anchor' => 'color: #3869D4;',
            'header-1' => 'margin-top: 0; color: #2F3133; font-size: 19px; font-weight: bold; text-align: left;',
            'paragraph' => 'margin-top: 0; color: #74787E; font-size: 16px; line-height: 1.5em;',
            'paragraph-sub' => 'margin-top: 0; color: #74787E; font-size: 12px; line-height: 1.5em;',
            'paragraph-center' => 'text-align: center;',

            /* Buttons ------------------------------ */

            'button' => 'display: block; display: inline-block; width: 200px; min-height: 20px; padding: 10px;
                 background-color: #3869D4; border-radius: 3px; color: #ffffff; font-size: 15px; line-height: 25px;
                 text-align: center; text-decoration: none; -webkit-text-size-adjust: none;',

            'button--green' => 'background-color: #22BC66;',
            'button--red' => 'background-color: #dc4d2f;',
            'button--blue' => 'background-color: #3869D4;',
        ];
    }

    public static function fontFamily(){
        return 'font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;';
    }
    /**
     * @param Request $request
     * @param User $user
     * @param $type
     * @return int
     */
    public static function sendEmailSignUp(Request $request,
                                           User $user,
                                           $type)
    {
        $result = GeneralConstant::RESULT_FALSE;
        // gender for message to send email
        $gender = ' bạn ';
        Log::info('[SEND EMAILS SIGN UP] BEFORE IF @type');
        $message = array();
        if ($type == GeneralConstant::LECTURER_ROLE) {
            ($user->isFemale()) ?
                $gender = " thầy " : $gender = ' cô ';
            // Text for button event
            $message += array('actionText' => "Xác nhận mật khẩu",
                'actionUrl' => GeneralConstant::url . route('check_token_password', $user->password, false));
        }

        $message += array(
            'greeting' => 'Xin chào' . $gender . $user->name,
            'introLines' => [
                GeneralConstant::PROJECT_NAME . ' xin thông báo: Tài khoản ' . $user->email . ' của' . $gender . 'đã được khởi tạo thành công.',
                'Xin cảm ơn và chào mừng' . $gender . ' tham gia vào cộng đồng ' . GeneralConstant::PROJECT_NAME . '!'
            ],
            'end' => 'Chúc ' . $gender . ' một ngày tốt lành,'
        );
        // Style and Font
        $message += array(
            'style' => EmailController::style(),
            'fontFamily' => EmailController::fontFamily()
        );
        Log::info($message);
        // send email
        try {
            Mail::queue('emails.to_user_template', $message, function ($message) use ($user) {
                Log::info('Send email to user');
                $message->to($user->email);
                $message->subject('[' . GeneralConstant::PROJECT_NAME . ']Thông tin tạo tài khoản!');
            });
        } catch (Exception $exception) {
            Log::info('[EMAIL USER SIGN UP] CATCH AN EXCEPTION WHEN SENDING EMAIL');
            return $result;
        }
        $result = GeneralConstant::RESULT_SUCCESS;
        return $result;
    }

    public static function sendEmailApprovedToStudent(Request $request,
                                                      User $user,
                                                      Company $company,
                                                      Project $project,
                                                      $contentArray)
    {
        $result = GeneralConstant::RESULT_FALSE;
        $message = array(
            'greeting' => 'Chào bạn ' . $user->name . ',',
            'introLines' => $contentArray,
            'end' => 'Chúc bạn một ngày tốt lành,'
        );
        $message += array('actionText' => "Vào xem dự án",
            'actionUrl' => GeneralConstant::url . route('projects.get_detail', $project->id, false));

        $subject = '[' . GeneralConstant::PROJECT_NAME . '] Công ty ' . $company->name .
            ' đã đồng ý để bạn tham gia vào dự án ' . $project->name . ' của công ty';
        // Style and Font
        $message += array(
            'style' => EmailController::style(),
            'fontFamily' => EmailController::fontFamily()
        );
        try {
            Mail::queue('emails.to_student_when_approved', $message,
                function ($message) use ($user, $subject) {
                    $message->to($user->email);
                    $message->subject($subject);
                });
            $result = GeneralConstant::RESULT_SUCCESS;
        } catch (Exception $exception) {
            Log::info('[EMAIL STUDENT WHEN APPROVED] CATCH AN EXCEPTION HERE');
            return $result;
        }
        return $result;
    }

    public static function sendEmailRejectToStudent(Request $request,
                                                    User $user,
                                                    Company $company,
                                                    Project $project,
                                                    $contentArray)
    {
        $result = GeneralConstant::RESULT_FALSE;
        $message = array(
            'greeting' => 'Chào bạn, ',
            'introLines' => $contentArray,
            'end' => 'Chúc bạn một ngày tốt lành,'
        );
        $subject = '[' . GeneralConstant::PROJECT_NAME . '] Công ty ' . $company->name .
            '  rất tiếc để thông báo bạn không đủ điều kiện tham gia vào dự án ' . $project->name . ' của công ty';
        // Style and Font
        $message += array(
            'style' => EmailController::style(),
            'fontFamily' => EmailController::fontFamily()
        );
        try {

            Mail::queue('emails.to_student_when_reject', $message,
                function ($message) use ($user, $subject) {
                    $message->to($user->email);
                    $message->subject($subject);
                });
            $result = GeneralConstant::RESULT_SUCCESS;
        } catch (Exception $exception) {
            Log::info('[EMAIL STUDENT WHEN REJECT] CATCH AN EXCEPTION HERE');
            return $result;
        }
        return $result;

    }

    public static function sendEmailToCompanyWhenStudentApply(Request $request,
                                                              $cvID,
                                                              StudentProfile $studentProfile,
                                                              User $companyUser,
                                                              Project $project,
                                                              $contentArray)
    {
        $result = GeneralConstant::RESULT_FALSE;
        if ($companyUser->company_id == null) {
            Log::info('dont know company');
            return;
        }
        try {
            Log::info('[SEND EMAIL TO COMPANY WHEN USER APPLY]');
            $company = Company::find($companyUser->company_id);

            if (is_null($company)) {
                return;
            }

            if (is_null($company->name)) {
                return;
            }

            $message = array(
                'greeting' => 'Xin chào quý công ty ' . $company->name,
                'introLines' => $contentArray,
                'end' => 'Chúc quý công ty một ngày tốt lạnh,'
            );

            $subject = '[' . GeneralConstant::PROJECT_NAME . '] Sinh viên ' . $studentProfile->full_name .
                ' muốn tham gia vào dự án ' . $project->name . ' của công ty.';

            // Style and Font
            $message += array(
                'style' => EmailController::style(),
                'fontFamily' => EmailController::fontFamily()
            );

            $filePath_GPADetail = storage_path().'/app/public/GPA_Detail/'.'student_'.$studentProfile->id.'-'.'project_'.$project->id.'.pdf' ;
            $filePath_CV = storage_path().'/app/public/CV_Pdf/'.$studentProfile->id.'_'.$cvID.'.pdf' ;
                //Storage::url('/CV/'.$studentProfile->id.'_'.$cvID.'.png');

            Mail::queue('emails.to_company_when_student_apply', $message,
                function ($message) use ($companyUser, $subject, $filePath_GPADetail,$filePath_CV) {
                    $message->to($companyUser->email);
                    $message->subject($subject);
                    $message->attach($filePath_GPADetail, array(
                        'as' => 'GPA_Detail',
                        'mime' => 'application/pdf'));
                    $message->attach($filePath_CV,array(
                        'as' => 'CV_Detail',
                        'mime' => 'application/pdf'));
                });
            //delete after send email
            //Storage::delete('GPA_Detail/student_'.$studentProfile->id.'-project_'.$project->id.'.pdf');
        } catch (Exception $exception) {
            Log::info('[sendEmailToCompanyWhenStudentApply] Catch an exception in get company');
            return $result;
        }
        Log::info('[SEND EMAIL TO COMPANY WHEN USER APPLY] SUCCESSFULLY');
        $result = GeneralConstant::RESULT_SUCCESS;
        return $result;
    }

    public static function sendEmail($emailTo, $subject, $title, $end, $contentArray)
    {
        $result = GeneralConstant::RESULT_FALSE;
        $message = [
            'greeting' => $title,
            'introLines' => $contentArray,
            'end' => $end
        ];

        // Style and Font
        $message += array(
            'style' => EmailController::style(),
            'fontFamily' => EmailController::fontFamily()
        );
        try {
            Mail::queue('emails.to_normal_form_email', $message,
                function ($message) use ($subject, $emailTo) {
                    $message->to($emailTo);
                    $message->subject($subject);
                });
            $result = GeneralConstant::RESULT_SUCCESS;
        } catch (Exception $exception) {
            Log::info('[EMAIL] CATCH AN EXCEPTION WHEN SENDING EMAIL');
            return $result;
        }
        return $result;
    }

    public static function sendEmailNominateToStudent(Request $request,
                                                      $email,
                                                      User $user,
                                                      Project $project,
                                                      $contentArray)
    {
        $result = GeneralConstant::RESULT_FALSE;
        $message = array(
            'greeting' => 'Chào bạn, ',
            'introLines' => $contentArray,
            'end' => 'Chúc bạn một ngày tốt lành,'
        );
        $message += array('actionText' => "Vào xem dự án",
            'actionUrl' => GeneralConstant::url . route('projects.get_detail', $project->id, false));

        $subject = '[' . GeneralConstant::PROJECT_NAME . '] Giảng viên ' . $user->name .
            ' đã đề cử bạn tham gia vào dự án ' . $project->name;
        // Style and Font
        $message += array(
            'style' => EmailController::style(),
            'fontFamily' => EmailController::fontFamily()
        );
        try {
            Log::info('before send' . json_encode($message));
            Mail::queue('emails.to_student_when_lecturer_nominate', $message,
                function ($message) use ($email, $subject) {
                    $message->to($email);
                    $message->subject($subject);
                });
            $result = GeneralConstant::RESULT_SUCCESS;
        } catch (Exception $exception) {
            Log::info('[EMAIL STUDENT WHEN ANOMINATE] CATCH AN EXCEPTION HERE');
            return $result;
        }
        return $result;
    }

}
