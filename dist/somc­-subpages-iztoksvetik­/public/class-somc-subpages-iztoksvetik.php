<?php
/**
 * Subpages plugin
 *
 * @package   Somc_Subpages
 * @author    Iztok Svetik <iztok@isd.si>
 * @license   GPL-2.0+
 * @link      http://www.isd.si
 * @copyright 2014 Iztok Svetik
 */

/**
 * Base class of Subpages plugin that handles the public facing functionalities
 *
 * @package default
 * @author 
 **/
class SomcSubpagesIztokSvetik 
{
	/**
	 * Plugin version
	 *
	 * @var string
	 **/
	const VERSION = '1.0.0';

	/**
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'somc-subpages-iztoksvetik';

	/**
	 * Instance of this class.
	 *
	 * @var      object
	 */
	protected static $instance = null;

	private $childen;
	private $pages;

	/**
	 * Initialize the plugin
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		// Construct the view on shortcode call
		add_shortcode( 'somc-subpages-iztoksvetik', array($this, 'shortcode'));
	}

	public function shortcode() {
		if ($id = get_the_id()) {
			$controller = new SomcSubpagesIztokSvetikController($id);
			return $controller->display();
		}
	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'assets/css/public.css', __FILE__ ), array(), self::VERSION );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'assets/js/public.js', __FILE__ ), array( 'jquery' ), self::VERSION );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function getInstance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}


} // END class SomcSubpagesIztokSvetik 