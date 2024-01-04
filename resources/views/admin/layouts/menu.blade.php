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
                <ul class="sub-menu list-unstyled">
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
                <a href="javascript:void(0)" class="item px-2 d-flex align-items-center justify-content-between gap-1 text-white toggle_menu">
                    <div class="d-flex align-items-center gap-2 ">
                        <i class="icon-th-large"></i>
                        <span class="BYekan hiddenItem">ویژگی</span>
                    </div>
                    <i class="icon-down-open icon-open open"></i>
                </a>
                <ul class="sub-menu list-unstyled">
                    <li class="itemLi active">
                        <a href="{{route('attributes_group.index')}}" class="item px-2 d-flex align-items-center gap-2 text-white">
                            <div class="d-flex align-items-center gap-2 ">
                                <i class="icon-clipboard"></i>
                                <span class="BYekan hiddenItem">لیست ویژگی ها</span>
                            </div>
                        </a>
                    </li>
                    <li class="itemLi">
                        <a href="{{route('attributes_group.create')}}" class="item px-2 d-flex align-items-center gap-2 text-white">
                            <div class="d-flex align-items-center gap-2 ">
                                <i class="icon-plus-squared-1"></i>
                                <span class="BYekan hiddenItem">ایجاد ویژگی</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="itemLi">
                <a href="javascript:void(0)" class="item px-2 d-flex align-items-center justify-content-between gap-1 text-white toggle_menu">
                    <div class="d-flex align-items-center gap-2 ">
                        <i class="icon-server"></i>
                        <span class="BYekan hiddenItem">مقدار ویژگی</span>
                    </div>
                    <i class="icon-down-open icon-open open"></i>
                </a>
                <ul class="sub-menu list-unstyled">
                    <li class="itemLi active">
                        <a href="{{route('attributes_value.index')}}" class="item px-2 d-flex align-items-center gap-2 text-white">
                            <div class="d-flex align-items-center gap-2 ">
                                <i class=" icon-doc-text-1"></i>
                                <span class="BYekan hiddenItem">لیست ویژگی ها</span>
                            </div>
                        </a>
                    </li>
                    <li class="itemLi">
                        <a href="{{route('attributes_value.create')}}" class="item px-2 d-flex align-items-center gap-2 text-white">
                            <div class="d-flex align-items-center gap-2 ">
                                <i class="icon-plus-squared-1"></i>
                                <span class="BYekan hiddenItem">ثبت مقدار ویژگی</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="itemLi">
                <a href="javascript:void(0)" class="item px-2 d-flex align-items-center justify-content-between gap-1 text-white toggle_menu">
                    <div class="d-flex align-items-center gap-2 ">
                        <i class="icon-menu-circle fs-18"></i>
                        <span class="BYekan hiddenItem">منو</span>
                    </div>
                    <i class="icon-down-open icon-open"></i>
                </a>
                <ul class="sub-menu list-unstyled">
                    <li class="itemLi active">
                        <a href="{{route('menus.index')}}" class="item px-2 d-flex align-items-center gap-2 text-white">
                            <div class="d-flex align-items-center gap-2 ">
                                <i class="icon-menu"></i>
                                <span class="BYekan hiddenItem">لیست منوها</span>
                            </div>
                        </a>
                    </li>
                    <li class="itemLi">
                        <a href="{{route('menus.create')}}" class="item px-2 d-flex align-items-center gap-2 text-white">
                            <div class="d-flex align-items-center gap-2 ">
                                <i class="icon-menu-add fs-14"></i>
                                <span class="BYekan hiddenItem">ایجاد منو</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="itemLi">
                <a href="javascript:void(0)" class="item px-2 d-flex align-items-center justify-content-between gap-1 text-white toggle_menu">
                    <div class="d-flex align-items-center gap-2 ">
                        <i class=" icon-megaphone"></i>
                        <span class="BYekan hiddenItem">برند</span>
                    </div>
                    <i class="icon-down-open icon-open"></i>
                </a>
                <ul class="sub-menu list-unstyled">
                    <li class="itemLi active">
                        <a href="{{route('brands.index')}}" class="item px-2 d-flex align-items-center gap-2 text-white">
                            <div class="d-flex align-items-center gap-2 ">
                                <i class=" icon-megaphone"></i>
                                <span class="BYekan hiddenItem">لیست برندها</span>
                            </div>
                        </a>
                    </li>
                    <li class="itemLi">
                        <a href="{{route('brands.create')}}" class="item px-2 d-flex align-items-center gap-2 text-white">
                            <div class="d-flex align-items-center gap-2 ">
                                <i class=" icon-certificate"></i>
                                <span class="BYekan hiddenItem">ثبت برند</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="itemLi">
                <a href="javascript:void(0)" class="item px-2 d-flex align-items-center justify-content-between gap-1 text-white toggle_menu">
                    <div class="d-flex align-items-center gap-2 ">
                        <i class=" icon-droplet"></i>
                        <span class="BYekan hiddenItem">رنگ ها</span>
                    </div>
                    <i class="icon-down-open icon-open"></i>
                </a>
                <ul class="sub-menu list-unstyled">
                    <li class="itemLi active">
                        <a href="{{route('colors.index')}}" class="item px-2 d-flex align-items-center gap-2 text-white">
                            <div class="d-flex align-items-center gap-2 ">
                                <i class="icon-color-adjust"></i>
                                <span class="BYekan hiddenItem">لیست رنگ ها</span>
                            </div>
                        </a>
                    </li>
                    <li class="itemLi">
                        <a href="{{route('colors.create')}}" class="item px-2 d-flex align-items-center gap-2 text-white">
                            <div class="d-flex align-items-center gap-2 ">
                                <i class="icon-eyedropper"></i>
                                <span class="BYekan hiddenItem">ثبت رنگ</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="itemLi">
                <a href="javascript:void(0)" class="item px-2 d-flex align-items-center justify-content-between gap-1 text-white toggle_menu">
                    <div class="d-flex align-items-center gap-2 ">
                        <i class="icon-size"></i>
                        <span class="BYekan hiddenItem">سایز ها</span>
                    </div>
                    <i class="icon-down-open icon-open"></i>
                </a>
                <ul class="sub-menu list-unstyled">
                    <li class="itemLi active">
                        <a href="{{route('sizes.index')}}" class="item px-2 d-flex align-items-center gap-2 text-white">
                            <div class="d-flex align-items-center gap-2 ">
                                <i class="icon-ruler"></i>
                                <span class="BYekan hiddenItem">لیست سایز ها</span>
                            </div>
                        </a>
                    </li>
                    <li class="itemLi">
                        <a href="{{route('sizes.create')}}" class="item px-2 d-flex align-items-center gap-2 text-white">
                            <div class="d-flex align-items-center gap-2 ">
                                <i class="icon-tapelineplus"></i>
                                <span class="BYekan hiddenItem">ثبت سایز</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="itemLi">
                <a href="javascript:void(0)" class="item px-2 d-flex align-items-center justify-content-between gap-1 text-white toggle_menu">
                    <div class="d-flex align-items-center gap-2 ">
                        <i class="icon-product-hunt"></i>
                        <span class="BYekan hiddenItem">محصولات</span>
                    </div>
                    <i class="icon-down-open icon-open open"></i>
                </a>
                <ul class="sub-menu list-unstyled open">
                    <li class="itemLi active">
                        <a href="{{route('products.index')}}" class="item px-2 d-flex align-items-center gap-2 text-white">
                            <div class="d-flex align-items-center gap-2 ">
                                <i class="icon-dropbox"></i>
                                <span class="BYekan hiddenItem">لیست محصولات</span>
                            </div>
                        </a>
                    </li>
                    <li class="itemLi">
                        <a href="{{route('products.create')}}" class="item px-2 d-flex align-items-center gap-2 text-white">
                            <div class="d-flex align-items-center gap-2 ">
                                <i class="icon-product-add"></i>
                                <span class="BYekan hiddenItem">ایجاد محصول</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</div>
