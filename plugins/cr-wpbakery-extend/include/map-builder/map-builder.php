<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * A google map builder tool
 */
class MHM_Map_builder {
	private $path;
	private $url;
	private $text_domain_name = 'crvc_extension';
	private $cpt = 'cr_map';
	/**
	 * Core singleton class
	 * @var self - pattern realization
	 */
	private static $_instance;
	/**
	 * Constructor loads API functions, defines paths and adds required wp actions
	 *
	 * @since  1.0
	 */
	private function __construct() {
		$this->path = plugin_dir_path(__FILE__);
		$this->url = plugin_dir_url(__FILE__);
		add_action( 'init', array(
			$this,
			'init',
		) );
		add_action( 'save_post', array(
			$this,
			'save_metafields',
		) );
	}
	/**
	 * Set text domain
	 * @param str $text_domain
	 */
	public function get_text_domain_name() {
		return apply_filters('mhm_map_builder_text_domain_nmae', $this->text_domain_name);
	}
	/**
	 * Set text domain
	 * @param str $text_domain
	 */
	public function get_custom_types_data($text_domain) {
		
	}
	/**
	 * Init the tool
	 */
	public function init() {
		$this->text_domain_name = $this->get_text_domain_name();
		$this->register_custom_types();
	}
	/**
	 * Register Post type for Map
	 */
	public function register_custom_types() {
		$labels = array(
			'name'				 => _x( 'Map', 'post type general name', $this->text_domain_name ),
			'singular_name'		 => _x( 'Map', 'post type singular name', $this->text_domain_name ),
			'menu_name'			 => _x( 'Map', 'admin menu', $this->text_domain_name ),
			'name_admin_bar'	 => _x( 'Map', 'add new on admin bar', $this->text_domain_name ),
			'add_new'			 => _x( 'Add New Map', $this->text_domain_name ),
			'add_new_item'		 => __( 'Add New ' . 'Map', $this->text_domain_name ),
			'new_item'			 => __( 'New Map', $this->text_domain_name ),
			'edit_item'			 => __( 'Edit Map', $this->text_domain_name ),
			'view_item'			 => __( 'View Map', $this->text_domain_name ),
			'all_items'			 => __( 'All Map', $this->text_domain_name ),
			'search_items'		 => __( 'Search Map', $this->text_domain_name ),
			'parent_item_colon'	 => __( 'Parent Map', $this->text_domain_name ),
			'not_found'			 => __( 'No Map found.', $this->text_domain_name ),
			'not_found_in_trash' => __( 'No Map found in Trash.', $this->text_domain_name )
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
			'has_archive'			 => false,
			'show_in_nav_menus'		 => false,
			'hierarchical'			 => false,
			'menu_position'			 => 25.1,
			'supports'				 => array('title'),
			'menu_icon'				 => 'dashicons-location-alt',
			'register_meta_box_cb'   => array($this, 'meta_box'),
		);
		register_post_type( $this->cpt, $args );
	}
	
	public function admin_register_assets() {
		wp_register_style('mhm_map_builder', $this->url . 'assets/css/admin.css');
		wp_register_script('mhm_map_builder', $this->url . 'assets/js/admin.js', array('jquery', 'underscore', 'backbone'), false, true);
		
		$map_data = $this->get_map_data(get_queried_object_id());
		wp_localize_script('mhm_map_builder', 'MHMMapBuilderData', $map_data);
		
		wp_enqueue_style('mhm_map_builder');
		wp_enqueue_script('mhm_map_builder');
		
	}
	
