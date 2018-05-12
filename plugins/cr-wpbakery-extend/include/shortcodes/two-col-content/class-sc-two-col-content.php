<?php

class CR_VcE_Sc_Two_Col_Content extends CR_VcE_Shortcode {
	private $max_floor_plans = 3;
	public function get_floorplans_data( $atts ) {
		$floorplans = array();
		if ( isset( $atts['floorplans'] ) && strlen( $atts['floorplans'] ) > 0 ) {
			$floorplans = vc_param_group_parse_atts( $atts['floorplans'] );
		}
		if(empty($floorplans)){
			$floorplans = array();
		}
		$parsed_floorplan_data = array();
		$count = 0;
		foreach($floorplans as $flp) {
			if(empty($flp['thumb'])){
				continue;
			}
			$thumb = wp_get_attachment_image_src( $flp['thumb'], 'full' );
			if(empty($thumb[0])) {
				continue;
			}
			$count++;
			$url = '';
			if(!empty($flp['url'])){
				$url = $this->parse_url($flp['url']);
			}
			if( strlen($url['url']) > 0) {
				$parsed_floorplan_data[] = array(
					'thumb' => $thumb[0],
					'url' => $flp['url'],
					'target' => $flp['target'],
					'title' => $flp['title'],
					'rel' => $flp['rel'],
				);
			}
			if($count == $this->max_floor_plans){
				break;
			}
			
		}
		return $parsed_floorplan_data;
	}
}