<?php

error_reporting(0); 
if(!isset($_SESSION))
{
	session_start();
        
}

//Add 'network' to paths when the plugin is running in multi-site
if ( is_multisite() ) $mu_path_x = 'network/';
else $mu_path_x = '';


define('DS', '/');//Directory Separator
define('PLUGIN_NAME','kite-file-translate-manage-system'); //plugins name
define("KTR_ROOT_DIRECTORY",'kite-file-translate-manage-system');
define("KTR_TRANSLATED_FILE_DIRECTORY",'kite-translators_files');
define("KTR_ORDER_INFO_TABLE",'ktr_translating_info');
define("KTR_ORDERED_FILE_URL_TABLE",'ktr_order_file_url');
define("KTR_TRANSLATE_FILE_URL_TABLE",'ktr_translated_file');
define("KTR_LANGUAGE_TABLE",'ktr_language');
define("KTR_FILE_TYPE_TABLE",'ktr_file_type');
define("KTR_TYPE_BASE_PRICE_TABLE",'ktr_type_base_price');


/**
 * 
 */
define('KTR_TRANSLATOR_INFO_TABLE','ktr_translator_info');
define('KTR_TRANSLATING_DETAIL_TABLE','ktr_translating_details');
define('KTR_TRANSLATOR_SPECIALIZATION_TABLE','ktr_translator_specialization');
define("KTR_EMAILS_TABLE", 'ktr_emails');
define("KTR_COMMENTS_TABLE",'ktr_comments');

define("ADMIN_CAP",'access_s2member_ccap_translator');

/**
 * Constructor for status
 */
define('COMPLETE',1);
define('QUERY',2);
define('PENDING',3); 
define('TCONFIRMED',33); //Translator confirmed the assignment (that he can do the translation within for the delivery date )
define('TRANSLATED',35); //Document received from translator
define('TSENT',37); //Ready document sent to client
define('ACCEPTED',4);
define('PAYMENT_RECEIVED',5);
define('AWATING_CLIENT_ACCEPTANCE',6);
define('AWATING_QUOTE',7);
define('START_ORDER',10000);
define('ERROR_IN_REQUEST','The is some thing wrong in your request .Please Contact with us');
define('NOT_FOUND','This data is not found in our database ');

//Pendidng statusses. Order is assigned to translator
define('PENDING_WAITING_TRANSLATOR',3); //Waiting for due date confirmation from translator
define('PENDING_WAITING_ADMIN',2); //Translator didn't confirm, but changed due date
define('PENDING_CONFIRMED',1); //Translator confimed. OR admin confirmed translator's change

/**
 * Temporary directory for file upload path
 */
define('TEMP_DIR', 'wp-content/plugins/'.PLUGIN_NAME.DS."valums-file-uploader/server/uploads");

/**
 * Destination directory  of tmporary upload file
 */
 
define('DEST_DIR', $upload_dir['basedir'].DS.KTR_ROOT_DIRECTORY.DS);
define('TRNS_DEST_DIR', $upload_dir['basedir'].DS.KTR_ROOT_DIRECTORY.DS.KTR_TRANSLATED_FILE_DIRECTORY.DS);

if(!is_dir ('wp-content/uploads')){
            $oldumask = umask(0);
           @ mkdir('wp-content/uploads', 0777);
            if(!is_dir ('wp-content/uploads/'.KTR_ROOT_DIRECTORY)){
            @mkdir('wp-content/uploads/'.KTR_ROOT_DIRECTORY, 0777); // or even 01777 so you get the sticky bit set
                }
            umask($oldumask);
    }
    if(!is_dir ('wp-content/uploads'.DS.KTR_ROOT_DIRECTORY.DS.KTR_TRANSLATED_FILE_DIRECTORY)){
            $oldumask = umask(0);
            @mkdir('wp-content/uploads/'.DS.KTR_ROOT_DIRECTORY.DS.KTR_TRANSLATED_FILE_DIRECTORY, 0777); // or even 01777 so you get the sticky bit set
            umask($oldumask);
    }
include('lib/pager.php');



    if($_REQUEST['ktr_translator_upload']){
         $_SESSION['insert_error_msg']="";
         global $wpdb;
         global $bp;
         $current_user=wp_get_current_user();
         $userID=$current_user->ID;
         $dir=TEMP_DIR.DS.  session_id();
        if(!is_dir ('wp-content/uploads'.DS.KTR_ROOT_DIRECTORY.DS.KTR_TRANSLATED_FILE_DIRECTORY.DS.$userID)){
            $oldumask = umask(0);
            mkdir('wp-content/uploads'.DS.KTR_ROOT_DIRECTORY.DS.KTR_TRANSLATED_FILE_DIRECTORY.DS.$userID, 0777); // or even 01777 so you get the sticky bit set
            umask($oldumask);
        }
            
            $ktr_id=$_REQUEST['hid_order_id'];
            $version2=get_uploaded_version($ktr_id);
         
        if( !recurse_copy(TEMP_DIR.DS.  session_id(),'wp-content/uploads'.DS.KTR_ROOT_DIRECTORY.DS.KTR_TRANSLATED_FILE_DIRECTORY.DS.$userID,$ktr_id,$version2)){
                $_SESSION['insert_error_msg']="Please Select file.";
              
            ?>
            
            <?php
              
           }else{
            $order_id= $ktr_id;
			
			//Update status to TRANSLATED
			bp_ktr_set_status($order_id, TRANSLATED);			
               
            $admin_email = get_option( 'ktr-setting-admin_email' );
            $user_name=$current_user->user_login;
            //$headers = 'From: '. get_bloginfo( $show, 'display' ).'<'.$admin_email.'>';
            $headers = 'From: '. get_bloginfo( $show, 'display' ).' <'.$admin_email.'>' . "\r\n"  .'X-Mailer: PHP/' . phpversion();
            $headers .= 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $subject='A new translated file has uploaded'. "\r\n";            
			
			$message = bp_ktr_get_email('admin_translation_uploaded', 'salutation');
            $message .='<p><b>'.$user_name.'</b> have Upload an translation.</p><p>Order ID:<b>'.$order_id.'</b>';
			$message .= bp_ktr_get_email('admin_translation_uploaded', 'footer');
			
            add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
            wp_mail($admin_email , $subject,$message , $headers);
            $_SESSION['msg']="Succesfully uploaded";
             
            
           }
            
        }


    global $pluginsStyleUrl;
    global $pluginsImagesUrl;
    global $pluginsJsUrl;
    $pluginsStyleUrl=plugins_url('/'.PLUGIN_NAME.'/style/');
    $pluginsImagesUrl=plugins_url('/'.PLUGIN_NAME.'/images/');
    $pluginsJsUrl=plugins_url('/'.PLUGIN_NAME.'/js/');


	
	
	
	
	
	
	
	
	

   
      
 // add_action('init','ktr_tables_create');
    function ktr_tables_create(){
            create_translating_info_table();
            create_ktr_order_file_url();
            create_ktr_translated_file();
            create_ktr_language_table();
            create_ktr_file_type_table();
            create_ktr_type_base_price_table();
            create_ktr_translator_info_table();
            create_ktr_translating_detail_table();
            create_ktr_translator_specialization_table();
            
			create_ktr_comments_table();
            create_ktr_emails_table();
    }
    
     create_ktr_translated_file();
 
    function create_translating_info_table(){
        global $wpdb;

       $ktr_info_table_name = $wpdb->prefix . KTR_ORDER_INFO_TABLE;
      $ktr_info_table_name_sql="CREATE TABLE IF NOT EXISTS " . $ktr_info_table_name . " (
                                ktr_id  INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                                ktr_order_id INT NOT NULL ,
                                ktr_order_number INT NOT NULL ,
                                ktr_page_number INT NOT NULL ,
                                ktr_file_type VARCHAR( 200 ) NOT NULL ,
                                ktr_language VARCHAR( 100 ) NOT NULL ,
                                ktr_message VARCHAR( 600 ) NOT NULL ,
                                ktr_order_from INT NOT NULL ,
                                ktr_order_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                ktr_complete_by INT NOT NULL ,
                                ktr_complete_date DATE NOT NULL,
                                ktr_price DECIMAL ( 11, 2 ) NOT NULL,
                                ktr_currency_code VARCHAR( 15 ) NOT NULL ,
                                status INT NOT NULL
                                ) ENGINE = MYISAM ";
     

         require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($ktr_info_table_name_sql);
    }

    function create_ktr_order_file_url(){
      global $wpdb;

       $ktr_order_file_name = $wpdb->prefix . KTR_ORDERED_FILE_URL_TABLE;

      $create_order_path_table_sql = "CREATE TABLE IF NOT EXISTS " . $ktr_order_file_name . " (
                                ktr_ordf_id  INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                                ktr_ordf_url  VARCHAR( 800 ) NOT NULL ,
                                ktr_id  INT NOT NULL
                                
                                ) ENGINE = MYISAM ";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta( $create_order_path_table_sql );
    }
    function create_ktr_translated_file(){
      global $wpdb;

       $translated_file_path_table = $wpdb->prefix . KTR_TRANSLATE_FILE_URL_TABLE;

     $translated_path_table_sql = "CREATE TABLE IF NOT EXISTS " . $translated_file_path_table . " (
                                ktr_trnslt_id  INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                                ktr_trnslt_url  VARCHAR( 800 ) NOT NULL ,
                                ktr_id   INT NOT NULL,
                                ktr_uploaded_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                ktr_trnslt_status INT NOT NULL,
                                user_id INT NOT NULL,
                                for_client tinyint(1) NOT NULL
                                ) ENGINE = MYISAM ";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta( $translated_path_table_sql );
    }
    
    function create_ktr_language_table(){
            global $wpdb;
            $table = $wpdb->prefix . KTR_LANGUAGE_TABLE;
           $table_sql = "CREATE TABLE IF NOT EXISTS " . $table . " (
                            ktr_laguage_id  INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                            ktr_trnslt_from  VARCHAR( 200 ) NOT NULL ,
                            ktr_trnslt_to  VARCHAR( 200 ) NOT NULL ,
                            ktr_price_per_word   DECIMAL ( 11, 2 ) NOT NULL,
                            ktr_language_create TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
							auto_send tinyint(4) NOT NULL,
						    default_translator int(11) NOT NULL
                            ) ENGINE = MYISAM ";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

            dbDelta( $table_sql );
    }
    
    
        function create_ktr_file_type_table(){
            global $wpdb;
            $table = $wpdb->prefix . KTR_FILE_TYPE_TABLE;
            $table_sql = "CREATE TABLE IF NOT EXISTS " . $table . " (
                            ktr_file_type_id  INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                            ktr_file_type  VARCHAR( 200 ) NOT NULL 
                            ) ENGINE = MYISAM ";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

            dbDelta( $table_sql );
    }
   function create_ktr_translator_specialization_table(){
            global $wpdb;
            $table = $wpdb->prefix .KTR_TRANSLATOR_SPECIALIZATION_TABLE;
            $table_sql = "CREATE TABLE IF NOT EXISTS " . $table . " (
                            ktr_apecialization_id  INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                            ktr_specialization  VARCHAR( 200 ) NOT NULL 
                            ) ENGINE = MYISAM ";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

            dbDelta( $table_sql );
    }
    
    
            function create_ktr_type_base_price_table(){
            global $wpdb;
            $table = $wpdb->prefix . KTR_TYPE_BASE_PRICE_TABLE;
            $table_sql = "CREATE TABLE IF NOT EXISTS " . $table . " (
                            ktr_type_base_price_id  INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                            ktr_type_language  INT NOT NULL ,
                            ktr_type INT NOT NULL ,
                            ktr_type_base_price   DECIMAL ( 11, 2 ) NOT NULL
                            
                            ) ENGINE = MYISAM ";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

            dbDelta( $table_sql );
    }
    
       function create_ktr_translator_info_table(){
            global $wpdb;
            $table = $wpdb->prefix . KTR_TRANSLATOR_INFO_TABLE;
            $table_sql = "CREATE TABLE IF NOT EXISTS " . $table . " (
                            ktr_u_id  INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                            default_user_id  INT NOT NULL ,
                            name VARCHAR(100) ,
                            value   VARCHAR(100)
                            
                            ) ENGINE = MYISAM ";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

            dbDelta( $table_sql );
    }
   
    function create_ktr_translating_detail_table(){
        global $wpdb;
        $table = $wpdb->prefix . KTR_TRANSLATING_DETAIL_TABLE;
        $table_sql = "CREATE TABLE IF NOT EXISTS " . $table . " (
                        ktr_detail_id  INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                        ktr_translator_id  INT NOT NULL ,
                        ktr_id INT NOT NULL ,
                        ktr_comment VARCHAR(250) ,
                        ktr_assign_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, 
                        ktr_due_date DATETIME NOT NULL,
                        ktr_pending_status tinyint(1) NOT NULL

                        ) ENGINE = MYISAM ";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta( $table_sql );
    }
	
	function create_ktr_comments_table(){
		global $wpdb;
        $table = $wpdb->prefix . KTR_COMMENTS_TABLE;
        $table_sql = "CREATE TABLE IF NOT EXISTS " . $table . " (
			  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			  order_id int(11) NOT NULL,
			  sender_id int(11) NOT NULL,
			  comment text NOT NULL,
			  date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  approved tinyint(1) NOT NULL
			) ENGINE = MYISAM ";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta( $table_sql );
	}
	
	function create_ktr_emails_table(){
		global $wpdb;
        $table = $wpdb->prefix . KTR_EMAILS_TABLE;
        $table_sql = "CREATE TABLE IF NOT EXISTS " . $table . " (
			  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			  name varchar(200) NOT NULL,
			  title varchar(200) NOT NULL,
			  salutation varchar(200) NOT NULL,
			  footer varchar(250) NOT NULL
			) ENGINE = MYISAM; ";
		
		$table_sql .= " 
		INSERT INTO " . $table . " (id, name, title, salutation, footer) VALUES
		(1, 'admin_new_order', 'New Order (Admin)', '', ''),
		(2, 'client_new_order', 'New Order (Client)', '', ''),
		(3, 'admin_payment_received', 'Payment Received (Admin)', '', ''),
		(4, 'client_payment_received', 'Payment Received (Client)', '', ''),
		(5, 'translator_order_assigned', 'Task assigned and document(s) sent (Translator)', '', ''),
		(6, 'admin_translation_uploaded', 'Document(s) returned by translator (Admin)', '', ''),
		(7, 'client_translation_ready', 'Translation ready (Client)', '', ''); ";
		
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta( $table_sql );
	}
	
	

    function ktr_plugin_install() {
        ktr_tables_create();
		
		//Add "translator" capabality (false). With this capability any user can be admin(for this plugin only!)
		global $wp_roles;		
		$roles = $wp_roles->get_names();
		foreach($roles as $role=>$role_name){		
			$wp_roles->add_cap( $role, 'access_s2member_ccap_translator', false );
		}
    }

    function ktr_plugin_remove() {
		
		//Remove "translator" capabality. With this capability any user can be admin(for this plugin only!)
		global $wp_roles;		
		$roles = $wp_roles->get_names();
		foreach($roles as $role=>$role_name){		
			$wp_roles->remove_cap( $role, 'access_s2member_ccap_translator' );
		}
    }
	
	
    function get_uploaded_version($order_id){
         global $wpdb;
          $current_user=wp_get_current_user();
         $userID=$current_user->ID;
        $q=$wpdb->prepare("SELECT MAX(ktr_trnslt_status) as max_version from ".$wpdb->prefix.KTR_TRANSLATE_FILE_URL_TABLE." where ktr_id=".$order_id." and user_id = '%d'", $userID);
        $results=$wpdb->get_row($q);
        if(count($results)>0){
          return  $results-> max_version+1;
        }else{
            return 0;
        }
    }
    function add_order_file_path($url,$order_id ,$version=''){
        global $wpdb;
         $current_user=wp_get_current_user();
         $userID=$current_user->ID;

        if($_REQUEST['ktr_translator_upload']){
            $sql = $wpdb->prepare(
                "INSERT INTO ".$wpdb->prefix.KTR_TRANSLATE_FILE_URL_TABLE." (
                        ktr_trnslt_url  ,
                        ktr_id,
                        ktr_trnslt_status,
                        user_id
                ) VALUES (
                            '%s', %d,%d,%d
                    )",
                    $url,
                    $order_id,
                    $version,
                    $userID
                    );
            
        }else{
        $sql = $wpdb->prepare(
                "INSERT INTO ".$wpdb->prefix.KTR_ORDERED_FILE_URL_TABLE." (
                        ktr_ordf_url  ,
                        ktr_id
                ) VALUES (
                            %s, %d
                    )",
                    $url,
                    $order_id
                    );
        }
                $result = $wpdb->query( $sql );
    }
    
    function add_translation_file_path(){
         global $wpdb;
        $sql = $wpdb->prepare(
                "INSERT INTO ".$wpdb->prefix.KTR_ORDERED_FILE_URL_TABLE." (
                        ktr_ordf_url  ,
                        ktr_id
                ) VALUES (
                            %s, %d
                    )",
                    $url,
                    $order_id
                    );
                $result = $wpdb->query( $sql );
    }
    
    function recurse_copy($src,$dst,$order_id,$version='') { 
        $is_val=read_dir(TEMP_DIR.DS.  session_id());
     if(is_array($is_val)){
    (is_dir($src))?" ":@mkdir($src); 
     $dir = opendir($src); 
    
    while(false !== ( $file = readdir($dir)) ) { 
        $unique_filename_callback=null;
       
       $dstfilename= wp_unique_filename($dst,$file,$unique_filename_callback);
  
    
        if (( $file != '.' ) && ( $file != '..' )) { 
           
            if ( is_dir($src . '/' . $file) ) { 
                recurse_copy($src . '/' . $file,$dst . '/' . $dstfilename); 
                add_order_file_path($dst . '/' . $dstfilename,$order_id,$version);
                unlink($src . '/' . $file);
            
            } 
            else { 
               
                copy($src . '/' . $file,$dst . '/' . $dstfilename); 
                add_order_file_path($dst . '/' . $dstfilename,$order_id,$version);
                unlink($src . '/' . $file);
             
            }
             
        }
        
    } 
    closedir($dir); 
    rmdir($src);
     return true;
         }else{
             return false;
         }
    
} 