	public function get_map_data($post_id) {
		global $post;
		if(!$post_id) {
			$post_id = isset($_GET['post']) ? $_GET['post']: $post->ID;
		}
		
		$map_center = get_post_meta($post_id, '_map_center', true);
		$map_zoom = get_post_meta($post_id, '_map_zoom', true);
		$map_filters = get_post_meta($post_id, '_map_filters', true);
		$map_markers = get_post_meta($post_id, '_map_markers', true);
		//var_dump($map_markers);die();
		$map_center = !empty($map_center) && is_array($map_center) ? $map_center : array();
		$map_filters = !empty($map_filters) && is_array($map_filters) ? $map_filters : array();
		$map_markers = !empty($map_markers) && is_array($map_markers) ? $map_markers : array();
		
		if(isset($map_center['lat'])){
			$map_center['lat'] = floatval($map_center['lat']);
		}
		if(isset($map_center['lng'])){
			$map_center['lng'] = floatval($map_center['lng']);
		}
		if(!empty($map_zoom)){
			$map_zoom = absint($map_zoom);
		}else{
			$map_zoom = 12;
		}
		foreach($map_markers as $key => $marker) {
			if(isset($marker['lat'])){
				$map_markers[$key]['lat'] = floatval($marker['lat']);
			}
			if(isset($map_center['lng'])){
				$map_markers[$key]['lng'] = floatval($marker['lng']);
			}
		}
		
		return array(
			'MAP_API_KEY' => get_option('cr_map_api_key'),
			'center' => $map_center,
			'zoom' => $map_zoom,
			'filters' => $map_filters,
			'markers' => $map_markers,
		);
	}
	/**
	 * 
	 * @param type $post
	 */
	public function meta_box($post) {
		add_meta_box('mhm_map_builder_mb', "Map Builder", array($this, 'builder_markup'));
		add_action('admin_enqueue_scripts', array(
			$this,
			'admin_register_assets'
		));
		add_action('admin_print_footer_scripts', array(
			$this,
			'admin_print_footer_scripts'
		), 100);
	}
	
	public function builder_markup($post) {
		$map_zoom = get_post_meta($post->ID, '_map_zoom', true);
		$map_zoom = absint($map_zoom);
		if(!$map_zoom) {
			$map_zoom = 12;
		}
		?> 
		<div id="mhm-map-builder-wrap">
			<?php wp_nonce_field('mhmmb_save_map', '_mhmmb_nonce'); ?>
			<div id="mhm-center-fields"></div>
			<div id="mhm-marker-fields"></div>
			<div id="mhm-map-builder-canvas">
				<div id="mhm-action-buttons">
					<div class="mhm-map-zoom">
						<label>
							<span>Zoom</span>
							<select id="mhmmb-zoom-field" name="mhmmb_zoom">
								<?php for($i = 1; $i <= 19; $i++ ): ?> 
								<option value="<?php echo $i; ?>" <?php selected( $i, $map_zoom, true ); ?> ><?php echo $i; ?></option>
								<?php endfor; ?>
							</select>
						</label>
					</div>
					<a id="mhm-set-center" class="button button-primary">Set Map Center</a>
					<a id="mhm-add-filter" class="button button-primary">Add Filter</a>
					<a id="mhm-add-marker" class="button button-primary">Add Marker</a>
					
					<a id="mhm-bdone" class="button button-secondary">Done</a>
					<a id="mhm-bcancel" class="button button-cancel">Cancel</a>
					
					<a id="mhm-mdone" class="button button-secondary">Done</a>
					<a id="mhm-mcancel" class="button button-cancel">Cancel</a>
					<div id="mhm-editor-form"></div>
				</div>
				<div id="mhm-filter-icons-wrapper">
					<div id="mhm-filter-icons"></div>
				</div>
				<div id="mhm-map-container">
				</div>
			</div>
		</div>
		<?php
		$this->admin_js_templates();
	}
		
