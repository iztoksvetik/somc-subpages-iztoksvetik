<?php
/**
 * Plugin Name: SOMC Subpages Iztok Svetik
 * Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
 * Description: Displays all subpages of the page the plugin is shown on in an orderable tree structure
 * Version: 1.0
 * Author: Iztok Svetik
 * Author URI: https://github.com/iztoksvetik
 * Text Domain: somc-subpages-iztoksvetik
 * License: GPL2
 *
 * Copyright 2014  Iztok Svetik  (email : iztok@isd.si)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as 
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
**/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/
require_once( plugin_dir_path( __FILE__ ) . 'public/class-somc-subpages-iztoksvetik-controller.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-somc-subpages-iztoksvetik.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-somc-subpages-iztoksvetik-widget.php' );

add_action('plugins_loaded', array('SomcSubpagesIztokSvetik', 'getInstance'));

add_action( 'widgets_init', create_function( '', 'register_widget("SomcSubpagesIztokSvetikWidget");' ) );


