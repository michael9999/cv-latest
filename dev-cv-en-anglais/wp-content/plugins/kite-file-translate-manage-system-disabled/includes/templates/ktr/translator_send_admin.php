<?php global $wpdb; ?>

<?php
	
	$table=$wpdb->prefix.KTR_TRANSLATOR_INFO_TABLE;
    $wp_user_table=$wpdb->prefix.'users';
    $sql="SELECT * from $table as ktr INNER JOIN $wp_user_table as wp ON wp.ID=ktr.default_user_id where ktr.name='u_login'";
    $translators = $wpdb->get_results($sql);
    $translators_select = '';
	if(count($translators)>0){
		foreach($translators as $t){ 
            $options.= "<option value='".$t->user_email."' >".$t->user_login."</option>";
        }
        $translators_select = "<select name='translator_email_addr' id='translator_email_addr'>".$options."</select>";
    }	
?>

<script type="text/javascript">
jQuery(function() {
	jQuery('#send_translator_email_form').submit(function(){ 
		if(jQuery('#send_translator_email_form textarea[name=email_body]').val() == ''){
			alert('Please enter the email text first.');
			jQuery('#send_translator_email_form textarea[name=email_body]').focus();
			return false;
		}
	});
});
</script>

<div class="admin_section_title"><h3>Send documents to translator</h3></div>
<div class="admin_section_body">
	<? if($translators_select):?>
	<form name="send_translator_email_form" id="send_translator_email_form" method="post" >
		<div>
			<b>Translator:</b><br />
			<?php echo $translators_select; ?>
		</div><br />
		<div>
			<b>Email:</b><br />
			<textarea name="email_body" cols="80" rows="10"></textarea>
		</div>
		
		<p class="submit">
			<input type="hidden" name="order_id" value="<?=$_REQUEST['order-id']?>">
			<input type="submit" name="send_translator_email" value="Send">
		</p>
	</form>
	<? else:?>
		Translators cannot be found yet.
	<? endif;?>
</div>
    