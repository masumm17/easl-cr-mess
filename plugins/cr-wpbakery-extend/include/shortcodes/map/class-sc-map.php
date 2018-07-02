<?php

class CR_VcE_Sc_Map extends CR_VcE_Shortcode {
	private $map_data = false;
	static private $map_instance_count = 0;
	
	public function get_instance_count() {
		return self::$map_instance_count;
	}
	public function get_api_key() {
		return get_option('cr_map_api_key');
	}
	public function get_map_data() {
		return $this->map_data;
	}
	public function set_map_data($post_id) {
		$map_api_key = get_option('cr_map_api_key');
		if(!$map_api_key){
			return false;
		}
		
		$map_center = get_post_meta($post_id, '_map_center', true);
		$map_zoom = get_post_meta($post_id, '_map_zoom', true);
		$map_filters = get_post_meta($post_id, '_map_filters', true);
		$map_markers = get_post_meta($post_id, '_map_markers', true);
		
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
		if(empty($map_center) || empty($map_markers) || count($map_markers) === 0) {
			return false;
		}
		
		$this->map_data =  array(
			'center' => $map_center,
			'zoom' => $map_zoom,
			'filters' => $map_filters,
			'markers' => $map_markers,
		);
		return true;
	}
	
	/**
	 * @param $atts
	 * @param null $content
	 *
	 * @return mixed|void
	 */
	protected function content( $atts, $content = null ) {
		$map = !empty($atts['map']) ? get_post($atts['map']) : false;
		
		if(!$map) {
			return '';
		}
		if(!$this->set_map_data($map->ID)){
			return '';
		}
		self::$map_instance_count++;
		return parent::content( $atts, $content );
	}
}