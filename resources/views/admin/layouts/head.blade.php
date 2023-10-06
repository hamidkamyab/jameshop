
    <div class="HeadMenu position-fixed mb-3 top-0 bg-white position-fixed w-100 d-flex align-items-center gap-3 px-5 NoSelect">
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
