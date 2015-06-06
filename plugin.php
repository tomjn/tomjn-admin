<?php
/**
 * Plugin Name: Tomjn Admin
 * Plugin URI: http://tomjn.com
 * Description: A custom admin interface.
 * Version:     1.0
 * Author:      Tom J Nowell, WordPress.com VIP, Automattic
 * Author URI: http://tomjn.com/
 * Text Domain: tomjn-admin
 */

if ( !is_admin() ) {
	return;
}

require_once( "php/AssetsController.php" );
require_once( "php/MenuHeader.php" );
require_once( "php/MenuDash.php" );
require_once( "php/MainController.php" );

use tomjn\admin\MainController;
use tomjn\admin\AssetsController;
use tomjn\admin\MenuHeader;

$assets = new AssetsController( __FILE__ );
$header = new MenuHeader();
$controller = new MainController( $assets, $header );

$controller->run();