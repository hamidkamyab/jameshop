﻿$(window).on('load', () => {
        const psl_w = $('.p-size-list-box').outerWidth();
        const psc_w = $('.p-size-list-container').outerWidth();
        if (psl_w >= psc_w) {
            $('.p-size-btn').addClass('disabled')
            $('.p-size-btn').attr('disabled', true);
        }
    })
    /************Header********** */
var headerTimeout;
$('.header-cartBox').on('mouseenter', function() {
    visibleCartTag('.header-cart', 'show')
});

$(".header-cartBox").on("mouseleave", function() {
    visibleCartTag('.header-cart', 'hidden')
});

$('.header-cart').on('mouseenter', function() {
    clearTimeout(headerTimeout);
});

$(".header-cart").on("mouseleave", function() {
    visibleCartTag('.header-cart', 'hidden')
});

$('.header-userBox').on('mouseenter', function() {
    visibleCartTag('.header-user-msg', 'show')
});

$('.header-userBox').on("mouseleave", function() {
    visibleCartTag('.header-user-msg', 'hidden')
});

function visibleCartTag(tag, status = '') {
    if (status == 'show') {
        $(tag).fadeIn();
    }
    if (status == 'hidden') {
        headerTimeout = setTimeout(() => {
            $(tag).fadeOut();
        }, 1000);
    }

}

/****Slider****/
var slideCount = 0;
var slideTimer;
const len = $('.sliderUl li').length;

function automaticSlider() {
    let time = $('.slider').attr('data-slider-time');
    if (!time) {
        time = 4000;
    }
    slideTimer = setInterval(() => {
        slideCount++;
        slider()
    }, time);
}
automaticSlider()

function slider() {
    if (slideCount >= len) {
        slideCount = 0;
    }
    if (slideCount < 0) {
        slideCount = len - 1;
    }
    let slideId = '#slide-' + slideCount;
    let paginateId = '#sliderPaginateItem-' + slideCount;

    $('.sliderUl li').fadeOut();
    $(slideId).fadeIn();
    $('.sliderPaginateItem').removeClass('active')
    $(paginateId).addClass('active')
}

function gotToSlide(tag, index) {
    let slideId = '#slide-' + index;
    clearInterval(slideTimer);
    $('.sliderUl li').fadeOut();
    $(slideId).fadeIn();
    $('.sliderPaginateItem').removeClass('active')
    $(tag).addClass('active')
    slideCount = index;
    automaticSlider()
}

$('.nextSlide').click(function() {
    slideCount++;
    clearInterval(slideTimer);
    slider()
    automaticSlider()
});

$('.prevSlide').click(function() {
    slideCount--;
    clearInterval(slideTimer);
    slider()
    automaticSlider()
});
/*********/

/******Menu***** */
var menuTimeout;

function openMenu(tag) {
    clearTimeout(menuTimeout);
    if (!$(tag).hasClass('active')) {
        $('.header-menu .nav-item').removeClass('active');
        $('.header-menu .nav-item .c-mega-menu').fadeOut();
        $('.header-menu .nav-item .nav-link-triangle').fadeOut();
        $(tag).addClass('active');
        $('.c-mega-menu', tag).fadeIn();
        $('.nav-link-triangle', tag).fadeIn();
        $('.c-mega-sub-menu-item').removeClass('active');
        $('.c-mega-sub-menu-item:first-child', tag).addClass('active');
    }
}

$('.header-menu .nav-item').mouseleave(function() {
    menuTimeout = setTimeout(() => {
        $('.header-menu .nav-item').removeClass('active');
        $('.header-menu .nav-item .c-mega-menu').fadeOut();
        $('.header-menu .nav-item .nav-link-triangle').fadeOut();
    }, 500);
});

$('.c-mega-menu').mouseenter(function(e) {
    clearTimeout(menuTimeout);
});

function showSubMenu(tag) {
    const parentTag = $(tag).parent('.c-mega-sub-menu-item')
    if (!$(parentTag).hasClass('active')) {
        $('.c-mega-sub-menu-item').removeClass('active');
        $(parentTag).addClass('active');
    }
}



/****** */
/************************** */

$(window).on('load', () => {
    swMains = document.querySelectorAll('.swiper-main');
    swMains.forEach(sw => {
        let swWidth = $(sw).outerWidth();
        let swItems = $(sw).find('.swiper-items');
        let swItemwidth = $(swItems[0]).outerWidth();
        let swNum = Math.floor(swWidth / swItemwidth);
        let swPageCount = Math.ceil($(swItems).length / swNum);
        if (swPageCount <= 1) {
            $('.swiper-btn-prev', sw).addClass('disabled')
            $('.swiper-btn-prev', sw).attr('disabled', true)
            $('.swiper-btn-next', sw).addClass('disabled')
            $('.swiper-btn-next', sw).attr('disabled', true)
        }
    })
})

