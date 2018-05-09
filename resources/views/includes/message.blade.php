{{--/**--}}
{{--* Created by PhpStorm.--}}
{{--* User: Dark Wolf--}}
{{--* Date: 11/11/2016--}}
{{--* Time: 2:47 PM--}}
{{--*/--}}
<!--11/10/2016: Dac-->
<div id="messages">
    @if(Session::has('message_success'))
        <div class="animated fadeOut  col-md-6 col-md-offset-3 alert alert-success alert-dismissible" role="alert"
             style="text-align: center;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            {{Session::get('message_success')}}
        </div>
    @endif
    @if(Session::has('message_info'))
        <div class="animated fadeOut col-md-6 col-md-offset-3 alert alert-info alert-dismissible" role="alert"
             style="text-align: center;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            {{Session::get('message_info')}}
        </div>
    @endif
    @if(Session::has('message_warning'))
        <div class="animated fadeOut col-md-6 col-md-offset-3 alert alert-warning alert-dismissible" role="alert"
             style="text-align: center;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            {{Session::get('message_warning')}}
        </div>
    @endif
    @if(Session::has('message_danger'))
        <div class="animated fadeOut col-md-6 col-md-offset-3 alert alert-danger alert-dismissible" role="alert"
             style="text-align: center;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            {{Session::get('message_danger')}}
        </div>
    @endif
</div>

<style>

    .animated {
        -webkit-animation-duration: 5s;
        animation-duration: 5s;
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both;
    }

    @-webkit-keyframes fadeOutLeft {
        0% {
            opacity: 1;
            -webkit-transform: translateX(0);
        }
        100% {
            opacity: 0;
            -webkit-transform: translateX(-20px);
        }
    }

    @keyframes fadeOutLeft {
        0% {
            opacity: 1;
            transform: translateX(0);
        }
        100% {
            opacity: 0;
            transform: translateX(-20px);
        }
    }

    @-webkit-keyframes fadeOut {
        0% {
            opacity: 1;
        }
        100% {
            opacity: 0;
        }
    }

    @keyframes fadeOut {
        0% {
            opacity: 1;
        }
        100% {
            opacity: 0;
        }
    }

    .fadeOutLeft {
        -webkit-animation-name: fadeOutLeft;
        animation-name: fadeOutLeft;
    }

    .fadeOut {
        -webkit-animation-name: fadeOut;
        animation-name: fadeOut;
    }
</style>

<script>
    setTimeout(function () {
        $('#messages').hide();
    }, 5000);
</script>

@if(count($errors) > 0)
    <div class="row">
        <div class="col-md-4 col-md-offset-4 error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif