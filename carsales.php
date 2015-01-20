<?php
/*
Plugin Name: Wordpress Car Sales
Plugin URI: https://github.com/italiafirenze/wordpress-car-sales
Description: Adds custom post types and taxonomies for car sales. Does not integrate them into the theme.
Version: 0.6
Author: Craig Cooper
Author Email: craig@plgrm.co
License: http://www.gnu.org/licenses/gpl-3.0.html

  Copyright 2011 Craig Cooper (craig@plgrm.co)

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
  
  http://www.gnu.org/licenses/gpl-3.0.html

*/

// Require Smart Meta box generator
require_once "smartmeta.php";

class CarSales {

	/*--------------------------------------------*
	 * Constants
	 *--------------------------------------------*/
	const name = 'Car Sales';
	const slug = 'carsales';

	/**
	 * Constructor
	 */
	function __construct() {
		//register an activation hook for the plugin
		register_activation_hook( __FILE__, array( &$this, 'install_carsales' ) );

		//Hook up to the init action
		add_action( 'init', array( &$this, 'init_carsales' ) );
	}

	/**
	 * Runs when the plugin is activated
	 */
	function install_carsales() {
		// do not generate any output here
	}

	/**
	 * Runs when the plugin is initialized
	 */
	function init_carsales() {
		// Load JavaScript and stylesheets
		$this->register_scripts_and_styles();


		if ( is_admin() ) {
			//this will run when in the WordPress admin
		} else {
			//this will run when on the frontend
		}

		/*
		 * TODO: Define custom functionality for your plugin here
		 *
		 * For more information:
		 * http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */
		add_action( 'your_action_here', array( &$this, 'action_callback_method_name' ) );
		add_filter( 'your_filter_here', array( &$this, 'filter_callback_method_name' ) );
	}

	function action_callback_method_name() {
		// TODO define your action method here
	}

	function filter_callback_method_name() {
		// TODO define your filter method here
	}

	/**
	 * Registers and enqueues stylesheets for the administration panel and the
	 * public facing site.
	 */
	private function register_scripts_and_styles() {
		if ( is_admin() ) {

		} else {

		} // end if/else
	} // end register_scripts_and_styles

	/**
	 * Helper function for registering and enqueueing scripts and styles.
	 *
	 * @name	The 	ID to register with WordPress
	 * @file_path		The path to the actual file
	 * @is_script		Optional argument for if the incoming file_path is a JavaScript source file.
	 */
	private function load_file( $name, $file_path, $is_script = false ) {

		$url = plugins_url($file_path, __FILE__);
		$file = plugin_dir_path(__FILE__) . $file_path;

		if( file_exists( $file ) ) {
			if( $is_script ) {
				wp_register_script( $name, $url, array('jquery') ); //depends on jquery
				wp_enqueue_script( $name );
			} else {
				wp_register_style( $name, $url );
				wp_enqueue_style( $name );
			} // end if
		} // end if

	} // end load_file

} // end class
new CarSales();

// Begin Plugin Functionality

// Register Car Custom Post Type

add_action( 'init', 'register_cpt_car' );

