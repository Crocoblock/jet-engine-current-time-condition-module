<?php
namespace Jet_Engine_Current_Time;

class Current_Time_Greater extends \Jet_Engine\Modules\Dynamic_Visibility\Conditions\Base {

	/**
	 * Returns condition ID
	 *
	 * @return string
	 */
	public function get_id() {
		return 'current-time-greater';
	}

	/**
	 * Returns condition name
	 *
	 * @return string
	 */
	public function get_name() {
		return __( 'Current time greater', 'jet-engine' );
	}

	/**
	 * Returns group for current operator
	 *
	 * @return [type] [description]
	 */
	public function get_group() {
		return 'general';
	}

	/**
	 * Check condition by passed arguments
	 *
	 * @param  array $args
	 * @return bool
	 */
	public function check( $args = array() ) {

		$type           = ! empty( $args['type'] ) ? $args['type'] : 'show';
		$current_value  = $this->get_current_value( $args );
		$time           = strtotime( wp_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) ) );
		$to_check       = strtotime( $current_value );

		if ( ! $to_check ) {
			$to_check = strtotime( 'Today ' . $current_value );
		}

		if ( ! $to_check ) {
			if ( 'hide' === $type ) {
				return true;
			} else {
				return false;
			}
		}

		if ( 'hide' === $type ) {
			return $time < $to_check;
		} else {
			return $time >= $to_check;
		}

	}

	/**
	 * Check if is condition available for meta fields control
	 *
	 * @return boolean
	 */
	public function is_for_fields() {
		return true;
	}

	/**
	 * Check if is condition available for meta value control
	 *
	 * @return boolean
	 */
	public function need_value_detect() {
		return false;
	}

}