$('.swiper-btn.swiper-btn-next').click(function(e) {
    let swPage;
    const swiper = $(e.target).parents('.swiper-main')[0];
    let swiperItems = $(swiper).find('.swiper-items');
    let swiperItemwidth = $(swiperItems[0]).outerWidth();
    let swiperWidth = $(swiper).outerWidth();
    let swNum = Math.floor(swiperWidth / swiperItemwidth);

    let swPageCount = Math.ceil($(swiperItems).length / swNum);

    swPage = $(swiper).attr('data-s-count');

    let mrValue = parseInt($(swiper).attr('data-m-right'));

    swPage++;
    let marginRight = (swNum * swiperItemwidth) + mrValue;
    if (swPageCount > 1) {
        if (swPage == swPageCount) {
            marginRight = mrValue + (swNum * swiperItemwidth);
            $(e.target).attr('disabled', true);
            $(e.target).addClass('disabled');
        }
        $(swiper).attr('data-m-right', marginRight);
        $(swiper).attr('data-s-count', swPage);

        if ($(swiper).attr('data-swiper-fade') == 'true') {
            $(swiperItems).fadeOut(200)
            $(swiperItems).fadeIn(400)
        }
        $('.swiper-btn-prev', swiper).removeClass('disabled')
        $('.swiper-btn-prev', swiper).attr('disabled', false)
        $('.swiper-container', swiper).css('margin-right', -marginRight + 'px');
    }
});

$('.swiper-btn.swiper-btn-prev').click(function(e) {
    let swPage;

    const swiper = $(e.target).parents('.swiper-main')[0];
    let swiperItems = $(swiper).find('.swiper-items');
    let swiperItemwidth = $(swiperItems[0]).outerWidth();
    let swiperWidth = $(swiper).outerWidth();
    let swNum = Math.floor(swiperWidth / swiperItemwidth);

    swPage = $(swiper).attr('data-s-count');
    let mrValue = parseInt($(swiper).attr('data-m-right'));

    swPage--;
    let marginRight = mrValue - (swiperItemwidth * swNum);

    if (swPage == 1) {
        marginRight = 0;
        $(e.target).attr('disabled', true);
        $(e.target).addClass('disabled');
    }
    $(swiper).attr('data-m-right', marginRight);
    $(swiper).attr('data-s-count', swPage);



    if ($(swiper).attr('data-swiper-fade') == 'true') {
        $(swiperItems).fadeOut(200)
        $(swiperItems).fadeIn(400)
    }
    $('.swiper-btn-next', swiper).removeClass('disabled')
    $('.swiper-btn-next', swiper).attr('disabled', false)
    $('.swiper-container', swiper).css('margin-right', -marginRight + 'px');

});



// $('.swiper-btn.swiper-btn-next').click(function(e) {
//     const swiper = $(e.target).parents('.swiper-main')[0];
//     let swiperItems = $(swiper).find('.swiper-items');
//     let swiperItemwidth = $(swiperItems[0]).outerWidth();
//     let swiperContainerWidth = $('.swiper-container', swiper).outerWidth();

//     let mrValue = parseInt($(swiper).attr('data-m-right'));
//     let marginRight = (mrValue - swiperItemwidth);
//     $(swiper).attr('data-m-right', marginRight);
//     if (-(swiperContainerWidth - swiperItemwidth) <= marginRight) {
//         if ($(swiper).attr('data-swiper-fade') == 'true') {
//             $(swiperItems).fadeOut(200)
//             $(swiperItems).fadeIn(400)
//         }
//         $('.swiper-btn-prev', swiper).removeClass('disabled')
//         $('.swiper-btn-prev', swiper).attr('disabled', false)
//         $('.swiper-container', swiper).css('margin-right', marginRight + 'px');

//         if (-(swiperContainerWidth - swiperItemwidth) == marginRight) {
//             $(e.target).attr('disabled', true);
//             $(e.target).addClass('disabled');
//         }
//     }
// });

// $('.swiper-btn.swiper-btn-prev').click(function(e) {
//     const swiper = $(e.target).parents('.swiper-main')[0];
//     let swiperItems = $(swiper).find('.swiper-items');
//     let swiperItemwidth = $(swiperItems[0]).outerWidth();
//     let mrValue = parseInt($(swiper).attr('data-m-right'));
//     let marginRight = (mrValue + swiperItemwidth);
//     $(swiper).attr('data-m-right', marginRight);
//     if (marginRight <= 0) {
//         if ($(swiper).attr('data-swiper-fade') == 'true') {
//             $(swiperItems).fadeOut(200)
//             $(swiperItems).fadeIn(400)
//         }
//         $('.swiper-btn-next', swiper).removeClass('disabled')
//         $('.swiper-btn-next', swiper).attr('disabled', false)
//         $('.swiper-container', swiper).css('margin-right', marginRight + 'px');
//         if (marginRight == 0) {
//             $(e.target).attr('disabled', true);
//             $(e.target).addClass('disabled');
//         }
//     }
// });

$('.col-more').click(function() {
    $('.col-more-d').toggleClass('open')
    $('.col-more-o').toggleClass('close')
    $('.col-more-c').toggleClass('close')
});


