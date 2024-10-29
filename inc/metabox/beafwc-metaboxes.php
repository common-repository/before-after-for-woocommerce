<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit();
}

function beafwc_admin_scripts() {
    wp_enqueue_script( 'media-upload' );
    wp_enqueue_script( 'thickbox' );
}

function beafwc_admin_styles() {
    wp_enqueue_style( 'thickbox' );
}
add_action( 'admin_print_scripts', 'beafwc_admin_scripts' );
add_action( 'admin_print_styles', 'beafwc_admin_styles' );

add_action( 'admin_enqueue_scripts', 'beafwc_enqueue_color_ficker' );
if ( !function_exists( 'beafwc_enqueue_color_ficker' ) ) {
    function beafwc_enqueue_color_ficker( $hook ) {
        wp_enqueue_media();
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
    }
}

//Register Meta box
add_action( 'add_meta_boxes', function () {

    add_meta_box( 'beafwc-metabox', 'Before after content', 'beafwc_metabox_callback', 'product', 'normal', 'default' );
} );

//Metabox content
if ( !function_exists( 'beafwc_metabox_callback' ) ) {
    function beafwc_metabox_callback( $post ) {
        ob_start();
        ?>
<div class="beafwc-tab">
    <a class="beafwc-tablinks active" onclick="beafwc_option_tab(event, 'beafwc_gallery_content')"><?php echo esc_html__( 'Content', 'beafwc' ); ?></a>
    <a class="beafwc-tablinks" onclick="beafwc_option_tab(event, 'beafwc_gallery_options')"><?php echo esc_html__( 'Options', 'beafwc' ); ?></a>
    <a class="beafwc-tablinks" onclick="beafwc_option_tab(event, 'beafwc_gallery_style')"><?php echo esc_html__( 'Style', 'beafwc' ); ?></a>
</div>

<div id="beafwc_gallery_content" class="beafwc-tabcontent" style="display: block;">
    <table class="beafwc-option-table">
		
       <tr>
            <td class="beafwc-option-label"><label for="beafwc_activate_slider"><?php echo esc_html__( 'Activate Before After Slider', 'beafwc' ); ?></label></td>
            <td class="beafwc-option-content">
                <ul>
                   <?php
                        $beafwc_slider_active = !empty( get_post_meta( $post->ID, 'beafwc_activate_slider', true ) ) ? get_post_meta( $post->ID, 'beafwc_activate_slider', true ) : 'no';
                    ?>
                    <li><input type="radio" name="beafwc_activate_slider" id="beafwc_activate_slider_yes" value="yes" <?php checked( $beafwc_slider_active, 'yes' );?>> <label for="beafwc_activate_slider_yes"><?php echo esc_html__( 'Yes', 'beafwc' ); ?></label></li>
                    <li><input type="radio" name="beafwc_activate_slider" id="beafwc_activate_slider_no" value="no" <?php checked( $beafwc_slider_active, 'no' );?>> <label for="beafwc_activate_slider_no"><?php echo esc_html__( 'No', 'beafwc' ); ?></label></li>
                </ul>
                <p><?php echo esc_html__( 'Activate before after slider for this product.', 'beafwc' ); ?></p>
            </td>
        </tr>
        <?php
        ob_start();
        ?>
        <tr>
            <td class="beafwc-option-label">
                <p><label for="beafwc_before_after_method"><?php echo esc_html__( "Before After Method", "beafwc" ); ?></label></p>
            </td>
            <td class="beafwc-option-content">
                <ul>
                    <li><input type="radio" class="" name="beafwc_before_after_method" id="beafwc_before_after_method1" value="method_1" checked="checked"> <label for="beafwc_before_after_method1"><?php echo esc_html__("Method 1 (Using 2 images)","beafwc");?></label></li>
                    <li><input type="radio" class="" name="beafwc_before_after_method" id="beafwc_before_after_method2" value="method_2"> <label for="beafwc_before_after_method2"><?php echo esc_html__("Method 2 (Using 1 image)","beafwc");?> <div class="beafwc-tooltip"><span>?</span>
                                <div class="beafwc-tooltip-info"><?php echo sprintf( esc_html__("Pro feature! %s You can make a slider using one image with an effect.","beafwc"),'</br>');?></div>
                            </div></label></li>
                </ul>
                <p><?php echo esc_html__( "Choose a method to make a before after slider using a single image or 2 images.", "beafwc" ); ?></p>
            </td>
        </tr>
        <?php
            $beafwc_before_after_method = ob_get_clean();
            echo apply_filters( 'beafwc_before_after_method', $beafwc_before_after_method, $post );
        ?>
        <tr class="beafwc-row-before-image">
            <td class="beafwc-option-label">
                <label><?php echo esc_html__( 'Before image', 'beafwc' ); ?></label>
            </td>
            <td class="beafwc-option-content">
                <input type="text" name="beafwc_before_image" id="beafwc_before_image" size="50" value="<?php echo esc_url( get_post_meta( $post->ID, 'beafwc_before_image', true ) ); ?>" />
                <input class="beafwc_button" id="beafwc_before_image_upload" type="button" value="Add or Upload Image">
                <img id="beafwc_before_image_thumbnail" src="<?php echo esc_url( get_post_meta( $post->ID, 'beafwc_before_image', true ) ); ?>">
            </td>
        </tr>
        <tr class="beafwc-row-after-image">
            <td class="beafwc-option-label"><label for="beafwc_before_after_method"><?php echo esc_html__( 'After image', 'beafwc' ); ?></label></td>
            <td class="beafwc-option-content">
                <input type="text" name="beafwc_after_image" id="beafwc_after_image" size="50" value="<?php echo esc_url( get_post_meta( $post->ID, 'beafwc_after_image', true ) ); ?>" />
                <input class="beafwc_button" id="beafwc_after_image_upload" type="button" value="Add or Upload Image">
                <img id="beafwc_after_image_thumbnail" src="<?php echo esc_url( get_post_meta( $post->ID, 'beafwc_after_image', true ) ); ?>">
            </td>
        </tr>
        <?php
        ob_start();
        ?>
        <tr class="beafwc-row-before-after-image" style="display: none">
            <td class="beafwc-option-label"><label><?php echo esc_html__("Before after image","beafwc");?> <div class="beafwc-tooltip"><span>?</span>
                        <div class="beafwc-tooltip-info"><?php echo esc_html__( 'Pro feature!', 'beafwc' ); ?></div>
                    </div></label></td>
            <td class="beafwc-option-content">
                <input type="text" name="beafwc_before_after_image" id="beafwc_before_after_image" size="50" disabled />
                <input class="beafwc_button" id="beafwc_before_after_image_upload" type="button" value="Add or Upload Image">
                <input type="hidden" name="img_txt_id" id="img_txt_id" value="" />
            </td>
        </tr>
        <?php
        $beafwc_before_after_image = ob_get_clean();
        echo apply_filters( 'beafwc_before_after_image', $beafwc_before_after_image, $post );
        ?>
        
        <?php
        ob_start();
        ?>
        <tr class="beafwc_filter_style" style="display: none">
            <td class="beafwc-option-label"><label for="beafwc_filter_style"><?php echo esc_html__( "Select Filter Effect","beafwc" );?> <div class="beafwc-tooltip"><span>?</span>
                        <div class="beafwc-tooltip-info"><?php echo sprintf( esc_html__("Pro feature! %s If you use one image to make a slider, then you can use an effect.","beafwc"),'<br>');?></div>
                    </div></label></td>
            <td class="beafwc-option-content">
                <ul>
                    <li><input type="radio" name="beafwc_filter_style" id="beafwc_filter_style1" value="none" disabled> <label for="beafwc_filter_style1"><?php echo esc_html__( "None","beafwc" ); ?></label></li>

                    <li><input type="radio" name="beafwc_filter_style" id="beafwc_filter_style2" value="grayscale" disabled> <label for="beafwc_filter_style2"><?php echo esc_html__( "Grayscale","beafwc" ); ?></label></li>

                    <li><input type="radio" name="beafwc_filter_style" id="beafwc_filter_style3" value="blur" disabled> <label for="beafwc_filter_style3"><?php echo esc_html__( "Blur","beafwc" ); ?></label></li>

                    <li><input type="radio" name="beafwc_filter_style" id="beafwc_filter_style4" value="saturate" disabled> <label for="beafwc_filter_style4"><?php echo esc_html__( "Saturate","beafwc" ); ?></label></li>

                    <li><input type="radio" name="beafwc_filter_style" id="beafwc_filter_style5" value="sepia" disabled> <label for="beafwc_filter_style5"><?php echo esc_html__( "Sepia","beafwc" ); ?></label></li>
                </ul>
                <p><?php echo esc_html__( "Select a filtering effect to use on the before or after image.","beafwc" ); ?></p>
            </td>
        </tr>
        <?php
        $beafwc_filter_style_html = ob_get_clean();
        echo apply_filters( 'beafwc_filter_style', $beafwc_filter_style_html, $post );
        ?>
        <?php
        ob_start();
        ?>
        <tr class="beafwc_filter_apply" style="display: none">
            <td class="beafwc-option-label"><label for="beafwc_filter_apply">Apply filter for <div class="beafwc-tooltip"><span>?</span>
                        <div class="beafwc-tooltip-info"><?php echo esc_html__( "Pro feature!","beafwc" ); ?></div>
                    </div></label></td>
            <td class="beafwc-option-content">
                <ul class="cmb2-radio-list cmb2-list">
                    <li><input type="radio" name="beafwc_filter_apply" id="beafwc_filter_apply1" value="none" disabled> <label for="beafwc_filter_apply1"><?php echo esc_html__( "None","beafwc" ); ?></label></li>

                    <li><input type="radio" name="beafwc_filter_apply" id="beafwc_filter_apply2" value="apply_before" checked="checked" disabled> <label for="beafwc_filter_apply2"><?php echo esc_html__( "Before Image","beafwc" ); ?></label></li>

                    <li><input type="radio" name="beafwc_filter_apply" id="beafwc_filter_apply3" value="apply_after" disabled> <label for="beafwc_filter_apply3"><?php echo esc_html__( "After Image","beafwc" ); ?></label></li>
                </ul>
                <p><?php echo esc_html__( 'Filtering will applicable on selected image.', 'beafwc' ); ?></p>
            </td>
        </tr>
        <?php
        $beafwc_filter_apply_html = ob_get_clean();
        echo apply_filters( 'beafwc_filter_apply', $beafwc_filter_apply_html, $post );
        ?>

        <tr>
            <td class="beafwc-option-label"><label><?php echo esc_html__( 'Orientation Style', 'beafwc' ); ?></label></td>
            <td class="beafwc-option-content">
                <ul class="orientation-style">
                    <?php
                        $orientation = trim( get_post_meta( $post->ID, 'beafwc_image_styles', true ) ) != '' ? get_post_meta( $post->ID, 'beafwc_image_styles', true ) : 'horizontal';
                    ?>
                    <li><input type="radio" name="beafwc_image_styles" id="beafwc_image_styles1" value="vertical" <?php checked( $orientation, 'vertical' );?>> <label for="beafwc_image_styles1"><img src="<?php echo esc_url( plugins_url( '../../assets/image/v.jpg', __FILE__ ) ); ?>" /></label></li>

                    <li><input type="radio" name="beafwc_image_styles" id="beafwc_image_styles2" value="horizontal" <?php checked( $orientation, 'horizontal' );?>> <label for="beafwc_image_styles2"><img src="<?php echo esc_url( plugins_url( '../../assets/image/h.jpg', __FILE__ ) ); ?>" /></label></li>
                </ul>
            </td>
        </tr>
        <?php
        ob_start();
        ?>
        <tr>
            <td class="beafwc-option-label"><label for="beafwc_before_after_style"><?php echo esc_html__( 'BEAF Template Style', 'beafwc' ); ?><div class="beafwc-tooltip"><span>?</span><div class="beafwc-tooltip-info"><?php echo esc_html__( 'Pro feature!', 'beafwc' ); ?></div>
                    </div></label>
            </td>
            <td class="beafwc_before_after_style">
                <ul class="beafwc-before-after-style">
                    <?php 
                    $beafwc_before_after_style = trim(get_post_meta( $post->ID, 'beafwc_before_after_style', true )) != '' ? get_post_meta( $post->ID, 'beafwc_before_after_style', true ) : 'default';
                    ?>
                    <li><input type="radio" checked name="beafwc_before_after_style" id="beafwc_before_after_style_default" value="default" <?php checked( $beafwc_before_after_style, 'default' ); ?>> <label for="beafwc_before_after_style_default"><img src="<?php echo esc_url(plugin_dir_url( __FILE__ ).'../../assets/image/default.png'); ?>" /></label></li>
                    <li><input type="radio" name="beafwc_before_after_style" id="beafwc_before_after_style_1" value="" <?php checked( $beafwc_before_after_style, '' ); ?>> <label for="beafwc_before_after_style_1"><img src="<?php echo esc_url(plugin_dir_url( __FILE__ ).'../../assets/image/style1.png'); ?>" /></label></li>
                    <li><input type="radio" name="beafwc_before_after_style" id="beafwc_before_after_style_2" value="" <?php checked( $beafwc_before_after_style, '' ); ?>> <label for="beafwc_before_after_style_2"><img src="<?php echo esc_url(plugin_dir_url( __FILE__ ).'../../assets/image/style2.png'); ?>" /></label></li>
                    <li><input type="radio" name="beafwc_before_after_style" id="beafwc_before_after_style_3" value="" <?php checked( $beafwc_before_after_style, '' ); ?>> <label for="beafwc_before_after_style_3"><img src="<?php echo esc_url(plugin_dir_url( __FILE__ ).'../../assets/image/style3.png'); ?>" /></label></li>
                    <li><input type="radio" name="beafwc_before_after_style" id="beafwc_before_after_style_4" value="" <?php checked( $beafwc_before_after_style, '' ); ?>> <label for="beafwc_before_after_style_4"><img src="<?php echo esc_url(plugin_dir_url( __FILE__ ).'../../assets/image/style4.png'); ?>" /></label></li>
                    <li><input type="radio" name="beafwc_before_after_style" id="beafwc_before_after_style_5" value="" <?php checked( $beafwc_before_after_style, '' ); ?>> <label for="beafwc_before_after_style_5"><img src="<?php echo esc_url(plugin_dir_url( __FILE__ ).'../../assets/image/style5.png'); ?>" /></label></li>
                    <li><input type="radio" name="beafwc_before_after_style" id="beafwc_before_after_style_6" value="" <?php checked( $beafwc_before_after_style, '' ); ?>> <label for="beafwc_before_after_style_6"><img src="<?php echo esc_url(plugin_dir_url( __FILE__ ).'../../assets/image/style6.png'); ?>" /></label></li>
                    <li><input type="radio" name="beafwc_before_after_style" id="beafwc_before_after_style_7" value="" <?php checked( $beafwc_before_after_style, '' ); ?>> <label for="beafwc_before_after_style_7"><img src="<?php echo esc_url(plugin_dir_url( __FILE__ ).'../../assets/image/style7.png'); ?>" /></label></li>
                    <li><input type="radio" name="beafwc_before_after_style" id="beafwc_before_after_style_8" value="" <?php checked( $beafwc_before_after_style, '' ); ?>> <label for="beafwc_before_after_style_8"><img src="<?php echo esc_url(plugin_dir_url( __FILE__ ).'../../assets/image/style8.png'); ?>" /></label></li>
                    <li><input type="radio" name="beafwc_before_after_style" id="beafwc_before_after_style_9" value="" <?php checked( $beafwc_before_after_style, '' ); ?>> <label for="beafwc_before_after_style_9"><img src="<?php echo esc_url(plugin_dir_url( __FILE__ ).'../../assets/image/style9.png'); ?>" /></label></li>
                </ul>
                <p><?php echo esc_html__('Select a style for the before and after label.','beafwc'); ?></p>
            </td>
        </tr>
        <?php
        $beafwc_before_after_style_html = ob_get_clean();
        echo apply_filters( 'beafwc_before_after_style', $beafwc_before_after_style_html, $post );
        ?>
    </table>
</div>

<div id="beafwc_gallery_options" class="beafwc-tabcontent">
    <table class="beafwc-option-table">
        <tr>
            <td class="beafwc-option-label"><label for="beafwc_default_offset"><?php echo esc_html__( 'Default Offset', 'beafwc' ); ?></label></td>
            <td class="beafwc-option-content">
               <?php
                $beafwc_default_offset = !empty( get_post_meta( $post->ID, 'beafwc_default_offset', true ) ) ? get_post_meta( $post->ID, 'beafwc_default_offset', true ) : '0.5';

                ?>
                <input type="text" class="regular-text" name="beafwc_default_offset" id="beafwc_default_offset" value="<?php echo esc_attr( $beafwc_default_offset ); ?>">
                <p><?php echo esc_html__( 'How much of the before image is visible when the page loads. (e.g: 0.7)', 'beafwc' ); ?></p>
            </td>
        </tr>
        <tr>
            <td class="beafwc-option-label"><label for="beafwc_before_label"><?php echo esc_html__( 'Before Label', 'beafwc' ); ?></label></td>
            <td class="beafwc-option-content">
               <?php
                    $beafwc_before_label = !empty( get_post_meta( $post->ID, 'beafwc_before_label', true ) ) ? get_post_meta( $post->ID, 'beafwc_before_label', true ) : 'Before';
                ?>
                <input type="text" class="regular-text" name="beafwc_before_label" id="beafwc_before_label" value="<?php echo esc_html( $beafwc_before_label ); ?>" >
                <p><?php echo esc_html__( 'Set a custom label for the title "Before".', 'beafwc' ); ?></p>
            </td>
        </tr>
        <tr>
            <td class="beafwc-option-label"><label for="beafwc_after_label"><?php echo esc_html__( 'After Label', 'beafwc' ); ?></label></td>
            <td class="beafwc-option-content">
               <?php
                $beafwc_after_label = !empty( get_post_meta( $post->ID, 'beafwc_after_label', true ) ) ? get_post_meta( $post->ID, 'beafwc_after_label', true ) : 'After';
                ?>
                <input type="text" class="regular-text" name="beafwc_after_label" id="beafwc_after_label" value="<?php echo esc_html( $beafwc_after_label ); ?>">
                <p><?php echo esc_html__( 'Set a custom label for the title "After".', 'beafwc' ); ?></p>
            </td>
        </tr>
        <!--Label Outside of Image start-->
        <?php ob_start();?>
        <tr class="beafwc_option_label">
            <td class="beafwc-option-label"><label for="beafwc_label_outside1"><?php echo esc_html__( 'Show Label Outside Of Image', 'beafwc' ); ?>
                <div class="beafwc-tooltip"><span>?</span>
                    <div class="beafwc-tooltip-info"><?php echo esc_html__( 'Pro feature!','beafwc' ); ?></div>
                </div></label>
            </td>
            <td class="beafwc-option-content">
                <ul>
                    <li><input type="radio" name="beafwc_label_outside" id="beafwc_label_outside1" value="true"> <label for="beafwc_label_outside1"><?php echo esc_html__( 'Yes','beafwc' ); ?></label></li>
                    <li><input type="radio" name="beafwc_label_outside" id="beafwc_label_outside2" value="false" checked="checked"> <label for="beafwc_label_outside2"><?php echo esc_html__( 'No','beafwc' ); ?></label></li>
                </ul>
            </td>
        </tr>
        <?php
        $show_label_outside_html = ob_get_clean();
        echo apply_filters( 'beafwc_show_label_outside', $show_label_outside_html, $post );
        ?>
        <!--Label Outside of Image start-->

        <?php
        ob_start();
        ?>
        <tr class="beafwc_auto_slide">
            <td class="beafwc-option-label"><label for="beafwc_auto_slide"><?php echo esc_html__( "Auto Slide","beafwc" ) ?> <div class="beafwc-tooltip"><span>?</span>
                        <div class="beafwc-tooltip-info"><?php echo esc_html__( "Pro feature!","beafwc" ) ?></div>
                    </div></label></td>
            <td class="beafwc-option-content">
                <ul>
                    <li><input type="radio" name="beafwc_auto_slide" id="beafwc_auto_slide1" value="true"> <label for="beafwc_auto_slide1"><?php echo esc_html__( "Yes","beafwc" ) ?></label></li>
                    <li><input type="radio" name="beafwc_auto_slide" id="beafwc_auto_slide2" value="false" checked="checked"> <label for="beafwc_auto_slide2"><?php echo esc_html__( "No","beafwc" ) ?></label></li>
                </ul>
                <p><?php echo esc_html__( 'The before and after image will slide automatically.', 'beafwc' ); ?></p>
            </td>
        </tr>
        <?php
        $beafwc_auto_slide_html = ob_get_clean();
        echo apply_filters( 'beafwc_auto_slide', $beafwc_auto_slide_html, $post );
        ?>
        
        <?php
            $beafwc_on_scroll_slide = !empty( get_post_meta( $post->ID, 'beafwc_on_scroll_slide', true ) ) ? get_post_meta( $post->ID, 'beafwc_on_scroll_slide', true ) : 'false';
        ?>
        <tr>
            <td class="beafwc-option-label"><label for="beafwc_on_scroll_slide"><?php echo esc_html__( 'On scroll Slide','beafwc' ) ?></label></td>
            <td class="beafwc-option-content">
                <ul>
                    <li><input type="radio" name="beafwc_on_scroll_slide" id="beafwc_on_scroll_slide1" value="true" <?php checked( $beafwc_on_scroll_slide, 'true' );?>> <label for="beafwc_on_scroll_slide1"><?php echo esc_html__( 'Yes','beafwc' ) ?></label></li>
                    <li><input type="radio" name="beafwc_on_scroll_slide" id="beafwc_on_scroll_slide2" value="false" <?php checked( $beafwc_on_scroll_slide, 'false' );?>> <label for="beafwc_on_scroll_slide2"><?php echo esc_html__( 'No','beafwc' ) ?></label></li>
                </ul>
                <p><?php echo esc_html("The before and after image slider will slide on scroll automatically.","beafwc");?></p>
            </td>
        </tr>

        <?php
        ob_start();
        ?>
        <tr class="beafwc_slide_handle">
            <td class="beafwc-option-label"><label for="beafwc_slide_handle"><?php echo esc_html__( "Disable Handle","beafwc" );?> <div class="beafwc-tooltip"><span>?</span>
                        <div class="beafwc-tooltip-info"><?php echo esc_html__( "Pro feature!","beafwc" );?></div>
                    </div></label></td>
            <td class="beafwc-option-content">
                <ul>
                    <li><input type="radio" name="beafwc_slide_handle" id="beafwc_slide_handle1" value="yes" disabled> <label for="beafwc_slide_handle1">Yes</label></li>
                    <li><input type="radio" name="beafwc_slide_handle" id="beafwc_slide_handle2" value="no" checked="checked" disabled> <label for="beafwc_slide_handle2">No</label></li>
                </ul>
                <p><?php echo esc_html__( "Disable the slider handle.","beafwc" );?></p>
            </td>
        </tr>
        <?php
        $beafwc_slide_handle_html = ob_get_clean();
        echo apply_filters( 'beafwc_slide_handle', $beafwc_slide_handle_html, $post );
        ?>

        <!-- Popup Preview -->
        <?php
        ob_start();
        ?>
        <tr class="beafwc_popup_preview">
            <td class="beafwc-option-label"><label for="beafwc_popup_preview"><?php echo esc_html__( "Full Screen View","beafwc" );?><div class="beafwc-tooltip"><span>?</span>
                        <div class="beafwc-tooltip-info">Pro feature!</div>
                    </div></label></td>
            <td class="beafwc-option-content">
                <ul>
                    <li><input type="radio" name="beafwc_popup_preview" id="beafwc_popup_preview1" value="yes" disabled> <label for="beafwc_popup_preview1">Yes</label></li>
                    <li><input type="radio" name="beafwc_popup_preview" id="beafwc_popup_preview2" value="no" checked="checked" disabled> <label for="beafwc_popup_preview2">No</label></li>
                </ul>
                <p><?php echo esc_html__( "Enable to display slider on full screen..","beafwc" );?></p>
            </td>
        </tr>
        <?php
        $beafwc_popup_preview = ob_get_clean();
        echo apply_filters( 'beafwc_popup_preview_meta', $beafwc_popup_preview, $post );
        ?>
        
        <tr class="beafwc_move_slider_on_hover" style="display: none">
            <td class="beafwc-option-label"><label for="beafwc_move_slider_on_hover"><?php echo esc_html__( 'Move slider on mouse hover?', 'beafwc' ); ?></label></td>
            <td class="beafwc-option-content">
                <ul>
                   <?php
                    $beafwc_move_slider_on_hover = !empty( get_post_meta( $post->ID, 'beafwc_move_slider_on_hover', true ) ) ? get_post_meta( $post->ID, 'beafwc_move_slider_on_hover', true ) : 'no';
                    ?>
                    <li><input type="radio" name="beafwc_move_slider_on_hover" id="beafwc_move_slider_on_hover1" value="yes" <?php checked( $beafwc_move_slider_on_hover, 'yes' );?>> <label for="beafwc_move_slider_on_hover1"><?php echo esc_html__( 'Yes', 'beafwc' ); ?></label></li>
                    <li><input type="radio" name="beafwc_move_slider_on_hover" id="beafwc_move_slider_on_hover2" value="no" <?php checked( $beafwc_move_slider_on_hover, 'no' );?>> <label for="beafwc_move_slider_on_hover2"><?php echo esc_html__( 'No', 'beafwc' ); ?></label></li>
                </ul>
            </td>
        </tr>
        <tr>
            <td class="beafwc-option-label"><label for="beafwc_click_to_move"><?php echo esc_html__( 'Click to Move', 'beafwc' ); ?></label></td>
            <td class="beafwc-option-content">
                <ul>
                   <?php
                        $beafwc_click_to_move = !empty( get_post_meta( $post->ID, 'beafwc_click_to_move', true ) ) ? get_post_meta( $post->ID, 'beafwc_click_to_move', true ) : 'no';
                    ?>
                    <li><input type="radio" class="cmb2-option" name="beafwc_click_to_move" id="beafwc_click_to_move1" value="yes" <?php checked( $beafwc_click_to_move, 'yes' );?>> <label for="beafwc_click_to_move1"><?php echo esc_html__( 'Yes', 'beafwc' ); ?></label></li>
                    <li><input type="radio" class="cmb2-option" name="beafwc_click_to_move" id="beafwc_click_to_move2" value="no" <?php checked( $beafwc_click_to_move, 'no' );?>> <label for="beafwc_click_to_move2"><?php echo esc_html__( 'No', 'beafwc' ); ?></label></li>
                </ul>
                <p><?php echo esc_html__( 'Allow a user to click (or tap) anywhere on the image to move the slider to that location.', 'beafwc' ); ?></p>
            </td>
        </tr>
        <tr>
            <td class="beafwc-option-label"><label for="beafwc_no_overlay"><?php echo esc_html__( 'Show Overlay', 'beafwc' ); ?></label></td>
            <td class="beafwc-option-content">
                <ul>
                   <?php
                        $beafwc_no_overlay = !empty( get_post_meta( $post->ID, 'beafwc_no_overlay', true ) ) ? get_post_meta( $post->ID, 'beafwc_no_overlay', true ) : 'yes';
                    ?>
                    <li><input type="radio" name="beafwc_no_overlay" id="beafwc_no_overlay1" value="yes" <?php checked( $beafwc_no_overlay, 'yes' );?>> <label for="beafwc_no_overlay1"><?php echo esc_html__( 'Yes', 'beafwc' ); ?></label></li>
                    <li><input type="radio" name="beafwc_no_overlay" id="beafwc_no_overlay2" value="no" <?php checked( $beafwc_no_overlay, 'no' );?>> <label for="beafwc_no_overlay2"><?php echo esc_html__( 'No', 'beafwc' ); ?></label></li>
                </ul>
                <p><?php echo esc_html__( 'Show overlay on the before and after image.', 'beafwc' ); ?></p>
            </td>
        </tr>
        <tr>
            <td class="beafwc-option-label"><label for="skip_lazy_load"><?php echo esc_html__( 'Skip lazy load', 'beafwc' ); ?></label></td>
            <td class="beafwc-option-content">
                <ul>
                   <?php
                    $skip_lazy_load = !empty( get_post_meta( $post->ID, 'skip_lazy_load', true ) ) ? get_post_meta( $post->ID, 'skip_lazy_load', true ) : 'yes';
                    ?>
                    <li><input type="radio" name="skip_lazy_load" id="skip_lazy_load1" value="yes" <?php checked( $skip_lazy_load, 'yes' );?>> <label for="skip_lazy_load1"><?php echo esc_html__( 'Yes', 'beafwc' ); ?></label></li>
                    <li><input type="radio" name="skip_lazy_load" id="skip_lazy_load2" value="no" <?php checked( $skip_lazy_load, 'no' );?>> <label for="skip_lazy_load2"><?php echo esc_html__( 'No', 'beafwc' ); ?></label></li>
                </ul>
                <p><?php echo esc_html__( 'Conflicting with lazy load? Try to skip lazy load.', 'beafwc' ); ?></p>
            </td>
        </tr>
    </table>
</div>

<div id="beafwc_gallery_style" class="beafwc-tabcontent">
    <table class="beafwc-option-table">
        <tr>
            <td class="beafwc-option-label">
                <label for="beafwc_before_label_background"><?php echo esc_html__( 'Before Label Background', 'beafwc' ); ?></label>
            </td>
            <?php
            $beafwc_before_label_background = !empty( get_post_meta( $post->ID, 'beafwc_before_label_background', true ) ) ? get_post_meta( $post->ID, 'beafwc_before_label_background', true ) : '';
            ?>
            <td class="beafwc-option-content"><input id="beafwc_before_label_background" class="beafwc-color-field" type="text" name="beafwc_before_label_background" value="<?php echo esc_attr( $beafwc_before_label_background ); ?>" /></td>
        </tr>
        <tr>
            <td class="beafwc-option-label">
                <label for="beafwc_before_label_color"><?php echo esc_html__( 'Before Text Color', 'beafwc' ); ?></label>
            </td>
            <?php
            $beafwc_before_label_color = !empty( get_post_meta( $post->ID, 'beafwc_before_label_color', true ) ) ? get_post_meta( $post->ID, 'beafwc_before_label_color', true ) : '';
            ?>
            <td class="beafwc-option-content"><input id="beafwc_before_label_color" class="beafwc-color-field" type="text" name="beafwc_before_label_color" value="<?php echo esc_attr( $beafwc_before_label_color ); ?>" /></td>
        </tr>
        <tr>
            <td class="beafwc-option-label">
                <label for="beafwc_after_label_background"><?php echo esc_html__( 'After Label Background', 'beafwc' ); ?></label>
            </td>
            <?php
            $beafwc_after_label_background = !empty( get_post_meta( $post->ID, 'beafwc_after_label_background', true ) ) ? get_post_meta( $post->ID, 'beafwc_after_label_background', true ) : '';
            ?>
            <td class="beafwc-option-content"><input id="beafwc_after_label_background" class="beafwc-color-field" type="text" name="beafwc_after_label_background" value="<?php echo esc_attr( $beafwc_after_label_background ); ?>" /></td>
        </tr>
        <tr>
            <td class="beafwc-option-label">
                <label for="beafwc_after_label_color"><?php echo esc_html__( 'After Text Color', 'beafwc' ); ?></label>
            </td>
            <?php
            $beafwc_after_label_color = !empty( get_post_meta( $post->ID, 'beafwc_after_label_color', true ) ) ? get_post_meta( $post->ID, 'beafwc_after_label_color', true ) : '';
            ?>
            <td class="beafwc-option-content"><input id="beafwc_after_label_color" class="beafwc-color-field" type="text" name="beafwc_after_label_color" value="<?php echo esc_attr( $beafwc_after_label_color ); ?>" /></td>
        </tr>

        <?php
        ob_start();
        ?>
        <tr>
            <td class="beafwc-option-label"><label for="beafwc_handle_color"><?php echo esc_html__( 'Slider Handle Color', 'beafwc' ); ?><div class="beafwc-tooltip"><span>?</span><div class="beafwc-tooltip-info"><?php echo esc_html__( 'Pro feature!', 'beafwc' ); ?></div>
                </div></label>
            </td>
            <td class="beafwc-option-content"><input id="beafwc_handle_color" class="beafwc-color-field" type="text" name="beafwc_handle_color" value="" /></td>
        </tr>
        <?php
        $beafwc_handle_color = ob_get_clean();
        echo apply_filters( 'beafwc_handle_color', $beafwc_handle_color, $post );
        ?>

        <?php
        ob_start();
        ?>
        <tr>
            <td class="beafwc-option-label"><label for="beafwc_overlay_color"><?php echo esc_html__( 'Slider Overlay Color', 'beafwc' ); ?><div class="beafwc-tooltip"><span>?</span><div class="beafwc-tooltip-info"><?php echo esc_html__( 'Pro feature!', 'beafwc' ); ?></div>
                </div></label>
            </td>
            <td class="beafwc-option-content">
                <input id="beafwc_overlay_color" data-alpha-enabled="true" class="beafwc-color-field" type="text" name="beafwc_overlay_color" value="" />
            </td>
        </tr>
        <?php
        $beafwc_overlay_color = ob_get_clean();
        echo apply_filters( 'beafwc_overlay_color', $beafwc_overlay_color, $post );
        ?>

        <?php
        ob_start();
        ?>
        <tr>
            <td class="beafwc-option-label"><label for="beafwc_custom_height_width"><?php echo esc_html__( 'Custom Width_Height', 'beafwc' ); ?><div class="beafwc-tooltip"><span>?</span><div class="beafwc-tooltip-info"><?php echo esc_html__( 'Pro feature!', 'beafwc' ); ?></div>
                    </div></label>
            </td>
            <td class="beafwc-option-content">
                <label for="beafwc_width"><input style="width:100px" type="text" id="beafwc_width" name="beafwc_width" placeholder="100%"> <?php echo esc_html__( 'Width', 'beafwc' ); ?></label>
                <br>
                <br>
                <label for="beafwc_height"><input style="width:100px" type="text" id="beafwc_height" name="beafwc_height" placeholder="auto"><?php echo esc_html__( 'Height', 'beafwc' ); ?> </label>

                <p><?php echo esc_html__( 'Set a specific height and width for this slider. (e.g: 100% or 400px)', 'beafwc' ); ?></p>
            </td>
        </tr>
        <?php
        $beafwc_custom_height_width = ob_get_clean();
        echo apply_filters( 'beafwc_custom_height_width', $beafwc_custom_height_width, $post );
        ?>

        <?php
        ob_start();
        ?>
    </table>
</div>
    <?php
    // Noncename needed to verify where the data originated
    wp_nonce_field( 'beafwc_meta_box_nonce', 'beafwc_meta_box_noncename' );
    ?>
<?php
    $contents = ob_get_clean();

    echo apply_filters( 'beafwc_meta_fields', $contents, $post );

    }
}

