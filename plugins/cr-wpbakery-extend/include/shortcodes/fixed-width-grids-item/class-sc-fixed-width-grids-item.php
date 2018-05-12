<?php

class CR_VcE_Sc_Fixed_Width_Grids_Item extends CR_VcE_Shortcode {
		/**
		 * @param $atts
		 * @param null $content
		 *
		 * @return mixed|void
		 */
		protected function content( $atts, $content = null ) {
//			if(!CR_VcE_Sc_Property_Slider::pass_item_restriction($atts, $content)) {
//				return '';
//			}
			return parent::content( $atts, $content );
		}
}