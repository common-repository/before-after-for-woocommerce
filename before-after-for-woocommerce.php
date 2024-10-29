<?php
/**
 * Plugin Name: Before After Slider for WooCommerce - eBEAF
 * Plugin URI: https://themefic.com/plugins/ebeaf/
 * Description: Want to show comparison of two images on your WooCommerce Store? Easily create before and after image slider for WooCommerce and add it on your single product page.
 * Version: 1.2.2
 * Author: Themefic
 * Author URI: https://themefic.com/
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: beafwc
 * Domain Path: /languages
 * WC tested up to: 8.4
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit();
}
class Before_After_Gallery_WooCommerce {

    public function __construct() {

        /*
         * Enqueue css and js for beafwc
         */
        add_action( 'wp_enqueue_scripts', array( $this, 'beafwc_image_before_after_foucs_scripts' ), 999 );
        add_action( 'admin_enqueue_scripts', array( $this, 'beafwc_image_before_after_foucs_scripts' ) );

        // BEAF_PLUGIN_URL
        if(!defined('EBEAF_PLUGIN_URL')){ 
            define( 'EBEAF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
        }
        /*
         * beafwc meta fields
         */
        $this->beafwc_meta_fields();

        /*
         * Require admin file
         */
        require_once 'admin/beafwc-admin.php';

        /*
         * Adding shortcode for beafwc
         */
        add_shortcode( 'beafwc', array( $this, 'beafwc_post_shortcode' ) );

        /*
         * Initialize the plugin tracker
         */
        $this->appsero_init_tracker_before_after_for_woocommerce();

        /*
         * Require function file
         */
        require_once 'inc/functions.php';
        
        /**High performance order status support */
        add_action( 'before_woocommerce_init', function() {
            if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
                \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
            }
        } );
        
    }

    /*
     * Enqueue css and js in frontend
     */
    public function beafwc_image_before_after_foucs_scripts() {

        wp_enqueue_style( 'beafwc_twentytwenty', plugin_dir_url( __FILE__ ) . 'assets/css/twentytwenty.css' );
        wp_enqueue_style( 'beafwc-style', plugin_dir_url( __FILE__ ) . 'assets/css/beafwc-style.css' );

        wp_enqueue_script( 'jquery-event-move', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.event.move.js', array( 'jquery' ), null, false );
        wp_enqueue_script( 'beafwc_twentytwenty', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.twentytwenty.js', array( 'jquery' ), null, true );
        wp_enqueue_script( 'beafwc_custom_js', plugin_dir_url( __FILE__ ) . 'assets/js/beafwc-custom-js.js', array( 'jquery', 'flexslider' ), null, true );
    }

    /*
    metabox included
     */
    public function beafwc_meta_fields() {
        require_once 'inc/metabox/beafwc-metaboxes.php';
    }

    /*
     * beafwc shortcode callback
     */
    public function beafwc_post_shortcode( $atts, $content = null ) {

        extract( shortcode_atts( array(
            'id' => '',
        ), $atts ) );

        ob_start();

        $b_image = get_post_meta( $id, 'beafwc_before_image', true );
        $a_image = get_post_meta( $id, 'beafwc_after_image', true );

        $orientation = !empty( get_post_meta( $id, 'beafwc_image_styles', true ) ) ? get_post_meta( $id, 'beafwc_image_styles', true ) : 'horizontal';
        $offset = !empty( get_post_meta( $id, 'beafwc_default_offset', true ) ) ? get_post_meta( $id, 'beafwc_default_offset', true ) : '0.5';
        $before_label = !empty( get_post_meta( $id, 'beafwc_before_label', true ) ) ? get_post_meta( $id, 'beafwc_before_label', true ) : 'Before';
        $after_label = !empty( get_post_meta( $id, 'beafwc_after_label', true ) ) ? get_post_meta( $id, 'beafwc_after_label', true ) : 'After';
        $overlay = !empty( get_post_meta( $id, 'beafwc_no_overlay', true ) ) ? get_post_meta( $id, 'beafwc_no_overlay', true ) : 'no';
        $move_slider_on_hover = !empty( get_post_meta( $id, 'beafwc_move_slider_on_hover', true ) ) ? get_post_meta( $id, 'beafwc_move_slider_on_hover', true ) : 'no';
        $click_to_move = !empty( get_post_meta( $id, 'beafwc_click_to_move', true ) ) ? get_post_meta( $id, 'beafwc_click_to_move', true ) : 'no';
        $beafwc_on_scroll_slide = (get_post_meta( $id, 'beafwc_on_scroll_slide', true ) == 'true') ? 'beafwc-on-scroll-slide' : '';

        $skip_lazy_load = get_post_meta( $id, 'skip_lazy_load', true );

        if ( $skip_lazy_load == 'yes' ) {
            $skip_lazy = 'skip-lazy';
            $data_skip_lazy = 'data-skip-lazy';
        } else {
            $skip_lazy = '';
            $data_skip_lazy = '';
        }

        if ( get_post_status( $id ) == 'publish' ):
        ?>

		<?php do_action( 'beafwc_before_slider', $id );?>

		<div data-thumb="<?php echo esc_url( $b_image ); ?>" class="woocommerce-product-gallery__image twentytwenty-wrapper beafwc-twentytwenty-wrapper <?php echo esc_attr( $beafwc_on_scroll_slide ); ?>">
			<div class="beafwc-twentytwenty-container <?php echo esc_attr( 'slider-' . $id . '' ); ?> <?php if ( get_post_meta( $id, 'beafwc_custom_color', true ) == 'yes' ) { echo 'beafwc-custom-color';
					}?>" beafwc-orientation="<?php echo esc_attr( $orientation ); ?>" beafwc-default-offset="<?php echo esc_attr( $offset ); ?>" beafwc-before-label="<?php echo esc_attr( $before_label ); ?>" beafwc-after-label="<?php echo esc_attr( $after_label ); ?>" beafwc-overlay="<?php echo esc_attr( $overlay ); ?>" beafwc-move-slider-on-hover="<?php echo esc_attr( $move_slider_on_hover ); ?>" beafwc-click-to-move="<?php echo esc_attr( $click_to_move ); ?>">
				<img class="beafwc-before-image <?php echo esc_attr( $skip_lazy ); ?>" <?php echo esc_attr( $data_skip_lazy ); ?> src="<?php echo esc_url( $b_image ); ?>" alt="Before Image">
				<img class="beafwc-after-image <?php echo esc_attr( $skip_lazy ); ?>" <?php echo esc_attr( $data_skip_lazy ); ?> src="<?php echo esc_url( $a_image ); ?>" alt="After Image">
			</div>
		</div>

		<?php do_action( 'beafwc_after_slider', $id );?>

	<style>
		<?php $beafwc_before_label_background = !empty( get_post_meta( $id, 'beafwc_before_label_background', true ) ) ? get_post_meta( $id, 'beafwc_before_label_background', true ) : '';

		$beafwc_before_label_color = !empty( get_post_meta( $id, 'beafwc_before_label_color', true ) ) ? get_post_meta( $id, 'beafwc_before_label_color', true ) : '';

		$beafwc_after_label_background = !empty( get_post_meta( $id, 'beafwc_after_label_background', true ) ) ? get_post_meta( $id, 'beafwc_after_label_background', true ) : '';

		$beafwc_after_label_color = !empty( get_post_meta( $id, 'beafwc_after_label_color', true ) ) ? get_post_meta( $id, 'beafwc_after_label_color', true ) : '';

		?><?php if ( !empty( $beafwc_before_label_background ) || !empty( $beafwc_before_label_color ) ) {
			?>.<?php echo 'slider-' . esc_attr( $id ) . ' ';

			?>.twentytwenty-before-label::before {
			background: <?php echo esc_attr( $beafwc_before_label_background );
			?>;
			color: <?php echo esc_attr( $beafwc_before_label_color );
			?>;
		}

		<?php
		}

		?><?php if ( !empty( $beafwc_after_label_background ) || !empty( $beafwc_after_label_color ) ) {
			?>.<?php echo 'slider-' . esc_attr( $id ) . ' ';

			?>.twentytwenty-after-label::before {
			background: <?php echo esc_attr( $beafwc_after_label_background );
			?>;
			color: <?php echo esc_attr( $beafwc_after_label_color );
			?>;
		}

		<?php
		}

		?>

	</style>
	<?php
	endif;
	return ob_get_clean();
    }
    
    /**
     * Initialize the plugin tracker
     *
     * @return void
     */
    function appsero_init_tracker_before_after_for_woocommerce() {

        if ( ! class_exists( 'Appsero\Client' ) ) {
            require_once ( __DIR__ . '/inc/app/src/Client.php');
        }

        $client = new Appsero\Client( '91b32371-6a97-4a05-8c00-bb1efb0378a7', 'Before After Slider for WooCommerce – eBEAF', __FILE__ );
        
        // Change Admin notice text

        $notice = sprintf( $client->__trans( 'Want to help make <strong>%1$s</strong> even more awesome? Allow %1$s to collect non-sensitive diagnostic data and usage information. I agree to get Important Product Updates & Discount related information on my email from  %1$s (I can unsubscribe anytime).' ), $client->name );
        $client->insights()->notice($notice);

        // Active insights
        $client->insights()->init();

    }

}

new Before_After_Gallery_WooCommerce();
