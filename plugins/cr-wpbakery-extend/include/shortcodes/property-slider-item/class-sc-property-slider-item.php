<?php

class CR_VcE_Sc_Property_Slider_Item extends CR_VcE_Shortcode {
	
	public function get_module_global_item_setting($key = false) {
		return isset(CR_VcE_Sc_Property_Slider::$module_global_item_settings[$key]) ? CR_VcE_Sc_Property_Slider::$module_global_item_settings[$key] : '';
	}
	/**
	 * @param $atts
	 * @param null $content
	 *
	 * @return mixed|void
	 */
	protected function _hide_content( $atts, $content = null ) {
		if(!CR_VcE_Sc_Property_Slider::pass_item_restriction($atts, $content)) {
			return '';
		}
		return parent::content( $atts, $content );
	}
}