	public function admin_js_templates() {
		?> 
		<script id="mhmbt-center-field" type="text/template">
			<div class="mhmn-fields-inner">
				<input type="hidden" name="mhmmb_center[lat]" value="<%= lat %>"/>
				<input type="hidden" name="mhmmb_center[lng]" value="<%= lng %>"/>
			</div>
		</script>
		<script id="mhmbt-filter-icon" type="text/template">
			<img src="<%= icon %>" alt="<%= label %>"/>
			<input type="hidden" name="mhmmb_filters[<%= index %>][name]" value="<%= name %>"/>
			<input type="hidden" name="mhmmb_filters[<%= index %>][label]" value="<%= label %>"/>
			<input type="hidden" name="mhmmb_filters[<%= index %>][icon]" value="<%= icon %>"/>
		</script>
		<script id="mhmbt-filter-form" type="text/template">
			<div class="mhmmb-filter-form-inner">
				<table>
					<tr>
						<td><label for="mhmmb-ff-name">Filter Slug</label></td>
						<td><input id="mhmmb-ff-name" type="text" value="<%= name %>"/></td
					</tr>
					<tr>
						<td><label for="mhmmb-ff-label">Filter Title</label></td>
						<td><input id="mhmmb-ff-label" type="text" value="<%= label%>"/></td
					</tr>
					<tr>
						<td><label for="mhmmb-ff-icon">Filter Icon</label></td>
						<td><input id="mhmmb-ff-icon" type="url" value="<%= icon %>"/><span class="mhmmb-upload">Upload</span></td
					</tr>
					<tr class="mhmmb-ff-buttons">
						<td></td>
						<td>
							<a id="mhm-filter-save" class="button button-secondary">Save</a>
							<a id="mhm-filter-delete" class="button button-delete">Delete</a>
							<a id="mhm-filter-cancel" class="button button-cancel">Cancel</a>
						</td
					</tr>
				</table>
			</div>
		</script>
		<script id="mhmbt-marker-form" type="text/template">
			<div class="mhmmb-marker-form-inner">
				<table>
					<tr>
						<td><label for="mhmmb-mf-filter">Filter</label></td>
						<td>
							<select id="mhmmb-mf-filter">
								<option value="">Select...</option>
							<% for(var i=0; i < filterdd.length; i++) { %>
								<option value="<%= filterdd[i].name %>" <% if(filterdd[i].name === filter){ %> selected="selected"<% } %>><%= filterdd[i].label %></option>
							<% } %>
						</td>
					</tr>
					<tr>
						<td><label for="mhmmb-mf-icon">Marker Icon</label></td>
						<td><input id="mhmmb-mf-icon" type="url" value="<%= icon %>"/><span class="mhmmb-upload">Upload</span></td
					</tr>
					<tr>
						<td><label for="mhmmb-mf-title">Title</label></td>
						<td><input id="mhmmb-mf-title" type="text" value="<%= title %>"/></td
					</tr>
					<tr>
						<td><label for="mhmmb-mf-order">Order</label></td>
						<td><input id="mhmmb-mf-order" type="text" value="<%= order %>"/></td
					</tr>
					<tr>
						<td><label for="mhmmb-mf-lat">Latitude</label></td>
						<td><input id="mhmmb-mf-lat" type="text" value="<%= lat %>"/></td
					</tr>
					<tr>
						<td><label for="mhmmb-mf-lng">Longitude</label></td>
						<td><input id="mhmmb-mf-lng" type="text" value="<%= lng %>"/></td
					</tr>
					<tr>
						<td><label for="mhmmb-mf-thumb">Marker Image</label></td>
						<td>
							<input class="mhmup-thumb" id="mhmmb-mf-thumb" type="hidden" value="<%= thumb %>"/>
							<input class="mhmup-full" id="mhmmb-mf-full-image" type="hidden" value="<%= full_image %>"/>
							<span class="mhmmb-upload thumb-full mhm-has-prev">Upload</span>
							<p class="mhmbb-upload-prev"><% if(thumb){ %><img alt="" src="<%= thumb %>"/><% } %></p>
						</td
					</tr>
					<tr>
						<td><label for="mhmmb-mf-text">Text</label></td>
						<td><textarea id="mhmmb-mf-text"><%= text %></textarea></td
					</tr>
					<tr>
						<td><label for="mhmmb-mf-cta-title">CTA title</label></td>
						<td><input id="mhmmb-mf-cta-title" type="text" value="<%= cta_title %>"/></td
					</tr>
					<tr>
						<td><label for="mhmmb-mf-cta-url">CTA URL</label></td>
						<td><input id="mhmmb-mf-cta-url" type="text" value="<%= cta_url %>"/></td
					</tr>
					<tr>
						<td><label for="mhmmb-mf-cta-nt">CTA New Tab</label></td>
						<td><input id="mhmmb-mf-cta-nt" type="checkbox" value="1" <% if(cta_nt === "yes"){ %>checked="checked"<% } %>/></td
					</tr>
					<tr class="mhmmb-f-buttons">
						<td></td>
						<td>
							<a id="mhm-marker-save" class="button button-secondary">Save</a>
							<a id="mhm-marker-delete" class="button button-delete">Delete</a>
							<a id="mhm-marker-cancel" class="button button-cancel">Cancel</a>
						</td
					</tr>
				</table>
			</div>
		</script>
		<script id="mhmbt-marker-field" type="text/template">
			<div class="mhmmb-fields-inner">
				<input type="hidden" name="mhmmb_markers[<%= index %>][lat]" value="<%= lat %>"/>
				<input type="hidden" name="mhmmb_markers[<%= index %>][lng]" value="<%= lng %>"/>
				<input type="hidden" name="mhmmb_markers[<%= index %>][order]" value="<%= order %>"/>
				<input type="hidden" name="mhmmb_markers[<%= index %>][filter]" value="<%= filter %>"/>
				<input type="hidden" name="mhmmb_markers[<%= index %>][icon]" value="<%= icon %>"/>
				<input type="hidden" name="mhmmb_markers[<%= index %>][title]" value="<%= title %>"/>
				<input type="hidden" name="mhmmb_markers[<%= index %>][thumb]" value="<%= thumb %>"/>
				<input type="hidden" name="mhmmb_markers[<%= index %>][full_image]" value="<%= full_image %>"/>
				<textarea style="display: none;" name="mhmmb_markers[<%= index %>][text]"><%= text %></textarea>
				<input type="hidden" name="mhmmb_markers[<%= index %>][cta_title]" value="<%= cta_title %>"/>
				<input type="hidden" name="mhmmb_markers[<%= index %>][cta_url]" value="<%= cta_url %>"/>
				<input type="hidden" name="mhmmb_markers[<%= index %>][cta_nt]" value="<%= cta_nt %>"/>
			</div>
		</script>
		<?php
	}
	public function admin_print_footer_scripts() {
		?> 
	<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo get_option('cr_map_api_key'); ?>&callback=MHMMBInitMap" async defer></script>
		<?php
	}
	
