<?php 
/**
 *Plugin Name: RTS Product Showcase
 * Description: Attractive grid and slider Layouts for WooCommerce Product Showcase Free Version.
 * Version:     1.0.0
 * Author: ReacThemes
 * Author URI:https://reactheme.com
 * License: GPLv2 or later
 * Domain Path: /languages/
 * Text Domain: wooproduct-showcase
 */


if ( ! function_exists( 'rps_fs' ) ) {
    // Create a helper function for easy SDK access.
    function rps_fs() {
        global $rps_fs;

        if ( ! isset( $rps_fs ) ) {
            // Include Freemius SDK.
            require_once dirname(__FILE__) . '/freemius/start.php';

            $rps_fs = fs_dynamic_init( array(
                'id'                  => '10955',
                'slug'                => 'rts-product-showcase',
                'premium_slug'        => 'rts-wooproduct-showcase-pro',
                'type'                => 'plugin',
                'public_key'          => 'pk_455fb4034a1a9d2a5ba57dedc0fa8',
                'is_premium'          => true,
                'is_premium_only'     => true,
                'has_addons'          => false,
                'has_paid_plans'      => true,
                'menu'                => array(
                    'first-path'     => 'plugins.php',
                ),
                // Set the SDK to work in a sandbox mode (for development & testing).
                // IMPORTANT: MAKE SURE TO REMOVE SECRET KEY BEFORE DEPLOYMENT.
                'secret_key'          => 'sk_JGXWi>oQ?~07nao42L*h.dUcnyCJL',
            ) );
        }

        return $rps_fs;
    }

    // Init Freemius.
    rps_fs();
    // Signal that SDK was initiated.
    do_action( 'rps_fs_loaded' );
}

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Pro version check.
 *
 * @return boolean
 */
function is_wooproduct_showcase_pro() {
	include_once ABSPATH . 'wp-admin/includes/plugin.php';
	if ( ! ( is_plugin_active( 'rts-wooproduct-showcase-pro/rts-wooproduct-showcase-pro.php' ) || is_plugin_active_for_network( 'rts-wooproduct-showcase-pro/rts-wooproduct-showcase-pro.php' ) ) ) {
		return true;
	}
}

define( 'WOOPRODUCT_SHOWCASE_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'WOOPRODUCT_SHOWCASE_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'WOOPRODUCT_SHOWCASE_ASSETS', trailingslashit( WOOPRODUCT_SHOWCASE_DIR_URL . 'assets' ) );

class WPNP_WOOPRODUCT_SHOWCASE_FREE_INITIAL{
	function __construct(){
		require WOOPRODUCT_SHOWCASE_DIR_PATH . 'base.php';
	}	
}

if ( is_wooproduct_showcase_pro() ) {
	new WPNP_WOOPRODUCT_SHOWCASE_FREE_INITIAL();
}

