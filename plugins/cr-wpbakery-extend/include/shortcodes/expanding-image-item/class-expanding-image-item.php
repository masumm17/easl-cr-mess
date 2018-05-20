<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
class CR_Sc_Expanding_Image_Item extends CR_Sc_base {
	public function __construct() {
		$this->tag = 'cr_expanding_image_item';
		$this->path = plugin_dir_path(__FILE__);
		$this->sc_class_name = 'CR_VcE_Sc_Expanding_Image_Item';
		parent::__construct();
	}
}

new CR_Sc_Expanding_Image_Item();