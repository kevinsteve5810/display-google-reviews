<?php
// Register Custom Post Type
function google_reviews_display_func() {

	$labels = array(
		'name'                  => _x( 'Google Reviews Display', 'Post Type General Name', 'google_reviews_display' ),
		'singular_name'         => _x( 'Google Reviews Display', 'Post Type Singular Name', 'google_reviews_display' ),
		'menu_name'             => __( 'Google Reviews Display', 'google_reviews_display' ),
		'name_admin_bar'        => __( 'Google Reviews Display', 'google_reviews_display' ),
		'archives'              => __( 'Item Archives', 'google_reviews_display' ),
		'attributes'            => __( 'Item Attributes', 'google_reviews_display' ),
		'parent_item_colon'     => __( 'Parent Item:', 'google_reviews_display' ),
		'all_items'             => __( 'All Items', 'google_reviews_display' ),
		'add_new_item'          => __( 'Add New Item', 'google_reviews_display' ),
		'add_new'               => __( 'Add New', 'google_reviews_display' ),
		'new_item'              => __( 'New Item', 'google_reviews_display' ),
		'edit_item'             => __( 'Edit Item', 'google_reviews_display' ),
		'update_item'           => __( 'Update Item', 'google_reviews_display' ),
		'view_item'             => __( 'View Item', 'google_reviews_display' ),
		'view_items'            => __( 'View Items', 'google_reviews_display' ),
		'search_items'          => __( 'Search Item', 'google_reviews_display' ),
		'not_found'             => __( 'Not found', 'google_reviews_display' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'google_reviews_display' ),
		'featured_image'        => __( 'Featured Image', 'google_reviews_display' ),
		'set_featured_image'    => __( 'Set featured image', 'google_reviews_display' ),
		'remove_featured_image' => __( 'Remove featured image', 'google_reviews_display' ),
		'use_featured_image'    => __( 'Use as featured image', 'google_reviews_display' ),
		'insert_into_item'      => __( 'Insert into item', 'google_reviews_display' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'google_reviews_display' ),
		'items_list'            => __( 'Items list', 'google_reviews_display' ),
		'items_list_navigation' => __( 'Items list navigation', 'google_reviews_display' ),
		'filter_items_list'     => __( 'Filter items list', 'google_reviews_display' ),
	);
	$args = array(
		'label'                 => __( 'Google Reviews Display', 'google_reviews_display' ),
		'description'           => __( 'Display the google reviews', 'google_reviews_display' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'greviews_display', $args );

}
add_action( 'init', 'google_reviews_display_func', 0 );