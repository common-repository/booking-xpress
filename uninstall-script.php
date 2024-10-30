<?php
	global $wpdb;
	$sql = "DROP TABLE " .servicesTable();
    $wpdb->query($sql);
	
	$sql = "DROP TABLE " .customersTable();
    $wpdb->query($sql);
	
	$sql = "DROP TABLE " .bookingTable();
    $wpdb->query($sql);
	
	$sql = "DROP TABLE " .social_Media_settingsTable();
    $wpdb->query($sql);
	
	$sql = "DROP TABLE " .payment_Gateway_settingsTable();
    $wpdb->query($sql);
	
	$sql = "DROP TABLE " .auto_Responders_settingsTable();
    $wpdb->query($sql);
	
	$sql = "DROP TABLE " .generalSettingsTable();
    $wpdb->query($sql);
	
	$sql = "DROP TABLE " .currenciesTable();
    $wpdb->query($sql);
	
	$sql = "DROP TABLE " .countriesTable();
    $wpdb->query($sql);
	
	$sql = "DROP TABLE " .bookingFormTable();
    $wpdb->query($sql);
	
	$sql = "DROP TABLE " .email_templatesTable();
    $wpdb->query($sql);
	
	$sql = "DROP TABLE " .multiple_bookingTable();
    $wpdb->query($sql);
	
	$sql = "DROP TABLE " .coupons_products();
    $wpdb->query($sql);
	
	$sql = "DROP TABLE " .coupons();
    $wpdb->query($sql);

	$sql = "DROP TABLE " .block_outs();
    $wpdb->query($sql);	
	
	$sql = "DROP TABLE " .bookingsCountTable();
    $wpdb->query($sql);	
?>