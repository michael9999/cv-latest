
<?php get_header() ?>

	<script type="text/javascript">
	jQuery(function() {
		jQuery("#due_date_new").datepick({dateFormat: 'dd/mm/yyyy' });
		
		jQuery("#due_date_confirm").click(function() {		   
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


		jQuery("#due_date_btn").click(function() {	
		   if(jQuery("#due_date_new").val() == ''){
				alert('Please enter the date.');
				return false;
		   }
		   
		   jQuery.post( ajaxurl, {
				action: 'translator_change_due_date',
				'cookie': encodeURIComponent(document.cookie),
				'order_id': jQuery("#due_date_confirm").val(),
				'due_date_new': jQuery("#due_date_new").val()
		  },
		  function(data) {
			    alert(data);
				location.reload();
		  });
		  
		  return false;
		});
	});
	</script>


	<style>
		#content table { border:0; }
		#content tr{ border-bottom:0; }
		#content tr td{ border-top:0; }
	</style>
	
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
                            <div class="wrap">
                                 <?php  global $bp; if ( $bp->current_component == $bp->ktr->slug && 'my-task' == $bp->current_action && $bp->action_variables[0]=="" ) {?>
                                <h2>My Projects</h2>
                                <?php
                                 $user=wp_get_current_user(); 
                                $user_id =$user->ID;
                                $get_results=get_editor_task();
                                
                                ?>
                                <?php if(count($get_results)>0): ?>
                                
                                <table class="form-table-list">
                                        <tr valign="top">
                                            <th scope="row"><label for="target_uri"><?php _e( 'Order No', 'bp-ktr' ) ?></label></th>
                                            <th scope="row"><label for="target_uri"><?php _e( 'Assign Date', 'bp-ktr' ) ?></label></th>
                                           <th scope="row"><label for="target_uri"><?php _e( 'Due Date', 'bp-ktr' ) ?></label></th>
                                        </tr>
                               
                                <?php foreach($get_results as $r):?>
                                <?php 
                               $dtl_link = $bp->loggedin_user->domain . $bp->current_component.'/'.$bp->current_action.'/';
                                $assign_date=$r->ktr_assign_date;
                                $asdateTime=explode(" ",$r->ktr_assign_date);
                                $asdateArray=explode('-',$asdateTime['0']) ;
                                $asdateAll=mktime(0,0,0,date($asdateArray[1]),date($asdateArray[2]),date($asdateArray[0]));
                                $asdate= date("d M Y",$asdateAll);
                                $due_date=$r->ktr_due_date;
                                $ddateTime=explode(" ",$due_date);
                                $ddateArray=explode('-',$ddateTime['0']) ;
                                $ddateAll=mktime(0,0,0,date($ddateArray[1]),date($ddateArray[2]),date($ddateArray[0]));
                                $ddate= date("d M Y",$ddateAll);
                                ?>
                                <tr>
                                    <td><a href="<?php echo $bp->loggedin_user->domain . $bp->current_component.'/my-task/'.$r->ktr_order_id.$r->ktr_translator_id; ?>"><?php echo $r->ktr_translator_id; ?></a> </td>
                                    <td><?php echo $asdate;  ?></td>
                                    <td><?php echo $ddate;  ?></td>
                                </tr>
                                 <?php endforeach;?>
                                 </table>
                                   <?php  else: ?>
                                    <div class="nodata"> Nodata found.</div>
                                <?php  endif; ?>
                            <?php }elseif ( $bp->current_component == $bp->ktr->slug && 'my-task' == $bp->current_action && $bp->action_variables[0]!="" ) { ?>
                                    <?php
                                     global $wpdb;
                                     global $bp;
                                     $current_user=wp_get_current_user();
                                     $userID=$current_user->ID;
                                     $dir=TEMP_DIR.DS.  session_id();
                                   
                                     if($_REQUEST['ktr_translator_upload']){

                                         echo $upload_path = get_option( 'upload_path' );
                                     }else{
                                         if(is_dir($dir)){
                                         remove_temp_directory($dir);
                                         }
                                     }
                                    
                                        if(is_numeric($bp->action_variables[0])){
                                                $dtl_link = $bp->loggedin_user->domain . $bp->current_component.'/'.$bp->current_action.'/';
                                                
                                                $table=$wpdb->prefix.KTR_ORDER_INFO_TABLE;
                                                 $table_translator_detail=$wpdb->prefix.KTR_TRANSLATING_DETAIL_TABLE;
                                                $sql = $wpdb->prepare( "SELECT ord.*,
                                                       dtl.ktr_detail_id,
                                                       dtl.ktr_translator_id as order_id,
                                                       dtl.ktr_id as u_id,
                                                       dtl.ktr_comment,
                                                       dtl.ktr_assign_date,
                                                       dtl.ktr_due_date,
                                                       dtl.ktr_pending_status
                                                       FROM $table as ord 
                                                       INNER JOIN $table_translator_detail as dtl on dtl.ktr_translator_id=ord.ktr_order_id
                                                       where ord.ktr_order_id=".$bp->action_variables[0]." and dtl.ktr_id = %d  ORDER BY ord.ktr_id desc", $userID );
                                                $order = $wpdb->get_row($sql);
                                                if($order->ktr_order_id == $bp->action_variables[0]){
                                                    $languagePrice= get_option("ktr-setting-language-price");
                                                    $dateTime=explode(" ",$order->ktr_order_date);
                                                    $language=$order->ktr_language;
                                                    $user_msg=$order->ktr_message;
                                                    $dateArray=explode('-',$dateTime['0']) ;
                                                    $dateAll=mktime(0,0,0,date($dateArray[1]),date($dateArray[2]),date($dateArray[0]));
                                                    $date= date("d M Y",$dateAll);
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
                                                    $staus="";
                                                    if($order->status==AWATING_QUOTE){
                                                        $status=sentence_case("AWATING QUOTE");
                                                    }elseif($order->status==AWATING_CLIENT_ACCEPTANCE){
                                                      $status=sentence_case("AWATING  CLIENT ACCEPTANCE");
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
                                                        $status=sentence_case("PAYMENT RECEIVED");
                                                    }elseif($order->status==COMPLETE){
                                                        $status=sentence_case("COMPLETE");
                                                    }
                                                    $currency_code=$order->ktr_currency_code;
                                                    $currency_symbol=  get_currency_symbol_by_currency_code($currency_code);
                                                     
                                                    $assign_date=$order->ktr_assign_date;
                                                    $asdateTime=explode(" ",$assign_date);
                                                    $asdateArray=explode('-',$asdateTime['0']) ;
                                                    $asdateAll=mktime(0,0,0,date($asdateArray[1]),date($asdateArray[2]),date($asdateArray[0]));
                                                    $asdate= date("d M Y",$asdateAll);
                                                    $due_date=$order->ktr_due_date;
                                                    $ddateTime=explode(" ",$due_date);
                                                    $ddateArray=explode('-',$ddateTime['0']) ;
                                                    $ddateAll=mktime(0,0,0,date($ddateArray[1]),date($ddateArray[2]),date($ddateArray[0]));
                                                    $ddate= date("d M Y",$ddateAll);
                                                    
                                                    
                                                    
                                                    ?>
                             
                                  <!--Deatail Translation-->
                                    <form action="" name="ktr-order-settings-price" id="ktr-settings-form" method="post">
                                                        <?php 
                                                        global $pluginsJsUrl;
                                                        global $pluginsStyleUrl;
                                                        
                                                        if($_REQUEST['ktr_translator_upload']){
                                                            $order_id=$_REQUEST['hid_order_id'];
                                                        } else{
                                                        $dir=TEMP_DIR.DS.  session_id();
                                                        if(is_dir($dir)){
                                                        remove_temp_directory($dir);
                                                        }
                                                        }
                                                        ?>
                                                        
                                                        <script>
																jQuery(function() {
																
                                                                    var uploaderTranslator = new qq.FileUploader({ 
                                                                        element: document.getElementById('trasnlatorUploader'),
                                                                        listElement: document.getElementById('separate-listtrns'),
                                                                        action: '<?php echo home_url()?>/wp-content/plugins/kite-file-translate-manage-system/valums-file-uploader/server/php.php'
                                                                    });           
                                                                     
																});
                                                            </script> 
                                                            <?php if ( $_SESSION['insert_error_msg'] ): 
                                                                     $dir=TEMP_DIR.DS.  session_id();
                                                                     if(is_dir($dir)){
                                                                    remove_temp_directory($dir);
                                                                }
                                                                     ?><?php echo "<div id='message' class='updated fade'><p>" . __("<b>Error:</b><br/>". $_SESSION['insert_error_msg'], 'bp-ktr' ) . "</p></div>" ?><?php  $_SESSION['insert_error_msg']=""; endif; ?>
                                                    <?php if ( $_SESSION['msg'] ): ?><?php echo "<div id='message' class='updated fade'><p>" . __( $_SESSION['msg'], 'bp-ktr' ) . "</p></div>" ?><?php $_SESSION['msg']=""; endif; ?>
                                                    <table class="form-table-list">
                                                         <tr>
                                                            <td valign="top">
                                                                <table>
                                                                    <tr><td valign="top" class="dtl_left_td">Order No: </td><td><?php echo $bp->action_variables[0];?></td></tr>
                                                                    <tr><td valign="top" class="dtl_left_td">Language: </td><td><?php echo $language;?></td></tr>
                                                                    
                                                                    <tr><td valign="top" class="dtl_left_td">Date Assigned:</td><td><?php echo $asdate;?></td></tr>
                                                                    <tr>
																		<td class="dtl_left_td">Due Date:</td>
																		<td>
																			<?php echo $ddate;?> 
																			<?php if($order->ktr_pending_status == 3): ?>
																					<br />
																					<input type="checkbox" id="due_date_confirm" value="<?php echo $bp->action_variables[0]?>" /> Confirm &nbsp;&nbsp; OR &nbsp;&nbsp; Edit&nbsp;
																					<input type="text" id="due_date_new" value="" style="width:80px">
																					<input type="button" id="due_date_btn" value="Submit" />
																			<?php elseif($order->ktr_pending_status == 2):?>
																				&nbsp;&nbsp;&nbsp;&nbsp; (Waiting for admin...)
																			<?php elseif($order->ktr_pending_status == 1):?>
																				&nbsp;&nbsp;&nbsp;&nbsp; (Confirmed)
																			<?php	endif;	?>
																		</td>
																	</tr>
                                                                    <?php if(trim($order->ktr_comment)):?>
                                                                    <tr><td class="dtl_left_td">Comments:</td><td><?php echo $order->ktr_comment;?></td></tr>
                                                                     <?php endif;?>
                                                                    <tr>
                                                                        <td class="dtl_left_td">Original Files:</td>
                                                                        <td>
                                                                            <?php
                                                                            $tableOrderPath=$wpdb->prefix.KTR_ORDERED_FILE_URL_TABLE;
                                                                            $tableOrderInfo=$wpdb->prefix.KTR_ORDER_INFO_TABLE;
                                                                           
                                                                            $sqlFilePath = $wpdb->prepare( "SELECT orp.*,ord.ktr_order_from as u_id FROM 
                                                                                     $tableOrderPath as orp
                                                                                     iNNER JOIN $tableOrderInfo as ord ON ord.ktr_id=orp.ktr_id
                                                                                     where orp.ktr_id = %d ORDER BY ktr_ordf_id desc", $order->ktr_id );
                                                                            $order_fliePath = $wpdb->get_results($sqlFilePath);
                                                                            $i=0;
                                                                            ?>
                                                                            <?php

                                                                            foreach($order_fliePath as $r){
                                                                                
                                                                            ?>

                                                                            <?php
                                                                            $i++;
                                                                            $fileFullpathArray=explode('/',$r->ktr_ordf_url);
                                                                            $filename=end($fileFullpathArray);
                                                                            echo $i.'. <a href="'.site_url().'/wp-content/plugins/kite-file-translate-manage-system/?file='.$filename.'&path='.$r->u_id.'" >'.$filename."</a><br/>";
                                                                            ?>

                                                                            <?php
                                                                            }

                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                    
                                                                
                                                            <tr>
                                                            <?php 
                                                                $current_user=wp_get_current_user();
                                                                $user_name=$current_user->user_login;
                                                                $user_id=$current_user->ID;
                                                                
                                                            ?>
                                                                <?php 
                                                             
                                                                  if($order->ktr_price!=0 && $order->status!=COMPLETE){
                                                                    ?>
                                                                    
                                                                    <td class="dtl_left_td"> Upload</td>
                                                                    <td>
                                                                    <div id="trasnlatorUploader"></div>
                                                                    <ul id="separate-listtrns"></ul>
                                                                    </td>

                                                                </td>
                                                                <?php
                                                                } else{
                                                                ?>
                                                                
                                                                 <?php 
                                                              }?>
                                                               
                                                          
                                                        </tr>
                                                   
                                                        <tr>
                                                            <td></td>
                                                            <td class="ktr_upload_tbl">
                                                                <input type="hidden" name="hid_order_id" id="hid_order_id" value="<?php echo $order->ktr_order_id; ?>"/>
                                                                <input type="submit" value="Submit" id="ktrUpload" name="ktr_translator_upload" class="sndr_col_submit">
                                                            </td>
                                                        </tr>
                                                        
                                                                </table>
                                                            </td>
                                                            <td valign="top">
                                                                <?php
                                                                $tableOrderDtlTrns=$wpdb->prefix.KTR_TRANSLATING_DETAIL_TABLE;
                                                                $tableTrnslatedFile=$wpdb->prefix.KTR_TRANSLATE_FILE_URL_TABLE;
                                                                  $sqlFilePath = $wpdb->prepare( 
                                                                            "SELECT * FROM $tableOrderDtlTrns as dtl
                                                                            Inner Join $tableTrnslatedFile as tf on tf.user_id=dtl.ktr_id 
                                                                            where dtl.ktr_translator_id =".$order->ktr_order_id." and tf.user_id = %d and tf.ktr_id=".$order->ktr_order_id." ORDER BY tf.ktr_trnslt_status asc", $user_id );
                                                                    $translatorUploadFile = $wpdb->get_results($sqlFilePath);
                                                                    $i=0;
                                                                    ?>
                                                                    <table class=" ">
                                                                        <tr>
                                                                            <td valign="top">My Uploaded File(s):</td>
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
																					  }else{     }
                                                                                  }
                                                                                ?>
                                                                        <tr>
                                                                            
                                                                            <td valign="top" class="detail_td">
                                                                                <?php
                                                                                    $i++;
                                                                                    $fileFullpathArray=explode('/',$r->ktr_trnslt_url);
                                                                                    $filename=end($fileFullpathArray);
                                                                                    echo ' <a href="'.site_url().'/wp-content/plugins/kite-file-translate-manage-system/?file='.$filename.'&path='.KTR_TRANSLATED_FILE_DIRECTORY.DS.$userID.'" >'.$filename."</a><br/>";
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
                                                        </tr>

                                                      

                                                    </table>
                                                        </form>
                                  <!--End Detail Translation-->
                                              <?php
                                                }else{
                                                    echo  NOT_FOUND;
                                                }
                                                
                                        }else{
                                            echo ERROR_IN_REQUEST;
                                        }
                                   } ?>
                            </div>

                    </div><!-- #item-body -->
					
					<?php bp_core_load_template( apply_filters( 'bp_ktr_template_ktr_view_tasks', 'ktr/comments' ) ); ?>
					
					
		</div><!-- .padder -->
	</div><!-- #content -->

	<?php locate_template( array( 'sidebar.php' ), true ) ?>

<?php get_footer() ?>
