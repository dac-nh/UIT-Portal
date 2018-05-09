<?php

namespace App\Http;

use App\Http\Middleware\checkUserRoleUserDetail;
use App\Http\Middleware\isActive;
use App\Http\Middleware\isActiveJs;
use App\Http\Middleware\isAgent;
use App\Http\Middleware\isAgentJs;
use App\Http\Middleware\isAllowedComment;
use App\Http\Middleware\isCompany;
use App\Http\Middleware\isCompanyJs;
use App\Http\Middleware\isLecture;
use App\Http\Middleware\isLectureJs;
use App\Http\Middleware\isStudent;
use App\Http\Middleware\isStudentJs;
use App\Http\Middleware\isSuperAdmin;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,

        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

        'isActive' => isActive::class,
        'isSuperUser' => isSuperAdmin::class,
        'isAgent' => isAgent::class,
        'isCompany' => isCompany::class,
        'isLecture' => isLecture::class,
        'isStudent' => isStudent::class,
        'isActiveJs' => isActiveJs::class,
        'isAgentJs' => isAgentJs::class,
        'isCompanyJs' => isCompanyJs::class,
        'isLectureJs' => isLectureJs::class,
        'isStudentJs' => isStudentJs::class,
        'checkUserRoleUserDetail' => checkUserRoleUserDetail::class,
        'isAllowedComment' => isAllowedComment::class
    ];
}
