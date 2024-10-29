;(function ($) {

    'use strict';

    $(".beafwc-twentytwenty-container").each(function () {

        if ($(this).attr('beafwc-move-slider-on-hover') == 'no') {
            var moveSliderHover = false;
        } else {
            var moveSliderHover = true;
        }

        if ($(this).attr('beafwc-overlay') == 'yes') {
            var overlay = false;
        } else {
            var overlay = true;
        }

        if ($(this).attr('beafwc-click-to-move') == 'no') {
            var clickToMove = false;
        } else {
            var clickToMove = true;
        }

        $(this).twentytwenty({
            orientation: $(this).attr('beafwc-orientation'),
            default_offset_pct: $(this).attr('beafwc-default-offset'),
            before_label: $(this).attr('beafwc-before-label'),
            after_label: $(this).attr('beafwc-after-label'),
            no_overlay: overlay,
            move_slider_on_hover: moveSliderHover,
            click_to_move: clickToMove
        });
            
    });
        
    $(window).on('load', function () {
        
        $(".beafwc-twentytwenty-container").each(function () {
            
            var beforeImageW = $(this).find('img.twentytwenty-before').width();
            $(this).css( 'max-width', beforeImageW + 'px' );
            
            //Label OutSide
            var beafwcLabelOutside = $(this).data('label_outside');
            var orientation = $(this).attr('beafwc-orientation');
            if(beafwcLabelOutside == true && orientation == 'vertical'){
                $('.beafwc-outside-label-wrapper.twentytwenty-vertical .beafwc-twentytwenty-container').css('margin', 50 + 'px' + ' auto'  );

                $('.beafwc-outside-label-wrapper.twentytwenty-vertical .twentytwenty-overlay>.twentytwenty-before-label').css('display','none');
                $('.beafwc-outside-label-wrapper.twentytwenty-vertical .twentytwenty-overlay .twentytwenty-after-label').css('display','none');
            }
            
        });
        
        $(window).on('scroll', function () {

            $(window).trigger("resize.twentytwenty");
    
        });
        
    });
    /*
* On scroll slide
*/

 $(window).on('load',function () {

    function on_scroll_slide(elementOffset) {

        $('.beafwc-twentytwenty-wrapper.beafwc-on-scroll-slide.twentytwenty-horizontal .beafwc-twentytwenty-container').each(function () {

            var $this = $(this);

            var elementOffset = $this.offset().top;
            var elementOffset = elementOffset - $(window).scrollTop();

            var imgH = $this.find('.beafwc-before-image').height();
            var imgWidth = $this.find('.beafwc-before-image').width(); 

            var imgW = elementOffset;

            if (elementOffset >= imgWidth) {

                imgW = imgWidth;
            }

            if (elementOffset < 0) {

                imgW = 0;
            }

            $this.find('.beafwc-before-image').css('clip', "rect(0px, " + imgW + "px, " + imgH + "px, 0px)");

            $this.find('.beafwc-after-image').css('clip', "rect(0px, " + imgWidth + "px, " + imgH + "px, " + imgW + "px)");

            $this.find('.twentytwenty-handle').attr("style", "left:" + imgW + "px");

        });//end scroll function


        $('.beafwc-twentytwenty-wrapper.beafwc-on-scroll-slide.twentytwenty-vertical .beafwc-twentytwenty-container').each(function () {

            var $this = $(this);

            var elementOffset = $this.offset().top;
            var elementOffset = elementOffset - $(window).scrollTop();

            var imgHeight = $this.find('.beafwc-before-image').height();
            var imgW = $this.find('.beafwc-before-image').width();

            var imgH = elementOffset;

            if (elementOffset >= imgHeight) {

                imgH = imgHeight;
            }

            if (elementOffset < 0) {

                imgH = 0;
            }

            $this.find('.beafwc-before-image').css('clip', "rect(0px, " + imgW + "px, " + imgH + "px, 0px)");

            $this.find('.beafwc-after-image').css('clip', "rect(" + imgH + "px, " + imgW + "px, " + imgHeight + "px, 0px)");

            $this.find('.twentytwenty-handle').css("top", "" + imgH + "px");

        });//end scroll function

    }

    $(window).scroll(function () {
        on_scroll_slide();
    });
});

})(jQuery);
