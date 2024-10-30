<?php
/*
Plugin Name: Booking Xpress
Plugin URI: http://wordpress.org/plugins/booking-xpress/
Description: Booking Xpress - its plugin for online reservation and availability checking service for your site.
Version: 1.0.0
Author URI: http://wordpress.org/plugins/booking-xpress/
Copyright 2013 Bookings-Xpress.com (email : sales@bookings-xpress.com)
*/
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//   D e f i n e     CONSTANTS              //////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if (!defined('TBP_DEBUG_MODE'))    define('TBP_DEBUG_MODE',  false );
	if (!defined('TBP_BK_FILE'))       define('TBP_BK_FILE',  __FILE__ );
	if (!defined('TBP_CONTENT_DIR'))      define('TBP_CONTENT_DIR', ABSPATH . 'wp-content');
	if (!defined('TBP_CONTENT_URL'))      define('TBP_CONTENT_URL', site_url() . '/wp-content');
	if (!defined('TBP_PLUGIN_DIR'))       define('TBP_PLUGIN_DIR', TBP_CONTENT_DIR . '/plugins');
	if (!defined('TBP_PLUGIN_URL'))       define('TBP_PLUGIN_URL', TBP_CONTENT_URL . '/plugins');
	if (!defined('TBP_BK_PLUGIN_FILENAME'))  define('TBP_BK_PLUGIN_FILENAME',  basename( __FILE__ ) );
	if (!defined('TBP_BK_PLUGIN_DIRNAME'))   define('TBP_BK_PLUGIN_DIRNAME',  plugin_basename(dirname(__FILE__)) );
	if (!defined('TBP_BK_PLUGIN_DIR')) define('TBP_BK_PLUGIN_DIR', TBP_PLUGIN_DIR.'/'.TBP_BK_PLUGIN_DIRNAME );
	if (!defined('TBP_BK_PLUGIN_URL')) define('TBP_BK_PLUGIN_URL', site_url().'/wp-content/plugins/'.TBP_BK_PLUGIN_DIRNAME );
	if (!defined('booking_xpress')) define('booking_xpress', 'booking_xpress');

if(file_exists(TBP_BK_PLUGIN_DIR. '/lib/booking-xpress-class.php'))// C L A S S    B o o k i n g
{
	 require_once(TBP_BK_PLUGIN_DIR. '/lib/booking-xpress-class.php');
}
function plugin_install_script()
{
	include_once TBP_BK_PLUGIN_DIR .'/install-script.php';	
}
function plugin_delete_script()
{
	include_once TBP_BK_PLUGIN_DIR .'/uninstall-script.php';
}
function plugin_load_textdomain() 
{
	if( function_exists( 'load_plugin_textdomain' ) )
	{
		load_plugin_textdomain(booking_xpress, false, TBP_BK_PLUGIN_DIRNAME .'/languages');
	}
}

add_action('plugins_loaded', 'plugin_load_textdomain');
register_activation_hook(__FILE__,'plugin_install_script');
register_uninstall_hook(__FILE__,'plugin_delete_script');

?>