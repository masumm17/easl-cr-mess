<?php

class CR_VcE_Sc_Mini_Grid_Gallery extends CR_VcE_Shortcode {
	
	private $max_images = 10;
	
	public static $count_instance = 0;


	

	public function load_settings() {
		$this->module_settings = array(
			'speed' => get_option('mini_grid_gallery_speed'),
			'transition' => get_option('mini_grid_gallery_transition'),
			'pagination' => get_option('mini_grid_gallery_pagination'),
		);
	}
	
	public function get_iamges_data($images) {
		if(empty($images)) {
			return '';
		}
		$images = explode(',', $images);
		$images_data = array();
		foreach ( $images as $i => $image ) {
			$image = preg_replace( '/[^\d]/', '', $image );
			$img_src = wp_get_attachment_image_src($image, 'fw1-2_col1-3_x');
			if(!$img_src) {
				continue;
			}
			$img_full_src = wp_get_attachment_image_src($image, 'full');
			$images_data[] = array(
				'src' => $img_src[0],
				'full' => $img_full_src[0],
			);
		}
		return $images_data;
	}
	
}