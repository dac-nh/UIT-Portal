<?php
/**
 * Created by PhpStorm.
 * User: Dark Wolf
 * Date: 11/04/2016
 * Time: 12:47 PM
 */
namespace App\Http\Middleware;

use Auth;
use Closure;

class isActive{
    /**
     * @param $request
     * @param Closure $next
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
        return $next($request);
    }
}