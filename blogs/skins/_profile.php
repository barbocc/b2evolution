<?php
	/*
	 * This is the template that displays the user profile form
	 *
	 * This file is not meant to be called directly.
	 * It is meant to be called by an include in the _main.php template.
	 * To display a feedback, you should call a stub AND pass the right parameters
	 * For example: /blogs/index.php?disp=profile
	 * Note: don't code this URL by hand, use the template functions to generate it!
	 */
	if( substr(basename($_SERVER['SCRIPT_FILENAME']), 0, 1) == '_' )
		die('Please, do not access this page directly.');

	if( ! is_logged_in() )
	{	// must be logged in!
		echo '<p>', T_( 'You are not logged in.' ), '</p>';
		return;
	}
	// --- //
?>

	<!-- form to add a comment -->
	<form action="<?php echo $htsrv_url ?>/profile_update.php" method="post" class="bComment">

		<input type="hidden" name="checkuser_id" value="<?php echo $user_ID ?>" />

		<fieldset>
			<div class="label"><?php echo T_('Login:') ?></div>
			<div class="input"><?php user_info( 'login', 'htmlhead' ) ?>
				-
				<strong><?php echo T_('ID') ?>:</strong>
				<?php user_info( 'ID', 'raw' ) ?>
			</div>
		</fieldset>

		<fieldset>
			<div class="label"><?php echo T_('Level') ?>:</div>
			<div class="input"><?php echo user_info( 'level', 'raw' ) ?></div>
		</fieldset>

		<fieldset>
			<div class="label"><?php echo T_('Posts') ?>:</div>
			<div class="input"><?php echo user_info( 'num_posts', 'raw' ) ?></div>
		</fieldset>

		<?php
			form_text( 'newuser_firstname', get_user_info( 'firstname' ), 40, T_('First name'), '', 50, 'bComment' );
			form_text( 'newuser_lastname', get_user_info( 'lastname' ), 40, T_('Last name'), '', 50, 'bComment' );
			form_text( 'newuser_nickname', get_user_info( 'nickname' ), 40, T_('Nickname'), '', 50, 'bComment' );
		?>

		<fieldset>
			<div class="label"><label for="newuser_idmode"><?php echo T_('Identity shown') ?>:</label></div>
			<div class="input">
				<?php $idmode = get_user_info( 'idmode' ); ?>
				<select name="newuser_idmode" class="bComment">
					<option value="nickname"<?php if ( $idmode == 'nickname' ) echo ' selected="selected"'; ?>><?php user_info( 'nickname', 'htmlhead' ) ?></option>
					<option value="login"<?php if ( $idmode == 'login' ) echo ' selected="selected"'; ?>><?php user_info( 'login', 'htmlhead' ) ?></option>
					<option value="firstname"<?php if ( $idmode == 'firstname' ) echo ' selected="selected"'; ?>><?php user_info( 'firstname', 'htmlhead' ) ?></option>
					<option value="lastname"<?php if ( $idmode == 'lastname' ) echo ' selected="selected"'; ?>><?php user_info( 'lastname', 'htmlhead' ) ?></option>
					<option value="namefl"<?php if ( $idmode == 'namefl' ) echo ' selected="selected"'; ?>><?php user_info( 'firstname', 'htmlhead' ); echo ' '; user_info( 'lastname', 'htmlhead' ); ?></option>
					<option value="namelf"<?php if ( $idmode == 'namelf' ) echo ' selected="selected"'; ?>><?php user_info( 'lastname', 'htmlhead' ); echo ' '; user_info( 'firstname', 'htmlhead' ); ?></option>
				</select>
		</div>
		</fieldset>


		<?php
			form_text( 'newuser_email', get_user_info( 'email' ), 40, T_('Email'), '', 100, 'bComment' );
			form_text( 'newuser_url', get_user_info( 'url' ), 40, T_('URL'), '', 100, 'bComment' );
			form_text( 'newuser_icq', get_user_info( 'icq' ), 40, T_('ICQ'), '', 40, 'bComment' );
			form_text( 'newuser_aim', get_user_info( 'aim' ), 40, T_('AOL I.M.'), '', 50, 'bComment' );
			form_text( 'newuser_msn', get_user_info( 'msn' ), 40, T_('MSN I.M.'), '', 100, 'bComment' );
			form_text( 'newuser_yim', get_user_info( 'yim' ), 40, T_('Yahoo I.M.'), '', 50, 'bComment' );

			form_checkbox( 'newuser_notify', get_user_info( 'notify' ), T_('Notifications'), T_('Check this to receive notification whenever one of your posts receives comments, trackbacks, etc.') );
		?>

		<fieldset>
			<div class="label"><label for="pass1"><?php echo T_('New password') ?>:</label></div>
			<div class="input"><input type="password" name="pass1" id="pass1" value="" size="16" class="bComment" /></div>
		</fieldset>

		<fieldset>
			<div class="label"><label for="pass2"><?php echo T_('Confirm new password') ?>:</label></div>
			<div class="input"><input type="password" name="pass2" id="pass2" value="" size="16" class="bComment" /></div>
		</fieldset>

		<fieldset>
			<div class="input">
				<input type="submit" name="submit" value="<?php echo T_('Update') ?>" class="search" />
			</div>
		</fieldset>

		<div class="clear"></div>

	</form>

