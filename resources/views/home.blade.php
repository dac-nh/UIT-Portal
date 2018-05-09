@extends('layouts.master')
@section('script_and_style')
    <script src="{{URL::to('js/controller/carousel.js')}}"></script>
    <script src="{{URL::to('js/controller/home.js')}}"></script>
@endsection
@section('content')
    @include('image_carousel')
    <div class="body-container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-7">
                <div class="form-group">
                    <a href="{{route('getHiringProjectsView')}}" style="float:right;margin-top:10px;">Xem tất cả</a>
                    <legend><h3>Các dự án mới nhất</h3></legend>
                </div>
                <div id="new_projects" ng-controller="HomeController">
                    <table class="table-hover">
                        @foreach($new_projects as $project)
                            <tr role="button" style="height: 150px;max-height: 150px" ng-click="onNewProjectClick({{$project->id}})">
                                <td width="20%">
                                    <img src="{{$project->getCompanyLogo()}}"
                                         height="90x" width="90px" style="margin:15px">
                                </td>
                                <td width="60%">
                                    <h3 style="color:#0067AF">{{$project->name}}</h3>
                                    <div style="width:100%;word-wrap: break-word;padding-right: 20px;height: 40px;overflow:hidden;">{{$project->intro}}</div>
                                </td>
                                <td width="20%">
                                    <div>
                                        <i class="fa fa-map-marker fa-lg" aria-hidden="true"></i>
                                        {{$project->address_id}}
                                    </div>
                                    <div>
                                        <i class="fa fa-clock-o fa-lg" aria-hidden="true"></i>
                                        {{$project->length}} tuần
                                    </div>
                                    <div>
                                        <i class="fa fa-users fa-lg" aria-hidden="true"></i>
                                        {{$project->need_min}}-{{$project->need_max}} sinh viên
                                    </div>
                                    <div>
                                        <i class="fa fa-suitcase fa-lg" aria-hidden="true"></i>
                                        @if($project->type == 0)
                                            Fulltime
                                        @else
                                            Partime
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="col-md-3">
                @include('top_students')
            </div>
        </div>
        <div class="row">
            <div style="position:absolute;margin-left: 5%;width: 72%;background: black;height: 0.5px"></div>
            <div style="margin-bottom: 50px;" class="col-md-10 col-md-offset-1">
                <h3 style="color: #216290;" class="text-center">TOP 3 DOANH NGHIỆP</h3>
                <table style="width: 100%;">
                    <tr>
                        <td width="33%">
                            <div class="col-md-2">
                                <img src="{{$top_companies[0]['logo']}}" height="80px" width="80px">
                            </div>
                            <div class="col-md-8 text-center">
                                <a href="">
                                    <h4>{{$top_companies[0]['name']}}</h4>
                                </a>
                                <span>
                                        @for($i =0; $i<5 ; $i ++)
                                        @if($i < $top_companies[0]['rating'])
                                            <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                                        @else
                                            <i class="fa fa-star-o fa-lg" aria-hidden="true"></i>
                                        @endif
                                    @endfor
                                    </span>
                            </div>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td width="33%">
                            <div class="col-md-2">
                                <img src="{{$top_companies[1]['logo']}}" height="80px" width="80px">
                            </div>
                            <div class="col-md-8 text-center">
                                <a href="">
                                    <h4>{{$top_companies[1]['name']}}</h4>
                                </a>
                                <span>
                                @for($i =0; $i<5 ; $i ++)
                                        @if($i < $top_companies[1]['rating'])
                                            <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                                        @else
                                            <i class="fa fa-star-o fa-lg" aria-hidden="true"></i>
                                        @endif
                                    @endfor
                            </span>
                            </div>
                        </td>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td width="33%">
                            <div class="col-md-2">
                                <img src="{{$top_companies[2]['logo']}}" height="80px" width="80px">
                            </div>
                            <div class="col-md-8 text-center">
                                <a href="">
                                    <h4>{{$top_companies[2]['name']}}</h4>
                                </a>
                                <span>
                                @for($i =0; $i<5 ; $i ++)
                                        @if($i < $top_companies[2]['rating'])
                                            <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                                        @else
                                            <i class="fa fa-star-o fa-lg" aria-hidden="true"></i>
                                        @endif
                                    @endfor
                            </span>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection

