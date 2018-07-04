<?php
if (!defined('ABSPATH')) die('-1');

class CR_Custom_types {
	/*
	 * The single instance of the class.
	 *
	 * @var WC_Checkout|null
	 */
	protected static $instance = null;
	private $text_domain_name;
	private static $types_data;/**
	 * Gets the main WC_Checkout Instance.
	 *
	 * @since 2.1
	 * @static
	 * @return WC_Checkout Main instance
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	private function __construct( ) {
		$this->text_domain_name = 'crt';
		self::$types_data = array(
			'amenity' => array('type' => 'amenity', 'slug' => 'amenity'),
			'accommodation' => array('type' => 'accommodation', 'slug' => 'accommodation'),
			'accommodation_location' => array('type' => 'accommodation_location', 'slug' => 'accommodation_location'),
			'accommodation_room_type' => array('type' => 'accommodation_room_type', 'slug' => 'accommodation_room_type'),
			'accommodation_amenity' => array('type' => 'accommodation_amenity', 'slug' => 'accommodation_amenity'),
			'room_type' => array('type' => 'apartment', 'slug' => 'apartment'),
			'offer' => array('type' => 'offer', 'slug' => 'offer'),
		);
		add_action('init', array($this, 'register'), 0);
	}
	
	/**
	 * Post type register: amenity
	 */
	private function amenity(){
		$type_name = self::get_amenity_data('type');
		$type_slug = self::get_amenity_data('slug');
		$labels = array(
			'name'				 => _x( 'Amenity', 'post type general name', $this->text_domain_name ),
			'singular_name'		 => _x( 'Amenity', 'post type singular name', $this->text_domain_name ),
			'menu_name'			 => _x( 'Amenity', 'admin menu', $this->text_domain_name ),
			'name_admin_bar'	 => _x( 'Amenity', 'add new on admin bar', $this->text_domain_name ),
			'add_new'			 => _x( 'Add New Amenity', $this->text_domain_name ),
			'add_new_item'		 => __( 'Add New ' . 'Amenity', $this->text_domain_name ),
			'new_item'			 => __( 'New Amenity', $this->text_domain_name ),
			'edit_item'			 => __( 'Edit Amenity', $this->text_domain_name ),
			'view_item'			 => __( 'View Amenity', $this->text_domain_name ),
			'all_items'			 => __( 'All amenities', $this->text_domain_name ),
			'search_items'		 => __( 'Search amenity', $this->text_domain_name ),
			'parent_item_colon'	 => __( 'Parent amenity', $this->text_domain_name ),
			'not_found'			 => __( 'No amenities found.', $this->text_domain_name ),
			'not_found_in_trash' => __( 'No amenities found in Trash.', $this->text_domain_name ),
			'attributes'		 => __( 'Amenity Attributes.', $this->text_domain_name ),
		);
		$args = array(
			'labels'				 => $labels,
			'public'				 => false,
			'publicly_queryable'	 => false,
			'show_ui'				 => true,
			'show_in_menu'			 => true,
			'query_var'				 => false,
			'rewrite'				 => array('slug' => $type_slug),
			'capability_type'		 => 'post',
			'has_archive'			 => false,
			'show_in_nav_menus'		 => false,
			'hierarchical'			 => false,
			'menu_position'			 => 25.1,
			'supports'				 => array('title', 'editor', 'thumbnail'),
		);

		register_post_type( $type_name, $args );		
	}
	
	/**
	 * Post type register: accommodation
	 */
	private function accommodation(){
		$type_name = self::get_accommodation_data('type');
		$type_slug = self::get_accommodation_data('slug');
		$labels = array(
			'name'				 => _x( 'Accommodation', 'post type general name', $this->text_domain_name ),
			'singular_name'		 => _x( 'Accommodation', 'post type singular name', $this->text_domain_name ),
			'menu_name'			 => _x( 'Accommodation', 'admin menu', $this->text_domain_name ),
			'name_admin_bar'	 => _x( 'Accommodation', 'add new on admin bar', $this->text_domain_name ),
			'add_new'			 => _x( 'Add Accommodation', $this->text_domain_name ),
			'add_new_item'		 => __( 'Add Accommodation', $this->text_domain_name ),
			'new_item'			 => __( 'New Accommodation', $this->text_domain_name ),
			'edit_item'			 => __( 'Edit Accommodation', $this->text_domain_name ),
			'view_item'			 => __( 'View Accommodation', $this->text_domain_name ),
			'all_items'			 => __( 'All accommodation', $this->text_domain_name ),
			'search_items'		 => __( 'Search accommodation', $this->text_domain_name ),
			'parent_item_colon'	 => __( 'Parent accommodation', $this->text_domain_name ),
			'not_found'			 => __( 'No accommodations found.', $this->text_domain_name ),
			'not_found_in_trash' => __( 'No accommodations found in Trash.', $this->text_domain_name ),
			'attributes'		 => __( 'Accommodation Attributes', $this->text_domain_name ),
		);
		$args = array(
			'labels'				 => $labels,
			'public'				 => false,
			'publicly_queryable'	 => false,
			'show_ui'				 => true,
			'show_in_menu'			 => true,
			'query_var'				 => false,
			'rewrite'				 => false,
			'capability_type'		 => 'post',
			'has_archive'			 => falase,
			'show_in_nav_menus'		 => false,
			'hierarchical'			 => false,
			'menu_position'			 => 25.2,
			'supports'				 => array('title', 'editor', 'thumbnail', 'page-attributes'),
			'taxonomies'			 => array(
											self::get_accommodation_location_data('type'), 
											self::get_accommodation_room_type_data('type'), 
											self::get_accommodation_amenity_data('type'),
										),
		);
		
		register_post_type( $type_name, $args );		
	}
	
