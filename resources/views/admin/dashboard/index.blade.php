@extends('admin.layouts.master')
@section('navigation')
داشبورد
@endsection

@section('content')
<div class="col-12 d-flex justify-content-center px-2 reportCard mb-5">

    <div class="col-3 px-1 mb-2 mb-lg-0">
        <div class="card bg-danger">
            <div class="card-body text-white d-flex justify-content-between align-items-center">
                <div class="details BYekan">
                    <h2 class="fs-1 fw-bolder">0</h2>
                    <span>بازدید روز</span>
                </div>
                <div class="icon">
                    <i class="icon-eye fs-1"></i>
                </div>
            </div>
            <div class="card-footer cf-hover position-relative p-0" role="button">
                <a href="portfolio_list.php" class="d-flex justify-content-center position-relative text-white align-items-center w-100 h-100 p-2">
                    <span class="BYekan">
                        اطلاعات بیشتر
                    </span>
                    <i class="icon-left"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-3 px-1 mb-2 mb-lg-0">
        <div class="card bg-success">
            <div class="card-body text-white d-flex justify-content-between align-items-center">
                <div class="details BYekan">
                    <h2 class="fs-1 fw-bolder">0</h2>
                    <span>پیام کاربران</span>
                </div>
                <div class="icon">
                    <i class="icon-commenting-o fs-1"></i>
                </div>
            </div>
            <div class="card-footer cf-hover position-relative p-0" role="button">
                <a href="portfolio_list.php" class="d-flex justify-content-center position-relative text-white align-items-center w-100 h-100 p-2">
                    <span class="BYekan">
                        اطلاعات بیشتر
                    </span>
                    <i class="icon-left"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-3 px-1 mb-2 mb-lg-0">
        <div class="card bg-warning">
            <div class="card-body text-white d-flex justify-content-between align-items-center">
                <div class="details BYekan">
                    <h2 class="fs-1 fw-bolder">0</h2>
                    <span>تیکت ها</span>
                </div>
                <div class="icon">
                    <i class="icon-ticket-1 fs-1"></i>
                </div>
            </div>
            <div class="card-footer cf-hover position-relative p-0" role="button">
                <a href="portfolio_list.php" class="d-flex justify-content-center position-relative text-white align-items-center w-100 h-100 p-2">
                    <span class="BYekan">
                        اطلاعات بیشتر
                    </span>
                    <i class="icon-left"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-3 px-1 mb-2 mb-lg-0">
        <div class="card bg-primary">
            <div class="card-body text-white d-flex justify-content-between align-items-center">
                <div class="details BYekan">
                    <h2 class="fs-1 fw-bolder">0</h2>
                    <span>سفارش ها</span>
                </div>
                <div class="icon">
                    <i class="icon-eye fs-1"></i>
                </div>
            </div>
            <div class="card-footer cf-hover position-relative p-0" role="button">
                <a href="portfolio_list.php" class="d-flex justify-content-center position-relative text-white align-items-center w-100 h-100 p-2">
                    <span class="BYekan">
                        اطلاعات بیشتر
                    </span>
                    <i class="icon-left"></i>
                </a>
            </div>
        </div>
    </div>

</div>
<!-- reportCard -->

<div class="row my-4">
    <div class="col-6">
        <h6 class="ms-2 fs-5-1  text-muted">
            جدیدترین کاربران:
        </h6>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" class="fw-normal">نام و نام خانوادگی</th>
                    <th scope="col" class="fw-normal">ایمیل</th>
                    <th scope="col" class="fw-normal">استان</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>حمید کامیاب</td>
                    <td>mr_kamyab@yahoo.com</td>
                    <td>تهران</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>نگار سوسنی</td>
                    <td>test@yahoo.com</td>
                    <td>فارس</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>هستی فرهادی</td>
                    <td>test@yahoo.com</td>
                    <td>خراسان رضوی</td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- user col -->

    <div class="col-6">
        <h6 class="ms-2 fs-5-1 text-muted">
            جدیدترین تیکتها:
        </h6>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" class="fw-normal">عنوان</th>
                    <th scope="col" class="fw-normal">نام کاربر</th>
                    <th scope="col" class="fw-normal">تاریخ ایجاد</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>مشکل فنی</td>
                    <td>سعید کامیاب</td>
                    <td>1402/07/05</td>
                </tr>
                <tr>
                    <th scope="row">1</th>
                    <td>مشکل فنی</td>
                    <td>مریم کامیاب</td>
                    <td>1402/07/06</td>
                </tr>

            </tbody>
        </table>
    </div>
    <!-- ticket col -->
</div>

<div class="row my-4">
    <div class="col-6">
        <h6 class="ms-2 fs-5-1 text-muted">
            بازدید هفته:
        </h6>
        <canvas id="w_visit_chart"></canvas>
    </div>

    <div class="col-6">
        <h6 class="ms-2 fs-5-1 text-muted">
            فروش هفته:
        </h6>
        <canvas id="w_sell_chart"></canvas>
    </div>
</div>

@endsection
