@extends('layouts.master')
@section('script_and_style')
    <script src="{{URL::to('js/controller/manage_company.js')}}"></script>
@endsection
@section('header_title')
    Trang Quản Lý Đại Diện Công Ty
@endsection
@section('content')
    <div ng-controller="ManageCompanyController">
        <input type="hidden" ng-model="company_id" ng-init="company_id={{$company->id}}">
        <div class="row">
            <div class="col-md-12">
                <h1 class="header-line"><span>Thông tin cá nhân</span>
                    <i class="glyphicon glyphicon-pencil pull-right main-text-color" style="cursor:pointer"></i>
                </h1>
            </div>
            <table style="width: 100%">
                <tr>
                    <td style="text-align: center" width="30%">
                        <img src="{{$company_logo}}" height="150px" width="150px">
                    </td>
                    <td width="60%">
                        <div>
                            <h3>{{$company->name}}</h3>
                        </div>
                        <div>
                            <h4>Địa chỉ : {{$company->address}}</h4>
                        </div>
                        <div>
                            <h4>Website : {{$company->url}}</h4>
                        </div>
                        <div>
                            <h4>Điện thoại : {{$company->phone}}</h4>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        {{--<div class="row">--}}
            {{--<div class="col-md-12">--}}
                {{--<a href="{{route('getHiringProjectsView')}}" style="float:right;margin-top:25px">Xem tất cả</a>--}}
                {{--<legend><h3>Danh sách các dự án đang tuyển</h3></legend>--}}
                {{--<div class="col-md-10 col-md-offset-1">--}}
                    {{--<div ui-grid="gridOptions1" class="preview-grid"></div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="row">--}}
            {{--<div class="col-md-12">--}}
                {{--<a href="{{route('getInProgressProjectsView')}}" style="float:right;margin-top:25px">Xem tất cả</a>--}}
                {{--<legend><h3>Danh sách các dự án đang thực hiện</h3></legend>--}}
                {{--<div class="col-md-10 col-md-offset-1">--}}
                    {{--<div ui-grid="gridOptions2" class="preview-grid"></div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="row">--}}
            {{--<div class="col-md-12">--}}
                {{--<a href="{{route('getFinishedProjectsView')}}" style="float:right;margin-top:25px">Xem tất cả</a>--}}
                {{--<legend><h3>Danh sách các dự án đã hoàn thành</h3></legend>--}}
                {{--<div class="col-md-10 col-md-offset-1">--}}
                    {{--<div ui-grid="gridOptions3" class="preview-grid"></div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        <uib-accordion close-others="false">
            <div uib-accordion-group class="panel-default" is-open="isOpen1">
                <uib-accordion-heading>
                    <h3 style="color: #216290;">Danh sách các dự án đang tuyển<i class="pull-right glyphicon"
                                                                                 ng-class="{'glyphicon-chevron-down': isOpen1, 'glyphicon-chevron-right': !isOpen1}"></i>
                    </h3>
                </uib-accordion-heading>
                <div ui-grid="gridOptions1" class="preview-grid"></div>
                <a href="{{route('getHiringProjectsView')}}" style="float:right;margin-top:25px">Xem tất cả</a>
            </div>
            <div uib-accordion-group class="panel-default" is-open="isOpen2">
                <uib-accordion-heading>
                    <h3 style="color: #216290;">Danh sách các dự án đang thực hiện<i class="pull-right glyphicon"
                                                                                    ng-class="{'glyphicon-chevron-down': isOpen2, 'glyphicon-chevron-right': !isOpen2}"></i>
                    </h3>
                </uib-accordion-heading>
                <div ui-grid="gridOptions2" class="preview-grid"></div>
                <a href="{{route('getInProgressProjectsView')}}" style="float:right;margin-top:25px">Xem tất cả</a>
            </div>
            <div uib-accordion-group class="panel-default" is-open="isOpen3">
                <uib-accordion-heading>
                    <h3 style="color: #216290;">Danh sách các dự án đã hoàn thành<i class="pull-right glyphicon"
                                                                                   ng-class="{'glyphicon-chevron-down': isOpen3, 'glyphicon-chevron-right': !isOpen3}"></i>
                    </h3>
                </uib-accordion-heading>
                <div ui-grid="gridOptions3" class="preview-grid"></div>
                <a href="{{route('getFinishedProjectsView')}}" style="float:right;margin-top:25px">Xem tất cả</a>
            </div>
        </uib-accordion>
    </div>
@endsection
<style>
    .preview-grid {
        height: 200px;
    }
</style>