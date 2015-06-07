<?php

namespace tomjn\admin;

/**
 * Class MenuDash
 * @package tomjn\admin
 */
class MenuDash {

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
		add_action( 'wp_dashboard_setup', array( $this, 'wp_dashboard_setup' ) );
		add_action( 'wp_network_dashboard_setup', array( $this, 'wp_dashboard_setup' ) );
	}

	public function wp_dashboard_setup() {
		add_action( 'tomjn_header_end', array( $this, 'dash_tomjn_header_end' ) );
	}

	public function dash_tomjn_header_end() {
		global $menu, $submenu;
		?>
		<div class="tomjn_dash_menu">
			<?php
			foreach ( $menu as $item ) {
				$title = $item[0];
				if ( empty( $title ) ) {
					continue;
				}
				$title       = wptexturize( $title );
				$url = $item[2];
				if ( is_network_admin() ) {
					$url = 'network/'.$url;
				}
				$url = admin_url( $url );
				?>
				<div class="tomjn_dash_menu_section">
					<h3><a href="<?php echo esc_url( $url ); ?>"><?php echo wp_kses_post( $title ); ?></a></h3>
					<?php
					if ( !empty( $submenu[ $item[2]] ) ) {
						echo '<ul>';
						foreach ( $submenu[ $item[2] ] as $sub_item ) {
							if ( !current_user_can( $sub_item[1] ) ) {
								continue;
							}
							echo '<li class="tomjn_dash_menu_item">';
							$url = $sub_item[2];
							if ( is_network_admin() ) {
								$url = 'network/'.$url;
							}
							$url = admin_url( $url );
							echo '<a href="'.esc_url( $url ).'">'.wp_kses_post( $sub_item[0] ).'</a>';
							echo '</li>';
						}
						echo '</ul>';
					}
					?>
				</div>
			<?php
			}
			?>
		</div>
		<?php
	}

	private function debug_menu() {
		global $parent_file, $menu, $submenu, $_wp_admin_css_colors;
		echo '<pre>';
		print_r( $menu );
		echo '</pre>';
		echo '<hr>';
		if ( !empty( $submenu[$parent_file] ) ) {
			echo '<pre>';
			print_r( $submenu[$parent_file] );
			echo '</pre>';
			echo '<hr>';
		}

		echo '<pre>'.print_r($parent_file, false).'</pre>';
		echo '<hr>';
		echo '<pre>';
		print_r( $_wp_admin_css_colors[get_user_option('admin_color')] );
		echo '</pre>';
	}
}