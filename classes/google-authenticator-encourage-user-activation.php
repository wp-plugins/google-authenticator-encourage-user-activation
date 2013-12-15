<?php

/**
 * Core plugin functionality
 * @package GoogleAuthenticatorEncourageUserActivation
 */
class GoogleAuthenticatorEncourageUserActivation {
	protected $settings;
	
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'init' ), 11 );                           // after GAEUASettings->init() so that settings are available
		add_action( 'init', array( $this, 'encourage_users_to_enable_2fa' ), 12 );	// after $this->init() so that variables are available
	}

	/**
	 * Initialize variables
	 */
	public function init() {
		$this->settings = $GLOBALS['gaeua']['GAEUASettings']->settings;
	}

	/**
	 * Encourage users to enable two-factor authentication, either by nagging or by forcing
	 */
	public function encourage_users_to_enable_2fa() {
		$user_has_2fa_enabled = 'enabled' == trim( get_user_option( 'googleauthenticator_enabled', get_current_user_id() ) );
		
		if ( ! $user_has_2fa_enabled ) {
			if ( 'force' == $this->settings['mode'] ) {
				add_filter( 'user_has_cap', array( $this, 'restrict_user_capabilities' ), 10, 3 );

				if ( is_admin() ) {
					add_action( 'current_screen', array( $this, 'redirect_to_profile' ) );
				}
			}

			add_action( 'admin_notices', array( $this, 'enable_2fa_notice' ) );
		}
	}
	
	/*
	* This temporarily gives the user the role of a Subscriber
	* It also prevents them from working around ga_redirect_to_profile() by using XML-RPC, an AJAX request, or the JSON API
	* Once they enable 2FA, they'll be restored to their original role
	*
	* @param array $all_caps
	* @param array $caps
	* @param array $has_cap_args
	* @return array
	*/
	public function restrict_user_capabilities( $all_caps, $caps, $has_cap_args ) {
		$capabilities = apply_filters( 'gaeua_restricted_capabilities', array( 'subscriber' => true, 'read' => true ) );
		
		return $capabilities;
	}
	
	/**
	 * Redirect the user to their profile whenever they try to visit a different screen
	 * This isn't usually necessary, since WordPress will prevent Subscribers from visiting other Core screens, but
	 * sometimes plugins add screens that are available to Subscribers (either intentionally or not)
	 */
	public function redirect_to_profile() {
		if( 'profile' != get_current_screen()->base ) {
			wp_safe_redirect( admin_url( 'profile.php' ) );
			die();
		}
	}

	/**
	 * Displays a notice to the user, either nagging them to enable 2FA, or notifying them that they can't do anything
	 * until they enable it.
	 */
	public function enable_2fa_notice() {
		$custom_notice = apply_filters( 'gaeua_notice_' . $this->settings['mode'], false );
		
		if ( $custom_notice ) {
			echo $custom_notice;
		} else {
			require_once( sprintf( '%s/views/%s-notice.php', dirname( dirname( __FILE__ ) ), $this->settings['mode'] ) );
		}
	}
} // end GoogleAuthenticatorEncourageUserActivation