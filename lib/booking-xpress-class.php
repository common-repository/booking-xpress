<?php
error_reporting('0');
//--------------------------------------------------------------------------------------------------------------//
// CODE FOR CREATING MENUS
//---------------------------------------------------------------------------------------------------------------//
function createGlobalMenus()
{	
	$menu = add_menu_page('Bookings Xpress', __('Bookings Xpress', booking_xpress), 'administrator', 'booking_xpress','',TBP_BK_PLUGIN_URL . '/icon.png');
	$submenu1 = add_submenu_page('booking_xpress', 'Dashboard', __('Dashboard', booking_xpress), 'administrator', 'booking_xpress', 'booking_xpress');
	$submenu2 = add_submenu_page('booking_xpress', 'Bookings', __('Bookings', booking_xpress), 'administrator', 'bookings', 'bookings');
	$submenu3 = add_submenu_page('booking_xpress', 'Services', __('Services', booking_xpress), 'administrator', 'display_services', 'display_services');
	$submenu4 = add_submenu_page('booking_xpress', 'Coupons', __('Coupons', booking_xpress), 'administrator', 'display_Coupons', 'display_Coupons');
	$submenu5 = add_submenu_page( 'booking_xpress', 'Block Outs', __('Block Outs', booking_xpress), 'administrator', 'display_blockouts', 'display_blockouts');	
	$submenu6 = add_submenu_page( 'booking_xpress', 'Clients', __('Clients', booking_xpress), 'administrator', 'bookings_customers', 'bookings_customers');
	$submenu7 = add_submenu_page( 'booking_xpress', 'Form Setup', __('Form Setup', booking_xpress), 'administrator', 'form_setup', 'form_setup');
	$submenu8 = add_submenu_page( 'booking_xpress', 'Email Templates', __('Email Templates', booking_xpress), 'administrator', 'email_templates', 'email_templates');
	$submenu9 = add_submenu_page( 'booking_xpress', 'Report a Bug', __('Report a Bug', booking_xpress), 'administrator', 'report_bugs', 'report_bugs');
	$submenu11 = add_submenu_page( 'booking_xpress', 'Help & Support', __('Help & Support', booking_xpress), 'administrator', 'help_support', 'help_support');
	$submenu12 = add_submenu_page( 'booking_xpress', 'Remove Plugin', __('Remove Plugin', booking_xpress), 'administrator', 'uninstall_plugin_code', 'uninstall_plugin_code');
}
//--------------------------------------------------------------------------------------------------------------//
//CODE FOR CALLING JAVASCRIPT FUNCTIONS
//--------------------------------------------------------------------------------------------------------------//
function plugin_js_scripts()
{
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-draggable');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jquery.ui.datepicker.js', TBP_BK_PLUGIN_URL .'/js/jquery.ui.datepicker.js');
	wp_enqueue_script('jquery-ui.multidatespicker.js', TBP_BK_PLUGIN_URL .'/js/jquery-ui.multidatespicker.js');
	wp_enqueue_script('bootstrap.min.js', TBP_BK_PLUGIN_URL .'/js/bootstrap.min.js');
	wp_enqueue_script('bootstrap-bootbox.min.js', TBP_BK_PLUGIN_URL .'/js/bootstrap-bootbox.min.js');
	wp_enqueue_script('jquery.validate.min.js', TBP_BK_PLUGIN_URL .'/js/jquery.validate.min.js');
	wp_enqueue_script('jquery.datatables.js', TBP_BK_PLUGIN_URL .'/js/jquery.datatables.js');
	wp_enqueue_script('jquery.fullcalendar.min.js', TBP_BK_PLUGIN_URL .'/js/jquery.fullcalendar.min.js');
	wp_enqueue_script('jquery.colorbox.js', TBP_BK_PLUGIN_URL .'/js/jquery.colorbox-min.js');
	wp_enqueue_script('jquery.colorpicker.js', TBP_BK_PLUGIN_URL .'/js/colorpicker.js');
}
//--------------------------------------------------------------------------------------------------------------//
// CODE FOR CALLING STYLE SHEETS
function plugin_css_scripts()
{
	wp_enqueue_style('menu.css', TBP_BK_PLUGIN_URL .'/css/menu.css');
	wp_enqueue_style('datatables.css', TBP_BK_PLUGIN_URL .'/css/datatables.css');
	wp_enqueue_style('forms.css', TBP_BK_PLUGIN_URL .'/css/forms.css');
	wp_enqueue_style('forms-btn.css', TBP_BK_PLUGIN_URL .'/css/forms-btn.css');
	wp_enqueue_style('fullcalendar.css', TBP_BK_PLUGIN_URL .'/css/plugins.css');	
	wp_enqueue_style('statics.css', TBP_BK_PLUGIN_URL .'/css/statics.css');
	wp_enqueue_style('style.css', TBP_BK_PLUGIN_URL .'/css/style.css');
	wp_enqueue_style('bootstrap.css', TBP_BK_PLUGIN_URL .'/css/bootstrap.css');
	wp_enqueue_style('system-message.css', TBP_BK_PLUGIN_URL .'/css/system-message.css');
	wp_enqueue_style('mdp.css', TBP_BK_PLUGIN_URL .'/css/mdp.css');
	wp_enqueue_style('colorbox.css', TBP_BK_PLUGIN_URL .'/css/colorbox.css');
	wp_enqueue_style('colorpicker.css', TBP_BK_PLUGIN_URL .'/css/colorpicker.css');
}
//--------------------------------------------------------------------------------------------------------------//
// FUNCTIONS FOR REPLACING TABLE NAMES
//--------------------------------------------------------------------------------------------------------------//
function servicesTable()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_Services';
}
function customersTable()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_Customers';
}
function currenciesTable()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_Currencies';
}
function countriesTable()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_Countries';
}
function email_templatesTable()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_email_templates';
}
function social_Media_settingsTable()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_social_media_Settings';
}
function payment_Gateway_settingsTable()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_payment_gateway_Settings';
}
function auto_Responders_settingsTable()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_auto_responders_settings';
}
function generalSettingsTable()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_general_settings';
}
function bookingTable()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_booking';
}
function bookingFormTable()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_booking_form';
}
function multiple_bookingTable()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_multiple_booking';
}
function coupons()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_coupons';
}
function coupons_products()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_coupon_products';
}
function block_outs()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_blockouts';
}
function bookingsCountTable()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_bookings_count';
}
//--------------------------------------------------------------------------------------------------------------//
// FUNCTIONS TO BE CALLED ON RESPECTIVE MENUS
//--------------------------------------------------------------------------------------------------------------//
function booking_xpress()
{
	global $wpdb;
	include_once TBP_BK_PLUGIN_DIR .'/header.php';
	include_once TBP_BK_PLUGIN_DIR .'/menus.php';
	include_once TBP_BK_PLUGIN_DIR .'/views/dashboard.php';
}
function bookings()
{
	global $wpdb;
	include_once TBP_BK_PLUGIN_DIR .'/header.php';
	include_once TBP_BK_PLUGIN_DIR .'/menus.php';
	include_once TBP_BK_PLUGIN_DIR .'/views/bookings.php';
}
function display_services()
{
	global $wpdb;
	include_once TBP_BK_PLUGIN_DIR .'/header.php';
	include_once TBP_BK_PLUGIN_DIR .'/menus.php';
	include_once TBP_BK_PLUGIN_DIR .'/views/services.php';
}
function display_Coupons()
{
	global $wpdb;
	include_once TBP_BK_PLUGIN_DIR .'/header.php';
	include_once TBP_BK_PLUGIN_DIR .'/menus.php';
	include_once TBP_BK_PLUGIN_DIR .'/views/coupon.php';
}
function display_blockouts()
{
	global $wpdb;
	include_once TBP_BK_PLUGIN_DIR .'/header.php';
	include_once TBP_BK_PLUGIN_DIR .'/menus.php';
	include_once TBP_BK_PLUGIN_DIR .'/views/blockouts.php';
}
function bookings_customers()
{
	global $wpdb;
	include_once TBP_BK_PLUGIN_DIR .'/header.php';
	include_once TBP_BK_PLUGIN_DIR .'/menus.php';
	include_once TBP_BK_PLUGIN_DIR .'/views/clients.php';
}
function form_setup()
{
	global $wpdb;
	include_once TBP_BK_PLUGIN_DIR .'/header.php';
	include_once TBP_BK_PLUGIN_DIR .'/menus.php';
	include_once TBP_BK_PLUGIN_DIR .'/views/bookingform.php';
}
function email_templates()
{
	global $wpdb;
	include_once TBP_BK_PLUGIN_DIR .'/header.php';
	include_once TBP_BK_PLUGIN_DIR .'/menus.php';
	include_once TBP_BK_PLUGIN_DIR .'/views/emailtemplates.php';
}
function report_bugs()
{
	global $wpdb;
	include_once TBP_BK_PLUGIN_DIR .'/header.php';
	include_once TBP_BK_PLUGIN_DIR .'/menus.php';
	include_once TBP_BK_PLUGIN_DIR .'/views/reportbug.php';	
}
function uninstall_plugin_code()
{
	
}
function go_premium()
{
	
}
function help_support()
{
	
}
//--------------------------------------------------------------------------------------------------------------//
// REGISTER AJAX BASED FUNCTIONS TO BE CALLED ON ACTION TYPE AS PER WORDPRESS GUIDELINES
//--------------------------------------------------------------------------------------------------------------//
if(isset($_REQUEST['action']))
{
	switch($_REQUEST['action'])
	{
		// To be Called on Service Related Executions
		case "servicesLibrary":
			 
		add_action( 'admin_init', 'servicesLibrary');
		function servicesLibrary()
		{
			global $wpdb;
			include_once TBP_BK_PLUGIN_DIR . '/lib/services-class.php';
		}
		case "dashboardLibrary":
			
		add_action( 'admin_init', 'dashboardLibrary');
		function dashboardLibrary()
		{
			global $wpdb;
			include_once TBP_BK_PLUGIN_DIR . '/lib/dashboard-class.php';
		}
		case "blockoutLibrary":
			
		add_action( 'admin_init', 'blockoutLibrary');
		function blockoutLibrary()
		{
			global $wpdb;
			include_once TBP_BK_PLUGIN_DIR . '/lib/blockouts-class.php';
		}
		case "bookingFormLibrary":
			
		add_action( 'admin_init', 'bookingFormLibrary' );
		function bookingFormLibrary()
		{
			global $wpdb;
			include_once TBP_BK_PLUGIN_DIR . '/lib/bookingform-class.php';
		}
		case "bookingsLibrary":
			
		add_action( 'admin_init', 'bookingsLibrary');
		function bookingsLibrary()
		{
			global $wpdb;
			include_once TBP_BK_PLUGIN_DIR . '/lib/bookingcalendar-class.php';
		}
		case "clientLibrary":
		
		add_action( 'admin_init', 'clientLibrary');
		function clientLibrary()
		{
			global $wpdb;
			include_once TBP_BK_PLUGIN_DIR . '/lib/clients-class.php';
		}		
		
		case "couponLibrary":
		
		add_action( 'admin_init', 'couponLibrary');
		function couponLibrary()
		{
			global $wpdb;
			include_once TBP_BK_PLUGIN_DIR . '/lib/coupons-class.php';
		}	 
		case "emailLibrary":
		
		add_action( 'admin_init', 'emailLibrary');
		function emailLibrary()
		{
			global $wpdb;
			include_once TBP_BK_PLUGIN_DIR . '/lib/emailtemplates-class.php';
		}	 
		
		case "reportBugLibrary":
		
		add_action( 'admin_init', 'reportBugLibrary');
		function reportBugLibrary()
		{
			global $wpdb;
			include_once TBP_BK_PLUGIN_DIR . '/lib/reportbug-class.php';
		}	
		case "bookingsCalendarLibrary":
   
		 add_action( 'admin_init', 'bookingsCalendarLibrary');
		 function bookingsCalendarLibrary()
		 {
		 	global $wpdb;
		 	include_once TBP_BK_PLUGIN_DIR . '/lib/bookings-class.php';
		 } 
		 case "menuLibrary":
   
		 add_action( 'admin_init', 'menuLibrary');
		 function menuLibrary()
		 {
		 	global $wpdb;
		 	include_once TBP_BK_PLUGIN_DIR . '/lib/menus-class.php';
		 } 
		 case "fullcalendarLibrary":
		 add_action( 'admin_init', 'fullcalendarLibrary');
		 function fullcalendarLibrary()
		 {
		 	global $wpdb;
		 	include_once TBP_BK_PLUGIN_DIR . '/lib/frontEndFullCalendar-class.php';
		 } 
		  case "calendarClassicLibrary":
		 add_action( 'admin_init', 'calendarClassicLibrary');
		 function calendarClassicLibrary()
		 {
		 	global $wpdb;
		 	include_once TBP_BK_PLUGIN_DIR . '/lib/bookingcalendarClassic-class.php';
		 } 
		// To be Called on Exceptions Related Executions
	}
}
//--------------------------------------------------------------------------------------------------------------//
// LANGUAGES
//--------------------------------------------------------------------------------------------------------------//

