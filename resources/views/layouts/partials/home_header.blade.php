
 <nav class="st-nav navbar main-nav navigation fixed-top" id="main-nav">
  <div class="container">
      <ul class="st-nav-menu nav navbar-nav">
          <li class="st-nav-section nav-item"><a href="#main" class="navbar-brand">
              <img src="{{asset('new/img/logo.png')}}" alt="ERP" class="logo logo-sticky d-inline-block d-md-none">
             <img src="{{asset('new/img/logo-light.png')}}" alt="Dashcore" class="logo d-none d-md-inline-block"></a></li>
          <li class="st-nav-section st-nav-primary nav-item"><a class="st-root-link nav-link active" href="{{route('home')}}">Home</a>
              <!-- <a class="st-root-link item-products st-has-dropdown nav-link" data-dropdown="blocks">Blocks</a>
               <a class="st-root-link item-products st-has-dropdown nav-link" data-dropdown="pages">Pages</a>
               <a class="st-root-link item-company st-has-dropdown nav-link" data-dropdown="components">UI Components</a>
               <a class="st-root-link item-blog st-has-dropdown nav-link" data-dropdown="blog">Blog</a>
               <a class="st-root-link item-shop st-has-dropdown nav-link" href="shop/" data-dropdown="shop">Shop</a> -->
               <a class="st-root-link item-shop  nav-link" href="#">Pricing Plans</a>
               <a class="st-root-link item-shop  nav-link" href="#">Add-ons</a>
               <a class="st-root-link item-shop  nav-link" href="#">Documentation</a>
               <a class="st-root-link item-shop  nav-link" href="#">FAQ</a>
               <a class="st-root-link item-shop  nav-link" href="#">About</a>
               <a class="st-root-link item-shop  nav-link" href="#">Contact</a>
              </li>
          <li class="st-nav-section st-nav-secondary nav-item">
        @if (Route::has('login'))
        @if(!Auth::check())
              <a class="btn btn-rounded btn-outline me-3 px-3 " href="{{ route('login') }}">
                  <i class="fas fa-sign-in-alt d-none d-md-inline me-md-0 me-lg-2"></i>
                  <span class="d-md-none d-lg-inline">Login</span> </a>
                  @if(config('constants.allow_registration'))
                  <a class="btn btn-rounded btn-solid px-3" href="{{ route('business.getRegister') }}">
                    <i class="fas fa-user-plus d-none d-md-inline me-md-0 me-lg-2"></i>
                     <span class="d-md-none d-lg-inline">Signup</span></a>
                    </li>
                    @endif
                    @endif
                    @endif
                  <!-- Mobile Navigation -->
          <li class="st-nav-section st-nav-mobile nav-item"><button class="st-root-link navbar-toggler" type="button"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></button>
              <div class="st-popup">
                  <div class="st-popup-container"><a class="st-popup-close-button">Close</a>
                      <div class="st-dropdown-content-group">
                          <h4 class="text-uppercase regular">Pages</h4><a class="regular text-primary" href="about.html"><i class="far fa-building me-2"></i> About </a><a class="regular text-success" href="contact.html"><i class="far fa-envelope me-2"></i> Contact </a><a class="regular text-warning" href="pricing.html"><i class="fas fa-hand-holding-usd me-2"></i> Pricing </a><a class="regular text-info" href="faqs.html"><i class="far fa-question-circle me-2"></i> FAQs</a>
                      </div>
                      <div class="st-dropdown-content-group border-top bw-2">
                          <h4 class="text-uppercase regular">Components</h4>
                          <div class="row">
                              <div class="col me-4"><a target="_blank" href="components/alert.html">Alerts</a> <a target="_blank" href="components/badge.html">Badges</a> <a target="_blank" href="components/button.html">Buttons</a> <a target="_blank" href="components/color.html">Colors</a> <a target="_blank" href="components/accordion.html">Accordion</a> <a target="_blank" href="components/cookie-law.html">Cookielaw</a></div>
                              <div class="col me-4"><a target="_blank" href="components/overlay.html">Overlay</a> <a target="_blank" href="components/progress.html">Progress</a> <a target="_blank" href="components/lightbox.html">Lightbox</a> <a target="_blank" href="components/tab.html">Tabs</a> <a target="_blank" href="components/tables.html">Tables</a> <a target="_blank" href="components/typography.html">Typography</a></div>
                          </div>
                      </div>
                      <div class="st-dropdown-content-group bg-light b-t"><a href="login.html">Sign in <i class="fas fa-arrow-right"></i></a></div>
                  </div>
              </div>
          </li>
      </ul>
  </div>
  <div class="st-dropdown-root">
      <div class="st-dropdown-bg">
          <div class="st-alt-bg"></div>
      </div>
      <div class="st-dropdown-arrow"></div>
      <div class="st-dropdown-container">
          <div class="st-dropdown-section" data-dropdown="blocks">
              <div class="st-dropdown-content">
                  <div class="st-dropdown-content-group">
                      <div class="row">
                          <div class="col me-4"><a class="dropdown-item" target="_blank" href="blocks/call-to-action.html">Call to actions</a> <a class="dropdown-item" target="_blank" href="blocks/contact.html">Contact</a> <a class="dropdown-item" target="_blank" href="blocks/counter.html">Counters</a> <a class="dropdown-item" target="_blank" href="blocks/faqs.html">FAQs</a></div>
                          <div class="col me-4"><a class="dropdown-item" target="_blank" href="blocks/footer.html">Footers</a> <a class="dropdown-item" target="_blank" href="blocks/form.html">Forms</a> <a class="dropdown-item" target="_blank" href="blocks/navbar.html">Navbar</a> <a class="dropdown-item" target="_blank" href="blocks/navigation.html">Navigation</a></div>
                          <div class="col"><a class="dropdown-item" target="_blank" href="blocks/pricing.html">Pricing</a> <a class="dropdown-item" target="_blank" href="blocks/slider.html">Sliders</a> <a class="dropdown-item" target="_blank" href="blocks/team.html">Team</a> <a class="dropdown-item" target="_blank" href="blocks/testimonial.html">Testimonials</a></div>
                      </div>
                  </div>
                  <div class="st-dropdown-content-group">
                      <h3 class="link-title"><i class="fas fa-long-arrow-alt-right icon"></i> Coming soon</h3>
                      <div class="ms-5"><span class="dropdown-item text-secondary">Dividers </span><span class="dropdown-item text-secondary">Gallery </span><span class="dropdown-item text-secondary">Screenshots</span></div>
                  </div>
              </div>
          </div>
          <div class="st-dropdown-section" data-dropdown="pages">
              <div class="st-dropdown-content">
                  <div class="st-dropdown-content-group">
                      <div class="mb-4">
                          <h3 class="text-darker light text-nowrap"><span class="bold regular">Useful pages</span> you'll need</h3>
                          <p class="text-secondary mt-0">Get a complete design stack</p>
                      </div>
                      <div class="row">
                          <div class="col">
                              <ul class="me-4">
                                  <li>
                                      <h4 class="text-uppercase regular">Error</h4>
                                  </li>
                                  <li><a target="_blank" href="403.html">403 Error</a></li>
                                  <li><a target="_blank" href="404.html">404 Error</a></li>
                                  <li><a target="_blank" href="500.html">500 Error</a></li>
                              </ul>
                          </div>
                          <div class="col">
                              <ul class="me-4">
                                  <li>
                                      <h4 class="text-uppercase regular">User</h4>
                                  </li>
                                  <li><a target="_blank" href="login.html">Login</a></li>
                                  <li><a target="_blank" href="register.html">Register</a></li>
                                  <li><a target="_blank" href="forgot.html">Forgot</a></li>
                              </ul>
                          </div>
                          <div class="col">
                              <ul>
                                  <li>
                                      <h4 class="text-uppercase regular">Extra</h4>
                                  </li>
                                  <li><a target="_blank" href="pricing.html">Pricing</a></li>
                                  <li><a target="_blank" href="terms.html">Terms</a></li>
                                  <li><a target="_blank" href="faqs.html">FAQ</a></li>
                              </ul>
                          </div>
                      </div>
                  </div>
                  <div class="st-dropdown-content-group"><a class="dropdown-item bold" href="about.html"><i class="far fa-building icon"></i> About </a><a class="dropdown-item bold" href="contact.html"><i class="far fa-envelope icon"></i> Contact </a><a class="dropdown-item bold" href="pricing.html"><i class="fas fa-hand-holding-usd icon"></i> Pricing</a></div>
              </div>
          </div>
          <div class="st-dropdown-section" data-dropdown="components">
              <div class="st-dropdown-content">
                  <div class="st-dropdown-content-group"><a class="dropdown-item" target="_blank" href="components/color.html">
                          <div class="d-flex mb-4"><i class="fas fa-palette me-2 bg-primary rounded-circle icon-md text-contrast center-flex"></i>
                              <div class="flex-fill">
                                  <h3 class="link-title m-0">Colors</h3>
                                  <p class="m-0 text-secondary">Get to know DashCore color options</p>
                              </div>
                          </div>
                      </a><a class="dropdown-item" target="_blank" href="components/accordion.html">
                          <div class="d-flex mb-4"><i class="fas fa-bars me-2 bg-primary rounded-circle icon-md text-contrast center-flex"></i>
                              <div class="flex-fill">
                                  <h3 class="link-title m-0">Accordion</h3>
                                  <p class="m-0 text-secondary">Useful accordion elements</p>
                              </div>
                          </div>
                      </a><a class="dropdown-item" target="_blank" href="components/cookie-law.html">
                          <div class="d-flex mb-4"><i class="fas fa-cookie-bite me-2 bg-primary rounded-circle icon-md text-contrast center-flex"></i>
                              <div class="flex-fill">
                                  <h3 class="link-title m-0">CookieLaw</h3>
                                  <p class="m-0 text-secondary">Comply with the hideous EU Cookie Law</p>
                              </div>
                          </div>
                      </a>
                      <h4 class="text-uppercase regular">Huge components list</h4>
                      <div class="row">
                          <div class="col me-4"><a class="dropdown-item" target="_blank" href="components/alert.html">Alerts</a> <a class="dropdown-item" target="_blank" href="components/badge.html">Badges</a> <a class="dropdown-item" target="_blank" href="components/button.html">Buttons</a></div>
                          <div class="col me-4"><a class="dropdown-item" target="_blank" href="components/overlay.html">Overlay</a> <a class="dropdown-item" target="_blank" href="components/progress.html">Progress</a> <a class="dropdown-item" target="_blank" href="components/lightbox.html">Lightbox</a></div>
                          <div class="col me-4"><a class="dropdown-item" target="_blank" href="components/tab.html">Tabs</a> <a class="dropdown-item" target="_blank" href="components/tables.html">Tables</a> <a class="dropdown-item" target="_blank" href="components/typography.html">Typography</a></div>
                      </div>
                  </div>
                  <div class="st-dropdown-content-group"><a class="dropdown-item" target="_blank" href="components/wizard.html">Wizard <span class="badge badge-pill badge-primary">New</span></a> <span class="dropdown-item d-flex align-items-center text-muted">Timeline <i class="fas fa-ban ms-auto"></i></span> <span class="dropdown-item d-flex align-items-center text-muted">Process <i class="fas fa-ban ms-auto"></i></span></div>
              </div>
          </div>
          <div class="st-dropdown-section" data-dropdown="blog">
              <div class="st-dropdown-content">
                  <div class="st-dropdown-content-group">
                      <div class="row">
                          <div class="col me-4">
                              <h4 class="regular text-uppercase">Full width</h4><a class="dropdown-item" target="_blank" href="blog/blog-post.html">Single post</a> <a class="dropdown-item" target="_blank" href="blog/blog-grid.html">Posts Grid</a>
                          </div>
                          <div class="col me-4">
                              <h4 class="regular text-uppercase">Sidebar left</h4><a class="dropdown-item" target="_blank" href="blog/blog-post-sidebar-left.html">Single post</a> <a class="dropdown-item" target="_blank" href="blog/blog-grid-sidebar-left.html">Posts Grid</a>
                          </div>
                          <div class="col me-4">
                              <h4 class="regular text-uppercase">Sidebar right</h4><a class="dropdown-item" target="_blank" href="blog/blog-post-sidebar-right.html">Single post</a> <a class="dropdown-item" target="_blank" href="blog/blog-grid-sidebar-right.html">Posts Grid</a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="st-dropdown-section" data-dropdown="shop">
              <div class="st-dropdown-content">
                  <div class="st-dropdown-content-group"><a class="dropdown-item mb-4" target="_blank" href="shop/">
                          <div class="d-flex align-items-center">
                              <div class="bg-success text-contrast icon-md center-flex rounded-circle me-3"><i class="fas fa-shopping-basket"></i></div>
                              <div class="flex-fill">
                                  <h3 class="link-title m-0">Home</h3>
                                  <p class="m-0 text-secondary">Online store home with an outstanding UX</p>
                              </div>
                          </div>
                      </a><a class="dropdown-item" target="_blank" href="shop/cart.html">
                          <div class="d-flex align-items-center">
                              <div class="bg-info text-contrast icon-md center-flex rounded-circle me-3"><i class="fas fa-shopping-cart"></i></div>
                              <div class="flex-fill">
                                  <h3 class="link-title m-0">Cart</h3>
                                  <p class="m-0 text-secondary">Online store shopping cart</p>
                              </div>
                          </div>
                      </a></div>
                  <div class="st-dropdown-content-group">
                      <h3 class="link-title"><i class="fas fa-money-check-alt icon"></i> Checkout</h3>
                      <div class="ms-5"><a class="dropdown-item text-secondary" target="_blank" href="shop/checkout-customer.html">Customer <i class="fas fa-angle-right ms-2"></i> </a><a class="dropdown-item text-secondary" target="_blank" href="shop/checkout-shipping.html">Shipping Information <i class="fas fa-angle-right ms-2"></i> </a><a class="dropdown-item text-secondary" target="_blank" href="shop/checkout-payment.html">Payment Methods <i class="fas fa-angle-right ms-2"></i> </a><a class="dropdown-item text-secondary" target="_blank" href="shop/checkout-confirmation.html">Order Review <i class="fas fa-angle-right ms-2"></i></a></div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</nav>
