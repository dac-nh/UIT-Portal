@extends('layouts.master')
@section('script_and_style')
    <script src="{{URL::to('js/controller/authenticate_controller.js')}}"></script>
@endsection
@section('header_title')
    Đăng nhập
@endsection
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Đăng nhập tài khoản sinh viên</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('sign_in') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email"
                                       value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password"
                                       required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input id='remember_me' type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-9 col-md-offset-4 col-sm-8 col-sm-offset-4 col-xs-9 col-xs-offset-2">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
                                <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                    <div class="col-md-9 col-md-offset-4 col-sm-8 col-sm-offset-4 col-xs-9 col-xs-offset-2" ng-controller="GoogleLoginController">
                        <a href="#" class="button google-plus" id="googleLogin" ng-click="googleLogin()">
                            <span>
                                <i class="fa fa-google-plus"></i>
                            </span>
                            <p class="social">Google</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
