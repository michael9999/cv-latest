<?php

/***
 * You can hook in ajax functions in WordPress/BuddyPress by using the 'wp_ajax' action.
 * 
 * When you post your ajax call from javascript using jQuery, you can define the action
 * which will determin which function to run in your PHP component code.
 *
 * Here's an ktr:
 *
 * In Javascript we can post an action with some parameters via jQuery:
 * 
 * 			jQuery.post( ajaxurl, {
 *				action: 'my_ktr_action',
 *				'cookie': encodeURIComponent(document.cookie),
 *				'parameter_1': 'some_value'
 *			}, function(response) { ... } );
 *
 * Notice the action 'my_ktr_action', this is the part that will hook into the wp_ajax action.
 * 
 * You will need to add an add_action( 'wp_ajax_my_ktr_action', 'the_function_to_run' ); so that
 * your function will run when this action is fired.
 * 
 * You'll be able to access any of the parameters passed using the $_POST variable.
 *
 * Below is an ktr of the addremove_friend AJAX action in the friends component.
 */

/***
 * NOTE:
 * Try and avoid returning HTML layout in your ajax functions.
 */

function ktr_friends_ajax_addremove_friend_ktr() {
	global $bp;

	if ( 'is_friend' == BP_Friends_Friendship::check_is_friend( $bp->loggedin_user->id, $_POST['fid'] ) ) {

		if ( !friends_remove_friend( $bp->loggedin_user->id, $_POST['fid'] ) ) {
			echo __( 'Friendship could not be canceled.', 'bp-component' );
		} else {
			echo '<a id="friend-' . $_POST['fid'] . '" class="add" rel="add" title="' . __( 'Add Friend', 'bp-component' ) . '" href="' . $bp->loggedin_user->domain . $bp['friends']['slug'] . '/add-friend/' . $_POST['fid'] . '">' . __( 'Add Friend', 'bp-component' ) . '</a>';
		}

	} else if ( 'not_friends' == BP_Friends_Friendship::check_is_friend( $bp->loggedin_user->id, $_POST['fid'] ) ) {

		if ( !friends_add_friend( $bp->loggedin_user->id, $_POST['fid'] ) ) {
			echo __( 'Friendship could not be requested.', 'bp-component');
		} else {
			echo '<a href="' . $bp->loggedin_user->domain . $bp['friends']['slug'] . '" class="requested">' . __( 'Friendship Requested', 'bp-component' ) . '</a>';
		}

	} else {
		echo __( 'Request Pending', 'bp-component' );
	}
	
	return false;
}

function ajax_url_ktr(){
    
    if($_REQUEST['current_action']){
        return  $ajaxUrl=$_REQUEST['current_action'];
    }
}




function ajax_ktr_translator_info(){
     if($_REQUEST['whatever']){
        global $wpdb;
        $table=$wpdb->prefix.KTR_TRANSLATOR_INFO_TABLE;
        $table_user_dtl=$wpdb->prefix.KTR_TRANSLATING_DETAIL_TABLE;
        $table_lang=$wpdb->prefix.KTR_LANGUAGE_TABLE;
        $table_sp=$wpdb->prefix.KTR_TRANSLATOR_SPECIALIZATION_TABLE;
        $wp_user_table=$wpdb->prefix.'users';
         $sql="SELECT * from $table as ktr INNER JOIN $wp_user_table as wp ON wp.ID=ktr.default_user_id where ktr.name='u_login' and default_user_id= ".$_REQUEST['whatever'];
        $get_user=$wpdb->get_row($sql);
        $name=$get_user->user_login;
        $q2=$wpdb->prepare("SELECT * from $table where  default_user_id= %s ", $_REQUEST['whatever']);
        $rs1=$wpdb->get_results($q2);
        if(count($rs1)>0){
            $param='';
          $l_la=1;
           $l_sp=1;
        foreach($rs1 as $param){
            if($param->name=="language"){
				$la_id=$param->value;
				$lang_query=$wpdb->prepare("SELECT * from $table_lang where ktr_laguage_id = %d ", $la_id);
				$language_rs=$wpdb->get_row($lang_query);
				$la.="<span class='ktr_span_ajax'>".$l_la.". ".$language_rs->ktr_trnslt_from.'-'.$language_rs->ktr_trnslt_to."</span>";
				$l_la++;
            }
           if($param->name=="specilization"){
				$sp_id=$param->value;
				$sp_query=$wpdb->prepare("SELECT * from $table_sp where ktr_apecialization_id = %d", $sp_id);
				$sp_rs=$wpdb->get_row($sp_query);
				$sp.="<span class='ktr_span_ajax'>".$l_sp.". ".$sp_rs->ktr_specialization."</span>";
				$l_sp++;
            }
            if($param->name=='status'){
				$status = $param->value;
            }
           if($param->name=='unavailability_period'){
				$unavailability_period = $param->value;
           }
        }
		
		$status = bp_ktr_get_t_status($_REQUEST['whatever']);		
		
        echo $name.'%NAME%'.$la.'%LANGUAGE%'.$sp."%STATUS%".$status;
        }
      die();
    }
}


