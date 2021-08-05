@extends('layouts.auth2')
@section('title', __('lang_v1.login'))
@section('content')
<main>
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6 col-lg-7 fullscreen-md d-flex justify-content-center align-items-center overlay bg-img block1"
                style="background-image: url('{{asset('new/img/login_bg.jpg')}}');background-repeat: no-repeat;background-size:cover  ;                     " >
            <div class="img">
                <img src="{{asset('new/img/erp_logo_white_new.png')}}" class="logo"  alt=""></div>
                <div class="content">
                    <h2 class="a7">
                    </h2>
                    <div class="option2">
                        <p class="ol1 text_d">
                        </p>
                    </div>
                    <div class="d-flex flex-column fb ">
                        <nav class="nav mb-4"><a id="l1" class="btn btn-circle  me-2" href="#"><i
                                    class="fab fa-facebook-f  "></i></a> <a id="l2"
                                class="btn btn-circle me-2" href="#"><i
                                    class="fab fa-twitter"></i></a> <a id="l3" class="btn btn-circle "
                                href="#"><i class="fab fa-linkedin"></i></a></nav>
                    </div>
                </div>
            </div>
            @php
            $username = old('username');
            $password = null;
            if(config('app.env') == 'demo'){
                $username = 'admin';
                $password = '123456';

                $demo_types = array(
                    'all_in_one' => 'admin',
                    'super_market' => 'admin',
                    'pharmacy' => 'admin-pharmacy',
                    'electronics' => 'admin-electronics',
                    'services' => 'admin-services',
                    'restaurant' => 'admin-restaurant',
                    'superadmin' => 'superadmin',
                    'woocommerce' => 'woocommerce_user',
                    'essentials' => 'admin-essentials',
                    'manufacturing' => 'manufacturer-demo',
                );

                if( !empty($_GET['demo_type']) && array_key_exists($_GET['demo_type'], $demo_types) ){
                    $username = $demo_types[$_GET['demo_type']];
                }
            }
        @endphp

            <div class="col-md-5 col-lg-4 mx-auto">
                <div class="login-form mt-5 mt-md-0">
                    <h1 class="text-darker bold x1">Login</h1>
                    <p id="t5" style=" margin-top: -130px;margin-bottom: 80px;font-weight: 500"> Grow your business with us </p>
                    <form class="form cozy" action="{{ route('login') }}"   method="POST" id="login-form" data-validate-on="submit" novalidate>
                        {{ csrf_field() }}

                        <div class="form-group has-icon input5"><input type="text" id="login_username"
                            name="username" value="{{ $username }}" required class="form-control form-control-rounded"
                                placeholder="Your registered username" required> <i class="icon fas fa-user"></i>
                        </div>
                        @if ($errors->has('username'))
                                <p style="margin-left: 25px;margin-top: -25px" class="is-invalid error">{{ $errors->first('username') }}</p>
                        @endif
                        <div class="form-group has-icon input5"><input  type="password" id="login_password"
                            name="password"
                            value="{{ $password }}" required class="form-control form-control-rounded"
                                placeholder="Your password" required> <i class="icon fas fa-lock"></i></div>
                                @if ($errors->has('password'))
                                    <p style="margin-left: 25px;margin-top: -25px" class="is-invalid error">{{ $errors->first('password') }}</p>
                            @endif
                        <div class="form-group d-flex align-items-center justify-content-between"><a id="f"
                                href="{{ route('password.request') }}"  style="font-size: 13px;font-weight: 500;color:#0276F6;">Forgot password?</a>
                            <div class="ajax-button">
                                <div class="fas fa-check btn-status text-success success"></div>
                                <div class="fas fa-times btn-status text-danger failed "></div><button  type="submit"
                                     class="btn  btn-rounded login1">Login </button>
                            </div>
                        </div>
                        <p class="paragraph">Don't have an account yet?     <a class="sign"  href="{{ route('business.getRegister') }}">Sign Up Now</a></p>
                    </form>
                    </div>
                 </div>
        </div>
    </div>
