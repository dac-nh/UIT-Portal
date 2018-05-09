<?php

namespace App\Http\Middleware;

use App\Libraries\GeneralConstant;
use Auth;
use Closure;
use Log;

class checkUserRoleUserDetail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('sign_in');
        }
        if (!Auth::user()->isActive()) {
            Auth::logout();
            $message = ['message_danger' => 'Tài khoản của bạn đã bị khóa!'];
            return redirect()->route('sign_in')->with($message);
        }
        if ($role_id = Auth::user()->role_id != GeneralConstant::STUDENT_ROLE)
            switch ($role_id) {
                case GeneralConstant::LECTURER_ROLE:
                    return redirect()->route('getLecturerManagement');
                    break;
                case GeneralConstant::COMPANY_ROLE:
                    return redirect()->route('getCompanyManagement');
                    break;
                default:
                    Log::info('[CheckUserRoleUserDetail] Has bug with profile role id: '.$role_id);
                    return redirect()->route('home');
                    break;
            }
        return $next($request);
    }
}