function read_dir($dir, $array = array()){
    if(is_dir($dir)){
        $dh = opendir($dir);
        $files = array();
        while (($file = readdir($dh)) !== false) {
            $flag = false;
            if($file !== '.' && $file !== '..' && !in_array($file, $array)) {
                $files[] = $file;
            }
        }
        return $files;
    }else{
        return false;
    }
    } 

 function remove_temp_directory($src) { 
     $dir = opendir($src); 
    while(false !== ( $file = readdir($dir)) ) { 
        $unique_filename_callback=null;
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
                unlink($src . '/' . $file);
            } 
            else { 
                unlink($src . '/' . $file);
            }
        } 
    } 
    closedir($dir); 
    rmdir($src);
     return true;
  
    
} 

function get_language_drp(){
    global $wpdb;
    
   $table = $wpdb->prefix . KTR_LANGUAGE_TABLE;
    $sql = $wpdb->prepare( "SELECT * FROM $table  ORDER BY ktr_trnslt_from asc", '' );
    $results = $wpdb->get_results($sql);
    
    
    if(is_array($results)):
        $i=0;
        echo "<select name='language_drp' id='language_drp'>";
        foreach($results as $val):
            $i;
        
            echo "<option value='".$val->ktr_laguage_id ."'>".ucfirst($val->ktr_trnslt_from)." To ".ucfirst($val->ktr_trnslt_to)."</option>";
            $i++;
        endforeach;
        echo "</select>";
    endif;
}



