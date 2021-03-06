var header = $('.header');

//------ Header
var header = $('.header');
var textDropdown = $('nav.menu ul li.dropdown ul li a');
var textMenu = $('nav.menu ul li a');
var menuBox = $('.menu-box');

var width = $(window).width();

$(function () {
    $(window).scroll(function () {
        var scroll = $(window).scrollTop();
        
        if (scroll >= 185 || header.hasClass('static')) {
            header.addClass('active');
        } else if(scroll < 185) {
            header.removeClass('active');
        }
    });
});

//menu-toggle
$('.menu-toggle').click(function(){
    $('.menu-box').toggleClass('slide-menu');
});

//Alert
$('.alert').find('#close').click(function(){
    $(this).parent().fadeOut();
});



//------------------------ 
// Slider
//------------------------
//Experience
//News
$('.experience .exp-box').owlCarousel({
    loop:true,
    responsiveClass:true,
    nav:false,
    stagePadding: 0,
    items: 1,
    autoplay:true,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
    margin:35,
    singleItem:true
});

//News
$('.news .news-box').owlCarousel({
    loop:true,
    margin:10,
    responsiveClass:true,
    nav:false,
    responsive:{
        0:{
            items:1,
        },
        600:{
            items:2,
            nav:false
        },
        1000:{
            items:3,
            loop:false
        }
    }
});

//Solution
$('.const-page .solution .box').owlCarousel({
    margin:5,
    responsiveClass:true,
    nav:false,
    dots:true,
    responsive:{
        0:{
            items:2,
        },
        600:{
            items:3,
        },
        1000:{
            items:4,
            loop:false
        }
    }
});