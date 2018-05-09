@extends('layouts.master')
@section('header_title')
    Trang Quản Lý Đại Diện Nhà Trường
@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1">
            <legend><h3>Thông Tin Tài Khoản</h3></legend>
            <table style="width: 100%">
                <tr>
                    <td style="text-align: center" width="30%">
                        <img src="{{$uni_logo}}" height="150px" width="150px">
                    </td>
                    <td width="60%">
                        <div>
                            <h3>{{$agent->name}}</h3>
                        </div>
                        <div>
                            <h4>Trường : {{$agent->university->name}}</h4>
                        </div>
                    </td>
                    <td>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1">
            <legend><h3>Chức Năng Riêng Của Đại Diện Trường</h3></legend>
            <ul class="col-md-offset-1">
                <li>
                    <h4><a href="{{Route('getAppliedList')}}">Quản lí tình hình thực tập của sinh viên</a></h4>
                </li>
                <li>
                    <h4><a href="{{Route('getManageProjectView')}}">Khởi tạo và quản lí các dự án</a></h4>
                </li>
                <li>
                    <h4><a href="{{Route('getCreateLecture')}}">Tạo tài khoản cho giáo viên</a></h4>
                </li>
                <li>
                    <h4><a href="{{Route('getCreateCompanyAgent')}}">Tạo tài khoản cho công ty</a></h4>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1">
            <legend><h3>Danh Sách Các Sinh Viên Đã Nhận Xét</h3></legend>
            <div class="col-md-10 col-md-offset-1">
                <table class="table table-striped table-bordered text-center" style="width: 900px;">
                    <thead>
                    <tr>
                        <th class="text-center">Tên Sinh Viên</th>
                        <th class="text-center">Tên Sinh Viên</th>
                        <th class="text-center">Nhận Xét Lúc</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cv_list as $cv)
                        <tr>
                            <td>
                                {{$cv['name']}}
                            </td>
                            <td>
                                {{$cv['student_name']}}
                            </td>
                            <td>
                                {{$cv['review_date']}}
                            </td>
                            <td>
                                <form method="post" action="/student/cv">
                                    {{csrf_field()}}
                                    <input type="hidden" name="cv_id" value="{{$cv['id']}}">
                                    <button class="btn btn-primary">Chi tiết >></button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
<style>
    legend h3 {
        color: #216290;
    }

    table th {
        background: #0067AF;
        color: #ffffff;
    }
</style>