<?php
if (!defined('ABSPATH')) die('-1');

GFForms::include_addon_framework();

class GFChevalRes extends GFAddOn {
	protected $_version = '1.0';
	protected $_min_gravityforms_version = '1.9.15.12';
	protected $_slug = 'gfchevres';
	protected $_path = 'cr-wpbakery-extend/include/third-party/gravity-form/class-gf-cheval-res.php';
	protected $_full_path = __FILE__;
	protected $_title = 'Gravity Forms Cheval Residence';
	protected $_short_title = 'GF CR';
	
	protected $form_id = null;
	protected $form_pages = null;

	private static $_instance = null;

	/**
	 * Get an instance of this class.
	 *
	 * @return GFSimpleAddOn
	 */
	public static function get_instance() {
		if ( self::$_instance == null ) {
			self::$_instance = new GFChevalRes();
		}

		return self::$_instance;
	}

	
	/**
	 * Handles anything which requires early initialization.
	 */
	public function pre_init() {
		parent::pre_init();

		if ( $this->is_gravityforms_supported() && class_exists( 'GF_Field' ) ) {
			require_once( 'fields/class-phone-field.php' );
		}
	}
	/**
	 * Handles hooks and loading of language files.
	 */
	public function init() {
		parent::init();
		
	}

	/**
	 * Initialize the admin specific hooks.
	 */
	public function init_admin() {
		
		// form editor
		add_action( 'gform_field_standard_settings', array( $this, 'field_settings' ), 10, 2 );
		add_filter( 'gform_tooltips', array( $this, 'tooltips' ) );
		add_filter( 'gform_entries_column_filter', array( $this, 'list_field_value'), 20, 4  );
		add_action( 'gform_editor_js_set_default_values', array( $this, 'default_js_values' ) );
		

		parent::init_admin();

	}

	//--------------  Script enqueuing  ---------------

	/**
	 * Override this function to provide a list of styles to be enqueued.
	 * When overriding this function, be sure to call parent::styles() to ensure the base class scripts are enqueued.
	 * See scripts() for an example of the format expected to be returned.
	 */
	public function styles() {
		return array(
			array(
				'handle'  => 'crgf_form_editor_css',
				'src'     => $this->get_base_url() . "/css/admin.css",
				'version' => $this->_version,
				'enqueue' => array(
					array( 'admin_page' => array( 'form_editor' ) ),
				)
			),
		);
	}

	// # SCRIPTS & STYLES -----------------------------------------------------------------------------------------------

	/**
	 * Return the scripts which should be enqueued.
	 *
	 * @return array
	 */
	public function scripts() {
		$scripts = array(
			
			array(
				'handle'   => 'crgf_form_editor_js',
				'src'      => $this->get_base_url() . '/js/admin.js',
				'version'  => $this->_version,
				'deps'     => array( 'jquery' ),
				'callback' => array( $this, 'localize_scripts' ),
				'enqueue'  => array(
					array( 'admin_page' => array( 'form_editor' ) ),
				),
			),

		);

		return array_merge( parent::scripts(), $scripts );
	}

	/**
	 * Localize the strings used by the scripts.
	 */
	public function localize_scripts() {
		
	}
	/**
	 * Add the tooltips for the Issue field.
	 *
	 * @param array $tooltips An associative array of tooltips where the key is the tooltip name and the value is the tooltip.
	 *
	 * @return array
	 */
	public function tooltips( $tooltips ) {
		$tooltips['form_field_cr_phone_default_country'] = '<h6>' . esc_html__( 'Default Country', 'crvc_extension' ) . '</h6>' . esc_html__( 'Select the country you would like to be selected by default when the form gets displayed..', 'crvc_extension' );
		
		return $tooltips;
	}