//save meta value with save post hook
add_action( 'save_post', 'beafwc_save_post' );
function beafwc_save_post( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( !isset( $_POST['beafwc_meta_box_noncename'] ) || !wp_verify_nonce( $_POST['beafwc_meta_box_noncename'], 'beafwc_meta_box_nonce' ) ) {
        return;
    }

    if ( !current_user_can( 'edit_posts' ) ) {
        return;
    }

    if ( isset( $_POST['beafwc_activate_slider'] ) ) {
        update_post_meta( $post_id, 'beafwc_activate_slider', esc_attr( $_POST['beafwc_activate_slider'] ) );
    }
    if ( isset( $_POST['beafwc_before_image'] ) ) {
        update_post_meta( $post_id, 'beafwc_before_image', esc_url_raw( $_POST['beafwc_before_image'] ) );
    }
    if ( isset( $_POST['beafwc_after_image'] ) ) {
        update_post_meta( $post_id, 'beafwc_after_image', esc_url_raw( $_POST['beafwc_after_image'] ) );
    }

    if ( isset( $_POST['beafwc_slider_title'] ) ) {
        update_post_meta( $post_id, 'beafwc_slider_title', sanitize_text_field( $_POST['beafwc_slider_title'] ) );
    }
    if ( isset( $_POST['beafwc_image_styles'] ) ) {
        update_post_meta( $post_id, 'beafwc_image_styles', esc_attr( $_POST['beafwc_image_styles'] ) );
    }
    if ( isset( $_POST['beafwc_default_offset'] ) ) {
        update_post_meta( $post_id, 'beafwc_default_offset', esc_attr( $_POST['beafwc_default_offset'] ) );
    }

    if ( isset( $_POST['beafwc_before_label'] ) ) {
        update_post_meta( $post_id, 'beafwc_before_label', esc_attr( $_POST['beafwc_before_label'] ) );
    }

    if ( isset( $_POST['beafwc_after_label'] ) ) {
        update_post_meta( $post_id, 'beafwc_after_label', esc_attr( $_POST['beafwc_after_label'] ) );
    }
    if ( isset( $_POST['beafwc_move_slider_on_hover'] ) ) {
        update_post_meta( $post_id, 'beafwc_move_slider_on_hover', esc_attr( $_POST['beafwc_move_slider_on_hover'] ) );
    }

    if ( isset( $_POST['beafwc_click_to_move'] ) ) {
        update_post_meta( $post_id, 'beafwc_click_to_move', esc_attr( $_POST['beafwc_click_to_move'] ) );
    }

    if ( isset( $_POST['beafwc_no_overlay'] ) ) {
        update_post_meta( $post_id, 'beafwc_no_overlay', esc_attr( $_POST['beafwc_no_overlay'] ) );
    }

    if ( isset( $_POST['beafwc_before_label_background'] ) ) {
        update_post_meta( $post_id, 'beafwc_before_label_background', esc_attr( $_POST['beafwc_before_label_background'] ) );
    }

    if ( isset( $_POST['beafwc_before_label_color'] ) ) {
        update_post_meta( $post_id, 'beafwc_before_label_color', esc_attr( $_POST['beafwc_before_label_color'] ) );
    }

    if ( isset( $_POST['beafwc_after_label_background'] ) ) {
        update_post_meta( $post_id, 'beafwc_after_label_background', esc_attr( $_POST['beafwc_after_label_background'] ) );
    }

    if ( isset( $_POST['beafwc_after_label_color'] ) ) {
        update_post_meta( $post_id, 'beafwc_after_label_color', esc_attr( $_POST['beafwc_after_label_color'] ) );
    }

    if ( isset( $_POST['skip_lazy_load'] ) ) {
        update_post_meta( $post_id, 'skip_lazy_load', esc_attr( $_POST['skip_lazy_load'] ) );
    }

    if ( isset( $_POST['beafwc_on_scroll_slide'] ) ) {
        update_post_meta( $post_id, 'beafwc_on_scroll_slide', esc_attr( $_POST['beafwc_on_scroll_slide'] ) );
    }
    

    do_action( 'beafwc_save_post_meta', $post_id );

}
