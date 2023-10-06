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
            <li class="itemLi">
                <a href="javascript:void(0)" class="item px-2 d-flex align-items-center justify-content-between gap-1 text-white toggle_menu">
                    <div class="d-flex align-items-center gap-2 ">
                        <i class="icon-tag"></i>
                        <span class="BYekan hiddenItem">دسته بندی</span>
                    </div>
                    <i class="icon-down-open icon-open open"></i>
                </a>
                <ul class="sub-menu list-unstyled open">
                    <li class="itemLi active">
                        <a href="{{route('categories.index')}}" class="item px-2 d-flex align-items-center gap-2 text-white">
                            <div class="d-flex align-items-center gap-2 ">
                                <i class="icon-tags"></i>
                                <span class="BYekan hiddenItem">لیست دسته بندی</span>
                            </div>
                        </a>
                    </li>
                    <li class="itemLi">
                        <a href="{{route('categories.create')}}" class="item px-2 d-flex align-items-center gap-2 text-white">
                            <div class="d-flex align-items-center gap-2 ">
                                <i class="icon-tag-add"></i>
                                <span class="BYekan hiddenItem">ایجاد دسته بندی</span>
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
            <li class="itemLi">
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

        </ul>
    </nav>
</div>
