<?php
if ( ! function_exists( 'thfo_intranet' ) ) {

// Register Custom Post Type
	function thfo_intranet() {

		$labels       = array(
			'name'                  => _x( 'Intranets', 'Post Type General Name', 'thfo-intranet' ),
			'singular_name'         => _x( 'Intranet', 'Post Type Singular Name', 'thfo-intranet' ),
			'menu_name'             => __( 'Intranet', 'thfo-intranet' ),
			'name_admin_bar'        => __( 'Intranet', 'thfo-intranet' ),
			'archives'              => __( 'Item Archives', 'thfo-intranet' ),
			'attributes'            => __( 'Item Attributes', 'thfo-intranet' ),
			'parent_item_colon'     => __( 'Parent Item:', 'thfo-intranet' ),
			'all_items'             => __( 'All Items', 'thfo-intranet' ),
			'add_new_item'          => __( 'Add New Item', 'thfo-intranet' ),
			'add_new'               => __( 'Add New', 'thfo-intranet' ),
			'new_item'              => __( 'New Item', 'thfo-intranet' ),
			'edit_item'             => __( 'Edit Item', 'thfo-intranet' ),
			'update_item'           => __( 'Update Item', 'thfo-intranet' ),
			'view_item'             => __( 'View Item', 'thfo-intranet' ),
			'view_items'            => __( 'View Items', 'thfo-intranet' ),
			'search_items'          => __( 'Search Item', 'thfo-intranet' ),
			'not_found'             => __( 'Not found', 'thfo-intranet' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'thfo-intranet' ),
			'featured_image'        => __( 'Featured Image', 'thfo-intranet' ),
			'set_featured_image'    => __( 'Set featured image', 'thfo-intranet' ),
			'remove_featured_image' => __( 'Remove featured image', 'thfo-intranet' ),
			'use_featured_image'    => __( 'Use as featured image', 'thfo-intranet' ),
			'insert_into_item'      => __( 'Insert into item', 'thfo-intranet' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'thfo-intranet' ),
			'items_list'            => __( 'Items list', 'thfo-intranet' ),
			'items_list_navigation' => __( 'Items list navigation', 'thfo-intranet' ),
			'filter_items_list'     => __( 'Filter items list', 'thfo-intranet' ),
		);
		$capabilities = array(
			'edit_post'              => 'edit_intranet',
			'read_post'              => 'read_intranet',
			'delete_post'            => 'delete_intranet',
			'edit_posts'             => 'edit_intranets',
			'edit_others_posts'      => 'edit_others_intranets',
			'read_others_posts'      => 'read_others_intranets',
			'publish_posts'          => 'publish_intranets',
			'publish_pages'          => 'publish_pages_intranets',
			'read_private_posts'     => 'read_private_intranets',
			'create_posts'           => 'create_private_intranets',
			'edit_published_posts'   => 'edit_published_intranets',
			'delete_published_posts' => 'delete_published_intranets',
			'delete_others_posts'    => 'delete_others_intranets',
			'edit_private_posts'     => 'edit_private_intranets',
			'delete_private_posts'   => 'delete_private_intranets',
		);
		$args         = array(
			'label'               => __( 'Intranet', 'thfo-intranet' ),
			'description'         => __( 'Intranet', 'thfo-intranet' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'comments', 'revisions', 'custom-fields' ),
			'hierarchical'        => true,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-privacy',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'capabilities'        => $capabilities,
		);
		register_post_type( 'intranet', $args );

	}

	add_action( 'init', 'thfo_intranet', 0 );

}