<?php
namespace Visualize;

use Visualize\Widgets\VisualizeLoop;
use Visualize\Widgets\VisualizeCarousel;
use Visualize\Widgets\VisualizeButton;
use Visualize\Widgets\VisualizeIconListAndNavbar;
use Visualize\Widgets\Template\VisualizeCarouselTemplate;
use Visualize\Widgets\Template\VisualizeButtonTemplate;
use Visualize\Widgets\Template\VisualizeIconListAndNavbarTemplate;
/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.0.0
 */
class Plugin {

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}


	/**
	 * widget_scripts
	 *
	 * Load required plugin core files.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function widget_scripts() {
		// css
		wp_enqueue_style( 'owl-carousel', plugins_url( '../assets/css/vendor/owl.carousel.min.css', __FILE__ ), [], null, 'all' );
		wp_enqueue_style( 'visualize-stylesheets', plugins_url( '../assets/css/style.css', __FILE__ ), [], null, 'all' );

		// js
		wp_register_script( 'owl-carousel', plugins_url( '../assets/js/vendor/owl.carousel.min.js', __FILE__ ), [ 'jquery' ], false, true );
		wp_register_script( 'visualize-scripts', plugins_url( '../assets/js/visualize.scripts.js', __FILE__ ), [ 'jquery' ], false, true );
	}

	/**
	 * Register Categories
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_categories( $elements_manager ){
		$elements_manager->add_category(
			'visualize-widgets',
			[
				'title' => __( 'Visualize Widgets', 'visualize' ),
				'icon' => 'fa fa-plug',
			]
		);
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_widgets() {
		// Register Widgets
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new VisualizeCarousel() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new VisualizeLoop() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new VisualizeButton() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new VisualizeIconListAndNavbar() );
	}

	/**
	 * load widgets template
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_widgets_template_load(){
		new VisualizeCarouselTemplate();
		new VisualizeButtonTemplate();
		new VisualizeIconListAndNavbarTemplate();
	}

	

	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		// register widget template
		add_action('init', [$this, 'register_widgets_template_load']);
		// Register widget scripts
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
		// Register Categories
		add_action( 'elementor/elements/categories_registered', [ $this, 'register_categories' ] );
		// Register widgets
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
	}
}