<?php
/**
 * The shortcode for the plugin.
 *
 * @link       https://dogangokce.com
 * @since      3.0.0
 *
 * @package    Canliders1
 * @subpackage Canliders1/public
 */

/**
 * The shortcode for the plugin.
 *
 * Registers the shortcode and handles displaying the shortcode.
 *
 * @package    Canliders1
 * @subpackage Canliders1/public
 * @author     Doğan GÖGCE <contact@dogangokce.com>
 */
class Canliders1_Public_Shortcode {

	/**
	 * Register canliders1 shortcodes.
	 *
	 * @since   3.0.0
	 */
	public function register_shortcodes() {
		add_shortcode( 'canliders1', array( $this, 'display_canliders1_shortcode' ) );
		add_shortcode( 'canliders1_recordings', array( $this, 'display_canliders1_old_recordings_shortcode' ) );
	}

	/**
	 * Handle shortcode attributes.
	 *
	 * @since   3.0.0
	 *
	 * @param   Array  $atts       Parameters in the shortcode.
	 * @param   String $content    Content of the shortcode.
	 *
	 * @return  String $content    Content of the shortcode with rooms and recordings.
	 */
	public function display_canliders1_shortcode( $atts = [], $content = null ) {
		global $pagenow;
		$type           = 'room';
		$author         = (int) get_the_author_meta( 'ID' );
		$display_helper = new Canliders1_Display_Helper( plugin_dir_path( __FILE__ ) );

		if ( ! Canliders1_Tokens_Helper::can_display_room_on_page() ) {
			return $content;
		}

		if ( array_key_exists( 'type', $atts ) && 'recording' == $atts['type'] ) {
			$type = 'recording';
			unset( $atts['type'] );
		}

		$tokens_string = Canliders1_Tokens_Helper::get_token_string_from_atts( $atts );

		if ( 'room' == $type ) {
			$content .= Canliders1_Tokens_Helper::join_form_from_tokens_string( $display_helper, $tokens_string, $author );
		} elseif ( 'recording' == $type ) {
			$content .= Canliders1_Tokens_Helper::recordings_table_from_tokens_string( $display_helper, $tokens_string, $author );
		}
		return $content;
	}

	/**
	 * Shows recordings for the old recordings shortcode format.
	 *
	 * @since   3.0.0
	 * @param   Array  $atts       Parameters in the shortcode.
	 * @param   String $content    Content of the shortcode.
	 *
	 * @return  String $content    Content of the shortcode with recordings.
	 */
	public function display_canliders1_old_recordings_shortcode( $atts = [], $content = null ) {
		$atts['type'] = 'recording';
		return $this->display_canliders1_shortcode( $atts, $content );
	}
}