	/**
	 * Custom Taxonomy register: accommodation_location
	 */
	private function accommodation_location(){
		$type_name = self::get_accommodation_data('type');
		$type_slug = self::get_accommodation_data('slug');
		$taxonomy_name = self::get_accommodation_location_data('type');
		$taxonomy_slug = self::get_accommodation_location_data('slug');
		$labels	 = array(
			'name'						 => _x( 'Accommodation Location', 'taxonomy general name', $this->text_domain_name ),
			'singular_name'				 => _x( 'Accommodation Location', 'taxonomy singular name', $this->text_domain_name ),
			'search_items'				 => __( 'Search Accommodation  Locations', $this->text_domain_name ),
			'popular_items'				 => __( 'Popular Accommodation Locations', $this->text_domain_name ),
			'all_items'					 => __( 'All Accommodation Locations', $this->text_domain_name ),
			'parent_item'				 => null,
			'parent_item_colon'			 => null,
			'edit_item'					 => __( 'Edit Accommodation Location', $this->text_domain_name ),
			'update_item'				 => __( 'Update Accommodation Location', $this->text_domain_name ),
			'add_new_item'				 => __( 'Add New Location', $this->text_domain_name ),
			'new_item_name'				 => __( 'New Location', $this->text_domain_name ),
			'separate_items_with_commas' => __( 'Separate Locations with commas', $this->text_domain_name ),
			'add_or_remove_items'		 => __( 'Add or remove Locations', $this->text_domain_name ),
			'choose_from_most_used'		 => __( 'Choose from the most used Location', $this->text_domain_name ),
			'not_found'					 => __( 'No Location  found.', $this->text_domain_name ),
			'menu_name'					 => __( 'Locations', $this->text_domain_name ),
		);
		$args	 = array(
			"labels"			 => $labels,
			'public'			 => false,
			'hierarchical'		 => false,
			'show_ui'			 => true,
			'show_in_nav_menus'	 => false,
			'show_admin_column'	 => true,
			'args'				 => array('orderby' => 'term_order'),
			'query_var'			 => false,
			'rewrite'			 => false,
			'meta_box_cb'		 => false,
		);
		register_taxonomy( $taxonomy_name, $type_name, $args );
	}
	
	/**
	 * Custom Taxonomy register: accommodation_type
	 */
	private function accommodation_room_type(){
		$type_name = self::get_accommodation_data('type');
		$type_slug = self::get_accommodation_data('slug');
		$taxonomy_name = self::get_accommodation_room_type_data('type');
		$taxonomy_slug = self::get_accommodation_room_type_data('slug');
		$labels	 = array(
			'name'						 => _x( 'Accommodation Room Type', 'taxonomy general name', $this->text_domain_name ),
			'singular_name'				 => _x( 'Accommodation Room Type', 'taxonomy singular name', $this->text_domain_name ),
			'search_items'				 => __( 'Search Accommodation  Room Type', $this->text_domain_name ),
			'popular_items'				 => __( 'Popular Accommodation Room Type', $this->text_domain_name ),
			'all_items'					 => __( 'All Accommodation Room Type', $this->text_domain_name ),
			'parent_item'				 => null,
			'parent_item_colon'			 => null,
			'edit_item'					 => __( 'Edit Accommodation Room Type', $this->text_domain_name ),
			'update_item'				 => __( 'Update Accommodation Room Type', $this->text_domain_name ),
			'add_new_item'				 => __( 'Add New Room Type', $this->text_domain_name ),
			'new_item_name'				 => __( 'New Room Type', $this->text_domain_name ),
			'separate_items_with_commas' => __( 'Separate Room Type with commas', $this->text_domain_name ),
			'add_or_remove_items'		 => __( 'Add or remove Room Type', $this->text_domain_name ),
			'choose_from_most_used'		 => __( 'Choose from the most used Room Type', $this->text_domain_name ),
			'not_found'					 => __( 'No Room Type  found.', $this->text_domain_name ),
			'menu_name'					 => __( 'Room Type', $this->text_domain_name ),
		);
		$args	 = array(
			"labels"			 => $labels,
			'public'			 => false,
			'hierarchical'		 => true,
			'show_ui'			 => true,
			'show_in_nav_menus'	 => true,
			'show_admin_column'	 => true,
			'args'				 => array('orderby' => 'term_order'),
			'query_var'			 => true,
			'rewrite'			 => false,
			'meta_box_cb'		 => false,
		);
		register_taxonomy( $taxonomy_name, $type_name, $args );
	}
	
