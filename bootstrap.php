<?php
/*
Plugin Name: Google Authenticator - Encourage User Activation
Plugin URI:  http://wordpress.org/plugins/google-authenticator-encourage-user-activation
Description: Allows administrators to either nag users to enable two-factor authentication, or force them to enable it.
Version:     0.1
Author:      Ian Dunn
Author URI:  http://iandunn.name
*/

if ( $_SERVER['SCRIPT_FILENAME'] == __FILE__ )
	die( 'Access denied.' );

define( 'GAEUA_REQUIRED_PHP_VERSION', '5.2.4' );  // because of WordPress minimum requirements
define( 'GAEUA_REQUIRED_WP_VERSION',  '3.1' );    // because of get_current_screen()

/**
 * Checks if the system requirements are met
 * @return bool True if system requirements are met, false if not
 */
function gaeua_requirements_met() {
	global $wp_version;
	require_once( ABSPATH . '/wp-admin/includes/plugin.php' );

	if ( version_compare( PHP_VERSION, GAEUA_REQUIRED_PHP_VERSION, '<' ) ) {
		return false;
	}

	if ( version_compare( $wp_version, GAEUA_REQUIRED_WP_VERSION, '<' ) ) {
		return false;
	}
	
	if ( ! is_plugin_active( 'google-authenticator/google-authenticator.php' ) ) {
		return false;
	}

	return true;
}

/**
 * Prints an error that the system requirements weren't met.
 */
function gaeua_requirements_error() {
	global $wp_version;

	require_once( dirname( __FILE__ ) . '/views/requirements-error.php' );
}

/*
 * Check requirements and load main class
 * The main program needs to be in a separate file that only gets loaded if the plugin requirements are met. Otherwise older PHP installations could crash when trying to parse it.
 */
if ( gaeua_requirements_met() ) {
	require_once( dirname( __FILE__ ) . '/classes/google-authenticator-encourage-user-activation.php' );
	require_once( dirname( __FILE__ ) . '/classes/gaeua-settings.php' );
	
	$GLOBALS['gaeua'] = array(
		'GoogleAuthenticatorEncourageUserActivation' => new GoogleAuthenticatorEncourageUserActivation(),
		'GAEUASettings'                              => new GAEUASettings()
	);
} else {
	add_action( 'admin_notices', 'gaeua_requirements_error' );
}