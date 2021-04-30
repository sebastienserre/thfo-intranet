<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly.

if ( ! function_exists( 'intranet_cat' ) ) {

// Register Custom Taxonomy
	function intranet_cat() {

		$labels       = array(
			'name'                       => _x( 'Categories', 'Taxonomy General Name', 'thfo-intranet' ),
			'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'thfo-intranet' ),
			'menu_name'                  => __( 'Categories', 'thfo-intranet' ),
			'all_items'                  => __( 'All Items', 'thfo-intranet' ),
			'parent_item'                => __( 'Parent Item', 'thfo-intranet' ),
			'parent_item_colon'          => __( 'Parent Item:', 'thfo-intranet' ),
			'new_item_name'              => __( 'New Item Name', 'thfo-intranet' ),
			'add_new_item'               => __( 'Add New Item', 'thfo-intranet' ),
			'edit_item'                  => __( 'Edit Item', 'thfo-intranet' ),
			'update_item'                => __( 'Update Item', 'thfo-intranet' ),
			'view_item'                  => __( 'View Item', 'thfo-intranet' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'thfo-intranet' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'thfo-intranet' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'thfo-intranet' ),
			'popular_items'              => __( 'Popular Items', 'thfo-intranet' ),
			'search_items'               => __( 'Search Items', 'thfo-intranet' ),
			'not_found'                  => __( 'Not Found', 'thfo-intranet' ),
			'no_terms'                   => __( 'No items', 'thfo-intranet' ),
			'items_list'                 => __( 'Items list', 'thfo-intranet' ),
			'items_list_navigation'      => __( 'Items list navigation', 'thfo-intranet' ),
		);
		$capabilities = array(
			'manage_terms' => 'manage_intranet_cat',
			'edit_terms'   => 'edit_intranet_cat',
			'delete_terms' => 'delete_intranet_cat',
			'assign_terms' => 'edit_intranet',
		);
		$args         = array(
			'labels'            => $labels,
			'hierarchical'      => false,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
			'capabilities'      => $capabilities,
		);
		register_taxonomy( 'intranet_cat', array( 'intranet' ), $args );

	}

	add_action( 'init', 'intranet_cat', 0 );

}