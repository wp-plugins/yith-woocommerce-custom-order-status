<?php
/**
 * Plugin Name: YITH WooCommerce Custom Order Status
 * Plugin URI: https://yithemes.com/themes/plugins/yith-woocommerce-custom-order-status/
 * Description: YITH WooCommerce Custom Order Status allows you to create and manage custom order statuses for Woocommerce.
 * Version: 1.0.6
 * Author: YIThemes
 * Author URI: http://yithemes.com/
 * Text Domain: yith-wccos
 * Domain Path: /languages/
 *
 * @author  yithemes
 * @package YITH WooCommerce Custom Order Status
 * @version 1.0.6
 */
/*  Copyright 2015  Your Inspiration Themes  (email : plugins@yithemes.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* == COMMENT == */

if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( !function_exists( 'is_plugin_active' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

function yith_wccos_install_woocommerce_admin_notice() {
    ?>
    <div class="error">
        <p><?php _e( 'YITH WooCommerce Custom Order Status is enabled but not effective. It requires WooCommerce in order to work.', 'yit' ); ?></p>
    </div>
    <?php
}


function yith_wccos_install_free_admin_notice() {
    ?>
    <div class="error">
        <p><?php _e( 'You can\'t activate the free version of YITH WooCommerce Custom Order Status while you are using the premium one.', 'yit' ); ?></p>
    </div>
    <?php
}

if ( !function_exists( 'yith_plugin_registration_hook' ) ) {
    require_once 'plugin-fw/yit-plugin-registration-hook.php';
}
register_activation_hook( __FILE__, 'yith_plugin_registration_hook' );


if ( !defined( 'YITH_WCCOS_VERSION' ) ) {
    define( 'YITH_WCCOS_VERSION', '1.0.6' );
}

if ( !defined( 'YITH_WCCOS_FREE_INIT' ) ) {
    define( 'YITH_WCCOS_FREE_INIT', plugin_basename( __FILE__ ) );
}

if ( !defined( 'YITH_WCCOS' ) ) {
    define( 'YITH_WCCOS', true );
}

if ( !defined( 'YITH_WCCOS_FILE' ) ) {
    define( 'YITH_WCCOS_FILE', __FILE__ );
}

if ( !defined( 'YITH_WCCOS_URL' ) ) {
    define( 'YITH_WCCOS_URL', plugin_dir_url( __FILE__ ) );
}

if ( !defined( 'YITH_WCCOS_DIR' ) ) {
    define( 'YITH_WCCOS_DIR', plugin_dir_path( __FILE__ ) );
}

if ( !defined( 'YITH_WCCOS_TEMPLATE_PATH' ) ) {
    define( 'YITH_WCCOS_TEMPLATE_PATH', YITH_WCCOS_DIR . 'templates' );
}

if ( !defined( 'YITH_WCCOS_ASSETS_URL' ) ) {
    define( 'YITH_WCCOS_ASSETS_URL', YITH_WCCOS_URL . 'assets' );
}

if ( !defined( 'YITH_WCCOS_ASSETS_PATH' ) ) {
    define( 'YITH_WCCOS_ASSETS_PATH', YITH_WCCOS_DIR . 'assets' );
}


function yith_wccos_init() {

    load_plugin_textdomain( 'yith-wccos', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

    // Load required classes and functions
    require_once( 'class.yith-wccos-admin.php' );
    require_once( 'class.yith-wccos-frontend.php' );
    require_once( 'class.yith-wccos.php' );

    // Let's start the game!
    YITH_WCCOS();
}

add_action( 'yith_wccos_init', 'yith_wccos_init' );


function yith_wccos_install() {

    if ( !function_exists( 'WC' ) ) {
        add_action( 'admin_notices', 'yith_wccos_install_woocommerce_admin_notice' );
    } elseif ( defined( 'YITH_WCCOS_PREMIUM' ) ) {
        add_action( 'admin_notices', 'yith_wccos_install_free_admin_notice' );
        deactivate_plugins( plugin_basename( __FILE__ ) );
    } else {
        do_action( 'yith_wccos_init' );
    }
}

add_action( 'plugins_loaded', 'yith_wccos_install', 11 );


/* Plugin Framework Version Check */
if ( !function_exists( 'yit_maybe_plugin_fw_loader' ) && file_exists( plugin_dir_path( __FILE__ ) . 'plugin-fw/init.php' ) ) {
    require_once( plugin_dir_path( __FILE__ ) . 'plugin-fw/init.php' );
}
yit_maybe_plugin_fw_loader( plugin_dir_path( __FILE__ ) );