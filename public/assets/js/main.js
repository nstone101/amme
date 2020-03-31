/*------------- preloader js --------------*/
$(window).on('load', function() {
    $('.loader-wraper').fadeOut(300);
});

$(document).ready(function() {
    "use strict";
    //
    // /*------------- preloader js --------------*/
    // $(window).on('load', function() {
    //     setTimeout(function() {
    //         $('.loader-wraper').fadeOut();
    //     }, 3000);
    // });


    /*------------ Start site menu  ------------*/

    // Start sticky header
    $(window).on('scroll', function() {
        if ($(window).scrollTop() >= 150) {
            $('#sticky-header').addClass('sticky-menu');
        } else {
            $('#sticky-header').removeClass('sticky-menu');
        }
    });

    $('#category-table').DataTable({
        'responsive': true,
        'details':true
    });
    $('#qz-question-table').DataTable({
        'responsive': true,
        'details':true
    });

    $('.sidebarToggler').on('click', function(){
        $('.qz-sidebar').toggleClass('sidebarToggle')
    })

    $('.qz-sidebar').scrollbar();

    // $(document).ready(function () {
    //     $("#notification_box").fadeOut(4000);
    // });

    setTimeout(function () {
        $(".myalert").fadeOut()
    }, 4000);

    /* Add here all your JS customizations */
    $('.number-only').keypress(function (e) {
        var regex = /^[+0-9+.\b]+$/;
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        e.preventDefault();
        return false;
    });
    $('.no-regx').keypress(function (e) {
        var regex = /^[a-zA-Z+0-9+\b]+$/;
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        e.preventDefault();
        return false;
    });
//Month picker
    $('.monthpicker2').datepicker({
        autoclose: true,
        format: "mm",
        viewMode: "months",
        minViewMode: "months"
    });

//Month picker
    $('.yearpicker2').datepicker({
        autoclose: true,
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years"
    });
    $(".start_date").datepicker({
        autoclose: true,
        todayHighlight: true,
        format: "yyyy-mm-dd",
    });
    $(".end_date").datepicker({
        autoclose: true,
        todayHighlight: true,
        format: "yyyy-mm-dd",
    });
    $(".datepicker").datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true
    });
    $(".birth_datepicker").datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true
    });

});