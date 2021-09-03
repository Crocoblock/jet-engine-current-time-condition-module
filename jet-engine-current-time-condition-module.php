<?php
/**
 * Plugin Name: JetEngine - Current time coditions module
 * Plugin URI:
 * Description: Module adds new conditions to Dynamic Conditions module. It allows to check if current time is less or greater selected time moments.
 * Version:     1.0.0
 * Author:      Crocoblock
 * Author URI:  https://crocoblock.com/
 * Text Domain: jet-appointments-booking
 * License:     GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}

add_action( 'plugins_loaded', 'jet_engine_current_time_conditions' );

function jet_engine_current_time_conditions() {

	define( 'JET_CTC_MODULE__FILE__', __FILE__ );
	define( 'JET_CTC_MODULE_PLUGIN_BASE', plugin_basename( JET_CTC_MODULE__FILE__ ) );
	define( 'JET_CTC_MODULE_PATH', plugin_dir_path( JET_CTC_MODULE__FILE__ ) );

	add_action( 'jet-engine/modules/dynamic-visibility/conditions/register', function( $conditions_manager ) {

		require JET_CTC_MODULE_PATH . 'current-time-greater.php';
		require JET_CTC_MODULE_PATH . 'current-time-less.php';

		$conditions_manager->register_condition( new Jet_Engine_Current_Time\Current_Time_Less() );
		$conditions_manager->register_condition( new Jet_Engine_Current_Time\Current_Time_Greater() );

	}, 100 );

}

function jet_engine_current_time_skip_day( $time = false ) {

	/**
	 * Shoul reutrn array of day numbers to skip. Example:
	 * add_filter( 'jet-engine/current-time-conditions/skip-weekdays', function() {
	 * 	return array( 6, 7 );
	 * } );
	 *
	 * day numbers:
	 * 1 - Monday
	 * 2 - Tuesday
	 * ...
	 * 6 - Saturady
	 * 7 - Sunday
	 *
	 * @var array
	 */
	$skip_days = apply_filters( 'jet-engine/current-time-conditions/skip-weekdays', array() );

	if ( empty( $skip_days ) ) {
		return false;
	}

	$day = date( 'N', $time );

	return in_array( $day, $skip_days );

}
