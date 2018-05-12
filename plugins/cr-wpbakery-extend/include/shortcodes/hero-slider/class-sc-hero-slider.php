<?php

class CR_VcE_Sc_Hero_Slider extends CR_VcE_Shortcode_Container {
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
	/**
	 * Get item type count
	 * @param string $type
	 */
	public static function item_type_count($type) {
		$types = array_column(self::$items_data, 'type');
		$type_count = array_count_values($types);
		if(isset($type_count[$type])) {
			return $type_count[$type];
		}
		return 0;
	}
}