<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/png" href="@if(!empty(allsetting('favicon'))) {{ asset(path_image().allsetting('favicon')) }} @else
    {{asset('assets/images/favicon.ico')}} @endif "/>
    <title>@yield('title','Ammelias | iTech')</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/css/font-awesome.min.css')}}">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/owl.theme.default.min.css')}}">
    <!-- Slicknav -->
    <link rel="stylesheet" href="{{asset('assets/css/metisMenu.min.css')}}">
    <!-- magnific popup -->
    <link rel="stylesheet" href="{{asset('assets/css/magnific-popup.css')}}">
    <!-- Swiper Slider -->
    <link rel="stylesheet" href="{{asset('assets/vendors/swiper-master/css/swiper.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/iconfont/flaticon.css')}}">
    <!-- Start data table -->
    <link rel="stylesheet" href="{{asset('assets/DataTables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/DataTables/css/responsive.dataTables.min.css')}}">
    <!---date picker-->
    <link href="{{asset('assets/DatePicker/datepicker.css')}}" rel="stylesheet" type="text/css" />
    {{-- editor--}}
    <link href="{{asset('assets/Summernote/summernote-bs4.css')}}" rel="stylesheet">
    <!-- font family -->
    <link rel="stylesheet" href="{{asset('assets/css/proxima-nova.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/scrollbar.css')}}">
    <!-- Modernizr Js -->
    <script src="{{asset('assets/vendors/modernizr-js/modernizr.js')}}"></script>
    <!--for image drag and drop-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/dropify/css/dropify.min.css')}}">
    <link href="{{asset('assets/alertify/css/alertify.min.css')}}" rel="stylesheet">
    <!-- Site Style -->
    <link rel="stylesheet" href="{{asset('assets/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/responsive.css')}}">
    <!--[if lt IE 8]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
</head>