function ajax_translator_confirm(){
	global $wpdb;
	if($order_id = $_REQUEST['order_id']){
		$wpdb->update( 
			$wpdb->prefix.KTR_TRANSLATING_DETAIL_TABLE, 
			array( 'ktr_pending_status' => PENDING_CONFIRMED ), 
			array( 'ktr_translator_id'  => $order_id ), 
			array( '%d'	), 
			array( '%d' ) 
		);
		
		bp_ktr_set_status($_REQUEST['order_id'], TCONFIRMED);
		
		echo 'Due date confirmed.';
		exit;
	}
}


function ajax_translator_change_due_date(){
	global $wpdb;
	
	//$date = DateTime::createFromFormat('d/m/Y', $_REQUEST['due_date_new']);  
	//$date_db = $date->format('Y-m-d') . ' 00:00:00';
	sscanf($_REQUEST['due_date_new'], "%[^/]/%[^/]/%s", $day, $month, $year);
	$date_db = $year.'-'.$month.'-'.$day;
	
	if($order_id = $_REQUEST['order_id']){
		$wpdb->update( 
			$wpdb->prefix.KTR_TRANSLATING_DETAIL_TABLE, 
			array( 'ktr_due_date' => $date_db, 'ktr_pending_status' => PENDING_WAITING_ADMIN ), 
			array( 'ktr_translator_id'  => $order_id ), 
			array( '%s', '%d'	), 
			array( '%d' ) 
		);
		
		echo 'Due date changed.';
		exit;
	}
}

function ajax_translator_resend_files(){
	global $wpdb;
	
	if( ($order_id = $_REQUEST['order_id']) && ($user_id = $_REQUEST['user_id']) ){
	
		//Translator email
		$user_info  = get_userdata($user_id);
		$user_email = $user_info->user_email ;
		
		//Prepare attachements
		$attachments = array();
		$filesTable  = $wpdb->prefix.KTR_ORDERED_FILE_URL_TABLE;
		$orderTable  = $wpdb->prefix.KTR_ORDER_INFO_TABLE;
		$filesSql    = 	"SELECT f.* FROM {$filesTable} AS f
			 INNER JOIN {$orderTable} as ord ON ord.ktr_id = f.ktr_id
			 WHERE ord.ktr_order_id = %d";
		$rows 		 = $wpdb->get_results($wpdb->prepare( $filesSql, $order_id )); 
		foreach($rows as $r){
			$attachments[]= WP_CONTENT_DIR . str_replace('wp-content','',$r->ktr_ordf_url);
		}
		
		$subject = ' Files for order : '.$order_id. "\r\n";
		$message =  "Resending files for the order: {$order_id}";
		
		$admin_email = get_option( 'ktr-setting-admin_email' );
		$headers = 'From: '. get_bloginfo( $show, 'display' ).'<'.$admin_email.'>' . "\r\n";
		$headers .= 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		wp_mail($user_email , $subject, $message , $headers, $attachments);
		
		echo 'Files are resent.';
		exit;
	}
	
	/*
		See "if(isset($_REQUEST['assign_translator']))" in bp-ktr-admin.php
		Also related to .resend-files-btn in  bp-ktr-admin.php
	*/
}





function ajax_admin_file_remove(){
	global $wpdb;
	if($file_id = $_REQUEST['file_id']){
				
		$tableTrnslatedFile=$wpdb->prefix.KTR_TRANSLATE_FILE_URL_TABLE;
		$wpdb->query("
			DELETE FROM {$tableTrnslatedFile} 
			WHERE ktr_trnslt_id = '{$file_id}'
			LIMIT 1"
		);
		
		echo 'File removed.';
		exit;
	}
}


