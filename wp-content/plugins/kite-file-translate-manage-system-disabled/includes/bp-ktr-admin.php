<?php

/***
 * This file is used to add site administration menus to the WordPress backend.
 *
 * If you need to provide configuration options for your component that can only
 * be modified by a site administrator, this is the best place to do it.
 *
 * However, if your component has settings that need to be configured on a user
 * by user basis - it's best to hook into the front end "Settings" menu.
 */

/**
 * bp_ktr_admin()
 *
 * Checks for form submission, saves component settings and outputs admin screen HTML.
 */



function bp_ktr_admin() {
	global $bp;

	/* If the form has been submitted and the admin referrer checks out, save the settings */
	if ( isset( $_POST['submit'] ) && check_admin_referer('ktr-settings') ) {
		update_option( 'ktr-setting-one', $_POST['ktr-setting-one'] );
		update_option( 'ktr-setting-two', $_POST['ktr-setting-two'] );

		$updated = true;
	}

	$setting_one = get_option( 'ktr-setting-one' );
	$setting_two = get_option( 'ktr-setting-two' );
?>
	<div class="wrap">
		<h2><?php _e( 'Example Admin', 'bp-ktr' ) ?></h2>
		<br />

		<?php if ( isset($updated) ) : ?><?php echo "<div id='message' class='updated fade'><p>" . __( 'Settings Updated.', 'bp-ktr' ) . "</p></div>" ?><?php endif; ?>

		<form action="<?php echo site_url() . '/wp-admin/'.$mu_path_x.'admin.php?page=bp-ktr-settings' ?>" name="ktr-settings-form" id="ktr-settings-form" method="post">

			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="target_uri"><?php _e( 'Option One', 'bp-ktr' ) ?></label></th>
					<td>
						<input name="ktr-setting-one" type="text" id="ktr-setting-one" value="<?php echo attribute_escape( $setting_one ); ?>" size="60" />
					</td>
				</tr>
					<th scope="row"><label for="target_uri"><?php _e( 'Option Two', 'bp-ktr' ) ?></label></th>
					<td>
						<input name="ktr-setting-two" type="text" id="ktr-setting-two" value="<?php echo attribute_escape( $setting_two ); ?>" size="60" />
					</td>
				</tr>
			</table>
			<p class="submit">
				<input type="submit" name="submit" value="<?php _e( 'Save Settings', 'bp-ktr' ) ?>"/>
			</p>

			<?php
			/* This is very important, don't leave it out. */
			wp_nonce_field( 'ktr-settings' );
			?>
		</form>
	</div>
<?php
}


function ktr_settings_page(){
   	global $bp;

	/* If the form has been submitted and the admin referrer checks out, save the settings */
	if ( isset( $_POST['submit'] ) && check_admin_referer('ktr-basic-settings') ) {
		update_option( 'ktr-setting-quote', $_POST['ktr-setting-quote'] );
		update_option( 'ktr-setting-paypal_email', $_POST['ktr-setting-paypal_email'] );
                update_option( 'ktr-setting-admin_email', $_POST['ktr-setting-admin_email'] );
                update_option( 'payment-currency', $_POST['ktr-setting-payment-currency'] );
                $currency=get_option('payment-currency');
                if($currency=="USD"){
                    update_option("ktr_currency","$");
                }
                if($currency=="GBP"){
                    update_option("ktr_currency","£");
                }
                if($currency=="EU"){
                    update_option("ktr_currency","€");
                }

		update_option( 'ktr-setting-captcha', $_POST['ktr-setting-captcha'] );
				
		$updated = true;
	}

	$setting_quote = get_option( 'ktr-setting-quote' );
	$setting_paypal = get_option( 'ktr-setting-paypal_email' );
        $ktr_admin_email = get_option( 'ktr-setting-admin_email' );
       $payment_currency = get_option('payment-currency');
        if($setting_quote=='automatic'){
            $check_automatic='checked=';
        }else{
            $check_automatic='';
        }
        
        if($setting_quote=='manual'){
             $checked_manual='checked=';
         }else{
             $checked_manual='';
        }
		
	$setting_captcha = get_option( 'ktr-setting-captcha' );
	if($setting_captcha=='no'){
		$check_captcha_yes = '';
		$check_captcha_no  = 'checked';
	}else{
		$check_captcha_yes = 'checked';
		$check_captcha_no  = 'no';
	}
        
?>
	<div class="wrap">
		<h2><?php _e( 'General Settings', 'bp-ktr' ) ?></h2>
		<br />

		<?php if ( isset($updated) ) : ?><?php echo "<div id='message' class='updated fade'><p>" . __( 'Settings Updated.', 'bp-ktr' ) . "</p></div>" ?><?php endif; ?>
                <div id="add_language"><h3>Add Settings</h3></div>
                <div class="add-new"> 
		<form action="<?php echo site_url() . '/wp-admin/'.$mu_path_x.'admin.php?page=ktr-settings-menu' ?>" name="ktr-basic-settings-form" id="ktr-settings-form" method="post">

			<table class="form-table">
                            <tr valign="top">
                                <th scope="row" class="ffs_th" ><label for="target_uri"><?php _e( 'Quote', 'bp-ktr' ) ?></label></th>
                                <td>
                                <input name="ktr-setting-quote"   type="radio" id="ktr-setting-quote1" value="automatic"  <?php echo $check_automatic; ?> /> Automatic
                                <input name="ktr-setting-quote"   type="radio" id="ktr-setting-quote2" value="manual"  <?php echo $checked_manual; ?> /> Manual
                                </td>
                            </tr>
                                <th scope="row" class="ffs_th"><label for="target_uri"><?php _e( 'Paypal Email', 'bp-ktr' ) ?></label></th>
                                <td>
                                <input name="ktr-setting-paypal_email" type="text" id="ktr-setting-two" value="<?php echo attribute_escape( $setting_paypal ); ?>" size="60" />
                                </td>
                            </tr>
                            </tr>
                                <th scope="row" class="ffs_th"><label for="target_uri"><?php _e( 'Admin Email', 'bp-ktr' ) ?></label></th>
                                <td>
                                <input name="ktr-setting-admin_email" type="text" id="ktr-setting-admin-email" value="<?php echo attribute_escape( $ktr_admin_email ); ?>" size="60" />
                                </td>
                            </tr>
                           </tr>
                                <th scope="row" class="ffs_th"><label for="target_uri"><?php _e( 'Currency', 'bp-ktr' ) ?></label></th>
                                <td>
                                <?php currency_drop_down('ktr-setting-payment-currency', $payment_currency); ?>
                                </td>
                            </tr>
				<tr valign="top">
					<th scope="row" class="ffs_th" ><label for="target_uri"><?php _e( 'Captcha', 'bp-ktr' ) ?></label></th>
					<td>
					<input name="ktr-setting-captcha" type="radio" value="yes"  <?php echo $check_captcha_yes; ?> /> Yes
					<input name="ktr-setting-captcha" type="radio" value="no"  <?php echo $check_captcha_no; ?> /> No
					</td>
				</tr>
			</table>
			<p class="submit">
				<input type="submit" name="submit" value="<?php _e( 'Save Settings', 'bp-ktr' ) ?>"/>
			</p>
			<?php
			/* This is very important, don't leave it out. */
			wp_nonce_field( 'ktr-basic-settings' );
			?>
		</form>
            </div>
	</div>
<?php
}