	/**
	 * Add the custom settings for the Issue fields to the fields general tab.
	 *
	 * @param int $position The position the settings should be located at.
	 * @param int $form_id The ID of the form currently being edited.
	 */
	public function field_settings( $position, $form_id ) {
		
		if ( $position == 25 ) {
			?> 
			<li class="cr_phone_default_country_setting field_setting">
				<label for="field_cr_phone_default_country" class="section_label">
					<?php esc_html_e( 'Default Country', 'crvc_extension' ); ?>
					<?php gform_tooltip( 'form_field_cr_phone_default_country' ) ?>
				</label>
				<select id="field_cr_phone_default_country" class="field_cr_phone_default_country" onchange="SetCRPhoneProperties();">
					<?php echo self::get_country_dropdown(); ?>
				</select>
			</li>
			<?php
		}
	}
	public function default_js_values() {
		?> 
		case "cr_phone" :
			if (!field.label){
				field.label = <?php echo json_encode( esc_html__( 'Phone', 'crvc_extension' ) ); ?>;
			}
			field.inputs = [new Input(field.id + '.2', <?php echo json_encode( esc_html__( 'Phone Number', 'crvc_extension' ) ); ?>), new Input(field.id + '.3', <?php echo json_encode( esc_html__( 'Country', 'crvc_extension' ) ); ?>)];
			break;
		<?php
	}
	
	
	public static function get_country_dropdown( $selected_country = '', $placeholder = '' ) {
		$str       = '';
		$countries = array_merge( array( '' ), self::get_countries() );
		foreach ( $countries as $code => $country ) {
			if ( is_numeric( $code ) ) {
				$code = $country;
			}
			if ( empty( $country ) ) {
				$country = $placeholder;
			}
			$selected = $code == $selected_country ? "selected='selected'" : '';
			$str .= "<option value='" . esc_attr( $code ) . "' $selected>" . esc_html( $country ) . '</option>';
		}

		return $str;
	}
	
	public function list_field_value($value, $form_id, $field_id, $entry) {
		$field = GFAPI::get_field( $form_id, $field_id );
		if($field->type != 'cr_phone') {
			return $value;
		}
		$country_value = trim( rgar( $entry, $field->id . '.3' ));
		$phone_value = trim( rgar( $entry, $field->id . '.2' ));
		$country_code = GFChevalRes::get_calling_code($country_value);
		if(!$phone_value) {
			return '';
		}
		$phone_number = $phone_value;
		if($country_code) {
			$phone_number = '+' . $country_code . $phone_value . '<br>('. GFChevalRes::get_country_name($country_value) .')';
		}
		return $phone_number;
	}


