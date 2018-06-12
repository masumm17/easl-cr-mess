<?php

class CR_VcE_Sc_Two_Col_Content extends CR_VcE_Shortcode {
	private $max_floor_plans = 6;
	public function get_floorplans_data( $atts ) {
		$floorplans = array();
		if ( isset( $atts['floorplans'] ) && strlen( $atts['floorplans'] ) > 0 ) {
			$floorplans = vc_param_group_parse_atts( $atts['floorplans'] );
		}
		if(empty($floorplans)){
			$floorplans = array();
		}
		$parsed_floorplan_data = array();
		$count = 0;
		foreach($floorplans as $flp) {
			if(empty($flp['thumb'])){
				continue;
			}
			$thumb = wp_get_attachment_image_src( $flp['thumb'], 'full' );
			if(empty($thumb[0])) {
				continue;
			}
			$count++;
			$url = '';
			if(!empty($flp['url'])){
				$url = $this->parse_url($flp['url']);
			}else{
				$url = array( 'url' => $thumb[0], 'title' => '', 'target' => '', 'rel' => '' );
			}
			if( strlen($url['url']) > 0) {
				$parsed_floorplan_data[] = array(
					'thumb' => $thumb[0],
					'url' => $url['url'],
					'target' => $url['target'],
					'title' => $url['title'],
					'rel' => $url['rel'],
				);
			}
			if($count == $this->max_floor_plans){
				break;
			}
			
		}
		return $parsed_floorplan_data;
	}
	/**
	* Suggest amenities for autocomplete
	*
	* @since 2.1.0
	*/
	public static function autocomplete_suggest_amenities( $search_string ) {
	   $amenities = array();
	   $amenities_ids = get_posts( array(
		   'posts_per_page' => -1,
		   'post_type'      => CR_Custom_types::get_amenity_data('type'),
		   's'              => $search_string,
		   'fields'         => 'ids',
	   ) );
	   if ( ! empty( $amenities_ids ) ) {
		   foreach ( $amenities_ids as $id ) {
			   $amenities[] = array(
				   'label' => get_the_title( $id ),
				   'value' => $id,
			   );
		   }
	   }
	   wp_reset_postdata(); // is it really needed?
	   return $amenities;
	}

	/**
	* Suggest amenities for autocomplete
	*
	* @since 2.1.0
	*/
	public static function autocomplete_render_amenities( $data ) {
	   return array(
		   'label' => get_the_title( $data['value'] ),
		   'value' => $data['value'],
	   );
	}
	public function get_inlcluded_amenities($ids) {
		// Turn into array
		$ids  = preg_split( '/\,[\s]*/', $ids );
		$return = array();
		foreach( $ids as $id ) {
			$id = absint($id);
			if($id){
				$return[] = absint($id);
			}
		}

		// Return array
		return $return;
	}
}


// Get autocomplete suggestion
add_filter( 'vc_autocomplete_cr_two_col_content_amenity_ids_callback', array('CR_VcE_Sc_Two_Col_Content', 'autocomplete_suggest_amenities'), 10, 1 );

// Render autocomplete suggestions
add_filter( 'vc_autocomplete_cr_two_col_content_amenity_ids_render', array('CR_VcE_Sc_Two_Col_Content', 'autocomplete_render_amenities'), 10, 1 );