function get_file_type_drp(){
    global $wpdb;
    $table = $wpdb->prefix . KTR_FILE_TYPE_TABLE;
    $sql = $wpdb->prepare( "SELECT * FROM $table  ORDER BY ktr_file_type asc", '' );
    $results = $wpdb->get_results($sql);
    
    
    if(is_array($results)):
        $i=0;
        echo "<select name='trs_type' id='trs_type'>";
        foreach($results as $val):
            $i;
        
            echo "<option value='".$val->ktr_file_type ."'>".ucfirst($val->ktr_file_type)."</option>";
            $i++;
        endforeach;
        echo "</select>";
    endif;
}

function get_order_id_by_insert_id($insert_id){
    global $wpdb;
    $table=$wpdb->prefix.KTR_ORDER_INFO_TABLE;
     $sql = $wpdb->prepare( "SELECT ktr_order_id FROM $table WHERE ktr_id='".$insert_id ."' ORDER BY ktr_id desc", '' );
    $order = $wpdb->get_row($sql);
    $order_id=$order->ktr_order_id;
   
 
    if($order_id < START_ORDER){
        $order_id=START_ORDER;
    }else{
        $order_id=(int)$order_id;
    }
   $order_id++;
  
    return $order_id;
    
    
}
function get_order_id(){
    global $wpdb;
    $table=$wpdb->prefix.KTR_ORDER_INFO_TABLE;
     $sql = $wpdb->prepare( "SELECT ktr_order_id FROM $table ORDER BY ktr_id desc", '' );
    $order = $wpdb->get_row($sql);
    $order_id=$order->ktr_order_id;
   
 
    if($order_id < START_ORDER){
        $order_id=START_ORDER;
    }else{
        $order_id=(int)$order_id;
    }
   $order_id++;
  
    return $order_id;
    
    
}