	public static function get_countries () {
		return array(
			"AF" => "Afghanistan (افغانستان)",
			"AL" => "Albania (Shqipëria)",
			"DZ" => "Algeria (الجزائر)",
			"AD" => "Andorra",
			"AO" => "Angola",
			"AI" => "Anguilla",
			"AG" => "Antigua and Barbuda",
			"AR" => "Argentina",
			"AM" => "Armenia (Հայաստան)",
			"AW" => "Aruba",
			"AU" => "Australia",
			"AT" => "Austria (Österreich)",
			"AZ" => "Azerbaijan (Azərbaycan)",
			"BS" => "Bahamas",
			"BH" => "Bahrain (البحرين)",
			"BD" => "Bangladesh (বাংলাদেশ)",
			"BB" => "Barbados",
			"BE" => "Belgium (België)",
			"BZ" => "Belize",
			"BJ" => "Benin (Bénin)",
			"BM" => "Bermuda",
			"BT" => "Bhutan (འབྲུག་ཡུལ)",
			"BO" => "Bolivia",
			"BA" => "Bosnia and Herzegovina (Bosna i Hercegovina)",
			"BW" => "Botswana",
			"BR" => "Brazil (Brasil)",
			"BN" => "Brunei (Brunei Darussalam)",
			"BG" => "Bulgaria (България)",
			"BF" => "Burkina Faso",
			"BI" => "Burundi (Uburundi)",
			"KH" => "Cambodia (Kampuchea)",
			"CM" => "Cameroon (Cameroun)",
			"CA" => "Canada",
			"CV" => "Cape Verde (Cabo Verde)",
			"KY" => "Cayman Islands",
			"CF" => "Central African Republic (République Centrafricaine)",
			"TD" => "Chad (Tchad)",
			"CL" => "Chile",
			"CN" => "China (中国)",
			"CO" => "Colombia",
			"KM" => "Comoros (Comores)",
			"CG" => "Congo",
			"CD" => "Congo; Democratic Republic of the",
			"CK" => "Cook Islands",
			"CR" => "Costa Rica",
			"HR" => "Croatia (Hrvatska)",
			"CU" => "Cuba",
			"CY" => "Cyprus (Κυπρος)",
			"CZ" => "Czech Republic (Česko)",
			"CI" => "Côte d'Ivoire",
			"DK" => "Denmark (Danmark)",
			"DJ" => "Djibouti",
			"DM" => "Dominica",
			"DO" => "Dominican Republic",
			"EC" => "Ecuador",
			"EG" => "Egypt (مصر)",
			"SV" => "El Salvador",
			"GQ" => "Equatorial Guinea (Guinea Ecuatorial)",
			"ER" => "Eritrea (Ertra)",
			"EE" => "Estonia (Eesti)",
			"ET" => "Ethiopia (Ityop'iya)",
			"FK" => "Falkland Islands",
			"FO" => "Faroe Islands",
			"FJ" => "Fiji",
			"FI" => "Finland (Suomi)",
			"FR" => "France",
			"GF" => "French Guiana",
			"PF" => "French Polynesia",
			"GA" => "Gabon",
			"GM" => "Gambia",
			"GE" => "Georgia (საქართველო)",
			"DE" => "Germany (Deutschland)",
			"GH" => "Ghana",
			"GI" => "Gibraltar",
			"GR" => "Greece (Ελλάς)",
			"GL" => "Greenland",
			"GD" => "Grenada",
			"GP" => "Guadeloupe",
			"GU" => "Guam",
			"GT" => "Guatemala",
			"GG" => "Guernsey",
			"GN" => "Guinea (Guinée)",
			"GW" => "Guinea-Bissau (Guiné-Bissau)",
			"GY" => "Guyana",
			"HT" => "Haiti (Haïti)",
			"HN" => "Honduras",
			"HK" => "Hong Kong",
			"HU" => "Hungary (Magyarország)",
			"IS" => "Iceland (Ísland)",
			"IN" => "India",
			"ID" => "Indonesia",
			"IR" => "Iran (ایران)",
			"IQ" => "Iraq (العراق)",
			"IE" => "Ireland",
			"IM" => "Isle of Man",
			"IL" => "Israel (ישראל)",
			"IT" => "Italy (Italia)",
			"JM" => "Jamaica",
			"JP" => "Japan",
			"JE" => "Jersey",
			"JO" => "Jordan (الاردن)",
			"KE" => "Kenya",
			"KW" => "Kuwait (الكويت)",
			"KG" => "Kyrgyzstan (Кыргызстан)",
			"LA" => "Laos (ນລາວ)",
			"LV" => "Latvia (Latvija)",
			"LB" => "Lebanon (لبنان)",
			"LS" => "Lesotho",
			"LR" => "Liberia",
			"LY" => "Libya (ليبيا)",
			"LI" => "Liechtenstein",
			"LT" => "Lithuania (Lietuva)",
			"LU" => "Luxembourg (Lëtzebuerg)",
			"MO" => "Macao",
			"MK" => "Macedonia (Македонија)",
			"MG" => "Madagascar (Madagasikara)",
			"MW" => "Malawi",
			"MY" => "Malaysia",
			"MV" => "Maldives (ގުޖޭއްރާ ޔާއްރިހޫމްޖ)",
			"ML" => "Mali",
			"MT" => "Malta",
			"MQ" => "Martinique",
			"MR" => "Mauritania (موريتانيا)",
			"MU" => "Mauritius",
			"MX" => "Mexico (México)",
			"MD" => "Moldova",
			"MC" => "Monaco",
			"MN" => "Mongolia (Монгол Улс)",
			"ME" => "Montenegro (Црна Гора)",
			"MS" => "Montserrat",
			"MA" => "Morocco (المغرب)",
			"MZ" => "Mozambique (Moçambique)",
			"NA" => "Namibia",
			"NR" => "Nauru (Naoero)",
			"NP" => "Nepal (नेपाल)",
			"NL" => "Netherlands (Nederland)",
			"AN" => "Netherlands Antilles",
			"NC" => "New Caledonia",
			"NZ" => "New Zealand",
			"NI" => "Nicaragua",
			"NE" => "Niger",
			"NG" => "Nigeria",
			"KP" => "North Korea (조선)",
			"NO" => "Norway (Norge)",
			"OM" => "Oman (عمان)",
			"PK" => "Pakistan (پاکستان)",
			"PS" => "Palestinian Territories",
			"PA" => "Panama (Panamá)",
			"PG" => "Papua New Guinea",
			"PY" => "Paraguay",
			"PE" => "Peru (Perú)",
			"PH" => "Philippines (Pilipinas)",
			"PL" => "Poland (Polska)",
			"PT" => "Portugal",
			"PR" => "Puerto Rico",
			"QA" => "Qatar (قطر)",
			"RE" => "Reunion",
			"RO" => "Romania (România)",
			"RU" => "Russia (Россия)",
			"RW" => "Rwanda",
			"KN" => "Saint Kitts and Nevis",
			"LC" => "Saint Lucia",
			"VC" => "Saint Vincent and the Grenadines",
			"WS" => "Samoa",
			"SM" => "San Marino",
			"SA" => "Saudi Arabia (المملكة العربية السعودية)",
			"SN" => "Senegal (Sénégal)",
			"RS" => "Serbia (Србија)",
			"SC" => "Seychelles",
			"SL" => "Sierra Leone",
			"SG" => "Singapore (Singapura)",
			"SK" => "Slovakia (Slovensko)",
			"SI" => "Slovenia (Slovenija)",
			"SO" => "Somalia (Soomaaliya)",
			"ZA" => "South Africa",
			"KR" => "South Korea (한국)",
			"ES" => "Spain (España)",
			"LK" => "Sri Lanka",
			"SD" => "Sudan (السودان)",
			"SR" => "Suriname",
			"SZ" => "Swaziland",
			"SE" => "Sweden (Sverige)",
			"CH" => "Switzerland (Schweiz)",
			"SY" => "Syria (سوريا)",
			"TW" => "Taiwan (台灣)",
			"TJ" => "Tajikistan (Тоҷикистон)",
			"TZ" => "Tanzania",
			"TH" => "Thailand (ราชอาณาจักรไทย)",
			"TL" => "Timor-Leste",
			"TG" => "Togo",
			"TO" => "Tonga",
			"TT" => "Trinidad and Tobago",
			"TN" => "Tunisia (تونس)",
			"TR" => "Turkey (Türkiye)",
			"TM" => "Turkmenistan (Türkmenistan)",
			"TC" => "Turks and Caicos Islands",
			"UG" => "Uganda",
			"UA" => "Ukraine (Україна)",
			"AE" => "United Arab Emirates (الإمارات العربيّة المتّحدة)",
			"GB" => "United Kingdom",
			"US" => "United States",
			"UY" => "Uruguay",
			"UZ" => "Uzbekistan (O'zbekiston)",
			"VU" => "Vanuatu",
			"VA" => "Vatican City (Città del Vaticano)",
			"VE" => "Venezuela",
			"VN" => "Vietnam (Việt Nam)",
			"VG" => "Virgin Islands; British",
			"VI" => "Virgin Islands; U.S.",
			"WF" => "Wallis and Futuna",
			"YE" => "Yemen (اليمن)",
			"ZM" => "Zambia",
			"ZW" => "Zimbabwe",
		);
	}
	public static function get_country_name($code) {
		$countries = self::get_countries();
		return isset($countries[$code]) ? $countries[$code] : '';
	}

