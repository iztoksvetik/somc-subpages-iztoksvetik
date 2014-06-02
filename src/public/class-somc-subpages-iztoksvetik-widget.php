<?php
/**
 * Subpages Widget plugin
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
class SomcSubpagesIztokSvetikWidget extends WP_Widget
{
	protected $widget_slug = 'somc-subpages-iztoksvetik';

	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/

	/**
	 * Specifies the classname and description, instantiates the widget,
	 * loads localization files, and includes necessary stylesheets and JavaScript.
	 */
	public function __construct() {

		// load plugin text domain
		add_action( 'init', array( $this, 'widget_textdomain' ) );

		// TODO: update description
		parent::__construct(
			$this->get_widget_slug(),
			__( 'Subpages widget', $this->get_widget_slug() ),
			array(
				'classname'  => $this->get_widget_slug().'-class',
				'description' => __( 'Adds subpages of the page its displayed on.', $this->get_widget_slug() )
			)
		);

	} // end constructor

	public function widget( $args, $instance ) {
		if ($id = get_the_id()) {
			$controller = new SomcSubpagesIztokSvetikController($id);
			$content = '<aside id="%s" class="widget"><h3 class="widget-title">%s</h3>%s</aside>';
			echo sprintf($content, $this->widget_slug, $instance['title'], $controller->display());
		}
	}

	/**
	 * Generates the administration form for the widget.
	 *
	 * @param array instance The array of keys and values for the widget.
	 */
	public function form( $instance ) {

		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Subpages', $this->widget_slug);
		}

		// TODO: Store the values of the widget in their own variable

		// Display the admin form
		include( plugin_dir_path(__FILE__) . 'views/admin.php' );

	} // end form

	/**
	 * Processes the widget's options to be saved.
	 *
	 * @param array new_instance The new instance of values to be generated via the update.
	 * @param array old_instance The previous instance of values before the update.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;

	} // end widget

	/**
     * Return the widget slug.
     *
     * @return    Plugin slug variable.
     */
    public function get_widget_slug() {
        return $this->widget_slug;
    }

    /**
	 * Loads the Widget's text domain for localization and translation.
	 */
    public function widget_textdomain() {
		load_plugin_textdomain( $this->get_widget_slug(), false, plugin_dir_path( __FILE__ ) . 'lang/' );

	} // end widget_textdomain

} // END class SomcSubpagesIztokSvetikWidget