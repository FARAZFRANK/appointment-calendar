<?php
/*
	# Plugin Name: Appointment Calendar
	# Version: 2.1
	# Description: Easily accept and manage appointments on your wordpress site. 
	# Author: Scientech It Solution
	# Author URI: http://www.appointzilla.com
	# Plugin URI: /plugins/appointment_calendar.zip

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 3 of the License, or
	(at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	along with this program. If not, see <http://www.gnu.org/licenses/>.
*/


/**
 *	Run 'Install' script on plugin activation
 *******************************************/
register_activation_hook( __FILE__, 'InstallScript' );
function InstallScript()
{
	include('install-script.php');
}


/**
 *	Run 'Uninstall' script on plugin deleted
 ************************************************/
register_deactivation_hook( __FILE__, 'UnInstallScript' );
function UnInstallScript()
{
	include('uninstall-script.php');
}


/**
 *	Admin dashboard Menu Pages For Booking Calendar Plugin
 **********************************************************/
add_action('admin_menu','appointment_calendar_menu');

function appointment_calendar_menu() 
{	
	//syntax: add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
	
	//syntax: add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
	
	
	//create new top-level menu 'appointment-calendar'
	add_menu_page('Appointment Calendar', 'Appointment Calendar', 'administrator', 'appointment-calendar');


	// Calendar Page
	add_submenu_page( 'appointment-calendar', 'Appointment Calendar', 'Appointment Calendar', 'administrator', 'appointment-calendar', 'dispaly_calendar_page' );
	// Time sloat Page
	add_submenu_page( 'appointment-calendar', 'Manage Time Sloat', '', 'administrator', 'time_sloat', 'dispaly_time_sloat_page' );
	// Data Save Page
	add_submenu_page( 'appointment-calendar', 'Data Save', '', 'administrator', 'data_save', 'dispaly_datasave_page' );
	
	
	// Service Page
	add_submenu_page( 'appointment-calendar', 'Service', 'Service', 'administrator', 'service', 'dispaly_service_page' );
	// manage Service Page
	add_submenu_page( 'appointment-calendar', 'Manage Service', '', 'administrator', 'manage-service', 'dispaly_manageservice_page' );
	
	
	// Staff Page
	//add_submenu_page( 'appointment-calendar', 'Staff', 'Staff', 'administrator', 'staff', 'dispaly_staff_page' );
	
	
	// Time-Off Page
	add_submenu_page( 'appointment-calendar', 'Time Off', 'Time Off', 'administrator', 'timeoff', 'dispaly_timeoff_page' );
	// Update Time-Off Page
	add_submenu_page( 'appointment-calendar', 'Update TimeOff', '', 'administrator', 'update-timeoff', 'dispaly_updatetimeoff_page' );
	
	
	
	// Client Page
	//add_submenu_page( 'appointment-calendar', 'Client', 'Client', 'administrator', 'client', 'dispaly_client_page' );
	
	
	// Manage Appointment Page
	add_submenu_page( 'appointment-calendar', 'Manage Appointment', 'Manage Appointment', 'administrator', 'manage-appointments', 'dispaly_manageappointment_page' );
	// Update Appointments Page
	add_submenu_page( 'appointment-calendar', 'Update Appointment', '', 'administrator', 'update-appointment', 'dispaly_updateappointment_page' );
	
	// Settings Page
	add_submenu_page( 'appointment-calendar', 'Calendar Settings', 'Calendar Settings', 'administrator', 'settings', 'dispaly_settings_page' );
	// Manage Settings Page
	add_submenu_page( 'appointment-calendar', 'Manage Settings', '', 'administrator', 'manage-settings', 'dispaly_managesettings_page' );
	
	
	// Email Settings Page
	add_submenu_page( 'appointment-calendar', 'Notification Settings', 'Notification Settings', 'administrator', 'notificationsettings', 'dispaly_notificationsettings_page' );
	// Manage Email Settings Page
	add_submenu_page( 'appointment-calendar', 'Manage Notification Settings', '', 'administrator', 'manage-notificationsettings', 'dispaly_managenotificationsettings_page' );
	
	// Get Premium
	add_submenu_page( 'appointment-calendar', 'Get Premium Version', 'Get Premium Version', 'administrator', 'get-premium', 'dispaly_getpremium_page' );
	
}



/**
 * Rendering All appointment-calendar Menu Page
 ***************************************/
 
 
 //calendar page
 function dispaly_calendar_page()
 {

	include('menu-pages/calendar.php');
 }
 //time slot page
 function dispaly_time_sloat_page()
 {
 	include("menu-pages/appointment-form2.php");
 
 }
 //appointment save page
 function dispaly_datasave_page()
 {
 	include("menu-pages/data_save.php");
 
 }
 
 
 //service page
 function dispaly_service_page()
 {
	include("menu-pages/service.php");
 }
 //manage service page
 function dispaly_manageservice_page()
 {
	include("menu-pages/manage-service.php");
 }
 
  //staff page
 /*function dispaly_staff_page()
 {
 	echo"Dispaly Staff";
 }*/
 
 
 //time-off page
 function dispaly_timeoff_page()
 {
	include("menu-pages/timeoff.php");
 }
 //update-time-off page
 function dispaly_updatetimeoff_page()
 {
	include("menu-pages/update-timeoff.php");
 }
 
 
 
 
 /*//client page
 function dispaly_client_page()
 {
 	echo"Dispaly client";
 }*/
 
 
 
 
 
 
 //manage-appointment page
 function dispaly_manageappointment_page()
 {
	include("menu-pages/manage-appointments.php");
 }
 function dispaly_updateappointment_page()
 {
	include("menu-pages/update-appointments.php");
 }


 
 
 
 //settings page
 function dispaly_settings_page()
 {
	include("menu-pages/settings.php");
 }
 //add/update settings page
 function dispaly_managesettings_page()
 {
	include("menu-pages/manage-settings.php");
 } 
 
 
 
 
 
  //email-settings page
 function dispaly_notificationsettings_page()
 {
	include("menu-pages/notification-settings.php");
 }
  //manage-emailsettings page
 function dispaly_managenotificationsettings_page()
 {
	include("menu-pages/manage-notificationsettings.php");
 }
 
 
 //get-premium page
 function dispaly_getpremium_page()
 {
 	include("menu-pages/getpremium.php");
 }
 

/****
 * Including Calendar Short-Code Page
 ***************************************/
	include("appointment-calendar-shortcode.php");
	
?>
