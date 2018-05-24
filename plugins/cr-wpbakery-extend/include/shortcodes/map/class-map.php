<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
class CR_Sc_Map extends CR_Sc_base {
	public function __construct() {
		$this->tag = 'cr_map';
		$this->path = plugin_dir_path(__FILE__);
		$this->sc_class_name = 'CR_VcE_Map';
		parent::__construct();
	}
}

new CR_Sc_Map();