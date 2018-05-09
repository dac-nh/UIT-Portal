<nav id="header" class="navbar navbar-default navbar-static-top" style="margin-bottom: 0px">
    <div class="row" id="header-content">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li>
                        <a class="navbar-header" href="{{ url('/') }}">
                            Giới Thiệu
                        </a>
                    </li>
                    <li>
                        <a class="navbar-header" href="{{ route('getListStudent') }}">
                            Sinh Viên
                        </a>
                    </li>
                    <li>
                        <a class="navbar-header" href="{{ route('getListCompany') }}">
                            Doanh Nghiệp
                        </a>
                    </li>
                    <li>
                        <a class="navbar-header" href="{{ Route('getHiringProjectsView') }}">
                            Dự Án
                        </a>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right" style="background-color: #39c">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('sign_in') }}">Đăng Nhập</a></li>
                        <li><a href="{{ route('sign_up') }}">Đăng Ký</a></li>
                    @else
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false" style="background-color: #39c">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu" style="background-color: #39c">
                                <li>
                                    <a href="{{route('get_current_user_detail', Auth::user()->id)}}">
                                        Thông tin tài khoản
                                    </a>
                                </li>
                                @if(Auth::user()->role_id == \App\Libraries\GeneralConstant::AGENT_ROLE)
                                    <li>
                                        <a href="/manage-uni">
                                            Trang quản lý
                                        </a>
                                    </li>
                                @endif
                                @if(Auth::user()->role_id == \App\Libraries\GeneralConstant::STUDENT_ROLE)
                                    <li>
                                        <a href="/manage-student">
                                            Trang quản lý
                                        </a>
                                    </li>
                                @endif
                                @if(Auth::user()->role_id == \App\Libraries\GeneralConstant::COMPANY_ROLE)
                                    <li>
                                        <a href="/manage-company">
                                            Trang quản lý
                                        </a>
                                    </li>
                                @endif
                                @if(Auth::user()->role_id == \App\Libraries\GeneralConstant::LECTURER_ROLE)
                                    <li>
                                        <a href="/manage-lecturer">
                                            Trang quản lý
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{ route('sign_out') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Đăng xuất
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</nav>
<style>
    #header-content {
        background: #369;
    }

    #header a {
        color: whitesmoke;
    }

    .dropdown-menu > li > a:hover {
        background-color: #369;
        background-image: none;
    }
</style>