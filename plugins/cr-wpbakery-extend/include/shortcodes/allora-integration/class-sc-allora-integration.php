<?php

class CR_VcE_Sc_Allora_Integration extends CR_VcE_Shortcode {
	
	public function get_allora_settings() {
		
		$allora_settings = array(
			'url' => get_option('cr_allora_url'),
			'template' => get_option('cr_allora_template'),
			'client_type' => get_option('cr_allora_client_type'),
			'client_id' => get_option('cr_allora_client_id'),
			'limit' => get_option('cr_allora_limit'),
		);
		
		if(!$allora_settings['template']) {
			$allora_settings['template'] = 'Custom';
		}
		if(!$allora_settings['client_type']) {
			$allora_settings['client_type'] = 'portal';
		}
		if(!$allora_settings['limit']) {
			$allora_settings['limit'] = 3;
		}

		return $allora_settings;
	}
}