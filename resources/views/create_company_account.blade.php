@extends('layouts.master')
@section('script_and_style')
    <script src="{{URL::to('/js/ui-bootstrap-tpls-2.2.0.min.js')}}"></script>
    <script src="{{URL::to('js/controller/upload_image.js')}}"></script>
    <script src="{{URL::to('js/controller/create_company_account.js')}}"></script>
@endsection
@section('header_title')
    Tạo Tài Khoản Cho Công Ty
@endsection
@section('content')
    <div class="container">
        {{--<form method="post" action="" class="form-horizontal" enctype="multipart/form-data">--}}
        <div class="row">
            <div class="col-md-10 col-md-offset-2">
                <table>
                    <tr>
                        <td width="80%">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <label class="form-control-static">Email:</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="email" name="email"
                                               value="{{old('email')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <label class="form-control-static">Mật khẩu:</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="password" name="password">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <label class="form-control-static">Xác nhận mật khẩu:</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="password" name="confirm_password">
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div ng-controller="UploadImageController">
                                <img ng-src="<%imageSrc%>" height="150px" width="150px">
                                <input type="file" name="file" accept='image/*'
                                       onchange="angular.element(this).scope().setFile(this)"
                                       style="overflow: hidden;width:80px;margin-left:35px">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <label class="form-control-static">Tên công ty:</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" name="name" value="{{old('name')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <label class="form-control-static">Tỉnh/Thành phố:</label>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="city_id">
                                            {{--@foreach($universities as $university)--}}
                                            {{--<option value="{{$university->id}}">{{$university->name}}</option>--}}
                                            {{--@endforeach--}}
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-control-static">Quận/Huyện:</label>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="district_id">
                                            {{--@foreach($universities as $university)--}}
                                            {{--<option value="{{$university->id}}">{{$university->name}}</option>--}}
                                            {{--@endforeach--}}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <label class="form-control-static">Trang web:</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" name="url"
                                               value="{{old('url')}}">
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row text-center" ng-controller="CreateCompanyAccountController">
            {{csrf_field()}}
            <button class="btn btn-primary btn-lg" ng-confirm-message="Xác nhận tạo tài khoản cho công ty?"
                    ng-confirm-click="onClick()">Tạo Tài Khoản
            </button>
        </div>
        <div class="row">
            @if(count($errors) > 0)
                <div class="col-md-offset-5">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>
                                <span style="color:red">{{$error}}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        {{--</form>--}}
    </div>
@endsection
