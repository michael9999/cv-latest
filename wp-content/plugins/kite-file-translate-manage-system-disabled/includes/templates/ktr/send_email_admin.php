<?php global $wpdb; ?>

<?php
	
	$table=$wpdb->prefix.KTR_ORDER_INFO_TABLE;
	$sql = $wpdb->prepare( "SELECT * FROM $table where ktr_order_id = %d ", $_REQUEST['order-id'] );
	$order = $wpdb->get_row($sql);
	$user_id=$order->ktr_order_from;
	$user_info = get_userdata($user_id);
	$user_info->user_email;
?>

<script type="text/javascript">
jQuery(function() {
	jQuery('#send_email_form').submit(function(){ 
		if(jQuery('#send_email_form textarea[name=email_body]').val() == ''){
			alert('Please enter the email text first.');
			jQuery('#send_email_form textarea[name=email_body]').focus();
			return false;
		}
	});
});
</script>

<div class="admin_section_title"><h3>Send email to customer</h3></div>
<div class="admin_section_body">
	<form name="send_email_form" id="send_email_form" method="post" >
		<div>
			<b>Email:</b><br />
			<textarea name="email_body" cols="80" rows="10"></textarea>
		</div>
		
		<p class="submit">
			<input type="hidden" name="customer_email_address" value="<?=$user_info->user_email?>">
			<input type="submit" name="send_email" value="Send">
		</p>
	</form>
</div>
    