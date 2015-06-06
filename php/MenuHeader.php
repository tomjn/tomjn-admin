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
		add_action( 'tomjn_header_end', array( $this, 'tomjn_header_end' ) );
		add_action( 'tomjn_header_begin', array( $this, 'tomjn_header_begin' ) );
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
				$links[]     = '<a href="' . admin_url( $sub_item[2] ) . '" class="' . $classes_str . '">' . $title . '</a>';
			}
		}
		echo implode( ', ', $links );
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
					?>
					<div class="tomjn_dash_menu_section">
						<h3><a href="<?php echo esc_url( admin_url( $item[2] ) ); ?>"><?php echo $title; ?></a></h3>
						<?php
						if ( !empty( $submenu[ $item[2]] ) ) {
							echo '<ul>';
							foreach ( $submenu[ $item[2] ] as $sub_item ) {
								if ( !current_user_can( $sub_item[1] ) ) {
									continue;
								}
								echo '<li class="tomjn_dash_menu_item">';
								echo '<a href="'.esc_url( admin_url( $sub_item[2] ) ).'">'.$sub_item[0].'</a>';
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
		/*echo '<pre>';
		print_r( $menu );
		echo '</pre>';
		echo '<hr>';
		echo '<pre>';
		print_r( $submenu[ $parent_file ] );
		echo '</pre>';
		echo '<hr>';
		echo '<pre>'.print_r($parent_file, false).'</pre>';
		echo '<hr>';
		global $_wp_admin_css_colors;
		echo '<pre>';
		print_r( $_wp_admin_css_colors[get_user_option('admin_color')] );
		echo '</pre>';*/
	}

	public function tomjn_header_begin() {
		global $menu, $submenu, $parent_file, $self;
		$links = array();
		$links[] = '<a href="'.admin_url().'">Dashboard</a>';
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
				$links[]     = '<a href="' . esc_url( admin_url( $item[2] ) ) . '" class="' . esc_attr( $classes_str ) . '">' . $title . '</a>';
				break;
			}
		}
		if ( count( $links ) > 1 ) {
			echo implode( ' > ', $links );
		}
	}
}