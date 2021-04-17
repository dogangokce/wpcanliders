<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://dogangokce.com
 * @since             3.0.0
 * @package           Canliders1
 *
 * @wordpress-plugin
 * Plugin Name:       CanliDers1
 * Plugin URI:        https://github.com/dogangokce/wpcanliders
 * Description:       CanliDers1, açık kaynaklı bir web konferans sistemi olan BigBlueButton'un wordpress için yazılmış eklentisinin v.3.0.0 sürümünün çoğaltılmış halidir. Daha fazla bilgi için yazara ulaşabilirsiniz. 
 * Version:           3.0.0-beta.4
 * Author:            Doğan GOGCE
 * Author URI:        https://dogangokce.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       canliders1
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 3.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CANLIDERS1_VERSION', '3.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-canliders1-activator.php
 */
function activate_canliders1() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-canliders1-activator.php';
	Canliders1_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-canliders1-deactivator.php
 */
function deactivate_canliders1() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-canliders1-deactivator.php';
	Canliders1_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_canliders1' );
register_deactivation_hook( __FILE__, 'deactivate_canliders1' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-canliders1.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    3.0.0
 */
function run_canliders1() {

	$plugin = new Canliders1();
	$plugin->run();

}
run_canliders1();
