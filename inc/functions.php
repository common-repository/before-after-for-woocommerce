<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit();
}

/**
 * Black Friday Deals 2023
 */
// inclue plugin.php file

include_once(ABSPATH . 'wp-admin/includes/plugin.php');
if(!function_exists('tf_black_friday_2023_admin_notice') && !is_plugin_active('before-after-for-woocommerce-pro/before-after-for-woocommerce-pro.php')){
	function tf_black_friday_2023_admin_notice(){

		// Set the expiration time to 3 hours from the current time
        $expiration_time = time() + 3 * 60 * 60;  
        $tf_display_admin_notice_time = get_option( 'tf_display_admin_notice_time' );
        if($tf_display_admin_notice_time == ''){
            update_option( 'tf_display_admin_notice_time', $expiration_time );
        }

		$deal_link =sanitize_url('https://themefic.com/deals/');
		$get_current_screen = get_current_screen();  
		if(!isset($_COOKIE['tf_dismiss_admin_notice']) && $get_current_screen->base == 'dashboard' && time() > $tf_display_admin_notice_time ){ 
            ?>
            <style> 
                .tf_black_friday_20222_admin_notice a:focus {
                    box-shadow: none;
                } 
                .tf_black_friday_20222_admin_notice {
                    padding: 7px;
                    position: relative;
                    z-index: 10;
					max-width: 825px;
                } 
                .tf_black_friday_20222_admin_notice button:before {
                    color: #fff !important;
                }
                .tf_black_friday_20222_admin_notice button:hover::before {
                    color: #d63638 !important;
                }
            </style>
            <div class="notice notice-success tf_black_friday_20222_admin_notice"> 
                <a href="<?php echo $deal_link; ?>" target="_blank" >
			<img  style="width: 100%;" src="<?php echo esc_url( 'https://themefic.com/wp-content/uploads/2023/11/Themefic_BlackFriday_rectangle_banner.png') ?>" alt="">
                </a> 
                <button type="button" class="notice-dismiss tf_black_friday_notice_dismiss"><span class="screen-reader-text"><?php echo __('Dismiss this notice.', 'ultimate-addons-cf7' ) ?></span></button>
            </div>
            <script>
                jQuery(document).ready(function($) {
                    $(document).on('click', '.tf_black_friday_notice_dismiss', function( event ) {
                        jQuery('.tf_black_friday_20222_admin_notice').css('display', 'none')
                        data = {
                            action : 'tf_black_friday_notice_dismiss_callback',
                        };

                        $.ajax({
                            url: ajaxurl,
                            type: 'post',
                            data: data,
                            success: function (data) { ;
                            },
                            error: function (data) { 
                            }
                        });
                    });
                });
            </script>
        
        <?php 
		}
		
	} 
	if (strtotime('2023-12-01') > time()) {
		add_action( 'admin_notices', 'tf_black_friday_2023_admin_notice' );  
	}   
}

if(!function_exists('tf_black_friday_notice_dismiss_callback')){
	function tf_black_friday_notice_dismiss_callback() { 
		$cookie_name = "tf_dismiss_admin_notice";
		$cookie_value = "1"; 
		setcookie($cookie_name, $cookie_value, strtotime('2023-12-01'), "/"); 
		update_option( 'tf_display_admin_notice_time', '1' );
		wp_die();
	}
	add_action( 'wp_ajax_tf_black_friday_notice_dismiss_callback', 'tf_black_friday_notice_dismiss_callback' );
}
 
add_action( 'wp_ajax_beaf_black_friday_notice_dismiss_callback', 'beaf_black_friday_notice_dismiss_callback' );


