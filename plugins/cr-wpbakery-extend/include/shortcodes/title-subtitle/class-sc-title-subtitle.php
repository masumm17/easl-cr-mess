<?php

class CR_VcE_Sc_Title_Subtitle extends CR_VcE_Shortcode {
	/**
	 * Is h1 tag already used
	 * @var int
	 */
	private static $h1_tag_used = false;
	/**
	 * Set h1 tag used
	 */
	public static function get_element_tag($element_tag) {
		$element_tag = trim($element_tag);
		if(!in_array( $element_tag, array('h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div') )){
			$element_tag = 'h1';
		}
		if('h1' != $element_tag){
			return $element_tag;
		}
		if(self::$h1_tag_used){
			return 'h2';
		}
		self::$h1_tag_used = true;
		return 'h1';
	}
}