<body>
<!-- Start wrapper -->
<div class="qz-wrapper">
    <!-- Start sidebar -->
    <div class="qz-sidebar">
        <div class="qz-logo">
            <a href="{{ route('adminDashboard') }}">
                <img @if(!empty(allsetting('logo'))) src ="{{ asset(path_image().allsetting('logo')) }}"
                     @else src="{{asset('assets/images/logo.png')}}" @endif alt="" class="img-fluid">
            </a>
        </div>
        <nav>
            <ul id="metismenu" class="menulist">
                <li class="@if(isset($menu) && $menu == 'dashboard') qz-active @endif">
                    <a href="{{ route('adminDashboard') }}">
                        <img src={{asset('assets/images/sidebar/dashboard.svg')}}>{{__('Dashboard')}}
                    </a>
                </li>
                <li class="@if(isset($menu) && $menu == 'portfolio') qz-active @endif">
                    <a href="{{ route('portfolioList') }}">
                        <img src={{asset('assets/images/sidebar/portfolio.svg')}}>{{__('Portfolio')}}
                    </a>
                </li>
                <li class="@if(isset($menu) && $menu == 'teamList') qz-active @endif">
                    <a href="{{ route('teamList') }}">
                        <img src={{asset('assets/images/sidebar/team.svg')}}>{{__('Team')}}
                    </a>
                </li>
                <li class="@if(isset($menu) && $menu == 'service') qz-active @endif">
                    <a href="{{ route('serviceList') }}">
                        <img src={{asset('assets/images/sidebar/services.svg')}}>{{__('Services')}}
                    </a>
                </li>
                <li class="@if(isset($menu) && $menu == 'gallery') qz-active @endif">
                    <a href="{{ route('galleryList') }}">
                        <img src={{asset('assets/images/sidebar/gallery.svg')}}>{{__('Gallery')}}
                    </a>
                </li>
                <li class="@if(isset($menu) && $menu == 'plan') qz-active @endif">
                    <a href="{{ route('planList') }}">
                        <img src={{asset('assets/images/sidebar/pricing.svg')}}>{{__('Pricing Plan')}}
                    </a>
                </li>
                <li class="@if(isset($menu) && $menu == 'testimonial') qz-active @endif">
                    <a href="{{ route('testimonialList') }}">
                        <img src={{asset('assets/images/sidebar/customer.svg')}}>{{__('Testimonial')}}
                    </a>
                </li>
                <li class="@if(isset($menu) && $menu == 'about') qz-active @endif">
                    <a href="{{ route('aboutSettings') }}">
                        <img src={{asset('assets/images/sidebar/about_us.svg')}}>{{__('About Us')}}
                    </a>
                </li>
                <li class="@if(isset($menu) && $menu == 'blog') qz-active @endif">
                    <a href="{{ route('blogList') }}">
                        <img src={{asset('assets/images/sidebar/blog.svg')}}>{{__('Blog')}}
                    </a>
                </li>
                <li class="@if(isset($menu) && $menu == 'subscriber') qz-active @endif">
                    <a href="{{ route('subscriberList') }}">
                        <img src={{asset('assets/images/sidebar/testimonial.svg')}}>{{__('Subscribers')}}
                    </a>
                </li>
                <li class="@if(isset($menu) && $menu == 'setting') qz-active @endif">
                    <a href="#cllopse" aria-expanded="true" data-toggle="collapse">
                        <img src={{asset('assets/images/sidebar/settings.svg')}}>{{__('Settings')}}
                    </a>
                    <ul class="collapse @if(isset($menu) && $menu == 'setting') show submenu-active2 @endif" id="cllopse">
                        <li class=" @if(isset($sub_menu) && $sub_menu == 'menu') submenu-active  @endif">
                            <a href="{{ route('menuList') }}"><span>{{__('Menu Settings')}}</span></a>
                        </li>
                        <li class=" @if(isset($sub_menu) && $sub_menu == 'general') submenu-active  @endif">
                            <a href="{{ route('adminSettings') }}"><span>{{__('General Settings')}}</span></a>
                        </li>
                        <li class="@if(isset($sub_menu) && $sub_menu == 'website') submenu-active @endif">
                            <a href="{{ route('webSettings') }}"><span>{{__('Website Settings')}}</span></a>
                        </li>
                    </ul>

                </li>
                <li class="@if(isset($menu) && $menu == 'userlist') qz-active @endif">
                    <a href="{{ route('userList') }}">
                        <img src={{asset('assets/images/sidebar/user_managment.svg')}}>{{__('User Management')}}
                    </a>
                </li>
                <li class="@if(isset($menu) && $menu == 'contact') qz-active @endif">
                    <a href="{{ route('contactList') }}">
                        <img src={{asset('assets/images/sidebar/contact_list.svg')}}>{{__('Contact List')}}
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <!-- End sidebar -->
<!-- Start main content -->
    <div class="qz-main-content">
        <!-- Start top bar -->
        <div class="qz-topbar">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-9 col-lg-8 col-md-7 col-12">
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-5 col-12 mt-md-0 mt-2">
                        <div class="btn-group d-md-inline-flex d-flex justify-content-left">
                            <button type="button" class="btn btn-secondary dropdown-toggle qz-user-profile-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if(isset(auth::user()->name)) {{ auth::user()->name }} @endif
                                <span class="flaticon-angle-arrow-down"></span>
                                <span class="qz-user-avater">
                            <img @if(isset(auth::user()->photo)) src="{{ asset(path_user_image().auth::user()->photo)}}" @else src="{{asset('assets/images/avater.jpg')}}" @endif alt="" class="img-fluid">

                        </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="{{route('userProfile')}}" class="dropdown-item">{{__('Profile')}}</a>
                                <a href="{{route('passwordChange')}}" class="dropdown-item">{{__('Password Setup')}}</a>
                                <a href="{{ route('logOut') }}" class="dropdown-item">{{__('Logout')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @yield('main-body')
    </div>
    <!-- End main content -->
</div>
<!-- End wrapper -->


<!-- Jquery plugins -->
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/popper.min.js')}}" ></script>
<!-- Bootstrap -->
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<!-- Owl Carousel -->
<script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
<!-- Counterup -->
<script src="{{asset('assets/js/waypoints.min.js')}}"></script>
<script src="{{asset('assets/js/counterup.min.js')}}"></script>
<!-- Slicknav -->
<!-- magnific popup -->
<script src="{{asset('assets/js/magnific-popup.min.js')}}"></script>
<!-- Swiper Slider -->
<script src="{{asset('assets/vendors/swiper-master/js/swiper.min.js')}}"></script>
<!-- Start data table -->
<script src="{{asset('assets/DataTables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/DataTables/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/js/scrollbar.min.js')}}"></script>
{{--Bootstrap editor--}}
<script src="{{asset('assets/Summernote/summernote-bs4.js')}}"></script>
<!---date picker-->
<script src="{{asset('assets/DatePicker/bootstrap-datepicker.js')}}"></script>

<!--drag and drop js-->
<script src="{{asset('assets/dropify/js/dropify.min.js')}}"></script>
<script src="{{asset('assets/dropify/js/form-file-uploads.js')}}"></script>
<script src="{{asset('assets/js/revenue-chart.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/alertify/alertify.min.js')}}"></script>
<!-- main js -->
<script src="{{asset('assets/js/main.js')}}"></script>
<script>
    $('#btEditor').summernote({height: 400});
    $('#btEditor2').summernote({height: 400});
</script>
@yield('script')

</body>
</html>