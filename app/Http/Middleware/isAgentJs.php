<?php

namespace App\Http\Middleware;

use App\Models\User;
use Auth;
use Closure;

class isAgentJs
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
        $currentUser = Auth::user();
        if (!$currentUser->isAgent()){
            $message = ['message_warning' => 'Chỉ có người đứng đầu công ty mới được quyền thực hiện tác vụ này!'];
            return redirect()->route('home')->with($message);
        }
        return $next($request);
    }
}
