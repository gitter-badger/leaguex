/*!
*   LEAGUEX
*   @copyright (C) 2014 fankstribe. All rights reserved.
*   @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*   License: Open source - MIT
*   @link http://www.fankstribe.org 
!*/

/* Dynamic modal width */
function modalWidth(){
    var windowSize = $(window).width();
    function calcVH() {
        $('.modal-body-custom').innerHeight( $(this).innerHeight() -56*2  );
    }
    calcVH();
    if(windowSize < 750){
            calcVH();
        }else{
            $('.modal-body-custom').css("height", "");
        }
}

/* Empty image */
function imgError(image) {
    image.onerror = "";
    image.src = base + "assets/img/no-image.png";
    return true;
}
  
/* Out side events */
if($('.float-button').length){
    $('.comments-widget').click(function(){
        $('.float-button').fadeOut('medium');
        $(this).bind('focusoutside clickoutside', function(e){
            $('.float-button').fadeIn('medium');
        });
    });
}

/* Set body height */
function bodyHeight(){
    $(window).on('resize', function(){
        var h = $(window).height();
        $("body").css({'min-height' : h+'px', 'bottom' : 'auto', 'right' : 'auto', 'width' : 'auto', 'height' : '100%'});
    }).resize();
}

/* Hide - Show header when user scroll  */
function hideHeader(){
    var windowSize = $(window).width();
    var didScroll;
    var lastScrollTop = 0;
    var delta = 5;
    var navbarHeight = $('.header-container').outerHeight();
    if(windowSize < 750){
        $(window).scroll(function(e){
            didScroll = true;
        });
    }else{
        $(window).off('scroll');
    }
    if(windowSize < 750){
    setInterval(function() {
        if (didScroll) {
            hasScrolled();
            didScroll = false;
        }
    }, 250);
     }else{
        $(window).off('scroll');
    }
           
    function hasScrolled() {
        var st = $(this).scrollTop();
        if(Math.abs(lastScrollTop - st) <= delta)
            return;
            if(st > lastScrollTop && st > navbarHeight){
                $('.header-container').removeClass('nav-down').addClass('nav-up');
            }else{
            if(st + $(window).height() < $(document).height()) {
                $('.header-container').removeClass('nav-up').addClass('nav-down');
            }
        }
        lastScrollTop = st;
    }
}

/* Hide - Show float button when scroll to bottom  */
function hideFloatButton(){
    var senseSpeed = 5;
    var previousScroll = 0;
    if($(window).width() < 961){
        $(window).scroll(function(event){
            var scroller = $(this).scrollTop();
            if (scroller-senseSpeed > previousScroll){
              $('.float-button').filter(':not(:animated)').slideUp();
            }else if (scroller+senseSpeed < previousScroll) {
                $('.float-button').filter(':not(:animated)').slideDown();
            }
            previousScroll = scroller;
         });
    }else{
        $(window).off('scroll');
    }
}

/* Disable body scroll when sidebar and dropdown notifications is visible */
function nobodyScroll(){
    var $body = $('body'),
        scrollDisabled = false,
        scrollTop;

    function scrollDisable() {
        if (scrollDisabled) {
            return;
        }
        scrollTop = $(window).scrollTop();

        $body.addClass('noscroll').css({
            top: -1 * scrollTop
        });

        scrollDisabled = true;
    }

    function scrollEnable() {
        if (!scrollDisabled) {
            return;
        }

        $body.removeClass('noscroll');
        $(window).scrollTop(scrollTop);

        scrollDisabled = false;
    }
    $('.dropdown.notifications').on('show.bs.dropdown', function(){
        scrollDisable(); 
    });
    $('.dropdown.notifications').on('hidden.bs.dropdown', function(){
        scrollEnable();
    });
    $('#sidebarChat, #sidebar-chat-mb-close').on('click', function(){
        if($("html").hasClass("sidebar-chat-opened")) {
            scrollDisable();  
        }else{
            scrollEnable();
        }
    });
}

/* Load page transition */
function showLoading() {
    var transition = $('#check-transition').val();
    var indur = "";
    var outdur = "";
    if(transition === '1') {
        indur = 0;
        outdur = 0;
    } else {
        indur = 300;
        outdur = 300;
    }
    
    if($('.animsition').length && $.fn.animsition){
        $(".animsition").animsition({
            inClass: 'fade-in-up-sm',
            outClass: 'fade-out-down-sm',
            inDuration: indur,
            outDuration: outdur,
            linkElement: '.animsition-link',
            loading: true,
            loadingParentElement: 'body', //animsition wrapper element
            loadingClass: 'loadpage',
            timeout: false,
            timeoutCountdown: 5000,
            onLoadEvent: true,
            browser: ['animation-duration', '-webkit-animation-duration'],
            // "browser" option allows you to disable the "animsition" in case the css property in the array is not supported by your browser.
            // The default setting is to disable the "animsition" in a browser that does not support "animation-duration".
            overlay: false,
            overlayClass: 'animsition-overlay-slide',
            overlayParentElement: 'body'
        });
    }
 }
 
