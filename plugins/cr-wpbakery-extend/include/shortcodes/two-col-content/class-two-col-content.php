<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
class CR_Sc_Two_Col_Content extends CR_Sc_base {
	public function __construct() {
		$this->tag = 'cr_two_col_content';
		$this->path = plugin_dir_path(__FILE__);
		$this->sc_class_name = 'CR_VcE_Sc_Two_Col_Content';
		parent::__construct();
	}
}

new CR_Sc_Two_Col_Content();