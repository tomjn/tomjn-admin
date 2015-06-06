<?php

namespace tomjn\admin;

/**
 * Class MainController
 * @package tomjn\admin
 */
class MainController {

	private $assets;
	private $header;

	/**
	 * @param AssetsController $assets
	 * @param MenuHeader       $header
	 */
	function __construct( AssetsController $assets, MenuHeader $header ) {
		$this->assets = $assets;
		$this->header = $header;
	}

	/**
	 *
	 */
	public function run() {
		$this->assets->run();
		$this->header->run();
	}
}