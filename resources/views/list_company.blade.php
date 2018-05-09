@extends('layouts.master')
@section('script_and_style')
    <script src="{{URL::to('/js/ui-bootstrap-tpls-2.2.0.min.js')}}"></script>
    <script src="{{URL::to('js/controller/show_filter_complist.js')}}"></script>
@endsection
@section('header_title')
    Danh sách các doanh nghiệp
@endsection

@section('content')
    <div class="container" ng-controller="CompanyListController">
        <div class="row">
            <div class="col-md-8" style="text-align: left;">

            </div>
            <div class="col-md-4" style="padding: 0px;">
                <div class="form-group pull-right">
                    <div class="input-group">
                        <input class="form-control" id="text" type="text" placeholder="Search" name="searchStudentName"
                               style="width: 300px;" ng-model="name" ng-change="onSearch()">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i>
                            </button>
                            <input type="hidden" value="{{Session::token()}}" name="_token">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div>
                <div ui-grid="gridOptions" ui-grid-pagination class="myGrid" style="height: 500px"></div>
            </div>
        </div>
    </div>
@endsection