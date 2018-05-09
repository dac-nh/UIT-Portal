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

class isSuperAdmin{
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
            $message = ['message_danger' => 'Tài khoản của bạn đã bị khóa!'];
            return redirect()->route('sign_in')->with($message);
        }
        if (Auth::user()->role_id != GeneralConstant::SUPER_USER_ROLE)
        {
            $message = ['message_info' => 'Tài khoản của bạn không đủ quyền hạn!'];
            return redirect()->route('home')->with($message);
        }
        return $next($request);
    }
}