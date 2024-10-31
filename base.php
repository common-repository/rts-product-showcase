<?php
/**
 * Main Elementor Extension Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class WPNP_WOOProduct_Elementor_Extension_Free {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '5.4';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * @var Elementor_Test_Extension The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return Elementor_Test_Extension An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 *
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function i18n() {
		load_plugin_textdomain( 'wooproduct-showcase' );
	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}
		// Add Plugin actions
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
		add_action( 'elementor/elements/categories_registered', [ $this, 'add_category' ] );
	
		add_action( 'wp_enqueue_scripts', [ $this, 'wpnp_register_plugin_styles' ] );		
		add_action( 'admin_enqueue_scripts', [ $this, 'WPNP_admin_defualt_css' ] );		
		add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'WPNP_register_plugin_admin_styles' ] );
		$this->include_files();		
	}

	public function wpnp_register_plugin_styles() {

		$dir = plugin_dir_url(__FILE__);   

        wp_enqueue_style( 'bootstrap', $dir.'assets/css/bootstrap.min.css', array(), '1.0.0', 'all' );
        wp_enqueue_style( 'wpnp-elements', $dir.'assets/css/elements.css', array(), microtime(), 'all' );
        wp_enqueue_style( 'swiper-bundle-css', $dir.'assets/css/swiper-bundle.min.css' );
        wp_enqueue_style( 'rt-icons', $dir.'assets/css/rt-icons.css' );
        //enqueue javascript

        wp_enqueue_script( 'swiper-bundle-js', $dir.'assets/js/swiper-bundle.min.js', array('jquery'), '823', true);
        wp_enqueue_script( 'wpnp-bootstrap-bundle', $dir.'assets/js/bootstrap-bundle.min.js', NULL, '823', true);
			

		wp_enqueue_script( 'wpnp-custom-pro', $dir.'assets/js/custom.js', array('jquery'), '201513434', true);
        
    }

    public function WPNP_register_plugin_admin_styles(){
    	$dir = plugin_dir_url(__FILE__);
    	wp_enqueue_style( 'wpnp-admin-pro', $dir.'assets/css/admin/admin.css' );
    	wp_enqueue_style( 'wpnp-admin-rt-icons-pro', $dir.'assets/css/rt-icons.css' );
    } 

    public function WPNP_admin_defualt_css(){
    	$dir = plugin_dir_url(__FILE__);
    	wp_enqueue_style( 'wpnp-admin-pro-style', $dir.'assets/css/admin/style.css' );    	
    }

     public function include_files() { 
          
        require( __DIR__ . '/inc/helper.php' );       
       
    }

	public function add_category( $elements_manager ) {
        $elements_manager->add_category(
            'wpnp_wooproduct_category',
            [
                'title' => esc_html__('Nice WoProduct Addons', 'wooproduct-showcase' ),
                'icon' => 'fa fa-smile-o',
            ]
        );
    }



	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'wooproduct-showcase' ),
			'<strong>' . esc_html__( 'WooProduct Showcase Elementor WooCommerce Addon', 'wooproduct-showcase' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'wooproduct-showcase' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'wooproduct-showcase' ),
			'<strong>' . esc_html__( 'WooProduct Showcase m Elementor Addon', 'wooproduct-showcase' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'wooproduct-showcase' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'wooproduct-showcase' ),
			'<strong>' . esc_html__( 'WooProducts Showcase Elementor Addon', 'wooproduct-showcase' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'wooproduct-showcase' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init_widgets() {
		
		
		if(class_exists('woocommerce')):
			
			require_once( __DIR__ . '/widgets/product-grid/product-grid.php' );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \WPNP_Elementor_Product_Grid_Widget_Free() );
			require_once( __DIR__ . '/widgets/product-slider/product-slider.php' );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \WPNP_Elementor_Product_Slider_Widget_Free() );
									

		endif;

		add_action( 'elementor/elements/categories_registered', [$this, 'add_category'] );
		
	}
}
WPNP_WOOProduct_Elementor_Extension_Free::instance();