@extends('layouts.master')
@section('script_and_style')
    <!-- css for view 'detail_project' -->
    <link href="{{URL::to('/css/projectDetail.css')}}" rel="stylesheet">
    <script src="{{URL::to('js/controller/project_detail.js')}}"></script>
@endsection
@section('header_title')
    {{ucfirst($project->name)}}
@endsection
@section('content')
    <div ng-controller="ProjectDetailController">
        <form action="{{route('projects.apply_get',['project_id' => $project->id])}}" method="get" id="formDK">
            <input type="hidden" ng-init="project_id={{$project->id}}" ng-model="project_id">
            <div class="row project-information" style="height: 200px">
                <div class="col-xs-5 col-sm-5 col-md-3 col-lg-3" style="padding-left: 80px;">
                    <div>
                        <img src="{{$company_logo}}" width="180" height="180" class="companyimg"/>
                    </div>
                </div>
                <div class="col-xs-3 col-sm-3 col-md-1 col-lg-1 padding" style="text-align: center">
                    <br>
                    <div><span class="fa fa-bookmark-o fa-lg"></span></div>
                    <br>
                    <div><span class="fa fa-map-marker fa-lg"></span><br></div>
                    <br>
                    <div><span class="fa fa-clock-o fa-lg"></span><br></div>
                    <br>
                    <div><span class="fa fa-briefcase fa-lg"></span><br></div>
                    <br>
                </div>
                <div class="col-xs-5 col-sm-5 col-md-3 col-lg-3 padding" style="font-weight: bold">
                    <br>
                    <div>
                        Dự án #{{$project->id}}
                    </div>
                    <br>
                    <div>
                        Tp. Hồ Chí Minh, Quận 1
                    </div>
                    <br>
                    <div>
                        {{$project->length}} tháng
                    </div>
                    <br>
                    <div>
                        @if($project->type==1)
                            Fulltime
                        @else
                            Parttime
                        @endif
                    </div>
                </div>
                <div class="col-xs-3 col-sm-3 col-md-1 col-lg-1 padding" style="text-align: center">
                    <br>
                    <div>
                        <span class="fa fa-users fa-lg"></span></div>
                    <br>
                    <div>
                        <span class="fa fa-address-book fa-lg"></span></div>
                    <br>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 padding" style="font-weight: bold">
                    <br>
                    <div>
                        Từ {{$project->need_min}} đến {{$project->need_max}} người
                    </div>
                    <br>
                    <div>
                        Có {{$project->num_of_joined}}/{{$project->num_of_applied}} sinh viên đã được chấp nhập
                    </div>
                    <br><br>
                    @if(Auth::guest())

                    @elseif(Auth::user()->isStudent())
                        @if(isset($result))
                            @if($result == 10)
                                <button type="submit" class="btn btn-default btn-lg"
                                        style="background-color: cornflowerblue;color: white;padding-right: 15px;"
                                        disabled>Đang chờ xét duyệt
                                </button>
                                <button type="button" class="btn btn-default btn-lg" ng-click="onCancel($event)">Hủy đăng ký</button>
                            @elseif($result == 11)
                                <button type="button" class="btn btn-success btn-lg" ng-click="onNeedConfirm($event)">Xác nhận tham gia
                                </button>
                                <button type="button" class="btn btn-default btn-lg" ng-click="onCancel($event)">Hủy đăng ký</button>
                            @elseif($result == 12)
                                <button type="button" class="btn btn-info btn-lg" disabled>Đang tham gia</button>
                            @elseif($result ==13)
                                <button type="submit" class="btn btn-default btn-lg"
                                        style="background-color: dimgrey;color: white" disabled>Cần cố gắng hơn nhé
                                </button>
                            @elseif($result ==14)
                                <button type="submit" class="btn btn-default btn-lg">Đăng ký tham gia</button>
                            @endif
                        @else
                            <button type="submit" class="btn btn-default btn-lg">Đăng ký tham gia</button>
                        @endif

                    @elseif(Auth::user()->isLecture())
                        <button type="button" class="btn btn-default btn-lg btnNominate" ng-click="onNominate($event)">Đề cử sinh viên</button>
                    @endif

                    <input type="hidden" name='project_id' value="{{$project->id}}">
                    @if(!Auth::guest())
                        <input type="hidden" name='student_id' value="{{$stuid=Auth::user()->id}}">
                    @endif
                </div>
            </div>
        </form>

        <!-- Mô tả -->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1">
                <legend><h3>Mô tả</h3></legend>
                <div class="info">
                    {!!  nl2br(e($project->intro)) !!}
                </div>
            </div>
        </div>
        <!--Yêu cầu -->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1">
                <legend><h3>Yêu cầu</h3></legend>
                <div class="info">
                    {!!  nl2br(e($project->requirement)) !!}
                </div>
            </div>
        </div>
        <!--Điểm cộng -->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1">
                <legend><h3>Điểm cộng</h3></legend>
                <div class="info">
                    {!!  nl2br(e($project->plus_point)) !!}
                </div>
            </div>
        </div>
        @if(Auth::guest())

        @else
            <div class="row" ng-init="is_guest = false">
                <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 col-sm-offset-1 col-xs-offset-1">
                    <legend><h3>Danh sách sinh viên đã đăng ký</h3></legend>
                    <div ui-grid="gridOptions" ui-grid-pagination></div>
                </div>
            </div>
        @endif
    </div>
    {{--cancel register--}}
    <script type="text/ng-template" id="cancel-modal.html">
        <div class="modal-header">
            <h4 class="modal-title">Hủy đăng ký</h4>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-group">
                    <label for="post-body">Bạn có chắc chắn hủy đăng ký dự án này không?</label>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" ng-click="onConfirm()" id="modal-delete">Chắc chắn</button>
            <button type="button" class="btn btn-default" data-dismiss="modal" ng-click="cancel()">Hủy bỏ</button>
        </div>
    </script>

    {{--confirm register--}}
    <script type="text/ng-template" id="confirm-modal.html">
        <div class="modal-header">
            <h4 class="modal-title">Xác nhận tham gia</h4>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-group">
                    <label for="post-body">Bạn có chắc chắc tham gia dự án này không?</label>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="modal-confirm" ng-click="onConfirm()">Xác nhận</button>
            <button type="button" class="btn btn-default" ng-click="cancel()">Hủy bỏ</button>
        </div>
    </script>

    <script>
        var token = '{{Session::token()}}';
        var project_url = '{{ route('projects.get_detail', ['project_id' => $project->id]) }}';
        var urlCancel = '{{route('postCancelRegister',['project_id'=>$project->id])}}';
        var urlConfirm = '{{route('postConfirmRegister',['project_id'=>$project->id])}}';
    </script>

    <script type="text/ng-template" id="nominate-modal.html">
        <form id="contact-form" class="form-horizontal ajax" role="form" action="{{route('projects.nominateStudent',['project_id' => $project->id])}}" method="post">
            <div class="modal-header">
                <h4>Đề cử sinh viên cho dự án<a class="close" data-dismiss="modal">x</a></h4>
            </div>
            <div class="modal-body" id="modal-body-id">
                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="contact-email" class="col-sm-2 control-label">E-mail:</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" name="email" multiple pattern="^([\w+-.%]+@[\w-.]+\.[A-Za-z]{2,4},*[\W]*)+$" value="" id="contact-email" placeholder="mail1@example.com, mail2@example.com">
                    </div>
                </div>
                <div class="form-group">
                    <label for="contact-msg" class="col-sm-2 control-label">Message:</label>
                    <div class="col-sm-10">
                        <textarea name="message" placeholder="Type your message..." id="contact-message" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" value="1" name="submit" type="submit" id="submit">Send Message</button>
                <a class="btn btn-default" data-dismiss="modal" ng-click="cancel()">Close</a>
            </div>
            <input type="hidden" value="{{Session::token()}}" name="_token">
        </form>
    </script>

@endsection