$('.p-size-btn.p-size-btn-next').click(function(e) {
    if (!$(e.target).hasClass('disabled')) {
        const parent = $(e.target).parents('.p-size-list')[0];
        const box = $('.p-size-list-box', parent)[0];
        const w_box = $(box).outerWidth();
        const w_ps_container = $('.p-size-list-container', box).outerWidth();

        let mrValue = parseInt($(box).attr('data-m-right'));
        let marginRight = mrValue + w_box - 46;
        $(box).attr('data-m-right', marginRight);

        if (marginRight <= w_ps_container) {
            $('.p-size-btn-prev', parent).removeClass('disabled')
            $('.p-size-btn-prev', parent).attr('disabled', false)
            $('.p-size-list-container', box).css('margin-right', -marginRight + 'px');
        }
        if (marginRight + w_box >= w_ps_container) {
            $(e.target).attr('disabled', true);
            $(e.target).addClass('disabled');
        }
    }
});

$('.p-size-btn.p-size-btn-prev').click(function(e) {
    if (!$(e.target).hasClass('disabled')) {
        const parent = $(e.target).parents('.p-size-list')[0];
        const box = $('.p-size-list-box', parent)[0];
        const w_box = $(box).outerWidth();
        const w_ps_container = $('.p-size-list-container', box).outerWidth();

        let mrValue = parseInt($(box).attr('data-m-right'));
        let marginRight = mrValue - w_box;
        if (marginRight <= 0) {
            marginRight = 0;
        }
        $(box).attr('data-m-right', marginRight);

        if (marginRight <= w_ps_container) {
            $('.p-size-btn-next', parent).removeClass('disabled')
            $('.p-size-btn-next', parent).attr('disabled', false)
            $('.p-size-list-container', box).css('margin-right', -marginRight + 'px');
        }
        if (marginRight == 0) {
            $(e.target).attr('disabled', true);
            $(e.target).addClass('disabled');
        }
    }
});

$('.p-size-list-container li span').on('click', (e) => {
    $('.p-size-list-container li span').removeClass('active')
    $(e.target).addClass('active');
    $('.p-size-s').text($(e.target).text());
})


document.addEventListener('DOMContentLoaded', function() {

    let floatingOffsetList = [];
    let count = 0;
    let lastScrollPosition = 0;
    let id;

    var targetTag = document.querySelectorAll('*[data-id="target-f"]');
    var floatingElement = $('.floating-tag');
    targetTag.forEach(element => {
        floatingOffsetList.push($(element).offset().top)
    });

    $(window).scroll(function() {
        let currentScrollPosition = window.scrollY;
        if (currentScrollPosition > lastScrollPosition) {
            if ($(this).scrollTop() > floatingOffsetList[count]) {
                floatingElement.fadeIn(0);
                id = '#' + $(targetTag[count]).attr('id') + "-link"
                $('.p-floating-link').removeClass('active')
                $(id).addClass('active');

                count++;
            }
        } else if (currentScrollPosition < lastScrollPosition) {
            if ($(this).scrollTop() < floatingOffsetList[0]) {
                count = 0;
                floatingElement.fadeOut(0);
            } else if ($(this).scrollTop() < floatingOffsetList[count - 1]) {
                count--;

                id = '#' + $(targetTag[count - 1]).attr('id') + "-link"
                $('.p-floating-link').removeClass('active')
                $(id).addClass('active');
            }
        }
        lastScrollPosition = currentScrollPosition;
    });
});

$('.p-floating-link').on('click', (e) => {
    $('.p-floating-link').removeClass('active')
    $(e.target).addClass('active');
})


function calculateRemainingTime(targetDate) {
    var currentDate = new Date();
    var currentTime = currentDate.getTime(); // به میلی‌ثانیه

    var targetDateTime = new Date(targetDate).getTime(); // به میلی‌ثانیه

    // محاسبه مدت زمان باقی‌مانده به میلی‌ثانیه
    var remainingTime = targetDateTime - currentTime;
    return Math.max(remainingTime, 0);
}


function displayTimer(remainingTime) {
    // // به میلی‌ثانیه، دقیقه و ساعت تبدیل شده
    var remainingSeconds = Math.floor(remainingTime / 1000);
    var remainingMinutes = Math.floor(remainingSeconds / 60);
    var remainingHours = Math.floor(remainingMinutes / 60);

    // // محاسبه مقادیر دقیقه و ثانیه باقی‌مانده
    var displayMinutes = remainingMinutes % 60;
    var displaySeconds = remainingSeconds % 60;

    $('.hours').text(remainingHours.toString().padStart(2, '0'));
    $('.minutes').text(displayMinutes.toString().padStart(2, '0'));
    $('.seconds').text(displaySeconds.toString().padStart(2, '0'));
}

function updateTimer() {
    if (targetDate) {
        var remainingTime = calculateRemainingTime(targetDate);
        displayTimer(remainingTime);
        if (remainingTime > 0) {
            requestAnimationFrame(updateTimer);
        } else {
            $('.s-amazing').fadeOut()
        }
    }
}

updateTimer(); // شروع تایمر