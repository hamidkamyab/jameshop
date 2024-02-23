 <section class="s-header my-4 position-absolute w-100">
     <!-- headerBox -->
     <div class="headerBox position-relative d-flex justify-content-center">
         <div class="container header-container mt-4 p-0">
             <div class="t-header-container container">
                 <div class="t-header-container-box d-flex align-items-start justify-content-between">
                     <div class="r-header-container text-white d-flex align-items-start justify-content-start">
                         <div class="d-flex align-items-center gap-1">
                             <div class="header-cartBox position-relative">
                                 <div class="d-flex align-items-center" role="button">
                                     <span
                                         class="cart-badge badge position-absolute translate-middle rounded-pill bg-danger fs-10 pt-1">0</span>
                                     <i class="icon-basket-thin fs-3 text-shadow-dark"></i>
                                     <span class="fs-14 text-shadow-dark">سبد خرید</span>
                                 </div>

                                 <div class="header-cart position-absolute start-0 rounded-1 bg-white">
                                     <div
                                         class="d-flex justify-content-center align-items-center flex-column py-5 gap-2">
                                         <img src="{{ asset('imgs/client/cart-empty.svg') }}" alt=""
                                             srcset="">
                                         <span class="fs-5 text-dark mt-1">سبد خرید شما خالی است.</span>

                                         <span class="text-muted mt-5">شاید این صفحات برای شما جذاب باشند</span>
                                         <ul
                                             class="list-unstyled d-flex justify-content-center align-items-center gap-2 fs-13">
                                             <li><a href="#" class="text-info">حراج استایل</a></li>
                                             <div class="vr-seperator bg-secondary vr-seperator-sm"></div>
                                             <li><a href="#" class="text-info">برندهای برتر</a></li>
                                             <div class="vr-seperator bg-secondary vr-seperator-sm"></div>
                                             <li><a href="#" class="text-info">خانه طراحان ایرانی</a></li>
                                         </ul>
                                     </div>
                                 </div>
                             </div>
                             <div class="vr-seperator vr-seperator-md ms-2 box-shadow-dark"></div>
                             <div class="header-userBox position-relative">
                                 <div class="d-flex align-items-center" role="button">
                                     <i class="icon-login-thin fs-3 p-0 m-0 text-shadow-dark"></i>
                                     <span class="fs-14 text-shadow-dark">وارد شوید</span>
                                 </div>

                                 <div class="header-user-msg position-absolute bg-white">
                                     <span class="text-dark fs-12 d-block w-100 text-center">وارد حساب کاربری خود
                                         شوید.</span>
                                 </div>
                             </div>
                         </div>
                     </div>


                     <div class="c-header-container d-flex flex-column px-3">
                         <div
                             class="header-log px-5 pb-4 border-1 border-bottom border-white mb-3 d-flex justify-content-center">
                             <img src="{{ asset('imgs/client/logo.svg') }}" alt="" srcset="">
                         </div>

                         <!-- header-menu -->
                         <div class="header-menu">
                             <nav class="nav d-flex align-items-center justify-content-center gap-1">

                                 @foreach ($menus as $key => $menu)
                                    @if($menu->position['original'] == 'Top')
                                     <li class="nav-item" onmouseenter="openMenu(this)">
                                         <a class="nav-link text-white text-shadow-dark position-relative"
                                             href="#">
                                             {{ $menu->title }}
                                             <span class="nav-link-triangle"></span>
                                         </a>
                                         <div class="c-mega-menu position-absolute container bg-white p-0">

                                             <ul
                                                 class="c-mega-sub-menu border-1 border-bottom border-muted list-unstyled d-flex justify-content-center align-items-center position-relative">

                                                 @foreach ($menu->children as $key => $items)
                                                     <li class="c-mega-sub-menu-item fs-15 ">

                                                         <div class="c-mega-sub-menu-title d-flex align-items-center justify-content-center px-4 py-2 gap-2"
                                                             onmouseenter="showSubMenu(this)">
                                                             <img src="{{ @$items->media[0]->file->path }}"
                                                                 alt="" srcset="">
                                                             <span>{{ $items->title }}</span>
                                                         </div>

                                                         <div class="c-mega-sub-menu-body position-absolute vw-100">
                                                             <div
                                                                 class="d-flex align-items-start justify-content-center w-100">
                                                                 <div class="c-mega-menu-right mCustomScrollbar col-6">
                                                                     <div class="col-12 d-flex flex-wrap px-3 pb-1">
                                                                         @foreach ($items->children as $key => $children)
                                                                             <div
                                                                                 class="col-4 d-flex flex-column align-items-start">


                                                                                 <h6 class="d-flex align-items-center">
                                                                                     {{ $children->title }}<i
                                                                                         class="icon-left-open-1"></i>
                                                                                 </h6>
                                                                                 <ul
                                                                                     class="c-mega-menu-cat-list d-flex col-12 flex-column list-unstyled p-0 m-0">
                                                                                     @foreach ($children->children as $subMenu)
                                                                                         <li class="py-2">
                                                                                             <a
                                                                                                 href="#">{{ $subMenu->title }}</a>
                                                                                         </li>
                                                                                     @endforeach

                                                                                 </ul>
                                                                             </div>
                                                                         @endforeach
                                                                     </div>

                                                                 </div>
                                                                 @if ($items->best == 1)
                                                                     <div
                                                                         class="vr-seperator c-mega-menu-seperator align-self-start mt-4 bg-silver col-1">
                                                                     </div>
                                                                     <div class="c-mega-menu-left col-5 px-4">
                                                                         <h6 class="ps-2">{{ $items->best_title }}
                                                                         </h6>
                                                                         <ul
                                                                             class="c-mega-menu-top-brand d-flex flex-wrap list-unstyled p-0 m-0">
                                                                             @foreach ($items->bestMenu as $bestMenu)
                                                                                 <li class="p-2 col-6">
                                                                                     <a href="{{ $bestMenu->link }}">
                                                                                         <img src="{{ $bestMenu->media[0]->file->path }}"
                                                                                             alt=""
                                                                                             srcset="">
                                                                                     </a>
                                                                                 </li>
                                                                             @endforeach
                                                                             <div class="col-10 pe-5 d-flex justify-content-end">
                                                                                <a href="{{ $items->link }}" class="d-inline-flex align-items-center justify-content-end text-dark">
                                                                                    <span>
                                                                                        مشاهده همه برندها
                                                                                    </span>
                                                                                    <i class="icon-left-open-1"></i>
                                                                                </a>
                                                                             </div>
                                                                         </ul>

                                                                     </div>
                                                                 @endif
                                                             </div>
                                                         </div>

                                                     </li>
                                                 @endforeach

                                             </ul>
                                         </div>
                                     </li>
                                    @endif
                                 @endforeach

                             </nav>
                         </div>
                     </div>
                     <!-- End header-menu -->


                     <div class="l-header-container d-flex justify-content-end align-items-start">
                         <div class="searchBox d-flex align-items-center border-bottom border-1 border-silver pe-3">
                             <i class="icon-search-thin fs-3 text-white text-shadow-dark"></i>
                             <span class="text-silver fs-13 text-shadow-dark">جستجو محصولات از 290 برند</span>
                         </div>
                     </div>
                 </div>
             </div>
             <!-- t-header-container -->
         </div>


     </div>
     <!-- End headerBox -->
 </section>
