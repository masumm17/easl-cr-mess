<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

trait CR_VcE_Common_Metods {
	protected $module_settings;
	/**
	* @return mixed
	*/
	protected function getFileName() {
		$file_name = str_replace('cr_', '', $this->shortcode);
		$file_name = strtolower($file_name);
		return str_replace( '_', '-', $file_name );
	}
	public function load_settings() {
		// Inidividual module can set
	}
	public function get_module_setting($key = false) {
		return isset($this->module_settings[$key]) ? $this->module_settings[$key] : '';
	}
	/**
	* Find html template for shortcode output.
	*/
	protected function findShortcodeTemplate() {
		// Check template path in shortcode's mapping settings
		if ( ! empty( $this->settings['html_template'] ) && is_file( $this->settings( 'html_template' ) ) ) {
			return $this->setTemplate( $this->settings['html_template'] );
		}

		// Check template in theme directory
		$user_template = vc_shortcodes_theme_templates_dir( $this->getFileName() . '.php' );
		if ( is_file( $user_template ) ) {
			return $this->setTemplate( $user_template );
		}
		// Check plugin dir
		$template_dir = cr_get_template_dir('shortcodes/');
		if ( is_file( $template_dir . $this->getFileName() . '.php' ) ) {
			return $this->setTemplate( $template_dir . $this->getFileName() . '.php' );
		}
		// Check default place
		$default_dir = vc_manager()->getDefaultShortcodesTemplatesDir() . '/';
		if ( is_file( $default_dir . $this->getFileName() . '.php' ) ) {
			return $this->setTemplate( $default_dir . $this->getFileName() . '.php' );
		}

		return '';
	}
	/**
	 * @param $atts
	 * @param null $content
	 *
	 * @return mixed|void
	 */
	protected function content( $atts, $content = null ) {
		$disabled = !empty($atts['sc_disabled']) ? $atts['sc_disabled'] : 'no';
		if('yes' == $disabled ) {
			return '';
		}
		return parent::content( $atts, $content );
	}
	
	public function parse_url($link) {
		//parse link
		$link = ( '||' === $link ) ? '' : $link;
		return vc_build_link( $link );
	}
}

class CR_VcE_Shortcode extends WPBakeryShortCode {
	use CR_VcE_Common_Metods;
	
	public function __construct( $settings ) {
		$this->load_settings();
		parent::__construct( $settings );
	}
	
}


class CR_VcE_Shortcode_Container extends WPBakeryShortCodesContainer {
	use CR_VcE_Common_Metods;
	
	public function __construct( $settings ) {
		$this->load_settings();
		parent::__construct( $settings );
	}
}