function add_order_info($user_id){
        global $wpdb;
        global $bp;

$error_word_number=($_REQUEST['wrd_nmbr']=="")?"Please write number word you want to translate.<br />":false;
$error_page_number=($_REQUEST['pg_nmbr']=="")?"Please write numebr of page want to translate.<br />":false;
$error_file_type=($_REQUEST['trs_type']=="")?"please Slect a file type.<br />":false;
$error_laguage=($_REQUEST['language_drp']=="")?"please select a lanuage for your translation.<br />":false;

$insert_error=$error_file_type.$error_laguage .$error_word_number.$error_page_number;
if($insert_error){
  $_SESSION['insert_error_msg']=$error_file_type.$error_laguage .$error_word_number.$error_page_number;
  
   return false;
}

        $table = $wpdb->prefix . KTR_LANGUAGE_TABLE;
        $sql = $wpdb->prepare( "SELECT * FROM $table  WHERE ktr_laguage_id  = %d", $_REQUEST['language_drp']);
        $get_language = $wpdb->get_results($sql);
        foreach($get_language as $r){
            $perword_rice=$r->ktr_price_per_word;
            $trnslt_frm=$r->ktr_trnslt_from;
            $trnslt_to=$r->ktr_trnslt_to;
            break;

        }
        $sql2 = $wpdb->prepare( "SELECT ktr_file_type_id FROM ". $wpdb->prefix.KTR_FILE_TYPE_TABLE."  WHERE ktr_file_type = %s", $_REQUEST['trs_type']);
        $get_type_id = $wpdb->get_row($sql2)->ktr_file_type_id;
        $sql3 = $wpdb->prepare( "SELECT ktr_type_base_price FROM ". $wpdb->prefix.KTR_TYPE_BASE_PRICE_TABLE."  WHERE ktr_type =".$get_type_id." and 	ktr_type_language = %s", $_REQUEST['language_drp']);

        $perword_price = $wpdb->get_row($sql3)->ktr_type_base_price;
        $currency_code=get_option('payment-currency');
        $setting_quote = get_option( 'ktr-setting-quote' );
        if($setting_quote=='automatic'){
        $price=$_REQUEST['pg_nmbr']*$perword_price;
        $status=AWATING_CLIENT_ACCEPTANCE;
     
            }else{
            $price='';
            $status=AWATING_QUOTE;
            $mail_send_price='<br /> Price: Not Quoted Yet<br /><br />';
           
        }
       
        $word_number=$_REQUEST['wrd_nmbr'];
        $page_number=$_REQUEST['pg_nmbr'];
        $file_type=$_REQUEST['trs_type'];
        $language=ucfirst($trnslt_frm)." To ".ucfirst($trnslt_to);
        $message=$_REQUEST['sender_msg'];
        $user_id=$user_id;
        $order_id=get_order_id();
        if($message!=''){
            $mail_user_msg=' Message: : '.nl2br($message).'<br />';
        }
        $user_info = get_userdata($user_id);
        $user_name=$user_info->user_login;
      $sql = $wpdb->prepare(
        "INSERT INTO ".$wpdb->prefix.KTR_ORDER_INFO_TABLE." (
                ktr_order_id ,
                ktr_order_number ,
                ktr_page_number,
                ktr_File_type,
                ktr_language,
                ktr_message,
                ktr_order_from,
                ktr_price,
                ktr_currency_code,
                status
        ) VALUES (
                    %d, %d, %d, %s, %s, %s, %d,%s,%s,%d
                )",
                $order_id,
                $word_number,
                $page_number,
                $file_type,
                $language,
                $_REQUEST['sender_msg'],
                $user_id,
                $price,
                $currency_code,
                $status
                );

        $wpdb->query( $sql );


         if($price>0){
                $table=$wpdb->prefix.KTR_ORDER_INFO_TABLE;
                    $sql = $wpdb->prepare( "SELECT * FROM $table where ktr_order_id = '%d' ORDER BY ktr_id desc", $order_id );
                    $order = $wpdb->get_row($sql);
              
					$item_name = 'Translation '.$order->ktr_language;
                    
           $mail_send_price='<br /> Price: '.get_option('ktr_currency').$price.' <a href="https://www.paypal.com/cgi-bin/webscr?business='.get_option('ktr-setting-paypal_email').'&amp;cmd=_xclick&currency_code='. $currency_code.'&amp;amount='. $order->ktr_price.'&amp;quantity=1&amp;item_name='.$item_name.'&amp;item_number='.$order->ktr_order_id.'&amp;notify_url='. site_url().'/wp-content/plugins/kite-file-translate-manage-system/ipn/listener.php&amp;return='. site_url().'/members/'. $user_name. '/ktr' . '/view-orders/&amp;cancel_return='. site_url().'/members/'. $user_name. '/ktr' . '/view-orders/">Pay Now</a>'
          .' <br /><br />';
           $mail_send_msg_details= '<a href="https://www.paypal.com/cgi-bin/webscr?business='.get_option('ktr-setting-paypal_email').'&cmd=_xclick&currency_code='. $currency_code.'&amount='.$order->ktr_price.'&quantity=1&item_name='.$item_name.'&item_number='.$order->ktr_order_id.'&notify_url='. site_url().'/wp-content/plugins/kite-file-translate-manage-system/ipn/listener.php&return='. $bp->loggedin_user->domain . 'ktr'  . '/view-orders/&cancel_return='.$bp->loggedin_user->domain . 'ktr'  . '/view-orders/">Pay Now</a> <br/><br />Once we receive your payment, we will initiate the translation process.';

         }else{
              $mail_send_msg_details="You will receive a price quotation very shortly.<br /><br />";
         }
            //$admin_email = get_option( 'ktr-setting-admin_email' );       
            
            $user_email=$user_info->user_email ;
            $admin_email = get_option( 'ktr-setting-admin_email' );
            $headers = 'From: '. get_bloginfo( $show, 'display' ).'<'.$admin_email.'>' . "\r\n";
            $headers .= 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $order_date= get_order_info_by_order_id($order_id)->ktr_order_date ;
            $dateTime=explode(" ",$order_date);
            $dateArray=explode('-',$dateTime['0']) ;
              
            $dateAll=mktime(0,0,0,date($dateArray[1]),date($dateArray[2]),date($dateArray[0]));
            $date= date("d M Y",$dateAll);
            $subject=' Your Order at '.get_bloginfo( $show, 'display' ).' : '.$order_id. "\r\n";
            $message='<br /><br />Thank you for your order with '. get_bloginfo( $show, 'display' ).'.
                Please find the price quotation for your order below:<br /> <br />
                Order ID: '.$order_id.'<br />
                Order Date: '.$date.'<br />
                Number of Pages: '.$page_number.'<br />
                Number of Words: '.$word_number.'<br />
                Language: '.$language.'<br />
                Type:  '.$file_type.'<br />
                '.$mail_user_msg.'
                '.$mail_send_price.'
                Thank you again for your order with '. get_bloginfo( $show, 'display' ).'. Please contact us if you need any clarification regarding your order.<br />--'. 
                "<br/>".get_bloginfo( $show, 'display' );
            add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
            wp_mail($user_email , $subject, $message , $headers);
          
        
        
      return $wpdb->insert_id;
}
function get_currency_symbol_by_currency_code($code){
    
    if($code=="USD"){
        $c_symbol="$";
    }elseif($code=="GBP"){
        $c_symbol="£";
    }elseif($code=="EU"){
         $c_symbol="€";
    }
    return $c_symbol;
}
function isValidEmail($email){
	return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
}
function get_order_info_by_order_id($id=''){
    global $wpdb;
    $table=$wpdb->prefix.KTR_ORDER_INFO_TABLE;
    $sql=$wpdb->prepare("SELECT * FROM $table WHERE ktr_order_id = '%s'", $id);
    $obj= $wpdb->get_row($sql);;
    return $obj;
    
}
function check_user_login($username){
     $ktr_user_name=strtolower($username);
     $user_name = str_replace (" ", "", $ktr_user_name);
     $user_id = username_exists( $user_name );
     if($user_id){
         return true;
     }else{
         return false;
     }
     
}
function check_user_email($useremail){
     $ktr_user_email=$useremail;
       if ( email_exists($ktr_user_email) ){
             return true;
            } else{
              return false;
            // echo "That E-mail doesn't belong to any registered users on this site";
            }
}




