@extends('layouts.master')
@section('script_and_style')
    <script src="{{URL::to('js/controller/applied_student_list.js')}}"></script>
@endsection
@section('header_title')
    Danh Sách Sinh Viên Đã Đăng Ký
@endsection
@section('content')
    <div class="container" ng-controller="AppliedStudentListController">
        <form method="post" action="/export/applied-students" class="form-horizontal">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="col-md-4">
                            <label class="form-control-static">Công ty</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="company_id" ng-model="company_id"
                                    ng-options="item.name for item in companyOptions track by item.id"></select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="col-md-4">
                            <label class="form-control-static">Trạng Thái</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="result" ng-model="result"
                                    ng-options="item.name for item in resultOptions track by item.id"></select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="col-md-4">
                            <label class="form-control-static">Từ ngày</label>
                        </div>
                        <div class="col-md-8">
                            <p class="input-group">
                                <input type="text" class="form-control" uib-datepicker-popup ng-model="from_date"
                                       name="from_date" is-open="popup1.opened" ng-required="true" close-text="Close"/>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="open1()"><i
                                                class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="col-md-4">
                            <label class="form-control-static">Tên sinh viên</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" type="text" name="student_name"
                                   ng-model="student_name">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="col-md-4">
                            <label class="form-control-static">Đến ngày</label>
                        </div>
                        <div class="col-md-8">
                            <p class="input-group">
                                <input type="text" class="form-control" uib-datepicker-popup ng-model="to_date"
                                       name="to_date" is-open="popup2.opened" ng-required="true" close-text="Close"/>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="open2()"><i
                                                class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                {{csrf_field()}}
                <button class="btn btn-primary">Xuất CSV</button>
            </div>
        </form>
        <div class="row">
            <div class="pull-right">
                <input type="hidden" ng-init="api_token='{{Session::token()}}'" ng-model="api_token" name="_token">
                <button class="btn btn-primary" ng-click="onSearch()">Tìm kiếm</button>
                <button class="btn" ng-click="onClear()">Clear</button>
            </div>
        </div>
        <div class="row">
            <div>
                <div ui-grid="gridOptions" ui-grid-pagination class="myGrid"></div>
            </div>
        </div>
    </div>
@endsection