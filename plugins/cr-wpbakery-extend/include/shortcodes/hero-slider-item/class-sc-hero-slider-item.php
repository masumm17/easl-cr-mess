<?php

class CR_VcE_Sc_Hero_Slider_Item extends CR_VcE_Shortcode {
		public function get_image_src($attachment_id, $size = 'cr_default') {
			$attachment_src = wp_get_attachment_image_src($attachment_id, $size);
			return !empty($attachment_src) ? $attachment_src[0] : '';
		}

		/**
		 * @param $atts
		 * @param $content
		 *
		 * @return string
		 */
		public function contentAdmin2( $atts, $content = null ) {
			$output = $custom_markup = $width = $el_position = '';
			if ( null !== $content ) {
				$content = wpautop( stripslashes( $content ) );
			}
			$shortcode_attributes = array( 'width' => '1/3' );
			$atts = vc_map_get_attributes( $this->shortcode, $atts ) + $shortcode_attributes;
			$this->atts = $atts;
			$elem = $this->getElementHolder( $width );
			$inner = $this->outputTitle( $this->settings['name'] );
			$inner .= $this->paramsHtmlHolders( $atts );
			$elem = str_ireplace( '%wpb_element_content%', $inner, $elem );
			$output .= $elem;

			return $output;
		}

		/**
		 * @param $atts
		 *
		 * @return string
		 */
		protected function paramsHtmlHolders2( $atts ) {
			$inner = '';
			
			$inner = '<div class="cr-hero-slider-item-thumb>Video/Image thumb</div>';

			return $inner;
		}

		/**
		 * @param $title
		 *
		 * @return string
		 */
		protected function outputTitle2( $title ) {
			return '<h4 class="wpb_element_title"> ' . esc_attr( $title ) . '</h4>';
		}
		/**
		 * @param $atts
		 * @param null $content
		 *
		 * @return mixed|void
		 */
		protected function content( $atts, $content = null ) {
			$type = !empty($atts['type']) ? $atts['type'] : 'image';
			if('video' == $type && 0 < CR_VcE_Sc_Hero_Slider::item_type_count($type)) {
				return '';
			}
			if(CR_VcE_Sc_Hero_Slider::$items_count > 6){
				return '';
			}
			return parent::content( $atts, $content );
		}
}