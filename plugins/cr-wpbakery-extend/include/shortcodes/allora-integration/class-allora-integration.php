<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
class CR_Sc_Allora_Integration extends CR_Sc_base {
	public function __construct() {
		$this->tag = 'cr_allora_integration';
		$this->path = plugin_dir_path(__FILE__);
		$this->sc_class_name = 'CR_VcE_Sc_Allora_Integration';
		parent::__construct();
	}
}

new CR_Sc_Allora_Integration();