//product pages 
if ( ! function_exists( 'tf_black_friday_2023_woo_product_ebeaf' )  && !is_plugin_active('before-after-for-woocommerce-pro/before-after-for-woocommerce-pro.php') ) {
	function tf_black_friday_2023_woo_product_ebeaf() {
		if ( ! isset( $_COOKIE['tf_black_friday_sidbar_notice_ebeaf'] ) ) {
			add_meta_box( 'tf_black_friday_annous_ebeaf', __( ' ', 'e-Beaf' ), 'tf_black_friday_2023_callback_woo_product_ebeaf', 'product', 'side',);
		}
	}

	if ( strtotime( '2023-12-01' ) > time() ) {
		add_action( 'add_meta_boxes', 'tf_black_friday_2023_woo_product_ebeaf' );
	}
	function tf_black_friday_2023_callback_woo_product_ebeaf() {
		$deal_link = sanitize_url( 'https://themefic.com/deals' );
		?>
		<style>
			#tf_black_friday_annous_ebeaf{
				border: 0px solid;
				box-shadow: none;
				background: transparent;
			}
			.back_friday_2023_preview a:focus {
				box-shadow: none;
			}

			.back_friday_2023_preview a {
				display: inline-block;
			}

			#tf_black_friday_annous_ebeaf .inside {
				padding: 0;
				margin-top: 0;
			}

			#tf_black_friday_annous_ebeaf .postbox-header {
				display: none;
				visibility: hidden;
			}
		</style>
		<div class="back_friday_2023_preview ebeaf_preview" style="text-align: center; overflow: hidden;">
			<button type="button" class="notice-dismiss ebeaf_friday_notice_dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
			<a href="<?php echo $deal_link; ?>" target="_blank">
				<img style="width: 100%;" src="<?php echo esc_url('https://themefic.com/wp-content/uploads/2023/11/eBEAF_BlackFriday_squre_banner.png') ?>" alt="">
			</a>
			<script>
			jQuery(document).ready(function($) {
				$(document).on('click', '.ebeaf_friday_notice_dismiss', function( event ) { 
					jQuery('.ebeaf_preview').css('display', 'none')
					var cookieName = "tf_black_friday_sidbar_notice_ebeaf";
					var cookieValue = "1";

					// Create a date object for the expiration date
					var expirationDate = new Date();
					expirationDate.setTime(expirationDate.getTime() + (5 * 24 * 60 * 60 * 1000)); // 5 days in milliseconds

					// Construct the cookie string
					var cookieString = cookieName + "=" + cookieValue + ";expires=" + expirationDate.toUTCString() + ";path=/";

					// Set the cookie
					document.cookie = cookieString;
				});
			});
			</script>
		</div>
		<?php
	}
}

add_filter( 'get_user_option_meta-box-order_product', 'ebeaf_metabox_order' );
function ebeaf_metabox_order( $order ) {
	return array(
		'side' => join( 
			",", 
			array(       // vvv  Arrange here as you desire
				'submitdiv',
				'tf_black_friday_annous_ebeaf',
			)
		),
	);
}

/*
* Init woo functions
*/
add_action( 'init', 'beafwc_init_woo_functions' );
function beafwc_init_woo_functions(){
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
	remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
	add_action( 'woocommerce_product_thumbnails', 'beafwc_woocommerce_show_product_thumbnails', 20 );
	add_action( 'woocommerce_before_single_product_summary', 'beafwc_woocommerce_show_product_images', 20 );
}

