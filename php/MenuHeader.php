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
		add_action( 'wp_dashboard_setup', array( $this, 'wp_dashboard_setup' ) );
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
			<?php
			global $menu, $submenu, $parent_file;
			foreach ( $menu as $key => $item ) {
				if ( !current_user_can( $item[1] ) ) {
					continue;
				}
				$title = $item[0];
				if ( empty( $title ) ) {
					continue;
				}
				$title = wptexturize( $item[0] );
				echo '<a href="'.admin_url( $item[2]).'">'.$title.'</a> ';
			}
			?>
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			<?php do_action('tomjn_header_end'); ?>
		</div>
		<div id="wpcontent">
		<?php
	}

	public function wp_dashboard_setup() {
		add_action( 'tomjn_header_end', array( $this, 'dash_tomjn_header_end' ) );
	}

	public function dash_tomjn_header_end() {
		global $menu, $submenu, $parent_file;
		echo '<pre>';
		print_r( $menu );
		echo '</pre>';
	}
}