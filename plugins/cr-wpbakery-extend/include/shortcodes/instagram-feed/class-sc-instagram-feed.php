<?php

class CR_VcE_Sc_Instagram_Feed extends CR_VcE_Shortcode {
	static $instance_count = 0;
	
	public function get_instance_count() {
		return self::$instance_count;
	}
}