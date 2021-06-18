@extends('layouts.auth2')
@section('title', __('lang_v1.register'))

@section('content')
    {{-- <div class="login-form col-md-12 col-xs-12 right-col-content-register">

    <p class="form-header text-white">@lang('business.register_and_get_started_in_minutes')</p> --}}
    <main>

        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7 fullscreen-md d-flex justify-content-center align-items-center overlay overlay-primary alpha-8 image-background cover"
                    style="background-image:url(https://picsum.photos/1920/1200/?random&gravity=south)">
                    <div class="content">
                        <h2 class="display-4 display-md-3 display-lg-2 text-contrast mt-4 mt-md-0">Get started with
                            <span class="bold d-block">ERP</span>
                        </h2>
                        <p class="lead text-contrast">Software That Can Think! Empowered Your Business .</p>
                        <hr class="mt-md-6 w-25">
                        <div class="d-flex flex-column">
                            <p class="small bold text-contrast">Or sign up with</p>
                            <nav class="nav mb-4"><a class="btn btn-circle btn-outline-contrast me-2" href="#"><i
                                        class="fab fa-facebook-f"></i></a> <a
                                    class="btn btn-circle btn-outline-contrast me-2" href="#"><i
                                        class="fab fa-twitter"></i></a> <a class="btn btn-circle btn-outline-contrast"
                                    href="#"><i class="fab fa-linkedin-in"></i></a></nav>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-lg-4 mx-auto">
                    <div class="register-form mt-5 mt-md-0"><img src="img/logo.png" class="logo img-responsive mb-4 mb-md-6"
                            alt="">
                        <h1 class="text-darker bold">Register</h1>
                        <p class="text-secondary mb-4 mb-md-6">Already have an account? <a href="login.html"
                                class="text-primary bold">Login here</a></p>
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