/* Select pick */
function selectPick() {
    if($('.selectpicker').length && $.fn.selectpicker) {
        $('.selectpicker').selectpicker({
            container: 'body',
            style: 'select-with-transition',
            iconBase: 'material-icons',
            tickIcon: 'done',
            dropupAuto: true
        });
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
            $('.selectpicker').selectpicker('mobile');
        }
    }
}
/* Navbar tabs */
function pullHeaderBottom(){
    if($('.nav-tabs-bar').length){
        $('html').addClass('navtabs');
    } else {
        $('html').removeClass('navtabs');
    }
}
/* Active Tabs */
function tabsTransition(){
    $('.tab-container a').click(function(e){
        $('.tab-container').removeClass('active');
        $(this).parent().addClass('active');
      
        
    });
}
/* Javascript to enable link to tab */
function tabsLink() {
        var hash = document.location.hash;
        var prefix = "tab-";
        if(hash) {
            $('.tab-container').removeClass("active");
            $('.nav-tabs-bar a[href=' + hash.replace(prefix, "") + ']').tab('show').parent().addClass('active');
            
        }

        // Change hash for page-reload
        $('.nav-tabs-bar a').on('shown.bs.tab', function(e) {
            window.location.hash = e.target.hash.replace("#", "#" + prefix);
        });
    }
//* Window resize */
function checkWidth() {
    $(window).on('resize', function() {
        if($(window).width() > 750) {
            $('html').removeClass('sidebar-opened');
            $('html').removeClass('sidebar-mb-opened');
        }
    });
}
/* Sidebar left nicescroll */
function sidebarLeftScroll() {
    var heightSidebarLeft = $(window).outerHeight();
    $('.sidebar-left .sidebar-container').height(heightSidebarLeft).niceScroll({
        cursorwidth: '4px',
        cursorborder: '0px',
        cursorcolor: 'trasparent',
        railalign: 'right'
    });
}
/* Sidebar right nicescroll */
function sidebarRightScroll() {
    var heightSidebarRight = $(window).outerHeight();
    $('.sidebar-right .viewport .content').height(heightSidebarRight).niceScroll({
        cursorwidth: '4px',
        cursorborder: '0px',
        cursorcolor: 'trasparent',
        railalign: 'right'
    });
}
/* Toggle chat open */
function showChat() {
    $(document).on('click', '[data-toggle="show-chat"],[data-toggle="close-chat"]', function(e) {
        e.preventDefault();
        if($(".sidebar-right").hasClass("show-chat")) {
            $(".sidebar-right").removeClass("show-chat");
        }else{
            $(".sidebar-right").addClass("show-chat");
        }
    });
}

/* Toggle Sidebar */
function sidebarMenu() {
    $('#navbar-left,#sidebar-mb-close').on('click', function() {
        if($('html').hasClass('sidebar-chat-opened')){
            $('html').removeClass('sidebar-chat-opened');
        }
        if($('html').hasClass('notification-sidebar-opened')){
            $('html').removeClass('notification-sidebar-opened');
        }
        ($(window).width() > 750) ? $('html').toggleClass('full-size'): $('html').toggleClass('sidebar-mb-opened');
    });
}
function sidebarChat() {
    $('#sidebarChat, #sidebar-chat-mb-close').on('click', function(){
        if($('.float-button').length){
            $('.float-button').toggle();
        }
        if($('html').hasClass('notification-sidebar-opened')){
            $('html').removeClass('notification-sidebar-opened');
        }
        if($('html').hasClass('sidebar-mb-opened')){
            $('html').removeClass('sidebar-mb-opened');
        }
        if($(window).width() > 750) {
            $('html').toggleClass('sidebar-chat-opened');
        }else{
            $('html').toggleClass('sidebar-chat-opened');
            $('html').removeClass('sidebar-opened');
        }
    });
}
 /* Toggle submenu */
function submenu() {
    $('.content>.content-menu').click(function(e){
        e.preventDefault();
        var target = $(this);
        var item = $(this).next();
        if(!target.hasClass('menu-open')) {
            $('.content-menu.menu-open').next().slideUp('fast');
            $('.content-menu.menu-open').toggleClass('menu-open');
        }
        $(this).toggleClass('menu-open');
        if($(this).hasClass('menu-open')) {
            item.slideDown('fast');
        } else {
            item.slideUp('fast');
        }
    });
}
/* Tooltip */
function tooltip() {
        $('[data-toggle="tooltip"]').tooltip();
}
    
