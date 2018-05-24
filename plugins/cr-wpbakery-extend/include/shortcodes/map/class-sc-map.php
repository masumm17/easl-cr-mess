<?php

class CR_VcE_Map extends CR_VcE_Shortcode {
	public function get_map_json_data() {
		$map_data = get_option('cr_map_data');
		return $map_data;
	}
}