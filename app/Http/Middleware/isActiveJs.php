<?php

namespace App\Http\Middleware;

use App\Libraries\GeneralConstant;
use App\Models\User;
use Auth;
use Closure;

class isActiveJs
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $currentUser = $request->user();
        if (is_null($currentUser)) {
            $message = ['message_info' => 'Bạn chưa đăng nhập! Xin vui lòng đăng nhập rồi thực hiện lại thao tác'];
            return redirect()->route('sign_in')->with($message);
        }
        $checkUser = User::whereId($currentUser->id)->first();
        if($currentUser != $checkUser){
            Auth::logout();
            $message = ['message_danger' => 'Tài khoản của bạn không chính xác! Xin vui lòng đăng nhập lại!'];
            return redirect()->route('sign_in')->with($message);
        }
        return $next($request);
    }
}
