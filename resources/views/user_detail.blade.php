@extends('layouts.master')
@section('script_and_style')
    <!-- css for view 'user_detail'-->
    <link href="{{URL::to('/css/user_detail.css')}}" rel="stylesheet">
    <script src="{{URL::to('js/controller/user_detail.js')}}"></script>
@endsection
@section('header_title')
    THÔNG TIN SINH VIÊN
@endsection
@section('content')
    @if(count($errors)>0)
        <div class="row">
            <div class="col-md-6 col-md-offset-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>
                            {{$error}}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    <div class="body-container">
        <input type="hidden" ng-init="init({{$student_profile['id']}})" ng-controller="UserIntroduction">
        <div class="row" style="background:white">
            <!-- left column -->
            <div id="avatar-rating" class="cold-lg-4 col-md-5 col-sm-12 col-xs-12">
                <div class="text-center">
                    <img id="avatar" name="avatar" src="{{$student_profile['avatar_path']}}"
                         class="avatar img-circle img-thumbnail"
                         alt="avatar">
                </div>
                <div class="text-center">
                    <span style="font-size: 25px;">
                        @for($i =0; $i<5 ; $i ++)
                            @if($i < $student_profile['rating'])
                                <i class="fa fa-star fa-lg" aria-hidden="true" style="color: #3399cc"></i>
                            @else
                                <i class="fa fa-star fa-lg" aria-hidden="true" style="color: silver"></i>
                            @endif
                        @endfor
                    </span>
                    <div id="uploadAvatar">
                        <input id="file" name="file" type="file" class="text-center center-block well well-sm"
                               accept="image/x-png,image/jpeg">
                        <p id="changeAvatar" class="btn-toolbar" style="color: red;text-align: center" hidden>Bấm lưu để
                            áp dụng hình
                            mới</p>
                    </div>
                </div>
            </div>
            <!-- edit form column -->
            <div id="info" class="cold-lg-8 col-md-7 col-sm-12 col-xs-12 personal-info" ng-controller="UserInformation">
                <h1 class="header-title" style="position:relative">
                    <span>Thông tin cá nhân</span>
                    @if($is_current_user == \App\Libraries\GeneralConstant::IS_CURRENT_USER)
                        <i id="editUserInformation" class="glyphicon glyphicon-pencil pull-right main-text-color"
                           style="font-size: 0.5em; cursor:pointer"></i>
                        <i id="saveUserInformation" ng-click="saveUserInformation()"
                           class="glyphicon glyphicon-save pull-right main-text-color"
                           style="font-size: 0.5em; cursor:pointer"></i>
                    @endif
                </h1>
                <form class="form-horizontal user-detail-information-form" role="form">
                    <div class="form-group">
                        <label class="cold-lg-3 col-md-3 col-sm-2 col-xs-2">Họ tên</label>
                        <div class="cold-lg-4 col-md-4 col-sm-5 col-xs-5">
                            <p id="name">{{$student_profile['name']}}</p>
                        </div>
                        <label class="cold-lg-2 col-md-2 col-sm-2 col-xs-2">Giới tính</label>
                        <div class="cold-lg-3 col-md-3 col-sm-3 col-xs-3">
                            @if($student_profile['gender'] == \App\Libraries\GeneralConstant::IS_FEMALE)
                                <p id="gender">Nữ</p>
                                <p id="genderNum" hidden>1</p>
                            @else
                                <p id="gender">Nam</p>
                                <p id="genderNum" hidden>0</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="cold-lg-3 col-md-3 col-sm-2 col-xs-2">Ngày sinh</label>
                        <div class="cold-lg-4 col-md-4 col-sm-5 col-xs-5">
                            <p id="birthday">{{$student_profile['birthday']}}</p>
                        </div>
                        <label class="cold-lg-2 col-md-2 col-sm-2 col-xs-2">Điện thoại</label>
                        <div class="cold-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <p id="telNum">{{$student_profile['phone']}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="cold-lg-3 col-md-3 col-sm-2 col-xs-2">Địa chỉ</label>
                        <div class="cold-lg-9 col-md-9 col-sm-10 col-xs-10">
                            <p id="addNum">{{$student_profile['address']}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="cold-lg-3 col-md-3 col-sm-2 col-xs-2">Trường</label>
                        <div class="cold-lg-4 col-md-4 col-sm-5 col-xs-5">
                            <p id="university">{{$student_profile['university_name']}}</p>
                        </div>

                        <label class="cold-lg-2 col-md-2 col-sm-2 col-xs-2">Khóa</label>
                        <div class="cold-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <p id="academicYear">{{$student_profile['academic_year']}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="cold-lg-3 col-md-3 col-sm-2 col-xs-2">Khoa</label>
                        <div class="cold-lg-4 col-md-4 col-sm-5 col-xs-5">
                            <p id="faculty">{{$student_profile['faculty_name']}}</p>
                        </div>
                        <label class="cold-lg-2 col-md-2 col-sm-2 col-xs-2">GPA</label>
                        <div class="cold-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <p id="gpa">{{$student_profile['gpa']}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="cold-lg-3 col-md-3 col-sm-2 col-xs-2">Chuyên ngành</label>
                        <div class="cold-lg-9 col-md-9 col-sm-10 col-xs-10">
                            <p id="major">{{$student_profile['major_name']}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="cold-lg-3 col-md-3 col-sm-2 col-xs-2">Email</label>
                        <div class="cold-lg-9 col-md-9 col-sm-10 col-xs-10">
                            <p id="email">{{$student_profile['email']}}</p>
                        </div>
                    </div>
                </form>
            </div>

            <div id="introduction" ng-controller="UserIntroduction">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h1 class="header-line" style="position:relative; margin-bottom:0.7em"><span>Giới thiệu</span>
                        @if($is_current_user == \App\Libraries\GeneralConstant::IS_CURRENT_USER)
                            <i id="editUserIntroduction" class="glyphicon glyphicon-pencil pull-right main-text-color"
                               style="font-size: 0.5em; cursor:pointer"></i>
                            <i id="saveUserIntroduction" ng-click="saveUserIntroduction()"
                               class="glyphicon glyphicon-save pull-right main-text-color"
                               style="font-size: 0.5em; cursor:pointer"></i>
                        @endif
                    </h1>

                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="info">
                        <p id="intro" style="text-align: center">{{$student_profile['intro']}}</p>
                    </div>
                </div>
            </div>
            <div id="job-introduction" ng-controller="UserIntroduction">
                <div class="cold-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h1 class="header-line" style="position:relative; margin-bottom:0.7em">
                        <span>Thông tin CV</span>
                        <i class="glyphicon glyphicon-cog pull-right main-text-color" style="cursor:pointer"
                           ng-click="settingCV()"></i>
                    </h1>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <table id="table_dom" class="table user-detail-table" width="100%">
                        <thead>
                        <tr>
                            <th>
                                STT
                            </th>
                            <th>
                                Tên CV(Vị trí ứng tuyển)
                            </th>
                            <th>
                                Upload lúc
                            </th>
                            <th>
                                Lần chỉnh sửa gần nhất
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($cvs as $index => $cv)
                            <tr>
                                <td>
                                    {{$index}}
                                </td>
                                <td>
                                    <strong>{{$cv['name']}}</strong>
                                </td>
                                <td>
                                    {{$cv['created_at']}}
                                </td>
                                <td>
                                    {{$cv['updated_at']}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="company-rating">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h1 class="header-line"><span>Đánh giá của doanh nghiệp</span></h1>
                </div>
                <div class="user-detail-company-rating col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    @foreach($companies as $company)
                        <div class="rating-element col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
                                <img src="{{$company['avatar']}}">
                            </div>
                            <div class="col-lg-6 col-md-5 col-sm-5 col-xs-8">
                                <h2>{{$company['project_name']}}</h2>
                                <h3>{{$company['company_name']}}</h3>
                            </div>
                            <div class="col-lg-4 col-md-5 col-sm-4 col-xs-6 pull-right">
                           <span>
                                @for($i =0; $i<5 ; $i ++)
                                   @if($i < $company['rating'])
                                       <i class="fa fa-star fa-lg fa-fixed" aria-hidden="true"
                                          style="color: #3399cc"></i>
                                   @else
                                       <i class="fa fa-star fa-lg fa-fixed" aria-hidden="true"
                                          style="color: silver"></i>
                                   @endif
                               @endfor
                            </span>
                                <p class="text-info" style="text-align: center"> {{$company['updated_at']}} </p>
                            </div>
                            <div class="col-lg-11 col-lg-offset-1 col-md-11 col-md-offset-1 col-sm-12 col-xs-12">
                                <p>{{$company['body']}}</p>
                            </div>
                            <hr class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1
                            col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1">
                        </div>
                    @endforeach
                </div>
            </div>

            <div id="lecturer-comment">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h1 class="header-line"><span>Đánh giá của giảng viên</span></h1>
                </div>
                <div class="user-detail-company-rating col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    @foreach($lecturers as $lecturer)
                        <div>
                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
                                <img src="{{$lecturer['avatar_path']}}" class="companyimg">
                            </div>
                            <div class="col-lg-6 col-md-5 col-sm-5 col-xs-8">
                                <h3>{{$lecturer['name']}}</h3>
                                <h4>{{$lecturer['university_name']}}</h4>
                                <h4>{{$lecturer['url']}}</h4>
                            </div>
                            <div class="col-lg-4 col-md-5 col-sm-4 col-xs-6 pull-right">
                            <span>
                                @for($i =0; $i<5 ; $i ++)
                                    @if($i < $lecturer['rating'])
                                        <i class="fa fa-star fa-lg fa-fixed" aria-hidden="true"
                                           style="color: #3399cc"></i>
                                    @else
                                        <i class="fa fa-star fa-lg fa-fixed" aria-hidden="true"
                                           style="color: silver"></i>
                                    @endif
                                @endfor
                            </span>
                                <p class="text-info" style="text-align: center"> {{$lecturer['updated_at']}} </p>
                            </div>
                            <div class="col-lg-11 col-lg-offset-1 col-md-11 col-md-offset-1 col-sm-12 col-xs-12">
                                <p>{{$lecturer['body']}}</p>
                            </div>
                            <hr class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1
                            col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1">
                        </div>
                    @endforeach
                </div>
                @if(isset($current_user) && ($current_user['role_id'] == \App\Libraries\GeneralConstant::LECTURER_ROLE ||
                 $current_user['role_id'] == \App\Libraries\GeneralConstant::AGENT_ROLE))
                    <div class="user-detail-company-rating col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-12 col-xs-12"
                             style="border: solid 1px darkgray">
                            <div style="margin-top: 15px">
                                <div class="col-lg-2 col-md-3 col-sm-3 col-xs-3">
                                    <img src="{{$current_user['avatar_path']}}" class="companyimg">
                                </div>
                                <div class="col-lg-4 col-md-9 col-sm-9 col-xs-9">
                                    <h3>{{$current_user['name']}}</h3>
                                    <h4>{{$current_user['university_name']}}</h4>
                                    @if(isset($current_user['faculty_name']))
                                        <h4>{{$current_user['faculty_name']}}</h4>
                                    @endif
                                </div>
                                <form role="form" method="POST"
                                      action="{{ route('comment_user_detail', $current_user_id)}}">
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 pull-right">
                                        <fieldset class="rating">
                                            <input type="radio" id="star5" name="rating" value="5"/>
                                            <label class="full" for="star5" title="Tuyệt vời - 5 điểm"></label>
                                            <input type="radio" id="star4" name="rating" value="4"/>
                                            <label class="full" for="star4" title="Khá giỏi - 4 điểm"></label>
                                            <input type="radio" id="star3" name="rating" value="3" checked/>
                                            <label class="full" for="star3" title="Bình thường - 3 điểm"></label>
                                            <input type="radio" id="star2" name="rating" value="2"/>
                                            <label class="full" for="star2" title="Không tốt - 2 điểm"></label>
                                            <input type="radio" id="star1" name="rating" value="1"/>
                                            <label class="full" for="star1" title="Rất tệ - 1 điểm"></label>
                                        </fieldset>
                                    </div>
                                    {{ csrf_field() }}
                                    <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11
                                     col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-offset-1"
                                         style="margin-top: 2%;margin-bottom: 30px">
                                        <textarea class="form-control" rows="3" name="body"
                                                  style="resize: none;" title=""></textarea>
                                        <button type="submit" class="btn btn-primary pull-right"
                                                style="margin-top: 5px">
                                            Comment
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script>
    </script>
@endsection
