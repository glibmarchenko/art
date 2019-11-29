<template>
    <div></div>
</template>


<script>

    export default {
        data() {
            return {
            
            }
        },

        mounted() {
            this.bindZoom();
        },
        
        methods: {

            bindZoom() {
                let $component = this;
                $('#zoom-btn,#zoom-image').unbind('click').on('click', function () {
                    
                    $('body').append('<div class="bl-zoom-now" id="myimagezoom">' +
                        '<div class="bl-toppanel">' +
                        '<div class="bl-workpanel">' +
                        '<div class="buttons-zoom-block">' +
                        '<div class="button-zoom zoom-out noselect"><i class="fa fa-minus" aria-hidden="true"></i></div>' +
                        '<div class="button-zoom zoom-in noselect"><i class="fa fa-plus" aria-hidden="true"></i></div>' +
                        '</div>' +
                        //'<input type="range" class="zoom-range">' +
                        '<input type="range" class="zoom-range" />' +
                        '<div class="button-zoom zoom-reset reset noselect">100%</div>' +
                        '</div>' +
                        '<div class="button-zoom bl-close-zoom"><img src="/web/images/ui/close-small.svg"/></div>' +
                        '</div>' +
                        '<div class="pnazoomblock">' +
                        '<img src="' + $component.image + '"/>' +
                        '</div>' +
                        '</div>');

                    $('img').each(function() {
                        $(this)[0].oncontextmenu = function() {
                            return false;
                        };
                    });
                   
                    //wheelzoom($('#myimagezoom'));
                    $('.pnazoomblock ').panzoom({
                        $zoomIn: $(".zoom-in"),
                        $zoomOut: $(".zoom-out"),
                        $zoomRange: $(".zoom-range"),
                        $reset: $(".reset")
                    });
                 
                    $('.bl-zoom-now').on('scroll', function (e) {

                    });
                    
                    $(window).bind('mousewheel', function (event) {
                        if (event.originalEvent.wheelDelta >= 0) {
                            $component.scrollZoomItem(0);
                        }
                        else {
                            $component.scrollZoomItem(1);
                        }
                    });


                    $('.zoom-range').on('input change', function () {
                        $component.show_range_percent()
                    });
                    
                    $('.button-zoom').on('click', function () {
                        $component.show_range_percent()
                    });


                    $('.bl-zoom-now').on('click', function (e) {
                        if (e.target.id == 'myimagezoom' || e.target.classList.value == 'pnazoomblock')
                            $component.close_zoom_box();
                    });

                    $('.bl-close-zoom').on('click', function () {
                        $component.close_zoom_box();
                    });
                })
            },

            scrollZoomItem(up) {
              
                if (!$('.pnazoomblock').length) {
                    return;
                }
                let transformDefault = "matrix(1, 0, 0, 1, 0, 0)";
                let transform = $('.pnazoomblock').css('transform');
                if (transform == 'none') {
                    transform = transformDefault;
                }
                let pixelCount = 0;
                if (navigator.userAgent.indexOf('Mac OS X') != -1) {
                    pixelCount = 8;
                } else {
                    pixelCount = 50;
                }
                let separate = transform.split('(')[1].split(',');
                let lastItem = parseInt(separate[separate.length - 1]);
                if (up) {
                    lastItem -= pixelCount;
                } else {
                    lastItem += pixelCount;
                }
                separate[separate.length - 1] = lastItem;
                transform = "matrix(" + separate.join(",") + ")";
                $('.pnazoomblock').css('transform', transform);

            },

            show_range_percent() {
                $('.zoom-reset').text(Math.round(parseFloat($('.zoom-range').val()) * 100) + '%');
            },

            close_zoom_box() {
                $('.bl-zoom-now').fadeOut(500);

                setTimeout(function () {
                    $('.bl-zoom-now').remove();
                }, 500);
            },

        },
        props : ['image']
    }
</script>