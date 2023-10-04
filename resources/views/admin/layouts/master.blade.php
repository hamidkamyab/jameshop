<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head></head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحه مدیریت فروشگاه جامه شاپ</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('imgs/admin/favicon.png') }}">
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">



    <link rel="stylesheet" href="{{ asset('fonticon/css/fontello.css') }}">
    <link rel="stylesheet" href="{{ asset('fonticon/css/fontello-ie7.css') }}">
    <link rel="stylesheet" href="{{ asset('fonticon/css/animation.css') }}">


    <link rel="stylesheet" href="{{ asset('css/jquery.custom-scrollbar.css') }}">

</head>
<body class="BYekan">
    <div class="RightMenu h-100 position-fixed top-0 overflow-hidden mCustomScrollbar HoverSC mCS_noMargin mCS_rightPos NoSelect">
        <div class="title border-bottom border-1 d-flex justify-content-center align-items-center text-white">
            <span class="text-center hiddenItem">پنل مدیریت</span>
        </div>
        <!-- title -->
        <div class="admin position-relative d-flex justify-content-start gap-3 mx-3 align-items-center border-bottom border-1 border-light-dark">
            <div class="adminPic">
                <img src="{{ asset('imgs/admin/ex/admin.jpg') }}" alt="" class="h-100">
            </div>
            <span class="fs-6 text-white position-absolute nameP hiddenItem">حمید کامیاب</span>
        </div>
        <!-- admin -->
        <nav>
            <ul class="menu list-unstyled text-white pt-1" role="button">
                <li class="itemLi">
                    <a href="#" class="item px-2 d-flex align-items-center justify-content-between gap-1 text-white toggle_menu">
                        <div class="d-flex align-items-center gap-2 ">
                            <i class="icon-gauge"></i>
                            <span class="BYekan hiddenItem">داشبورد</span>
                        </div>
                        <i class="icon-down-open icon-open d-none"></i>
                    </a>
                </li>
                <li class="itemLi active open">
                    <a href="#" class="item px-2 d-flex align-items-center justify-content-between gap-1 text-white toggle_menu">
                        <div class="d-flex align-items-center gap-2 ">
                            <i class="icon-android"></i>
                            <span class="BYekan hiddenItem">محصولات</span>
                        </div>
                        <i class="icon-down-open icon-open"></i>
                    </a>
                    <ul class="sub-menu list-unstyled">
                        <li class="itemLi">
                            <a href="#" class="item px-2 d-flex align-items-center gap-2 text-white">
                                <div class="d-flex align-items-center gap-2 ">
                                    <i class="icon-gauge"></i>
                                    <span class="BYekan hiddenItem">زیر منو یک</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="itemLi">
                    <a href="#" class="item px-2 d-flex align-items-center justify-content-between gap-1 text-white toggle_menu">
                        <div class="d-flex align-items-center gap-2">
                            <i class="icon-user"></i>
                            <span class="BYekan hiddenItem">کاربران</span>
                        </div>
                        <i class="icon-down-open icon-open d-none"></i>
                    </a>
                </li>
                <li class="itemLi open">
                    <a href="#" class="item px-2 d-flex align-items-center justify-content-between gap-1 text-white toggle_menu">
                        <div class="d-flex align-items-center gap-2">
                            <i class="icon-buffer"></i>
                            <span class="BYekan hiddenItem">صفحات</span>
                        </div>
                        <i class="icon-down-open icon-open"></i>
                    </a>
                    <ul class="sub-menu list-unstyled">
                        <li class="itemLi">
                            <a href="#" class="item px-2 d-flex align-items-center gap-2 text-white">
                                <div class="d-flex align-items-center gap-2 ">
                                    <i class="icon-gauge"></i>
                                    <span class="BYekan hiddenItem">زیر منو</span>
                                </div>
                            </a>
                        </li>
                        <li class="itemLi">
                            <a href="#" class="item px-2 d-flex align-items-center gap-2 text-white">
                                <div class="d-flex align-items-center gap-2 ">
                                    <i class="icon-gauge"></i>
                                    <span class="BYekan hiddenItem">زیر منو دو</span>
                                </div>
                            </a>
                        </li>
                        <li class="itemLi">
                            <a href="#" class="item px-2 d-flex align-items-center gap-2 text-white">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="icon-gauge"></i>
                                    <span class="BYekan hiddenItem">زیر منو سه</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="itemLi open">
                    <a href="#" class="item px-2 d-flex align-items-center justify-content-between gap-1 text-white toggle_menu open">
                        <div class="d-flex align-items-center gap-2">
                            <i class="icon-buffer"></i>
                            <span class="BYekan hiddenItem">صفحات</span>
                        </div>
                        <i class="icon-down-open icon-open"></i>
                    </a>
                    <ul class="sub-menu list-unstyled" style="height: 600px;">
                        <li class="itemLi">
                            <a href="#" class="item px-2 d-flex align-items-center gap-2 text-white">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="icon-gauge"></i>
                                    <span class="BYekan hiddenItem">زیر منو</span>
                                </div>
                            </a>
                        </li>
                        <li class="itemLi">
                            <a href="#" class="item px-2 d-flex align-items-center gap-2 text-white">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="icon-gauge"></i>
                                    <span class="BYekan hiddenItem">زیر منو دو</span>
                                </div>
                            </a>
                        </li>
                        <li class="itemLi">
                            <a href="#" class="item px-2 d-flex align-items-center gap-2 text-white">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="icon-gauge"></i>
                                    <span class="BYekan hiddenItem">زیر منو سه</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>





            </ul>
        </nav>
    </div>

    <div class="HeadMenu position-fixed mb-3 top-0 border-bottom bg-white position-fixed w-100 d-flex align-items-center gap-3 px-5 NoSelect">
        <div>
            <a href="/" class="mb-2 mb-lg-0 text-dark text-decoration-none">
                <img src="{{ asset('imgs/admin/logo-bold.png') }}" alt="" width="80">
            </a>
        </div>
        <div class="d-flex align-items-center justify-content-between flex-grow-1">
            <div class="right d-flex align-items-center gap-4  ms-5">
                <i class="icon icon-menu-1 fs-4 text-muted ms-1 sidebarBtn" role="button" data-id="sideBarId"></i>
            </div>

            <div class="left d-flex align-items-center gap-5">

                <div class="dropdown text-end">
                    <div href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" role="button">
                        <i class="icon-commenting-o text-secondary badgeBtn fs-5"></i>
                        <span class="badegIcon position-absolute top-25 translate-middle p-1 bg-danger border border-light rounded-circle">
                        </span>
                    </div>
                    <div class="dropdown-menu badgeBox outCW position-absolute end-0 py-1 px-2 rounded-3 mt-2">
                        <span class="num_unread_msg fs-8 text-dark">0</span>
                        <span class="fs-8 text-dark"> پیام خوانده نشده دارید!</span>
                        <a href="#" class="d-block fs-8 text-end text-info">مشاهده</a>
                    </div>
                </div>
                <div class="dropdown text-end">
                    <div href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" role="button">
                        <i class="icon-ticket-1 text-secondary badgeBtn fs-5"></i>
                        <span class="badegIcon position-absolute top-25 translate-middle p-1 bg-danger border border-light rounded-circle">
                        </span>
                    </div>
                    <div class="dropdown-menu badgeBox outCW position-absolute end-0 py-1 px-2 rounded-3 mt-2">
                        <span class="num_unread_msg fs-8 text-dark">0</span>
                        <span class="fs-8 text-dark"> تیکت خوانده نشده دارید!</span>
                        <a href="#" class="d-block fs-8 text-end text-info">مشاهده</a>
                    </div>
                </div>
                <a href="#" onclick="">
                    <i class="icon-home-1 text-muted fs-5" title=" خانه "></i>
                </a>
                <a href="#" onclick="">
                    <i class="icon-logout-2 text-muted fs-6" title=" خروج "></i>
                </a>
            </div>
        </div>
    </div>

    <div class="main vh-100">
        <div class="content mCustomScrollbar h-100" data-mcs-theme="dark">
            <div class="subContent container d-flex flex-wrap align-items-start gap-2" >
                <div class="col-12 d-flex flex-wrap justify-content-center gap-2">
                    <div class="navigtionBar col-12 p-3 bg-white d-flex align-items-center h-auto">
                        <h4 class="BYekan text-muted m-0 p-0">
                            @yield('navigation')
                        </h4>
                    </div>
                    <!-- navigtionBar -->

                    <div class="col-12 bg-white p-3">
                        @yield('content')
                    </div>
                </div>


                <div class="footer align-self-end col-12 p-2 mb-4 bg-white d-flex justify-content-center align-items-center h-auto text-muted gap-1 vazir" dir="ltr" style="bottom:0">
                    <span class="fs-12">©</span>
                    <span class="m-0 p-0 fw-bold fs-12" >
                        CopyRight: Hamid Kamyab - 2024
                    </span>
                </div>
                <!-- footer -->

            </div>
            <!-- container -->
        </div>
    </div>


</body>

<script src="{{ asset('js/admin.js') }}" type="text/javascript "></script>
<script src="{{ asset('js/jquery.custom-scrollbar.js') }}"></script>


<script>
    const wvc = document.getElementById('w_visit_chart');
    new Chart(wvc, {
        type: 'bar',
        data: {
            labels: ['شنبه', 'یکشنبه', 'دوشنبه', 'سه شنبه', 'چهارشنبه', 'پنج شنبه', 'جمعه'],
            datasets: [{
                label: 'بازدید',
                data: [812, 190, 433, 500, 200, 300, 940],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        },
    });

    const wsc = document.getElementById('w_sell_chart');
    new Chart(wsc, {
        type: 'bar',
        data: {
            labels: ['شنبه', 'یکشنبه', 'دوشنبه', 'سه شنبه', 'چهارشنبه', 'پنج شنبه', 'جمعه'],
            datasets: [{
                label: 'فروش',
                data: [10, 5, 23, 7, 4, 6, 40],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        },
    });
</script>

</html>