function bookingXpressShortCode() 
{
  return extract_ShortCodes();
}
function bookingXpressShortCode1() 
{
  return extract_ShortCodes1();
}
function bookingXpressShortCode2() 
{
  return extract_ShortCodes2();
}
function bookingXpressShortCode3() 
{
  return extract_ShortCodes3();
}
function bookingXpressShortCode4() 
{
  return extract_ShortCodes4();
}
function extract_ShortCodes() 
{
	?>
	<div style="display:block">
		<div id="bookNewService">
			<div id="bookNewService">
				<div class="body">
					<?php include_once TBP_BK_PLUGIN_DIR.'/views/frontEndFullCalendar.php' ?>
				</div> 
			</div>	
		</div>
	</div>
	
	<?php
}
function extract_ShortCodes1() 
{
	?>
	<div style="display:block">
		<div id="bookNewService">
			<div id="bookNewService">
				<div class="body">
					<?php include_once TBP_BK_PLUGIN_DIR.'/views/booking-calendar-Front-EndEmbed.php' ?>
				</div> 
			</div>	
		</div>
	</div>
	<?php
}
function extract_ShortCodes2() 
{
	?>
	<a href="#bookNewService2" class="inline">
		<img src="<?php echo TBP_BK_PLUGIN_URL.'/images/bookNow.png' ?>" >
	</a>
	<div style="display:none">
		<div id="bookNewService2">
			<div class="body">
				<?php include_once TBP_BK_PLUGIN_DIR.'/views/booking-calendar-Front-End.php' ?>
			</div> 
		</div>
	</div>
	<script>jQuery(".inline").colorbox({inline:true, width:"700px"});</script>
	<?php
}
function extract_ShortCodes3() 
{
	?>
	
	<div style="display:block">
		
			<div class="body">
				<?php include_once TBP_BK_PLUGIN_DIR.'/views/bookingsCalendarEmbed-classic.php' ?>
			</div> 
		
	</div>
	<?php
}
function extract_ShortCodes4() 
{
	?>
	<a href="#bookNewService3" class="inline">
		<img src="<?php echo TBP_BK_PLUGIN_URL.'/images/bookNow.png' ?>" >
	</a>
	<div style="display:none">
		<div id="bookNewService3">
			<div class="body">
				<?php include_once TBP_BK_PLUGIN_DIR.'/views/bookingsCalendar-classic.php' ?>
			</div> 
		</div>
	</div>
	<script>jQuery(".inline").colorbox({inline:true, width:"700px"});</script>
	<?php
}
//--------------------------------------------------------------------------------------------------------------//
// GLOBAL HOOOKS
//--------------------------------------------------------------------------------------------------------------//
add_action('admin_menu','createGlobalMenus');
add_action('init','plugin_js_scripts');
add_action('init','plugin_css_scripts');
add_shortcode('bookingXpressFullCalendarEmbed', 'bookingXpressShortCode' );
add_shortcode('bookingXpressBookingFrontEndEmbed', 'bookingXpressShortCode1' );
add_shortcode('bookingXpressBookingFrontEndPopUp', 'bookingXpressShortCode2' );
add_shortcode('bookingXpressBookingFrontEndClassicEmbedForm', 'bookingXpressShortCode3' );
add_shortcode('bookingXpressBookingFrontEndClassicPopUp', 'bookingXpressShortCode4' );
?>