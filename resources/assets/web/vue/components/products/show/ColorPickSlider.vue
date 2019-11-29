<template>
    <li class="color-palette-li mf-color-item">
        <div class="mf-name" data-placeholder="Цвет">Цвет</div>
        <div class="mf-dot"></div>
        <div class="mf-border-fix"></div>
        <div class="mf-content mf-content-fullwidth ">
            <div class="mf-palette-box">
                <div class="reset-palette">Сбросить</div>
                <div class="mf-palette">
                    <div class="mf-color-box"></div>
                    <div class="mf-color-box"></div>
                    <div class="mf-color-box"></div>
                    <div class="mf-color-box"></div>
                    <div class="mf-color-box"></div>
                    <div class="mf-color-box"></div>
                    <div class="mf-color-box"></div>
                    <div class="mf-color-box"></div>
                    <div class="mf-color-box"></div>
                    <div class="mf-color-box"></div>
                    <div class="mf-color-box"></div>
                    <div class="mf-color-box"></div>
                    <div class="mf-color-box"></div>
                    <div class="mf-color-box"></div>
                    <div class="mf-color-box"></div>
                    <div class="mf-color-box"></div>
                    <div class="mf-color-box"></div>
                </div>
                <div class="mf-color-gradient">
                    <span class="cielch-demo"></span>
                </div>
                <input type="hidden" class="full-color-input hsl-color" data-color-format="hsl"/>
                <input type="hidden" class="full-color-input rgb-color" data-color-format="rgb"/>
            </div>
        </div>
    </li>
</template>


<script>

    export default {
        data() {
            return {
                colors: {
                    rgb: '',
                    hsl: ''
                },
                rgb: '',
                hsl: '',
            };
        },


        
        methods: {
         
     
        },
        mounted: function() {
            $(document).click(function (event) {
                if (!$(event.target).closest('.color-palette-li').length) {
                    $('.color-palette-li').removeClass('m-filter-change');
                }
            });

            $('.color-palette-li').on('click', function (e) {
                if (e.target !== this && (!$(e.target).hasClass('mf-name') && !$(e.target).hasClass('mf-dot')))
                    return;
                if (!$(this).hasClass('m-filter-change')) {
                    $('.m-filter-item').removeClass('m-filter-change');
                }
                $(this).toggleClass('m-filter-change');
            });

            $('.mf-color-box').on('click', function () {
                $('.mf-color-box').removeClass('mf-color-change');
                $(this).addClass('mf-color-change');
                $(".cielch-demo").trigger("colorpickersliders.updateColor", $(this).css('background-color'));
            })

            $('.reset-palette').on('click', function () {
                $('.m-filter-change').click();
                $('.mf-color-box').removeClass('mf-color-change');
                //$('.mf-color-default').click();
                $(".cielch-demo").trigger("colorpickersliders.updateColor", '#fff');
                $('.mf-color-item').removeClass('mf-active');
            });


            console.log('test');

            /* Color Filter */

            let component = this;
            $(".cielch-demo").ColorPickerSliders({
                flat: true,
                color: "#fff",
                connectedinput: '.full-color-input',
                order: {
                    hsl: 1
                }, onchange: function (container, color) {
                    if ($('.mf-color-item').hasClass('m-filter-change'))
                        $('.mf-color-item').addClass('mf-active');
                    $(".cp-marker").css("background-color", color.tiny.toRgbString());
                    component.$set(component, 'rgb',  $('.rgb-color').val())
                }
            });
            $('.cp-hsllightness span').text('');
        },
        watch: {
            rgb: function(value) { // watch it
                this.$parent.setColor(value);
            }
        }
    }
</script>