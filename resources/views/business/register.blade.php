@extends('layouts.auth2')
@section('title', __('lang_v1.register'))

@section('content')
    {{-- <div class="login-form col-md-12 col-xs-12 right-col-content-register">

    <p class="form-header text-white">@lang('business.register_and_get_started_in_minutes')</p> --}}
    <main>

        <div class="container-fluid">
            <div class="row align-items-center ">
                <div class="col-md-6 col-lg-7 fullscreen-md d-flex justify-content-center align-items-center overlay alpha-8 image-background cover"
                     style=" background-image: url('{{asset('new/img/login_bg.jpg')}}');background-repeat: no-repeat;background-size:cover                       " >
                    <div class="img2">   <img src="{{asset('new/img/erp_logo_white_new.png')}}" class="logo logo1" alt="Responsive image"></div>
                    <div class="content d1">
                        <h2 class="a7" id="a5">
                        </h2>
                        <div class="option2 d2">
                            <p class="ol1 text_d">
                            </p>
                        </div>
                        <div class="d-flex flex-column fb2" style="">
                            <nav class="nav am-3"><a id="z1" class="btn btn-circle me-2" href="#"><i
                                        class="fab fa-facebook-f"></i></a> <a id="z2"
                                    class="btn btn-circle me-2" href="#"><i
                                        class="fab fa-twitter"></i></a> <a id="z3" class="btn btn-circle"
                                    href="#"><i class="fab fa-linkedin"></i></a></nav>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-lg-4 mx-auto">
                    <div class="register-form mt-5 mt-md-0">
                        <h1 class="text-darker bold t1">Sign Up Here</h1>
                        <p id="t2"> Grow your business with us </p>
                                @if($errors->any())
                                <div class="alert alert-danger">
                                    <p><strong>Opps Something went wrong</strong></p>
                                    <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                    </ul>
                                </div>
                            @endif
                        {!! Form::open(['url' => route('business.postRegister'), 'method' => 'post', 'id' => 'business_register_form', 'class'=>'cozy', 'files' => true]) !!}
                        @include('business.partials.register_form')
                        {!! Form::hidden('package_id', $package_id) !!}
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </main>
@stop
@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#change_lang').change(function() {
                window.location = "{{ route('business.getRegister') }}?lang=" + $(this).val();
            });
        })

    </script>
@endsection