	public function save_metafields($post_id) {
		// Verify that the nonce is valid.
        if ( empty($_POST['_mhmmb_nonce']) || ! wp_verify_nonce( $_POST['_mhmmb_nonce'], 'mhmmb_save_map' ) ) {
            return $post_id;
        }
		/*
         * If this is an autosave, our form has not been submitted,
         * so we don't want to do anything.
         */
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }
		// Check the permision
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}
		
		$center_data = isset($_POST['mhmmb_center']) && is_array($_POST['mhmmb_center']) ? $_POST['mhmmb_center'] : '';
		$map_zoom = isset($_POST['mhmmb_zoom']) ? absint($_POST['mhmmb_zoom']) : 12;
		$filter_data = isset($_POST['mhmmb_filters']) && is_array($_POST['mhmmb_filters']) ? $_POST['mhmmb_filters'] : '';
		$markers_data = isset($_POST['mhmmb_markers']) && is_array($_POST['mhmmb_markers']) ? $_POST['mhmmb_markers'] : '';
		if($filter_data && count($filter_data) > 0){
			$filter_data = array_values($filter_data);
		}
		if($markers_data && count($markers_data) > 0){
			$markers_data = array_values($markers_data);
		}
		
		
		update_post_meta($post_id, '_map_center', $center_data);
		update_post_meta($post_id, '_map_zoom', $map_zoom);
		update_post_meta($post_id, '_map_filters', $filter_data);
		update_post_meta($post_id, '_map_markers', $markers_data);
		
	}

	/**
	 * Get the instance of CR_VCE_Manager
	 *
	 * @return self
	 */
	public static function get_instance() {
		
		if ( ! ( self::$_instance instanceof self ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
}

MHM_Map_builder::get_instance();