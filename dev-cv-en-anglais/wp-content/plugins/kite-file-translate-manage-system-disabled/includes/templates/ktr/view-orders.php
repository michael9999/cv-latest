<?php get_header() ?>

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
                                    <?php 
                                         global $wpdb;
                                        global $bp;
                                      
                                        if ( isset( $_POST['submit'] ) && check_admin_referer('ktr-order-price')&&1==2 ) {
                                            $table=$wpdb->prefix.KTR_ORDER_INFO_TABLE;
                                            $wpdb->query(
                                                        "
                                                        UPDATE $table 
                                                        SET ktr_price =".$_POST['ord_prc'] .",
                                                            status =".AWATING_CLIENT_ACCEPTANCE ."
                                                        WHERE ktr_order_id = ".$_POST['order_id'] ."
                                                                
                                                        "
                                                );
                                                $sql = $wpdb->prepare( "SELECT * FROM $table where ktr_order_id = %d ORDER BY ktr_id desc", $_REQUEST['order-id'] );
                                                $order = $wpdb->get_row($sql);
                                                $user_id=$order->ktr_order_from;
                                                $user_info = get_userdata($user_id);
                                                $user_name=$user_info->user_login;
                                                $user_email=$user_info->user_email ;
                                                $headers = 'From: '. get_bloginfo( $show, 'display' ).' <noreply@mydomain.com>' . "\r\n";
                                                $subject='You have successfully register'. "\r\n";
                                                $message='<p><b>Dear '.$user_name.',</b></p><p>Your order qoutation is updated.</p><p>Your Order ID:<b>'.$_REQUEST['order_id'].'</b>
                                                <br/><p>Price:<b>'.$_POST['ord_prc'].'</b></p><p>Thank you for stay with us.</p>';
                                                add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
                                                wp_mail($ktr_sender_email , $subject,$message , $headers);
                                                $_SESSION['update']='true';
                                               // echo "<script type='text/javascript'>window.location='". $bp->loggedin_user->domain .$bp->ktr->slug .'/'.$bp->current_action."';</script>";
                                    }
                                    
                                    ?>
				<h4> <?php global $bp;   ( $bp->current_component == $bp->ktr->slug && 'view-orders' == $bp->current_action && $bp->action_variables[0]=="" )? _e( 'My Orders ', 'bp-ktr' ): _e( "Order Detail For Order ID: ".$bp->action_variables[0], 'bp-ktr' ) ?></h4>
                                
                                <?php  global $bp; if ( $bp->current_component == $bp->ktr->slug && 'view-orders' == $bp->current_action && $bp->action_variables[0]=="" ) {?>
                                    <?php
                                        global $wpdb;
                                        global $bp;
                                        $dtl_link = $bp->loggedin_user->domain . $bp->current_component.'/'.$bp->current_action.'/';
                                        $current_user=wp_get_current_user();
                                        $userID=$current_user->ID;
                                        $user_name=$current_user->user_login;
										
                                        $table =$wpdb->prefix.KTR_ORDER_INFO_TABLE;
                                        $table2=$wpdb->prefix.KTR_TRANSLATING_DETAIL_TABLE;
                                        $sql = $wpdb->prepare( "SELECT t1.*, t2.ktr_due_date FROM $table AS t1
											LEFT JOIN $table2 AS t2 ON t1.ktr_order_id = t2.ktr_translator_id
											WHERE t1.ktr_order_from = %d
											ORDER BY t1.ktr_id desc", $userID );
                                        $order = $wpdb->get_results( $sql );
  //print_r($order);      

                                    ?>
                                   <?php if ( $_SESSION['update']== 'true') : ?><?php echo "<div id='message' class='updated fade'><p>" . __( 'Updated.', 'bp-ktr' ) . "</p></div>" ?><?php $_SESSION['update']=''; endif; ?>
                                   <?php if ( $_REQUEST['st']== 'Completed') : ?><?php echo "<div id='message' class='updated fade'><p>" . __( 'Your payment is received by paypal.', 'bp-ktr' ) . "</p></div>" ?><?php $_SESSION['update']=''; endif; ?>
                                    <?php if(count($order)>0): ?>
                                    <style>
										#content table { border:0; }
										#content tr{ border-bottom:0; }
										#content tr td{ border-top:0; }
									</style>
									<table class="form-table-list ffs_flat_list">
                                        <tr valign="top">
                                            <th scope="row"><label for="target_uri"><?php _e( 'Order No', 'bp-ktr' ) ?></label></th>
                                            <th scope="row"><label for="target_uri"><?php _e( 'Delivery Date', 'bp-ktr' ) ?></label></th>
                                           
                                            <th scope="row"><label for="target_uri"><?php _e( 'Language', 'bp-ktr' ) ?></label></th>
                                            <th scope="row"><label for="target_uri"><?php _e( 'Status', 'bp-ktr' ) ?></label></th>
                                        </tr>
                                        <?php foreach($order as $r): 
                                            $i=$r->ktr_language;
                                            $order_id=$r->ktr_order_id;
											
											$date = '';
											if($r->ktr_due_date){
												$dateTime=explode(" ",$r->ktr_due_date);
												$dateArray=explode('-',$dateTime['0']) ;
												$dateAll=mktime(0,0,0,date($dateArray[1]),date($dateArray[2]),date($dateArray[0]));
												$date= date("d M Y",$dateAll);
											}
                                            $language=$r->ktr_language;
                                            $u_name=$current_user->user_login;
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
                                                         $status=ucfirst(strtolower("AWATING QUOTE"));
                                                    }elseif($r->status==AWATING_CLIENT_ACCEPTANCE){
                                                        $status=sentence_case("AWATING  CLIENT ACCEPTANCE");
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
                                        ?>
                                        <tr>
                                            <td><a href="<?php echo $dtl_link.$order_id;?>"><?php echo $order_id; ?></a></td>
                                            <td><?php echo $date; ?></td>
                                           
                                            <td><?php echo $language; ?></td>
                                            <td><?php echo $status; ?></td>
                                        </tr>
                                        <?php  endforeach;?>
                                    </table>
                                <?php else: ?>
                                <div>No data found.</div>
                                <?php endif; ?>
                              <?php 
                            
                                }elseif ( $bp->current_component == $bp->ktr->slug && 'view-orders' == $bp->current_action && $bp->action_variables[0]!="" ) {
                                     global $wpdb;
                                     global $bp;
                                     
                                            
                                        if(is_numeric($bp->action_variables[0])){
                                                $dtl_link = $bp->loggedin_user->domain . $bp->current_component.'/'.$bp->current_action.'/';
                                                $current_user=wp_get_current_user();
                                                $userID=$current_user->ID;
                                                $table1 = $wpdb->prefix.KTR_ORDER_INFO_TABLE;
                                                $table2 = $wpdb->prefix.KTR_TRANSLATING_DETAIL_TABLE;
                                                $sql = $wpdb->prepare( "SELECT t1.*, t2.ktr_due_date FROM $table1 AS t1
													LEFT JOIN $table2 AS t2 ON t2.ktr_translator_id = t1.ktr_order_id
													WHERE t1.ktr_order_id = %d 
													ORDER BY t1.ktr_id desc", $bp->action_variables[0] );
                                                $order = $wpdb->get_row($sql);
                                                if($order->ktr_order_id == $bp->action_variables[0]){
                                                    $languagePrice= get_option("ktr-setting-language-price");
                                                    
                                                    $language=$order->ktr_language;
                                                    $user_msg=$order->ktr_message;
													
                                                    $dateTime=explode(" ",$order->ktr_order_date);
													$dateArray=explode('-',$dateTime['0']) ;
                                                    $dateAll=mktime(0,0,0,date($dateArray[1]),date($dateArray[2]),date($dateArray[0]));
                                                    $date= date("d M Y",$dateAll);
													
													if($order->ktr_due_date){
														$dateTime2    = explode(" ",$order->ktr_due_date);
														$dateArray2   = explode('-',$dateTime2['0']) ;
														$dateAll2     = mktime(0,0,0,date($dateArray2[1]),date($dateArray2[2]),date($dateArray2[0]));
														$dateDue      = date("d M Y",$dateAll2);
													}else{ $dateDue = "N/A"; }
													
                                                    $laguage_array=explode(" ",$language);
                                                    $sql2=$sql3=$sql4="";
                                                    $sql2 = $wpdb->prepare( "SELECT ktr_file_type_id FROM ".$wpdb->prefix.KTR_FILE_TYPE_TABLE." where ktr_file_type='".$order->ktr_file_type."'", '' );
                                                    $type_id = $wpdb->get_row($sql2)->ktr_file_type_id;
                                                    $sql3 = $wpdb->prepare( "SELECT ktr_laguage_id FROM ".$wpdb->prefix.KTR_LANGUAGE_TABLE." where ktr_trnslt_from='".$laguage_array[0]."' and ktr_trnslt_to='".$laguage_array[2]."'", '');
                                                    $language_id = $wpdb->get_row($sql3)->ktr_laguage_id;
                                                    if($type_id && $language_id){
                                                    $sql4 = $wpdb->prepare( "SELECT ktr_type_base_price FROM ".$wpdb->prefix.KTR_TYPE_BASE_PRICE_TABLE." where ktr_type_language='".$language_id."' and ktr_type='".$type_id."'", '');
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
                                                     
                                                    ?>
                                                    <form action="" name="ktr-order-settings-price" id="ktr-settings-form" method="post">

                                                    <table class="form-table-list">
                                                        <tr>
                                                            <td valign="top">
                                                                <table>
                                                                    <tr><td valign="top" class="dtl_left_td">Order No: </td><td><?php echo $order->ktr_order_id;?></td></tr>
                                                                    <tr><td valign="top" class="dtl_left_td">Date:</td><td><?php echo $date;?></td></tr>
                                                                    <tr><td valign="top" class="dtl_left_td">Delivery Date:</td><td><?php echo $dateDue;?></td></tr>
                                                                    <tr><td class="dtl_left_td">Status:</td><td><?php echo $status;?></td></tr>
                                                                    <tr><td class="dtl_left_td">Type:</td><td><?php echo $order->ktr_file_type;?></td></tr>
                                                                    <tr><td class="dtl_left_td">Language:</td><td><?php echo $language; ?></td></tr>
                                                                    <tr><td class="dtl_left_td">Number Of Words:</td>
                                                                        <td><?php echo $order->ktr_order_number; ?>
                                                                            <input type="hidden" name="word_number" id="word_number" value="<?php echo $order->ktr_order_number;  ?>" />
                                                                            <input type="hidden" name="word_price" id="word_price" value="<?php echo $price_per_word;  ?>" />
                                                                            <input type="hidden" name="order_id" id="order_id" value="<?php echo $order->ktr_order_id;  ?>" />
                                                                        </td></tr>
                                                                    <tr><td class="dtl_left_td">Number Of Page:</td><td><?php echo $order->ktr_page_number; ?></td></tr>
                                                                                                                            <tr>
                                                            <?php 
                                                                $current_user=wp_get_current_user();
                                                                $user_name=$current_user->user_login;
                                                                
                                                            ?>
                                                                <?php 
                                                             
                                                                  if($order->ktr_price!=0 && $order->status==AWATING_CLIENT_ACCEPTANCE){
                                                                    ?>
                                                                    <td class="dtl_left_td">Price:  </td><td><?php echo $currency_symbol; ?><?php echo $order->ktr_price; ?> Not Paid Yet  &nbsp;
                                                                        <!--<a href='javascript:void(0);'onClick="document.payform.submit()" title="Make payments with PayPal - it's fast, free and secure!" ><span class="dtl_left_td"> Pay Now </span></a>-->
<!--<a href="https://www.sandbox.paypal.com/cgi-bin/webscr?business=kitewe_1314369053_biz@gmail.com&cmd=_xclick&currency_code=USD&amount=100&quantity=2&item_name=test-description&discount_amount=10&item_number=10051&notify_url=http://sandbox.kiteweb.net/translator/wp-content/plugins/kite-file-translate-manage-system/ipn/listener.php&&return=<?php echo $bp->loggedin_user->domain . $bp->current_component ?>/view-orders/&cancel_return=<?php echo $bp->loggedin_user->domain . $bp->current_component ?>/view-orders/">Pay Now</a>-->
<?php

$item_name = 'Translation '.$order->ktr_language;
//$business_email = 'wander_1339262690_biz@gmail.com';
$business_email = get_option('ktr-setting-paypal_email');
$return = $bp->loggedin_user->domain . $bp->current_component . '/paypal-success/';

echo '<a href="https://www.paypal.com/cgi-bin/webscr?business='.$business_email.'&cmd=_xclick&currency_code='. $currency_code.'&amount='. $order->ktr_price.'&quantity=1&item_name='.$item_name.'&discount_amount=10&item_number='.$order->ktr_order_id.'&notify_url='. site_url().'/wp-content/plugins/kite-file-translate-manage-system/ipn/listener.php&return='. $return . '&cancel_return='.$bp->loggedin_user->domain . $bp->current_component . '/view-orders/">Pay Now</a>'
        
  ?>
                                                                
                                                                </td>
                                                                <?php
                                                                } elseif($order->status==AWATING_QUOTE){
                                                                ?>
                                                                <td class="dtl_left_td">Price: </td><td> Not Quote Yet  </td>
                                                                 <?php 
                                                                }else{
                                                                ?>
                                                                <td class="dtl_left_td">Price: </td><td><?php echo $currency_symbol; ?><?php echo $order->ktr_price;?> </td>
                                                                <?php }?>
                                                               
                                                          
                                                        </tr>
                                                        <?php if($user_msg): ?>
                                                        <tr><td class="dtl_left_td">Message:</td><td><?php echo $user_msg; ?></td></tr>
                                                        <?php endif;?>
                                                        
                                                                </table>
                                                            </td>
                                                            <td valign="top">
                                                                <?php
																	$tableOrderPath=$wpdb->prefix.KTR_ORDERED_FILE_URL_TABLE;
																	$sqlFilePath = $wpdb->prepare( "SELECT * FROM $tableOrderPath where ktr_id=".$order->ktr_id." ORDER BY ktr_ordf_id desc", '' );
																	$order_fliePath = $wpdb->get_results($sqlFilePath);
																	$i=0;
																?>
																<table class="form-table-list ">
																	<tr>
																		<td valign="top">Uploaded File(s):</td>
																	</tr>
																	
																	<?php 																
																	foreach($order_fliePath as $r):
																	?>
																	<tr>                                                                            
																		<td valign="top" class="detail_td">
																			<?php
																			$i++;
																			$fileFullpathArray=explode('/',$r->ktr_ordf_url);
																			$filename=end($fileFullpathArray);
																			echo $i.'. <a href="'.site_url().'/wp-content/plugins/kite-file-translate-manage-system/?file='.$filename.'&path='.$userID.'" >'.$filename."</a><br/>";
																			?>
																		 </td>
																	</tr>
																	<?php
																	endforeach;
																	?>
																	<tr>
																		<td valign="top"><br /><br /></td>
																	</tr>
																</table>
                                                                
																<?php
																	$tableTranslated=$wpdb->prefix.KTR_TRANSLATE_FILE_URL_TABLE;
																	$sqlTranslated = $wpdb->prepare( "SELECT * FROM $tableTranslated WHERE ktr_id=".$order->ktr_order_id." AND for_client = 1", '' );
																	$translatedResult = $wpdb->get_results($sqlTranslated); 
																	$i=0;
																?>
																<table class="form-table-list ">
																	<tr>
																		<td valign="top">Translated File(s):</td>
																	</tr>
																	
																	<?php 																
																	foreach($translatedResult as $r):
																	?>
																	<tr>                                                                            
																		<td valign="top" class="detail_td">
																			<?php
																			$i++;
																			$fileFullpathArray=explode('/',$r->ktr_trnslt_url);
																			$filename=end($fileFullpathArray);
																			echo $i.'. <a href="'.site_url().'/wp-content/plugins/kite-file-translate-manage-system/?file='.$filename.'&path='.KTR_TRANSLATED_FILE_DIRECTORY.DS.$r->user_id.'" >'.$filename."</a><br/>";
																			?>
																		 </td>
																	</tr>
																	<?php
																	endforeach;
																	?>
																	<tr>
																		<td valign="top"><br /><br /></td>
																	</tr>
																</table>
                                                            </td>
                                                        </tr>

                                                        <?php if($user_name=="admin"&&($order->status==AWATING_CLIENT_ACCEPTANCE || $order->status==AWATING_QUOTE)):?>
                                                       
                                                      <?php endif; ?>

                                                    </table>
                                                        </form>
                                                        <form name="payform" id="payform" action="https://www.paypal.com/cgi-bin/webscr" method="post" accept-charset="utf-8">
                                                        <p>
                                                        <input type="hidden" name="cmd" value="_xclick" />
                                                        <input type="hidden" name="charset" value="utf-8" />
                                                        <input type="hidden" name="business" value="<?php echo get_option('ktr-setting-paypal_email')?>" />
                                                        <input type="hidden" name="item_name" value="Translator" />
                                                        <input type="hidden" name="item_number" value="<?php echo $order->ktr_order_id;?>" />
                                                        <input type="hidden" name="amount" value="<?php echo $order->ktr_price; ?>" />
                                                        <input type="hidden" name="test_ipn" value="1" />
                                                        <input type="hidden" name="currency_code" value="<?php echo $currency_code;?>" />
                                                        <input type="hidden" name="return" value="<?php echo $bp->loggedin_user->domain . $bp->current_component . '/view-orders/';?>" />
                                                        <input type="hidden" name="cancel_return" value="<?php echo $bp->loggedin_user->domain . $bp->current_component . '/view-orders/';?>" />
                                                        <input type="hidden" name="bn" value="Business_BuyNow_WPS_SE" />

                                                        </p>
                                                        </form>
                                                    <?php
                                                }else{
                                                    echo  NOT_FOUND;
                                                }
                                                
                                        }else{
                                            echo ERROR_IN_REQUEST;
                                        }
                                    }
                                              
                                
                            ?>
				
			</div><!-- #item-body -->

			<?php bp_core_load_template( apply_filters( 'bp_ktr_template_ktr_view_tasks', 'ktr/comments' ) ); ?>
			
		</div><!-- .padder -->
	</div><!-- #content -->

	<?php locate_template( array( 'sidebar.php' ), true ) ?>

<?php get_footer() ?>