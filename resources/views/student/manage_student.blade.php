@extends('layouts.master')
@section('script_and_style')
    <script src="{{URL::to('js/controller/upload_image.js')}}"></script>
    <script src="{{URL::to('js/controller/manage_student.js')}}"></script>
@endsection
@section('header_title')
    Trang Quản Lý Của Sinh Viên
@endsection
@section('content')
    <div class="container" ng-controller="ManageStudentController">
        <input type="hidden" ng-value="student_id" ng-init="student_id={{$student_profiles->id}}">
        <div class="row">
            <div class="col-md-12">
                <h1 class="header-line"><span>Thông tin cá nhân</span>
                    <i class="glyphicon glyphicon-pencil pull-right main-text-color" style="cursor:pointer"></i>
                </h1>
            </div>
            <!-- left column -->
            <div class="col-md-3">
                <div class="text-center" ng-controller="UploadImageController">
                    <img ng-src="<%imageSrc%>" height="200px" width="200px"
                         alt="avatar">
                    <input type="file" class="text-center center-block well well-sm" name="file" accept='image/*'
                           onchange="angular.element(this).scope().setFile(this)"
                           style="overflow: hidden;margin-top:35px">
                </div>
            </div>
            <!-- edit form column -->
            <div class="col-md-9 personal-info">
                <form class="form-horizontal user-detail-information-form" role="form">
                    <div class="form-group">
                        <label class="col-md-2">Họ tên</label>
                        <p class="col-md-4">{{$student_profiles['full_name']}}</p>
                        <label class="col-md-2">Giới tính</label>
                        @if($student_profiles['gender'] == 1)
                            <p class="col-md-4">Nữ</p>
                        @else
                            <p class="col-md-4">Nam</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="col-md-2">Ngày sinh</label>
                        <p class="col-md-4">{{$student_profiles['birthday']}}</p>
                        <label class="col-md-2">Địa chỉ</label>
                        <p class="col-md-4">{{$student_profiles['address']}}</p>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2">Số điện thoại</label>
                        <p class="col-md-4">{{$student_profiles['phone']}}</p>
                        <label class="col-md-2">Skype ID</label>
                        <p class="col-md-4">{{$student_profiles['skype_id']}}</p>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2">Email</label>
                        <p class="col-md-4">{{$student_profiles['user']->email}}</p>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2">Trường</label>
                        <p class="col-md-4">{{$student_profiles['university_id']}}</p>
                        <label class="col-md-2">Khóa</label>
                        <p class="col-md-4">{{$student_profiles['academic_year']}}</p>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2">Khoa</label>
                        <p class="col-md-4">{{$student_profiles['faculty_name']}}</p>
                        <label class="col-md-2">GPA</label>
                        <p class="col-md-4">{{$student_profiles['gpa']}}</p>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2">Chuyên ngành</label>
                        <p class="col-md-4">{{$student_profiles['major_name']}}</p>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h1 class="header-line"><span>Giới thiệu</span>
                    <i class="glyphicon glyphicon-pencil pull-right main-text-color" style="cursor:pointer"></i>
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h1 class="header-line"><span>Thông tin CV</span>
                    <i class="glyphicon glyphicon-cog pull-right main-text-color" style="cursor:pointer"></i>
                </h1>
            </div>
            <div class="col-md-10 col-md-offset-1">
                <div ui-grid="gridOptions1" class="preview-grid"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h1 class="header-line"><span>Các dự án đã đăng ký</span>
                </h1>
            </div>
            <div class="col-md-10 col-md-offset-1">
                <div ui-grid="gridOptions2" class="preview-grid"></div>
            </div>
        </div>
    </div>
@endsection
