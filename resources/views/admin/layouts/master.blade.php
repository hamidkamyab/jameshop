<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head></head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحه مدیریت فروشگاه جامه شاپ</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('imgs/admin/favicon.png') }}">
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
    <script src="{{asset('js/jquery-3.7.1.min.js')}}"></script>

    <link rel="stylesheet" href="{{ asset('fonticon/css/fontello.css') }}">
    <link rel="stylesheet" href="{{ asset('fonticon/css/fontello-ie7.css') }}">
    <link rel="stylesheet" href="{{ asset('fonticon/css/animation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.custom-scrollbar.css') }}">
    @yield('styles')

    <script>
        $(document).ready(function() {
            $('.searchSelect').select2();
        });
    </script>

</head>
<body class="BYekan">
    @include('admin.layouts.menu')

    @include('admin.layouts.head')

    <div class="main vh-100">
        <div class="content mCustomScrollbar h-100" data-mcs-theme="dark">
            <div class="subContent container d-flex flex-wrap align-items-start gap-2" >
                <div class="col-12 d-flex flex-wrap justify-content-center gap-2">
                    <div class="navigtionBar col-12 p-3 bg-white d-flex align-items-center h-auto border-start border-4 border-info">
                        <h4 class="BYekan text-muted m-0 p-0">
                            @yield('navigation')
                        </h4>
                    </div>
                    <!-- navigtionBar -->

                    <div class="col-12 bg-white p-3 border-start border-4 border-info">
                        @yield('content')
                    </div>
                </div>


                <div class="footer align-self-end col-12 p-2 mb-4 bg-white d-flex justify-content-center align-items-center h-auto text-muted gap-1 vazir" dir="ltr" style="bottom:0">
                    <i class="icon-copyright fs-6"></i>
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
@yield('scripts')

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
