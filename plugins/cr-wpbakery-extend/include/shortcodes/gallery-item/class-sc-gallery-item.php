<?php

class CR_VcE_Sc_Gallery_Item extends CR_VcE_Shortcode {
	
	public function get_buttons_data( $buttn_att ) {
		$buttons = array();
		if ( $buttn_att && strlen( $buttn_att ) > 0 ) {
			$buttons = vc_param_group_parse_atts( $buttn_att );
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
		/**
		 * @param $atts
		 * @param null $content
		 *
		 * @return mixed|void
		 */
		protected function content( $atts, $content = null ) {
			if(!CR_VcE_Sc_Gallery::pass_item_restriction($atts, $content)) {
				return '';
			}
			return parent::content( $atts, $content );
		}
}