	/**
	 * Custom Taxonomy register: accommodation_amenity
	 */
	private function accommodation_amenity(){
		$type_name = self::get_accommodation_data('type');
		$type_slug = self::get_accommodation_data('slug');
		$taxonomy_name = self::get_accommodation_amenity_data('type');
		$taxonomy_slug = self::get_accommodation_amenity_data('slug');
		$labels	 = array(
			'name'						 => _x( 'Accommodation Amenity', 'taxonomy general name', $this->text_domain_name ),
			'singular_name'				 => _x( 'Accommodation Amenity', 'taxonomy singular name', $this->text_domain_name ),
			'search_items'				 => __( 'Search Accommodation  Amenity', $this->text_domain_name ),
			'popular_items'				 => __( 'Popular Accommodation Amenity', $this->text_domain_name ),
			'all_items'					 => __( 'All Accommodation Amenity', $this->text_domain_name ),
			'parent_item'				 => null,
			'parent_item_colon'			 => null,
			'edit_item'					 => __( 'Edit Accommodation Amenity', $this->text_domain_name ),
			'update_item'				 => __( 'Update Accommodation Amenity', $this->text_domain_name ),
			'add_new_item'				 => __( 'Add New Amenity', $this->text_domain_name ),
			'new_item_name'				 => __( 'New Amenity', $this->text_domain_name ),
			'separate_items_with_commas' => __( 'Separate Amenity with commas', $this->text_domain_name ),
			'add_or_remove_items'		 => __( 'Add or remove Amenity', $this->text_domain_name ),
			'choose_from_most_used'		 => __( 'Choose from the most used Amenity', $this->text_domain_name ),
			'not_found'					 => __( 'No Amenity  found.', $this->text_domain_name ),
			'menu_name'					 => __( 'Amenity', $this->text_domain_name ),
		);
		$args	 = array(
			"labels"			 => $labels,
			'public'			 => false,
			'hierarchical'		 => false,
			'show_ui'			 => true,
			'show_in_nav_menus'	 => false,
			'show_admin_column'	 => true,
			'args'				 => array('orderby' => 'term_order'),
			'query_var'			 => false,
			'rewrite'			 => false,
			'meta_box_cb'		 => false,
		);
		register_taxonomy( $taxonomy_name, $type_name, $args );
	}
	
	
	/**
	 * Post type register: amenity
	 */
	private function room_type(){
		$type_name = self::get_room_type_data('type');
		$type_slug = self::get_room_type_data('slug');
		$labels = array(
			'name'				 => _x( 'Apartments', 'post type general name', $this->text_domain_name ),
			'singular_name'		 => _x( 'Apartment', 'post type singular name', $this->text_domain_name ),
			'menu_name'			 => _x( 'Apartment', 'admin menu', $this->text_domain_name ),
			'name_admin_bar'	 => _x( 'Apartment', 'add new on admin bar', $this->text_domain_name ),
			'add_new'			 => _x( 'Add New Apartment', $this->text_domain_name ),
			'add_new_item'		 => __( 'Add New Apartment', $this->text_domain_name ),
			'new_item'			 => __( 'New Apartment', $this->text_domain_name ),
			'edit_item'			 => __( 'Edit Apartment', $this->text_domain_name ),
			'view_item'			 => __( 'View Apartment', $this->text_domain_name ),
			'all_items'			 => __( 'All Apartments', $this->text_domain_name ),
			'search_items'		 => __( 'Search Apartments', $this->text_domain_name ),
			'parent_item_colon'	 => __( 'Parent Apartment', $this->text_domain_name ),
			'not_found'			 => __( 'No Apartment found.', $this->text_domain_name ),
			'not_found_in_trash' => __( 'No Apartment found in Trash.', $this->text_domain_name ),
			'attributes'		 => __( 'Apartment Attributes.', $this->text_domain_name ),
		);
		$args = array(
			'labels'				 => $labels,
			'public'				 => true,
			'publicly_queryable'	 => true,
			'show_ui'				 => true,
			'show_in_menu'			 => true,
			'query_var'				 => true,
			'rewrite'				 => array('slug' => $type_slug),
			'capability_type'		 => 'post',
			'has_archive'			 => false,
			'show_in_nav_menus'		 => true,
			'hierarchical'			 => true,
			'menu_position'			 => 25.2,
			'supports'				 => array('title', 'editor', 'thumbnail', 'page-attributes', ),
		);

		register_post_type( $type_name, $args );		
	}
	
	
	/**
	 * Post type register: amenity
	 */
	private function offers(){
		$type_name = self::get_offer_data('type');
		$type_slug = self::get_offer_data('slug');
		$labels = array(
			'name'				 => _x( 'Offers', 'post type general name', $this->text_domain_name ),
			'singular_name'		 => _x( 'Offer', 'post type singular name', $this->text_domain_name ),
			'menu_name'			 => _x( 'Offer', 'admin menu', $this->text_domain_name ),
			'name_admin_bar'	 => _x( 'Offer', 'add new on admin bar', $this->text_domain_name ),
			'add_new'			 => _x( 'Add New Offer', $this->text_domain_name ),
			'add_new_item'		 => __( 'Add New Offer', $this->text_domain_name ),
			'new_item'			 => __( 'New Offer', $this->text_domain_name ),
			'edit_item'			 => __( 'Edit Offer', $this->text_domain_name ),
			'view_item'			 => __( 'View Offer', $this->text_domain_name ),
			'all_items'			 => __( 'All Offers', $this->text_domain_name ),
			'search_items'		 => __( 'Search Offers', $this->text_domain_name ),
			'parent_item_colon'	 => __( 'Parent Offer', $this->text_domain_name ),
			'not_found'			 => __( 'No offer found.', $this->text_domain_name ),
			'not_found_in_trash' => __( 'No offer found in Trash.', $this->text_domain_name ),
			'attributes'		 => __( 'Offer Type Attributes.', $this->text_domain_name ),
		);
		$args = array(
			'labels'				 => $labels,
			'public'				 => true,
			'publicly_queryable'	 => true,
			'show_ui'				 => true,
			'show_in_menu'			 => true,
			'query_var'				 => true,
			'rewrite'				 => array('slug' => $type_slug),
			'capability_type'		 => 'post',
			'has_archive'			 => false,
			'show_in_nav_menus'		 => true,
			'hierarchical'			 => true,
			'menu_position'			 => 25.2,
			'supports'				 => array('title', 'editor', 'thumbnail', 'page-attributes', ),
		);

		register_post_type( $type_name, $args );		
	}

