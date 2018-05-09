@extends('layouts.master')
@section('script_and_style')
    <script src="{{URL::to('/js/ui-bootstrap-tpls-2.2.0.min.js')}}"></script>
    <link href="{{URL::to('css/list_cv.css')}}" rel="stylesheet"/>
    <script src="{{URL::to('/js/upload_cv.js')}}"></script>
@endsection
@section('header_title')
    Quản Lý CV
@endsection
@section('content')
    <div class="row" ng-controller="CVListController">
        <input hidden value="{{$student_id}}" />
        <input hidden value="{{$numOfCV}}" id="numOfCV"/>
        <div class="col-md-6" style="padding-left: 80px;">
            <button type="button" class="btn btn-success btn-lg" ng-click="onUpload($event)">Upload</button>
        </div>
        {{--<div class="col-md-6" style="text-align: right;padding-right: 80px;">--}}
        {{--<button type="button" class="btn btn-danger btn-lg btnXoa">Xóa</button>--}}
        {{--</div>--}}
    </div>
    <br>
    <div>
        <div class="row" ng-controller="CVListController">
            @foreach($cvs as $cv)
                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 template_cv show-image">
                    <input type="hidden" value="{{$cv->id}}">
                    <a href="{{$cv->filePath_png}}">
                        <img ng-src="{{$cv->filePath_png}}" class="cv_img" frameborder="0"/> {{--ng-click="showFullScreen($index)" ng-show="nowShowing==$index"--}}
                    </a>
                    <button type="button" class="btn btn-default btn-lg delete" id="btnDelete" style="background-color:indianred;color: white" ng-click="onDelete($event)"><i class="glyphicon glyphicon-trash"></i></button>
                    <button type="button" class="btn btn-default btn-md edit" id="btnEdit" style="background-color:olive;color: white" ng-click="onEdit($event)"><i class="glyphicon glyphicon-pencil"></i></button>
                    <div class="clearfix"></div>
                    <div class="row template_cv" style="padding-left: 70px;padding-right: 10px;">
                        <div class="col-xs-3 col-sm-3 col-md-1 col-lg-1"></div>
                        <div class="bs-callout bs-callout-danger" style="height: 80px;width: 430px;">
                            <div class="col-xs-7 col-sm-7 col-md-5 col-lg-5">
                                <p>{{$cv->name}}</p>
                                <div style="width: 170px;">
                                    <i class="fa fa-clock-o fa-sm"></i> {{$cv->created_at}}
                                </div>
                            </div>
                            <div class="col-xs-10 col-sm-10 col-md-7 col-lg-7">
                                <div style="text-align: right;">
                                    {{--3 lượt nhận xét--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{--Upload CV--}}
    <script type="text/ng-template" id="upload-modal.html">
        <div class="modal-header">
            <h4 class="modal-title">Upload CV</h4>
        </div>
        <div class="modal-body">
            <form enctype="multipart/form-data" id="upload_form" role="form" method="POST" action="" >
                <div class="form-group">
                    <label for="contact-email" class="col-sm-2 control-label">Tên CV:</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" name="cv_name" id="cv_name" value="">
                    </div>
                    <div style="padding-top: 45px;padding-bottom: 10px;">
                        {{--<form enctype="multipart/form-data" id="upload_form" role="form" method="POST" action="" >--}}
                        <label for="contact-msg" class="col-sm-2 control-label">Upload: </label>
                        <div class="col-md-10">
                            <input type="file" id="cv_file" name="cvFile" accept="application/pdf" value="Upload" style="width: 270px;text-decoration: underline;">
                        </div>
                        {{--</form>--}}
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="modal-confirm" ng-click="onSureUpload()">Xác nhận</button>
            <button type="button" class="btn btn-default" data-dismiss="modal" ng-click="onCancel()">Hủy bỏ</button>
        </div>
    </script>

    <script>
        var saveCV = '{{ route('cvs.saveCV', ['student_id' => $student_id]) }}';
        var listCV = '{{ route('getListCVView', ['student_id' => $student_id]) }}';
        var deleteCV = '{{ route('cvs.deleteCV',['student_id'=>$student_id]) }}';
        var editCV = '{{route('cvs.editCV',['student_id'=>$student_id])}}';
    </script>

    {{--Delete CV--}}
    <script type="text/ng-template" id="delete-modal.html">
        <div class="modal-header">
            <h4 class="modal-title">Xóa CV</h4>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-group">
                    <label for="post-body">Bạn có chắc chắn xóa CV này không?</label>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="modal-delete" ng-click="onSureDelete()">Chắc chắn</button>
            <button type="button" class="btn btn-default" data-dismiss="modal" ng-click="onCancel()">Không</button>
        </div>
    </script>

    {{--Edit CV--}}
    <script type="text/ng-template" id="edit-modal.html">
        <div class="modal-header">
            <h4 class="modal-title">Chỉnh sửa CV</h4>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-group">
                    <label for="post-body">Tên CV: </label>
                    <input class="form-control" type="text" name="cv_name" ng-model="cv_name_edit" value="">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="modal-save" ng-click="onSureEdit()">Lưu</button>
            <button type="button" class="btn btn-default" data-dismiss="modal" ng-click="onCancel()">Hủy</button>
        </div>
    </script>
@endsection