<!-- Static navbar -->
{{-- <nav class="navbar navbar-default navbar-static-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">{{config('app.name', 'ultimatePOS')}}</a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        @if(Auth::check())
            <li><a href="{{ action('HomeController@index') }}">@lang('home.home')</a></li>
        @endif
        @if(Route::has('frontend-pages') && config('app.env') != 'demo'
        && !empty($frontend_pages))
            @foreach($frontend_pages as $page)
                <li><a href="{{ action('\Modules\Superadmin\Http\Controllers\PageController@showPage', $page->slug) }}">{{$page->title}}</a></li>
            @endforeach
        @endif
        @if(Route::has('pricing') && config('app.env') != 'demo')
        <li><a href="{{ action('\Modules\Superadmin\Http\Controllers\PricingController@index') }}">@lang('superadmin::lang.pricing')</a></li>
        @endif
        @if(Route::has('repair-status'))
        <li>
          <a href="{{ action('\Modules\Repair\Http\Controllers\CustomerRepairStatusController@index') }}">
            @lang('repair::lang.repair_status')
          </a>
        </li>
        @endif
      </ul>
      <ul class="nav navbar-nav navbar-right">
        @if (Route::has('login'))
            @if(!Auth::check())
                <li><a href="{{ route('login') }}">@lang('lang_v1.login')</a></li>
                @if(config('constants.allow_registration'))
                    <li><a href="{{ route('business.getRegister') }}">@lang('lang_v1.register')</a></li>
                @endif
            @endif
        @endif
      </ul>
    </div><!-- nav-collapse -->
  </div>
</nav> --}}