if ( ! function_exists( 'beafwc_woocommerce_show_product_images' ) ) {
function beafwc_woocommerce_show_product_images() {
	
	$beafwc_slider_active = !empty( get_post_meta( get_the_ID(), 'beafwc_activate_slider', true ) ) ? get_post_meta( get_the_ID(), 'beafwc_activate_slider', true ) : 'no';
	
	if( $beafwc_slider_active == 'no' ) {
	
		wc_get_template( 'single-product/product-image.php' );
		return;
	}
	
	if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
		return;
	}

	global $product;

	$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
	$post_thumbnail_id = $product->get_image_id();
	$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . ( $product->get_image_id() ? 'with-images' : 'without-images' ),
		'woocommerce-product-gallery--columns-' . absint( $columns ),
		'images',
	) );
	?>
	
	<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
		<figure class="woocommerce-product-gallery__wrapper">
			<?php
	
			if( $beafwc_slider_active == 'yes' ) {
				//eBEAF slider
				echo do_shortcode( '[beafwc id="' . get_the_ID() . '"]' );
			}

			if ( $product->get_image_id() ) {
				$html = wc_get_gallery_image_html( $post_thumbnail_id, true );
			} else {
				$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
				$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
				$html .= '</div>';
			}

			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped

			do_action( 'woocommerce_product_thumbnails' );
			?>
		</figure>
	</div>
	<?php
}

}

if ( ! function_exists( 'beafwc_woocommerce_show_product_thumbnails' ) ) {
	function beafwc_woocommerce_show_product_thumbnails() {
		
		$beafwc_slider_active = !empty( get_post_meta( get_the_ID(), 'beafwc_activate_slider', true ) ) ? get_post_meta( get_the_ID(), 'beafwc_activate_slider', true ) : 'no';
	
		if( $beafwc_slider_active == 'no' ) {

			wc_get_template( 'single-product/product-thumbnails.php' );
			return;
		}
		
		if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
			return;
		}

		global $product;

		$attachment_ids = $product->get_gallery_image_ids();

		if ( $attachment_ids && $product->get_image_id() ) {
			foreach ( $attachment_ids as $attachment_id ) {
				echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', wc_get_gallery_image_html( $attachment_id ), $attachment_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
			}
		}
	}

}

/**
* Adding WooCommerce support
*/
add_action( 'after_setup_theme', 'beafwc_add_woocommerce_support' );
function beafwc_add_woocommerce_support() {
    add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

}

/**
* eBeaf support with WooCommerce product slider
*/
add_filter( 'woocommerce_single_product_carousel_options', 'beafwc_woocommerce_single_product_carousel_options_filter' );
function beafwc_woocommerce_single_product_carousel_options_filter( $array ){

	$beafwc_slider_active_check = !empty( get_post_meta( get_the_ID(), 'beafwc_activate_slider', true ) ) ? get_post_meta( get_the_ID(), 'beafwc_activate_slider', true ) : 'no';

	$beafwc_woocommerce_slider_option_array = array(
		'animation'      => 'slide',
		'smoothHeight'   => true,
		'directionNav'   => false,
		'controlNav'     => 'thumbnails',
		'slideshow'      => false,
		'animationSpeed' => 500,
		'animationLoop'  => false, // Breaks photoswipe pagination if true.
		'allowOneSlide'  => false,
		// 'touch' => false,
	);

	if($beafwc_slider_active_check == 'yes'){
		$beafwc_woocommerce_slider_option_array['touch'] = false;
	}else if($beafwc_slider_active_check == 'no'){
		$beafwc_woocommerce_slider_option_array['touch'] = true;
	}
	return $beafwc_woocommerce_slider_option_array;
}





// Themefic Plugin Set Admin Notice Status
if(!function_exists('beafwc_review_activation_status')){

    function beafwc_review_activation_status(){ 
        $beafwc_installation_date = get_option('beafwc_installation_date'); 
        if( !isset($_COOKIE['beafwc_installation_date']) && empty($beafwc_installation_date) && $beafwc_installation_date == 0){
            setcookie('beafwc_installation_date', 1, time() + (86400 * 7), "/"); 
        }else{
            update_option( 'beafwc_installation_date', '1' );
        }
    }
    add_action('admin_init', 'beafwc_review_activation_status');
}