//Create order!
function ktr_file_upload_form($args = array(), $content = null){
   global $dataSubmitMsg; 
 if($_REQUEST['ktr_upload']){
 
	//Determine if the same form is submitted again
	$isResubmission = false;
	if(isset($_SESSION['zecurity']) && $_SESSION['zecurity'] == $_POST['zecurity']){
		$isResubmission = true;
	}else{
		$_SESSION['zecurity'] = $_POST['zecurity'];
	}
	
  if($isResubmission){
           ?>
        <?php if ( $_SESSION['insert_error_msg'] ) :
            
            ?><?php echo "<div id='message' class='updated fade'><p>" . __("<b>Error:</b><br/>". $_SESSION['insert_error_msg'], 'bp-ktr' ) . "</p></div>" ?>
		<?php  else: ?>
         <?php echo "<div id='message' class='updated fade'><p>" . __("Data Submited Already", 'bp-ktr' ) . "</p></div>" ?>
       <?php
          endif;
      }else{
          
		  //Captcha related code
		  if(get_option( 'ktr-setting-captcha' ) != 'no'){
			
			if(!isset($_POST['z_'.substr(md5(home_url()),0,3)])){
				$_SESSION['insert_error_msg'] = 'You may have disabled javascript. Please enable javascript.';
				echo "<div id='message' class='updated fade'><p>" . __("<b>Error:</b><br/>". $_SESSION['insert_error_msg'], 'bp-ktr' ) . "</p></div>";
				return false;
			} elseif (isset($_POST['z_email']) && $_POST['z_email'] !== ''){
				$_SESSION['insert_error_msg'] = 'You appear to be a spambot. Contact admin another way if you feel this message is in error';
				echo "<div id='message' class='updated fade'><p>" . __("<b>Error:</b><br/>". $_SESSION['insert_error_msg'], 'bp-ktr' ) . "</p></div>";
				return false;
			} 
		 }
		  
            if ( is_user_logged_in() ) {
            $current_user=wp_get_current_user();
            $userID=$current_user->ID;
            $insert_id=add_order_info($userID);
            if($insert_id){
            if(!is_dir ('wp-content/uploads'.DS.KTR_ROOT_DIRECTORY.DS.$userID)){
                $oldumask = umask(0);
                mkdir('wp-content/uploads/'.KTR_ROOT_DIRECTORY.DS.$userID, 0777); // or even 01777 so you get the sticky bit set
                umask($oldumask);
            }
           if( !recurse_copy(TEMP_DIR.DS.  session_id(),'wp-content/uploads/'.KTR_ROOT_DIRECTORY.DS.$userID,$insert_id)){
                $_SESSION['insert_error_msg']="Please Select file.";
                ?>
             <?php if ( $_SESSION['insert_error_msg'] ): 
                 $dir=TEMP_DIR.DS.  session_id();
                remove_temp_directory($dir);
                 ?><?php echo "<div id='message' class='updated fade'><p>" . __("<b>Error:</b><br/>". $_SESSION['insert_error_msg'], 'bp-ktr' ) . "</p></div>" ?><?php endif; ?>
            <?php
               return false;
           }
            $dataSubmitMsg="<div id='message' class='updated fade'><p>Thank You! We have received your order. You will receive a price quotation very shortly.</p></div>";
            $admin_email = get_option( 'ktr-setting-admin_email' );
            $user_name=$current_user->user_login;
            //$headers = 'From: '. get_bloginfo( $show, 'display' ).'<'.$admin_email.'>';
            $headers = 'From: '. get_bloginfo( $show, 'display' ).' <'.$admin_email.'>' . "\r\n" .'Reply-To: '.get_bloginfo( $show, 'display' ).'<'. $admin_email .'>'."\r\n" .'X-Mailer: PHP/' . phpversion();
            $headers .= 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $subject='A new order is placed'. "\r\n";
            $order_id= get_order_id_by_insert_id($insert_id);
			$message = bp_ktr_get_email('admin_new_order', 'salutation');
            $message .='<p><b>'.$user_name.'</b> have placed an order.</p><p>Order ID:<b>'.$order_id.'</b>';
			$message .= bp_ktr_get_email('admin_new_order', 'footer');
            add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
            wp_mail($admin_email , $subject,$message , $headers);
            }else{
                $dir=TEMP_DIR.DS.  session_id();
                remove_temp_directory($dir);
                ?>
                <?php if ( $_SESSION['insert_error_msg'] ) : ?><?php echo "<div id='message' class='updated fade'><p>" . __("<b>Error:</b><br/>". $_SESSION['insert_error_msg'], 'bp-ktr' ) . "</p></div>" ?><?php  endif; ?>
                <?php
            }
           }else{
            
            $msg=array();
            $ktr_sender_name=trim($_REQUEST['sender_name']);
            $user_name = str_replace (" ", "", $ktr_sender_name);
            $ktr_sender_email=$_REQUEST['sender_email'];
            $random_password = wp_generate_password( 12, false );
            if ( email_exists($ktr_sender_email) ){
                $emailError='true';
                $msg['email_exist']= "That E-mail is registered to please chose another email" ;
            } else{
                $msg['email_exist']="";
                $emailError='false';
            // echo "That E-mail doesn't belong to any registered users on this site";
            }
              $user_id = username_exists( $user_name );
          
        if ( !$user_id && $emailError=='false'&&$user_name!="") {
                $user_name=strtolower($user_name);
                $userID = wp_create_user( $user_name, $random_password, $ktr_sender_email );
                $insert_id=add_order_info($userID);
                if(!is_dir ('wp-content/uploads'.DS.KTR_ROOT_DIRECTORY.DS.$userID)){
                    $oldumask = umask(0);
                    mkdir('wp-content/uploads/'.KTR_ROOT_DIRECTORY.DS.$userID, 0777); // or even 01777 so you get the sticky bit set
                    umask($oldumask);
                    }
                    
                    recurse_copy(TEMP_DIR.DS.  session_id(),'wp-content/uploads/'.KTR_ROOT_DIRECTORY.DS.$userID,$insert_id);
                    
					$admin_email = get_option('ktr-setting-admin_email');
                    $noreply_email=$admin_email;
                    $headers = 'From: '. get_bloginfo( $show, 'display' ).' <'.$noreply_email.'>' . "\r\n" .'Reply-To: '.get_bloginfo( $show, 'display' ).'<'. $admin_email .'>'."\r\n" .'X-Mailer: PHP/' . phpversion();
                    $headers .= 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    $subject='A new order is placed'. "\r\n";
                    $subject='Registration Information at '.get_bloginfo( $show, 'display' ). "\r\n";
					$message =  bp_ktr_get_email('client_new_order', 'salutation');
                    $message .= "Following is the details of your user account at ".get_bloginfo( $show, 'display' ).":<br /><br /> User name: ".$user_name."
                    <br /> Password: ".$random_password."<br /><br /> Thank you <br /> ".get_bloginfo( $show, 'display' )."";
                    $message .= bp_ktr_get_email('client_new_order', 'footer');
					
					add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
                    wp_mail($ktr_sender_email , $subject,$message , $headers);
                    
					
					
                   // $headers_admin = 'From: '. get_bloginfo( $show, 'display' ).' <'.$admin_email.'>' . "\r\n";
                    $headers_admin = 'From: '. get_bloginfo( $show, 'display' ).' <'.$noreply_email.'>' . "\r\n" .'Reply-To: '.get_bloginfo( $show, 'display' ).'<'. $admin_email .'>'."\r\n" .'X-Mailer: PHP/' . phpversion();
                    $headers_admin .= 'MIME-Version: 1.0' . "\r\n";
                    $headers_admin .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    $subject_admin='A new order is placed'. "\r\n";
					$message_admin =  bp_ktr_get_email('admin_new_order', 'salutation');
                    $message_admin .= $user_name.' have placed an order.<br /> Order ID:'. get_order_id_by_insert_id($insert_id).'<br />';
					$message_admin .= bp_ktr_get_email('admin_new_order', 'footer');
					
                    add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
                    wp_mail($admin_email , $subject_admin,$message_admin , $headers_admin);
                    $dataSubmitMsg ="<div id='message' class='updated fade'><p>Thank You! We have received your order. You will receive a price quotation very shortly</div></p>";
            } else {
                $dir=TEMP_DIR.DS.  session_id();
                remove_temp_directory($dir);
                $msg['user_exist']=$random_password = 'User already exists.<br/>';
                $dataSubmitMsg="<div id='message' class='updated fade'><p>".$msg['user_exist'].$msg['email_exist']."</p></div>";
            }

               // echo session_id();
         }
         echo $dataSubmitMsg;
         
		 //update_option("ktr_vailation","true");
         //update_option("ktr_vailation","false");

      }
}else{
     $dir=TEMP_DIR.DS.  session_id();
     if(is_dir($dir)){
         
     remove_temp_directory($dir);
     }
//update_option("ktr_vailation","false");

    ?>

<script>  
	var atLeastOneFileUploaded = false;
	function createUploader(){            
		var uploader = new qq.FileUploader({
			element: document.getElementById('demo'),
			listElement: document.getElementById('separate-list'),
			action: '<?php echo home_url()?>/wp-content/plugins/kite-file-translate-manage-system/valums-file-uploader/server/php.php',
			onComplete: function(id, fileName, responseJSON){
				atLeastOneFileUploaded = true;
			}
		});           
	}  
	
	window.onload = createUploader;  
</script> 

<script type="text/javascript">
	jQuery(function() {
		jQuery("#form1").validate({
			invalidHandler: function(e, validator) {
				alert('Please correct the highlited fields.');				 
			},
			onkeyup: false,
			submitHandler: function() {
				if(atLeastOneFileUploaded){
					jQuery(form).submit();	
				}else{
					alert('Please upload at least one file.');
				}
			},
			rules: {
				wrd_nmbr: { digits: true, required: true },
				pg_nmbr: { digits: true, required: true },
				sender_msg: { required: true }
			},
			messages: {
				wrd_nmbr: "",
				pg_nmbr: "",
				sender_msg: ""
			}
		});
	});
</script>
	
	<form id="form1" name="ktr_upload_frm" method="post" enctype="multipart/form-data">	
		<input type="hidden" name="zecurity" value="form1_<?=time()?>" />
		<fieldset>
			<p class="first">
				<label>Number of Words</label>
				<input type="text" name="wrd_nmbr" size="100%" />
			</p>
			<p>
				<label>Number of Pages</label>
				<input type="text" name="pg_nmbr" size="100%" />
			</p>
			<p>
				<label>Type</label>
				<?php echo get_file_type_drp();?>
			</p>
			<p>
				<label>Language</label>
				<?php do_action('create_language_drop'); ?>
			</p>	
			<p>
				<label>File Upload</label>
				<div id="demo"></div>
                <ul id="separate-list"></ul>
			</p>
			
			<?php if(!is_user_logged_in()):?>
			<p>
				<label>Username</label>
				<input type="text" name="sender_name" size="100%" />
			</p>
			<p>
				<label>Email</label>
				<input type="text" name="sender_email" size="100%" />
			</p>
			<?php endif;?>
		
			<p>
				<label>Message</label>
				<textarea name="sender_msg"></textarea>
			</p>
			
			<p>
<?
		//if(!is_user_logged_in() || true){
		if(get_option( 'ktr-setting-captcha' ) != 'no'){
            
            echo '<p id="z_p" style="clear:both;"></p>';
            echo '<script type="text/javascript">
            //v1.2
            var z_p = document.getElementById("z_p");
            var z_checkbox = document.createElement("input");
            var gasp_text = document.createTextNode(" Please confirm that you are a human. ");
            z_checkbox.type = "checkbox";
            z_checkbox.id = "z_'.substr(md5(home_url()),0,3).'";
            z_checkbox.name = "z_'.substr(md5(home_url()),0,3).'";
            z_checkbox.style.width = "12px";
            z_p.appendChild(z_checkbox);
            z_p.appendChild(gasp_text);
            var frm = z_checkbox.form;
            frm.onsubmit = gasp_it;
            function gasp_it(){
            if(z_checkbox.checked != true){
            alert("Please check the checkbox first.");
            return false;
            }
            return true;
            }
            </script>
            <noscript>you MUST enable javascript to be able to send the translations</noscript>
            <input type="hidden" id="z_email" name="z_email" value="" />';
        }
?>
		</p>
		</fieldset>	

		

		<p class="submit">
			<input type="hidden" name="ktr_upload" value="Submit" />
			<button type="submit">Submit</button></p>		
						
	</form>	
			 

<?php
    }
}
    function ktr_fileupload_form_shortcode($atts){
       ob_start();
	ktr_file_upload_form();
	$output = ob_get_clean();
	
	return $output;
    }
    
    function ktr_pluginUninstall() {

            global $wpdb;
            $clientInfoTable = $wpdb->prefix."kiteorder_client";
            $registerDomainInfoTable = $wpdb->prefix."kiteorder_order";

           // $wpdb->query("DROP TABLE IF EXISTS $registerDomainInfoTable");
            //$wpdb->query("DROP TABLE IF EXISTS $clientInfoTable");
    }

 
   function ktr_init_method() {
     ktr_tables_create();
     add_action('create_language_drop','get_language_drp');
     add_shortcode('KTR_FILE_UPLOADER', 'ktr_fileupload_form_shortcode'); 
     

    
}
 $currency=get_option('payment-currency');
