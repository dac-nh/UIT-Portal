@extends('layouts.master')
@section('script_and_style')
    <script src="{{URL::to('/js/ui-bootstrap-tpls-2.2.0.min.js')}}"></script>
    <script src="{{URL::to('js/controller/show_filter_stulist.js')}}"></script>
@endsection
@section('header_title')
    Bảng xếp hạng sinh viên
@endsection

@section('content')
    <div class="container" ng-controller="StudentListController">
        <div class="row">
            <div class="col-md-3" style="text-align: left;">
                @if(Auth::guest())

                @elseif(Auth::user()->isStudent())
                    <button type="button" class="btn btn-default btn-md" ng-click="onSearchMe()">Hạng của tôi</button>
                    <input type="hidden" ng-init="user_id={{Auth::user()->id}}" ng-model="user_id" name="user_id">
                @endif
            </div>
            <div class="col-md-7" style="padding: 0px;">
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
            <div class="col-md-2" style="padding: 0px;">
                <form class="navbar-form pull-left" role="filter" style="margin-top: 0px;">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit" id="button_filter"><i
                                    class="glyphicon glyphicon-filter"></i></button>
                    </div>
                </form>
                <form class="navbar-form pull-left" style="margin-top: 0px;padding-left: 0px;">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit" ng-click="clear()"><i
                                    class="glyphicon glyphicon-remove"></i></button>
                    </div>
                </form>
            </div>
        </div>

        <div style="padding-left:210px;width: 900px;">
            <div class="row"
                 style="background: lightgrey; height:50px;border-radius: 10px;margin-left: -0px;margin-right: 0px;width: 900px;margin-bottom: 15px;"
                 hidden="hidden" id="filterSL">
                <div class=" col-md-5 form-group" style="padding: 10px;margin-bottom: 0px;">
                    <label class="mainlabel" for="hometown"
                           style="margin-right: 0px;padding-left: 25px;padding-right: 10px;">Trường</label>
                    <select class="selectpicker" name="university_name" ng-model="university_name"
                            ng-options="item.name for item in universityOptions track by item.id"
                            style="width: 250px;"></select>
                </div>
                <div class="col-md-2 form-group"
                     style="padding:0px;padding-top:10px;padding-bottom:10px;margin-bottom: 0px;">
                    <label class="mainlabel" for="hometown" style="margin-right: 0px;width: 90px;">Đánh giá từ</label>
                    <input id="rate_from" type="text" style="width: 50px;" ng-model="rating_from">
                    <span class="glyphicon glyphicon-star form-control-feedback"
                          style="padding-top: 11px;color: burlywood;top: -32px; right: -124px;"></span>
                </div>


                <div class=" col-md-2 form-group" style="padding:0px;padding-top:10px;margin-bottom: 0px;">
                    <label class="mainlabel" for="hometown" style="margin-right: 0px;padding-left: 25px;width: 80px;">đến</label>
                    <input id="rate_to" type="text" style="width: 50px;" ng-model="rating_to">
                    <span class="glyphicon glyphicon-star form-control-feedback"
                          style="padding-top: 11px;padding-right: 25px;color: burlywood;top: -32px; right: -114px;"></span>
                </div>

                <div class="col-md-2" style="padding:10px;text-align:center;">
                    <form>
                        <button type="submit" id="ApDung" class="btn btn-default btn-sm" ng-click="onSearch()">Áp dụng
                        </button>
                    </form>
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