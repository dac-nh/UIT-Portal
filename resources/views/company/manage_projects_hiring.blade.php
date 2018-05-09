@extends('layouts.master')
@section('script_and_style')
    <script src="{{URL::to('js/controller/manage_projects_hiring.js')}}"></script>
@endsection
@section('header_title')
    {{ucfirst($project->name)}}
@endsection
@section('content')
    <div class="container" ng-controller="ManageProjectsHiringController">
        <input type="hidden" ng-model="project_id" ng-init="project_id={{$project->id}}">
        <div class="row project-information" style="height: 200px">
            <div class="col-md-1" style="text-align: center">
                <br>
                <div><span class="fa fa-bookmark-o fa-lg"></span></div>
                <br>
                <div><span class="fa fa-map-marker fa-lg"></span><br></div>
                <br>
                <div><span class="fa fa-clock-o fa-lg"></span><br></div>
                <br>
            </div>
            <div class="col-md-3" style="font-weight: bold">
                <br>
                <div>
                    Dự án #{{$project->id}}
                </div>
                <br>
                <div>
                    {{$project->address_id}}
                </div>
                <br>
                <div>
                    {{$project->length}} tuần
                </div>
            </div>
            <div class="col-md-1" style="text-align: center">
                <br>
                <div><span class="fa fa-briefcase fa-lg"></span><br></div>
                <br>
                <div>
                    <span class="fa fa-users fa-lg"></span></div>
                <br>
                <div>
                    <span class="fa fa-address-book fa-lg"></span></div>
                <br>
            </div>
            <div class="col-md-3" style="font-weight: bold">
                <br>
                <div>
                    @if($project->type==1)
                        Fulltime
                    @else
                        Parttime
                    @endif
                </div>
                <br>
                <div>
                    Từ {{$project->need_min}} đến {{$project->need_max}} người
                </div>
                <br>
                <div>
                    <input type="hidden" ng-model="num_of_joined" ng-init="num_of_joined = {{$project->num_of_joined}}">
                    <input type="hidden" ng-model="num_of_applied" ng-init="num_of_applied = {{$project->num_of_applied}}">
                    Có <label>{{$project->num_of_joined}}</label>/<label>{{$project->num_of_applied}}</label> sinh viên đã được chấp nhập
                    {{--Có <label><%num_of_joined%></label>/<label><%num_of_applied%></label> sinh viên đã được chấp nhập--}}
                </div>
            </div>
            <div class="col-md-4" style="text-align: center">
                <br>
                <br>
                <form action="{{route('projects.get_detail',['project_id' => $project->id])}}" method="get">
                    <button class="btn btn-primary btn-lg">Chi tiết dự án</button>
                </form>
            </div>
        </div>
        <div class="row">
            <legend><h3 style="color: #216290;">Danh sách sinh viên chờ xét duyệt</h3></legend>
            <div ui-grid="gridOptions2" ui-grid-pagination class="preview-grid"></div>
        </div>
        <div class="row">
            <legend><h3 style="color: #216290;">Danh sách sinh viên đã xét duyệt</h3></legend>
            <div ui-grid="gridOptions3" ui-grid-pagination class="preview-grid"></div>
        </div>
        {{--<uib-accordion close-others="false">--}}
            {{--<div uib-accordion-group class="panel-default" is-open="isOpen2">--}}
                {{--<uib-accordion-heading>--}}
                    {{--<h3 style="color: #216290;">Danh sách sinh viên chờ xét duyệt<i class="pull-right glyphicon"--}}
                                                            {{--ng-class="{'glyphicon-chevron-down': isOpen2, 'glyphicon-chevron-right': !isOpen2}"></i>--}}
                    {{--</h3>--}}
                {{--</uib-accordion-heading>--}}
                {{--<div ui-grid="gridOptions2" ui-grid-pagination class="preview-grid"></div>--}}
            {{--</div>--}}
            {{--<div uib-accordion-group class="panel-default" is-open="isOpen3">--}}
                {{--<uib-accordion-heading>--}}
                    {{--<h3 style="color: #216290;">Danh sách sinh viên đã xét duyệt<i class="pull-right glyphicon"--}}
                                                           {{--ng-class="{'glyphicon-chevron-down': isOpen3, 'glyphicon-chevron-right': !isOpen3}"></i>--}}
                    {{--</h3>--}}
                {{--</uib-accordion-heading>--}}
                {{--<div ui-grid="gridOptions3" ui-grid-pagination class="preview-grid"></div>--}}
            {{--</div>--}}
        {{--</uib-accordion>--}}
    </div>
    <script type="text/ng-template" id="ConfirmRejectModal.html">
        <div class="modal-header">
            <h3 class="modal-title" id="modal-title">Xác nhận từ chối</h3>
        </div>
        <div class="modal-body" id="modal-body">
            Bạn có chắc chắn muốn từ chối <%student_name%>
            <div>
                Nội dung :
                <textarea class="form-control" ng-model="email_content" style="resize: none;"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" type="button" ng-click="ok()">Xác nhận</button>
            <button class="btn btn-warning" type="button" ng-click="cancel()">Hủy</button>
        </div>
    </script>
    <script type="text/ng-template" id="ConfirmJoinModal.html">
        <div class="modal-header">
            <h3 class="modal-title" id="modal-title">Xác nhận</h3>
        </div>
        <div class="modal-body" id="modal-body">
            Tới : <%student_name%>
            <div>
                Nội dung :
                <textarea class="form-control" ng-model="email_content" style="resize: none;"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" type="button" ng-click="ok()">Gửi</button>
            <button class="btn btn-warning" type="button" ng-click="cancel()">Hủy</button>
        </div>
    </script>
@endsection
