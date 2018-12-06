<?php

/*
  Plugin Name: CR Role Manager
  Description: A customized role manager for CR.
  Version: 1.3
  Author: Soto
  Author URI: http://www.gosoto.co/
  License: GPLv2 or later
 */


// don't load directly
if ( !defined( 'ABSPATH' ) )
	die( '-1' );

if ( !class_exists( 'CR_Role_Manager' ) ) {

	class CR_Role_Manager {
		/**
		 * Contains all roles data
		 * @var type array
		 */
		private $version = '1.3';

		/**
		 * Contains all roles data
		 * @var type array
		 */
		private $roles;

		/**
		 * Root plugin dir path with trailing slash
		 * @var type string
		 */
		private $root_path;

		/**
		 * Core singleton class
		 * @var self - pattern realization
		 */
		private static $_instance;

		/**
		 * Constructor of this class
		 * It's private method to prevent direct instantiation of this class
		 */
		private function __construct() {
			$this->root_path = plugin_dir_path( __FILE__ );
			$this->root_url = plugin_dir_url( __FILE__ );

			$this->set_roles();
			
			// Plugins actions and filter
			$this->actions();
			$this->filters();
		}

		private function filters() {
			add_filter( 'admin_body_class', array($this, 'admin_body_class') );
			add_filter( 'custom_menu_order', '__return_true' );
			add_filter( 'menu_order', array( $this, 'menu_order' ) );
			add_filter( 'screen_options_show_screen', array( $this, 'hide_screen_option' ) );
			add_filter( 'wpseo_accessible_post_types', array( $this, 'wp_seo_post_types' ), 20 );
			add_filter( 'page_row_actions', array( $this, 'row_actions' ), 999 );
			add_filter( 'post_row_actions', array( $this, 'row_actions' ), 999 );
			//add_filter( 'get_sample_permalink_html', array( $this, 'sample_permalink_html' ), 999 );
			add_filter( 'wp_editor_settings', array( $this, 'wp_editor_settings' ), 999 );
			add_filter( 'login_redirect', array( $this, 'login_redirect' ), 20, 3 );
			
			add_action('init', array($this, 'rremove_post_type_supports'), 20);
			// Real Media features
			//add_filter( 'RML/Backend/JS_Localize', array( $this, 'rml_js_options' ), 999 );
			// Visual Composer features
			add_filter( 'vc_role_access_with_post_types_get_state', array( $this, 'vc_backend_post_types' ), 20, 2 );
			add_filter( 'vc_role_access_with_post_types_can', array( $this, 'vc_backend_post_types_can' ), 20, 3 );
			add_filter( 'vc_role_access_with_backend_editor_get_state', array( $this, 'vc_backend_editor' ), 20, 2 );
			add_filter( 'vc_role_access_with_frontend_editor_get_state', array( $this, 'vc_frontend_editor' ), 20, 2 );
			add_filter( 'vc_role_access_with_templates_get_state', array( $this, 'vc_templates_editor' ), 20, 2 );
			add_filter( 'vc_role_access_with_backend_editor_can_disabled_ce_editor', array( $this, 'vc_classic_editor' ), 20, 2 );
			add_filter( 'vc_role_access_with_shortcodes_get_state', array( $this, 'vc_shortcodes_get_state' ), 20, 2 );
			add_filter( 'vc_role_access_with_shortcodes_can', array( $this, 'vc_shortcodes_can' ), 20, 3 );
			
			add_filter( 'vc_role_access_all_caps_role', array( $this, 'vc_all_caps' ), 20 );
			add_filter( 'vc_nav_controls', array( $this, 'vc_nav_controls' ), 20 );
		}

		private function actions() {
			add_action( 'admin_menu', array( $this, 'roles_menu_items' ), 200 );
			add_action( 'admin_bar_menu', array( $this, 'roles_admin_bar_items' ), 999 );
			add_action( 'current_screen', array( $this, 'current_screen' ) );
			add_action( 'load-upload.php', array( $this, 'media_page_loaded' ) );
			add_action( 'admin_head', array( $this, 'head_style' ) );
			add_action( 'admin_footer', array( $this, 'footer_scripts' ), 200 );
			add_action('vc_backend_editor_enqueue_js_css', array(
				$this,
				'backend_enqueue_editor_css_js'
			));
		}
		public function admin_body_class($classes) {
			if ( !$this->is_role( 'hotel_editor' ) ) {
				return $classes;
			}
			$screen = get_current_screen();
			
			if(!$screen) {
				return $classes;
			}
			if(!empty($screen->post_type) && $this->check_get_var('action', 'edit')){
				$classes .= ' crrm-screen-' . $screen->post_type . '-edit';
			}
			if(!empty($screen->post_type) && $screen->action && ($screen->action == 'add')){
				$classes .= ' crrm-screen-' . $screen->post_type . '-add-new';
			}
			
			return $classes;
		}
		
		public function check_get_var($key, $val) {
			if(!empty($_GET[$key]) && $val == $_GET[$key]){
				return true;
			}
			return false;
		}
		
		public function media_page_loaded() {
			if ( !$this->is_role( 'hotel_editor' ) ) {
				return;
			}
			if ( isset( $_GET[ 'mode' ] ) ) {
				$_GET[ 'mode' ] = 'grid';
			}
		}
		
		public function rremove_post_type_supports() {
			if ( !$this->is_role( 'hotel_editor' ) ) {
				return;
			}
			remove_post_type_support( 'amenity', 'editor' );
		}

		public function vc_backend_post_types( $state, $role ) {
			if ( !$role || ('hotel_editor' != $role->name) ) {
				return $state;
			}
			return 'custom';
		}

		public function vc_backend_post_types_can( $value, $role, $rule ) {
			if ( !$role || ('hotel_editor' != $role->name) ) {
				return $value;
			}
			return in_array( $rule, array('apartment', 'offer', 'page') );
		}
		public function vc_backend_editor( $state, $role ) {
			if ( !$role || ('hotel_editor' != $role->name) ) {
				return $state;
			}
			return true;
		}
		
		public function vc_shortcodes_get_state($state, $role) {
			if ( !$role || ('hotel_editor' != $role->name) ) {
				return $state;
			}
			
			return 'custom';
		}
		
		public function vc_shortcodes_can($value, $role, $rule) {
			if ( !$role || ('hotel_editor' != $role->name) ) {
				return $value;
			}
			return true;
		}

		public function vc_nav_controls( $controls ) {
			if ( !$this->is_role( 'hotel_editor' ) ) {
				return $controls;
			}
			$custom_css_pos	 = false;
			$fullscreen_pos	 = false;
			foreach ( $controls as $pos => $control ) {
				if ( $control[ 0 ] == 'custom_css' ) {
					$custom_css_pos = $pos;
				}
				if ( $control[ 0 ] == 'fullscreen' ) {
					$fullscreen_pos = $pos;
				}
			}
			if ( false !== $custom_css_pos ) {
				unset( $controls[ $custom_css_pos ] );
			}
			if ( false !== $fullscreen_pos ) {
				unset( $controls[ $fullscreen_pos ] );
			}
			return $controls;
		}

		public function vc_frontend_editor( $state, $role ) {
			if ( !$role || ('hotel_editor' != $role->name) ) {
				return $state;
			}
			return false;
		}

		public function vc_templates_editor( $state, $role ) {
			if ( !$role || ('hotel_editor' != $role->name) ) {
				return $state;
			}
			return false;
		}

		public function vc_classic_editor( $state, $role ) {
			if ( !$role || ('hotel_editor' != $role->name) ) {
				return $state;
			}
			return true;
		}

		public function vc_all_caps( $role ) {
			if ( !$role || ('hotel_editor' != $role->name) ) {
				return $role;
			}
			$part																 = vc_role_access()->who( $role->name )->part( 'backend_editor' );
			$role->capabilities[ $part->getStateKey() . '/disabled_ce_editor' ]	 = true;

			return $role;
		}
		
		public function login_redirect($redirect_to, $requested_redirect_to, $user) {
			if ( !is_wp_error($user) && in_array( 'hotel_editor', $user->roles )  ) {
				$redirect_to = admin_url( 'edit.php?post_type=page' );
			}
			return $redirect_to;
		}

		public function rml_js_options( $options ) {
			global $pagenow;
			if ( !$this->is_role( 'hotel_editor' ) || $pagenow != 'upload.php' ) {
				return $options;
			}
			if ( isset( $options[ 'lang' ][ 'createTypes' ][ 'collection' ] ) ) {
				unset( $options[ 'lang' ][ 'createTypes' ][ 'collection' ] );
			}
			return $options;
		}

		public function head_style() {
			if ( !$this->is_role( 'hotel_editor' ) ) {
				return;
			}
			require_once $this->root_path . 'inc/styles.php';
		}

		public function footer_scripts() {
			if ( !$this->is_role( 'hotel_editor' ) ) {
				return;
			}
			require_once $this->root_path . 'inc/scripts.php';
		}
		public function backend_enqueue_editor_css_js() {
			if ( !$this->is_role( 'hotel_editor' ) ) {
				return;
			}
			wp_enqueue_script('crrm-jscompoers', $this->root_url . 'assets/js/js-compoer.js', array(), $this->version, true);
		}

		public function wp_editor_settings( $settings ) {
			if ( !$this->is_role( 'hotel_editor' ) ) {
				return $settings;
			}
			$screen = get_current_screen();
			
			if($screen && !empty($screen->post_type) && in_array( $screen->post_type, array('post') )){
				return $settings;
			}
			$settings[ 'media_buttons' ] = false;
			return $settings;
		}

		public function sample_permalink_html( $return ) {
			if ( !$this->is_role( 'hotel_editor' ) ) {
				return $return;
			}
			return preg_replace( '/<span id="edit-slug-buttons">(.*?)<\/span>/', '', $return );
		}

		public function current_screen() {
			if ( !$this->is_role( 'hotel_editor' ) ) {
				return;
			}
			$current_screen = get_current_screen();
			if ( !$current_screen ) {
				return;
			}
			add_filter( "bulk_actions-{$current_screen->id}", "__return_false" );
			if(!empty($current_screen->taxonomy)){
				add_filter("manage_{$current_screen->id}_columns", array($this, 'list_table_columns'));
			}
		}
		
		public function list_table_columns($columns) {
			if(isset($columns['description'])){
				unset($columns['description']);
			}
			if(isset($columns['wpseo-score'])){
				unset($columns['wpseo-score']);
			}
			if(isset($columns['wpseo-score-readability'])){
				unset($columns['wpseo-score-readability']);
			}
			return $columns;
		}

		public function is_role( $role ) {
			$current_user = wp_get_current_user();
			if ( $current_user && in_array( $role, $current_user->roles ) ) {
				return true;
			}
			return false;
		}

		public function roles_menu_items() {
			if ( !$this->is_role( 'hotel_editor' ) ) {
				return;
			}
			global $menu, $submenu;
			unset( $menu[ 2 ] );
			unset( $menu[ 4 ] );
			$to_hide = array(
				'edit.php?post_type=accommodation',
				'edit.php?post_type=cr_map',
				'profile.php',
				'tools.php',
				'vc-welcome'
			);
			foreach ( $menu as $id => $data ) {
				if ( in_array( $data[ 2 ], $to_hide ) ) {
					unset( $menu[ $id ] );
				}
			}
			// Remove item form Appearance submenu
			if ( isset( $submenu[ 'themes.php' ] ) ) {
				foreach ( $submenu[ 'themes.php' ] as $pos => $themes_page ) {
					if ( $themes_page[ 2 ] != 'nav-menus.php' ) {
						unset( $submenu[ 'themes.php' ][ $pos ] );
					}
				}
			}
			$new_files = array(
				'post-new.php',
				'post-new.php?post_type=page',
				'post-new.php?post_type=amenity'.
				'post-new.php?post_type=accommodation',
				'post-new.php?post_type=apartment',
				'post-new.php?post_type=offer'
				
			);
			// add classes to submenu items
			foreach ( $submenu as $menu_file => $items_sub_menus ) {
				foreach($items_sub_menus as $pos => $sub_menu_item) {
					if( in_array( $sub_menu_item[2],  $new_files)){
						unset( $submenu[ $menu_file ][ $pos ] );
					}
					$submenu[$menu_file][$pos][4] = 'cr-submenu-item-' . sanitize_title_with_dashes($sub_menu_item[0]);
				}
			}
		}

		public function menu_order( $menu_order ) {
			if ( !$this->is_role( 'hotel_editor' ) ) {
				return $menu_order;
			}
			$post_menu_position	 = array_search( 'edit.php', $menu_order );
			$page_menu_position	 = array_search( 'edit.php?post_type=page', $menu_order );
			unset( $menu_order[ $page_menu_position ] );
			if ( ($post_menu_position !== false) && ($page_menu_position !== false) ) {
				array_splice( $menu_order, $post_menu_position, 0, array( 'edit.php?post_type=page' ) );
			}
			return $menu_order;
		}

		public function roles_admin_bar_items( $wp_admin_bar ) {
			if ( !$this->is_role( 'hotel_editor' ) ) {
				return;
			}
			$wp_admin_bar->remove_node( 'comments' );
			$wp_admin_bar->remove_node( 'new-content' );
			$wp_admin_bar->remove_node( 'wpseo-menu' );
		}

		public function hide_screen_option( $show_screen ) {
			if ( !$this->is_role( 'hotel_editor' ) ) {
				return $show_screen;
			}
			return array();
		}

		public function wp_seo_post_types( $post_types ) {
			if ( !$this->is_role( 'hotel_editor' ) ) {
				return $post_types;
			}
			return false;
		}

		public function row_actions( $actions ) {
			if ( !$this->is_role( 'hotel_editor' ) ) {
				return $actions;
			}
			if ( isset( $actions[ 'edit_vc' ] ) ) {
				unset( $actions[ 'edit_vc' ] );
			}
			if ( isset( $actions[ 'inline hide-if-no-js' ] ) ) {
				unset( $actions[ 'inline hide-if-no-js' ] );
			}
			return $actions;
		}

		private function set_roles() {
			$this->roles = apply_filters( 'cr_rm_roles', array(
				'hotel_editor' => array(
					'role'			 => 'hotel_editor',
					'display_name'	 => __( 'Hotel Editor', 'crt' ),
					'caps'			 => array(
						'edit_theme_options'	 => true,
						'delete_others_pages'	 => true,
						'delete_others_posts'	 => true,
						'delete_pages'			 => true,
						'delete_posts'			 => true,
						'delete_private_pages'	 => true,
						'delete_private_posts'	 => true,
						'delete_published_pages' => true,
						'delete_published_posts' => true,
						'edit_others_pages'		 => true,
						'edit_others_posts'		 => true,
						'edit_pages'			 => true,
						'edit_posts'			 => true,
						'edit_private_pages'	 => true,
						'edit_private_posts'	 => true,
						'edit_published_pages'	 => true,
						'edit_published_posts'	 => true,
						'manage_categories'		 => true,
						'manage_links'			 => true,
						'moderate_comments'		 => true,
						'publish_pages'			 => true,
						'publish_posts'			 => true,
						'read'					 => true,
						'read_private_pages'	 => true,
						'read_private_posts'	 => true,
						'unfiltered_html'		 => true, // (not with Multisite. See Unfiltered MU & RemoveKses)
						'upload_files'			 => true,
					),
				)
			) );
			if ( empty( $this->roles ) ) {
				$this->roles = array();
			}
		}

		private function check_role_data( $role_data ) {
			if ( empty( $role_data[ 'role' ] ) || empty( $role_data[ 'display_name' ] ) ) {
				return false;
			}
			if ( !is_array( $role_data[ 'caps' ] ) ) {
				$role_data[ 'caps' ] = array();
			}
			return $role_data;
		}

		/**
		 * Get the instance of CR_VCE_Manager
		 *
		 * @return self
		 */
		public static function get_instance() {
			if ( !( self::$_instance instanceof self ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function create_roles() {
			global $wp_roles;
			if ( !class_exists( 'WP_Roles' ) ) {
				return;
			}

			if ( !isset( $wp_roles ) ) {
				$wp_roles = new WP_Roles();
			}
			foreach ( $this->roles as $role_key => $role_data ) {
				$role_data = $this->check_role_data( $role_data );
				if ( !$role_data ) {
					continue;
				}
				// First remove role so that capabilitiesa re reassigned
				remove_role( $role_data[ 'role' ] );
				add_role( $role_data[ 'role' ], $role_data[ 'display_name' ], $role_data[ 'caps' ] );
			}
		}

		public function remove_roles() {
			foreach ( $this->roles as $role_key => $role_data ) {
				$role_data = $this->check_role_data( $role_data );
				if ( !$role_data ) {
					continue;
				}
				remove_role( $role_data[ 'role' ] );
			}
		}

		public static function activate() {
			self::get_instance()->create_roles();
		}

		public static function deactivate() {
			self::get_instance()->remove_roles();
		}

	}

	register_activation_hook( __FILE__, array( 'CR_Role_Manager', 'activate' ) );
	register_deactivation_hook( __FILE__, array( 'CR_Role_Manager', 'deactivate' ) );

	CR_Role_Manager::get_instance();
}