<?php

namespace App\Http\Middleware;
use App\Models\User;
use Auth;
use Closure;

/**
 * Created by PhpStorm.
 * User: Dark Wolf
 * Date: 12/22/2016
 * Time: 2:19 PM
 */
class isAllowedComment
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
        if (!$currentUser->isLecture() && !$currentUser->isAgent() && !$currentUser->isCompany()){
            $message = ['message_warning' => 'Bạn không có quyền truy cập!'];
            return redirect()->route('home')->with($message);
        }
        return $next($request);
    }
}
