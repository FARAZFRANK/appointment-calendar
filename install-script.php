<?php
global $wpdb;
	//*************create a ap_appointments table*************************
	$table_name = $wpdb->prefix . "ap_appointments";
	$appointments = "CREATE TABLE $table_name (
		`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`name` VARCHAR( 30 ) NOT NULL ,
		`email` VARCHAR( 256 ) NOT NULL ,
		`service_id` INT( 11 ) NOT NULL ,
		`phone` BIGINT( 21 ) NOT NULL ,
		`start_time` VARCHAR( 10 ) NOT NULL ,
		`end_time` VARCHAR( 10 ) NOT NULL ,
		`date` DATE NOT NULL ,
		`note` TEXT NOT NULL ,
		`appointment_key` VARCHAR( 32 ) NOT NULL ,
		`status` VARCHAR( 10 ) NOT NULL ,
		`appointment_by` VARCHAR( 10 ) NOT NULL 
		)";
	$wpdb->query($appointments); 
	
	
	//*************create ap_events table*************************	
	$table_name = $wpdb->prefix . "ap_events";
	$events = "CREATE TABLE $table_name (
		`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`name` VARCHAR( 30 ) NOT NULL ,
		`allday` VARCHAR( 10 ) NOT NULL ,
		`start_time` VARCHAR( 10 ) NOT NULL ,
		`end_time` VARCHAR( 10 ) NOT NULL ,
		`repeat` VARCHAR( 10 ) NOT NULL ,
		`start_date` DATE NOT NULL ,
		`end_date` DATE NOT NULL ,
		`note` TEXT NOT NULL ,
		`status` VARCHAR( 10 ) NOT NULL 
		)";
	$wpdb->query($events); 
	
	
	//*************create ap_services table*************************	
	$table_name = $wpdb->prefix . "ap_services";
	$services = "CREATE TABLE $table_name (
		`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`name` VARCHAR( 50 ) NOT NULL ,
		`desc` TEXT NOT NULL ,
		`duration` INT( 11 ) NOT NULL ,
		`unit` VARCHAR( 10 ) NOT NULL ,
		`paddingtime` INT( 11 ) NOT NULL ,
		`cost` FLOAT NOT NULL ,
		`capacity` INT( 11 ) NOT NULL ,
		`availability` VARCHAR( 10 ) NOT NULL ,
		`business_id` INT( 11 ) NOT NULL ,
		`category_id` INT( 11 ) NOT NULL ,
		`staff_id` VARCHAR( 300 ) NOT NULL 
		)";
	$wpdb->query($services); 
	
	
	//*************inserting service 'Default'*************************
	$table_name = $wpdb->prefix . "ap_services";
	$insert_service = "INSERT INTO $table_name (
						`id` ,
						`name` ,
						`desc` ,
						`duration` ,
						`unit` ,
						`paddingtime`,
						`cost` ,
						`capacity`,
						`availability`,
						`business_id`,
						`category_id`,
						`staff_id`
						)
						VALUES ('1', 'Default', 'This is default service. You can edit this service.', '30', 'Minutes', '10', '100', '10', 'yes', '1', '1', '1');";
	$wpdb->query($insert_service);
	
	
	//*************create a service Category*************************
	$table_name = $wpdb->prefix . "ap_service_category";
	$service_category = "CREATE TABLE $table_name (
		`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`name` VARCHAR( 100 ) NOT NULL 
		)";
	$wpdb->query($service_category);
	
	
	//*************inserting a 'Default' service category*************************
	$table_name = $wpdb->prefix . "ap_service_category";
	$insert_service_category = "INSERT INTO $table_name (
						`id` ,
						`name` 
						)
						VALUES (
						'1', 'Default'
						);";
	$wpdb->query($insert_service_category);
	
	
	//*************create a calendar settings table*************************
	$table_name = $wpdb->prefix . "ap_calendar_settings";
	$calendar_settings = "CREATE TABLE $table_name (
		`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`view` VARCHAR( 20 ) NOT NULL ,
		`timeslots` INT( 11 ) NOT NULL 
		)";
	$wpdb->query($calendar_settings);



	//default calendar options & settings
	add_option('calendar_slot_time', '30');		// 30 min slots
	add_option('day_start_time', '10:00 AM');	// 10:00 AM
	add_option('day_end_time', '5:00 PM');		// 5:00 PM
	add_option('calendar_view', 'month');		// month
	add_option('calendar_start_day', '1');		// monday

	add_option('emailstatus', 'on');			//on	
	add_option('emailtype', 'wpmail');			//wpmail
	$EmailDetails =  array ( 'wpemail' => get_settings('admin_email') );
	add_option( 'emaildetails', serialize($EmailDetails));					// current admin email
	
	
?>
