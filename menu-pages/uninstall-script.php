<?php
	global $wpdb;
	
	//drop ap_appointments table
	$table_appointments = $wpdb->prefix . "ap_appointments";
	$appointments = "DROP TABLE `$table_appointments`";
	$wpdb->query($appointments); 
	
	
	//drop ap_events table
	$table_events = $wpdb->prefix . "ap_events";
	$events = "DROP TABLE `$table_events`";
	$wpdb->query($events); 
	
	
	//drop ap_services table	
	$table_services = $wpdb->prefix . "ap_services";
	$services = "DROP TABLE `$table_services`";
	$wpdb->query($services); 
	
	
	//drop a service Category
	$table_service_category = $wpdb->prefix . "ap_service_category";
	$service_category = "DROP TABLE `$table_service_category`";
	$wpdb->query($service_category);
	
		
	//drop a calendar settings table
	$table_calendar_settings = $wpdb->prefix . "ap_calendar_settings";
	$calendar_settings = "DROP TABLE `$table_calendar_settings`";
	$wpdb->query($calendar_settings);


	//delete all default calendar options & settings
	delete_option('calendar_slot_time');
	delete_option('day_start_time');
	delete_option('day_end_time');
	delete_option('calendar_view');
	delete_option('calendar_start_day');
	delete_option('emailstatus');
	delete_option('emailtype');
	delete_option('emaildetails');
?>
