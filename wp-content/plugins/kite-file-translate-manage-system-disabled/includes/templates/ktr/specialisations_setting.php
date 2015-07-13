<?php global $wpdb; ?>

<script type="text/javascript">
jQuery(function() {
	jQuery('.admin_section_title').click(function(){
		jQuery(this).next('.admin_section_body').slideToggle(); 
	});
});
</script>

<div class="wrap">
	<h2><?php _e( 'Specialisations', 'bp-ktr' ) ?></h2>
	<br />
	
	
	<? if($action == 'new_form' || $action == 'edit_form'):?>
	
		<div class="admin_section">
			<div class="admin_section_title"><h3><?=$title?></h3></div>
			<div class="admin_section_body">
				<form action="<?php echo site_url() . '/wp-admin/'.$mu_path_x.'admin.php?page=ktr-specialisations-setting&action='.$form_action?>" method="post">
					<table class="form-table-file-type-add add-specialiazation">
						<tr valign="top">                                        
							<th scope="row"><label for="ktr_user_name">Specialisation</label></th>
							<td>
								<input name="s_name" type="text" value="<?php echo $s; ?>" size="50" />
							</td>
						</tr>                            
									   
						<tr valign="top">
							<th  align="center" class="submit">						
								<input type="hidden" name="s_id" value="<?php echo $s_id; ?>" />
								<input type="submit" name="Save" value="Save"/>
							</th>
						</tr>
					</table>
				</form>
			</div>
		</div>
		
	<? else: ?>
		
		<div class="admin_section">
			<div class="admin_section_title"><h3>Specialisations List</h3></div>
			<div class="admin_section_body">
				<table class="form-table-type ffs_tran" style="width:50%;margin-bottom:10px;">
					<tr valign="top">
						<th scope="row" class="serial"><label for="target_uri"><?php _e( 'Specialisation', 'bp-ktr' ) ?></label></th>
						<th scope="row" align="left" width="130"><label for="target_uri"><?php _e( 'Action', 'bp-ktr' ) ?></label></th>
					</tr>    
					
					<?php foreach($specialisations as $s):?>
					<tr>
						<td>
							<?php echo $s->ktr_specialization;?>
						</td>
						<td class="submit">
							<a href="<?php echo site_url() . '/wp-admin/admin.php?page=ktr-specialisations-setting&action=edit_form&id='.$s->ktr_apecialization_id; ?>">Edit</a>
							<a href="javascript:if(confirm('Are you sure?')) document.location = '<?php echo site_url() . '/wp-admin/admin.php?page=ktr-specialisations-setting&action=delete&id='.$s->ktr_apecialization_id; ?>'">Delete</a>              
						</td>
										
					</tr>
					<?php  endforeach;?>                   
									
				</table>
				
				<p class="submit">
					<input type="button" value="New Specialisation" onclick="document.location='<?php echo site_url() . '/wp-admin/admin.php?page=ktr-specialisations-setting&action=new_form' ?>'">
				</p>
				
			</div>
			<br />
		</div>
		
	<? endif; ?>	
	
</div>
    