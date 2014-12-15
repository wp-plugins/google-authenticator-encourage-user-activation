=== Google Authenticator - Encourage User Activation ===
Contributors:      iandunn
Donate link:       http://nhmin.org
Tags:              google authenticator,two factor authentication
Requires at least: 3.1
Tested up to:      4.1
Stable tag:        0.1
License:           GPLv2 or Later

Allows administrators to either nag users to enable two-factor authentication, or force them to enable it.


== Description ==

The [Google Authenticator](http://wordpress.org/plugins/google-authenticator/) plugin is a great way to add two-factor authentication to your site, but in order for it to work, users have to activate it for their account themselves. They may not know that it's available, or may not be motivated to enable it.
  
This plugin helps administrators to encourage users to activate it, and has two different methods for doing that, depending on how strict you want to be:

* Nag the user: An error message will appear at the top of the Administration Panels, asking them to enable two-factor authentication. The message goes away when they enable it. This is the default behavior.
* Force the user: The user will be prevented from doing anything in the Administration Panels until they activate it. They're temporarily assigned the role of a Subscriber, and redirected to their profile whenever they try to access another screen. Once they enable two-factor authentication, their original role is restored and they can access other screens again. 


== Installation ==

For help installing this (or any other) WordPress plugin, please read the [Managing Plugins](http://codex.wordpress.org/Managing_Plugins) article on the Codex.

Once the plugin is installed and activated, you can visit the General Settings screen to choose whether users should be nagged to enable two-factor authentication, or forced to.


== Frequently Asked Questions ==

= Does this replace the Google Authenticator plugin? =
No, this is built on top of the Google Authenticator plugin and requires it in order to work.

= Can I customize the notice that's displayed when a user doesn't have two-factor authentication enabled? =
Yes, you can use the `gaeua_notice_nag` and `gaeua_notice_force` filters. For example, you can copy and paste the following code into <a href="http://wpcandy.com/teaches/how-to-create-a-functionality-plugin/">a functionality plugin</a>:

`add_filter( 'gaeua_notice_nag', 'gaeua_notice_nag' );
function gaeua_notice_nag( $nag ) {
	ob_start();
	?>
	
		<div class="error">
			<p>
				Enter your custom message here.
			</p>
		</div>
	
	<?php
	$nag = ob_get_clean();
	
	return $nag;
}`


== Screenshots ==

1. Under 'Nag' mode, the user has normal access, but will always see a nag message.
2. Under 'Force' mode, the user will always be redirected to their profile, so that they can't do anything until they enable two-factor authentication. 
3. The configuration options on the General Settings page.

== Other Notes ==
Keep in mind that the Google Authenticator plugin doesn’t require users to enter a valid 2FA code from their phone during the activation process, so some users may not set it up correctly and lock themselves out of their account. This is unfortunate and may result in more support requests, but it's a small price to pay for increased security.


== Changelog ==

= v0.1 (2013-12-14) =
* [NEW] Initial release


== Upgrade Notice ==

= 0.1 =
Initial release.