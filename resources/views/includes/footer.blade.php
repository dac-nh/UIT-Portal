<div id="footer">
    <div class="row" id="footer_content">
        <div class="col-md-4 text-center">
            <h4 style="color:whitesmoke;">&copy; Copyright 2016. All right reserved.</h4>
        </div>
        <div class="col-md-3">
            <h4>
                <a href="{{ url('/') }}">Giới thiệu</a>
            </h4>
            <h4>
                <a href="{{ url('/') }}">Công ty tài trợ</a>
            </h4>
            <h4>
                <a href="{{ url('/') }}">Công ty đang tham gia</a>
            </h4>
        </div>
        <div class="col-md-2">
            <h4>
                <a href="{{ url('/') }}">Dự án</a>
            </h4>
            <h4>
                <a href="{{ url('/') }}">Doanh nghiệp</a>
            </h4>
            <h4>
                <a href="{{ url('/') }}">Sinh viên</a>
            </h4>
        </div>
        <div class="col-md-3">
            <h4>
                <a href="{{ route('sign_up') }}">Đăng ký thành viên</a>
            </h4>
            <h4>
                <a href="{{ url('/') }}">Liên hệ</a>
            </h4>
        </div>
    </div>
</div>
<style>
    #footer {
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
    }

    #footer_content {
        height: 150px; /* Height of the footer */
        background: #333;
    }

    #footer a {
        color: whitesmoke;
    }
</style>