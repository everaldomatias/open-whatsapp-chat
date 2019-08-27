<?php

/**
 * Plugin Name:       Open WhatsApp Chat
 * Plugin URI:        https://gitlab.com/everaldomatias/open-whatsapp-chat/
 * Description:       Add a simple button to open WhatsApp chat.
 * Version:           1.0.2
 * Author:            Everaldo Matias
 * Author URI:        https://everaldo.dev
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       open-whatsapp-chat
 * Domain Path:       /languages/
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 */
define( 'OWC_VERSION', '1.0.2' );
define( 'OWC_FILE', __FILE__ );

if ( ! class_exists( 'Open_WhatsApp_Chat' ) ) {

	include_once dirname( OWC_FILE ) . '/includes/class-open-whatsapp-chat.php';
	add_action( 'init', 'owc_load_plugin_textdomain' );
	add_action( 'plugin_action_links_' . plugin_basename( OWC_FILE ), 'owc_add_plugin_action_links', 10, 5 );

}

/**
 * Load the plugin text domain for translation.
 */
function owc_load_plugin_textdomain() {
	load_plugin_textdomain( 'open-whatsapp-chat', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

/**
 * Add link to Settings on plugin action links
 */
function owc_add_plugin_action_links( $links ) {

	$links = array_merge( array(
		'<a href="' . esc_url( admin_url( '/options-general.php?page=open-whatsapp-chat' ) ) . '">' . __( 'Settings', 'open-whatsapp-chat' ) . '</a>'
	), $links );

	return $links;

}
