<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
class CR_Sc_Full_Width_Grid_Item extends CR_Sc_base {
	public function __construct() {
		$this->tag = 'cr_full_width_grid_item';
		$this->path = plugin_dir_path(__FILE__);
		$this->sc_class_name = 'CR_VcE_Sc_Full_Width_Grid_Item';
		parent::__construct();
	}
}

new CR_Sc_Full_Width_Grid_Item();