
$(function(){ 'use strict';

// Topnav
var topnav = $('nav.topnav'),
    topnavSecretary = $('nav.topnav-secretary'),
    topnavMinisite = $('nav.topnav-minisite');
var sidenav = $('nav.sidenav'),
    sidenavMenus = sidenav.find('.menu-container'),
    sidenavToggle = $('nav .sidenav-toggle');

if(topnav.length){
    // Topnav Dropdown
    var topnavDropdown = $('.topnav-dropdown'),
        topnavDropdownToggle = $('.topnav-dropdown-toggle');
    topnavDropdownToggle.click(function(e){
        e.preventDefault();
        if(topnavDropdown.hasClass('active')){
            topnavDropdown.removeClass('active');
            topnavDropdownToggle.find('.hamburger').removeClass('active');
            $('html, body').removeClass('topnav-dropdown-opened');
        }else{
            topnavDropdown.addClass('active');
            topnavDropdownToggle.find('.hamburger').addClass('active');
            $('html, body').addClass('topnav-dropdown-opened');
        }
    });
}

if(topnavSecretary.length){
    // Generate Sidenav
    sidenavMenus.html( topnavSecretary.find('#topnav-menu').html() );
    sidenavMenus.find('.num, .title, .submenu-title').remove();
    sidenavMenus.find('.has-children').each(function(){
        $(this).append('<div class="dropdown-toggle"><em class="fas fa-chevron-right"></em></div>');
    });
    sidenavMenus.find('.dropdown-toggle').click(function(e){
        e.preventDefault();
        var self = $(this);
        self.toggleClass('active');
        self.prev().slideToggle();
    });
}

if(topnavMinisite.length){
    // Generate Sidenav
    sidenavMenus.html( topnavMinisite.find('#topnav-menu').html() );
    sidenavMenus.find('.num, .title, .submenu-title').remove();
    sidenavMenus.find('.has-children').each(function(){
        $(this).append('<div class="dropdown-toggle"><em class="fas fa-chevron-right"></em></div>');
    });
    sidenavMenus.find('.dropdown-toggle').click(function(e){
        e.preventDefault();
        var self = $(this);
        self.toggleClass('active');
        self.prev().slideToggle();
    });
}

// Sidenav Toggle
sidenavToggle.click(function(e){
    e.preventDefault();
    if($('body').hasClass('sidenav-opened')){
        $('html, body').removeClass('sidenav-opened');
        sidenavToggle.find('> *').removeClass('active');
        sidenav.removeClass('active');
    }else{
        $('html, body').addClass('sidenav-opened');
        sidenavToggle.find('> *').addClass('active');
        sidenav.addClass('active');
    }
});
$('.sidenav-filter').click(function(e){
    e.preventDefault();
    $('html, body').removeClass('sidenav-opened');
    sidenavToggle.find('> *').removeClass('active');
    sidenav.removeClass('active');
});

// Back to Top
var backToTop = $('.back-to-top');
backToTop.click(function(e){
    e.preventDefault();
    $('html, body').stop().animate({ scrollTop: 0 }, 800 );
});

// Global Search Container
var globalSearchContainer = $('.global-search-container'),
    globalSearchToggles = $('.global-search-toggle');
if(globalSearchContainer.length && globalSearchToggles.length){
    globalSearchToggles.click(function(e){
        e.preventDefault();
        globalSearchToggles.toggleClass('active');
        globalSearchContainer.toggleClass('active');
        if(globalSearchContainer.hasClass('active')){
            globalSearchContainer.find('input[type=text]').focus();
            $('html, body').addClass('global-search-opened');
        }else{
            $('html, body').removeClass('global-search-opened');
        }
    });
}

// Accessibility Container
var accessibilityContainer = $('.accessibility-container'),
    accessibilityToggles = $('.accessibility-toggle');
if(accessibilityContainer.length && accessibilityToggles.length){
    accessibilityToggles.click(function(e){
        e.preventDefault();
        accessibilityToggles.toggleClass('active');
        accessibilityContainer.toggleClass('active');
    });
}

// Font Sizes
var bodySize = 16;
$('.btn.font-size-btn').click(function(e){
    e.preventDefault();
    var s = Number($(this).data('size'));
    if(s==0) bodySize = 16;
    else if(s==1 || s==-1) bodySize += s;
    else bodySize = s;
    $('html, body').css('font-size', bodySize+'px');
});

// Themes
$('.theme-btn').click(function(e){
    e.preventDefault();
    $('#css-theme').attr('href', 'public/assets/app/css/color-'+$(this).data('theme')+'.css');
    $('body').removeClass('theme-0 theme-1 theme-2');
    $('body').addClass('theme-'+$(this).data('theme'));
});


// Check on Scroll
function checkOnScroll(st){
    if(st > 4*bodySize){
        backToTop.addClass('active');
    }else{
        backToTop.removeClass('active');
    }
    if(st > 16*bodySize){
        topnavSecretary.addClass('sticky');
    }else{
        topnavSecretary.removeClass('sticky');
    }
}
checkOnScroll( $(window).scrollTop() );
$(window).scroll(function(){
    checkOnScroll( $(this).scrollTop() );
});


// Date Picker
$('input.date-picker').each(function(){
    new Datepicker($(this)[0], {});
});

// Dropzone
$('.input-dropzone').each(function(){
    $(this).dropzone({
        url: 'writable',
        acceptedFiles: 'image/*,application/pdf',
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 5,
        maxFiles: 5,
        maxFilesize: 5,
        addRemoveLinks: true,
    });
});


// Button Toggle
$('.btn-toggle').click(function(e){
    e.preventDefault();
    $('.toggle-target[data-toggle="'+$(this).data('toggle')+'"]').toggleClass('active');
});

// Button Popup
$('.btn-popup-toggle').click(function(e){
    e.preventDefault();
    $('.popup-container[data-popup="'+$(this).data('popup')+'"]').toggleClass('active');
});

// Button Copy
var copyReady = true;
$('a[data-copy]').click(function(e){
    e.preventDefault();
    var self = $(this),
        target = $('textarea[data-copy="'+self.data('copy')+'"]');
    if(copyReady && target.length){
        copyReady = false;
        target[0].select();
        target[0].setSelectionRange(0, target[0].value.length);
        document.execCommand('copy');
        target.blur();
        self.html('<em class="fas fa-check mr-1"></em> คัดลอกโค๊ดสำเร็จ');
        setTimeout(function(){
            copyReady = true;
            self.closest('.toggle-target').removeClass('active');
            self.html('คัดลอกโค้ด');
        }, 2000);
    }
});


// Tab Container
var tabContainers = $('.tab-container');
if(tabContainers.length){
    tabContainers.each(function(){
        var self = $(this),
            tabs = self.find('.tabs > .tab'),
            tabContents = self.find('.tab-contents > .tab-content');
        tabs.click(function(e){
            var target = tabContents.filter('[data-tab="'+$(this).data('tab')+'"]'),
                slideContainers = target.find('.slide-container');
            if(target.length){
                e.preventDefault();
                tabs.removeClass('active');
                $(this).addClass('active');

                tabContents.removeClass('active');
                target.addClass('active');
                
                if(slideContainers.length){
                    slideContainers.each(function(){
                        $(this).find('.slides').slick('setPosition');
                    });
                }

                AOS.refresh();
            }
        });
    });
}


// Special Card 05
var ssCard05 = $('.ss-card-05.use-slick');
if(ssCard05.length){
    ssCard05.each(function(){
        var self = $(this),
            slideContainer = self.find('.slide-container'),
            slides = slideContainer.find('> .slides'),
            imageWrappers = self.find('.img-wrapper');
        slides.slick({
            centerMode: false, infinity: true, centerPadding: 0, slidesToShow: 1, 
            focusOnSelect: true, autoplay: false, autoplaySpeed: 4000, speed: 600,
            arrows: true, appendArrows: slideContainer.find('.arrows'), dots: false
        });
        slides.on('beforeChange', function(e, s, c, i){
            imageWrappers.removeClass('active');
            imageWrappers.filter('[data-i="'+i+'"]').addClass('active');
        });
    });
}


// Footer Minisite
var fooerMinisite = $('nav.footer-minisite');
if(fooerMinisite.length){
    fooerMinisite.find('.slide-container').each(function(){
        var self = $(this);
        self.find('> .slides').slick({
            centerMode: false, infinity: true, centerPadding: 0, slidesToShow: 5, 
            focusOnSelect: true, autoplay: true, autoplaySpeed: 4000, speed: 600,
            arrows: true, appendArrows: self.find('> .arrows'), dots: false,
            swipeToSlide: true,
            responsive: [
                { breakpoint: 1199.98, settings: { slidesToShow: 4, } },
                { breakpoint: 991.98, settings: { slidesToShow: 3, } },
                { breakpoint: 767.98, settings: { slidesToShow: 2, } },
            ]
        });
    });
}


// About 03
var about03 = $('.about-03');
if(about03.length){
    about03.find('.slide-container').each(function(){
        var self = $(this);
        self.find('> .slides').slick({
            centerMode: true, centerPadding: 0, slidesToShow: 3, swipeToSlide: true,
            focusOnSelect: true, autoplay: true, autoplaySpeed: 4000, speed: 800,
            arrows: true, appendArrows: self.find('.arrows'), 
            dots: true, appendDots: self.find('.dots'),
            responsive: [
                { breakpoint: 991.98, settings: { slidesToShow: 2, } },
                { breakpoint: 575.98, settings: { slidesToShow: 1, } },
            ]
        });
    });
}


// Banner 01
var banner01 = $('.banner-01');
if(banner01.length){
    banner01.each(function(){
        var self = $(this),
            options = {
                centerMode: true, centerPadding: 0, slidesToShow: 1, swipeToSlide: true,
                focusOnSelect: true, autoplay: true, autoplaySpeed: 4000, speed: 800,
                arrows: true, appendArrows: self.find('.arrows'),
                dots: true, appendDots: self.find('.dots')
            };
        if(self.hasClass('img-only')){
            options = {
                centerMode: true, centerPadding: 0, slidesToShow: 1, swipeToSlide: true,
                focusOnSelect: true, autoplay: true, autoplaySpeed: 4000, speed: 800,
                arrows: true, appendArrows: self.find('.arrows'),
                dots: true, appendDots: self.find('.dots'),
                adaptiveHeight: false
            };
        }
        self.find('.slides').slick(options);
    });
}

// Banner 02
var banner02 = $('.banner-02');
if(banner02.length){
    banner02.each(function(){
        var self = $(this),
            options = {
                centerMode: true, centerPadding: 0, slidesToShow: 1, swipeToSlide: true,
                focusOnSelect: true, autoplay: true, autoplaySpeed: 4000, speed: 800,
                prevArrow: self.find('.arrow-prev'),
                nextArrow: self.find('.arrow-next')
                
            };
        if(self.hasClass('img-only')){
            options = {
                centerMode: true, centerPadding: 0, slidesToShow: 1, swipeToSlide: true,
                focusOnSelect: true, autoplay: true, autoplaySpeed: 4000, speed: 800,
                prevArrow: self.find('.arrow-prev'),
                nextArrow: self.find('.arrow-next'),
                adaptiveHeight: false
            };
        }
        self.find('.slides').slick(options);
    });
}

// Banner 03
var banner03 = $('.banner-03');
if(banner03.length){
    banner03.each(function(){
        var self = $(this);
        self.find('.slides').slick({
            centerMode: true, centerPadding: 0, slidesToShow: 1, swipeToSlide: true,
            focusOnSelect: true, autoplay: true, autoplaySpeed: 4000, speed: 800,
            arrows: true, appendArrows: self.find('.arrows'), dots: false,
        });
    });
}


// Client 01
var client01 = $('.client-01');
if(client01.length){
    client01.find('.slide-container').each(function(){
        var self = $(this);
        self.find('> .slides').slick({
            centerMode: true, centerPadding: 0, slidesToShow: 4, swipeToSlide: true,
            focusOnSelect: true, autoplay: true, autoplaySpeed: 4000, speed: 800,
            arrows: true, appendArrows: self.find('.arrows'), dots: false,
            responsive: [
                { breakpoint: 991.98, settings: { slidesToShow: 3, } },
                { breakpoint: 767.98, settings: { slidesToShow: 2, } },
            ]
        });
    });
}


// Intro 03
var intro03 = $('.intro-03');
if(intro03.length){
    intro03.find('.slide-container').each(function(){
        var self = $(this);
        self.find('.slides').slick({
            centerMode: true, centerPadding: 0, slidesToShow: 1, swipeToSlide: true,
            focusOnSelect: true, autoplay: true, autoplaySpeed: 4000, speed: 800,
            dots: false, arrows: true, appendArrows: self.find('.arrows')
        });
    });
}

// Intro 06
var intro06 = $('.intro-06');
if(intro06.length){
    intro06.each(function(){
        var self = $(this);
        self.find('.slides').slick({
            slidesToShow: 7, focusOnSelect: false, infinite: true,
            autoplay: true, autoplaySpeed: 0, speed: 1200,
            cssEase: 'linear', arrows: false, dots: false,
            responsive: [
                { breakpoint: 1199.98, settings: { slidesToShow: 6, } },
                { breakpoint: 1099.98, settings: { slidesToShow: 5, } },
                { breakpoint: 991.98, settings: { slidesToShow: 4, } },
                { breakpoint: 767.98, settings: { slidesToShow: 2, } },
                { breakpoint: 575.98, settings: { slidesToShow: 1, } },
            ]
        });
    });
}

// Intro 07
var intro07 = $('.intro-07');
if(intro07.length){
    intro07.find('.slide-container').each(function(){
        var self = $(this);
        self.find('> .slides').slick({
            centerMode: true, centerPadding: 0, slidesToShow: 4, swipeToSlide: true,
            focusOnSelect: true, autoplay: true, autoplaySpeed: 4000, speed: 800,
            arrows: true, appendArrows: self.find('.arrows'), dots: false,
            responsive: [
                { breakpoint: 991.98, settings: { slidesToShow: 3, } },
                { breakpoint: 767.98, settings: { slidesToShow: 2, } },
                { breakpoint: 575.98, settings: { slidesToShow: 1, } },
            ]
        });
    });
}


// FAQ 01
var faq01 = $('.faq-01');
if(faq01.length){
    faq01.each(function(){
        $(this).find('.faq > .question').click(function(e){
            e.preventDefault();
            var parent = $(this).parent();
            if(parent.hasClass('active')){
                parent.removeClass('active');
                parent.find('> .answer').slideUp();
            }else{
                parent.addClass('active');
                parent.find('> .answer').slideDown();
            }
        });
    });
}

// FAQ 02
var faq02 = $('.faq-02');
if(faq02.length){
    faq02.each(function(){
        $(this).find('.faq > .question').click(function(e){
            var parent = $(this).parent(),
                target = parent.find('> .answer');
            if(target.length){
                e.preventDefault();
                if(parent.hasClass('active')){
                    parent.removeClass('active');
                    target.slideUp();
                }else{
                    parent.addClass('active');
                    target.slideDown();
                }
            }
        });
    });
}


// Survey 01
var survey01 = $('.survey-01');
if(survey01.length){
    survey01.each(function(){
        $(this).find('.survey .survey-toggle').click(function(e){
            e.preventDefault();
            var parent = $(this).closest('.survey');
            if(parent.hasClass('active')){
                parent.removeClass('active');
                parent.find('> .body').slideUp();
            }else{
                parent.addClass('active');
                parent.find('> .body').slideDown();
            }
        });
    });
}


// Page Loader
if($('.page-loader').length){
    window.onload = function(){
        $('.page-loader').addClass('fade-out');
        setTimeout(function(){
            $('.page-loader').remove();
            $('body').removeClass('loading');
        }, 1350);
    }
}else{
    $('body').removeClass('loading');
}


// AOS Animation
AOS.init({ easing: 'ease-in-out-cubic', duration: 750, once: true, offset: 10 });

});

function ssPageProcess(){
var ssPages = $('.ss-page');
if(ssPages.length){
    var ssPageBtns = $('.ss-page-btn');
    var hash = window.location.hash;

    if(hash){
        var pageId = hash.replace('#', '');
        var activePage = ssPages.filter('[data-page="'+pageId+'"]');
        if(activePage.length){
            ssPages.removeClass('active');
            activePage.addClass('active');
            ssPageBtns.removeClass('active');
            ssPageBtns.filter('[data-page="'+pageId+'"]').addClass('active');
        }
    }

    ssPageBtns.click(function(e){
        var target = $('.ss-page[data-page="'+$(this).data('page')+'"]');
        if(target.length){
            e.preventDefault();

            ssPages.removeClass('active');
            target.addClass('active');
            ssPageBtns.removeClass('active');
            $(this).addClass('active');
            
            var slideContainers = target.find('.slide-container');
            if(slideContainers.length){
                slideContainers.each(function(){
                    $(this).find('.slides').slick('setPosition');
                });
            }

            AOS.refresh();
        }
    });
}
}
