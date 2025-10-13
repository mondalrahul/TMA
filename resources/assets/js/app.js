
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

//window.Vue = require('vue');
//
///**
// * Next, we will create a fresh Vue application instance and attach it to
// * the page. Then, you may begin adding components to this application
// * or customize the JavaScript scaffolding to fit your unique needs.
// */
//
//Vue.component('example', require('./components/Example.vue'));
//
//const app = new Vue({
//    el: '#app'
//});
//

$(function() {
    // $('#forgotPasswordModal').modal();
    $('.home-image-slider .image-slider').slick({
        arrows: true,
        autoplay: true,
        autoplaySpeed: 5000
    });

    $('.promotion .promotion-slider').slick({
        arrows: false,
        dots: true,
    });

    $('.product-gallery-slider').slick({
        arrows: true,
        dots: true,
        autoplay: true,
        autoplaySpeed: 3000,
        customPaging : function(slider, i) {
            var thumb = $(slider.$slides[i]).find('img').data('thumb');
            return '<div style="background-image: url(\''+thumb+'\')">&nbsp;</div>';
        }
    });

    $('.product-detail-wrapper .book-btn').click(function() {
        $('#paymentModal').modal();
        return false;
    });

    $('#faq_list .collapse').on('show.bs.collapse', function () {
        $(this).siblings('.faq-header').addClass('active');
    });
    
    $('#faq_list .collapse').on('hide.bs.collapse', function () {
        $(this).siblings('.faq-header').removeClass('active');
    });

    $('.datepicker-element').datepicker();

    new WOW().init();

    // sticky menu
    chooseMenuToShow();
    $(window).scroll(chooseMenuToShow);
})

adjustHeaderMargin();

$(window).resize(adjustHeaderMargin);


function adjustHeaderMargin() {
  var pages = [
    '.trident-life-style-page',
    '.faq-page',
    '.contact-page',
    '.product-detail-wrapper',
    '.account-page',
    '.add-boat-page',
    '.my-booking-page',
    '.add-boat-page',
    '.my-boat-page',
    '.self-drive-page',
    '.upgrade-account-page',
  ];
    var height = $('header').height();
    $(pages.join(', ')).css('padding-top',  height + 'px');
}


function showMiniMenu(flag) {
  var header = $('header'),
    headerHeight = header.height();

  header.css('top', '-' + headerHeight + 'px');
  clearTimeout(window.menuTimer);

  window.menuTimer = setTimeout(function(flag) {
    flag ? header.addClass('mini') : header.removeClass('mini');
    header.css('top', '0px');
    window.menuIsChanging = false;
  }.bind(undefined, flag), 300)
}

function chooseMenuToShow() {
  var top = window.pageYOffset || document.documentElement.scrollTop,
    breakpoint = 100;
  
  if (top > breakpoint && !$('header').hasClass('mini') && window.menuIsChanging !== true) {
    showMiniMenu(true);
    window.menuIsChanging = true;
  }

  if (top <= breakpoint && $('header').hasClass('mini') && window.menuIsChanging !== true) {
    showMiniMenu(false);
    window.menuIsChanging = true;
  }
}