function ajax_admin_file_replace(){
	global $wpdb;
	
	$old_file_id = $_REQUEST['old_file_id'];
	$src_dir_path = '../'.TEMP_DIR.DS.  session_id();
	$src_dir = opendir($src_dir_path);

	clearstatcache();
	
	$latest_ctime = 0;
	$latest_filename = '';  
	while(false !== ( $src_file = readdir($src_dir)) ) {         
		$filepath = $src_dir_path . '/' . $src_file;
 
		if (is_file($filepath) && filectime($filepath) > $latest_ctime) {
			  $latest_ctime = filectime($filepath);
			  $latest_filename = $src_file;
			  
		}		          
             
    }  
    
	if($latest_filename){ 
		$filesTable  = $wpdb->prefix.KTR_TRANSLATE_FILE_URL_TABLE; 
		$filesResult = $wpdb->get_row("SELECT * FROM $filesTable WHERE ktr_trnslt_id = {$old_file_id} LIMIT 1");
		
		rename($src_dir_path . '/' . $latest_filename, '../'.$filesResult->ktr_trnslt_url);
		//unlink($src_dir_path . '/' . $latest_filename);
		echo 'File replaced.';		
	}else{
		echo 'Error! Please refresh the page and try again.';	
	}
	exit;
}


function ajax_admin_comment_remove(){
	global $wpdb;
	if($comment_id = $_REQUEST['comment_id']){
				
		$commentsTable = $wpdb->prefix.KTR_COMMENTS_TABLE;
		$wpdb->query("
			DELETE FROM {$commentsTable} 
			WHERE id = '{$comment_id}'
			LIMIT 1");
		
		echo 'Comment removed.';
		exit;
	}
}

function ajax_admin_comment_approve(){
	global $wpdb; 
	
	if($comment_id = $_REQUEST['comment_id']){
		$wpdb->update( 
			$wpdb->prefix.KTR_COMMENTS_TABLE, 
			array( 'approved' => 1 ), 
			array( 'id'  => $comment_id )
		);
				
		bp_ktr_comment_email($comment_id);  //Send email to users involved
		
		echo 'Comment approved.';
		exit;
	}
}

function ajax_admin_mark_complete(){
	global $wpdb;
	if($order_id = $_REQUEST['order_id']){
		$wpdb->update( 
			$wpdb->prefix.KTR_ORDER_INFO_TABLE, 
			array( 'status' => 1 ), 
			array( 'ktr_id'  => $order_id )
		);
		
		echo 'Order market complete.';
		exit;
	}
}


function ajax_admin_change_order_status(){
	global $wpdb;
	//print_r($_REQUEST);
	if(($order_id = $_REQUEST['order_id']) && ($status = $_REQUEST['status'])){
		$wpdb->update( 
			$wpdb->prefix.KTR_ORDER_INFO_TABLE, 
			array( 'status' => $status ), 
			array( 'ktr_order_id'  => $order_id )
		);
		echo 'Order status changed.';
		exit;
	}
}

add_action( 'wp_ajax_widget_r', 'ajax_ktr_translator_info' );
add_action( 'wp_ajax_nopriv_widget_r', 'ajax_ktr_translator_info' );

//add_action( 'wp_ajax_addremove_friend_ktr', 'friends_ajax_addremove_friend_ktr' );
add_action( 'wp_ajax_my_ktr_action', 'ajax_ktr_translator_info' );

add_action( 'wp_ajax_translator_confirm', 'ajax_translator_confirm' );
add_action( 'wp_ajax_translator_change_due_date', 'ajax_translator_change_due_date' );
add_action( 'wp_ajax_translator_resend_files', 'ajax_translator_resend_files' );

add_action( 'wp_ajax_admin_file_remove', 'ajax_admin_file_remove' );
add_action( 'wp_ajax_admin_file_replace', 'ajax_admin_file_replace' );
add_action( 'wp_ajax_admin_comment_remove',  'ajax_admin_comment_remove' );
add_action( 'wp_ajax_admin_comment_approve', 'ajax_admin_comment_approve' );
add_action( 'wp_ajax_admin_mark_complete', 'ajax_admin_mark_complete' );
add_action( 'wp_ajax_admin_change_order_status', 'ajax_admin_change_order_status' );



?>