@extends('layouts.master')
@section('script_and_style')
    <script src="{{URL::to('/js/ui-bootstrap-tpls-2.2.0.min.js')}}"></script>
    <script src="{{URL::to('js/controller/upload_image.js')}}"></script>
@endsection
@section('header_title')
    Tạo Tài Khoản Cho Giáo Viên
@endsection
@section('content')
    <div class="container">
        <form method="post" action="" class="form-horizontal" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-10 col-md-offset-2">
                    <table>
                        <tr>
                            <td width="80%">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-4">
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
                                        <div class="col-md-4">
                                            <label class="form-control-static">Tên giảng viên:</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="name" value="{{old('name')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label class="form-control-static">Trường:</label>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control" name="university_id">
                                                <option selected disabled>Chọn trường</option>
                                                @foreach($universities as $university)
                                                    <option value="{{$university->id}}">{{$university->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label class="form-control-static">Khoa:</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="faculty"
                                                   value="{{old('faculty')}}">
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
                    </table>
                </div>
            </div>
            <div class="row text-center">
                {{csrf_field()}}
                <button class="btn btn-primary btn-lg">Tạo Tài Khoản</button>
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
        </form>
    </div>
@endsection
