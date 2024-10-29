<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit();
}

/*
 * Enqueue css and js for beafwc
 */
add_action( 'admin_enqueue_scripts', 'beafwc_admin_enqueue_scripts' );

//Enqueue script in admin area
function beafwc_admin_enqueue_scripts() {
    wp_enqueue_script( 'wp-color-picker-alpha', plugins_url( '../assets/js/wp-color-picker-alpha.min.js',__FILE__ ), array( 'jquery','wp-color-picker'), null, true );
    wp_enqueue_script( 'beafwc-custom', plugins_url( '../assets/js/beafwc-script.js', __FILE__ ), array( 'jquery' ), null, true );
    wp_enqueue_style( 'beafwc_admin_style', plugins_url( '../assets/css/beafwc-admin-style.css', __FILE__ ) );
}

/**
 * Add action links to the plugin list page
 * @since 1.1.1
 * @return array() 
 */
add_filter( 'plugin_action_links_before-after-for-woocommerce/before-after-for-woocommerce.php', 'beafwc_plugin_settings_links' );
function beafwc_plugin_settings_links( $links ){

    //create the link
    $doc_link = "<a target='_blank' href='https://themefic.com/docs/ebeaf/'>" . __( 'Documentation', 'beafwc' ) . "</a>";   
    $pro_link = "<a target='_blank' href='https://themefic.com/plugins/ebeaf/' class='beafwc-go-pro'>" . __( 'Go Pro', 'beafwc' ) . "</a>";

    
    //add links
    array_push( 
        $links,
        $doc_link,
        $pro_link
        );

    //check if the Pro version is installed 
    if( class_exists( 'Before_After_Gallery_WooCommerce_Pro' )) : 
        array_pop($links);
    endif;

    return $links;
}

add_action( 'admin_menu', 'beafwc_add_menu_page' );
/**
 * Add menu page for beafwc
 * @since 1.1.1
 * @return url
 */
function beafwc_add_menu_page () {

    add_menu_page( __( 'eBEAF','beafwc' ), __( 'eBEAF','beafwc' ), 'manage_options', 'beafwc-add-new-slider', 'beafwc_add_new_slider', 'dashicons-image-flip-horizontal', 13);

    add_submenu_page( 'beafwc-add-new-slider', __( 'Add New Slider','beafwc' ), __( 'Add New Slider','beafwc' ), 'manage_options', 'add-new-slider', 'beafwc_add_new_slider' );
    add_submenu_page( 'beafwc-add-new-slider', __( 'Documentation','beafwc' ), __( 'Documentation','beafwc' ), 'manage_options', 'https://themefic.com/docs/ebeaf/' );
    
    //check if the Pro version is installed 
    if( ! class_exists( 'Before_After_Gallery_WooCommerce_Pro' )) : 
        add_submenu_page( 'beafwc-add-new-slider', __( 'Go Pro','beafwc' ), '<span class="beafwc-go-pro">' . __( 'Go Pro','beafwc') .'</span>', 'manage_options', 'https://themefic.com/plugins/ebeaf/pro/' );
    endif;
}

/**
 * callback function of Add new slider
 * @since 1.1.1
 */
function beafwc_add_new_slider(){
    
    //redirect to add new product panel when click on the eBEAF Menu
    wp_redirect( home_url() . '/wp-admin/post-new.php?post_type=product' ); 
    exit;
}

add_action( 'admin_notices', 'beafwc_woocommerce_installation_notice_error' );
/*
* Admin notice: Plugin installation error
*/
function beafwc_woocommerce_installation_notice_error() {
    if(! class_exists( 'WooCommerce' ) ):
    ?>
    <div class="notice notice-error is-dismissible">
        <p><?php echo esc_html__( 'eBEAF requires', 'beafwc' );
        echo '<a href="' . admin_url( 'plugin-install.php?s=WooCommerce&tab=search&type=term' ) . '"> WooCommerce </a>';
        echo esc_html__( 'to be installed and active.', 'beafwc' ); ?>
        </p>
    </div>
    <?php
    endif;
}