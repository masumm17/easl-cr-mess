<?php
if (!defined('ABSPATH')) die('-1');

class CR_GF_Phone_Field extends GF_Field {
	public $type = 'cr_phone';
	
	public function get_form_editor_field_title() {
		return esc_attr__( 'CR Phone', 'crvc_extension' );
	}
	public function get_form_editor_button() {
		return array(
			'group' => 'advanced_fields',
			'text'  => $this->get_form_editor_field_title()
		);
	}
	function get_form_editor_field_settings() {
		return array(
			'conditional_logic_field_setting',
			'prepopulate_field_setting',
			'error_message_setting',
			'label_setting',
			'label_placement_setting',
			'admin_label_setting',
			'rules_setting',
			'visibility_setting',
			'duplicate_setting',
			'default_value_setting',
			'description_setting',
			'css_class_setting',
			'cr_phone_default_country_setting'
		);
	}
	
	public function is_conditional_logic_supported() {
		return true;
	}
	
	function validate( $value, $form ) {

		if ( $this->isRequired ) {
			$phone_number = trim(rgpost( 'input_' . $this->id . '_2' ));
			$phone_number_val = str_replace( ' ', '', $phone_number );
			if ( empty( $phone_number ) ) {
				$this->failed_validation  = true;
				$this->validation_message = empty( $this->errorMessage ) ? esc_html__( 'This field is required. Please enter a valid phone number.', 'crvc_extension' ) : $this->errorMessage;
			}elseif ( empty($phone_number_val) || !preg_match('/^\d+$/',$phone_number_val) ) {
				$this->failed_validation  = true;
				$this->validation_message = empty( $this->errorMessage ) ? esc_html__( 'Invalid phone number. Please enter a valid phone number.', 'crvc_extension' ) : $this->errorMessage;
			}
			
		}
	}
	
	public function get_field_input( $form, $value = '', $entry = null ) {
		$form_id         = absint( $form['id'] );
		$is_entry_detail = $this->is_entry_detail();
		$is_form_editor  = $this->is_form_editor();

		$html_input_type = 'text';


		$logic_event = ! $is_form_editor && ! $is_entry_detail ? $this->get_conditional_logic_event( 'keyup' ) : '';
		$id          = (int) $this->id;
		$field_id    = $is_entry_detail || $is_form_editor || $form_id == 0 ? "input_$id" : 'input_' . $form_id . "_$id";

		$size         = $this->size;
		$class_suffix = $is_entry_detail ? '_admin' : '';

		$max_length = is_numeric( $this->maxLength ) ? "maxlength='{$this->maxLength}'" : '';

		$disabled_text         = $is_form_editor ? 'disabled="disabled"' : '';
		$placeholder_attribute = $this->get_field_placeholder_attribute();
		$required_attribute    = $this->isRequired ? 'aria-required="true"' : '';
		$invalid_attribute     = $this->failed_validation ? 'aria-invalid="true"' : 'aria-invalid="false"';
		
		$country = '';
		$phone  = '';

		if ( is_array( $value ) ) {
			$country = esc_attr( GFForms::get( $this->id . '.3', $value ) );
			$phone  = esc_attr( GFForms::get( $this->id . '.2', $value ) );
		}
		if ( empty( $country ) ) {
			$country = $this->defaultCountry;
		}
		$country_input = GFFormsModel::get_input( $this, $this->id . '.3' );
		$phone_input  = GFFormsModel::get_input( $this, $this->id . '.2' );
		$country_tabindex = GFCommon::get_tabindex();
		$phone_tabindex  = GFCommon::get_tabindex();
		
		$countries_markup = '';
		$phone_number_markup = '';
		$country_dropdown = GFChevalRes::get_country_dropdown($country);
		$countries_markup = "<span id='{$field_id}_3_container' class='cr_phone_country'>
								<select name='input_{$id}.3' id='input_{$id}_3' {$country_tabindex} {$disabled_text}>{$country_dropdown}</select>
							</span>";
		$phone_number_markup = "<span id='{$field_id}_2_container' class='cr_phone_number'>
								<input name='input_{$id}.2' id='{$field_id}_2' type='text' value='{$phone}' {$max_length} {$phone_tabindex} {$logic_event} {$placeholder_attribute} {$required_attribute} {$invalid_attribute} {$disabled_text}/>
							</span>";

		return "<div class='ginput_complex{$class_suffix} ginput_container ginput_container_cr_phone' id='{$field_id}'>
					{$countries_markup}
					{$phone_number_markup}
					<div class='gf_clear gf_clear_complex'></div>
                </div>";
	}
	public function get_value_entry_detail( $value, $currency = '', $use_text = false, $format = 'html', $media = 'screen' ) {
		if ( !is_array( $value ) || empty( $value ) ) {
			return '';
		}
		$country_value = trim( $value[ $this->id . '.3' ] );
		$phone_value = trim( $value[ $this->id . '.2' ] );
		$country_code = GFChevalRes::get_calling_code($country_value);
		if(!$phone_value) {
			return '';
		}
		$phone_number = $phone_value;
		if($country_code) {
			$phone_number = $country_code . $phone_value;
		}
		return '<a href="tel: '. $phone_number .'">+' . $phone_number . '</a><br>('.GFChevalRes::get_country_name($country_value).')';
	}
	public function get_value_export($entry, $input_id = '', $use_text = false, $is_csv = false) {
		if ( empty( $input_id ) ) {
			$input_id = $this->id;
		}
		if ( absint( $input_id ) == $input_id ) {
			$country_value  = str_replace( '  ', ' ', trim( rgar( $entry, $input_id . '.3' ) ) );
			$phone_value = str_replace( '  ', ' ', trim( rgar( $entry, $input_id . '.2' ) ) );
			if(!$phone_value) {
				return '';
			}
			$phone_number = $phone_value;
			if($country_code) {
				$phone_number = $country_code . $phone_value;
			}
			return $phone_number;
		} elseif($input_id == $this->id . '.3'){
			$country_value  = str_replace( '  ', ' ', trim( rgar( $entry, $this->id . '.3' ) ) );
			return GFChevalRes::get_country_name($country_value);
		} elseif($input_id == $this->id . '.2'){
			$country_value  = str_replace( '  ', ' ', trim( rgar( $entry, $this->id . '.3' ) ) );
			$phone_value = str_replace( '  ', ' ', trim( rgar( $entry, $this->id . '.2' ) ) );
			if(!$phone_value) {
				return '';
			}
			$phone_number = $phone_value;
			if($country_code) {
				$phone_number = $country_code . $phone_value;
			}
			return $phone_number;
		}else {

			return rgar( $entry, $input_id );
		}
	}
}

GF_Fields::register( new CR_GF_Phone_Field() );