if($currency==""){
    update_option("payment-currency","&#x24;");
    update_option("ktr_currency","&#x24;");
}

function sentence_case($string) { 
    $sentences = preg_split('/([.?! ]+)/', $string, -1, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE); 
    $new_string = ''; 
    foreach ($sentences as $key => $sentence) { 
        $new_string .= ($key & 1) == 0? 
            ucfirst(strtolower(trim($sentence))) : 
            $sentence.' '; 
    } 
    return trim($new_string); 
}


function add_ajaxurl_cdata_to_front(){
?>
<script type="text/javascript">
//<![CDATA[
var MyAjax = {
    ajaxurl:" <?php echo site_url();?>/wp-admin/admin-ajax.php",
    somevar1: "widget_r",
    somevar2: "someothervalue"
};

//]]>
</script>
<script type="text/javascript" src="<?php echo plugins_url('/'.PLUGIN_NAME.'/js/kite_translaor.js')?>"></script>
<?php

}
add_action( 'admin_head', 'add_ajaxurl_cdata_to_front', 5);







add_action('init', 'ktr_init_method');

wp_enqueue_script("jquery");

 wp_enqueue_script("ktr_valum_js_ff",str_replace('/js','',$pluginsJsUrl).'valums-file-uploader/client/fileuploader.js');
  //wp_enqueue_script("ktr_valum_js_ffsb",str_replace('/js','',$pluginsJsUrl).'valums-file-uploader/client/trns_fileuploader.js');