	/**
	 * Get Amenity data
	 * @param string $key
	 * @return string
	 */
	public static function get_amenity_data($key = ''){
		if($key && isset(self::$types_data['amenity'][$key])){
			return self::$types_data['amenity'][$key];
		}
		return self::$types_data['amenity'];
	}

	/**
	 * Get Course data
	 * @param string $key
	 * @return string
	 */
	public static function get_accommodation_data($key = ''){
		if($key && isset(self::$types_data['accommodation'][$key])){
			return self::$types_data['accommodation'][$key];
		}
		return self::$types_data['accommodation'];
	}

	/**
	 * Get Course data
	 * @param string $key
	 * @return string
	 */
	public static function get_accommodation_location_data($key = ''){
		if($key && isset(self::$types_data['accommodation_location'][$key])){
			return self::$types_data['accommodation_location'][$key];
		}
		return self::$types_data['accommodation_location'];
	}

	/**
	 * Get Course data
	 * @param string $key
	 * @return string
	 */
	public static function get_accommodation_room_type_data($key = ''){
		if($key && isset(self::$types_data['accommodation_room_type'][$key])){
			return self::$types_data['accommodation_room_type'][$key];
		}
		return self::$types_data['accommodation_room_type'];
	}

	/**
	 * Get Course data
	 * @param string $key
	 * @return string
	 */
	public static function get_accommodation_amenity_data($key = ''){
		if($key && isset(self::$types_data['accommodation_amenity'][$key])){
			return self::$types_data['accommodation_amenity'][$key];
		}
		return self::$types_data['accommodation_amenity'];
	}
	/**
	 * Get Room Type data
	 * @param string $key
	 * @return string
	 */
	public static function get_room_type_data($key = ''){
		if($key && isset(self::$types_data['room_type'][$key])){
			return self::$types_data['room_type'][$key];
		}
		return self::$types_data['room_type'];
	}
	/**
	 * Get offer data
	 * @param string $key
	 * @return string
	 */
	public static function get_offer_data($key = ''){
		if($key && isset(self::$types_data['offer'][$key])){
			return self::$types_data['offer'][$key];
		}
		return self::$types_data['offer'];
	}
	/**
	 * Register each custom types
	 */
	public function register(){
		$this->amenity();
		$this->accommodation_location();
		$this->accommodation_room_type();
		$this->accommodation_amenity();
		$this->accommodation();
		$this->room_type();
		$this->offers();
	}
}
