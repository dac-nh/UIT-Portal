<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!--Google Login-->
    <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Signika+Negative:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Inconsolata:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto">

    <script src="https://apis.google.com/js/client:platform.js?onload=start" async defer></script>
    <meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id"
          content="1021142554357-5a5b8g3log3srueo3ou7o88nmrfg1niv.apps.googleusercontent.com">
    <!-- Bootstrap CSS -->
    <link href="{{URL::to('/css/bootstrap.css')}}" rel="stylesheet" type="text/css">
    <link href="{{URL::to('/css/bootstrap-social-button.css')}}" rel="stylesheet" type="text/css">
    <!-- font-awesome -->
    <link rel="stylesheet" href="{{URL::to('css/font-awesome/css/font-awesome.min.css')}}">
    <!-- CSS main -->
    <link href="{{URL::to('/css/app.css')}}" rel="stylesheet">
    <!-- css for bootstrap dialog-->
    <link href="{{URL::asset('css/bootstrap-dialog.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>

    <!--JQuery -->
    <script src="{{URL::asset('js/jquery.min.js')}}"></script>
    <!-- API Google -->
    <script src="https://apis.google.com/js/platform.js" async defer></script>

    <!-- Bootstrap -->
    <script src="{{URL::to('/js/bootstrap.js')}}" rel="stylesheet"></script>
    <!-- Tether for Bootstrap -->
    <script src="https://www.atlasestateagents.co.uk/javascript/tether.min.js"></script>
    <!--Bootstrap Dialog-->
    <script src="{{URL::asset('js/bootstrap-dialog.js')}}"></script>
    <title>@yield('title')</title>
</head>

<body ng-app="MainApp">
<div id="container">
    @include('includes.header')
    <div id="body">
    @if(Request::path() == '/')
        <!--11/10/2016: Dac-->
            @include('includes.message')
            @yield('content')
        @else
            <div id="body-content">
                <div class="row">
                    <div class="col-md-12 text-center" style="margin-bottom: 10px">
                        <h1 style="font-weight: bold;font-size: 3em;color: #216290"> @yield('header_title')</h1>
                    </div>
                </div>
                <!--11/10/2016: Dac-->
                @include('includes.message')
                @yield('content')
            </div>
        @endif


    </div>
    @include('includes.footer')
</div>
<!-- Scripts -->
<script>
    window.Laravel =
    <?php echo json_encode([
        'csrfToken' => csrf_token(),
        'CONST_PROJECT_NEW' => \App\Libraries\GeneralConstant::PROJECT_NEW,
        'CONST_PROJECT_HIRING' => \App\Libraries\GeneralConstant::PROJECT_HIRING,
        'CONST_PROJECT_IN_PROGRESS' => \App\Libraries\GeneralConstant::PROJECT_IN_PROGRESS,
        'CONST_PROJECT_FINISHED' => \App\Libraries\GeneralConstant::PROJECT_FINISHED,
        'CONST_PROJECT_PUBLISHED' => \App\Libraries\GeneralConstant::PROJECT_PUBLISHED,
        'CONST_PROJECT_STOPPED' => \App\Libraries\GeneralConstant::PROJECT_STOPPED,
        'CONST_PROJECT_CANCELED' => \App\Libraries\GeneralConstant::PROJECT_CANCELED,
    ]);
    ?>
</script>
<!--AngularJS-->
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.0/angular.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.0/angular-animate.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.0/angular-aria.min.js"></script>
<!--Grid for AngularJS-->
<link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/angular-ui/bower-ui-grid/master/ui-grid.min.css">
<script src="https://cdn.rawgit.com/angular-ui/bower-ui-grid/master/ui-grid.min.js"></script>
<!--Material Design for AngularJS-->
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.css">
<script src="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.js"></script>
<script src="{{URL::to('/js/ui-bootstrap-tpls-2.2.0.min.js')}}"></script>
<script src="{{URL::to('/js/angular_home.js')}}"></script>
@yield('script_and_style')
</body>
</html>
