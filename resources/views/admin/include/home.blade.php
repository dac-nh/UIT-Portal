<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

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
    <link href="{{URL::asset('css/admin/sb-admin-2.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Metis Menu-->
    <link href="{{URL::asset('css/admin/metisMenu.min.css')}}" rel="stylesheet" type="text/css"/>
    <!--Morris-->
    <link href="{{URL::asset('css/admin/morris.css')}}" rel="stylesheet" type="text/css"/>


    <!--JQuery -->
    <script src="{{URL::asset('js/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{URL::to('/js/bootstrap.min.js')}}" rel="stylesheet"></script>
    <!-- Tether for Bootstrap -->
    <script src="https://www.atlasestateagents.co.uk/javascript/tether.min.js"></script>
    <!--Bootstrap Dialog-->
    <script src="{{URL::asset('js/bootstrap-dialog.js')}}"></script>
    <!-- Metis Menu-->
    <script src="{{URL::asset('js/admin/metisMenu.min.js')}}"></script>
    <!--Raphael-->
    <script src="{{URL::asset('js/admin/raphael.min.js')}}"></script>
    <!--Morris-->
    <script src="{{URL::asset('js/admin/morris.min.js')}}"></script>
    <script src="{{URL::asset('js/admin/morris-data.js')}}"></script>
    <script src="{{URL::asset('js/admin/sb-admin-2.js')}}"></script>

    <!-- Scripts -->
    <script>
        window.Laravel =
        <?php echo json_encode([
            'csrfToken' => csrf_token(),
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
    <script src="{{URL::to('/js/ui-bootstrap-tpls-2.2.0.min.js')}}"></script>
    <script src="{{URL::to('/js/angular_home.js')}}"></script>
    <title>@yield('title')</title>
    @include('admin.include.header')
</head>

<body>
<div>
    <div id="wrapper">
        @yield('content')
    </div>
</div>
</body>
</html>