@extends('layouts.master')
@section('script_and_style')
    <!-- css for view 'register_project' -->
    <link href="{{URL::to('/css/register_project.css')}}" rel="stylesheet">
    <link href="{{URL::to('/css/projectDetail.css')}}" rel="stylesheet">
    <script src="{{URL::to('/js/register_success.js')}}"></script>
@endsection
@section('header_title')
    Đăng ký dự án #{{$project_id}}
@endsection
@section('content')
    @include('includes.message')
    <div class="container" ng-controller="RegisterController">
        {{--thong tin dang ky--}}
        <div>
            <div class="strike">
                <span><h4 style="font-weight: bold">Thông tin đăng ký</h4></span>
            </div>

            <div class="form-group" style="padding-left: 90px;padding-top: 15px;">
                <label class="mainlabel" for="studentname" style="margin-right: 55px;">Giới thiệu</label>
                <textarea class="form-control" id="intro" style="resize: none;height: 100px;width:780px;" name="intro" minlength="50"></textarea>
            </div>

            <div class="row">
                <div class="col-md-6"  style="padding-left: 90px;padding-right: 0px;">
                    <div class="form-group">
                        <label class="lblBangDiem" for="cv_name">Tên CV</label>
                        <select class="selectpicker cv_select">
                            @foreach($cvs as $cv)
                                <option value="{{$cv->id}}">{{$cv->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <form enctype="multipart/form-data" id="upload_form" role="form" method="POST" action="" >
                            <label class="lblBangDiem" for="gpadetail">Bảng điểm chi tiết:</label>
                            <input type="file" id="gpa_detail" name="gpadetail" accept="application/pdf" value="Upload" style="width: 270px;text-decoration: underline;">
                        </form>
                    </div>
                </div>
                <div class="col-md-5">
                        <div class="groupbutton" style="text-align: right">
                            <button type="button" class="btn btn-default btn-lg" id="register" ng-click="onRegister($event)" style="background-color: darkgreen;color: white">Đăng ký</button>
                        </div>
                </div>
            </div>
        </div>

        <!-- Thông tin cá nhân -->
        <div>
            <div class="row">
                <div class="col-md-11 strike">
                    <span><h4 style="font-weight: bold">Thông tin cá nhân</h4></span>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-default btn-md btnEdit" ng-hide="show" ng-click="onEdit()" style="background-color: cadetblue;color: white"><i class="glyphicon glyphicon-pencil"></i></button>
                    <button type="button" class="btn btn-default btn-md btnSave" ng-hide="!show" ng-click="onSave()" style="background-color: cadetblue;color: white;"><i class="glyphicon glyphicon-ok" ></i></button>
                </div>
            </div>
            <div class="strike">

            </div>
            <div class="row" style="padding-top: 15px;">
                <div class="col-md-6 col-md-offset-1">
                    <div class="form-group">
                        <label class="mainlabel" for="studentname">Họ và tên</label>
                        <label id="full_name">{{$profile->full_name}}</label>
                    </div>
                    <div class="form-group">
                        <label class="mainlabel" for="birthday">Ngày sinh</label>
                        <label id="birthday">{{$birthday=date("d-m-Y",strtotime($profile->birthday))}}</label>
                    </div>
                    <div class="form-group">
                        <label class="mainlabel" for="studentid">Email</label>
                        <label id="email">{{$email}}</label>
                    </div>
                    <div class="form-group">
                        <label class="mainlabel" for="major">Số điện thoại</label>
                        <label id="phone">{{$profile->phone}}</label>
                    </div>
                    <div class="form-group">
                        <label class="mainlabel" for="major">Skype ID</label>
                        <label id="skypeid">{{$profile->skype_id}}</label>
                    </div>
                    <div class="form-group">
                        <label class="mainlabel" for="studentname">Địa chỉ</label>
                        <label id="address">Tp Hồ Chí Minh</label>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="mainlabel" for="university_name">Trường</label>
                        <label id="university_name">{{$profile->university_name}}</label>
                    </div>
                    <div class="form-group">
                        <label class="mainlabel" for="faculty">Khoa</label>
                        <label id="faculty_name">{{$profile->faculty_name}}</label>
                    </div>
                    <div class="form-group">
                        <label class="mainlabel lblChuyenNganh" for="major">Chuyên ngành</label>
                        <label id="major_name">{{$profile->major_name}}</label>
                    </div>
                    <div class="form-group">
                        <label class="mainlabel" for="academic_year">Khóa</label>
                        <label id="academic_year"> {{$profile->academic_year}}</label>
                    </div>
                    <div class="form-group">
                        <label class="mainlabel" for="gpa">GPA</label>
                        <label id="gpa">{{$profile->gpa}}</label>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>

    <script type="text/ng-template" id="confirm-modal.html">
        <div class="modal-header">
            <h4 class="modal-title">Đăng ký</h4>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-group">
                    <label for="post-body">Bạn có chắc chắn đăng ký dự án #{{$project_id}} không?</label>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="modal-save" ng-click="onSureRegist()">Chắc chắn</button>
            <button type="button" class="btn btn-default" data-dismiss="modal" ng-click="onCancel()">Không</button>
        </div>
    </script>

    <script>
        var project_url = '{{ route('projects.get_detail', ['project_id' => $project_id]) }}';
        var urlSave = '{{ route('projects.apply_post', ['project_id' => $project_id]) }}';
        var urlSaveFile = '{{ route('projects.apply_post.saveFile', ['student_id' => $profile->id, 'project_id' => $project_id]) }}';
    </script>
@endsection
