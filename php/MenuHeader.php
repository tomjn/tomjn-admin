<?php

namespace tomjn\admin;

/**
 * Class MenuHeader
 * @package tomjn\admin
 */
class MenuHeader {

	/**
	 *
	 */
	function __construct() {
		//
	}

	/**
	 *
	 */
	public function run() {
		add_action( 'adminmenu', array( $this, 'adminmenu' ), PHP_INT_MAX );
		add_action( 'in_admin_header', array( $this, 'in_admin_header' ), PHP_INT_MAX + 1 );
	}

	public function adminmenu() {
		ob_start();
		echo '<!-- commentius startus -->';
	}

	public function in_admin_header() {
		ob_get_clean();
		?>
				</ul>
			</div>
		</div>
		<div id="tomjnadminhead">
			<h2><?php bloginfo('name');?></h2>
		</div>
		<div id="wpcontent">
		<?php
	}
}