wp_enqueue_style('ktr_valum_css_kk',  str_replace('/style','', $pluginsStyleUrl).'valums-file-uploader/client/fileuploader.css');

wp_enqueue_script("ktr_form_validator",$pluginsJsUrl.'jquery.validate.min.js');

//wp_enqueue_script("ktr_js",$pluginsJsUrl.'kite_translaor.js');
wp_enqueue_style('ktr_style_sheet',$pluginsStyleUrl.'kite_translator.css');
wp_enqueue_script("ktr_date_picker",$pluginsJsUrl.'jq.datepicker.js');
wp_enqueue_style('ktr_style_sheet',$pluginsStyleUrl.'smoothness/jquery-ui-1.7.1.custom.css');

wp_enqueue_script('jquery.datepick', plugins_url( '/'.PLUGIN_NAME.'/includes/js/jquery.datepick.js'));
	wp_enqueue_style('jquery.datepick',plugins_url( '/'.PLUGIN_NAME.'/includes/style/jquery.datepick.css' ));



 



register_deactivation_hook( __FILE__, 'ktr_plugin_remove' );
register_activation_hook(__FILE__,'ktr_plugin_install');
register_uninstall_hook(__FILE__,'ktr_pluginUninstall');

add_action( 'admin_action_ktr', 'ktr_admin_action' );
function kite_admin_action()
{
    // Do your stuff here
   wp_redirect( $_SERVER['HTTP_REFERER'] );
   $_REQUEST['pagenum']=7;
    exit();
}
    function fb_wp_insert_user() {
    $user_data = array(
    'ID' => '',
    'user_pass' => wp_generate_password(),
    'user_login' => 'dummy',
    'user_nicename' => 'Dummy',
    'user_url' => '',
    'user_email' => 'dummy@example.com',
    'display_name' => 'Dummy',
    'nickname' => 'dummy',
    'first_name' => 'Dummy',
    'user_registered' => '2010-05-15 05:55:55',
    'role' => get_option('default_role') // Use default role or another role, e.g. 'editor'
    );
    $user_id = wp_insert_user( $user_data );
    }
   // add_action( 'admin_init', 'fb_wp_insert_user' );


   
//Get email parts   
function bp_ktr_get_email($email_name, $part = 'salutation'){
	global $wpdb;
	
	$table = $wpdb->prefix.KTR_EMAILS_TABLE;
	$sql   = $wpdb->prepare("SELECT * from $table WHERE name = '%s' LIMIT 1", $email_name);
	if($db_email = $wpdb->get_row($sql)){
		
		if($part == 'salutation'){
			return $db_email->salutation;
		}elseif($part == 'footer'){
			return $db_email->footer;
		}
	}else{
		return '';
	}
}   

//Set translation status
function bp_ktr_set_status($order_id, $status){
	global $wpdb;
	
	$table=$wpdb->prefix . KTR_ORDER_INFO_TABLE;
       
	$wpdb->query($wpdb->prepare("
			UPDATE $table 
			SET status = {$status}
			WHERE ktr_order_id = %d"
	, $order_id ));
	
}

//Is automatic send on for the order (for language combination of the order)
function z_automatic_send($order_number){ //Like 10001
	global $wpdb;
	
	$orderTable = $wpdb->prefix . KTR_ORDER_INFO_TABLE;
	$order = $wpdb->get_row("SELECT * FROM {$orderTable} WHERE ktr_order_id = $order_number");
	$lang_parts = explode(' To ', $order->ktr_language);
	
	$langTable = $wpdb->prefix . KTR_LANGUAGE_TABLE;
	$lang = $wpdb->get_row("SELECT * FROM {$langTable} WHERE ktr_trnslt_from = '{$lang_parts[0]}' AND ktr_trnslt_to = '{$lang_parts[1]}'");
	if($lang->auto_send){
		$translator_id = $lang->default_translator;
		
		$table_assign_translator=$wpdb->prefix.KTR_TRANSLATING_DETAIL_TABLE;
        $date='';
            
        $sql = $wpdb->prepare(
                "INSERT INTO $table_assign_translator (
                        ktr_translator_id,
                        ktr_id,
						ktr_due_date,
                        ktr_comment,
						ktr_pending_status
                ) VALUES (
                   %d,
                   ".$lang->default_translator.",
                   '',
                   '',
				   '".PENDING_WAITING_TRANSLATOR."')"
                , $order_number);
         $result = $wpdb->query( $sql );
            
         $order_table=$wpdb->prefix.KTR_ORDER_INFO_TABLE;
         $wpdb->query($wpdb->prepare("
			UPDATE $order_table 
			SET status =3
			WHERE ktr_order_id = %d"
		 , $order_number));
			
			//Additions
			//$sentDate   = date('Y').'-'.date('m').'-'.date('d').' 00:00:00';
			
			$user_id = $lang->default_translator;
			$user_info = get_userdata($user_id);
			$user_email = $user_info->user_email ;
			$admin_email = get_option( 'ktr-setting-admin_email' );
			$headers = 'From: '. get_bloginfo( $show, 'display' ).'<'.$admin_email.'>' . "\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$date = date("d M Y");
			$subject=' A New Task is Assigned : '.$order_number. "\r\n";
			$message =  bp_ktr_get_email('translator_order_assigned', 'salutation');
			$message .='<br /><br />A new task has been assigned for you automatically.
			<br /><br />
			You can view more details of the task from your admin panel.<br /><br />--'.
				"<br/>".get_bloginfo( $show, 'display' );
			$message .= bp_ktr_get_email('translator_order_assigned', 'footer');
			
			add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
			
			//Prepare attachements
			$attachments = array();
			$filesTable  = $wpdb->prefix.KTR_ORDERED_FILE_URL_TABLE;
			$filesSql    = 	"SELECT * FROM $filesTable WHERE ktr_id = %";
			$rows 		 = $wpdb->get_results($wpdb->prepare( $filesSql, $order->ktr_id ));
			foreach($rows as $r){
				$attachments[]= WP_CONTENT_DIR . str_replace('wp-content','',$r->ktr_ordf_url);
			}
			
          wp_mail($user_email , $subject, $message , $headers, $attachments);
	}
} 

?>