<?php

class CR_VcE_Sc_Single_Col_Content extends CR_VcE_Shortcode {
	public function get_buttons_data( $atts ) {
		$buttons = array();
		if ( isset( $atts['buttons'] ) && strlen( $atts['buttons'] ) > 0 ) {
			$buttons = vc_param_group_parse_atts( $atts['buttons'] );
		}
		if(empty($buttons)){
			$buttons = array();
		}
		$parsed_button_data = array();
		foreach($buttons as $btn) {
			if(empty($btn['button'])){
				continue;
			}
			$p_link = $this->parse_url($btn['button']);
			if( strlen($p_link['url']) > 0) {
				$parsed_button_data[] = $p_link;
			}
			
		}
		return $parsed_button_data;
	}
}