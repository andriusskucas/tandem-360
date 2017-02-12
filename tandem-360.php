<?php
/**
 * Plugin Name: 360 objektų galerijos
 * Plugin URI: http://tandem-studio.lt
 * Description: Įskiepis skirtas 360 objektų galerijoms įdėti į puslapį
 * Version: 1.0.0
 * Author: Andrius S
 * Author URI: http://tandem-studio.lt
 * License: GPL2
 */

define('TANDEM360',plugins_url('',__FILE__));

// Creating tandem 360 custom post type
function tandem_360() {

	register_post_type( 'tandem_360',

		array('labels' => array(
                'name' => __('360 objektai', 'tandem'),
                'singular_name' => __('Objektas', 'tandem'),
                'all_items' => __('Visi objektai', 'tandem'),
                'add_new' => __('Pridėti naują', 'tandem'),
                'add_new_item' => __('Pridėti naują', 'tandem'),
                'edit' => __( 'Redaguoti', 'tandem' ),
                'edit_item' => __('Radaguoti', 'tandem'),
                'new_item' => __('Naujas objektas', 'tandem'),
                'view_item' => __('Rodyti objektą', 'tandem'),
                'search_items' => __('Ieškoti objekto', 'tandem'),
                'not_found' =>  __('Nieko nerasta.', 'tandem'),
                'not_found_in_trash' => __('Šiukšlinėje nieko nerasta', 'tandem'),
                'parent_item_colon' => ''
			),
			'description' => __( '360 objektai', 'jointswp' ),
			'public' => true,
			'publicly_queryable' => false,
			'exclude_from_search' => true,
			'show_ui' => true,
			'query_var' => false,
			'menu_position' => 60,
			'menu_icon' => 'dashicons-update',
			'rewrite'	=> array( 'slug' => 'tandem-360', 'with_front' => false ),
			'has_archive' => false,
			'capability_type' => 'post',
			'hierarchical' => false,
			'supports' => array( 'title'),
            'register_meta_box_cb' => 'add_tandem_360_metaboxes'
	 	)
	); /* end of register post type */
}
// Calling custom post type create action
add_action( 'init', 'tandem_360');

// Declaring main functions for tandem 360 plugin (display_tandem_360_object ...)
require_once('includes/functions.php');

// Adding custom columns in objects list in backend
require_once('includes/custom-columns.php');

// Adding custom metaboxes for tandem 360 objects
require_once('includes/custom-metaboxes.php');

// Adding wordpress shortcode support for the plugin
require_once('includes/shortcode.php');


// Adding custom JS and CSS for plugins frontend and back end
require_once('includes/enquene-scripts.php');
