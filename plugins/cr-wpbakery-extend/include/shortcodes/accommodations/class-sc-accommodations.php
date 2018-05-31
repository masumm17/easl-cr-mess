<?php

class CR_VcE_Sc_Accommodations extends CR_VcE_Shortcode {
	public function get_terms_posts_id($term_id, $taxonomy) {
		$args = array(
			'post_type' => 'accommodation',
			'posts_per_page' => -1,
			'fields' => 'ids',
			'tax_query' => array(
				array(
					'taxonomy' => $taxonomy,
					'field' => 'term_id',
					'terms' => $term_id,
					//'operator' => '=',
				)
			),
		);
		$accomodation_ids = get_posts($args);
		if(!$accomodation_ids) {
			$accomodation_ids = array();
		}
		return array_map('absint', $accomodation_ids);
	}
	/*
	 * Get Term list
	 */
	public static function get_accommodations_filter($taxonomy) {
		$terms = get_terms( array(
			'taxonomy' => $taxonomy,
			'hide_empty' => true,
		) );
		if( is_wp_error($terms)){
			return '';
		}
		switch($taxonomy) {
			case 'accommodation_location':
				$taxonomy_jsname = 'location';
				break;
			case 'accommodation_room_type':
				$taxonomy_jsname = 'roomtype';
				break;
			case 'accommodation_amenity':
				$taxonomy_jsname = 'amenity';
				break;
		}
		$list = '';
		foreach($terms as $term) {
			$term_post_ids = self::get_terms_posts_id($term->term_id, $taxonomy);
			$list .= '<li data-id="'. $term->term_id .'" data-ids="'. esc_attr( implode( ',', $term_post_ids )) .'" data-taxonomy="'. esc_attr($taxonomy_jsname) .'">'. $term->name .'</li>';
		}
		return $list;
	}
	/**
	 * Get accommodations
	 */
	public static function get_accommodations() {
		$args = array(
			'post_type' => 'accommodation',
			'posts_per_page' => -1,
		);
		//tax_query
		$tax_query = array();
		if(isset($_REQUEST['acmf_location']) && is_array($_REQUEST['acmf_location']) && count($_REQUEST['acmf_location']) > 0) {
			$tax_query[] = array(
				'taxonomy' => 'accommodation_location',
				'field' => 'term_id',
				'terms' => $_REQUEST['acmf_location'],
				'operator' => 'IN',
			);
		}
		if(isset($_REQUEST['acmf_room_type']) && is_array($_REQUEST['acmf_room_type']) && count($_REQUEST['acmf_room_type']) > 0) {
			$tax_query[] = array(
				'taxonomy' => 'accommodation_room_type',
				'field' => 'term_id',
				'terms' => $_REQUEST['acmf_room_type'],
				'operator' => 'IN',
			);
		}
		if(isset($_REQUEST['acmf_amenities']) && is_array($_REQUEST['acmf_amenities']) && count($_REQUEST['acmf_amenities']) > 0) {
			$tax_query[] = array(
				'taxonomy' => 'accommodation_amenity',
				'field' => 'term_id',
				'terms' => $_REQUEST['acmf_amenities'],
				'operator' => 'IN',
			);
		}
		if(count($tax_query) > 0) {
			$tax_query['relation'] = 'AND';
			$args['tax_query'] = $tax_query;
		}
		$accomodation_query = new WP_Query($args);
		if(!$accomodation_query->have_posts()){
			return '<li class="cr-not-found">'. __('No accommodation found!', 'crvc_extension') .'</li>';
		}
		$output = '';
		while ($accomodation_query->have_posts()){
			$accomodation_query->the_post();
			ob_start();
			include cr_get_template_dir('partials/accommodation.php');
			$output .= ob_get_clean();
		}
		wp_reset_postdata();
		return trim($output);
	}
	
	public static function ajax_filter_request() {
		$html = self::get_accommodations();
		if(!$html) {
			wp_send_json(array(
				'status' => 'NOTOK', 
				'msg' => '<li class="accommodations-item-notfound">' . __('No accomodations found!', 'crvc_extension') . '</li>',
			));
		}
		wp_send_json(array(
			'status' => 'OK', 
			'html' => $html,
		));
	}
}

add_action('wp_ajax_cr_get_accommodations', array('CR_VcE_Sc_Accommodations', 'ajax_filter_request'));
add_action('wp_ajax_nopriv_cr_get_accommodations', array('CR_VcE_Sc_Accommodations', 'ajax_filter_request'));