<?php
/**
 * Plugin Name: Tomjn Admin
 * Plugin URI: https://tomjn.com
 * Description: A custom admin interface that eliminates the sidebar and experiments with a new layout
 * Version:     1.1
 * Author:      Tom J Nowell, WordPress.com VIP, Automattic
 * Author URI:  https://tomjn.com/
 * Text Domain: tomjn-admin
 */

/**
 * This plugins is an admin UI plugin, it has no business
 * running on the frontend!
 **/
if ( !is_admin() ) {
	return;
}

/**
 * lets define our classes! Note that loading these files
 * shouldn't do anything, the files define classes, they
 * don't run them, that's our decision to make by running
 * the `run` method
 **/
require_once( "php/AssetsController.php" );
require_once( "php/MenuHeader.php" );
require_once( "php/MenuDash.php" );
require_once( "php/MainController.php" );

// now we've defined them, lets tell PHP which ones we're going to use
use tomjn\admin\MainController;
use tomjn\admin\AssetsController;
use tomjn\admin\MenuDash;
use tomjn\admin\MenuHeader;

/**
 * great, now lets build all our objects, we're going to need:
 * - Something to manage our css/js assets
 *   - It's going to need to know this files path
 * - Something to display the header menu and hide the sidemenu
 * - Something to display the full menu on the dashboard
 * - A place for all of these things to live
 * 
 * Note that we're creating our objects, we're not ready to run the code yet
 **/
$assets = new AssetsController( __FILE__ );
$header = new MenuHeader();
$dash = new MenuDash();
$controller = new MainController( $assets, $header, $dash );

/**
 * now that we've defined our code, and created our objects,
 * everything is ready to go, but we haven't given the go ahead
 * yet, lets start things off!
 **/
 
$controller->run();
