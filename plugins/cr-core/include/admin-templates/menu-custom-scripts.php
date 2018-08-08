<?php
if (!defined('ABSPATH')) die('-1');
settings_errors( 'cr_settings_messages' );
?>
<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	<form action="options.php" method="post">
		<?php
		settings_fields( 'crsettings' );
		do_settings_sections( 'crsettings' );
		submit_button( 'Save' );
		?>
	</form>
</div>