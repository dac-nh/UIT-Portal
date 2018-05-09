<?php
/**
 * Created by PhpStorm.
 * User: Dark Wolf
 * Date: 11/10/2016
 * Time: 12:54 PM
 */
namespace App\Http\Middleware;

use App\Libraries\GeneralConstant;
use Auth;
use Closure;

class isLecture
{
    /**
     * @param $request
     * @param \Closure $next
     * @return \Illuminate\Http\RedirectResponse
     */
    function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            $message = ['message_info' => 'Bạn chưa đăng nhập! Xin vui lòng đăng nhập rồi thực hiện lại thao tác'];
            return redirect()->route('sign_in')->with($message);
        }
        if (!Auth::user()->isActive()) {
            Auth::logout();
            $message = ['message_danger' => 'Tài khoản của bạn đã bị khóa!'];
            return redirect()->route('sign_in')->with($message);
        }
        if (Auth::user()->role_id != GeneralConstant::LECTURER_ROLE && Auth::user()->role_id != GeneralConstant::AGENT_ROLE) {
            return redirect()->route('home');
        }
        return $next($request);
    }
}