<?php

namespace tomjn\admin;

/**
 * Class MainController
 * @package tomjn\admin
 */
class MainController {

	private $assets;
	private $header;
	private $dash;

	/**
	 * @param AssetsController $assets
	 * @param MenuHeader       $header
	 */
	function __construct( AssetsController $assets, MenuHeader $header, MenuDash $dash ) {
		$this->assets = $assets;
		$this->header = $header;
		$this->dash = $dash;
	}

	/**
	 *
	 */
	public function run() {
		$this->assets->run();
		$this->header->run();
		$this->dash->run();
	}
}