function register_cpt_car() {

    $labels = array(
        'name' => _x( 'Cars', 'car' ),
        'singular_name' => _x( 'car', 'car' ),
        'add_new' => _x( 'Add New', 'car' ),
        'add_new_item' => _x( 'Add New Car', 'car' ),
        'edit_item' => _x( 'Edit car', 'car' ),
        'new_item' => _x( 'New car', 'car' ),
        'view_item' => _x( 'View car', 'car' ),
        'search_items' => _x( 'Search Cars', 'car' ),
        'not_found' => _x( 'No cars found', 'car' ),
        'not_found_in_trash' => _x( 'No cars found in Trash', 'car' ),
        'parent_item_colon' => _x( 'Parent car:', 'car' ),
        'menu_name' => _x( 'Cars', 'car' ),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => false,

        'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'tags', 'author', 'publicize' ),
        'taxonomies' => array( 'fuel', 'gearbox', 'makemodel', 'plateyear', 'taxclass', 'listingfeatures', 'listingtypes', 'post_tag' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 4,

        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => array( 'slug' => 'used-cars', 'with_front' => TRUE),
        'capability_type' => 'post'
    );

    register_post_type( 'car', $args );
}

// Add Fuel Taxonomy

add_action( 'init', 'register_taxonomy_fuel' );

function register_taxonomy_fuel() {

    $labels = array(
        'name' => _x( 'Fuels', 'fuel' ),
        'singular_name' => _x( 'Fuel', 'fuel' ),
        'search_items' => _x( 'Search Fuels', 'fuel' ),
        'popular_items' => _x( 'Popular Fuels', 'fuel' ),
        'all_items' => _x( 'All Fuels', 'fuel' ),
        'parent_item' => _x( 'Parent Fuel', 'fuel' ),
        'parent_item_colon' => _x( 'Parent Fuel:', 'fuel' ),
        'edit_item' => _x( 'Edit Fuel', 'fuel' ),
        'update_item' => _x( 'Update Fuel', 'fuel' ),
        'add_new_item' => _x( 'Add New Fuel', 'fuel' ),
        'new_item_name' => _x( 'New Fuel', 'fuel' ),
        'separate_items_with_commas' => _x( 'Separate fuels with commas', 'fuel' ),
        'add_or_remove_items' => _x( 'Add or remove Fuels', 'fuel' ),
        'choose_from_most_used' => _x( 'Choose from most used Fuels', 'fuel' ),
        'menu_name' => _x( 'Fuels', 'fuel' ),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => true,
        'hierarchical' => false,

        'rewrite' => array( 'slug' => 'fuel'),
        'query_var' => true
    );

    register_taxonomy( 'fuel', array('car'), $args );
}

// Add Gearbox Taxonomy

add_action( 'init', 'register_taxonomy_gearbox' );

function register_taxonomy_gearbox() {

    $labels = array(
        'name' => _x( 'Gearboxes', 'gearbox' ),
        'singular_name' => _x( 'Gearbox', 'gearbox' ),
        'search_items' => _x( 'Search Gearboxes', 'gearbox' ),
        'popular_items' => _x( 'Popular Gearboxes', 'gearbox' ),
        'all_items' => _x( 'All Gearboxes', 'gearbox' ),
        'parent_item' => _x( 'Parent Gearbox', 'gearbox' ),
        'parent_item_colon' => _x( 'Parent Gearbox:', 'gearbox' ),
        'edit_item' => _x( 'Edit Gearbox', 'gearbox' ),
        'update_item' => _x( 'Update Gearbox', 'gearbox' ),
        'add_new_item' => _x( 'Add New Gearbox', 'gearbox' ),
        'new_item_name' => _x( 'New Gearbox', 'gearbox' ),
        'separate_items_with_commas' => _x( 'Separate gearboxes with commas', 'gearbox' ),
        'add_or_remove_items' => _x( 'Add or remove gearboxes', 'gearbox' ),
        'choose_from_most_used' => _x( 'Choose from the most used gearboxes', 'gearbox' ),
        'menu_name' => _x( 'Gearboxes', 'gearbox' ),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => false,
        'hierarchical' => true,

        'rewrite' => array( 'slug' => 'gearbox'),
        'query_var' => true
    );

    register_taxonomy( 'gearbox', array('car'), $args );
}

// Add Tax Class Taxonomy

add_action( 'init', 'register_taxonomy_taxclass' );

function register_taxonomy_taxclass() {

    $labels = array(
        'name' => _x( 'Tax Classes', 'taxclass' ),
        'singular_name' => _x( 'Tax Class', 'taxclass' ),
        'search_items' => _x( 'Search Tax Classes', 'taxclass' ),
        'popular_items' => _x( 'Popular Tax Classes', 'taxclass' ),
        'all_items' => _x( 'All Tax Classes', 'taxclass' ),
        'parent_item' => _x( 'Parent Tax Class', 'taxclass' ),
        'parent_item_colon' => _x( 'Parent Tax Class:', 'taxclass' ),
        'edit_item' => _x( 'Edit Tax Class', 'taxclass' ),
        'update_item' => _x( 'Update Tax Class', 'taxclass' ),
        'add_new_item' => _x( 'Add New Tax Class', 'taxclass' ),
        'new_item_name' => _x( 'New Tax Class', 'taxclass' ),
        'separate_items_with_commas' => _x( 'Separate tax classes with commas', 'taxclass' ),
        'add_or_remove_items' => _x( 'Add or remove Tax Classes', 'taxclass' ),
        'choose_from_most_used' => _x( 'Choose from most used Tax Classes', 'taxclass' ),
        'menu_name' => _x( 'Tax Classes', 'taxclass' ),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => false,
        'hierarchical' => false,

        'rewrite' => true,
        'query_var' => true
    );

    register_taxonomy( 'taxclass', array('car'), $args );
}

// Add Features taxonomy

add_action( 'init', 'register_taxonomy_listingfeatures' );

function register_taxonomy_listingfeatures() {

    $labels = array(
        'name' => _x( 'Features', 'listingfeatures' ),
        'singular_name' => _x( 'Feature', 'listingfeatures' ),
        'search_items' => _x( 'Search Features', 'listingfeatures' ),
        'popular_items' => _x( 'Popular Features', 'listingfeatures' ),
        'all_items' => _x( 'All Features', 'listingfeatures' ),
        'parent_item' => _x( 'Parent Feature', 'listingfeatures' ),
        'parent_item_colon' => _x( 'Parent Feature:', 'listingfeatures' ),
        'edit_item' => _x( 'Edit Feature', 'listingfeatures' ),
        'update_item' => _x( 'Update Feature', 'listingfeatures' ),
        'add_new_item' => _x( 'Add New Feature', 'listingfeatures' ),
        'new_item_name' => _x( 'New Feature', 'listingfeatures' ),
        'separate_items_with_commas' => _x( 'Separate features with commas', 'listingfeatures' ),
        'add_or_remove_items' => _x( 'Add or remove features', 'listingfeatures' ),
        'choose_from_most_used' => _x( 'Choose from the most used features', 'listingfeatures' ),
        'menu_name' => _x( 'Features', 'listingfeatures' ),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => false,
        'hierarchical' => true,

        'rewrite' => array( 'slug' => 'feature'),
        'query_var' => true
    );

    register_taxonomy( 'listingfeatures', array('car'), $args );
}

// Add Listing Type Taxonomy

add_action( 'init', 'register_taxonomy_listingtype' );

function register_taxonomy_listingtype() {

    $labels = array(
        'name' => _x( 'Listing Types', 'listingtype' ),
        'singular_name' => _x( 'Listing Type', 'listingtype' ),
        'search_items' => _x( 'Search Listing Types', 'listingtype' ),
        'popular_items' => _x( 'Popular Listing Types', 'listingtype' ),
        'all_items' => _x( 'All Listing Types', 'listingtype' ),
        'parent_item' => _x( 'Parent Listing Type', 'listingtype' ),
        'parent_item_colon' => _x( 'Parent Listing Type:', 'listingtype' ),
        'edit_item' => _x( 'Edit Listing Type', 'listingtype' ),
        'update_item' => _x( 'Update Listing Type', 'listingtype' ),
        'add_new_item' => _x( 'Add New Listing Type', 'listingtype' ),
        'new_item_name' => _x( 'New Listing Type', 'listingtype' ),
        'separate_items_with_commas' => _x( 'Separate listing types with commas', 'listingtype' ),
        'add_or_remove_items' => _x( 'Add or remove listing types', 'listingtype' ),
        'choose_from_most_used' => _x( 'Choose from the most used listing types', 'listingtype' ),
        'menu_name' => _x( 'Listing Types', 'listingtype' ),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => false,
        'hierarchical' => true,

        'rewrite' => array( 'slug' => 'type'),
        'query_var' => true
    );

    register_taxonomy( 'listingtype', array('car'), $args );
}

// Add Make and Model Taxonomy

add_action( 'init', 'register_taxonomy_makemodel' );

function register_taxonomy_makemodel() {

    $labels = array(
        'name' => _x( 'Models', 'makemodel' ),
        'singular_name' => _x( 'Model', 'makemodel' ),
        'search_items' => _x( 'Search Models', 'makemodel' ),
        'popular_items' => _x( 'Popular Models', 'makemodel' ),
        'all_items' => _x( 'All Models', 'makemodel' ),
        'parent_item' => _x( 'Parent Model', 'makemodel' ),
        'parent_item_colon' => _x( 'Parent Model:', 'makemodel' ),
        'edit_item' => _x( 'Edit Model', 'makemodel' ),
        'update_item' => _x( 'Update Model', 'makemodel' ),
        'add_new_item' => _x( 'Add New Model', 'makemodel' ),
        'new_item_name' => _x( 'New Model', 'makemodel' ),
        'separate_items_with_commas' => _x( 'Separate models with commas', 'makemodel' ),
        'add_or_remove_items' => _x( 'Add or remove models', 'makemodel' ),
        'choose_from_most_used' => _x( 'Choose from the most used models', 'makemodel' ),
        'menu_name' => _x( 'Models', 'makemodel' ),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => false,
        'hierarchical' => true,
        'rewrite' => array('hierarchical' => true, 'slug' => 'make'),
        'query_var' => true
    );

    register_taxonomy( 'makemodel', array('car'), $args );
}

// Add Years and Plates Taxonomy

add_action( 'init', 'register_taxonomy_plateyear' );

function register_taxonomy_plateyear() {

    $labels = array(
        'name' => _x( 'Plates', 'plateyear' ),
        'singular_name' => _x( 'Plate', 'plateyear' ),
        'search_items' => _x( 'Search Plates', 'plateyear' ),
        'popular_items' => _x( 'Popular Plates', 'plateyear' ),
        'all_items' => _x( 'All Plates', 'plateyear' ),
        'parent_item' => _x( 'Parent Plate', 'plateyear' ),
        'parent_item_colon' => _x( 'Parent Plate:', 'plateyear' ),
        'edit_item' => _x( 'Edit Plate', 'plateyear' ),
        'update_item' => _x( 'Update Plate', 'plateyear' ),
        'add_new_item' => _x( 'Add New Plate', 'plateyear' ),
        'new_item_name' => _x( 'New Plate', 'plateyear' ),
        'separate_items_with_commas' => _x( 'Separate plates with commas', 'plateyear' ),
        'add_or_remove_items' => _x( 'Add or remove plates', 'plateyear' ),
        'choose_from_most_used' => _x( 'Choose from the most used plates', 'plateyear' ),
        'menu_name' => _x( 'Plates', 'plateyear' ),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => false,
        'hierarchical' => true,

        'rewrite' => array( 'slug' => 'year'),
        'query_var' => true
    );

    register_taxonomy( 'plateyear', array('car'), $args );
}


add_smart_meta_box('car_details_meta', array(
	'title'     => 'Car Details',
	'pages'		=> array('car'),
	'context'   => 'normal',
	'priority'  => 'high',
	'fields'    => array(
		array(
			'name' => 'Availability',
			'id' => 'wcs_availability',
			'default' => '',
			'desc' => 'Is the car available or not?',
			'type'=> 'select',
			'options' => array(
			'available' => 'In Stock',
			'soon' => 'Coming Soon',
			'sold' => 'Sold',
			)
		),
		array(
			'name' => 'Registration',
			'id' => 'wcs_vrm',
			'default' => '',
			'desc' => 'Enter the full vehicle reg',
			'type' => 'text',
		),
		array(
			'name' => 'Mileage',
			'id' => 'wcs_mileage',
			'default' => '',
			'desc' => 'Enter the exact mileage, include a comma',
			'type' => 'text',
		),
		array(
			'name' => 'Price',
			'id' => 'wcs_price',
			'default' => '',
			'desc' => 'Enter the price including currency symbol',
			'type' => 'text',
		),
		array(
			'name' => 'Colour',
			'id' => 'wcs_colour',
			'default' => '',
			'desc' => 'The exterior colour',
			'type' => 'text',
		),
		array(
			'name' => 'Interior Colour',
			'id' => 'wcs_interior',
			'default' => '',
			'desc' => 'The interior colour and type e.g. Black Leather',
			'type' => 'text',
		),
		array(
			'name' => 'Engine Size',
			'id' => 'wcs_enginesize',
			'default' => '',
			'desc' => 'Exact CC from the logbook, add cc to the end.',
			'type' => 'text',
		),
		array(
			'name' => 'CO2 Emissions',
			'id' => 'wcs_emissions',
			'default' => '',
			'desc' => 'Exact CO2 g/km from V5',
			'type' => 'text',
		),
		array(
			'name' => 'Engine Power Output',
			'id' => 'wcs_power',
			'default' => '',
			'desc' => 'Power Output of Engine',
			'type' => 'text',
		),
		array(
			'name' => 'Drivetrain',
			'id' => 'wcs_drivetrain',
			'default' => 'first-val',
			'desc' => 'Front, Rear or Four Wheel Drive.',
			'type' => 'select',
			'options' => array(
				'fwd' => 'Front Wheel Drive',
				'rwd' => 'Rear Wheel Drive',
				'4wd' => 'Four Wheel Drive',
			)
		),

	)
));

	add_smart_meta_box('economy_meta_box', array(
		'title'     => 'Economy Details',
		'pages'		=> array('car'),
		'context'   => 'normal',
		'priority'  => 'high',
		'fields'    => array(
			array(
				'name' => 'Combined MPG',
				'id' => 'wcs_combinedmpg',
				'default' => '',
				'desc' => 'Enter the MPG from the combined cycle.',
				'type' => 'text',
			),
			array(
				'name' => 'Urban MPG',
				'id' => 'wcs_urbanmpg',
				'default' => '',
				'desc' => 'Enter the MPG from the urban cycle.',
				'type' => 'text',
			),
			array(
				'name' => 'Extra Urban MPG',
				'id' => 'wcs_extraurbanmpg',
				'default' => '',
				'desc' => 'Enter the MPG from the extra-urban cycle.',
				'type' => 'text',
			),

		)
	));

	add_smart_meta_box('tax_cost_meta_box', array(
		'title'     => 'Tax Cost',
		'pages'		=> array('car'),
		'context'   => 'normal',
		'priority'  => 'high',
		'fields'    => array(
			array(
				'name' => '12 Months Tax Cost',
				'id' => 'wcs_12monthstax',
				'default' => '',
				'desc' => 'Enter the cost of 12 months tax',
				'type' => 'text',
			),
			array(
				'name' => '6 Months Tax Cost',
				'id' => 'wcs_6monthstax',
				'default' => '',
				'desc' => 'Enter the cost of 6 months tax',
				'type' => 'text',
			),

		)
	));

	add_smart_meta_box('readiness_meta_box', array(
		'title'     => 'Readinesss Details',
		'pages'		=> array('car'),
		'context'   => 'normal',
		'priority'  => 'high',
		'fields'    => array(
			array(
				'name' => 'MOT Date',
				'id' => 'wcs_MOTdate',
				'default' => 'None',
				'desc' => 'Enter the date of the MOT',
				'type' => 'text',
			),

		)
	));


// Add to admin_init function
		add_filter('manage_edit-car_columns', 'add_new_car_columns');

		function add_new_car_columns($car_columns) {
		$new_columns['cb'] = '<input type="checkbox" />';
 		$new_columns['title'] = _x('Title', 'column name');
		$new_columns['vrm'] = __('Reg.');
		$new_columns['price'] = __('Price');
		$new_columns['thumbnail'] = __('Thumbnail');

		return $new_columns;
	}

	add_action( 'manage_posts_custom_column', 'fill_columns' );
	function fill_columns($column) {
    global $post;
    switch($column) {
        case 'thumbnail' :
            if (has_post_thumbnail($post->ID))
                echo get_the_post_thumbnail($post->ID, array(50, 50));
            else
                echo '<em>no thumbnail</em>';
		break;

		case 'price' :
                echo get_post_meta($post->ID, 'price', true);
        break;

		case 'vrm' :
                echo get_post_meta($post->ID, 'vrm', true);
        break;
    }
}

// ADD VRM TO PERMALINK

	add_action('init', 'wordpress_car_sales_add_rewrite_rules');
		function wordpress_car_sales_add_rewrite_rules()
{
 
// Register custom rewrite rules
 
	global $wp_rewrite;
		$wp_rewrite->add_rewrite_tag('%car%', '([^/]+)', 'car=');
		$wp_rewrite->add_rewrite_tag('%vrm%', '([^/]+)', 'vrm=');
		$wp_rewrite->add_permastruct('car', '/cars/%car%/%vrm%/', false);
	}
	
	add_filter('post_type_link', 'wordpress_car_sales_permalinks', 10, 3);
	 
	function wordpress_car_sales_permalinks($permalink, $post, $leavename)
 
{
	$no_data = 'no-vrm';	 
	$post_id = $post->ID;	 
	if($post->post_type != 'car' || empty($permalink) || in_array($post->post_status, array('draft', 'pending', 'auto-draft')))
	 
	return $permalink;
	$var1 = get_post_meta($post_id, 'vrm', true);
	$var1 = sanitize_title($var1);
	if(!$var1) { $var1 = $no_data; }
	$permalink = str_replace('%vrm%', $var1, $permalink);	 
	return $permalink; 
}

;?>