</main>

    {{-- <div class="login-form col-md-12 col-xs-12 right-col-content">
        <p class="form-header text-white">@lang('lang_v1.login')</p>
        <form method="POST" action="{{ route('login') }}" id="login-form">
            {{ csrf_field() }}
            <div class="form-group has-feedback {{ $errors->has('username') ? ' has-error' : '' }}">
                @php
                    $username = old('username');
                    $password = null;
                    if(config('app.env') == 'demo'){
                        $username = 'admin';
                        $password = '123456';

                        $demo_types = array(
                            'all_in_one' => 'admin',
                            'super_market' => 'admin',
                            'pharmacy' => 'admin-pharmacy',
                            'electronics' => 'admin-electronics',
                            'services' => 'admin-services',
                            'restaurant' => 'admin-restaurant',
                            'superadmin' => 'superadmin',
                            'woocommerce' => 'woocommerce_user',
                            'essentials' => 'admin-essentials',
                            'manufacturing' => 'manufacturer-demo',
                        );

                        if( !empty($_GET['demo_type']) && array_key_exists($_GET['demo_type'], $demo_types) ){
                            $username = $demo_types[$_GET['demo_type']];
                        }
                    }
                @endphp
                <input id="username" type="text" class="form-control" name="username" value="{{ $username }}" required autofocus placeholder="@lang('lang_v1.username')">
                <span class="fa fa-user form-control-feedback"></span>
                @if ($errors->has('username'))
                    <span class="help-block">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                <input id="password" type="password" class="form-control" name="password"
                value="{{ $password }}" required placeholder="@lang('lang_v1.password')">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> @lang('lang_v1.remember_me')
                    </label>
                </div>
            </div>
            <br>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-flat btn-login">@lang('lang_v1.login')</button>
                @if(config('app.env') != 'demo')
                <a href="{{ route('password.request') }}" class="pull-right">
                    @lang('lang_v1.forgot_your_password')
                </a>
            @endif
            </div>
        </form>
    </div>
    @if(config('app.env') == 'demo')
    <div class="col-md-12 col-xs-12" style="padding-bottom: 30px;">
        @component('components.widget', ['class' => 'box-primary', 'header' => '<h4 class="text-center">Demo Shops <small><i> Demos are for example purpose only, this application <u>can be used in many other similar businesses.</u></i></small></h4>'])

            <a href="?demo_type=all_in_one" class="btn btn-app bg-olive demo-login" data-toggle="tooltip" title="Showcases all feature available in the application." data-admin="{{$demo_types['all_in_one']}}"> <i class="fas fa-star"></i> All In One</a>

            <a href="?demo_type=pharmacy" class="btn bg-maroon btn-app demo-login" data-toggle="tooltip" title="Shops with products having expiry dates." data-admin="{{$demo_types['pharmacy']}}"><i class="fas fa-medkit"></i>Pharmacy</a>

            <a href="?demo_type=services" class="btn bg-orange btn-app demo-login" data-toggle="tooltip" title="For all service providers like Web Development, Restaurants, Repairing, Plumber, Salons, Beauty Parlors etc." data-admin="{{$demo_types['services']}}"><i class="fas fa-wrench"></i>Multi-Service Center</a>

            <a href="?demo_type=electronics" class="btn bg-purple btn-app demo-login" data-toggle="tooltip" title="Products having IMEI or Serial number code."  data-admin="{{$demo_types['electronics']}}" ><i class="fas fa-laptop"></i>Electronics & Mobile Shop</a>

            <a href="?demo_type=super_market" class="btn bg-navy btn-app demo-login" data-toggle="tooltip" title="Super market & Similar kind of shops." data-admin="{{$demo_types['super_market']}}" ><i class="fas fa-shopping-cart"></i> Super Market</a>

            <a href="?demo_type=restaurant" class="btn bg-red btn-app demo-login" data-toggle="tooltip" title="Restaurants, Salons and other similar kind of shops." data-admin="{{$demo_types['restaurant']}}"><i class="fas fa-utensils"></i> Restaurant</a>
            <hr>

            <i class="icon fas fa-plug"></i> Premium optional modules:<br><br>

            <a href="?demo_type=superadmin" class="btn bg-red-active btn-app demo-login" data-toggle="tooltip" title="SaaS & Superadmin extension Demo" data-admin="{{$demo_types['superadmin']}}"><i class="fas fa-university"></i> SaaS / Superadmin</a>

            <a href="?demo_type=woocommerce" class="btn bg-woocommerce btn-app demo-login" data-toggle="tooltip" title="WooCommerce demo user - Open web shop in minutes!!" style="color:white !important" data-admin="{{$demo_types['woocommerce']}}"> <i class="fab fa-wordpress"></i> WooCommerce</a>

            <a href="?demo_type=essentials" class="btn bg-navy btn-app demo-login" data-toggle="tooltip" title="Essentials & HRM (human resource management) Module Demo" style="color:white !important" data-admin="{{$demo_types['essentials']}}">
                    <i class="fas fa-check-circle"></i>
                    Essentials & HRM</a>

            <a href="?demo_type=manufacturing" class="btn bg-orange btn-app demo-login" data-toggle="tooltip" title="Manufacturing module demo" style="color:white !important" data-admin="{{$demo_types['manufacturing']}}">
                    <i class="fas fa-industry"></i>
                    Manufacturing Module</a>

            <a href="?demo_type=superadmin" class="btn bg-maroon btn-app demo-login" data-toggle="tooltip" title="Project module demo" style="color:white !important" data-admin="{{$demo_types['superadmin']}}">
                    <i class="fas fa-project-diagram"></i>
                    Project Module</a>

            <a href="?demo_type=services" class="btn btn-app demo-login" data-toggle="tooltip" title="Advance repair module demo" style="color:white !important; background-color: #bc8f8f" data-admin="{{$demo_types['services']}}">
                    <i class="fas fa-wrench"></i>
                    Advance Repair Module</a>

            <a href="{{url('docs')}}" target="_blank" class="btn btn-app" data-toggle="tooltip" title="Advance repair module demo" style="color:white !important; background-color: #2dce89">
                    <i class="fas fa-network-wired"></i>
                    Connector Module / API Documentation</a>
        @endcomponent
    </div>
    @endif --}}
@stop

@section('javascript')

@endsection