/* Toast */
function toast() {
    $.notifyDefaults({
        placement: {
            from: "bottom",
            align: "left"
        },
        animate: {
            enter: 'animated slideInUp',
            exit: 'animated slideOutDown'
	},
        type: "custom",
        delay: 2000,
        spacing: 20,
        allow_dismiss: false
    });
}
/* Function image upload */
function imageUpload() {
    if($('.preview').length) {
        var icon = $('.upload-logo');
        var icon_profile = $('.profile-avatar-btn');
        var button = $('#upload');
        var thumb = $('#thumbImg');
        var preview = $('.preview');
        var url = $('#image-preview').attr("data-url");
        var tmp = $('#image-preview').attr("data-img");
        new AjaxUpload(button, {
            action: url,
            responseType: 'json',
            onSubmit: function(file, ext) {
                if(ext && /^(jpg|png|jpeg|gif)$/.test(ext)) {
                    this.setData({'key': $('#image-preview').attr("data-id")});
                    thumb.hide();
                    icon.hide();
                    icon_profile.hide();
                    if($('.comments-widget').length){
                        preview.slideDown(500).css('display', 'inline-block');
                    } else {
                        preview.css('display', 'inline-block');
                    }
                }else{
                    bootbox.dialog({
                        message: imgType,
                        title: alertDanger,
                        size: 'small',
                        closeButton: false,
                        buttons: {
                            danger: {
                                label: alertOk,
                                className: "btn-info",
                                callback: function() {}
                            }
                        }
                    });
                    return false;
                }
            },
            onComplete: function(file, json) {
                if(json['error']) {
                    bootbox.dialog({
                        message: json['error'],
                        title: alertDanger,
                        size: 'small',
                        closeButton: false,
                        buttons: {
                            danger: {
                                label: alertOk,
                                className: "btn-info",
                                callback: function() {}
                            }
                        }
                    });
                    
                    preview.css('display', 'none'); 
                    icon.show();
                    icon_profile.show();
                    thumb.show();
                    return false;
                }
                setTimeout(function(){
                    if(json['success']) {
                        var image = tmp + '/' + json['photo_file'];
                        var img_ghost = $('#img-ghost');
                        img_ghost.val(json['photo_file']); 
                        thumb.attr('src', image);
                        preview.hide();                         
                        $('#imageid').val(json['photo_file']);
                        icon.show();
                        icon_profile.show();
                        thumb.fadeIn(400);
                        if(!$('.comments-widget, #img-ghost').length){
                        $.notify({message: updateSuccessMessage});    
                        }
                    }
                },1000);
            }
        });
        $('input[type="file"]').on('click', function(e){
    // code here
});
    };
}
/* Function file upload */
function fileUpload(fileid){
    if('undefined' !== typeof fileid){
        var button = $('#uploadFile_' + fileid);
        var url = $('#inputFile').attr("data-url");
        var iconurl = $('#iconclear').attr("data-clear");
        new AjaxUpload(button, {
            action: url,
            responseType: 'json',
            onSubmit: function(file, ext) {
                if(ext && /^(jpg|png|jpeg)$/.test(ext)) {}else{
                    bootbox.dialog({
                        message: imgType,
                        title: alertDanger,
                        size: 'small',
                        closeButton: false,
                        buttons: {
                            danger: {
                                label: alertOk,
                                className: "btn-info",
                                callback: function() {}
                            }
                        }
                    });
                    return false;
                }
            },
            onComplete: function(file, json) {
                if(json['error']) {
                    bootbox.dialog({
                        message: json['error'],
                        title: alertDanger,
                        size: 'small',
                        closeButton: false,
                        buttons: {
                            danger: {
                                label: alertOk,
                                className: "btn-info",
                                callback: function() {}
                            }
                        }
                    });
                    return false;
                }
                if(json['success']){
                    var iconclear = $(button).closest('.form-group').find('#iconclear');
                    var file_ghost = $(button).closest('.form-group').find('#inputFile');
                    file_ghost.val(json['photo_file']); 
                    if(!$('#inputFile').length){
                        $.notify({message: updateSuccessMessage});    
                    }
                    $(iconclear).on('click', function(){
                        
                        file_ghost.val(''); 
                        
                    });
                }
            }
        });
    }
}
/* Clear input value */
function cleareInputValue(){
    if($('.icon-clear').length){
        $('input.icon-clear').each(function(){
            var icon = $(this).next();
            $(this).on('keyup', function(){
                $(icon).show();
            });
            $(this).on('focusin', function(){
                if($(this).val() != ''){
                $(icon).show();}
            }).on('focusout', function(){
                setTimeout(function(){
                    $(icon).hide();
                },150);
            });
            $(icon).on('click', function(){
                $(this).prev().val('').focus();
                $(this).hide();
            });
        });
    }
}


/****  Init of Main Functions  ****/
$(document).ready(function(){
    $.material.init();
    modalWidth();
    bodyHeight();
    showLoading();
    checkWidth();
    selectPick();
    pullHeaderBottom();
    tabsTransition();
    tabsLink();
    sidebarLeftScroll();
    sidebarRightScroll();
    showChat();
    sidebarMenu();
    sidebarChat();
    submenu();
    tooltip();
    toast();
    imageUpload();
    fileUpload();
    cleareInputValue();
    nobodyScroll();
    hideHeader();
    $(window).resize(hideHeader);
    hideFloatButton();
    $(window).resize(hideFloatButton);
    $(window).resize(modalWidth);
});