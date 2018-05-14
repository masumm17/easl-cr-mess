<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
class CR_Sc_Full_Width_Grid extends CR_Sc_base {
	public function __construct() {
		$this->tag = 'cr_full_width_grid';
		$this->path = plugin_dir_path(__FILE__);
		$this->sc_class_name = 'CR_VcE_Sc_Full_Width_Grid';
		parent::__construct();
	}
}

new CR_Sc_Full_Width_Grid();