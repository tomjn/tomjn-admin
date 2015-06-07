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
		add_action( 'tomjn_header_end', array( $this, 'tomjn_header_end' ) );
		add_action( 'tomjn_header_begin', array( $this, 'tomjn_header_begin' ) );
	}

	public function adminmenu() {
		ob_start();
	}

	public function in_admin_header() {
		ob_get_clean();
		?>
				</ul>
			</div>
		</div>
		<div id="tomjnadminhead">
			<?php
			do_action( 'tomjn_header_begin' );
			?>
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			<?php do_action('tomjn_header_end'); ?>
		</div>
		<div id="wpcontent">
		<?php
	}

	public function tomjn_header_end() {
		global $submenu, $parent_file, $plugin_page;
		$links = array();
		if ( $parent_file == 'index.php' ) {
			return;
		}
		if ( !empty( $links ) ) {
			$links[] = '<br>';
		}
		if ( !empty( $submenu[ $parent_file ] )) {
			$submenus = $submenu[$parent_file];
			foreach ( $submenus as $sub_item ) {
				if ( !current_user_can( $sub_item[1] ) ) {
					continue;
				}
				$classes = array(
					'tomjn_top_menu_item'
				);
				$title   = $sub_item[0];
				if ( empty( $title ) ) {
					continue;
				}
				$title       = wptexturize( $title );
				$classes_str = implode( ' ', $classes );
				$links[]     = '<a href="' . admin_url( $sub_item[2] ) . '" class="' . esc_attr( $classes_str ). '">'. wp_kses_post( $title ) . '</a>';
			}
		}
		echo implode( ', ', $links );
		//$this->debug_menu();
	}

	public function tomjn_header_begin() {
		global $menu, $submenu, $parent_file, $self;
		$links = array();
		if ( is_network_admin() ) {
			$links[] = '<a href="' . esc_url( admin_url('network/') ) . '">Network Dashboard</a>';
		} else {
			$links[] = '<a href="' . esc_url( admin_url() ) . '">Dashboard</a>';
		}
		foreach ( $menu as $key => $item ) {
			if ( !current_user_can( $item[1] ) ) {
				continue;
			}
			$classes = array(
				'tomjn_top_menu_item'
			);
			if ( $item[2] == 'index.php' ) {
				continue;
			}
			if ( false !== strpos( $item[4], 'wp-menu-separator' ) ) {
				continue;
			}
			$title = $item[0];
			if ( empty( $title ) ) {
				continue;
			}

			if ( !empty( $submenu[$item[2]] ) ) {
				$classes[] = 'tomjn_admin_top_has_submenu';
			}

			if ( ( $item[2] == $parent_file ) || ( $item[2] == $self ) ) {
				$classes[] = 'tomjn_admin_top_current_parent';
				$title       = wptexturize( $item[0] );
				$classes_str = implode( ' ', $classes );
				$url = $item[2];
				if ( is_network_admin() ) {
					$url = 'network/'.$url;
				}
				$url = admin_url( $url );
				$links[]     = '<a href="' . esc_url( $url ) . '" class="' . esc_attr( $classes_str ) . '">' . wp_kses_post( $title ) . '</a>';
				break;
			}
		}
		if ( count( $links ) > 1 ) {
			echo implode( ' > ', $links );
		}
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