function ktr_language_price_setting(){
    global $bp;

       

      if(isset( $_POST['update_language'] ) && check_admin_referer('ktr-settings-language-price')){
       
        if(count($_REQUEST['ktr-select-language'])>0){
         global $wpdb;
        $table = $wpdb->prefix . KTR_LANGUAGE_TABLE;
		//print_r($_REQUEST); exit;
            foreach($_REQUEST['ktr-select-language'] as $key=>$val){
                if($_REQUEST['ktr-language-from'][$val]==""||$_REQUEST['ktr-language-to'][$val]==""){
                    $update_error=true;
                   
                    }else{
                    $table = $wpdb->prefix . KTR_LANGUAGE_TABLE;
					$default_translator = isset($_REQUEST['default_translator'][$val]) ? $_REQUEST['default_translator'][$val] : 0;
                    $auto_send = isset($_REQUEST['ktr-language-automatic'][$val]) ? 1 : 0;
					$sql = $wpdb->prepare(
                            "UPDATE $table SET
                                    ktr_trnslt_from  = '".$_REQUEST['ktr-language-from'][$val]."',
                                    ktr_trnslt_to ='".$_REQUEST['ktr-language-to'][$val]."',
                                    ktr_price_per_word = '".$_REQUEST['ktr-price'][$val]."',
                                    auto_send = '".$auto_send."',
                                    default_translator = '". $default_translator ."'
                            WHERE ktr_laguage_id  = '%s'"
                            , $val);
                    $updated= $wpdb->query($sql);
                    $table_type="";
                    $table_type=$wpdb->prefix.KTR_FILE_TYPE_TABLE;
                    $type_resource=$wpdb->prepare("Select * from ".$table_type." ORDER BY  ktr_file_type asc", '');
                    $up_all_types=$wpdb->get_results($type_resource);
                    
                    foreach($up_all_types as $up_r){
						$up_r->ktr_file_type_id;
						$table = $wpdb->prefix . KTR_LANGUAGE_TABLE;
						$update_type_price_sql="";
						$type_field_name="ktr-language-".$up_r->ktr_file_type."-price-".$val;
		//                  echo "<pre>";
		//                    var_dump($_REQUEST[$type_field_name]);
		//                     echo "</pre>";
		//                    
						if($_REQUEST[$type_field_name][$val]==""){
							$update_error=true;
						   print_r($_REQUEST); exit();
						}else{
							$update_type_price_sql = $wpdb->prepare(
								"UPDATE ".$wpdb->prefix.KTR_TYPE_BASE_PRICE_TABLE." SET
								ktr_type_base_price  = '".$_REQUEST[$type_field_name][$val]."'
								WHERE ktr_type_language  = '".$val."' and ktr_type=".$up_r->ktr_file_type_id, '');
							$updated= $wpdb->query( $update_type_price_sql); 
							if(!$updated){ //The row doesn't exist. So it should be inserted.
								$wpdb->query($wpdb->prepare(
								"INSERT INTO ".$wpdb->prefix.KTR_TYPE_BASE_PRICE_TABLE." SET
									ktr_type_base_price  = '".$_REQUEST[$type_field_name][$val]."',
									ktr_type_language  = '".$val."',
									ktr_type=".$up_r->ktr_file_type_id, '')); 
							}
						}
                    } 
                }
            }
            $type_resource="";
            
          }
        
         
           //echo "<script type='text/javascript'>window.location='".  site_url().'/wp-admin/admin.php?page=ktr_language_setting'."';</script>";
        }
        
      if(isset( $_POST['delete_laguage'] ) && check_admin_referer('ktr-settings-language-price')){
        global $wpdb;
      
        $table = $wpdb->prefix . KTR_LANGUAGE_TABLE;
        
        if(is_array($_REQUEST['ktr-select-language'])){
            foreach($_REQUEST['ktr-select-language'] as $val){
               $wpdb->query( $wpdb->prepare( "DELETE FROM $table WHERE ktr_laguage_id = %d  ", $val ) );
               $wpdb->query( $wpdb->prepare( "DELETE FROM ".$wpdb->prefix.KTR_TYPE_BASE_PRICE_TABLE." WHERE ktr_type_language = %d  ", $val ) );
            }
            $delete=true;
               //echo "<script type='text/javascript'>window.location='".  site_url().'/wp-admin/admin.php?page=ktr_language_setting'."';</script>";
          }
        }

	/* If the form has been submitted and the admin referrer checks out, save the settings */
           global $wpdb;
            $type_val_check=$wpdb->prepare("Select * from ".$wpdb->prefix.KTR_FILE_TYPE_TABLE." ORDER BY  ktr_file_type asc", '');
            $all_types_val_check=$wpdb->get_results($type_val_check);
            foreach($all_types_val_check as $check_val){
                $typ_check_name='ktr-language-'.$check_val->ktr_file_type.'-price';
                if($_REQUEST[$typ_check_name]==""||$_REQUEST[$typ_check_name]=="0"){
                    $type_val_null='type_val_insert_error';
                    
                }
            }
	
	if ( isset( $_POST['submit'] ) && check_admin_referer('ktr-settings-language-price')) {
	
            if($_POST['ktr-language-from']!=""&&$_POST['ktr-language-to']!=""&&$type_val_null!="type_val_insert_error"){
            global $wpdb;
            $sql = $wpdb->prepare(
                "INSERT INTO ".$wpdb->prefix.KTR_LANGUAGE_TABLE." (
                        ktr_trnslt_from  ,
                        ktr_trnslt_to  ,
                        ktr_price_per_word
                ) VALUES (
                            %s, %s, %d
                    )",
                    $_POST['ktr-language-from'],
                    $_POST['ktr-language-to'],
                    $_POST['ktr-language-price']
                    );
              $result = $wpdb->query( $sql );
              $insert_id=$wpdb->insert_id;

                $type_resource=$wpdb->prepare("Select * from ".$wpdb->prefix.KTR_FILE_TYPE_TABLE." ORDER BY  ktr_file_type asc", '');
                $all_types=$wpdb->get_results($type_resource);
                foreach($all_types as $r){
                     $sql = $wpdb->prepare(
                "INSERT INTO ".$wpdb->prefix.KTR_TYPE_BASE_PRICE_TABLE." (
                        ktr_type_language ,
                        ktr_type,
                        ktr_type_base_price
                ) VALUES (
                            %d, %d, %s
                    )",
                    $insert_id,
                    $r->ktr_file_type_id,
                    $_POST['ktr-language-'. $r->ktr_file_type.'-price']
                    );
               $result = $wpdb->query( $sql );
                    
                }
		$added = true;
               // echo "<script type='text/javascript'>window.location='".  site_url().'/wp-admin/admin.php?page=ktr-language-setting'."';</script>";
            }else{
                $insert_error=true;
            }
	}
        
        global $wpdb;
        $table = $wpdb->prefix . KTR_LANGUAGE_TABLE;
        $sql = $wpdb->prepare( "SELECT * FROM $table  ORDER BY ktr_laguage_id desc", '' );
        $get_language = $wpdb->get_results($sql);

	
      
            //delete_option('ktr-setting-language-price');
        
?>
	<div class="wrap">
		<h2><?php _e( 'Language & Price', 'bp-ktr' ) ?></h2>
		<br />
                <?php if ( isset($added) ) : ?><?php echo "<div id='message' class='updated fade'><p>" . __( 'Added a new language.', 'bp-ktr' ) . "</p></div>" ?><?php endif; ?>
		<?php if ( isset($updated) ) : ?><?php echo "<div id='message' class='updated fade'><p>" . __( 'Settings Updated.', 'bp-ktr' ) . "</p></div>" ?><?php endif; ?>
                <?php if ( isset($insert_error) ) : ?><?php echo "<div id='message' class='updated fade'><p>" . __( 'All field value should be given for adding a new language.', 'bp-ktr' ) . "</p></div>" ?><?php endif; ?>
                  <?php if ( isset($update_error) ) : ?><?php echo "<div id='message' class='updated fade'><p>" . __( 'All field value should be given for updating a existing language.', 'bp-ktr' ) . "</p></div>" ?><?php endif; ?>
               <?php if ( isset($delete) ) : ?><?php echo "<div id='message' class='updated fade'><p>" . __( 'Deleted.', 'bp-ktr' ) . "</p></div>" ?><?php endif; ?>
               
                    <div id="add_language"><h3>Add New</h3></div>
			
                        <div class="add-new">  
                       <form action="<?php echo site_url() . '/wp-admin/'.$mu_path_x.'admin.php?page=ktr-language-setting' ?>" name="ktr-language-settings-form" id="ktr-settings-form" method="post">

			<table class="form-table-language-add">
				<tr valign="top">
                                        
					<th scope="row"><label for="target_uri"><?php _e( 'From', 'bp-ktr' ) ?></label>
                                        <input name="ktr-language-from" type="text" id="" value="" size="30" />
					</th>
                                        <th scope="row"><label for="target_uri"><?php _e( 'To', 'bp-ktr' ) ?></label>
                                        <input name="ktr-language-to" type="text" id="" value="" size="30" />
					</th>
                                        <th scope="row"><label for="target_uri"><?php _e( 'Price', 'bp-ktr' ) ?></label></th>
                                        <th scope="row" style="text-align: left;">
                                        <!--<input name="ktr-language-price" type="text" id="" value="" size="30" />-->
                                         <?php 
                                            global $wpdb;
                                            global $bp;
                                            $table='';
                                           $table=$wpdb->prefix.KTR_FILE_TYPE_TABLE;
                                         $type_resource=$wpdb->prepare("Select * from ".$table." ORDER BY  ktr_file_type asc", '');
                                            $all_types=$wpdb->get_results($type_resource);
                                             foreach($all_types as $r){
                                                 
                                            ?>
						<input name="ktr-language-<?php echo $r->ktr_file_type; ?>-price" type="text" id="" value="" size="30" /><?php echo $r->ktr_file_type ; ?><br />
                                             <?php } ?>
					</th>
					
				</tr>
                                <tr>
                                    <td colspan="4" align="center">
                                        <p class="submit">
				<input type="submit" name="submit" value="<?php _e( 'Add', 'bp-ktr' ) ?>"/>
			</p>
                                    </td>
                                </tr>
					
                               
			</table>
                           
                        <?php
			/* This is very important, don't leave it out. */
			wp_nonce_field( 'ktr-settings-language-price' );
			?>
                    </form>
                      
<?php if(count($get_language) >=1):?>
                        </div>
	
	<script type="text/javascript">
		jQuery(function() {
			jQuery("input[name='update_language']").click(function() {
				if(jQuery('input[name="ktr-language-automatic[]"]:checked').length > 0){ //Something is checked
					var checkboxes = jQuery('input[name="ktr-language-automatic[]"]');
					
					var return_ = true;
					jQuery.each(checkboxes, function() {						
						//Checkbox is checked, but translator not selected from the list
						if(jQuery(this).attr('checked') && jQuery(this).prev().prev().val() == ""){ 
							alert('You need to adjust default translator(s) first.');	
							return_ = false;
						}
					});
					return return_;
				}
			});	
		});	
	 
	 </script> 
						
    <div id="add_language"><h3>List Language & Price</h3></div>
			
      <div class="add-new">  
		<form action="<?php echo site_url() . '/wp-admin/'.$mu_path_x.'admin.php?page=ktr-language-setting' ?>" name="ktr-basic-settings-update" id="ktr-basic-settings-update" method="post" >

			<table class="form-table-language">
				<tr valign="top">
                    <th scope="row">&nbsp;</th>
					<th scope="row"><label for="target_uri"><?php _e( 'From', 'bp-ktr' ) ?></label></th>
                    <th scope="row"><label for="target_uri"><?php _e( 'To', 'bp-ktr' ) ?></label></th>
                    <th scope="row"><label for="target_uri"><?php _e( 'Price', 'bp-ktr' ) ?></label></th>
                    <th scope="row"><label for="target_uri"><?php _e( 'Automatic Settings', 'bp-ktr' ) ?></label></th>
                </tr>
				
                             
                <?php foreach($get_language as $val):?>
                <tr valign="top">
					<td>
                       <input class="ktr_checkbox" name="ktr-select-language[]" type="checkbox" id="" value="<?php echo $val->ktr_laguage_id ; ?>" />
					</td>
                    <td>
                       <input name="ktr-language-from[<?php echo $val->ktr_laguage_id ; ?>]" type="text" id="" value="<?php echo $val->ktr_trnslt_from ?>" size="30" />
					</td>
                    <td>
                       <input name="ktr-language-to[<?php echo $val->ktr_laguage_id ; ?>]" type="text" id="" value="<?php echo $val->ktr_trnslt_to; ?>" size="30" />
					</td>
					<td>
						<?php 
						global $wpdb;
						global $bp;
						$table='';
						$table=$wpdb->prefix.KTR_FILE_TYPE_TABLE;
						$type_resource="";
						$type_resource=$wpdb->prepare("Select * from ".$table." ORDER BY  ktr_file_type asc", '');
						$all_types=$wpdb->get_results($type_resource);
						 foreach($all_types as $r){
							 $type_price="";
							
						 $type_price=$wpdb->prepare("Select * from ".$wpdb->prefix.KTR_TYPE_BASE_PRICE_TABLE." where ktr_type_language=".$val->ktr_laguage_id." and ktr_type=".$r->ktr_file_type_id, '');
							$type_price=$wpdb->get_row($type_price);
							 
						?>
						<input name="ktr-language-<?php echo $r->ktr_file_type; ?>-price-<?php echo $val->ktr_laguage_id ; ?>[<?php echo $val->ktr_laguage_id ; ?>]" type="text" id="" value="<?php echo $type_price->ktr_type_base_price; ?>" size="30" /><?php echo $r->ktr_file_type; ; ?><br />
                        <?php } ?>
					</td>
					<td>
						<?php if($translator_select = z_translator_list($val->ktr_laguage_id, $val->default_translator)): ?>
							<?php echo $translator_select ?><br />
							<input name="ktr-language-automatic[<?php echo $val->ktr_laguage_id ; ?>]" type="checkbox" value="1" <?php echo ($val->auto_send ? 'checked' :'' ) ?> /> Automatic send to default translator
						<?php endif; ?>
					</td>
				</tr>
                <?php  endforeach;?>
                               
                <tr>
					
                    <td colspan="5">
						<input class="chk_validate11111" type="submit" name="update_language" value="<?php _e( 'Update', 'bp-ktr' ) ?>"/>
                        <input class="ktr_delete" type="submit" name="delete_laguage" value="<?php _e( 'Delete', 'bp-ktr' ) ?>"/>
					</td>
                                        
				</tr>
			</table>
                    <?php
			/* This is very important, don't leave it out. */
			wp_nonce_field( 'ktr-settings-language-price' );
			?>
                    </form>
                 <?php endif;?>
                

		  </div>	
		
	</div>
<?php
}
function ktr_file_setting(){
        global $wpdb;
        $table = $wpdb->prefix . KTR_FILE_TYPE_TABLE;
    	/* If the form has been submitted and the admin referrer checks out, save the settings */
	if ( isset( $_POST['submit'] ) && check_admin_referer('ktr-settings-file-type')) {
            if($_POST['ktr-file-type']!=""){
         
            $sql = $wpdb->prepare(
                "INSERT INTO $table (
                        ktr_file_type
                ) VALUES (
                            %s
                    )",
                    $_POST['ktr-file-type']
                 
                    );
                $result = $wpdb->query( $sql );
		$updated = true;
               // echo "<script type='text/javascript'>window.location='".  site_url().'/wp-admin/admin.php?page=ktr_language_setting'."';</script>";
            }
	}
        
        
      if(isset( $_POST['update_file_type'] ) && check_admin_referer('ktr-update-file-type')){
       
        if(count($_REQUEST['ktr-selected-file-type'])>0){
         
            foreach($_REQUEST['ktr-selected-file-type'] as $key=>$val){
             
             $sql = $wpdb->prepare(
				"UPDATE $table SET
					ktr_file_type  = '".$_REQUEST['ktr-file-type'][$key]."'
                                WHERE ktr_file_type_id  = '".$val."'", ''
				);
          $updated= $wpdb->query($sql);
         
  
            }
            
          }
        
         
        
        }
        
        
          if(isset( $_POST['delete_file_type'] ) && check_admin_referer('ktr-update-file-type')){
     
        
        if(is_array($_REQUEST['ktr-selected-file-type'])){
            
            foreach($_REQUEST['ktr-selected-file-type'] as $val){
               
               $updated= $wpdb->query( $wpdb->prepare( "DELETE FROM $table WHERE ktr_file_type_id = %d  ", $val ) );
	
  
            }
            
               //echo "<script type='text/javascript'>window.location='".  site_url().'/wp-admin/admin.php?page=ktr_language_setting'."';</script>";
          }
        
         
        }
        
       
        $sql = $wpdb->prepare( "SELECT * FROM $table  ORDER BY ktr_file_type_id desc", '' );
        $get_file_type = $wpdb->get_results($sql);

 ?>
	<div class="wrap">
		<h2><?php _e( 'Translation Type', 'bp-ktr' ) ?></h2>
		<br />
                

		<?php if ( isset($updated) ) : ?><?php echo "<div id='message' class='updated fade'><p>" . __( 'File Type Updated.', 'bp-ktr' ) . "</p></div>" ?><?php endif; ?>
                <div id="add_language"><h3>Add New</h3></div>
                <div class="add-new">     
                    
                       <form action="<?php echo site_url() . '/wp-admin/'.$mu_path_x.'admin.php?page=ktr-file-type-setting' ?>" name="ktr-language-settings-form" id="ktr-settings-form" method="post">
			<table class="form-table-file-type-add">
				<tr valign="top">
                                        
					<th scope="row"><label for="target_uri"><?php _e( 'Type', 'bp-ktr' ) ?></label>
                                        <input name="ktr-file-type" type="text" id="ktr-file-type" value="" size="30" />
					</th>
                                       
                                    <th  align="center" class="submit">
                                       
                                            <input type="submit" name="submit" value="<?php _e( 'Add', 'bp-ktr' ) ?>"/>
                                       
                                    </th>
                                	
				</tr>
                           
					
                               
			</table>
                           
                        <?php
			/* This is very important, don't leave it out. */
			wp_nonce_field( 'ktr-settings-file-type' );
			?>
                    </form>
                </div>
<?php if(count($get_file_type) >=1):?>
                 <div id="add_language"><h3>Type List</h3></div>
                 <div class="add-new">  
		<form action="<?php echo site_url() . '/wp-admin/'.$mu_path_x.'admin.php?page=ktr-file-type-setting' ?>" name="ktr-basic-settings-update" id="ktr-basic-settings-update" method="post" >

			<table class="form-table-type">
				<tr valign="top">
                                    <th scope="row" class="serial">&nbsp;</th>
                                    <th scope="row" align="left"><label for="target_uri"><?php _e( 'Type', 'bp-ktr' ) ?></label></th>
                               
                                </tr>
					
				<tr>
                             
                                    <?php foreach($get_file_type as $val):?>
                                       
					<td>
						<input class="ktr_checkbox" name="ktr-selected-file-type[]" type="checkbox" id="" value="<?php echo $val->ktr_file_type_id; ?>" />
                                                
					</td>
                                        <td>
						<input name="ktr-file-type[]" type="text" id="" value="<?php echo $val->ktr_file_type; ?>" size="30" />
					</td>
                                    
				</tr>
                                <?php  endforeach;?>
                               
                                </tr>
					
                                <td colspan="2" class="submit">
						<input class="chk_validate" type="submit" name="update_file_type" value="<?php _e( 'Update', 'bp-ktr' ) ?>"/>
                                                <input class="ktr_delete" type="submit" name="delete_file_type" value="<?php _e( 'Delete', 'bp-ktr' ) ?>"/>
					</td>
                                        
				</tr>
			</table>
                    <?php
			/* This is very important, don't leave it out. */
			wp_nonce_field( 'ktr-update-file-type' );
			?>
                    </form>
                 <?php endif;?>


		</div>	
		
	</div>
<?php   
}
function currency_drop_down($name,$select='',$id=''){
    $currency=array("USD","GBP","EU");
    $id=($id!='')?$id:$name;

 ?>
<select name="<?php echo $name; ?>" id="<?php echo $d; ?>" >
    <?php for($i=0; $i< count($currency) ;$i++){?>
    
            <?php if($select==$currency[$i]){
               $selected="selected='selected'";
                }else{
                    $selected=""; 
                }
            ?>
            <option value="<?php echo $currency[$i]; ?>" <?php echo $selected; ?> > <?php  echo $currency[$i]; ?> </option>
    
    <?php }?>
</select>
<?php
}
function ktr_admin_order_view(){
	global $wpdb, $bp;
       
        
	// Send comment [zura]. Template: comments_admin.php -------------------------------------------- 
	$order_id = $_REQUEST['order-id'];		
	if($_REQUEST['send_comment']){		
		bp_ktr_post_comment($order_id);
	}
	
	// Send email to customer [zura]. Template: send_email_admin.php ---------------------------------
	if($_REQUEST['send_email']){		
		$cc = '';
		$reply_to = '';
		bp_ktr_send_email($_REQUEST['customer_email_address'], nl2br($_REQUEST['email_body']), $cc, $reply_to);
	}	
		 
		
	// Additional form. Sends documents to translator once client uploads them. Template: translator_send_admin.php ---------------------------------
	if($_REQUEST['send_translator_email']){		
		$cc = '';
		$reply_to = '';
		bp_ktr_send_translator_email($_REQUEST['order_id'], $_REQUEST['translator_email_addr'], nl2br($_REQUEST['email_body']), $cc, $reply_to);
	}		
		
		
		
		
		
		$nonce=$_REQUEST['_wpnonce'];
		
        if (isset($_REQUEST['order_id'])&& $_REQUEST['page']=='ktr-order-view') {
        if($_REQUEST['ord_prc'] && check_admin_referer('ktr-order-price')){
        $table=$wpdb->prefix.KTR_ORDER_INFO_TABLE;
        $wpdb->query(
                    "
                    UPDATE $table 
                    SET ktr_price =".$_POST['ord_prc'] .",
                        ktr_currency_code='". $_REQUEST['rdCurrency']."',
                        status =".AWATING_CLIENT_ACCEPTANCE ."
                    WHERE ktr_order_id = '{$_REQUEST['order_id']}'");
        
       
            $sql = $wpdb->prepare( "SELECT * FROM $table where ktr_order_id='%d'
					ORDER BY ktr_id desc", $_REQUEST['order-id'] );
            $order = $wpdb->get_row($sql);
             $user_id=$order->ktr_order_from;
            $user_info = get_userdata($user_id);
             $user_name=$user_info->user_login;
            $user_email=$user_info->user_email ;
            $page_number=$order->ktr_page_number;
            $word_number=$order->ktr_order_number;
            $type=$order->ktr_file_type;
            $currency_code= $order->ktr_currency_code;
            $curr_symbol=get_currency_symbol_by_currency_code($order->ktr_currency_code);
            
			
			
			if($_POST['ord_prc']){
                $table=$wpdb->prefix.KTR_ORDER_INFO_TABLE;
                
                   
             
               $mail_send_msg_details= '<a href="https://www.paypal.com/cgi-bin/webscr?business='.get_option('ktr-setting-paypal_email').'&cmd=_xclick&currency_code='. $currency_code.'&amount='. $_POST['ord_prc'].'&quantity=1&item_name=Translator Order&item_number='.$_REQUEST['order-id'].'&notify_url='. site_url().'/wp-content/plugins/kite-file-translate-manage-system/ipn/listener.php&return='. site_url().'/members/' .$user_name. '/ktr'  . '/view-orders/&cancel_return='. site_url().'/members/' .$user_name. '/ktr'  . '/view-orders/">Pay Now</a> <br/><br />Once we receive your payment, we will initiate the translation process.';

                    
         }else{
              $mail_send_msg_details="You will receive a price quotation very shortly.<br /><br />";
         }
         
         $message=$order->ktr_message;
           if($message=''){
            $mail_user_msg=' Message:  '.nl2br($message).'<br /> <br />';
        }
		
	   $item_name = 'Translation '.$order->ktr_language;
	   
       $mail_send_price='<br /> Price: '.$curr_symbol.$_POST['ord_prc'].' <a href="https://www.paypal.com/cgi-bin/webscr?business='.get_option('ktr-setting-paypal_email').'&cmd=_xclick&currency_code='. $currency_code.'&amount='. $_POST['ord_prc'].'&quantity=1&item_name='.$item_name.'&item_number='.$_REQUEST['order-id'].'&notify_url='. site_url().'/wp-content/plugins/kite-file-translate-manage-system/ipn/listener.php&return='.site_url().'/members/' .$user_name. '/ktr'  . '/view-orders/&cancel_return='.site_url().'/members/' .$user_name. '/ktr'  . '/view-orders/">Pay Now</a>'
          .' <br /><br />';
            //$admin_email = get_option( 'ktr-setting-admin_email' );       
           
            $admin_email = get_option( 'ktr-setting-admin_email' );
            $headers = 'From: '. get_bloginfo( $show, 'display' ).'<'.$admin_email.'>' . "\r\n";
            $headers .= 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $order_date= get_order_info_by_order_id($_REQUEST['order_id'])->ktr_order_date ;
            $dateTime=explode(" ",$order_date);
            $dateArray=explode('-',$dateTime['0']) ;
            $dateAll=mktime(0,0,0,date($dateArray[1]),date($dateArray[2]),date($dateArray[0]));
            $date= date("d M Y",$dateAll);
            $subject=' Your Order at '.get_bloginfo( $show, 'display' ).' : '.$order_id. "\r\n";
             $message='<br /><br />Thank you for your order with '. get_bloginfo( $show, 'display' ).'.
                Please find the price quotation for your order below:<br /> <br />
                Order ID: '.$_REQUEST['order_id'].'<br />
                Order Date: '.$date.'<br />
                Number of Pages: '.$page_number.'<br />
                Number of Words: '.$word_number.'<br />
                Language: '.$order->ktr_language 	.'<br />
                Type:  '.$type.'<br />
                '.$mail_user_msg.'
                '.$mail_send_price.'
               
                Thank you again for your order with '. get_bloginfo( $show, 'display' ).'.Please contact us if you need any clarification regarding your order.<br /><br />--'.
                "<br/>".get_bloginfo( $show, 'display' );
            add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
          wp_mail($user_email , $subject, $message , $headers);
   
            $_SESSION['update']='true';
        }else{
           if(isset($_REQUEST['assign_translator'])){
               $_SESSION['error']="true";
           }
            
            
        }
       
        }

        ?>
<div class="wrap">
        <?php if($_REQUEST['action']=='send-files'){ ?>
        <h2> <?php global $bp;   _e( 'Send Files ', 'bp-ktr' ); ?></h2><br/>
       <?php }else{ ?>
        <h2> <?php global $bp;   _e( 'View Orders ', 'bp-ktr' ); ?></h2><br/>
         <?php } ?>

        <?php  global $bp; 
		if ( $_REQUEST['page']=="ktr-order-view"&&(! wp_verify_nonce($nonce, 'detail-view'))&&!isset($_REQUEST['assign_translator'])) {?>
        
        
        <?php
        global $wpdb;
        global $bp;
        $dtl_link = $bp->loggedin_user->domain . $bp->current_component.'/'.$bp->current_action.'/';
        $current_user=wp_get_current_user();
        $userID=$current_user->ID;
        $user_name=$current_user->user_login;
        
		
        $table  = $wpdb->prefix.KTR_ORDER_INFO_TABLE;
        $table2 = $wpdb->prefix.KTR_TRANSLATING_DETAIL_TABLE;
        $sql = $wpdb->prepare( "SELECT  t1.*, t2.ktr_due_date, t2.ktr_id AS translator_id FROM $table AS t1
				LEFT JOIN $table2 AS  t2 ON t2.ktr_translator_id = t1.ktr_order_id
				ORDER BY  t1.ktr_id desc", '' );
        $order = $wpdb->get_results( $sql );
      

        //                                        echo "<pre>";
        //                                        var_dump($language);
        //                                        echo "</pre>";

        ?>
         
         <?php if ( $_SESSION['update']== 'true') : ?><?php echo "<div id='message' class='updated fade'><p>" . __( 'Updated.', 'bp-ktr' ) . "</p></div>" ?><?php $_SESSION['update']=''; endif; ?>
          <?php if ( $_SESSION['error']== 'true') : ?><?php echo "<div id='message' class='updated fade'><p>" . __( 'Blank cannot be updated.', 'bp-ktr' ) . "</p></div>" ?><?php $_SESSION['error']=''; endif; ?>
         
        <table class="form-table-list widefat">
        <tr valign="top">
        <th scope="row"><label for="target_uri"><?php _e( 'Order No', 'bp-ktr' ) ?></label></th>
        <th scope="row"><label for="target_uri"><?php _e( 'Date', 'bp-ktr' ) ?></label></th>
        <th scope="row"><label for="target_uri"><?php _e( 'Date Due', 'bp-ktr' ) ?></label></th>
        <th scope="row"><label for="target_uri"><?php _e( 'Customer Username', 'bp-ktr' ) ?></label></th>
        <th scope="row"><label for="target_uri"><?php _e( 'Language', 'bp-ktr' ) ?></label></th>
        <th scope="row"><label for="target_uri"><?php _e( 'Translator', 'bp-ktr' ) ?></label></th>
        <th scope="row"><label for="target_uri"><?php _e( 'Status', 'bp-ktr' ) ?></label></th>
        </tr>
        <?php foreach($order as $r):
        
        $i=$r->ktr_language;
        $order_id=$r->ktr_order_id;
		
        $dateTime=explode(" ",$r->ktr_order_date);
        $dateArray=explode('-',$dateTime['0']) ;        
		$dateAll=mktime(0,0,0,date($dateArray[1]),date($dateArray[2]),date($dateArray[0]));
        $date= date("d M Y",$dateAll);
		
		if(isset($r->ktr_due_date)){
			$dateTime2  = explode(" ",$r->ktr_due_date);
			$dateArray2 = explode('-',$dateTime2['0']) ;
			$dateAll2   = mktime(0,0,0,date($dateArray2[1]),date($dateArray2[2]),date($dateArray2[0]));
			$dateDue    = date("d M Y",$dateAll2);
		}else{
			$dateDue    = '';
		}
        
		$translator_user  = get_userdata($r->translator_id);
		
		$language=$r->ktr_language;
         if($user_name=="admin"){
         $u_id=="";
        $u_id=$r->ktr_order_from;
        $list_user=get_userdata( $u_id );
        $u_name=$list_user->user_login;
        }else{
        $u_name=$current_user->user_login;
        }
        
        $status="";
        if($r->status==AWATING_QUOTE){
        $status=sentence_case("AWATING QUOTE");
        }elseif($r->status==AWATING_CLIENT_ACCEPTANCE){
        $status=sentence_case("AWATING CLIENT ACCEPTANCE");
        }elseif($r->status==PAYMENT_RECEIVED){
        $status=sentence_case("PAYMENT RECEIVED");
        }elseif($r->status==ACCEPTED){
        $status=sentence_case("ACCEPTED");
        }elseif($r->status==PENDING){
        $status=sentence_case("PENDING");
        }elseif($r->status==TCONFIRMED){ //New status
			$status = "Confirmed by translator";		
		}elseif($r->status==TRANSLATED){ //New status
			$status=sentence_case("TRANSLATED");
		}elseif($r->status==TSENT){ //New status
			$status="Translation sent";
        }elseif($r->status==QUERY){
        $status=sentence_case("PAYMENT RECEIVED");
        }elseif($r->status==COMPLETE){
        $status=sentence_case("COMPLETE");
        }
        $order_id=$r->ktr_order_id;
        $actionurl=admin_url('admin.php?page=ktr-order-view&&order-id='.$order_id);
        $action ='detail-view';
        
        ?>
        <tr>
        <td><a href="<?php echo wp_nonce_url($actionurl,$action);?>"><?php echo $order_id; ?></a></td>
        <td><?php echo $date; ?></td>
        <td><?php echo $dateDue; ?></td>
        <td><?php echo $u_name; ?></td>
        <td><?php echo $language; ?></td>
        <td><?php echo $translator_user->user_login; ?></td>
        <td><?php echo $status; ?></td>
        </tr>
        <?php  endforeach;?>
        </table>
        <?php 

        }else{
            
            
            ###########
            
         if($_REQUEST['action']=="send-files"){
             
                global $wpdb;
                global $bp;
           ?>

 <div ><h3><?php global $bp;   _e( 'Sends Files for order '.$_REQUEST['order-id'], 'bp-ktr' ); ?></h3></div>
    <div class="add-new"> 

        <br />
        
<?php 
 $order_id=$_REQUEST['order-id'];
global $wpdb;
$table_translaing_info=$wpdb->prefix.KTR_TRANSLATING_DETAIL_TABLE;
 $q="SELECT * FROM $table_translaing_info WHERE ktr_translator_id ='%s'";
$results=$wpdb->get_results($wpdb->prepare($q, $order_id));
$table_translator_detail_info=$wpdb->prefix.KTR_TRANSLATOR_INFO_TABLE;
if(count($results>0)){
    ?>

<form action="<?php echo site_url(); ?>/wp-admin/<?=$mu_path_x?>admin.php?page=send_files&_wpnonce=<?php echo $_REQUEST['_wpnonce']?>" name="ktr-send-files-form" id="ktr-send-files-form" method="post">
             
   <?php
    
    foreach($results as $r){
        $user_id = $r->ktr_id;
        $sql=$wpdb->prepare("SELECT * FROM $table_translator_detail_info where default_user_id=".$user_id." and name='u_login' ",'');
        $user=$wpdb->get_row($sql);
        $user_name=$user->value;
        
        
        $assign_date=$r->ktr_assign_date;
        $asdateTime=explode(" ",$assign_date);
        $asdateArray=explode('-',$asdateTime['0']) ;
        $asdateAll=mktime(0,0,0,date($asdateArray[1]),date($asdateArray[2]),date($asdateArray[0]));
        $asdate= date("d M Y",$asdateAll);
        $due_date=$r->ktr_due_date;
        $ddateTime=explode(" ",$due_date);
        $ddateArray=explode('-',$ddateTime['0']) ;
        $ddateAll=mktime(0,0,0,date($ddateArray[1]),date($ddateArray[2]),date($ddateArray[0]));
        $ddate= date("d M Y",$ddateAll);
        $comment=$r->ktr_comment;
        $user_id=$r->ktr_id;
        ?>              
     <table class="form-table-list ">
        <tr>
            
            <td><b>Translator: <?php echo $user_name; ?></b></td> 
          
        </tr>
        <tr>
            <td >
        <?php
            $tableOrderDtlTrns=$wpdb->prefix.KTR_TRANSLATING_DETAIL_TABLE;
            $tableTrnslatedFile=$wpdb->prefix.KTR_TRANSLATE_FILE_URL_TABLE;
                  $sqlFilePath = $wpdb->prepare( 
                                "SELECT * FROM $tableOrderDtlTrns as dtl
                                Inner Join $tableTrnslatedFile as tf on tf.user_id=dtl.ktr_id 
                                where dtl.ktr_translator_id =".$_REQUEST['order-id']." and tf.user_id=".$user_id." and tf.ktr_id='%s' ORDER BY tf.ktr_trnslt_status asc", $_REQUEST['order-id']);
                $translatorUploadFile = $wpdb->get_results($sqlFilePath);
				
                $i=0;
                ?>
                <table class=" ">
                   
                    <?php if(count($translatorUploadFile)>0):?>
                            <?php
                            $loop=1;
                            $revesionArray=array();
                            foreach($translatorUploadFile as $r){

                                $version=$r->ktr_trnslt_status;
                                $date=$r->ktr_uploaded_date;
                                $upload_date=$date;
                                $upldateTime=explode(" ",$upload_date);
                                $upldateTimeArray=explode('-',$upldateTime['0']) ;
                                $upHr=explode(':',$upldateTime['1']) ;
                                $asdateAll=mktime($upHr[0],$upHr[1],$upHr[2],date($upldateTimeArray[1]),date($upldateTimeArray[2]),date($upldateTimeArray[0]));
                                $upldate=" Upload on ". date("d M Y H :i:s",$asdateAll);
                                if(!in_array($version,$revesionArray)){
                                $revesionArray[]=$version;
                                if($version==1){
                                      echo $revesion ="<tr>
                                      <td>
                                      ".$upldate."
                                      </td>
                                      <td></td>
                                      </tr>";
                                }else{
                                    $rv=$version-1;
                                     echo $revesion ="<tr>
                                      <td>
                                      Revesion -".$rv.$upldate."
                                      </td>
                                      <td></td>
                                      </tr>"; 
                                }

                                }
                              if($r->ktr_trnslt_status==1){
                                  $revesion ="";
                              }else{
                                  if(in_array($version,$revesionArray)){
                                  $version=$version-1;

                              }else{

                              }

                              }


                            ?>
                    <tr>

                        <td valign="top" class="detail_td">
                            <?php
                                $i++;
                                $fileFullpathArray=explode('/',$r->ktr_trnslt_url);
                                $filename=end($fileFullpathArray);
                                ?>
                            <input type="checkbox" name="send_file_check_box[]" id="send_file_check_box_<?php echo $i; ?>" value="<?php echo $r->ktr_trnslt_id; ?>" />
                            <?php
                                echo '<lavel for="send_file_check_box_'. $i.'"> <a href="'.site_url().'/wp-content/plugins/kite-file-translate-manage-system/?file='.$filename.'&path='.KTR_TRANSLATED_FILE_DIRECTORY.DS.$user_id.'" >'.$filename."</a></label><br/>";
                                ?>
                             </td>
                        </tr>
                            <?php
                            }
							?>
                         <?php else:?>
							<tr>
								<td valign="top" class="detail_td">No file found.</td>
							</tr>
                        <?php endif;?>
                    </table>
            </td>
            
        </tr>
       
               
         
    </table> 
        <?php
    }
    
    ?>
         <input type="hidden" name="order_id" value="<?php echo $translatorUploadFile[0]->ktr_id ?>" />
         <input type="submit" name="admin_send_file" id="admin_send_file" class="ffs_button" value="Send" />
         <a href="<?php echo site_url('/wp-admin/admin.php?page=ktr-order-view&order-id='.$_REQUEST['order-id'].'&_wpnonce='.$_REQUEST['_wpnonce']) ?>" class="ffs_button">Cancel </a>
     </form>
	 
	 <script type="text/javascript">
		jQuery(function() {
			jQuery("#admin_send_file").click(function() {
				if(jQuery('input[name="send_file_check_box[]"]:checked').length == 0){ //Nothing is checked
					alert("Please select at least one file.");
					return false;
				}
			});	
		});	
	 
	 </script> 
	 
	 <?php
    } 
             
         }else{
        global $wpdb;
        global $bp;
		
            
        $table=$wpdb->prefix.KTR_ORDER_INFO_TABLE;
        if($_REQUEST['action']=='change-status'&&isset($_REQUEST['type'])){ 
            $wpdb->query($wpdb->prepare("UPDATE $table 
                    SET status =".$_REQUEST['type'] ."
                    WHERE ktr_order_id = '%d'", $_REQUEST['order-id']));
            
             $rs=$wpdb->get_row($wpdb->prepare("SELECT ktr_order_from FROM $table WHERE ktr_order_id = '%d'", $_REQUEST['order-id']));
            
            $user_id=$rs->ktr_order_from;
            $user_info = get_userdata($user_id);
            $user_email=$user_info->user_email ;
            $admin_email = get_option( 'ktr-setting-admin_email' );
            $headers = 'From: '. get_bloginfo( $show, 'display' ).'<'.$admin_email.'>' . "\r\n";
            $headers .= 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $date= date("d M Y",$dateAll);
            $subject=' Accepted Translation Order : '.$_REQUEST['order-id']. "\r\n";
			
			$message =  bp_ktr_get_email('client_translation_accepted', 'salutation');
            $message .='<br /><br />Your translation request is accepted.<br /><br />--<br/>'.get_bloginfo( $show, 'display' );
			$message .=  bp_ktr_get_email('client_translation_accepted', 'footer');
            
			add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
            wp_mail($user_email , $subject, $message , $headers);
           
            
            
            //Automatically send the order to the default translator (if selected)
			z_automatic_send($_REQUEST['order-id']); 
            
            $_SESSION['update']=true;
        }
       if(isset($_REQUEST['assign_translator'])){
           $table_assign_translator=$wpdb->prefix.KTR_TRANSLATING_DETAIL_TABLE;
           $dueDate=explode('/',$_REQUEST['txt_assign_date']);
            $date=$dueDate[2].'-'.$dueDate[1].'-'.$dueDate[0].' 00:00:00';
             $nnn=explode('_',$_REQUEST['ffs_df']);
           
            
          $sql = $wpdb->prepare(
                "INSERT INTO $table_assign_translator (
                        ktr_translator_id,
                        ktr_id,
						ktr_due_date,
                        ktr_comment,
						ktr_pending_status
                ) VALUES (
                         '%s',
                   ".$_REQUEST['drp_translator'].",
                   '".$date."',
                   '".$_REQUEST['txtComment']."',
				   '".PENDING_WAITING_TRANSLATOR."')"
                ,$_REQUEST['order_id']);
            $result = $wpdb->query( $sql );
                
            $table=$wpdb->prefix.KTR_ORDER_INFO_TABLE;
       
            $wpdb->query($wpdb->prepare("UPDATE $table SET status =3
                    WHERE ktr_order_id = '%d'", $_REQUEST['order_id']));
			
			//Additions
			$sentDate_  = explode('/',$_REQUEST['txt_date_sent']);
            $sentDate   = $sentDate_[2].'-'.$sentDate_[1].'-'.$sentDate_[0].' 00:00:00';
			$sentTo     = $_REQUEST['txt_sent_to'];
			$comment    = $_REQUEST['txtComment'];
			
            $user_id=$_REQUEST['drp_translator'];
            $user_info = get_userdata($user_id);
            $user_email=$user_info->user_email ;
            $admin_email = get_option( 'ktr-setting-admin_email' );
            $headers = 'From: '. get_bloginfo( $show, 'display' ).'<'.$admin_email.'>' . "\r\n";
            $headers .= 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            $subject=' A New Task is Assigned : '.$_REQUEST['order_id']. "\r\n";
			$message =  bp_ktr_get_email('translator_order_assigned', 'salutation');
            $message .='<br /><br />A new task has been assigned for you. Details:<br /><br />
			<b>Date Sent: </b>'. $_REQUEST['txt_date_sent'] .'<br />
			<b>Date Due: </b>'. $_REQUEST['txt_assign_date'] .'<br />
			<b>Sent to: </b>'. $sentTo .'<br />
			'.($comment ? '<b>Comment: </b>'.$comment.'<br />' : '').'
			<br /><br />
			You can view more details of the task from your admin panel.<br /><br />--'.
                "<br/>".get_bloginfo( $show, 'display' );
            $message .= bp_ktr_get_email('translator_order_assigned', 'footer');
			
			add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
			
			//Prepare attachements
			$attachments = array();
			$filesTable  = $wpdb->prefix.KTR_ORDERED_FILE_URL_TABLE;
			//$filesSql  = "SELECT * FROM $filesTable where ktr_id=".$_REQUEST['order_id'];
			$filesSql    = 	"SELECT f.* FROM $filesTable AS f
				 INNER JOIN $table as ord ON ord.ktr_id = f.ktr_id
				 WHERE ktr_order_id = '%s'";
			$rows 		 = $wpdb->get_results($wpdb->prepare( $filesSql, $_REQUEST['order_id'] ));
			foreach($rows as $r){
				$attachments[]= WP_CONTENT_DIR . str_replace('wp-content','',$r->ktr_ordf_url);
			}
			//$message.= print_r($attachments, true);

			
          wp_mail($user_email , $subject, $message , $headers, $attachments);
          
          $_SESSION['msg']="Translator assigned successfully";
          $nonce=$nnn[1];
         //echo "<script type='text/javascript'>window.location='".site_url('wp-admin/admin.php?page=ktr-order-view&order-id='.$_REQUEST['order_id'].'&_wpnonce='.$_get['df_wpnonce'].'')."';</script>";
         // echo site_url('wp-admin/admin.php?page=ktr-order-view&order-id='.$_REQUEST['order_id'].'&_wpnonce='.$nonce);
          
         ?>
         <script type='text/javascript'>
             window.location='<?php  echo site_url('wp-admin/admin.php?page=ktr-order-view&order-id='.$_REQUEST['order_id'].'&_wpnonce='.$nonce); ?>';
         </script>";
        <?php
         die();
                
       }
       


        if(is_numeric($_REQUEST['order-id'])){
            //$dtl_link = $bp->loggedin_user->domain . $bp->current_component.'/'.$bp->current_action.'/';
            $current_user=wp_get_current_user();
            $userID=$current_user->ID;
            $table=$wpdb->prefix.KTR_ORDER_INFO_TABLE;
			$table2 = $wpdb->prefix.KTR_TRANSLATING_DETAIL_TABLE;
            $sql = $wpdb->prepare( "SELECT t1.*, t2.ktr_due_date, t2.ktr_id AS translator_id FROM $table AS t1
				LEFT JOIN $table2 AS  t2 ON t2.ktr_translator_id = t1.ktr_order_id
				where t1.ktr_order_id=%s 
				ORDER BY t1.ktr_id desc", $_REQUEST['order-id'] );
            $order = $wpdb->get_row($sql);
            if($order->ktr_order_id == $_REQUEST['order-id']){
                $languagePrice= get_option("ktr-setting-language-price");
                
                $language=$order->ktr_language;
                $laguage_array=explode(" ",$language);
                $sql2=$sql3=$sql4="";
                
                
                $sql2 = $wpdb->prepare( "SELECT ktr_file_type_id FROM ".$wpdb->prefix.KTR_FILE_TYPE_TABLE." where ktr_file_type='".$order->ktr_file_type."'", '' );
                $type_id = $wpdb->get_row($sql2)->ktr_file_type_id;
                $sql3 = $wpdb->prepare( "SELECT ktr_laguage_id FROM ".$wpdb->prefix.KTR_LANGUAGE_TABLE." where ktr_trnslt_from='".$laguage_array[0]."' and ktr_trnslt_to='".$laguage_array[2]."'", '' );
              $language_id = $wpdb->get_row($sql3)->ktr_laguage_id;
               if($type_id && $language_id){
                 $sql4 = $wpdb->prepare( "SELECT ktr_type_base_price FROM ".$wpdb->prefix.KTR_TYPE_BASE_PRICE_TABLE." where ktr_type_language='".$language_id."' and ktr_type='".$type_id."'", '' );
                   $price_per_word = $wpdb->get_row($sql4)->ktr_type_base_price;
                  
               }else{
                   $type_language_not_found=true;
               }
                
				$dateTime=explode(" ",$order->ktr_order_date);				
                $dateArray=explode('-',$dateTime['0']) ;
                $dateAll=mktime(0,0,0,date($dateArray[1]),date($dateArray[2]),date($dateArray[0]));
                $date= date("d M Y",$dateAll);
				
				if(isset($order->ktr_due_date)){
					$dateTime2  = explode(" ",$order->ktr_due_date);				
					$dateArray2 = explode('-',$dateTime2['0']) ;
					$dateAll2 = mktime(0,0,0,date($dateArray2[1]),date($dateArray2[2]),date($dateArray2[0]));
					$dateDue  = date("d M Y",$dateAll2);
				}else{
					$dateDue    = '';
				}
				
                
               // $price_per_word=$languagePrice[$order->ktr_language]['price'];
                $status="";

			if($order->status==AWATING_QUOTE){
                $status=sentence_case("AWATING QUOTE");
                }elseif($order->status==AWATING_CLIENT_ACCEPTANCE){
                $status=sentence_case("AWATING CLIENT ACCEPTANCE");
                }elseif($order->status==PAYMENT_RECEIVED){
                $status=sentence_case("PAYMENT RECEIVED");
                }elseif($order->status==ACCEPTED){
                $status=sentence_case("ACCEPTED");
                }elseif($order->status==PENDING){
                $status=sentence_case("PENDING");
				}elseif($order->status==TCONFIRMED){ //New status
					$status = "Confirmed by translator";
                }elseif($order->status==TRANSLATED){ //New status
					$status=sentence_case("TRANSLATED");
				}elseif($order->status==TSENT){ //New status
					$status="Translation sent";
				}elseif($order->status==QUERY){
                $status=sentence_case("QUERY");
                }elseif($order->status==COMPLETE){
                $status=sentence_case("COMPLETE");
                }
                
				$user_id=$order->ktr_order_from;
				$user_obj  = get_userdata($user_id);
				
				$translator_obj  = get_userdata($order->translator_id);
				
                $order->ktr_message;
                if($order->ktr_currency_code){
                $select=$order->ktr_currency_code;
                }else{
                 echo  $select=get_option('payment_currency') ;
                }
                
               $currency=get_currency_symbol_by_currency_code($order->ktr_currency_code);
               
               $actionurl=admin_url('admin.php?page=ktr-order-view&&order-id='.$_REQUEST['order-id']);
               $action ='detail-view';
                ?>
               <?php if ( $_SESSION['update']== 'true') : ?><?php echo "<div id='message' class='updated fade'><p>" . __( 'Updated.', 'bp-ktr' ) . "</p></div>" ?><?php $_SESSION['update']=''; endif; ?>
          <?php if (  $_SESSION['msg']!= '') : ?><?php echo "<div id='message' class='updated fade'><p>" . __(  $_SESSION['msg'], 'bp-ktr' ) . "</p></div>" ?><?php  $_SESSION['msg']=''; endif; ?>
                    
					
				<script type="text/javascript">
					jQuery(function() {						
						jQuery("#change_order_status").click(function() {	  
						   jQuery.post( ajaxurl, {
								action: 'admin_change_order_status',
								'cookie': encodeURIComponent(document.cookie),
								'order_id': jQuery("input[name=order_id]").val(),
								'status': jQuery("select[name=status_selector]").val()
						  },
						  function(data) {
								alert(data);
								//location.reload();
						  });			  
						}); 
					});	
				 
				 </script> 
					
					<div id="add_language"><h3>Order Details</h3></div>
                    <div class="add-new"> 
                <form action="" name="ktr-order-settings-price" id="ktr-settings-form" method="post">

                <table class="form-table-list ">
                    <tr>
                        <td valign="top">
                            <table class="form-table-list">
                                <tr><td valign="top" class="dtl_left_td">Order No: </td><td><?php echo $order->ktr_order_id;?></td></tr>
                                <tr><td valign="top" class="dtl_left_td">Date:</td><td><?php echo $date;?></td></tr>
                                <tr><td valign="top" class="dtl_left_td">Date Due:</td><td><?php echo $dateDue;?></td></tr>
                                <tr><td valign="top" class="dtl_left_td">Customer:</td><td><?php echo $user_obj->user_login;?></td></tr>
                                <tr><td valign="top" class="dtl_left_td">Translator:</td><td><?php echo $translator_obj->user_login;?></td></tr>
                                <tr>
									<td class="dtl_left_td">Status:</td>
									<td>
										<?php //echo $status;?>
										<?php echo z_statusses_list($order->status); ?>
										<button id="change_order_status" type="button">Change</button>
									</td>
								</tr>
                                <tr><td class="dtl_left_td">Type:</td><td><?php echo $order->ktr_file_type;?></td></tr>
                                <tr><td class="dtl_left_td">Language:</td><td><?php echo $language; ?></td></tr>
      <!--<tr>  
        <td class="dtl_left_td">Date</td>
        <td><input type="text" size="27" id="txtOrderDate" name="txtOrderDate" value="" /></td>
    </tr>-->
                                <tr><td class="dtl_left_td">Number Of Words:</td>
                                    <td><?php echo $order->ktr_order_number; ?>
                                        <input type="hidden" name="page_number" id="page_number" value="<?php echo $order->ktr_page_number;  ?>" />
                                        <input type="hidden" name="word_price" id="word_price" value="<?php echo $price_per_word;  ?>" />
                                        <input type="hidden" name="order_id" id="order_id" value="<?php echo $order->ktr_order_id;  ?>" />
                                    </td ></tr>
                                <tr><td class="dtl_left_td">Number Of Pages:</td><td><?php echo $order->ktr_page_number; ?></td></tr>
                                <?php if($order->ktr_message) :?>
                                <tr><td class="dtl_left_td">Message:</td><td><?php echo $order->ktr_message; ?></td></tr>
                                <?php endif; ?>
								
								<tr><td class="dtl_left_td">Automatic:</td><td><?php echo z_is_automatic($order); ?></td></tr>
								
                                <tr>

                                    <?php 
                                    $current_user=wp_get_current_user();
                                    $user_name=$current_user->user_login;

                                    ?>
                                    <?php if($user_name=="admin"){
                                    wp_nonce_field( 'ktr-order-price' );
                                    if($order->ktr_price>0 &&($order->status==AWATING_CLIENT_ACCEPTANCE || $order->status==AWATING_QUOTE)){
                                    ?>
                                     <td class="dtl_left_td">Price:</td><td>
                                   <input type="text" name="ord_prc" id="ord_prc" value="<?php echo ($order->ktr_price)==0?" ":$order->ktr_price; ?>" size="5" />
                                   
                                   &nbsp;<?php  currency_drop_down('rdCurrency', $select); ?>
                                    
                                    Modified the price
                                    </td>
                                    <?php
                                    }else{if($type_language_not_found &&($order->status==AWATING_CLIENT_ACCEPTANCE || $order->status==AWATING_QUOTE)){
                                    ?>
                                    <td class="dtl_left_td">Price:</td><td>Not Quote Yet | 
                                    <input type="text" name="ord_prc" id="ord_prc" value="<?php echo ($order->ktr_price)==0?" ":$order->ktr_price; ?>" size="5" />
                                    &nbsp;<?php  currency_drop_down('rdCurrency', $select); ?>
                                    Put a price manually.
                                    </td>
                                    <?php
                                    }elseif($order->status==AWATING_CLIENT_ACCEPTANCE || $order->status==AWATING_QUOTE){
                                    ?>
                                    <td class="dtl_left_td">Price:</td>
                                    <td> Not Quote Yet | 
                                    <input type="text" name="ord_prc" id="ord_prc" value="<?php echo ($order->ktr_price)==0?" ":$order->ktr_price; ?>" size="5" />&nbsp;
                                    <?php  currency_drop_down('rdCurrency', $select); ?>
                                    Put a price or <a id="crate_automatic_price" href="javascript:void(0)" >generate automatically</a>
                                    </td>
                                    <?php 
                                    }elseif($order->status==PAYMENT_RECEIVED){
                                    ?>
                                    <td class="dtl_left_td">Price:</td>
                                    <td><?php echo $currency; ?><?php echo $order->ktr_price; ?>
                                    </td>
                                    <?php 
                                    }
                                    }?>
                                    <?php }?>
                                </tr>

                                <?php if($user_name=="admin"&&($order->status==AWATING_CLIENT_ACCEPTANCE || $order->status==AWATING_QUOTE)):?>

                                <tr><td>
                                        <input class="ffs_button" type="submit" name="submit" id="ktr_crate_invoice" value="Create Invoice" />
                                        <input class="ffs_button" type="button" name="submit" id="ktr_crate_invoice" value="Cancel Order" />
                                    </td>
                                </tr>

                                
                                 <?php elseif($user_name=="admin"&&($order->status==PAYMENT_RECEIVED)):?>
                                    <?php $status="&action=change-status&type=4"; ?>
                                <tr>
                                    <td colspan="2">
                                        <input class="ffs_button" type="button" name="submit" id="ktr_crate_invoice" value="Cancel Order" />
                                         <!--<input class="ffs_button" type="button" name="submit" id="ktr_crate_invoice" value="Accept" />-->
                                        <a class="ffs_button" href="<?php echo wp_nonce_url($actionurl.$status,$action);?>" > Accept </a>
                                    </td>
                                </tr>
                                
                                 <?php elseif($user_name=="admin"&&($order->status==ACCEPTED)):?>

                                <tr>
                                    <td>
                                        <input class="ffs_button" type="button" name="submit" id="ktr_crate_invoice" value="Cancel Order" />
                                    </td>
                                </tr>
                              <?php elseif($user_name=="admin"&&($order->status==PENDING || $order->status==TRANSLATED || $order->status==TSENT )):?>

                                <tr>
                                    <td>
										<script type="text/javascript">
											jQuery(function() {
												
												jQuery("#mark-complete-btn").click(function() {	  
												   jQuery.post( ajaxurl, {
														action: 'admin_mark_complete',
														'cookie': encodeURIComponent(document.cookie),
														'order_id': jQuery("#mark-complete-order-id").val()
												  },
												  function(data) {
														alert(data);
														location.reload();
												  });			  
												}); 
											});	
										 
										 </script> 
																		   
                                         <?php $status="&action=send-files";?>
                                        
                                        <input class="ffs_button" type="button" name="submit" id="ktr_crate_invoice" value="Cancel Order" />
                                        <a class="ffs_button" href="<?php echo wp_nonce_url($actionurl.$status,$action);?>" > Send Files </a>
                                        <input class="ffs_button" type="button" name="submit" id="mark-complete-btn" value="Mark Complete" />
                                        <input type="hidden" id="mark-complete-order-id" value="<?php  print $order->ktr_id ?>" />
                                    </td>
                                </tr>
                                 <?php elseif($user_name=="admin"&&($order->status==QUERY)):?>

                                <tr>
                                    <td>
                                        <input class="ffs_button" type="button" name="submit" id="ktr_crate_invoice" value="Cancel Order" />
                                        <input class="ffs_button" type="button" name="submit" id="ktr_crate_invoice" value="Send Files" />
                                        <input class="ffs_button" type="button" name="submit" id="ktr_crate_invoice" value="Mark Complete" />
                                    </td>
                                </tr>
                              <?php elseif($user_name=="admin"&&($order->status==COMPLETE)):?>

                                <tr>
                                    <td>
                                        <!--input class="ffs_button" type="button" name="submit" id="ktr_crate_invoice" value="Reopen" /-->
                                   
                                    </td>
                                </tr>

                                <?php endif; ?>

                            </table>
                        </td>
                        <td valign="top">
                            <?php
                            $tableOrderPath=$wpdb->prefix.KTR_ORDERED_FILE_URL_TABLE;
                             $sqlFilePath = $wpdb->prepare( "SELECT * FROM $tableOrderPath where ktr_id=".$order->ktr_id." ORDER BY ktr_ordf_id desc", '' );
                                $order_fliePath = $wpdb->get_results($sqlFilePath);
                                $i=0;
                                ?>
                                <table class="form-table-list">
                                    <tr>
                                        <td valign="top"><b>Uploaded File(s):</b> </td>
                                    </tr>

                                            <?php
                                            $actionurl=admin_url('admin.php?page=ktr-order-view');
                                            $action ='detail-view';
                                            foreach($order_fliePath as $r){
                                            ?>
                                    <tr>
                                        
                                        <td valign="top" class="detail_td">
                                             <?php
                                            $i++;
                                            $fileFullpathArray=explode('/',$r->ktr_ordf_url);
                                            $filename=end($fileFullpathArray);
                                            echo $i.'.<a href="'.site_url().'/wp-content/plugins/kite-file-translate-manage-system/?file='.$filename.'&path='.$user_id.'" >'.$filename."</a><br/>";
                                            ?>
                                             </td>
                                        </tr>
                                            <?php
                                            }

                                        ?>
                                    </table>

                        </td>
                    </tr>
                

                </table>
                </form>
                    </div>
                <?php
            }else{
                echo  NOT_FOUND;
            }

        }else{
        echo ERROR_IN_REQUEST;
        }
       
  if($order->status==PENDING || $order->status==TRANSLATED || $order->status==QUERY || $order->status==COMPLETE||$order->status==ACCEPTED){                  
      ?>
                    <div id="add_language"><h3><?php global $bp;   _e( 'Assign Translator', 'bp-ktr' ); ?></h3></div>
               <div class="add-new"> 
        
        <br />
      
        <?php $actionurl=site_url('/wp-admin/admin.php?page=ktr-order-view&order-id='.$_REQUEST['order_id']);
        $action='detail-view';
        ?>
        <form action="<?php echo site_url(); ?>/wp-admin/<?=$mu_path_x?>admin.php?page=ktr-order-view&order-id=<?php echo $_REQUEST['order-id'] ?>&_wpnonce=<?php echo $_REQUEST['_wpnonce']?>" name="ktr-assign-translator-form" id="ktr-assign-translator-form" method="post">
            
        <table class="form-table-list">
                    <tr >
                        <td valign="top">
                            <?php echo create_translator_list('drp_translator')?>
                        </td>
                        <td valign="top">
                            <table class="form-table-list">
                                <tr class="loader">
                                    <td class="loaderImg" colspan="2"><img src="<?php echo site_url('/wp-content/plugins/kite-file-translate-manage-system/images/ajax_loader_large.gif');?>"/></td>
                                    
                                </tr>
                                <tr class="ajaxUserInfo">
                                    <td class="dtl_left_td">Name:</td>
                                    <td><span id="name"></span> 
                                        <input class="ffs_button" type="button" name="submit" id="ktr_select_translator" value="Select" />
                                    </td>
                                </tr>
                                <tr class="ajaxUserInfo">
                                    <td class="dtl_left_td">Status:</td>
                                    <td><div id="translatorStatus"></div></td>
                                </tr>
                                <tr class="ajaxUserInfo">
                                    <td class="dtl_left_td">Language:</td>
                                    <td><div id="translatorLanguage"></div></td>
                                </tr>
                                <tr class="ajaxUserInfo">
                                    <td class="dtl_left_td">Specialization:</td>
                                    <td><div id="translatorSpecialization"></div></td>
                                </tr>
								
								<tr class="assign_trns">
                                    <td class="dtl_left_td">Date Sent:</td>
                                    <td>
										<input type="text" name="txt_date_sent" id="txtDateSent"/>
										<div style="display: none;"> 
											<img id="date-sent-trigger" src="<?php echo site_url('/wp-content/plugins/kite-file-translate-manage-system/images/cal_ico.gif')?>" alt="..." title="..." /> 
										</div>
									</td>
                                </tr>
                                <tr class="assign_trns">
                                    <td class="dtl_left_td">Date Due:</td>
                                    <td>
										<input type="text" name="txt_assign_date" id="txtOrderDate"/>
										<div style="display: none;"> 
											<img id="order-date-trigger" src="<?php echo site_url('/wp-content/plugins/kite-file-translate-manage-system/images/cal_ico.gif')?>" alt="..." title="..." /> 
										</div>
									</td>
                                </tr>
								<tr class="assign_trns">
                                    <td class="dtl_left_td">Sent To:</td>
                                    <td><input type="text" name="txt_sent_to"  id="txtSentTo" /></td>
                                </tr>
                                <tr class="assign_trns">
                                    <td class="dtl_left_td">Comment:</td>
                                    <td><textarea name="txtComment" id="txtComment" rows="5" cols="25"></textarea></td>
                                </tr>
                                 <tr class="assign_trns">
                                    <td class="dtl_left_td"></td>
                                    <td>
                                        <input type="hidden" name="ffs_df" value="mm_<?php echo $_REQUEST['_wpnonce'];?>_mm"/>
                                        <input type="hidden" name="order_id" id="assigned_order_id" value="<?php echo $order->ktr_order_id;?>"/>
                                         <input class="ffs_button" type="submit" name="assign_translator" id="ktr_assign_translator" value="Assign" />
                                         <input class="ffs_button" type="button" name="button" id="ktr_cancel_translator" value="Cancel" />
                                    </td>
                                </tr>
                            </table>
                           
                        </td>
                    </tr>
        </table>
           
     </form>
   </div>


<?php if($order->status==PENDING || $order->status==TRANSLATED || $order->status==QUERY || $order->status==COMPLETE ){?>

 <div id="add_language"><h3><?php global $bp;   _e( 'Assigned Translators', 'bp-ktr' ); ?></h3></div>
    <div class="add-new"> 

        <br />
        
<?php 
 $order_id=$_REQUEST['order-id'];
global $wpdb;
$table_translaing_info=$wpdb->prefix.KTR_TRANSLATING_DETAIL_TABLE;
 $q="SELECT * FROM $table_translaing_info WHERE ktr_translator_id ='%s'";
$results=$wpdb->get_results($wpdb->prepare($q, $order_id));
$table_translator_detail_info=$wpdb->prefix.KTR_TRANSLATOR_INFO_TABLE;
if(count($results>0)){
    ?>
   
             
   <?php
    
    foreach($results as $r){
        $user_id = $r->ktr_id;
        $sql=$wpdb->prepare("SELECT * FROM $table_translator_detail_info where default_user_id=".$user_id." and name='u_login' ", '');
        $user=$wpdb->get_row($sql); 
        $user_name=$user->value;
        
        
         $assign_date=$r->ktr_assign_date;
        $asdateTime=explode(" ",$assign_date);
        $asdateArray=explode('-',$asdateTime['0']) ;
        $asdateAll=mktime(0,0,0,date($asdateArray[1]),date($asdateArray[2]),date($asdateArray[0]));
        $asdate= date("d M Y",$asdateAll);
        $due_date=$r->ktr_due_date;
        $ddateTime=explode(" ",$due_date);
        $ddateArray=explode('-',$ddateTime['0']) ;
        $ddateAll=mktime(0,0,0,date($ddateArray[1]),date($ddateArray[2]),date($ddateArray[0]));
        $ddate= date("d M Y",$ddateAll);
        $comment=$r->ktr_comment;
        $user_id=$r->ktr_id;
        ?>

	<script type="text/javascript">
		jQuery(function() {
			
			jQuery("#due_date_confirm_admin").click(function() {	  
			   jQuery.post( ajaxurl, {
					action: 'translator_confirm',
					'cookie': encodeURIComponent(document.cookie),
					'order_id': jQuery(this).val()
			  },
			  function(data) {
					alert(data);
					location.reload();
			  });			  
			}); 
			
			jQuery(".file_remove").click(function() {	
			   if(!confirm('Are you sure to remove this file?')) return;
			   
			   jQuery.post( ajaxurl, {
					action: 'admin_file_remove',
					'cookie': encodeURIComponent(document.cookie),
					'file_id': jQuery(this).attr('rel')
			  },
			  function(data) {
					//alert(data);
					location.reload();
			  });			  
			}); 
			
			
			var uploaderAdmin = new qq.FileUploader({ 
				multiple: false,
				element: document.getElementById('adminUploader'),
				listElement: document.getElementById('separate-listtrns'),
				action: '<?php echo home_url()?>/wp-content/plugins/kite-file-translate-manage-system/valums-file-uploader/server/php.php',
				onComplete: function(id, fileName, responseJSON){					
					//alert(responseJSON['filename']);
					jQuery("#adminUploaderBtn").show();
				}   
			});   

			jQuery("#adminUploaderBtn").click(function() {	//alert(jQuery("#adminUploaderFileId").val())
				jQuery.post( ajaxurl, {
					action: 'admin_file_replace',
					'cookie': encodeURIComponent(document.cookie),
					'old_file_id': jQuery("#adminUploaderFileId").val()
				},
				function(data) {
					alert(data);
					//location.reload();
					jQuery("#adminUploaderContainer").hide();
					jQuery("#adminUploaderFile").html("");
					jQuery("#adminUploaderFileId").val("");
					jQuery("#adminUploaderBtn").hide();
				});			  
						
			});

			
			jQuery(".resend-files-btn").click(function() {	
			   jQuery.post( ajaxurl, {
					action: 'translator_resend_files',
					'cookie': encodeURIComponent(document.cookie),
					'order_id': jQuery(this).next(".resend-files-order-id").val(),
					'user_id':  jQuery(this).next().next(".resend-files-user-id").val()
			  },
			  function(data) {
					alert(data);
					//console.log(data);
			  });			  
			}); 
		});
		
		function showAdminUploader(file_id, file_name){
			jQuery("#adminUploaderContainer").show();
			jQuery("#adminUploaderFile").html(file_name);
			jQuery("#adminUploaderFileId").val(file_id);
		}
		
		
	</script>

	
     <table class="form-table-list ">
        <tr>
            <td>
                <table class="form-table-list assigned_translators">
                    
                         <tr><td class="dtl_left_td">Name: </td><td><?php echo $user_name; ?></td> </tr>
                         <tr><td class="dtl_left_td" >Date Assigned: </td><td><?php echo $asdate; ?></td> </tr>
                        <tr> <td class="dtl_left_td" >Due Date: </td><td><?php echo $ddate; ?></td> </tr>
                        <tr> <td class="dtl_left_td" >Comments: </td><td><?php echo $comment ?></td> </tr>
                        <tr> 
							<td class="dtl_left_td" >Status: </td>
							<td>
								<?php 
									switch($r->ktr_pending_status){
										case PENDING_WAITING_TRANSLATOR: print 'Waiting translator confirmation.'; break;
										case PENDING_WAITING_ADMIN: 
											print 'Translator changed due date. Please confirm: &nbsp;&nbsp;'; 
											print '<input type="checkbox" id="due_date_confirm_admin" value="'.$order_id.'" />'; 
										break;
										case PENDING_CONFIRMED: print 'Confirmed.'; break;
									}
								?>
							</td> 
						</tr>
                        
                </table><br />
				
				<input type="button" class="resend-files-btn ffs_button" value="Resend Files" />
				<input type="hidden" class="resend-files-order-id" value="<?=$order_id?>" />
				<input type="hidden" class="resend-files-user-id"  value="<?=$user_id?>">
            
			</td>
            <td>
        <?php
            $tableOrderDtlTrns=$wpdb->prefix.KTR_TRANSLATING_DETAIL_TABLE;
            $tableTrnslatedFile=$wpdb->prefix.KTR_TRANSLATE_FILE_URL_TABLE;
                  $sqlFilePath = $wpdb->prepare( 
                                "SELECT * FROM $tableOrderDtlTrns as dtl
                                Inner Join $tableTrnslatedFile as tf on tf.user_id=dtl.ktr_id 
                                where dtl.ktr_translator_id =".$order->ktr_order_id." and tf.user_id=".$user_id." and tf.ktr_id=".$order->ktr_order_id." ORDER BY tf.ktr_trnslt_status asc", '' );
                $translatorUploadFile = $wpdb->get_results($sqlFilePath);
                $i=0;
                ?>
                <table class=" ">
                    <tr>
                        <td valign="top">Translator Uploaded File(s):</td>
                    </tr>
                    <?php if(count($translatorUploadFile)>0):?>
                            <?php
                            $loop=1;
                            $revesionArray=array();
                            foreach($translatorUploadFile as $r){

                                $version=$r->ktr_trnslt_status;
                                $date=$r->ktr_uploaded_date;
                                $upload_date=$date;
                                $upldateTime=explode(" ",$upload_date);
                                $upldateTimeArray=explode('-',$upldateTime['0']) ;
                                $upHr=explode(':',$upldateTime['1']) ;
                                $asdateAll=mktime($upHr[0],$upHr[1],$upHr[2],date($upldateTimeArray[1]),date($upldateTimeArray[2]),date($upldateTimeArray[0]));
                                $upldate=" Upload on ". date("d M Y H :i:s",$asdateAll);
                                if(!in_array($version,$revesionArray)){
                                $revesionArray[]=$version;
                                if($version==1){
                                      echo $revesion ="<tr>
                                      <td><b>
                                      ".$upldate."</b>
                                      </td>
                                      <td></td>
                                      </tr>";
                                }else{
                                    $rv=$version-1;
                                     echo $revesion ="<tr>
                                      <td><b>
                                      Revesion -".$rv.$upldate."</b>
                                      </td>
                                      <td></td>
                                      </tr>"; 
                                }

                                }
                              if($r->ktr_trnslt_status==1){
                                  $revesion ="";
                              }else{
                                  if(in_array($version,$revesionArray)){
                                  $version=$version-1;

                              }else{

                              }

                              }
                            ?>
                    <tr>

                        <td valign="top" class="detail_td">
                            <?php 
                                $i++;
                                $fileFullpathArray=explode('/',$r->ktr_trnslt_url);
                                $filename=end($fileFullpathArray);
                                echo ' <a href="'.site_url().'/wp-content/plugins/kite-file-translate-manage-system/?file='.$filename.'&path='.KTR_TRANSLATED_FILE_DIRECTORY.DS.$user_id.'" >'.$filename."</a>&nbsp;&nbsp;";
								echo " <a href=\"javascript:showAdminUploader(".$r->ktr_trnslt_id.",'".$filename."')\">Replace</a>";
								if(!$r->for_client)
									echo ' <img rel="'.$r->ktr_trnslt_id.'" class="file_remove" src="' .  site_url('/wp-content/plugins/kite-file-translate-manage-system/images/remove_icon.png') . '"   title="Remove"   style="cursor:pointer"/> ';
								if($r->for_client) 
									echo ' <img src="' .  site_url('/wp-content/plugins/kite-file-translate-manage-system/images/client_sent.png') . '" title="This file is sent to client." /> <br />';
                                ?>
                             </td>
                        </tr>
                            <?php
                            }


                        ?>
                         <?php else:?>
                          <tr>

                        <td valign="top" class="detail_td">
                            No file found.
                             </td>
                        </tr>
                        <?php endif;?>
                    </table>
            </td>
            <td>
				<div id="adminUploaderContainer" style="display:none">
					<b>Replace file <span id="adminUploaderFile"></span></b>
					<div id="adminUploader"></div>
					<ul id="separate-listtrns"></ul>
					<input type="hidden" id="adminUploaderFileId" value="" />
					<input type="button" id="adminUploaderBtn" value="Replace" style="display:none" />
				</div>
			</td>
        </tr>
    </table> 
        <?php
      
    }
     ?>
                   
        <?php
    
}

}
?>
                
   </div>    
 </div>  
<div class="clear"></div>       



<?php	
	// Comments form ------------------------------------------------------------------------- 
	$comments = bp_ktr_get_comments($order_id);
	require_once(WP_PLUGIN_DIR.DS.PLUGIN_NAME.DS."includes/templates/ktr/comments_admin.php"); 
?>



<?php
 }


	//Email to customer form  --------------------------------------------------------------- 
	require_once(WP_PLUGIN_DIR.DS.PLUGIN_NAME.DS."includes/templates/ktr/send_email_admin.php");


	
	//Additional form. Sends documents to translator once client uploads them. ---------------
	if( $order->status == AWATING_QUOTE || $order->status == AWATING_CLIENT_ACCEPTANCE ){
		require_once(WP_PLUGIN_DIR.DS.PLUGIN_NAME.DS."includes/templates/ktr/translator_send_admin.php");
	}
	
	
	
	
	
	
	
	
	}
 }
        ######

}


function create_translator_list($name){
    global $wpdb;
   
    $table=$wpdb->prefix.KTR_TRANSLATOR_INFO_TABLE;
    $table_ktr_dtl=$wpdb->prefix.KTR_TRANSLATING_DETAIL_TABLE;
    $wp_user_table=$wpdb->prefix.'users';
    $sql="SELECT * from $table as ktr INNER JOIN $wp_user_table as wp ON wp.ID=ktr.default_user_id where ktr.name='u_login' and
    ktr.default_user_id NOT IN (SELECT ktr_id FROM $table_ktr_dtl where ktr_translator_id=".$_REQUEST['order-id'].")

    order by ktr.ktr_u_id desc";
    $get_users=$wpdb->get_results($sql);
    if(count($get_users)>0){
        foreach($get_users as $tot_u){
            $recursive.="<option value='".$tot_u->ID."' >".$tot_u->user_login."</option>";
        }
        $select="<select name='".$name."' size='10' id='".$name."' >".$recursive."</select>";
        return $select;
    }else{
        return "No translator found.";
    }
}


function translator_setting(){
if($_REQUEST['action']=='add-specialization'){
    ktr_specialization_setting();
}else{
    translator_add();
}
}
function check_for_checkbox($name,$msg){
     $number_check=count($_REQUEST[$name]);
    if($number_check>0){
       for($i=0;$i<=$number_check-1;$i++){
           if(trim($_REQUEST[$name][$i])!=""){
              $data_insert=true;
           }
       }
       if($data_insert==1){
           return "";
       }else{
           return "<p>".$msg."</p>";
       }
        
    }else{
        return "<p>".$msg."</p>";
    }
}
function user_email_not_available($user_login='',$user_email,$action='',$id=''){
    
    if($action=='edt'&&$id){
         $user_info = get_userdata($id);
         $u_email=$user_info->user_email;
    }
   if($action=='edt'&&$u_email==$user_email){
       return "";
   }
    if($user_login){
        if($user_login==1){
           $error="<p>User already exists.</p>";
        }else{
            $error="";
        }
    }
      if($user_email==1){
        $error.="<p>That E-mail is registered to please chose another email</p>";
    }else{
        $error.="";
    }
    if($error!=""){
        return $error;
    }else{
        return "";
    }
}




function translator_add(){
    if(isset($_REQUEST['submit'])&&check_admin_referer('ktr-add-translator')){
                    $validator=new FormValidator();
                    $validator->addValidation('ktr_user_name',"minlen=3","User name should be atleast 3 charecter");
                    $validator->addValidation('ktr_user_name',"req","Please give your  user name");
                    $validator->addValidation('ktr_user_email',"req","Please give your email address");
                    $validator->addValidation('ktr_user_email',"email","The input for Email should be a valid email value");
                    $sp_chk_msg=check_for_checkbox("ktr_translator_specialization","Please check atlest on specialization checkbox");
                    $sp_lang_msg=check_for_checkbox("ktr_translator_language","Please check atlest on language checkbox");
                 if($validator->ValidateForm())
                {
                     
                     $user_available=check_user_login($_REQUEST['ktr_user_name']);
                     $user_email_available=check_user_email($_REQUEST['ktr_user_email']);
                      $abailable_user_email=user_email_not_available($user_available,$user_email_available)  ;   

                    if(empty($abailable_user_email)&&empty($sp_lang_msg)&&empty($sp_chk_msg)){
                          global $wpdb;  
                        $ktr_user_name=strtolower($_REQUEST['ktr_user_name']);
                        $user_name = str_replace (" ", "", $ktr_user_name);
                        $date=date('Y-m-d H:i:s',time());
                        $random_password = wp_generate_password( 12, false );
                            $user_data = array(
                            'ID' => '',
                            'user_pass' => $random_password,
                            'user_login' => $user_name,
                            'user_nicename' => $_REQUEST['ktr_user_name'],
                            'user_url' => '',
                            'user_email' => $_REQUEST['ktr_user_email'],
                            'display_name' => $_REQUEST['ktr_user_name'],
                            'nickname' => $user_name,
                            'first_name' => $user_name,
                            'user_registered' => '',
                            'role' => 'editor' // Use default role or another role, e.g. 'editor'
                            );
                    $user_id = wp_insert_user( $user_data );
                    //add_action( 'admin_init', 'fb_wp_insert_user' ); 
                    $table=$wpdb->prefix.KTR_TRANSLATOR_INFO_TABLE;
                    $sql = $wpdb->prepare(
                    "INSERT INTO $table (
                        default_user_id,
                         name,
                        value
                        ) VALUES (
                        %d,%s,%s
                    )",
                     $user_id,
                    "u_login",
                     $user_name

                    );
                    $result = $wpdb->query( $sql );
                  $sql_st = $wpdb->prepare(
                    "INSERT INTO $table (
                        default_user_id,
                         name,
                        value
                        ) VALUES (
                        %d,%s,%s
                    )",
                     $user_id,
                    "status",
                     '1'

                    );
                $result = $wpdb->query( $sql_st );
                $table=$wpdb->prefix.KTR_TRANSLATOR_INFO_TABLE;
                if(is_array($_REQUEST['ktr_translator_specialization'])){
                    for($i=0;$i<=count($_REQUEST['ktr_translator_specialization'])-1;$i++){
                         $sql = $wpdb->prepare(
                    "INSERT INTO $table (
                        default_user_id,
                         name,
                        value
                        ) VALUES (
                        %d,%s,%s
                    )",
                     $user_id,
                    "specilization",
                     $_REQUEST['ktr_translator_specialization'][$i]

                    );
                $result = $wpdb->query( $sql ); 
                }
                }
                    if(is_array($_REQUEST['ktr_translator_language'])){
                    for($i=0;$i<=count($_REQUEST['ktr_translator_language'])-1;$i++){
                         $sql = $wpdb->prepare(
                    "INSERT INTO $table (
                        default_user_id,
                         name,
                        value
                        ) VALUES (
                        %d,%s,%s
                    )",
                     $user_id,
                    "language",
                     $_REQUEST['ktr_translator_language'][$i]

                    );
                $result = $wpdb->query( $sql ); 
                }
                        
                    } 
                    $ktr_sender_email=$_REQUEST['ktr_user_email'];
                    $admin_email = get_option('ktr-setting-admin_email');
                    $noreply_email=$admin_email;
                    $headers = 'From: '. get_bloginfo( $show, 'display' ).' <'.$noreply_email.'>' . "\r\n" .'Reply-To: '.get_bloginfo( $show, 'display' ).'<'. $admin_email .'>'."\r\n" .'X-Mailer: PHP/' . phpversion();
                    $headers .= 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    $subject='Registration Information at '.get_bloginfo( $show, 'display' ). "\r\n";
                    $message="Following is the details of your user account at ".get_bloginfo( $show, 'display' ).":<br /><br /> User name: ".$user_name."
                    <br /> Password: ".$random_password."<br /><br /> -- <br /> ".get_bloginfo( $show, 'display' )."";
                    add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
                    wp_mail($ktr_sender_email , $subject,$message , $headers);
                     
                        $_SESSION['msg']="Added Successfully";
                        $error=false;
                       echo "<script type='text/javascript'>window.location='".  site_url().'/wp-admin/admin.php?page=ktr-translators-setting'."';</script>";
                       die();
                    }else{
                        
                        $_SESSION['msg']= "<b>Validation Errors:</b>".$abailable_user_email.$sp_chk_msg.$sp_lang_msg;
                        $error=true;
                    }
                  
                }else{
                    
                    $errorMsg= "<b>Validation Errors:</b>";
                    $error_hash = $validator->GetErrors();
                    foreach($error_hash as $inpname => $inp_err)
                    {
                        $msg.= "<p> $inp_err</p>\n";
                    }
                  $_SESSION['msg']= $errorMsg.$msg.$sp_chk_msg.$sp_lang_msg;
                   $error=true;
               
                }
    
    }
    
     if(isset($_REQUEST['update_user'])&&check_admin_referer('ktr-edit-translator')){
                    $validator=new FormValidator();
                   
                    $validator->addValidation('ktr_user_email',"req","Please give your email address");
                    $validator->addValidation('ktr_user_email',"email","The input for Email should be a valid email value");
                    $sp_chk_msg=check_for_checkbox("ktr_translator_specialization","Please check atlest on specialization checkbox");
                    $sp_lang_msg=check_for_checkbox("ktr_translator_language","Please check atlest on language checkbox");
                 if($validator->ValidateForm())
                {
                     $user_email_available=check_user_email($_REQUEST['ktr_user_email']);
                     $abailable_user_email=user_email_not_available('',$user_email_available,'edt',$_REQUEST['u_id'])  ;   
                    if(empty($abailable_user_email)&&empty($sp_lang_msg)&&empty($sp_chk_msg)){
                          global $wpdb;
                        $user_id=$_REQUEST['u_id'];
                        $random_password = wp_generate_password( 12, false );
                            $user_data = array(
                            'ID' => $user_id,
                            'user_email' => $_REQUEST['ktr_user_email'],
                            );
                     wp_update_user( $user_data );
                    //add_action( 'admin_init', 'fb_wp_insert_user' ); 
                    $table=$wpdb->prefix.KTR_TRANSLATOR_INFO_TABLE;
                   
                $table=$wpdb->prefix.KTR_TRANSLATOR_INFO_TABLE;
                if(is_array($_REQUEST['ktr_translator_specialization'])){
                     $wpdb->query($wpdb->prepare("Delete from $table Where default_user_id='".$user_id."' and name='specilization' %",''));
                    for($i=0;$i<=count($_REQUEST['ktr_translator_specialization'])-1;$i++){
                         $sql = $wpdb->prepare(
                    "INSERT INTO $table (
                        default_user_id,
                         name,
                        value
                        ) VALUES (
                        %d,%s,%s
                    )",
                     $user_id,
                    "specilization",
                     $_REQUEST['ktr_translator_specialization'][$i]

                    );
                $result = $wpdb->query( $sql ); 
                }
                }
                 if(is_array($_REQUEST['ktr_translator_language'])){
                     $wpdb->query($wpdb->prepare("Delete from $table Where default_user_id='".$user_id."' and name='language' %",''));
                    for($i=0;$i<=count($_REQUEST['ktr_translator_language'])-1;$i++){
                       $sql = $wpdb->prepare(
                    "INSERT INTO $table (
                        default_user_id,
                         name,
                        value
                        ) VALUES (
                        %d,%s,%s
                    )",
                     $user_id,
                    "language",
                     $_REQUEST['ktr_translator_language'][$i]

                    );
                $result = $wpdb->query( $sql ); 
                }
                     
                    }        
                   
                        
                        
                        $_SESSION['msg']="Updated Successfully";
                        $error=false;
                       echo "<script type='text/javascript'>window.location='".  site_url().'/wp-admin/admin.php?page=ktr-translators-setting'."';</script>";
                       die();
                    }else{
                        
                        $_SESSION['msg']= "<b>Validation Errors:</b>".$abailable_user_email.$sp_chk_msg.$sp_lang_msg;
                        $error=true;
                    }
                  
                }else{
                    
                    $errorMsg= "<b>Validation Errors:</b>";
                    $error_hash = $validator->GetErrors();
                    foreach($error_hash as $inpname => $inp_err)
                    {
                        $msg.= "<p> $inp_err</p>\n";
                    }
                  $_SESSION['msg']= $errorMsg.$msg.$sp_chk_msg.$sp_lang_msg;
                   $error=true;
               
                }
    
    }
    if($_REQUEST['action']=='delete'){
        $id=$_REQUEST['id'];
         wp_delete_user( $id );
         $_SESSION['msg']='Deleted';
    }
    
    if($_REQUEST['action']=='edt'){
        global $wpdb;
        $table=$wpdb->prefix.KTR_TRANSLATOR_INFO_TABLE;
        $user_info = get_userdata($_REQUEST['id']);
        $user_name=$user_info->user_login;
        $user_email=$user_info->user_email;
        $btn_name="update_user";
        $btn_val="Update";
         $edt_q="select * from $table where default_user_id='".$_REQUEST['id']."'";
        $edt_info=$wpdb->get_results($edt_q);
        foreach($edt_info as $e){
            if($e->name=='specilization'){
                 $edt_sp[]=$e->value;
            }
            if($e->name=='language'){
                $edt_lang[]=$e->value;
            }
    }
    if($error){
        $user_email=$_REQUEST['ktr_user_email'];
    }
    }else{
        $btn_name="submit";
        $btn_val="Add";
        if($error){
            $user_name=$_REQUEST['ktr_user_name'];
            $user_email=$_REQUEST['ktr_user_email'];
        }else{
             $user_name="";
            $user_email="";
        }
    }


    ?>

    <div class="wrap">
		<h2><?php _e( 'Translators', 'bp-ktr' ) ?></h2>
		
    <?php if ( $_SESSION['update']== 'true') : ?><?php echo "<div id='message' class='updated fade'><p>" . __( 'Updated.', 'bp-ktr' ) . "</p></div>" ?><?php $_SESSION['update']=''; endif; ?>
    <?php if ( $_SESSION['msg']) : ?><?php echo "<div id='message' class='updated fade'><p>" . __( $_SESSION['msg'], 'bp-ktr' ) . "</p></div>" ?><?php $_SESSION['msg']=''; endif; ?>
                <div class="add_new_top"><a href="<?php echo admin_url() ?>/admin.php?page=ktr-translators-setting&AMP;action=add-specialization">Add Specialization</a></div> <br />
               <div class="clear"></div>
               <?php if($_REQUEST['action']=='edt'){ ?>
               <div id="add_language"><h3>Update User</h3></div>
               <?php }else{ ?>
                      <div id="add_language"><h3>Add New</h3></div>
              <?php } ?>
                <div class="add-new">     
                    <?php if($_REQUEST['action']=='edt'){$form_action='&action=edt&id='.$_REQUEST['id'];}else{$form_action='';}?>
                       <form action="<?php echo site_url() . '/wp-admin/'.$mu_path_x.'admin.php?page=ktr-translators-setting'.$form_action ?>" name="ktr-translators-setting-form" id="ktr-translators-setting-form" method="post">
                           
			<table class="form-table-file-type-add add-specialiazation">
				<tr valign="top">
                                        
					<th scope="row"><label for="ktr_user_name"><?php _e( 'Username', 'bp-ktr' ) ?></label></th>
                                        <td><?php if($_REQUEST['action']=='edt'):?>
                                            <?php echo $user_name; ?>
                                            <?php else:?>
                                             <input name="ktr_user_name" type="text" id="ktr_user_name" value="<?php echo $user_name; ?>" size="30" />
                                            <?php endif;?>
                                           
					</td>
                               </tr>
                               <tr valign="top">
					<th scope="row"><label for="ktr_user_name"><?php _e( 'Email', 'bp-ktr' ) ?></label></h>
                                        <td>
                                            <input name="ktr_user_email" type="text" id="ktr_user_email" value="<?php echo $user_email; ?>" size="30" />
					</td>
                               </tr>
                              <tr valign="top">
                                    <th valign="top" scope="row"><label for="ktr_user_name"><?php _e( 'Specialization', 'bp-ktr' ) ?></label></h>
                                    <td>
                                        <div>
                               <?php
                               global $wpdb;
                               $table=$wpdb->prefix.KTR_TRANSLATOR_SPECIALIZATION_TABLE;
                               $q_lang="SELECT * from $table order by ktr_specialization asc";
                                $resuls=$wpdb->get_results($q_lang);
                                if(count($resuls)>0){
                                    $loop_sp=0;
                                    if($error){
                                   
                                    }
                                    foreach ($resuls as $r){
                                          if($_REQUEST['action']=='edt'&&!$error){
                                            if(is_array($edt_sp)){
                                           if(in_array($r->ktr_apecialization_id, $edt_sp)){
                                                $check="checked";
                                               //echo $r->ktr_apecialization_id;
                                            }else{
                                                $check="";
                                            }
                                            }
                                        }else{
                                            if(  is_array($_REQUEST['ktr_translator_specialization'])){
                                            if(in_array($r->ktr_apecialization_id, $_REQUEST['ktr_translator_specialization'])){
                                                $check="checked";
                                               //echo $r->ktr_apecialization_id;
                                            }else{
                                                $check="";
                                            }
                                            }
                                        }
                                        
                                     
                                        $specialization_val=$r->ktr_specialization;
                                        $$specialization_id=$r->ktr_apecialization_id;
                               ?>
                          
                                                <span class="ktr_chk sp"> 
                                                    <input class="ktr_checkbox sp" <?php echo $check; ?>  type="checkbox" name="ktr_translator_specialization[]" id="ktr_translator_specialization_<?php echo $loop_sp; ?>" value="<?php echo $$specialization_id; ?>"> <label for="ktr_translator_specialization_<?php echo $loop_sp; ?>"><?php echo  $specialization_val; ?></label>
                                                </span>
                                                
                          
                               <?php 
                               $loop_sp++;
                                    }
                               }else{ ?>
                                
                                      <td>
                                            No data found.
                                        </td>
                              
                               <?php }?>
                                        </div>
                                    </td>
                                </tr>
                                 <tr valign="top">
					<th valign="top" scope="row"><label for="ktr_user_name"><?php _e( 'Languages', 'bp-ktr' ) ?></label></h>
                                        <td>
                                            <div>
                                    <?php
                               global $wpdb;
                               $table=$wpdb->prefix.KTR_LANGUAGE_TABLE;
                               $q_lang="SELECT * from $table order by ktr_trnslt_from asc";
                                $resuls=$wpdb->get_results($q_lang);
                                $loop_lang=1;
                                if(count($resuls)>0){
                                    foreach ($resuls as $r){
                                        $language_val=$r->ktr_trnslt_from." To ".$r->ktr_trnslt_to;
                                        $language_id=$r->ktr_laguage_id;
                                        if($_REQUEST['action']=='edt'&&!$error){
                                            if(is_array($edt_lang)){
                                           if(in_array($r->ktr_laguage_id, $edt_lang)){
                                               echo $check="checked";
                                               //echo $r->ktr_apecialization_id;
                                            }else{
                                                $check="";
                                            }
                                            }
                                        }else{
                                          if(is_array($_REQUEST['ktr_translator_language'])){
                                           if(in_array($r->ktr_laguage_id, $_REQUEST['ktr_translator_language'])){
                                                $check="checked";
                                               //echo $r->ktr_apecialization_id;
                                            }else{
                                                $check="";
                                            }
                                            }
                                        }
                                        
                               ?>
                            
                                                <span class="ktr_chk lang"> 
                                                    <input class="ktr_checkbox2 lang" <?php echo $check; ?> type="checkbox" name="ktr_translator_language[]" id="ktr_translator_language_<?php echo $loop_lang; ?>" value="<?php echo $language_id; ?>"> <label for="ktr_translator_language_<?php echo $loop_lang; ?>"><?php echo  $language_val; ?></label>
                                                </span>
                                                
                               
                               <?php 
                                $loop_lang++;
                                    }
                               }else{ ?>
                                      <td>
                                            No data found.
                                        </td>
                                  
                               <?php }?>
                               
                                            </div>
                                        </td>
                                        
                               </tr>
                               
                               <tr valign="top">
                                    <th  align="center" class="submit">
                                        
                                            <input type="hidden" name="u_id" value="<?php _e($_REQUEST['id']);?>" />
                                            <input type="submit" class="add_user" name="<?php _e($btn_name,'bp-ktr'); ?>" value="<?php _e( $btn_val, 'bp-ktr' ); ?>"/>
                                       
                                    </th>
                                	
				</tr>
                           
					
                               
			</table>
                           
                        <?php
			/* This is very important, don't leave it out. */
			
			?>
                           
                           <?php if($_REQUEST['action']=='edt'):?>
                            <?php wp_nonce_field( 'ktr-edit-translator' );?>
                           <?php else:?>
                           <?php wp_nonce_field( 'ktr-add-translator' );?>
                           <?php endif;?>
                    </form>
                    
                  
                </div>
                      <?php if($_REQUEST['action']=='edt'){?>
                      <?php echo " "; ?>
                       <?php }else{?>
                      <?php 
                      global $wpdb;
                       $table=$wpdb->prefix.KTR_TRANSLATOR_INFO_TABLE;
                        $wp_user_table=$wpdb->prefix.'users';
                        $sql="SELECT * from $table as ktr INNER JOIN $wp_user_table as wp ON wp.ID=ktr.default_user_id where ktr.name='u_login' order by ktr.ktr_u_id desc";
                        $get_user=$wpdb->get_results($sql);
						
                      ?>
                <?php if(count($get_user) >=1):?>
                 <div id="add_language"><h3>List Translator</h3></div>
                 <div class="add-new">  
		<form action="<?php echo site_url() . '/wp-admin/'.$mu_path_x.'admin.php?page=ktr-translators-setting&action=add-specialization' ?>" name="ktr-user-specialization_update" id="ktr-user-specialization_update" method="post" >

			<table class="form-table-type ffs_tran" style="width:50%">
				<tr valign="top">
					<th scope="row" class="serial"><label for="target_uri"><?php _e( 'Name', 'bp-ktr' ) ?></label></th>
					<th scope="row" class="serial"><label><?php _e( 'Language', 'bp-ktr' ) ?></label></th>
					<th scope="row" class="serial"><label><?php _e( 'Status', 'bp-ktr' ) ?></label></th>
					<th scope="row" align="left" width="130"><label for="target_uri"><?php _e( 'Action', 'bp-ktr' ) ?></label></th>
				</tr>    
                
				<?php foreach($get_user as $val):?>
				<?
						
				?>
                <tr>
					<td>
                        <a href="#"><?php echo $val->value;?></a>
					</td>
					<td>
                        <?php echo bp_ktr_get_t_langs($val->default_user_id);?>
					</td>
					<td>
                        <?php echo bp_ktr_get_t_status($val->default_user_id);?>
					</td>
					<td class="submit">
						<a href="<?php echo site_url() . '/wp-admin/admin.php?page=ktr-translators-setting&action=edt&id='.$val->default_user_id; ?>">Edit</a>
						<a href="<?php echo site_url() . '/wp-admin/admin.php?page=ktr-translators-setting&action=delete&id='.$val->default_user_id; ?>">Delete</a>              
					</td>
                                    
				</tr>
                <?php  endforeach;?>
                               
                                
			</table>
                    <?php
			/* This is very important, don't leave it out. */
			wp_nonce_field( 'ktr-update-specialization' );
			?>
                    </form>
                     <?php else:?>
                     <div id="add_language"><h3>List Translator</h3></div>
                     <div>No data found.</div>
                 <?php endif;?>


		</div>	
		
         <?php }?>
    <?php
}

function ktr_specialization_setting(){
        global $wpdb;
        $table = $wpdb->prefix . KTR_TRANSLATOR_SPECIALIZATION_TABLE;
    	/* If the form has been submitted and the admin referrer checks out, save the settings */
	if ( isset( $_POST['submit'] ) &&isset($_POST['ktr-user-specialization'])) {
            if($_POST['ktr-user-specialization']!=""){
         
            $sql = $wpdb->prepare(
                "INSERT INTO $table (
                        ktr_specialization
                ) VALUES (
                            %s
                    )",
                    $_POST['ktr-user-specialization']
                 
                    );
                $result = $wpdb->query( $sql );
		$_SESSION['msg']='Added Successfully.';
                echo "<script type='text/javascript'>window.location='".  site_url().'/wp-admin/admin.php?page=ktr-translators-setting&action=add-specialization'."';</script>";
                
            }else{
                $_SESSION['msg']='Please write a value.';
                echo "<script type='text/javascript'>window.location='".  site_url().'/wp-admin/admin.php?page=ktr-translators-setting&action=add-specialization'."';</script>"; 
            }
            die();
	}
        
        
      if(isset( $_POST['update_specialization'] ) && check_admin_referer('ktr-update-specialization')){
       
        if(count($_REQUEST['ktr-selected-specialization'])>0){
         
            foreach($_REQUEST['ktr-selected-specialization'] as $key=>$val){
             
             $sql = $wpdb->prepare(
				"UPDATE $table SET
					ktr_specialization  = '".$_REQUEST['ktr-specialization'][$key]."'
                                WHERE ktr_apecialization_id  = '".$val."' %"
				,'');
                $updated= $wpdb->query($sql);
                $_SESSION[msg]="Updated successfully";
         
  
            }
            
          }
        
         
        
        }
        
        
      if(isset( $_POST['delete_specialization'] ) ){
        
        if(is_array($_REQUEST['ktr-selected-specialization'])){
            
            foreach($_REQUEST['ktr-selected-specialization'] as $val){
               
               $updated= $wpdb->query( $wpdb->prepare( "DELETE FROM $table WHERE ktr_apecialization_id = %d  ", $val ) );
               $_SESSION[msg]="Deleted successfully";
  
            }
            
               //echo "<script type='text/javascript'>window.location='".  site_url().'/wp-admin/admin.php?page=ktr_language_setting'."';</script>";
          }
        
         
        }
        
       
        $sql = $wpdb->prepare( "SELECT * FROM $table  ORDER BY ktr_apecialization_id  desc" );
        $get_specialization = $wpdb->get_results($sql);

 ?>
	<div class="wrap">
		<h2><?php _e( 'Specialization', 'bp-ktr' ) ?></h2>
		<br />
                

		<?php if ( $_SESSION[msg]!="" ) : ?><?php echo "<div id='message' class='updated fade'><p>" . $_SESSION[msg] . "</p></div>" ;$_SESSION[msg]=""; ?><?php endif; ?>
                <div id="add_language"><h3>Add New</h3></div>
                <div class="add-new">     
                    
                       <form action="<?php echo site_url() . '/wp-admin/'.$mu_path_x.'admin.php?page=ktr-translators-setting&action=add-specialization' ?>" name="ktr-specialization-settings-form" id="ktr-settings-form" method="post">
			<table class="form-table-file-type-add">
				<tr valign="top">
                                        
					<th scope="row"><label for="target_uri"><?php _e( 'Type', 'bp-ktr' ) ?></label>
                                        <input name="ktr-user-specialization" type="text" id="ktr-user-specialization" value="" size="30" />
					</th>
                                       
                                    <th  align="center" class="submit">
                                       
                                            <input type="submit" name="submit" value="<?php _e( 'Add', 'bp-ktr' ) ?>"/>
                                       
                                    </th>
                                	
				</tr>
                           
					
                               
			</table>
                           
                        <?php
			/* This is very important, don't leave it out. */
			wp_nonce_field( 'ktr-settings-specialization' );
			?>
                    </form>
                </div>
<?php if(count($get_specialization) >=1):?>
                 <div id="add_language"><h3>List Specialization </h3></div>
                 <div class="add-new">  
		<form action="<?php echo site_url() . '/wp-admin/'.$mu_path_x.'admin.php?page=ktr-translators-setting&action=add-specialization' ?>" name="ktr-user-specialization_update" id="ktr-user-specialization_update" method="post" >

			<table class="form-table-type">
				<tr valign="top">
                                    <th scope="row" class="serial">&nbsp;</th>
                                    <th scope="row" align="left"><label for="target_uri"><?php _e( 'Type', 'bp-ktr' ) ?></label></th>
                               
                                </tr>
					
				<tr>
                             <?php $loop=0; ?>
                                    <?php foreach($get_specialization as $val):?>
                                       
					<td>
						<input class="ktr_checkbox" name="ktr-selected-specialization[<?php echo $loop; ?>]" type="checkbox" id="" value="<?php echo $val->ktr_apecialization_id ; ?>" />
                                                
					</td>
                                        <td>
						<input name="ktr-specialization[<?php echo $loop; ?>]" type="text" id="" value="<?php echo $val->ktr_specialization; ?>" size="30" />
					</td>
                                    
				</tr>
                                <?php $loop++; ?>
                                <?php  endforeach;?>
                               
                                </tr>
					
                                <td colspan="2" class="submit">
                                    <input type="submit" class="chk_validate" name="update_specialization" value="<?php _e( 'Update', 'bp-ktr' ) ?>"/>
                                      <input type="submit" name="delete_specialization" class="ktr_delete" value="<?php _e( 'Delete', 'bp-ktr' ) ?>"/>
                                </td>
                                        
				</tr>
			</table>
                    <?php
			/* This is very important, don't leave it out. */
			wp_nonce_field( 'ktr-update-specialization' );
			?>
                    </form>
                 <?php endif;?>


		</div>	
		
	</div>
<?php   
}

function emails_setting(){
	global $wpdb;
	
	$table 	= $wpdb->prefix.KTR_EMAILS_TABLE;
	
	if(isset($_REQUEST['email_save_btn'])){
		
		list($name, $parts) = each($_REQUEST['email_parts']);
		$wpdb->update( $table, $parts, array( 'name' => $name ) ); 
		
		echo "<div id='message' class='updated fade'><p>" . __("Email saved.", 'bp-ktr' ) . "</p></div>";
	}
	
	
    $emails = $wpdb->get_results( "SELECT * FROM $table" ); 
	
    
	require_once(WP_PLUGIN_DIR.DS.PLUGIN_NAME.DS."includes/templates/ktr/email_settings.php");

    
    
//    echo "<h1>Christmas</h1>";
    
}


function specialisations_setting(){
	global $wpdb;
	
	$table 	= $wpdb->prefix.KTR_TRANSLATOR_SPECIALIZATION_TABLE;
	
	if(isset($_REQUEST['action'])){
		$action = $_REQUEST['action'];
		switch($_REQUEST['action']){
			case 'new_form':
				$title = 'New Specialisation';
				$form_action = 'new_save';
				
				$s = $s_id = '';
			break;
			
			case 'new_save':
				if($_REQUEST['s_name']){
					$wpdb->insert( $table, array( 'ktr_specialization' => $_REQUEST['s_name']) ); 
					echo "<div id='message' class='updated fade'><p>" . __("Specialisation added.", 'bp-ktr' ) . "</p></div>";
				}
			break;
			
			case 'edit_form':
				$title = 'Edit Specialisation';
				$form_action = 'edit_save';
				
				$sql = $wpdb->prepare( "SELECT * FROM $table where ktr_apecialization_id = '%' LIMIT 1", $_REQUEST['id'] );
				$row = $wpdb->get_row($sql);
				$s = $row->ktr_specialization;
				$s_id = $row->ktr_apecialization_id;
			break;

			case 'edit_save':
				if($_REQUEST['s_name'] && $_REQUEST['s_id']){
					$wpdb->update( $table, 
						array( 'ktr_specialization' => $_REQUEST['s_name']), 
						array( 'ktr_apecialization_id' => $_REQUEST['s_id'] ) 
					); 
					echo "<div id='message' class='updated fade'><p>" . __("Specialisation updated.", 'bp-ktr' ) . "</p></div>";
				}
			break;
			
			case 'delete':
				if($_REQUEST['id']){
					$wpdb->query( $wpdb->prepare( "DELETE FROM $table WHERE ktr_apecialization_id = %d", $_REQUEST['id']) );
					echo "<div id='message' class='updated fade'><p>" . __("Specialisation removed.", 'bp-ktr' ) . "</p></div>";
				}
			break;
		}
		//$wpdb->update( $table, $parts, array( 'name' => $name ) ); 
		
		//echo "<div id='message' class='updated fade'><p>" . __("Email saved.", 'bp-ktr' ) . "</p></div>";
	}
	
	
    $specialisations = $wpdb->get_results( "SELECT * FROM $table" ); 
	
	require_once(WP_PLUGIN_DIR.DS.PLUGIN_NAME.DS."includes/templates/ktr/specialisations_setting.php");
}



function z_send_files(){
	global $wpdb;
	
	if($_REQUEST['send_file_check_box']){
		$file_ids = $_REQUEST['send_file_check_box'];
		
		//Mark the files in database. These files will be visible for client
		$filesTable 	= $wpdb->prefix.KTR_TRANSLATE_FILE_URL_TABLE;
		$file_ids_str = implode(",", $file_ids);
		$sql = $wpdb->prepare(
				"UPDATE $filesTable SET for_client  = '1'
				WHERE ktr_trnslt_id IN ({$file_ids_str}) ", '');
		$wpdb->query($sql);
		
		//Send files to client ..................................................................................
		
		//Get client email
		$orderTable=$wpdb->prefix.KTR_ORDER_INFO_TABLE;
		$sql = $wpdb->prepare( "SELECT * FROM $orderTable where ktr_order_id=%s ORDER BY ktr_id desc", $_REQUEST['order_id'] );
        $order = $wpdb->get_row($sql);		
		$client = get_userdata( $order->ktr_order_from );
				
		$admin_email = get_option( 'ktr-setting-admin_email' );
		$headers = 'From: '. get_bloginfo( $show, 'display' ).'<'.$admin_email.'>' . "\r\n";
		$headers .= 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$date= date("d M Y",$dateAll);
		$subject  = "Translations are ready! \r\n";
		$message  =  bp_ktr_get_email('client_translation_ready', 'salutation');
		$message .= "<br /><br />Please find the translations attached.<br /><br />";
		$message .= bp_ktr_get_email('client_translation_ready', 'footer');
		
		add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
		
		//Prepare attachements
		$attachments = array();
		$filesSql    = 	"SELECT * FROM $filesTable AS f WHERE ktr_id = %s AND for_client = 1";
		$rows 		 = $wpdb->get_results($wpdb->prepare( $filesSql, $_REQUEST['order_id'] ));
		foreach($rows as $r){
			$attachments[]= WP_CONTENT_DIR . str_replace('wp-content','',$r->ktr_trnslt_url);
		}
			
        wp_mail($client->user_email , $subject, $message , $headers, $attachments);
		
		//Set status to "Translation sent"
		bp_ktr_set_status($_REQUEST['order_id'], TSENT);
		
		print '<script> document.location = "' . admin_url('admin.php?page=ktr-order-view') . '"; </script>';
		exit();
	}

}


//Create translator list for a specific language combination
function z_translator_list($lang_id, $default_translator){
    global $wpdb;
   
    $translatorTable = $wpdb->prefix.KTR_TRANSLATOR_INFO_TABLE;
    $userTable = $wpdb->prefix.'users';
    $sql = "SELECT default_user_id from $translatorTable WHERE name = 'language' AND value =  $lang_id";
    $translators = $wpdb->get_results($sql);
	
	$options  .= "<option value=''>&lt; Please select &gt;</option>";
	if(count($translators)>0){
		foreach($translators as $t){
			$user_info = get_userdata($t->default_user_id);
			$selected  = ($default_translator == $t->default_user_id ? 'selected' : '');
			$options  .= "<option value='".$t->default_user_id."' {$selected} >".$user_info->user_login."</option>";
		}
		return "<select name='default_translator[".$lang_id."]'>".$options."</select>";
	}else{
		return false;
	}	
}

function z_statusses_list($selected_status){
    global $wpdb;
   
	$selected[7] = $selected[6] = $selected[5] = $selected[4] = $selected[3] = $selected[33] = $selected[35] = $selected[37] = $selected[1] = ''; 
	$selected[$selected_status] = ' selected="selected"';
   
    $options = '';        
	$options  .= "<option value='7'{$selected[7]}>".sentence_case("AWATING QUOTE")."</option>";
	$options  .= "<option value='6'{$selected[6]}>".sentence_case("AWATING CLIENT ACCEPTANCE")."</option>";
	$options  .= "<option value='5'{$selected[5]}>".sentence_case("PAYMENT RECEIVED")."</option>";
	$options  .= "<option value='4'{$selected[4]}>".sentence_case("ACCEPTED")."</option>";
	$options  .= "<option value='3'{$selected[3]}>".sentence_case("PENDING")."</option>";
	$options  .= "<option value='33'{$selected[33]}>".sentence_case("TRANSLATOR CONFIRMED")."</option>";
	$options  .= "<option value='35'{$selected[35]}>".sentence_case("TRANSLATED")."</option>";
	$options  .= "<option value='37'{$selected[37]}>"."Translation sent"."</option>";
	$options  .= "<option value='1'{$selected[1]}>".sentence_case("COMPLETE")."</option>";
	
	return "<select name='status_selector'>".$options."</select>";
}


?>