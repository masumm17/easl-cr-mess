<?php

class CR_VcE_Sc_Fixed_Width_Grid extends CR_VcE_Shortcode_Container {
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
		if(empty($atts['image']) || empty($atts['overlay_title'])){
			return false;
		}
		if( self::$items_count > 20 ){
			return false;
		}
		return true;
	}
}