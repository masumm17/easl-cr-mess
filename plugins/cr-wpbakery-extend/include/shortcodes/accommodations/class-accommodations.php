<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
class CR_Sc_Accommodations extends CR_Sc_base {
	public function __construct() {
		$this->tag = 'cr_accommodations';
		$this->path = plugin_dir_path(__FILE__);
		$this->sc_class_name = 'CR_VcE_Sc_Accommodations';
		parent::__construct();
	}
}

new CR_Sc_Accommodations();