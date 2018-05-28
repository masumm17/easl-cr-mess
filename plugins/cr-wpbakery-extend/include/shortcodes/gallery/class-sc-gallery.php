<?php

class CR_VcE_Sc_Gallery extends CR_VcE_Shortcode_Container {
	
	public static $count_instance = 0;
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
	
	/**
	 * Reset Items data
	 */
	public function reset_items_data() {
		self::$items_count = 0;
		self::$items_data = array();
		self::$data = array();
	}
	public static function pass_item_restriction($atts, $content=null) {
		if( empty($atts['image']) || empty($atts['lightbox_title']) ){
			return false;
		}
		if( self::$items_count > 100 ){
			return false;
		}
		return true;
	}
	public function enqueue_scritps() {
		//wp_enqueue_script('isotope');
	}
}