// Themefic Plugin Review Admin Notice
if(!function_exists('beafwc_review_notice')){
    
     function beafwc_review_notice(){ 
        $get_current_screen = get_current_screen();  
        if($get_current_screen->base == 'dashboard'){
            $current_user = wp_get_current_user();
        ?>
            <div class="notice notice-info themefic_review_notice"> 
               
                <?php echo sprintf( 
                        __( ' <p>Hey %1$s 👋, You have been using <b>%2$s</b> for quite a while. If you feel %2$s is helping your business to grow in any way, would you please help %2$s to grow by simply leaving a 5* review on the WordPress Forum?', 'beafwc' ),
                        $current_user->user_login,
                        'Before After Slider for WooCommerce'
                    ); ?> 
                
                <ul>
                    <li><a target="_blank" href="<?php echo esc_url('https://wordpress.org/support/plugin/before-after-for-woocommerce/reviews/#new-post') ?>" class=""><span class="dashicons dashicons-external"></span><?php _e(' Ok, you deserve it!', 'beafwc' ) ?></a></li>
                    <li><a href="#" class="already_done" data-status="already"><span class="dashicons dashicons-smiley"></span> <?php _e('I already did', 'beafwc') ?></a></li>
                    <li><a href="#" class="later" data-status="later"><span class="dashicons dashicons-calendar-alt"></span> <?php _e('Maybe Later', 'beafwc') ?></a></li>
                    <li><a target="_blank"  href="<?php echo esc_url('https://themefic.com/docs/ebeaf/') ?>" class=""><span class="dashicons dashicons-sos"></span> <?php _e('I need help', 'beafwc') ?></a></li>
                    <li><a href="#" class="never" data-status="never"><span class="dashicons dashicons-dismiss"></span><?php _e('Never show again', 'beafwc') ?> </a></li> 
                </ul>
				<button type="button" class="notice-dismiss review_notice_dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
            </div>

            <!--   Themefic Plugin Review Admin Notice Script -->
            <script>
                jQuery(document).ready(function($) {
                    $(document).on('click', '.already_done, .later, .never', function( event ) {
                        event.preventDefault();
                        var $this = $(this);
                        var status = $this.attr('data-status'); 
                        $this.closest('.themefic_review_notice').css('display', 'none')
                        data = {
                            action : 'beafwc_review_notice_callback',
                            status : status,
                        };

                        $.ajax({
                            url: ajaxurl,
                            type: 'post',
                            data: data,
                            success: function (data) { ;
                            },
                            error: function (data) { 
                            }
                        });
                    });
                    $(document).on('click', '.review_notice_dismiss', function( event ) {
                        event.preventDefault(); 
						var $this = $(this);
                        $this.closest('.themefic_review_notice').css('display', 'none')
                        
                    });
                });
            </script>
        <?php  
        }
     }
     $beafwc_review_notice_status = get_option('beafwc_review_notice_status'); 
     $beafwc_installation_date = get_option('beafwc_installation_date'); 
     if(isset($beafwc_review_notice_status) && $beafwc_review_notice_status <= 0 && $beafwc_installation_date == 1 && !isset($_COOKIE['beafwc_review_notice_status']) && !isset($_COOKIE['beafwc_installation_date'])){ 
        add_action( 'admin_notices', 'beafwc_review_notice' );  
     }
     
}

 
// Themefic Plugin Review Admin Notice Ajax Callback 
if(!function_exists('beafwc_review_notice_callback')){

    function beafwc_review_notice_callback(){
        $status = $_POST['status'];
        if( $status == 'already'){ 
            update_option( 'beafwc_review_notice_status', '1' );
        }else if($status == 'never'){ 
            update_option( 'beafwc_review_notice_status', '2' );
        }else if($status == 'later'){
            $cookie_name = "beafwc_review_notice_status";
            $cookie_value = "1";
            setcookie($cookie_name, $cookie_value, time() + (86400 * 7), "/"); 
            update_option( 'beafwc_review_notice_status', '0' ); 
        }  
        wp_die();
    }
    add_action( 'wp_ajax_beafwc_review_notice_callback', 'beafwc_review_notice_callback' );

}

