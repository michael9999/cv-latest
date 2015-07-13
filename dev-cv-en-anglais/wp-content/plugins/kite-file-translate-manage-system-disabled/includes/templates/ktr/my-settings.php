
<?php get_header() ?>

<script type="text/javascript">
jQuery(function() {
	jQuery('#translatorAvailabilityPeriod').datepick({rangeSelect: true, dateFormat: 'dd/mm/yyyy' });
});
</script>

	<div id="content">
		<div class="padder">

			<div id="item-header">
				<?php locate_template( array( 'members/single/member-header.php' ), true ) ?>
			</div>

			<div id="item-nav">
				<div class="item-list-tabs no-ajax" id="object-nav">
					<ul>
						<?php bp_get_displayed_user_nav() ?>
					</ul>
				</div>
			</div>

			<div id="item-body">
                            <div class="item-list-tabs no-ajax" id="subnav">
					<ul><?php bp_get_options_nav() ?></ul>
				</div>
                             <div class="wrap"><!--body wrap-->
                                 <?php 
                                 global $wpdb;
                                 global $bp;
                                 $table=$wpdb->prefix.KTR_TRANSLATOR_INFO_TABLE;
                                 $user=wp_get_current_user(); 
                                $user_id =$user->ID;
                           
                                        if ( isset( $_POST['submit'] ) && check_admin_referer('translator-settings') ) {
                                              $sql = $wpdb->prepare(
                                                            "UPDATE $table SET
                                                                    value  = '".$_REQUEST['translatorAvailability']."'
                                                            WHERE default_user_id  = '%s' and name='status'"
                                                            , $user_id);
                                                    $updated= $wpdb->query($sql);
													$updated=true;
													
													
													//Set availability period
													if($_REQUEST['translatorAvailabilityPeriod']){														
														$where = "default_user_id  = %s and name='unavailability_period'";
														$check_query = "SELECT COUNT(*) FROM $table WHERE  $where";
														if($wpdb->get_var( $wpdb->prepare( $check_query, $user_id ) )){
															$sql = $wpdb->prepare("UPDATE $table SET value  = '{$_REQUEST['translatorAvailabilityPeriod']}' WHERE $where", $user_id);
															$wpdb->query($sql); 
														}else{
															$sql = $wpdb->prepare("INSERT INTO $table SET 
																default_user_id = {$user_id},
																name = 'unavailability_period',
																value  = '%s'", $_REQUEST['translatorAvailabilityPeriod']);
															$wpdb->query($sql);  
														}
													}
													
                                                    
                                        }
                                        
                                        $q="SELECT * FROM $table WHERE default_user_id='%s' and name='status'";
                                        $results=$wpdb->get_row($wpdb->prepare($q, $user_id));
                                        $status=$results->value;
                                        
                                        if($status==1){
                                           $checkAvailable="checked" ;
                                        }else{
                                            $checkAvailable="";
                                            $checkNotAvailable="checked" ;
                                            
                                        }
										
										
										//Get availability period from db
										$where = "default_user_id  = '%s' and name='unavailability_period'";
										$availabilityPeriod = $wpdb->get_var( $wpdb->prepare( "SELECT value FROM $table WHERE  $where", $user_id ) );
                                 
                                 ?>
                                <h2>Availability</h2>
                                <?php if ( isset($updated) ) : ?><?php echo "<div id='message' class='updated fade'><p>" . __( 'Settings Updated.', 'bp-ktr' ) . "</p></div>" ?><?php endif; ?>
              
                                <form action="" method="post" name="" id="">
                                <table class="form-table-list">
                                        <tr valign="top">
                                            <td class="dtl_left_td">Availability Status </td>
                                            <td >
                                                <span class="available"><input type="radio" value="1" name="translatorAvailability" <?php echo $checkAvailable?> /> Available</span>
                                                <span class="available"><input type="radio" value="0" name="translatorAvailability" <?php echo $checkNotAvailable?> /> Not Available</span>
                                            </td>
                                        </tr>
										<tr valign="top">
                                            <!--td class="dtl_left_td">Availability Period</td-->
                                            <td class="dtl_left_td">Not available within</td>
                                            <td>
                                                <span class="available">
													<input type="text" id="translatorAvailabilityPeriod" name="translatorAvailabilityPeriod" value="<?php echo $availabilityPeriod ?>" style="width:170px" />
												</span>                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>
                                                <?php wp_nonce_field('translator-settings');?>
                                                <input  type="submit" name="submit" id="submit" value="Save" />
                                            </td>
                                        </tr>
                                </table>
                                    </form>

                             </div><!-- #item-body wrap -->
                    </div><!-- #item-body -->

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php locate_template( array( 'sidebar.php' ), true ) ?>

<?php get_footer() ?>
