<?php

class CR_VcE_Sc_Property_Slider extends CR_VcE_Shortcode_Container {
	/**
	 * Count number of items
	 * @var int
	 */
	public static $items_count = 0;
	/**
	 * Save contains item data
	 * @var array
	 */
	public static $items_data = array();
	
	public static $data = array();
	
	public static $module_global_item_settings;



	public function load_settings() {
		$this->module_settings = array(
			'title_length' => (int)get_option('property_slider_title_length'),
			'subtitle_length' => (int)get_option('property_slider_subtitle_length'),
			'content_length' => (int)get_option('property_slider_content_length'),
		);
		self::$module_global_item_settings = $this->module_settings;
	}
	/**
	 * Reset Items data
	 */
	public function reset_items_data() {
		self::$items_count = 0;
		self::$items_data = array();
		self::$data = array();
	}
	public static function pass_item_restriction($atts, $content=null) {
		if(empty($atts['image']) || empty($atts['overlay_title']) || empty($atts['cta_button']) || empty($content)){
			return false;
		}
		if( self::$items_count > 20 ){
			return false;
		}
		return true;
	}
}