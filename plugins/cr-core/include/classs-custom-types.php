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
		);
		add_action('init', array($this, 'register'));
	}
	
	/**
	 * Post type register: Course
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
			'supports'				 => array('title', 'editor', 'thumbnail', 'page-attributes'),
		);

		register_post_type( $type_name, $args );		
	}

	/**
	 * Get Course data
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
	 * Register each custom types
	 */
	public function register(){
		$this->amenity();
	}
}
