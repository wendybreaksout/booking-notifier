<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://tnotw.com
 * @since             1.0.0
 * @package           Booking_Notifier
 *
 * @wordpress-plugin
 * Plugin Name:       Booking Notifier
 * Plugin URI:        https://tnotw.com/booking-notifier
 * Description:       A plugin for notifying users of equipment reservations made using then wp develop booking calendar platform. 
 * Version:           1.0.0
 * Author:            Wendy Emerson
 * Author URI:        https://tnotw.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       booking-notifier
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BOOKING_NOTIFIER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-booking-notifier-activator.php
 */
function activate_booking_notifier() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-booking-notifier-activator.php';
	Booking_Notifier_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-booking-notifier-deactivator.php
 */
function deactivate_booking_notifier() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-booking-notifier-deactivator.php';
	Booking_Notifier_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_booking_notifier' );
register_deactivation_hook( __FILE__, 'deactivate_booking_notifier' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-booking-notifier.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_booking_notifier() {

	$plugin = new Booking_Notifier();
	$plugin->run();

}
run_booking_notifier();
