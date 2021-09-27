$(function () {
            var DROPDOWN = 'dropdown'
            var ON = 'on'
            var SLIDETOGGLE_SPEED = 'slow'
            var ARROW = '<b class="arrow"></b>'
            var $nav = $('ul.nav')
            $nav.find('li>ul').prev().addClass(DROPDOWN).append(ARROW)
            $nav.find('li>a>b').click(function (event) {
                event.preventDefault();
                $(this).toggleClass(ON);
                $(this).parent().next().slideToggle(SLIDETOGGLE_SPEED);
            });

            $(window).resize(function () {
                if($(window).width()>768){
                    $nav.find('li a b').removeClass(ON);
                    $nav.find('.sub-menu').css('display', '');
                }
            });
        });