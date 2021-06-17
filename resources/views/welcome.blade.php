@extends('layouts.home')
@section('title', config('app.name', 'ultimatePOS'))

@section('content')


<main class="position-relative overflow-hidden">
    <!-- ./Page header -->
    <header class="header alter2-header section parallax image-background center-bottom cover overlay overlay-primary alpha-8 text-contrast" style="background-image: url({{asset('new/img/bg/grid.jpg')}})">
        <!-- <div class="divider-shape">
            waves divider <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none" class="shape-waves" style="left: 0; transform: rotate3d(0,1,0,180deg);">
                <path class="shape-fill shape-fill-contrast" d="M790.5,93.1c-59.3-5.3-116.8-18-192.6-50c-29.6-12.7-76.9-31-100.5-35.9c-23.6-4.9-52.6-7.8-75.5-5.3c-10.2,1.1-22.6,1.4-50.1,7.4c-27.2,6.3-58.2,16.6-79.4,24.7c-41.3,15.9-94.9,21.9-134,22.6C72,58.2,0,25.8,0,25.8V100h1000V65.3c0,0-51.5,19.4-106.2,25.7C839.5,97,814.1,95.2,790.5,93.1z" /></svg></div> -->
        <div class="container overflow-hidden">
            <div class="row">
                <div class="col-md-7 banner-heading">
                    <h1 class="text-contrast bold">A Software that can think </h1>
                    <p class="lead">Grow Your Business mainfolds with <br> ERP by PITS</p>
                    <nav class="nav mt-5"><a href="#" class="me-3 btn btn btn-rounded btn-contrast"><i class="fas fa-tag me-3"></i> Plans & pricing </a><a href="#" class="btn btn-rounded btn-success text-contrast">Start now</a></nav>
                </div>
            </div>
        </div>
    </header><!-- ./Perspective mockups -->
    <section class="perspective-mockups hidden-preload">
        <div class="tablet ipad landscape">
            <div class="screen"><img src="{{asset('new/img/screens/tablet/1.png')}}" alt="..."></div>
            <div class="button"></div>
        </div>
        <div class="phone-big iphone-x">
            <div class="screen"><img src="{{asset('new/img/screens/app/1.png')}}" alt="..."></div>
            <div class="notch"></div>
        </div>
        <div class="phone-small iphone-x">
            <div class="screen"><img src="{{asset('new/img/screens/app/2.png')}}" alt="..."></div>
            <div class="notch"></div>
        </div>
        <div class="tablet ipad portrait">
            <div class="screen"><img src="{{asset('new/img/screens/tablet/2.png')}}" alt="..."></div>
            <div class="button"></div>
        </div>
    </section><!-- ./Lightweight HTML - text overview -->
    <section class="section lightweight-template">
        <div class="container">
            <div class="row align-items-center text-center text-lg-start">
                <div class="col-md-8 col-lg-6 me-auto">
                    <h2>Lightweight HTML template great for your product</h2>
                    <p class="lead text-muted">Suspendisse dignissim lorem vel elit dapibus mattis. Etiam magna nunc, maximus bibendum diam et, porttitor.</p>
                    <a href="#" class="btn btn-info btn-rounded mt-4 learn-more text-contrast1">Learn More</a>
                </div>
            </div>
        </div>
    </section><!-- ./Tools for everyone - Swiper -->
    <section class="section b-b b-t bg-light">
        <div class="container">
            <div class="section-heading text-center"><i data-feather="sliders" width="36" height="36" class="stroke-primary"></i>
                <h2 class="bold">Tools for everyone</h2>
                <p class="lead text-muted">Get ready in no time... just like 1, 2 & 3.</p>
            </div>
            <div class="row align-items-end">
                <div class="col-lg-4">
                    <h2 class="bold">Start the right way<br><span class="light">Start with ERP</span></h2>
                    <p class="lead text-secondary">Thinking about a new project? Start in no time with the tools ERP brings to you.</p><a href="pricing.html" class="btn btn-primary btn-rounded mt-4">Choose the right plan <i class="ms-3 fas fa-long-arrow-alt-right"></i></a>
                    <ol id="sw-nav-tools" class="nav nav-process nav-circle nav-justified mt-5">
                        <li class="nav-item active"><a class="nav-link" href="#" data-step="1"><small class="mt-4 absolute">Inbox</small></a></li>
                        <li class="nav-item"><a class="nav-link" href="#" data-step="2"><small class="mt-4 absolute">Calendar</small></a></li>
                        <li class="nav-item"><a class="nav-link" href="#" data-step="3"><small class="mt-4 absolute">Invoicing</small></a></li>
                        <li class="nav-item"><a class="nav-link" href="#" data-step="4"><small class="mt-4 absolute">Reporting</small></a></li>
                    </ol>
                </div>
                <div class="col-lg-7 ml-lg-auto">
                    <div class="browser shadow mt-4 mt-md-0" data-aos="fade-left">
                        <div class="swiper-container" data-sw-navigation="#sw-nav-tools">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide"><img src="{{asset('new/img/screens/dash/1.png')}}" alt="" class="img-responsive"></div>
                                <div class="swiper-slide"><img src="{{asset('new/img/screens/dash/2.png')}}" alt="" class="img-responsive"></div>
                                <div class="swiper-slide"><img src="{{asset('new/img/screens/dash/3.png')}}" alt="" class="img-responsive"></div>
                                <div class="swiper-slide"><img src="{{asset('new/img/screens/dash/4.png')}}" alt="" class="img-responsive"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- ./Every thing you need - Tabs -->
    <section class="section">
        <div class="container">
            <div class="section-heading text-center">
                <h2 class="bold">Everything you need - all in one theme</h2>
            </div>
            <nav class="slide nav nav-tabs nav-outlined nav-rounded justify-content-around justify-content-md-center mb-5"><a class="nav-item nav-link active" data-bs-toggle="tab" href="#dashboard-tab">Dashboard</a> <a class="nav-item nav-link" data-bs-toggle="tab" href="#tasks-tab">Invoicing</a> <a class="nav-item nav-link" data-bs-toggle="tab" href="#calendar-tab">Calendar</a> <a class="nav-item nav-link" data-bs-toggle="tab" href="#inbox-tab">Inbox</a></nav>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="dashboard-tab">
                    <div class="row gap-y align-items-center">
                        <div class="col-md-6 me-md-auto">
                            <div class="browser shadow" data-aos="fade-end"><img src="{{asset('new/img/screens/dash/4.png')}}" class="img-responsive" alt=""></div>
                        </div>
                        <div class="col-md-5" style="margin-right: 55px;">
                            <p class="rounded-pill py-2 px-4 bold badge badge-info">New feature</p>
                            <h2 class="display-4 light">Dashboard</h2>
                            <p>When buying ERP you will get right in your hand a powerful tool to boost your design. You will get not just a template but a complete ready-to-use HTML code snippets to start right away with your project.</p>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tasks-tab">
                    <div class="row gap-y align-items-center">
                        <div class="col-md-6 order-md-2 ms-md-auto">
                            <div class="browser shadow" data-aos="fade-start"><img src="{{asset('new/img/screens/dash/3.png')}}" alt="" class="img-responsive"></div>
                        </div>
                        <div class="col-md-5 me-md-auto">
                            <h2 class="display-4 light">Invoicing</h2>
                            <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore maxime numquam perspiciatis saepe totam.</p>
                            <hr class="mt-5">
                            <p class="small text-secondary">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium aspernatur atque dolor dolorem ea esse expedita hic iste laboriosam libero nihil nostrum obcaecati, odio qui reprehenderit sint vel veniam voluptatibus.</p>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="calendar-tab">
                    <div class="row gap-y align-items-center">
                        <div class="col-md-6 me-md-auto position-relative">
                            <div class="browser shadow-box" data-aos="fade-end"><img src="{{asset('new/img/screens/dash/2.png')}}" alt="" class="img-responsive"></div><img src="img/screens/dash/2.1.png" alt="" class="absolute img-responsive shadow rounded" style="right: 0; top: 0">
                        </div>
                        <div class="col-md-5">
                            <h2 class="display-4 light">Calendar</h2>
                            <p class="lead text-secondary">Calendar plugin included and beautified</p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias atque cum, delectus dicta doloribus enim fuga hic itaque modi nobis pariatur porro quasi ratione repellat sint veniam veritatis voluptas voluptates.</p>
                        </div>
                    </div>
                </div>
                <!-- <div class="tab-pane fade" id="inbox-tab">
                    <div class="row gap-y align-items-center">
                        <div class="col-md-6 order-md-2 ms-md-auto">
                            <div class="browser shadow" data-aos="fade-start"><img src="img/screens/dash/1.png" alt="" class="img-responsive"></div>
                        </div>
                        <div class="col-md-5">
                            <p class="rounded-pill py-2 px-4 bold badge badge-info">Outstanding</p>
                            <h2 class="display-4 light">Inbox</h2>
                            <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. A ab, accusantium aliquid dolore dolorem excepturi exercitationem fugiat incidunt iure nesciunt nihil non numquam perferendis quaerat quisquam rem saepe sunt temporibus.</p>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </section><!-- ./Single testimonial - Left -->
    <section class="singl-testimonial shadow">
        <div class="container-fluid py-0">
            <div class="row align-items-center gradient gradient-primary-dark text-contrast">
                <div class="col-md-3 mx-auto py-4 py-md-0">
                    <p class="badge bg-contrast text-dark shadow rounded-pill py-2 px-4 text-uppercase mb-0">ERP is great for</p>
                    <p class="font-md bold mt-1 text-contrast">Anyone who is looking for a great startup template</p>
                    <hr class="my-4">
                    <div class="small text-contrast"><span class="bold d-block">Lorem Inc. Team,</span> Doing great since 2018</div>
                </div>
                <div class="col-12 col-md-7 image-background cover" style="background-image: url({{asset('new/img/testimonials/1.jpg')}});"></div>
            </div>
        </div>
    </section><!-- ./Top-notch appearance - Big Screen Left -->
    <section class="section">
        <div class="container-wide">
            <div class="section-heading text-center">
                <p class="rounded-pill py-2 px-4 bold badge badge-info">Built to Last</p>
                <h2>What you will get with ERP</h2>
                <p class="lead text-secondary">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna</p>
            </div>
            <div class="row gap-y align-items-center">
                <div class="col-10 col-lg-4 mx-auto">
                    <div class="row gap-y text-center text-md-start">
                        <div class="col-md-6"><i data-feather="pie-chart" width="36" height="36" class="stroke-primary mb-3"></i>
                            <p class="my-0 bold lead text-dark">Dashboard</p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed do eiusmod tempor.</p>
                        </div>
                        <div class="col-md-6"><i data-feather="dollar-sign" width="36" height="36" class="stroke-primary mb-3"></i>
                            <p class="my-0 bold lead text-dark">Save money</p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed do eiusmod tempor.</p>
                        </div>
                        <div class="col-md-6"><i data-feather="sliders" width="36" height="36" class="stroke-primary mb-3"></i>
                            <p class="my-0 bold lead text-dark">Design tools</p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed do eiusmod tempor.</p>
                        </div>
                        <div class="col-md-6"><i data-feather="download" width="36" height="36" class="stroke-primary mb-3"></i>
                            <p class="my-0 bold lead text-dark">Updates</p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed do eiusmod tempor.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 pe-0"><img src="{{asset('new/img/screens/dash/2.png')}}" alt="" class="img-responsive shadow" data-aos="fade-left"></div>
            </div>
        </div>
    </section><!-- ./Lightweight HTML - Big Screen Right -->
    <div class="section">
        <div class="container-wide bring-to-front">
            <div class="row gap-y align-items-center">
                <div class="col-12 col-lg-6 ps-0 position-relative">
                    <div class="device-twin free-width align-items-center mt-4 mt-lg-0">
                        <div class="browser shadow" data-aos="fade-end"><img src="{{asset('new/img/screens/dash/4.png')}}" alt="..."></div>
                        <div class="front iphone-x absolute d-none d-sm-block" data-aos="fade-up" data-aos-delay=".5" style="right: 0; bottom: -1.5rem;">
                            <div class="screen"><img src="{{asset('new/img/screens/app/1.png')}}" alt="..."></div>
                            <div class="notch"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-5 mx-auto">
                    <div class="section-heading"><span class="bold py-2"><i data-feather="bar-chart" class="stroke-primary me-2"></i> <span class="bold text-info">Dashboard included</span></span>
                        <h2 class="mt-3">Every thing you need to get started</h2>
                        <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna</p>
                    </div>
                    <p>Nullam vitae scelerisque est, sed tempus metus. Donec convallis volutpat enim consequat viverra. Nam blandit est eu ipsum elementum, ac pellentesque nibh placerat. Quisque venenatis pulvinar nulla, non vestibulum urna ultrices accumsan.</p><a href="#" class="btn px-4 btn-rounded btn-primary mt-4">Learn more</a>
                </div>
            </div>
        </div>
    </div><!-- ./Brands -->
    <section class="section bg-light edge top-right">
        <div class="container">
            <h4 class="bold text-center mb-5">They trust us</h4>
            <div class="row gap-y">
                <div class="col-md-3 col-xs-4 col-6 px-md-5"><img src="{{asset('new/img/logos/1.png')}}" alt="" class="img-responsive mx-auto op-7" style="max-height: 60px;"></div>
                <div class="col-md-3 col-xs-4 col-6 px-md-5"><img src="{{asset('new/img/logos/2.png')}}" alt="" class="img-responsive mx-auto op-7" style="max-height: 60px;"></div>
                <div class="col-md-3 col-xs-4 col-6 px-md-5"><img src="{{asset('new/img/logos/3.png')}}" alt="" class="img-responsive mx-auto op-7" style="max-height: 60px;"></div>
                <div class="col-md-3 col-xs-4 col-6 px-md-5"><img src="{{asset('new/img/logos/4.png')}}" alt="" class="img-responsive mx-auto op-7" style="max-height: 60px;"></div>
            </div>
        </div>
    </section><!-- ./FAQs -->
    <section class="section bg-light edge bottom-right">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h2>Do you have <span class="bold">questions?</span></h2>
                    <p class="lead">Not sure how this template can help you? Wonder why you need to buy our theme?</p>
                    <p class="text-muted">Here are the answers to some of the most common questions we hear from our appreciated customers</p>
                </div>
                <div class="col-md-8">
                    <div class="accordion accordion-clean" id="faqs-accordion">
                        <div class="card mb-3">
                            <div class="card-header"><a href="#" class="card-title btn" data-bs-toggle="collapse" data-bs-target="#v1-q1"><i class="fas fa-angle-down angle"></i> What does the package include?</a></div>
                            <div id="v1-q1" class="collapse show" data-bs-parent="#faqs-accordion">
                                <div class="card-body">When you buy ERP, you get all you see in the demo but the images. We include SASS files for styling, complete JS files with comments, all HTML variations. Besides we include all mobile PSD mockups.</div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header"><a href="#" class="card-title btn collapsed" data-bs-toggle="collapse" data-bs-target="#v1-q2"><i class="fas fa-angle-down angle"></i> What is the typical response time for a support question?</a></div>
                            <div id="v1-q2" class="collapse" data-bs-parent="#faqs-accordion">
                                <div class="card-body">Since you report us a support question we try to make our best to find out what is going on, depending on the case it could take more or les time, however a standard time could be minutes or hours.</div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header"><a href="#" class="card-title btn collapsed" data-bs-toggle="collapse" data-bs-target="#v1-q3"><i class="fas fa-angle-down angle"></i> What do I need to know to customize this template?</a></div>
                            <div id="v1-q3" class="collapse" data-bs-parent="#faqs-accordion">
                                <div class="card-body">Our documentation give you all you need to customize your copy. However you will need some basic web design knowledge (HTML, Javascript and CSS)</div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header"><a href="#" class="card-title btn collapsed" data-bs-toggle="collapse" data-bs-target="#v1-q4"><i class="fas fa-angle-down angle"></i> Can I suggest a new feature?</a></div>
                            <div id="v1-q4" class="collapse" data-bs-parent="#faqs-accordion">
                                <div class="card-body">Definitely <span class="bold">Yes</span>, you can contact us to let us know your needs. If your suggestion represents any value to both we can include it as a part of the theme or you can request a custom build by an extra cost. Please note it could take some time in order for the feature to be implemented.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- ./CTA - Start Now -->
    <section class="section bg-contrast">
        <div class="container bring-to-front bring-to-front">
            <div class="shadow rounded text-center bg-dark p-5">
                <div class="text-contrast"><i class="fa fa-heart fa-2x mb-3"></i>
                    <h2 class="mb-5 text-contrast">Try ERP now... Love it forever!</h2>
                    <p class="handwritten highlight font-md">Why wait? Start now!</p>
                </div><a href="signup.html" class="btn btn-success text-contrast btn-rounded mt-4">Buy ERP on Themeforest</a>
            </div>
        </div>
    </section><!-- ./CTA - Create Account -->
    <section class="section">
        <div class="container">
            <div class="d-flex align-items-center flex-column flex-md-row">
                <div class="text-center text-md-start">
                    <p class="light mb-0 text-primary lead">Ready to get started?</p>
                    <h2 class="mt-0 bold">Create an account now</h2>
                </div><a href="register.html" class="btn btn-primary btn-rounded mt-3 mt-md-0 ms-md-auto">Create ERP account</a>
            </div>
        </div>
    </section><!-- ./Footer - Four Columns -->
    <footer class="site-footer section b-t">
        <div class="container pb-3">
            <div class="row gap-y text-center text-md-start">
                <div class="col-md-4 me-auto"><img src="img/logo.png" alt="" class="logo">
                    <p>ERP, a carefully crafted and powerful HTML5 template, it's perfect to showcase your startup or software</p>
                </div>
                <div class="col-md-2">
                    <h6 class="py-2 bold text-uppercase">Company</h6>
                    <nav class="nav flex-column"><a class="nav-item py-2" href="about.html">About</a> <a class="nav-item py-2" href="#">Services</a> <a class="nav-item py-2" href="blog/blog-grid.html">Blog</a></nav>
                </div>
                <div class="col-md-2">
                    <h6 class="py-2 bold text-uppercase">Product</h6>
                    <nav class="nav flex-column"><a class="nav-item py-2" href="#">Features</a> <a class="nav-item py-2" href="#">API</a> <a class="nav-item py-2" href="#">Customers</a></nav>
                </div>

            </div>
            <hr class="mt-5">
            <div class="row small align-items-center">
                <div class="col-md-4">
                    <p class="mt-2 mb-md-0 text-secondary text-center text-md-start">© 2021 PITS. All Rights Reserved</p>
                </div>
                <div class="col-md-8">
                    <nav class="nav justify-content-center justify-content-md-end"><a href="#" class="btn btn-circle btn-sm btn-secondary me-3 op-4"><i class="fab fa-facebook"></i></a> <a href="#" class="btn btn-circle btn-sm btn-secondary me-3 op-4"><i class="fab fa-twitter"></i></a> <a href="#" class="btn btn-circle btn-sm btn-secondary op-4"><i class="fab fa-instagram"></i></a></nav>
                </div>
            </div>
        </div>
    </footer>
</main><!-- themeforest:js -->
    {{-- <style type="text/css">
        .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
                margin-top: 10%;
            }
        .title {
                font-size: 84px;
            }
        .tagline {
                font-size:25px;
                font-weight: 300;
                text-align: center;
            }

        @media only screen and (max-width: 600px) {
            .title{
                font-size: 38px;
            }
            .tagline {
                font-size:18px;
            }
        }
    </style>
    <div class="title flex-center" style="font-weight: 600 !important;">
        {{ config('app.name', 'ultimatePOS') }}
    </div>
    <p class="tagline">
        {{ env('APP_TITLE', '') }}
    </p> --}}
@endsection