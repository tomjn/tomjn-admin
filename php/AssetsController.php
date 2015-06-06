<?php

namespace tomjn\admin;

/**
 * Class AssetsController
 *
 * Sets up the Js and CSS needed for this plugin
 *
 * @package tomjn\admin
 */
class AssetsController {

	private $root_file='';

	/**
	 * @param $root_file string the root plugin __FILE__
	 */
	function __construct( $root_file ) {
		$this->root_file = $root_file;
	}

	public function run() {
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
	}

	public function admin_enqueue_scripts() {
		$admin_css_url = plugins_url('css/admin.css', $this->root_file );
		wp_enqueue_style( 'tomjn-admin', $admin_css_url );
	}
}