@extends('layouts.master')
@section('script_and_style')
    <script src="{{URL::to('js/controller/create_project.js')}}"></script>
@endsection
@section('header_title')
    Tạo mới dự án
@endsection
@section('content')
    <div ng-controller="CreateProjectController">
        <!-- Thông tin chung -->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1">
                <legend><h3>Thông tin chung</h3></legend>
                <div>
                    <div class="row form-group">
                        <label class="col-lg-2 col-md-2 col-sm-2 col-xs-2">Tên dự án</label>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                            <input ng-model="project_name" ng-class="project_name_field" class="form-control" type="text" style="width: 90%;"/>
                        </div>
                        <label class="col-lg-2 col-md-2 col-sm-2 col-xs-2">Công ty</label>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <select ng-class="company_field" class="form-control" ng-model="company"
                                    ng-options="item.name for item in companyOptions track by item.id"></select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-lg-2 col-md-2 col-sm-2 col-xs-2">Địa điểm</label>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                            <textarea ng-class="address_field" ng-model="address" class="form-control"
                                      style="resize: none;width: 90%"></textarea>
                        </div>
                        <label class="col-lg-2 col-md-2 col-sm-2 col-xs-2">Dự kiến bắt đầu</label>
                        <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>
                            <p class="input-group">
                                <input ng-class="start_date_field" type="text" class="form-control" uib-datepicker-popup
                                       ng-model="start_date" is-open="popup.opened"
                                       close-text="Close"/>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="open()"><i
                                                class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-lg-2 col-md-2 col-sm-2 col-xs-2">Thời gian</label>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input ng-class="num_of_week_field" class="form-control" ng-model="number_of_week" only-numbers style="width: 90%;"
                                   placeholder="Số tuần"/>
                        </div>
                        <label class="col-xs-2 col-xs-offset-2">Thời gian làm việc</label>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <select ng-class="work_type_field" class="form-control" ng-model="work_type"
                                    ng-options="item.name for item in typeOptions track by item.id"></select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-lg-2 col-md-2 col-sm-2 col-xs-2">Skill</label>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <div class="row form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <select class="form-control" name="type_id" ng-model="selected_skill"
                                            ng-options="item.name for item in skillOptions track by item.id"></select>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                    <button ng-click="onAddSkill()" class="btn btn-primary"><i
                                                class="glyphicon glyphicon-plus"></i></button>
                                </div>
                            </div>
                            <div id="tag-field" style="border: 1px solid silver; width: 90%; min-height: 150px;">
                                <label ng-repeat="skill in selected_skill_list"
                                       style="margin:10px; background-color: #5cb85c;color: white; padding: 5px;"
                                       class="text-center">
                                    <%skill.name%>
                                    <i style="border-left: 2px solid white;padding: 5px;margin-left: 10px;cursor: pointer"
                                       class="glyphicon glyphicon-remove"
                                       ng-click="onRemoveSkill($index)"></i>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Thông tin tuyển dụng -->
        <div class="row">
            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-md-offset-1">
                <legend><h3>Thông tin tuyển dụng</h3></legend>
                <div>
                    <div class="row form-group">
                        <label class="col-xs-2">Số lượng</label>
                        <div class="col-xs-3">
                            <input ng-class="need_min_field" ng-model="need_min" class="form-control" only-numbers type="text"/>
                        </div>
                        <label class="col-xs-2">Tối đa</label>
                        <div class='col-xs-3'>
                            <input ng-class="need_max_field" ng-model="need_max" class="form-control" only-numbers type="text"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-lg-2 col-md-2 col-sm-2 col-xs-2">Mô tả</label>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <textarea ng-class="intro_field" ng-model="intro" class="form-control"
                                      style="resize: none;height: 150px;"></textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-lg-2 col-md-2 col-sm-2 col-xs-2">Yêu cầu</label>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <textarea ng-class="requirement_field" ng-model="requirement" class="form-control"
                                          style="resize: none;height: 150px;"></textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-lg-2 col-md-2 col-sm-2 col-xs-2">Điểm cộng</label>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <textarea ng-class="plus_point_field" ng-model="plus_point" class="form-control"
                                      style="resize: none;height: 100px;"></textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-lg-2 col-md-2 col-sm-2 col-xs-2">Email liên
                            hệ</label>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <input ng-class="contact_email_field" ng-model="contact_email" class="form-control" type="text" style="width: 95%;"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-lg-2 col-md-2 col-sm-2 col-xs-2">Tập tin đính kèm
                            (nếu
                            có)</label>
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                            <input type="file" ng-model="extra_file"
                                   value="Upload" style="width: 270px;text-decoration: underline;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 pull-right">
                <button ng-click="onPublishProjectClick()" type="button" class="btn btn-primary btn-lg pull-left">
                    Publish
                </button>
                <button ng-click="onCreateProjectClick()" type="button" class="btn btn-lg"
                        style="background-color: darkgreen;color: white; margin-left:20px">
                    Tạo
                </button>
            </div>
        </div>
    </div>
@endsection
