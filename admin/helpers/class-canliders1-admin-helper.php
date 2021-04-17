<?php
/**
 * The admin helper class.
 *
 * @link       https://dogangokce.com
 * @since      3.0.0
 *
 * @package    Canliders1
 * @subpackage Canliders1/public/helpers
 */

/**
 * The admin helper class.
 *
 * A list of helper functions that is used across CanliDers1 admin classes..
 *
 * @package    Canliders1
 * @subpackage Canliders1/public/helpers
 * @author     Doğan GÖGCE <contact@dogangokce.com>
 */
class Canliders1_Admin_Helper {

	/**
	 * Generate random alphanumeric string.
	 *
	 * @since   3.0.0
	 *
	 * @param   Integer $length         Length of random string.
	 * @return  String  $default_code   The resulting random string.
	 */
	public static function generate_random_code( $length = 10 ) {
		$default_code = bin2hex( random_bytes( $length / 2 ) );
		return $default_code;
	}
}
