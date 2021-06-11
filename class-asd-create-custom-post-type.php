<?php

/**
 * Create a custom post type for the plugin
 * @link       alexstillwagon.com
 * @since      1.0.0
 * @package    Asd_Photo_Catalog
 * @subpackage Asd_Photo_Catalog/includes
 * @author     Alex Stillwagon <alex@alexstillwagon.com>
 */
class Asd_Create_Custom_Post_Type {

    /**
     * Setup the Custom Post Type
     *
     * @param $fields array
     *
     * @return void
     * @since 1.0
     */
    private function register_post_type( array $fields ): void {

	// Setup Labels for CPT
	$labels = [
	    'name' => _x( $fields[ 'plural' ], 'asd_photo_catalog_i18n' ),
	    'singular_name' => _x( $fields[ 'singular' ], 'asd_photo_catalog_i18n' ),
	    'menu_name' => __( $fields[ 'menu_name' ], 'asd_photo_catalog_i18n' ),
	    'name_admin_bar' => __( $fields[ 'name_admin_bar' ], 'asd_photo_catalog_i18n' ),
	    'archives' => __( $fields[ 'archives' ], 'asd_photo_catalog_i18n' ),
	    'attributes' => __( $fields[ 'archives' ], 'asd_photo_catalog_i18n' ),
	    'all_items' => sprintf( __( 'All %s', 'asd_photo_catalog_i18n' ), $fields[ 'plural' ] ),
	    'view_item' => sprintf( __( 'View %s', 'asd_photo_catalog_i18n' ), $fields[ 'singular' ] ),
	    'view_items' => sprintf( __( 'View %s', 'asd_photo_catalog_i18n' ), $fields[ 'plural' ] ),
	    'add_new_item' => sprintf( __( 'Add new %s', 'asd_photo_catalog_i18n' ), $fields[ 'singular' ] ),
	    'add_new' => sprintf( __( 'New %s', 'asd_photo_catalog_i18n' ), $fields[ 'singular' ] ),
	    'new_item' => sprintf( __( 'New %s', 'asd_photo_catalog_i18n' ), $fields[ 'singular' ] ),
	    'edit_item' => sprintf( __( 'Edit %s', 'asd_photo_catalog_i18n' ), $fields[ 'singular' ] ),
	    'update_item' => sprintf( __( 'Update %s', 'asd_photo_catalog_i18n' ), $fields[ 'singular' ] ),
	    'search_items' => sprintf( __( 'Search %s', 'asd_photo_catalog_i18n' ), $fields[ 'plural' ] ),
	    'not_found' => sprintf( __( 'No %s found', 'asd_photo_catalog_i18n' ), strtolower( $fields[ 'plural' ] ) ),
	    'not_found_in_trash' => sprintf( __( 'No %s found in trash', 'asd_photo_catalog_i18n' ), strtolower( $fields[ 'plural' ] ) ),
	    'featured_image' => __( 'Featured Image', 'asd_photo_catalog_i18n' ),
	    'set_featured_image' => __( 'Set featured image', 'asd_photo_catalog_i18n' ),
	    'remove_featured_image' => __( 'Remove featured image', 'asd_photo_catalog_i18n' ),
	    'use_featured_image' => __( 'Use as featured image', 'asd_photo_catalog_i18n' ),
	    'insert_into_item' => sprintf( __( 'Insert' . ' into %s', 'asd_photo_catalog_i18n' ), strtolower( $fields[ 'singular' ] ) ),
	    'uploaded_to_this_item' => sprintf( __( 'Uploaded to this %s', 'asd_photo_catalog_i18n' ), strtolower( $fields[ 'singular' ] ) ),
	    'items_list' => __( $fields[ 'singular' ] . ' list', 'asd_photo_catalog_i18n' ),
	    'items_list_navigation' => __( $fields[ 'plural' ] . ' list navigation', 'asd_photo_catalog_i18n' ),
	    'filter_items_list' => sprintf( __( 'Filter %s', 'asd_photo_catalog_i18n' ), $fields[ 'plural' ] ),

	    /* Labels for hierarchical post types only. */
	    'parent_item' => sprintf( __( 'Parent %s', 'asd_photo_catalog_i18n' ), $fields[ 'singular' ] ),
	    'parent_item_colon' => sprintf( __( 'Parent %s:', 'asd_photo_catalog_i18n' ), $fields[ 'singular' ] ),

	    /* Custom archive label.  Must filter 'post_type_archive_title' to use. */
	    'archive_title' => $fields[ 'plural' ],
	];

	// Setup CPT Properties
	$args = array (
	    'label' => _x( $fields[ 'singular' ], 'asd_photo_catalog_i18n' ),
	    'labels' => $labels,
	    // ( isset( $fields[ 'description' ] ) ) ? $fields[ 'description' ] : '' ,
	    'description' => $fields[ 'description' ] ?? '',
	    'public' => $fields[ 'public' ] ?? true,
	    'publicly_queryable' => $fields[ 'publicly_queryable' ] ?? true,
	    'exclude_from_search' => $fields[ 'exclude_from_search' ] ?? false,
	    'show_ui' => $fields[ 'show_ui' ] ?? true,
	    'show_in_menu' => $fields[ 'show_in_menu' ] ?? true,
	    'query_var' => $fields[ 'query_var' ] ?? true,
	    'show_in_admin_bar' => $fields[ 'show_in_admin_bar' ] ?? true,
	    'capability_type' => $fields[ 'capability_type' ] ?? 'post',
	    'has_archive' => $fields[ 'has_archive' ] ?? true,
	    'hierarchical' => $fields[ 'hierarchical' ] ?? true,
	    'menu_position' => $fields[ 'menu_position' ] ?? 5,
	    'menu_icon' => $fields[ 'menu_icon' ] ?? 'dashicons-admin-generic',
	    'show_in_nav_menus' => $fields[ 'show_in_nav_menus' ] ?? true,
	    'show_in_rest' => $fields[ 'show_in_rest' ] ?? true,
	    'taxonomies' => array ( 'asd_photo_catalog_category' ),
	    'can_export' => false,
	);

	// If Rewrite is set
	if ( isset( $fields[ 'rewrite' ] ) ) {
	    /**
	     *  Add $this->plugin_name as translatable in the permalink structure,
	     *  to avoid conflicts with other plugins which may use customers as well.
	     */
	    $args[ 'rewrite' ] = $fields[ 'rewrite' ];
	}

	//
	if ( $fields[ 'custom_caps' ] ) {

	    /**
	     * Provides more precise control over the capabilities than the defaults.  By default, WordPress
	     * will use the 'capability_type' argument to build these capabilities.  More often than not,
	     * this results in many extra capabilities that you probably don't need.  The following is how
	     * I set up capabilities for many post types, which only uses three basic capabilities you need
	     * to assign to roles: 'manage_examples', 'edit_examples', 'create_examples'.  Each post type
	     * is unique though, so you'll want to adjust it to fit your needs.
	     * @link https://gist.github.com/creativembers/6577149
	     * @link http://justintadlock.com/archives/2010/07/10/meta-capabilities-for-custom-post-types
	     */
	    $args[ 'capabilities' ] = array (
		// Meta capabilities
		'edit_post' => 'edit_' . strtolower( $fields[ 'singular' ] ),
		'read_post' => 'read_' . strtolower( $fields[ 'singular' ] ),
		'delete_post' => 'delete_' . strtolower( $fields[ 'singular' ] ),
		// Primitive capabilities used outside of map_meta_cap():
		'edit_posts' => 'edit_' . strtolower( $fields[ 'plural' ] ),
		'edit_others_posts' => 'edit_others_' . strtolower( $fields[ 'plural' ] ),
		'publish_posts' => 'publish_' . strtolower( $fields[ 'plural' ] ),
		'read_private_posts' => 'read_private_' . strtolower( $fields[ 'plural' ] ),
		// Primitive capabilities used within map_meta_cap():
		'delete_posts' => 'delete_' . strtolower( $fields[ 'plural' ] ),
		'delete_private_posts' => 'delete_private_' . strtolower( $fields[ 'plural' ] ),
		'delete_published_posts' => 'delete_published_' . strtolower( $fields[ 'plural' ] ),
		'delete_others_posts' => 'delete_others_' . strtolower( $fields[ 'plural' ] ),
		'edit_private_posts' => 'edit_private_' . strtolower( $fields[ 'plural' ] ),
		'edit_published_posts' => 'edit_published_' . strtolower( $fields[ 'plural' ] ),
		'create_posts' => 'edit_' . strtolower( $fields[ 'plural' ] ),
		//
	    );

	    /**
	     * Adding map_meta_cap will map the meta correctly.
	     * @link https://wordpress.stackexchange.com/questions/108338/capabilities-and-custom-post-types/108375#108375
	     */
	    $args[ 'map_meta_cap' ] = true;

	    /**
	     * Assign capabilities to users
	     * Without this, users - also admins - can not see post type.
	     */
	    $this->assign_capabilities( $args[ 'capabilities' ], $fields[ 'custom_caps_users' ] );
	}

	/**
	 * Register Taxonomies if any
	 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	if ( isset( $fields[ 'taxonomies' ] ) && is_array( $fields[ 'taxonomies' ] ) ) {

	    foreach ( $fields[ 'taxonomies' ] as $taxonomy ) {
		$this->register_single_post_type_taxonomy( $taxonomy );
	    }
	}

	// Register Custom Post Type ( Finally, Do the Work. )
	register_post_type( strtolower( $fields[ 'slug' ] ), $args );

	// Create Custom Admin Messages
	add_filter( 'post_updated_messages', $this->create_admin_messages( $fields ) );

    }

    /**
     * Register Taxonomy for Custom Post Type
     *
     * @param $tax_fields array
     *
     * @return void
     * @since 1.0
     */
    private function register_single_post_type_taxonomy( array $tax_fields ): void {

	// Set Labels
	$labels = array (
	    'name' => $tax_fields[ 'plural' ],
	    'singular_name' => $tax_fields[ 'single' ],
	    'menu_name' => $tax_fields[ 'plural' ],
	    'all_items' => sprintf( __( 'All %s', 'asd_photo_catalog_i18n' ), $tax_fields[ 'plural' ] ),
	    'edit_item' => sprintf( __( 'Edit %s', 'asd_photo_catalog_i18n' ), $tax_fields[ 'single' ] ),
	    'view_item' => sprintf( __( 'View %s', 'asd_photo_catalog_i18n' ), $tax_fields[ 'single' ] ),
	    'update_item' => sprintf( __( 'Update %s', 'asd_photo_catalog_i18n' ), $tax_fields[ 'single' ] ),
	    'add_new_item' => sprintf( __( 'Add New %s', 'asd_photo_catalog_i18n' ), $tax_fields[ 'single' ] ),
	    'new_item_name' => sprintf( __( 'New %s Name', 'asd_photo_catalog_i18n' ), $tax_fields[ 'single' ] ),
	    'parent_item' => sprintf( __( 'Parent %s', 'asd_photo_catalog_i18n' ), $tax_fields[ 'single' ] ),
	    'parent_item_colon' => sprintf( __( 'Parent %s:', 'asd_photo_catalog_i18n' ), $tax_fields[ 'single' ] ),
	    'search_items' => sprintf( __( 'Search %s', 'asd_photo_catalog_i18n' ), $tax_fields[ 'plural' ] ),
	    'popular_items' => sprintf( __( 'Popular %s', 'asd_photo_catalog_i18n' ), $tax_fields[ 'plural' ] ),
	    'separate_items_with_commas' => sprintf( __( 'Separate %s with commas', 'asd_photo_catalog_i18n' ), $tax_fields[ 'plural' ] ),
	    'add_or_remove_items' => sprintf( __( 'Add or remove %s', 'asd_photo_catalog_i18n' ), $tax_fields[ 'plural' ] ),
	    'choose_from_most_used' => sprintf( __( 'Choose from the most used %s', 'asd_photo_catalog_i18n' ), $tax_fields[ 'plural' ] ),
	    'not_found' => sprintf( __( 'No %s found', 'asd_photo_catalog_i18n' ), $tax_fields[ 'plural' ] ),
	);

	// Setup CPT Taxonomy Properties
	$args = array (
	    'label' => $tax_fields[ 'plural' ],
	    'labels' => $labels,
	    'hierarchical' => $tax_fields[ 'hierarchical' ] ?? true,
	    'public' => $tax_fields[ 'public' ] ?? true,
	    'show_ui' => $tax_fields[ 'show_ui' ] ?? true,
	    'show_in_nav_menus' => $tax_fields[ 'show_in_nav_menus' ] ?? true,
	    'show_tagcloud' => $tax_fields[ 'show_tagcloud' ] ?? true,
	    'meta_box_cb' => $tax_fields[ 'meta_box_cb' ] ?? NULL,
	    'show_admin_column' => $tax_fields[ 'show_admin_column' ] ?? true,
	    'show_in_quick_edit' => $tax_fields[ 'show_in_quick_edit' ] ?? true,
	    'update_count_callback' => $tax_fields[ 'update_count_callback' ] ?? '',
	    'show_in_rest' => $tax_fields[ 'show_in_rest' ] ?? true,
	    'rest_base' => $tax_fields[ 'taxonomy' ],
	    'rest_controller_class' => $tax_fields[ 'rest_controller_class' ] ?? 'WP_REST_Terms_Controller',
	    'query_var' => $tax_fields[ 'taxonomy' ],
	    'sort' => $tax_fields[ 'sort' ] ?? '',
	    'rewrite' => $tax_fields[ 'rewrite' ] ?? true,
	);

	$args = apply_filters( $tax_fields[ 'taxonomy' ] . '_args', $args );

	// Register Custom Taxonomy
	register_taxonomy( $tax_fields[ 'taxonomy' ], $tax_fields[ 'post_types' ], $args );

	// Create 'General' Category for Taxonomy
	// Check if General is not set to false. Default 'blank' / not set = true
	if ( ! $tax_fields[ 'general' ] === false ) {

	    // Create 'general' category for the custom taxonomy
	    self::create_general_taxonomy( $tax_fields[ 'taxonomy' ] );
	}
    }

    /**
     * Create a Default General Category to start
     *
     * @param $taxonomy string
     *
     * @return void
     * @since 1.0
     */
    private static function create_general_taxonomy( string $taxonomy ): void {

	// Check if the term (category) already exists in the given taxonomy
	if ( ! term_exists( _x( 'General', 'asd_photo_catalog_i18n' ), $taxonomy ) ) {

	    // If term does not exist, create it
	    wp_insert_term( _x( 'General', 'asd_photo_catalog_i18n' ), $taxonomy );
	}
    }

    /**
     * Create custom messages for users when adding, editing, updating or deleting
     *
     * @param $fields array
     *
     * @return array
     * @since 1.0
     */
    private function create_admin_messages( array $fields ): array {

	// Get Current Post Info
	global $post, $post_ID;

	// Setup Messages
	$messages[ $fields[ 'slug' ] ] = array (
	    0 => '',
	    1 => sprintf( __( '%s updated. <a href="%s">View Item</a>', 'asd_photo_catalog_i18n' ), $fields[ 'singular' ], esc_url( get_permalink( $post_ID ) ) ),
	    2 => sprintf( esc_html__( '%s updated.', 'asd_photo_catalog_i18n' ), $fields[ 'singular' ] ),
	    3 => sprintf( esc_html__( '%s deleted.', 'asd_photo_catalog_i18n' ), $fields[ 'singular' ] ),
	    4 => sprintf( esc_html__( '%s updated.', 'asd_photo_catalog_i18n' ), $fields[ 'singular' ] ),
	    5 => isset( $_GET[ 'revision' ] ) ? sprintf( __( '%s restored to revision from %s', 'asd_photo_catalog_i18n' ), $fields[ 'singular' ], wp_post_revision_title( (int) $_GET[ 'revision' ], false ) ) : false,
	    6 => sprintf( __( '%s published. <a href="%s">View Catalog</a>', 'asd_photo_catalog_i18n' ), $fields[ 'singular' ], esc_url( get_permalink( $post_ID ) ) ),
	    7 => sprintf( esc_html__( '%s saved.', 'asd_photo_catalog_i18n' ), $fields[ 'singular' ] ),
	    8 => sprintf( __( '%s submitted. <a target="_blank" href="%s">Preview Catalog</a>', 'asd_photo_catalog_i18n' ), $fields[ 'singular' ], esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
	    9 => sprintf( __( '%3$s scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview %4$s</a>', 'asd_photo_catalog_i18n' ), date_i18n( __( 'M j, Y @ G:i', 'asd_photo_catalog_i18n' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ), $fields[ 'singular' ], $fields[ 'singular' ] ),
	    10 => sprintf( __( '%s draft updated. <a target="_blank" href="%s">Preview %s</a>', 'asd_photo_catalog_i18n' ), $fields[ 'singular' ], esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ), $fields[ 'singular' ] ),
	);

	return $messages;
    }

    /**
     * Assign capabilities to users
     * @link https://codex.wordpress.org/Function_Reference/register_post_type
     * @link https://typerocket.com/ultimate-guide-to-custom-post-types-in-wordpress/
     *
     * @param $caps_map array
     * @param $users array
     *
     * @return void
     * @since 1.0
     */
    private function assign_capabilities( array $caps_map, array $users ): void {

	// Loop through
	foreach ( $users as $user ) {

	    $user_role = get_role( $user );

	    foreach ( $caps_map as $cap_map_key => $capability ) {

		$user_role->add_cap( $capability );

	    } //end foreach caps_map

	} //end foreach users

    } //end assign_capabilities

    /**
     * Create Custom Image Sizes
     *
     * @param $fields array
     *
     * @return void
     * @since 1.0
     */
    public function create_custom_image_sizes( array $fields ): void {

	// Check if  Custom Images Size is set
	if ( isset( $fields[ 'image_size' ] ) && is_array( $fields[ 'image_size' ] ) ) {

	    // Loop through
	    foreach ( $fields[ 'image_size' ] as $image => $size ) {

		// Add Image Size
		add_image_size( strtolower( $fields[ 'singular' ] ) . '_' . $image, $size, $size, true );
	    }
	}

    }

    /**
     * Setup the settings for the CPT
     * This is where the real work happens.
     * Create an array for each CPT's settings
     *  You can create multiple post types
     * @return void
     * @since 1.0
     */
    public function create_custom_post_type(): void {

	/**
	 * This is not all the fields, only what I find important. Feel free to change this function ;)
	 * @link https://codex.wordpress.org/Function_Reference/register_post_type
	 */
	$post_types_fields = array (

	    // Create the first post type
	    array (
		'slug' => 'photo-catalog',
		'singular' => 'Photo Catalog',
		'plural' => 'Photo Catalogs',
		'menu_name' => 'Photo Catalogs',
		'name_admin_bar' => 'Photo Catalogs',
		'description' => 'Photo Catalogs for archiving film negatives, and prints.',
		'has_archive' => true,
		'archives' => 'Catalog Archives',
		'hierarchical' => false,
		'menu_icon' => plugin_dir_path( __FILE__ ).'/images/menu_icon.png', // TODO Change to svg or typeface icon
		'rewrite' => array (

		    'slug' => 'photo-catalog',
		    'with_front' => true,
		    'pages' => true,
		    'feeds' => false,
		    'ep_mask' => EP_PERMALINK,
		),
		'menu_position' => 5,
		'public' => true,
		'publicly_queryable' => false,
		'exclude_from_search' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'supports' => array (
		    /* Post titles ($post->post_title). */
		    'title',
		    /* Post content ($post->post_content). */
		    //'editor',
		    /* Post excerpt ($post->post_excerpt). */
		    //'excerpt',
		    /* Post author ($post->post_author). */
		    //'author',
		    /* Featured images (the user's theme must support 'post-thumbnails'). */
		    'thumbnail',
		    /* Displays comments meta box.  If set, comments (any type) are allowed for the post. */
		    //'comments',
		    /* Displays meta box to send trackbacks from the edit post screen. */
		    //'trackbacks',
		    /* Displays the Custom Fields meta box. Post meta is supported regardless. */
		    'custom-fields',
		    /* Displays the Revisions meta box. If set, stores post revisions in the database. */
		    'revisions',
		    /* Displays the Attributes meta box with a parent selector and menu_order input box. */
		    'page-attributes',
		    /* Displays the Format meta box and allows post formats to be used with the posts. */
		    //'post-formats',
		    'genesis-seo',
		    'genesis-cpt-archives-settings',
		),
		'custom_caps' => true,
		'custom_caps_users' => array (
		    'administrator',
		    'editor',
		    // 'author',
		    // 'contributor',
		    // 'subscriber',
		),

		'taxonomies' => array (

		    array (
			'taxonomy' => 'photo-catalog_category',
			'plural' => 'Categories',
			'single' => 'Category',
			'post_types' => array ( 'photo-catalog' ),
		    ),
		    array (
			'taxonomy' => 'photo-catalog_people',
			'plural' => 'People',
			'single' => 'Person',
			'general' => false,
			'post_types' => array ( 'photo-catalog' ),
		    ),

		),

		//'image_size' => [
		//    // Image Size, Crop true, false
		//    'list' => [ '100', 'true' ],
		//    'thumbs' => [ '235', 'true' ],
		//    'full' => [ '315', 'true' ],
		//],
	    ),

	);

	foreach ( $post_types_fields as $fields ) {
	    $this->register_post_type( $fields );
	}

    } //end create-custom-post-type

} // End Create Custom Post Type