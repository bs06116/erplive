@extends('layouts.auth2')

@section('title', __('lang_v1.reset_password'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7 fullscreen-md d-flex justify-content-center align-items-center overlay bg-img "
                     style="background-image: url('{{asset('new/img/login_bg.jpg')}}');background-repeat: no-repeat;background-size:cover                       " >
                    <div class="img">   <img src="/new/img/erp_logo_login.png" class="logo"  alt=""></div>

                    <div class="content">
                        <h5 class="add">How to add Users</h5>
                        <div class="option" id="p">
                            <ol class="ol1">
                                <li> User Management->Users->Add new</li>
                                <li> Fill the user details, Select user role, give a unique user name.</li>
                                <li> Sales Commission Percentage(%): Provide the commission % <br> for this user. This option gets applied its commission</li>
                            </ol>
                        </div>
                        <div class="d-flex flex-column fb ">
                            <nav class="nav mb-4"><a id="l1" class="btn btn-circle  me-2" href="#"><i
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
        <p  style=" margin-top: -130px;margin-bottom: 80px;margin-left: 115px;font-weight: 500"> Grow your business with us </p>
         <div class="form-group has-icon has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
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
