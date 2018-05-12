<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

abstract class CR_Sc_base {
	/**
	 * Shortcode tag name
	 * @var string
	 */
	protected $tag;
	/**
	 * Shrotcode path
	 * @var string
	 */
	protected $path;
	/**
	 * Shortcode class name
	 * @var string
	 */
	protected $sc_class_name;
	
	public function __construct() {
		$this->autoload_files();
		$this->lean_map();
	}

	/**
	 * VC lean map for this shortcode
	 */
	public function lean_map() {
		vc_lean_map($this->tag, null, $this->path . 'map.php');
	}
	
	/**
	 * Get class file path
	 */
	public function get_class_path() {
		$file_name = str_replace('CR_VcE_', '', $this->sc_class_name);
		$file_name = strtolower($file_name);
		$file_name = str_replace('_', '-', $file_name);
		return $this->path . 'class-' . $file_name . '.php';
	}
	/**
	 * Auto load shortcode main class file
	 */
	public function autoload_files() {
		require_once $this->get_class_path();
	}
	
}