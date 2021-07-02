@extends('layouts.auth2')

@section('title', __('lang_v1.reset_password'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7 fullscreen-md d-flex justify-content-center align-items-center overlay bg-img "
                     style="background-image: url('{{asset('new/img/login_bg.jpg')}}');background-repeat: no-repeat;background-size:cover                       " >
                    <div class="img3"><img src="/new/img/erp_logo_login.png" class="logo"  alt=""></div>

                    <div class="content b1">
                        <h5 class="a7" id="b2"></h5>
                        <div class="option" id="p">
                            <p class="ol1 text_d">
                            </p>
                        </div>
                        <div class="d-flex flex-column fb3">
                            <nav class="nav mp8"><a id="l1" class="btn btn-circle  me-2" href="#"><i
                                            class="fab fa-facebook-f  "></i></a> <a id="l2"
                                                                                    class="btn btn-circle me-2" href="#"><i
                                            class="fab fa-twitter"></i></a> <a id="l3" class="btn btn-circle "
                                                                               href="#"><i class="fab fa-linkedin-in"></i></a></nav>
                        </div>
                    </div>
                </div>
<div class="login-form col-md-5 col-lg-4 mt-5 mt-md-0">
    <form  method="POST" action="{{ route('password.email') }} ">
        {{ csrf_field() }}
        <h1 class="text-darker x5">Reset Password</h1>
        <p id="y1"  style=" margin-top: -140px;margin-bottom: 80px;font-weight: 500"> Grow your business with us </p>
         <div class="form-group has-icon has-feedback {{ $errors->has('email') ? ' has-error' : '' }}  email">
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="@lang('lang_v1.email_address')">
            <i class="icon fas fa-envelope email1 "></i>
        </div>
        @if ($errors->has('email'))
            <span class="help-block ero">
                    {{ $errors->first('email') }}
                </span>
        @endif
        <br>
        <div class="form-group">
            <button type="submit" class="btn btn-rounded btn-block btn-flat login2">
                @lang('lang_v1.send_password_reset_link')
            </button>
        </div>
    </form>
</div>
            </div>
        </div>
    </main>
@endsection