	public static function get_calling_code($country_code) {
		$codes = array(
			'AD' => '376',
			'AE' => '971',
			'AF' => '93',
			'AG' => '1268',
			'AI' => '1264',
			'AL' => '355',
			'AM' => '374',
			'AN' => '599',
			'AO' => '244',
			'AQ' => '672',
			'AR' => '54',
			'AS' => '1684',
			'AT' => '43',
			'AU' => '61',
			'AW' => '297',
			'AZ' => '994',
			'BA' => '387',
			'BB' => '1246',
			'BD' => '880',
			'BE' => '32',
			'BF' => '226',
			'BG' => '359',
			'BH' => '973',
			'BI' => '257',
			'BJ' => '229',
			'BL' => '590',
			'BM' => '1441',
			'BN' => '673',
			'BO' => '591',
			'BR' => '55',
			'BS' => '1242',
			'BT' => '975',
			'BW' => '267',
			'BY' => '375',
			'BZ' => '501',
			'CA' => '1',
			'CC' => '61',
			'CD' => '243',
			'CF' => '236',
			'CG' => '242',
			'CH' => '41',
			'CI' => '225',
			'CK' => '682',
			'CL' => '56',
			'CM' => '237',
			'CN' => '86',
			'CO' => '57',
			'CR' => '506',
			'CU' => '53',
			'CV' => '238',
			'CX' => '61',
			'CY' => '357',
			'CZ' => '420',
			'DE' => '49',
			'DJ' => '253',
			'DK' => '45',
			'DM' => '1767',
			'DO' => '1809',
			'DZ' => '213',
			'EC' => '593',
			'EE' => '372',
			'EG' => '20',
			'ER' => '291',
			'ES' => '34',
			'ET' => '251',
			'FI' => '358',
			'FJ' => '679',
			'FK' => '500',
			'FM' => '691',
			'FO' => '298',
			'FR' => '33',
			'GA' => '241',
			'GB' => '44',
			'GD' => '1473',
			'GE' => '995',
			'GH' => '233',
			'GI' => '350',
			'GL' => '299',
			'GM' => '220',
			'GN' => '224',
			'GQ' => '240',
			'GR' => '30',
			'GT' => '502',
			'GU' => '1671',
			'GW' => '245',
			'GY' => '592',
			'HK' => '852',
			'HN' => '504',
			'HR' => '385',
			'HT' => '509',
			'HU' => '36',
			'ID' => '62',
			'IE' => '353',
			'IL' => '972',
			'IM' => '44',
			'IN' => '91',
			'IQ' => '964',
			'IR' => '98',
			'IS' => '354',
			'IT' => '39',
			'JM' => '1876',
			'JO' => '962',
			'JP' => '81',
			'KE' => '254',
			'KG' => '996',
			'KH' => '855',
			'KI' => '686',
			'KM' => '269',
			'KN' => '1869',
			'KP' => '850',
			'KR' => '82',
			'KW' => '965',
			'KY' => '1345',
			'KZ' => '7',
			'LA' => '856',
			'LB' => '961',
			'LC' => '1758',
			'LI' => '423',
			'LK' => '94',
			'LR' => '231',
			'LS' => '266',
			'LT' => '370',
			'LU' => '352',
			'LV' => '371',
			'LY' => '218',
			'MA' => '212',
			'MC' => '377',
			'MD' => '373',
			'ME' => '382',
			'MF' => '1599',
			'MG' => '261',
			'MH' => '692',
			'MK' => '389',
			'ML' => '223',
			'MM' => '95',
			'MN' => '976',
			'MO' => '853',
			'MP' => '1670',
			'MR' => '222',
			'MS' => '1664',
			'MT' => '356',
			'MU' => '230',
			'MV' => '960',
			'MW' => '265',
			'MX' => '52',
			'MY' => '60',
			'MZ' => '258',
			'NA' => '264',
			'NC' => '687',
			'NE' => '227',
			'NG' => '234',
			'NI' => '505',
			'NL' => '31',
			'NO' => '47',
			'NP' => '977',
			'NR' => '674',
			'NU' => '683',
			'NZ' => '64',
			'OM' => '968',
			'PA' => '507',
			'PE' => '51',
			'PF' => '689',
			'PG' => '675',
			'PH' => '63',
			'PK' => '92',
			'PL' => '48',
			'PM' => '508',
			'PN' => '870',
			'PR' => '1',
			'PT' => '351',
			'PW' => '680',
			'PY' => '595',
			'QA' => '974',
			'RO' => '40',
			'RS' => '381',
			'RU' => '7',
			'RW' => '250',
			'SA' => '966',
			'SB' => '677',
			'SC' => '248',
			'SD' => '249',
			'SE' => '46',
			'SG' => '65',
			'SH' => '290',
			'SI' => '386',
			'SK' => '421',
			'SL' => '232',
			'SM' => '378',
			'SN' => '221',
			'SO' => '252',
			'SR' => '597',
			'ST' => '239',
			'SV' => '503',
			'SY' => '963',
			'SZ' => '268',
			'TC' => '1649',
			'TD' => '235',
			'TG' => '228',
			'TH' => '66',
			'TJ' => '992',
			'TK' => '690',
			'TL' => '670',
			'TM' => '993',
			'TN' => '216',
			'TO' => '676',
			'TR' => '90',
			'TT' => '1868',
			'TV' => '688',
			'TW' => '886',
			'TZ' => '255',
			'UA' => '380',
			'UG' => '256',
			'US' => '1',
			'UY' => '598',
			'UZ' => '998',
			'VA' => '39',
			'VC' => '1784',
			'VE' => '58',
			'VG' => '1284',
			'VI' => '1340',
			'VN' => '84',
			'VU' => '678',
			'WF' => '681',
			'WS' => '685',
			'XK' => '381',
			'YE' => '967',
			'YT' => '262',
			'ZA' => '27',
			'ZM' => '260',
			'ZW' => '263',
		);
		return isset($codes[$country_code]) ? $codes[$country_code] : '';
	}
}
