<?php global $wpdb; ?>

<script type="text/javascript">
jQuery(function() {
	jQuery('.admin_section_title').click(function(){
		jQuery(this).next('.admin_section_body').slideToggle(); 
	});
});
</script>

<div class="wrap">
	
        <h2><?php _e( 'Emails', 'bp-ktr' ) ?></h2>
		<br />
		
		<?php foreach($emails as $e):?>
			<div class="admin_section">
				<div class="admin_section_title"><h3><?php echo $e->title ?></h3></div>
				<div class="admin_section_body" style="display:none">
					<form name="email_parts" method="post" >
						<div style="float:left">
							<b>Salutation:</b><br />
							<textarea class="email_salutation" name="email_parts[<?php echo $e->name?>][salutation]"><?php echo $e->salutation?></textarea>
						</div>
						<div style="float:right">
							<b>Footer:</b><br />
							<textarea class="email_footer" name="email_parts[<?php echo $e->name?>][footer]"><?php echo $e->footer?></textarea>
						</div>
						<div style="clear:both"></div>
						
						<p class="submit">
							<input type="submit" value="Save" name="email_save_btn">
						</p>
					</form>
				</div>
				<br />
			</div>
		<?php endforeach; ?>
</div>