<?php // There are more semantic ways to mark this up, but this is closest to how Core does it, and avoids the need to add CSS rules to make it visually consistent with Core ?>

<fieldset>
	<label for="gaeua_mode_nag">
		<input id="gaeua_mode_nag" name="gaeua_settings[mode]" type="radio" value="nag" <?php checked( $this->settings['mode'], 'nag' ); ?> />
		<strong>Nag</strong> the user
	</label><br />

	<label for="gaeua_mode_force">
		<input id="gaeua_mode_force" name="gaeua_settings[mode]" type="radio" value="force" <?php checked( $this->settings['mode'], 'force' ); ?> />
		<strong>Force</strong> the user
	</label>
</fieldset>