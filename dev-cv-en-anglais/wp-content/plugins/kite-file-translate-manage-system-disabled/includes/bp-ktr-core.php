<?php

/* Define a constant that can be checked to see if the component is installed or not. */
define ( 'BP_KTR_IS_INSTALLED', 1 );

/* Define a constant that will hold the current version number of the component */
define ( 'BP_KTR_VERSION', '1.5' );

/* Define a constant that will hold the database version number that can be used for upgrading the DB
 *
 * NOTE: When table defintions change and you need to upgrade,
 * make sure that you increment this constant so that it runs the install function again.
 *
 * Also, if you have errors when testing the component for the first time, make sure that you check to
 * see if the table(s) got created. If not, you'll most likely need to increment this constant as
 * BP_KTR_DB_VERSION was written to the wp_usermeta table and the install function will not be
 * triggered again unless you increment the version to a number higher than stored in the meta data.
 */
define ( 'BP_KTR_DB_VERSION', '1' );

/* Define a slug constant that will be used to view this components pages (http://ktr.org/SLUG) */
if ( !defined( 'BP_KTR_SLUG' ) )
	define ( 'BP_KTR_SLUG', 'ktr' );

	

	
	
/*
 * If you want the users of your component to be able to change the values of your other custom constants,
 * you can use this code to allow them to add new definitions to the wp-config.php file and set the value there.
 *
 *
 *	if ( !defined( 'BP_KTR_CONSTANT' ) )
 *		define ( 'BP_KTR_CONSTANT', 'some value' // or some value without quotes if integer );
 */

/**
 * You should try hard to support translation in your component. It's actually very easy.
 * Make sure you wrap any rendered text in __() or _e() and it will then be translatable.
 *
 * You must also provide a text domain, so translation files know which bits of text to translate.
 * Throughout this ktr the text domain used is 'bp-ktr', you can use whatever you want.
 * Put the text domain as the second parameter:
 *
 * __( 'This text will be translatable', 'bp-ktr' ); // Returns the first parameter value
 * _e( 'This text will be translatable', 'bp-ktr' ); // Echos the first parameter value
 */

if ( file_exists( dirname( __FILE__ ) . '/languages/' . get_locale() . '.mo' ) )
	load_textdomain( 'bp-ktr', dirname( __FILE__ ) . '/bp-ktr/languages/' . get_locale() . '.mo' );

/**
 * The next step is to include all the files you need for your component.
 * You should remove or comment out any files that you don't need.
 */

/* The classes file should hold all database access classes and functions */


/* The ajax file should hold all functions used in AJAX queries */
require ( dirname( __FILE__ ) . '/bp-ktr-ajax.php' );

/* The cssjs file should set up and enqueue all CSS and JS files used by the component */
require ( dirname( __FILE__ ) . '/bp-ktr-cssjs.php' );

/* The templatetags file should contain classes and functions designed for use in template files */
require ( dirname( __FILE__ ) . '/bp-ktr-templatetags.php' );

/* The widgets file should contain code to create and register widgets for the component */
require ( dirname( __FILE__ ) . '/bp-ktr-widgets.php' );

/* The notifications file should contain functions to send email notifications on specific user actions */
require ( dirname( __FILE__ ) . '/bp-ktr-notifications.php' );

/* The filters file should create and apply filters to component output functions. */
require ( dirname( __FILE__ ) . '/bp-ktr-filters.php' );

require_once( ABSPATH . '/wp-admin/includes/file.php' );

/**
 * bp_ktr_setup_globals()
 *
 * Sets up global variables for your component.
 */
 
function bp_ktr_setup_globals() {
	global $bp, $wpdb;

if ( !defined( 'BP_KTR_UPLOAD_PATH' ) ){
		define ( 'BP_KTR_UPLOAD_PATH', bp_ktr_upload_path() );
}

	/* For internal identification */
	$bp->ktr->id = 'ktr';

	$bp->ktr->table_name = $wpdb->base_prefix . 'bp_doc_library';
	$bp->ktr->format_notification_function = 'bp_ktr_format_notifications';
	$bp->ktr->slug = BP_KTR_SLUG;
        $bp->ktr->upload='upload-lib-doc';

	/* Register this in the active components array */
	$bp->active_components[$bp->ktr->slug] = $bp->ktr->id;

}
add_action( 'bp_setup_globals', 'bp_ktr_setup_globals' );



/**
 * bp_ktr_add_admin_menu()
 *
 * This function will add a WordPress wp-admin admin menu for your component under the
 * "BuddyPress" menu.
 */
function bp_ktr_add_admin_menu() {
	global $bp;

	//if ( !is_super_admin() )		return false;
	
	$cap = 'access_s2member_ccap_translator'; //With this capability any user can be admin(for this plugin only!)

	require ( dirname( __FILE__ ) . '/bp-ktr-admin.php' );
        
    add_menu_page(__('Translator','ktr-settings-menu'), __('Translator','menu-set'), $cap, 'ktr-order-view', 'ktr_admin_order_view' );
    add_submenu_page('ktr-order-view', __('View Orders','ktr-order-view'), __('View Orders','ktr-order-view'), $cap, 'ktr-order-view', 'ktr_admin_order_view');
    add_submenu_page('ktr-order-view', __('General Settings','ktr-settings-menu'), __('General Settings ','ktr-settings-menu'), $cap, 'ktr-settings-menu', 'ktr_settings_page');
   
   

     //add_menu_page(__('ktr_settings_menu','kite_oerder_setting'), __('Kite Mail Setting','menu-setting'), true, 'kite_oerder_setting', 'kite_mail_setting' );
    add_submenu_page('ktr-order-view', __('Language & Price','ktr-language-setting'), __('Language & Price ','ktr-language-setting'), $cap, 'ktr-language-setting', 'ktr_language_price_setting');
    add_submenu_page('ktr-order-view', __('Translation Type','ktr-file-type-setting'), __('Translation Type','ktr-file-type-setting'), $cap, 'ktr-file-type-setting', 'ktr_file_setting');
    add_submenu_page('ktr-order-view', __('Translators','ktr-translators-setting'), __('Translators','ktr-translators-setting'), $cap, 'ktr-translators-setting', 'translator_setting');
	add_submenu_page('ktr-order-view', __('Emails','ktr-emails-setting'), __('Emails','ktr-emails-setting'), $cap, 'ktr-emails-setting', 'emails_setting');
	add_submenu_page('ktr-order-view', __('Specialisations','ktr-specialisations-setting'), __('Specialisations','ktr-specialisations-setting'), $cap, 'ktr-specialisations-setting', 'specialisations_setting');
  
	
	//Pages without menu
	add_submenu_page( null, 'Send files', 'Send files', $cap, 'send_files', 'z_send_files' );


}
// The admin menu should be added to the Network Admin screen when Multisite is enabled
add_action( is_multisite() ? 'network_admin_menu' : 'admin_menu', 'bp_ktr_add_admin_menu' );

/**
 * bp_ktr_setup_nav()
 *
 * Sets up the user profile navigation items for the component. This adds the top level nav
 * item and all the sub level nav items to the navigation array. This is then
 * rendered in the template.
 */

function get_editor_task(){
    global $bp;
    global $wpdb;
    $table=$wpdb->prefix.KTR_TRANSLATING_DETAIL_TABLE;
    $user=wp_get_current_user(); 
    $u_id=$user->ID;
    $q="SELECT * FROM $table where ktr_id=".$u_id ." order by ktr_detail_id desc";
    return $wpdb->get_results($wpdb->prepare($q, ''));
}
function is_editor(){
    global $bp;
    global $wpdb;
  
        $user=wp_get_current_user(); 
        $user = new WP_User( $user->ID );
       $user->roles[0];
        if($user->roles[0]=='editor'){
            return true;
        }else{
            return false;
        }
   
}


function bp_ktr_setup_nav() {
	global $bp;
     

	/* Add 'Example' to the main user profile navigation */
        if(is_editor()==true){
              if(is_user_logged_in()):
                        bp_core_new_nav_item( array(
                        'name' => __( 'My Projects', 'bp-ktr' ),
                        'slug' => $bp->ktr->slug.'',
                        'position' => 80,
                        'screen_function' => 'bp_ktr_view_tasks',
                        'default_subnav_slug' => 'my-task',
                        'user_has_access' => bp_is_my_profile() 
                ) );
               endif; 
               
               
                 $ktr_link = $bp->loggedin_user->domain . $bp->ktr->slug . '/';

                /* Create two sub nav items for this component */

                bp_core_new_subnav_item( array(
                        'name' => __( 'My projects', 'bp-ktr' ),
                        'slug' => 'my-task',
                        'parent_slug' => $bp->ktr->slug,
                        'parent_url' => $ktr_link,
                        'screen_function' => 'bp_ktr_view_tasks',
                        'position' => 10,
                        'user_has_access' => bp_is_my_profile() 
                ) );
                      $ktr_link = $bp->loggedin_user->domain . $bp->ktr->slug . '/';

                /* Create two sub nav items for this component */

                bp_core_new_subnav_item( array(
                        'name' => __( 'My Availability', 'bp-ktr' ),
                        'slug' => 'my-settings',
                        'parent_slug' => $bp->ktr->slug,
                        'parent_url' => $ktr_link,
                        'screen_function' => 'bp_ktr_my_settings',
                        'position' => 10,
                        'user_has_access' => bp_is_my_profile() 
                ) );
				
				bp_core_new_subnav_item( array(
                        'name' => __( 'My specialisations', 'bp-ktr' ),
                        'slug' => 'my-specialisations',
                        'parent_slug' => $bp->ktr->slug,
                        'parent_url' => $ktr_link,
                        'screen_function' => 'bp_ktr_my_specialisations',
                        'position' => 10,
                        'user_has_access' => bp_is_my_profile() 
                ) );
        }else{
           
               if(is_user_logged_in()):
                bp_core_new_nav_item( array(
                        'name' => __( 'My Translation', 'bp-ktr' ),
                        'slug' => $bp->ktr->slug,
                        'position' => 80,
                        'screen_function' => 'bp_ktr_view_orders',
                        'default_subnav_slug' => 'view-orders',
                        'user_has_access' => bp_is_my_profile() 
                ) );
               endif;

                $ktr_link = $bp->loggedin_user->domain . $bp->ktr->slug . '/';

                /* Create two sub nav items for this component */

                bp_core_new_subnav_item( array(
                        'name' => __( 'View Orders', 'bp-ktr' ),
                        'slug' => 'view-orders',
                        'parent_slug' => $bp->ktr->slug,
                        'parent_url' => $ktr_link,
                        'screen_function' => 'bp_ktr_view_orders',
                        'position' => 10,
                        'user_has_access' => bp_is_my_profile() 
                ) );
        
        }
		
		//Paypal payment successful page
		$ktr_link = $bp->loggedin_user->domain . $bp->ktr->slug . '/';
		bp_core_new_subnav_item( array(
				'name' => '&zwnj;',
				'slug' => 'paypal-success',
				'parent_slug' => $bp->ktr->slug,
				'parent_url' => $ktr_link,
				'screen_function' => 'bp_ktr_paypal_success'
		) );
		
//	bp_core_new_subnav_item( array(
//		'name' => __( 'New Orders', 'bp-ktr' ),
//		'slug' => 'screen-two',
//		'parent_slug' => $bp->ktr->slug,
//		'parent_url' => $ktr_link,
//		'screen_function' => 'bp_ktr_screen_two',
//		'position' => 20,
//		'user_has_access' => bp_is_my_profile() // Only the logged in user can access this on his/her profile
//	));

	/* Add a nav item for this component under the settings nav item. See bp_ktr_screen_settings_menu() for more info */

}
add_action( 'bp_setup_nav', 'bp_ktr_setup_nav' );


/**
 * bp_ktr_load_template_filter()
 *
 * You can define a custom load template filter for your component. This will allow
 * you to store and load template files from your plugin directory.
 *
 * This will also allow users to override these templates in their active theme and
 * replace the ones that are stored in the plugin directory.
 *
 * If you're not interested in using template files, then you don't need this function.
 *
 * This will become clearer in the function bp_ktr_screen_one() when you want to load
 * a template file.
 */
function bp_ktr_load_template_filter( $found_template, $templates ) {
	global $bp;

	/**
	 * Only filter the template location when we're on the ktr component pages.
	 */
	if ( $bp->current_component != $bp->ktr->slug )
		return $found_template;

	foreach ( (array) $templates as $template ) {
		if ( file_exists( STYLESHEETPATH . '/' . $template ) )
			$filtered_templates[] = STYLESHEETPATH . '/' . $template;
		else
			$filtered_templates[] = dirname( __FILE__ ) . '/templates/' . $template;
	}

	$found_template = $filtered_templates[0];

	return apply_filters( 'bp_ktr_load_template_filter', $found_template );
}
add_filter( 'bp_located_template', 'bp_ktr_load_template_filter', 10, 2 );


/********************************************************************************
 * Screen Functions
 *
 * Screen functions are the controllers of BuddyPress. They will execute when their
 * specific URL is caught. They will first save or manipulate data using business
 * functions, then pass on the user to a template file.
 */

/**
 * bp_ktr_screen_one()
 *
 * Sets up and displays the screen output for the sub nav item "ktr/view-orders"
 *
 */
function bp_ktr_upload_path(){
	if ( bp_core_is_multisite() )
		$path = ABSPATH . get_blog_option( BP_ROOT_BLOG, 'upload_path' );
	else {
		$upload_path = get_option( 'upload_path' );
		$upload_path = trim($upload_path);
		if ( empty($upload_path) || '/wp-content/uploads' == $upload_path) {
			$path = WP_CONTENT_DIR . '/uploads';
		} else {
			$path = $upload_path;
			if ( 0 !== strpos($path, ABSPATH) ) {
				// $dir is absolute, $upload_path is (maybe) relative to ABSPATH
				$path = path_join( ABSPATH, $path );
			}
		}
	}

	 $path .= '/packege';

	return apply_filters( 'bp_ktr_upload_path', $path );

}

 function bp_ktr_screen_abc(){

        do_action( 'bp_ktr_screen_abc' );
 bp_ktr_add_upload_notification();
	add_action( 'bp_template_title', 'bp_ktr_screen_abc_title' );

	add_action( 'bp_template_content', 'bp_ktr_screen_abc_content' );

	/* Finally load the plugin template file. */
	bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
 }

function bp_ktr_action_upload() {

	global $bp;

	if ( $bp->current_component == 'album' && $bp->ktr->upload == $bp->current_action && isset( $_POST['submit'] )) {

		check_admin_referer('bp-examle-upload');

		$error_flag = false;
		$feedback_message = array();

		// check privacy
		if( !isset($_POST['privacy']) ){
			$error_flag = true;
			$feedback_message[] = __( 'Please select a privacy option.', 'bp-album' );

		} else {

			$priv_lvl = intval($_POST['privacy']);

		}

		$uploadErrors = array(
			0 => __("There is no error, the file uploaded with success", 'bp-album'),
			1 => __("Your image was bigger than the maximum allowed file size of: ", 'bp-album') . size_format(CORE_MAX_FILE_SIZE),
			2 => __("Your image was bigger than the maximum allowed file size of: ", 'bp-album') . size_format(CORE_MAX_FILE_SIZE),
			3 => __("The uploaded file was only partially uploaded", 'bp-album'),
			4 => __("No file was uploaded", 'bp-album'),
			6 => __("Missing a temporary folder", 'bp-album')
		);

                
		if ( isset($_FILES['file']) ){

			if ( $_FILES['file']['error'] ) {

				$feedback_message[] = sprintf( __( 'Your upload failed, please try again. Error was: %s', 'bp-album' ), $uploadErrors[$_FILES['file']['error']] );
				$error_flag = true;

			}
			elseif ( $_FILES['file']['size'] > BP_AVATAR_ORIGINAL_MAX_FILESIZE ) {

				$feedback_message[] = sprintf( __( 'The file you uploaded is too big. Please upload a file under %s', 'bp-album'), size_format(CORE_MAX_FILE_SIZE) );
				$error_flag = true;

			}
			// Check the file has the correct extension type. Copied from bp_core_check_avatar_type() and modified with /i so that the
			// regex patterns are case insensitive (otherwise .JPG .GIF and .PNG would trigger an error)


			elseif ( (!empty( $_FILES['file']['type'] ) && preg_match('/(jpe?g|gif|png)$/i', $_FILES['file']['type'] ) ) || preg_match( '/(jpe?g|gif|png)$/i', $_FILES['file']['name'] ) ) {

				$feedback_message[] = __( 'Please upload without JPG, GIF or PNG image files.', 'bp-album' );
				$error_flag = true;
			}

		}
		else {
			$feedback_message[] = sprintf( __( 'Your upload failed, please try again. Error was: %s', 'bp-album' ), $uploadErrors[4] );
			$error_flag = true;

		}

		if(!$error_flag){  // If everything is ok handle the upload and move to the directory

			add_filter( 'upload_dir', 'bp_ktr_upload_dir', 10, 0 ); //the upload handle get the upload dir from this filter

			$pic_org = wp_handle_upload( $_FILES['file'],array('action'=>'upload_lib_doc') );

			if ( !empty( $pic_org['error'] ) ) {
				$feedback_message[] = sprintf( __('Your upload failed, please try again. Error was: %s', 'bp-album' ), $pic_org['error'] );
				$error_flag = true;
			}
		}
		if(!$error_flag){

			// Handle blog upload directories

			if( !is_multisite() ){

			    	// Some site owners with single-blog installs of wordpress change the path of
				// their upload directory by setting the constant 'BLOGUPLOADDIR'. Handle this
				// for compatibility with legacy sites.

				if( defined( 'BLOGUPLOADDIR' ) ){

					$abs_path_to_files = str_replace('/files/','/',BLOGUPLOADDIR);
				}
				else {

					$abs_path_to_files = ABSPATH;
				}

			}
			else {

				// If the install is running in multisite mode, 'BLOGUPLOADDIR' is automatically set by
				// wordpress to something like "C:\xampp\htdocs/wp-content/blogs.dir/1/" even though the
				// actual file is in "C:\xampp\htdocs/wp-content/uploads/", so we need to use ABSPATH

				$abs_path_to_files = ABSPATH;
			}

			$pic_org_path = $pic_org['file'];
			$pic_org_url = str_replace($abs_path_to_files,'/',$pic_org_path);

			  $owner_type = 'user';
                       // echo " Owner Type<br/>";
			  $owner_id = $bp->loggedin_user->id;
                       // echo " Owner Id<br/>";
			  $date_uploaded =  gmdate( "Y-m-d H:i:s" );
                       // echo "<br/>";
			  $title = $_FILES['file']['name'];
                       // echo " Title <br/>";
			  $description = ' ';
                      //  echo "Description <br/>";
			  $privacy = $priv_lvl;
                   

			$id=bp_ktr_add_file($owner_type,$owner_id,$title,$description,$priv_lvl,$date_uploaded,$pic_org_url,$pic_org_path);

				    if($id)
					    $feedback_message[] = __('Library Document uploaded.', 'bp-ktr');
				    else {
					    $error_flag = true;
					    $feedback_message[] = __('There were problems saving picture details.', 'bp-ktr');
			}
		}

		if ($error_flag){
			bp_core_add_message( implode('&nbsp;', $feedback_message ),'error');
		} else {
                   
			bp_core_add_message( implode('&nbsp;', $feedback_message ),'success' );
                       //echo $bp->loggedin_user->domain . $bp->current_component . '/'.$bp->ktr->upload.'/';
			//bp_core_redirect( $bp->loggedin_user->domain . $bp->current_component . '/'.$bp->album->single_slug.'/' . $id.'/'.$bp->ktr->upload.'/');
                        bp_core_redirect( $bp->loggedin_user->domain . $bp->current_component . '/'.$bp->ktr->upload.'/');
			die;
		}

	}

}
add_action('wp','bp_ktr_action_upload',3);



function bp_ktr_upload_dir() {
	global $bp;

	$user_id = $bp->loggedin_user->id;

	$dir = BP_KTR_UPLOAD_PATH;

	$siteurl = trailingslashit( get_blog_option( 1, 'siteurl' ) );
	$url = str_replace(ABSPATH,$siteurl,$dir);

	$bdir = $dir;
	$burl = $url;

	$subdir = '/' . $user_id;

	$dir .= $subdir;
	$url .= $subdir;

	if ( !file_exists( $dir ) )
		@wp_mkdir_p( $dir );

	return apply_filters( 'bp_ktr_upload_dir', array( 'path' => $dir, 'url' => $url, 'subdir' => $subdir, 'basedir' => $bdir, 'baseurl' => $burl, 'error' => false ) );

}
function bp_ktr_get_upload_item($args=''){
   
    return array("items"=>bp_ktr_get_items($args),"total"=>bp_ktr_get_item_count($args));
}
function bp_ktr_get_items($args = ''){
    BP_Example_TableName::query_pictures($args);
	return BP_Example_TableName::query_pictures($args);
}

function bp_ktr_get_item_count($args = ''){
    BP_Example_TableName::query_pictures($args,true);
	return BP_Example_TableName::query_pictures($args,true);
}



 function bp_ktr_screen_abc_title() {
		?><h4><?php _e( 'Packege List', 'bp-ktr' ) ?></h4><?php
	}

function bp_ktr_screen_abc_content($ajax='') {
		global $bp;

?>

<?php if ( bp_ktr_has_items('',$ajax) ) : ?>
                <?php wp_enqueue_script('jquery'); ?>
   

<div class="picture-pagination">
        <?php bp_ktr_item_pagination(); ?>
</div>
<div class="picture-gallery">
    <?php upload_galary_ktr() ?>
</div>
<?php else : ?>

        <div id="message" class="info">
                <p><?php echo bp_word_or_name( __('No document is found here, show something to the community!', 'bp-album' ), __( "Either %s hasn't uploaded any document yet or they have restricted access", 'bp-album' )  ,false,false) ?></p>
        </div>

        <?php endif; ?>



<?php if ( $bp->displayed_user->id == $bp->loggedin_user->id ) {?>
                <div><h4>Upload File</h4></div>
		

                <form class="standard-form" action="http://localhost/proj/avenue/members/admin/album/upload-lib-doc/" id="bp-album-upload-form" name="bp-album-upload-form" enctype="multipart/form-data" method="post">

            <input type="hidden" value="CORE_MAX_FILE_SIZE" name="MAX_FILE_SIZE">
            <input type="hidden" value="upload_lib_doc" name="action">

            <p>
                <label>Select Picture to Upload *<br>
                <input type="file" id="file" name="file"></label>
            </p>
            <p style="display: none;">
                <label>Visibility</label>


				<label><input type="radio" checked="checked" value="0" name="privacy">Public</label>


				<label><input type="radio" value="2" name="privacy">Registered members</label>


				<label><input type="radio" value="4" name="privacy">Only friends</label>


				<label><input type="radio" value="6" name="privacy">Private</label>

				            </p>
                                <input type="submit" value="Upload picture" id="submit" name="submit" style="display: inline;">

			<input type="hidden" value="/proj/avenue/members/admin/album/upload-lib-doc/" name="_wp_http_referer">
                        <?php wp_nonce_field('bp-examle-upload') ?>
                </form>
                <div id="message" class="info">
                    <div id="kite_album_edt_msg" class="kite_msg">   <?php do_action( 'template_notices' ) ?>   </div>
                </div>
               
	<?php }
	}

function upload_galary_ktr(){
     while ( bp_ktr_items() ) : bp_ktr_the_item(); ?>

        <div class="picture-thumb-box">
            <!--<a href="<?php bp_album_picture_thumb_url() ?>" class="picture-thumb"><?php bp_album_picture_thumb_url() ?></a>-->
            <a href="<?php bp_ktr_item_org_path()  ?>"  class="picture-title"><?php bp_ktr_item_title_truncate() ?></a>
             <?php if ( $bp->displayed_user->id == $bp->loggedin_user->id ) { ?>
    <div><a href="#" >Delete</a></div>
    <?php }?>
        </div>

    <?php endwhile;
}
function bp_ktr_add_file($owner_type,$owner_id,$title,$description,$priv_lvl,$date_uploaded,$pic_org_url,$pic_org_path){
	global $bp;

	$lib = new BP_Example_TableName();

	$lib->owner_type = $owner_type;

	// Filters have to be applied *here*, not in the database class. Otherwise they get run on
	// data that has already been filtered, corrupting the db. Since filtered data is stored in
	// the db, we also have to run the filters on submitted values before comparing them against
	// the db, to determine if the data needs to be updated.

	$title = esc_attr( strip_tags($title) );
	$description = esc_attr( strip_tags($description) );

	//$title = apply_filters( 'bp_ktr_title_before_save', $title );
	//$description = apply_filters( 'bp_ktr_description_before_save', $description);

	$lib->user_id = $owner_id;
	$lib->title = $title;
	$lib->description = $description;
	$lib->privacy = $priv_lvl;
	$lib->date_uploaded = $date_uploaded;
	$lib->pic_org_url = $pic_org_url;
	$lib->pic_org_path = $pic_org_path;


    return $lib->save() ? $lib->id : false;

}
function bp_ktr_view_task_title() {
		_e( 'Screen One', 'bp-ktr' );
	}
        
        
        
	function bp_ktr_view_task_content() {
		global $bp;

		$high_fives = bp_ktr_get_highfives_for_user( $bp->displayed_user->id );

		/**
		 * For security reasons, we MUST use the wp_nonce_url() function on any actions.
		 * This will stop naughty people from tricking users into performing actions without their
		 * knowledge or intent.
		 */
		$send_link = wp_nonce_url( $bp->displayed_user->domain . $bp->current_component . '/view-orders/send-h5', 'bp_ktr_send_high_five' );
	?>
		<h4><?php _e( 'Welcome to Screen One', 'bp-ktr' ) ?></h4>
		<p><?php printf( __( 'Send %s a <a href="%s" title="Send high-five!">high-five!</a>', 'bp-ktr' ), $bp->displayed_user->fullname, $send_link ) ?></p>

		<?php if ( $high_fives ) : ?>
			<h4><?php _e( 'Received High Fives!', 'bp-ktr' ) ?></h4>

			<table id="high-fives">
				<?php foreach ( $high_fives as $user_id ) : ?>
				<tr>
					<td width="1%"><?php echo bp_core_fetch_avatar( array( 'item_id' => $user_id, 'width' => 25, 'height' => 25 ) ) ?></td>
					<td>&nbsp; <?php echo bp_core_get_userlink( $user_id ) ?></td>
	 			</tr>
				<?php endforeach; ?>
			</table>
		<?php endif; ?>
	<?php
	}
function bp_ktr_view_tasks() {
	global $bp, $comments;
	
	if($_REQUEST['ktr_translator_upload']){
        if(is_dir ("./".$upload_dir['baseurl'].DS.KTR_ROOT_DIRECTORY.DS.KTR_TRANSLATED_FILE_DIRECTORY.DS)){
			$oldumask = umask(0);
			echo $upload_dir['baseurl'].DS.KTR_ROOT_DIRECTORY.DS.KTR_TRANSLATED_FILE_DIRECTORY.DS.'50';
			mkdir($upload_dir['baseurl'].DS.'50', 0777); // or even 01777 so you get the sticky bit set
			umask($oldumask);
        }

    }
	
	$order_id = $bp->action_variables[0];
	$comments = bp_ktr_get_comments($order_id); 
	if($_REQUEST['send_comment']){		
		bp_ktr_post_comment($order_id);
	}
	
	do_action( 'bp_ktr_view_tasks' );
	add_action( 'bp_template_title', 'bp_ktr_view_task_title' );
	add_action( 'bp_template_content', 'bp_ktr_view_task_content' );
	
	wp_enqueue_script('jquery.datepick', plugins_url( '/'.PLUGIN_NAME.'/includes/js/jquery.datepick.js'));
	wp_enqueue_style('jquery.datepick',plugins_url( '/'.PLUGIN_NAME.'/includes/style/jquery.datepick.css' ));
	
	bp_core_load_template( apply_filters( 'bp_ktr_template_ktr_view_tasks', 'ktr/view-task' ) );
       


}

function bp_ktr_my_settings_title(){
    _e( 'My Availability', 'bp-ktr' );
}
function bp_ktr_my_settings_ontent(){
    	global $bp;

}
function bp_ktr_my_settings(){
    global $bp;

	do_action( 'bp_ktr_my_settings' );
	add_action( 'bp_template_title', 'bp_ktr_my_settings_title' );
	add_action( 'bp_template_content', 'bp_ktr_my_settings_ontent' );
	
	wp_enqueue_script('jquery.datepick', plugins_url( '/'.PLUGIN_NAME.'/includes/js/jquery.datepick.js'));
	wp_enqueue_style('jquery.datepick',plugins_url( '/'.PLUGIN_NAME.'/includes/style/jquery.datepick.css' ));
	
	bp_core_load_template( apply_filters( 'bp_ktr_template_ktr_editor_settings', 'ktr/my-settings' ) );
}


function bp_ktr_my_specialisations(){
    global $bp;

	do_action( 'bp_ktr_my_specialisations' );
	add_action( 'bp_template_title', 'My specialisation' );
	//add_action( 'bp_template_content', 'bp_ktr_my_settings_ontent' );
	
	bp_core_load_template( apply_filters( 'bp_ktr_template_ktr_specialisations', 'ktr/my-specialisations' ) );
}



//Get translator language pairs
function bp_ktr_get_t_langs($default_user_id){
    global $wpdb;
	
	$table = $wpdb->prefix.KTR_TRANSLATOR_INFO_TABLE;
	$table_lang = $wpdb->prefix.KTR_LANGUAGE_TABLE;
	$sql   = "SELECT l.* from $table AS t 
				LEFT JOIN $table_lang AS l ON l.ktr_laguage_id = t.value
				WHERE t.default_user_id = '{$default_user_id}' AND t.name = 'language'";
	$rows  = $wpdb->get_results($sql);
	
	$languages = '';
	$l_la=1;
	foreach($rows as $r){
		$languages .= "<span class='ktr_span_ajax'>".$l_la.". ".$r->ktr_trnslt_from.'-'.$r->ktr_trnslt_to."</span>";
		$l_la++;
	}
		
	return $languages;
}

//Get translator status
function bp_ktr_get_t_status($default_user_id){
	global $wpdb;
	
	$table = $wpdb->prefix.KTR_TRANSLATOR_INFO_TABLE;
	$sql   = "SELECT * from $table WHERE default_user_id = '{$default_user_id}'";
	$rows  = $wpdb->get_results($sql);
	foreach($rows as $r){
		$params->{$r->name} = $r->value;
	}	

	if($params->status == 1){
		if(isset($params->unavailability_period)){
			$start_date = strtr(strtok($params->unavailability_period, " - "), '/', '-');
			$end_date   = strtr(strtok(" - "), '/', '-');
			
			// Convert to timestamp
			$start_ts = strtotime($start_date); 
			$end_ts = strtotime($end_date);
			$now_ts = time();

			// Check that today is between start & end
			if(($now_ts >= $start_ts) && ($now_ts <= $end_ts)){
				$status="Not Available, Available from ".date("d/m/Y", strtotime($end_date)+3600);
			}else{
				$status="Available"; //Available today
			}

		}else{
			$status="Available";
		}
	}else{
		$status="Not Available";
	}

	return 	$status;
}



//Get comments for a particular order
function bp_ktr_get_comments($order_id){
	global $wpdb;
	
	$commentsTable = $wpdb->prefix.KTR_COMMENTS_TABLE;
	$usersTable = $wpdb->prefix.'users';
	$sql   = $wpdb->prepare("SELECT c.*, u.user_nicename AS sender 
		FROM $commentsTable AS c, $usersTable AS u 
		WHERE c.order_id = '%s' AND c.sender_id = u.id
		ORDER BY c.date", $order_id);
	return $wpdb->get_results($sql);
	
}

function bp_ktr_post_comment($order_id){
	//print_r($_REQUEST['comment']);
	global $wpdb;
		
	$current_user = wp_get_current_user();
	
	$wpdb->insert( 
		$wpdb->prefix.KTR_COMMENTS_TABLE, 
		array( 
			'order_id' => $order_id, 
			'sender_id' => $current_user->ID, 
			'comment' => $_REQUEST['comment'], 
			'approved' => ( $current_user->has_cap(ADMIN_CAP) ? 1 : 0 )
		), 
		array( 
			'%d', '%d', '%s', '%d'  
		) 
	);
	$lastid = $wpdb->insert_id;
	
	if( !$current_user->has_cap(ADMIN_CAP) ){ //Not admin	
		$admin_email = get_bloginfo( ' admin_email' );
		$headers_admin = 'From: '. get_bloginfo( $show, 'display' ).' <noreply@mydomain.com>' . "\r\n";
		$subject_admin = 'A new comment is posted'. "\r\n";
		$message_admin = '<p><b>'.$current_user->user_login.'</b> posted a new comment.</p><p>Order ID:<b>'.$order_id.'</b>';
		add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
		wp_mail($admin_email, $subject_admin, $message_admin, $headers_admin);
		
		$_SESSION['msg'] = 'Your comment is sent, but not visible yet. Please wait for admin approval.';
	}else{
		$_SESSION['msg'] = 'Your comment is sent..';
		
		bp_ktr_comment_email($lastid);  //Send email to users involved
	}
}

//Send email to the other parties when comment is sent/approved
function bp_ktr_comment_email($comment_id){
	global $wpdb;
	
	$target_users = array(); //Users that will get this email
	
	//Get comment and sender
	$commentsTable = $wpdb->prefix.KTR_COMMENTS_TABLE;
	$usersTable = $wpdb->prefix.'users';
	$sql   = $wpdb->prepare("SELECT c.*, u.user_nicename AS sender_username,   u.user_email
		FROM $commentsTable AS c, $usersTable AS u 
		WHERE c.id = '%s' AND c.sender_id = u.id", $comment_id);
	$comment = $wpdb->get_row($sql);
	
	//Get the order author
	$table1 = $wpdb->prefix.KTR_ORDER_INFO_TABLE;
	$sql = "SELECT t1.ktr_order_from AS user_id, u.user_nicename AS username, u.user_email 
		FROM $table1 AS t1, $usersTable AS u  
		WHERE t1.ktr_order_id ='".$order_id."' AND t1.ktr_order_from = u.id";
	$author = $wpdb->get_row($sql);
	if($author->user_id != $comment->sender_id){
		$target_users[]= $author;
	}
	
	//Get translators
	$table_translaing_info = $wpdb->prefix.KTR_TRANSLATING_DETAIL_TABLE;
	$sql = "SELECT t1.ktr_id AS user_id, u.user_nicename AS username, u.user_email
		FROM $table_translaing_info AS t1, $usersTable AS u  
		WHERE t1.ktr_translator_id ='%s' AND t1.ktr_id = u.id";
	$results = $wpdb->get_results($wpdb->prepare($sql, $order_id));
	foreach($results as $r){
        if($r->user_id != $comment->sender_id){
			$target_users[]= $r;
		}
	}
	
	if($target_users){
		foreach($target_users as $tu){
			$headers  = 'From: '. get_bloginfo( $show, 'display' ).' <noreply@mydomain.com>' . "\r\n";
			$subject  = 'A new comment has been added, order nb: ' . $comment->order_id . "\r\n";
			$message  = "Dear {$tu->username}, \r\n\r\n";
			$message .= "<p>The following comment has been added to your translation:</p> \r\n\r\n";
			$message .= $comment->comment . "\r\n"; 
			add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
			wp_mail($tu->user_email, $subject, $message, $headers);
		}
	}
}


//Send email to customer
function bp_ktr_send_email($to, $body, $cc = '', $reply_to =''){
	//print_r($_REQUEST['comment']);
	global $wpdb, $_SESSION;
		
	$current_user = wp_get_current_user();
	
	if( $current_user->has_cap(ADMIN_CAP) ){ //Not admin	
		//$admin_email = get_bloginfo( ' admin_email' );
		$headers = 'From: '. get_bloginfo( $show, 'display' ).' <noreply@mydomain.com>'. "\r\n";
		if($cc) $headers.= 'Cc: ' . $cc . "\r\n";
		if($reply_to) $headers.= 'Reply-to: ' . $reply_to . "\r\n";
		$subject = 'Email from admin'. "\r\n";
		add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
		wp_mail($to, $subject, stripslashes($body), $headers);
		
		$_SESSION['msg'] = 'Mail sent successfully.';
	}
}



//Send email to translator with files  once client uploads them
function bp_ktr_send_translator_email($order_id, $to, $body, $cc = '', $reply_to =''){
	//print_r($_REQUEST['comment']);
	global $wpdb;
		
	$current_user = wp_get_current_user();	
	if( $current_user->has_cap(ADMIN_CAP) ){ //Admin	
		//Prepare attachements for the order
		$attachments = array();
		$ordersTable = $wpdb->prefix.KTR_ORDER_INFO_TABLE;
		$filesTable  = $wpdb->prefix.KTR_ORDERED_FILE_URL_TABLE;
		$filesSql    = 	"SELECT f.* FROM $filesTable AS f, $ordersTable AS o
							WHERE f.ktr_id = o.ktr_id AND o.ktr_order_id = '%s'";
		$rows 		 = $wpdb->get_results($wpdb->prepare( $filesSql, $order_id ));
		foreach($rows as $r){
			$attachments[]= WP_CONTENT_DIR . str_replace('wp-content','',$r->ktr_ordf_url);
		}
		
		//$admin_email = get_bloginfo( ' admin_email' );
		$headers = 'From: '. get_bloginfo( $show, 'display' ).' <noreply@mydomain.com>' . "\r\n";
		if($cc) $headers.= 'Cc: ' . $cc . "\r\n";
		if($reply_to) $headers.= 'Reply-to: ' . $reply_to . "\r\n";
		$subject = 'Email from admin'. "\r\n";
		add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
		wp_mail($to, $subject, $body, $headers, $attachments);
		
		$_SESSION['msg'] = 'Mail sent successfully.';
	}
}






function bp_ktr_view_orders() {
	global $bp, $comments;

	/**
	 * There are three global variables that you should know about and you will
	 * find yourself using often.
	 *
	 * $bp->current_component (string)
	 * This will tell you the current component the user is viewing.
	 *
	 * Example: If the user was on the page http://ktr.org/members/andy/groups/my-groups
	 *          $bp->current_component would equal 'groups'.
	 *
	 * $bp->current_action (string)
	 * This will tell you the current action the user is carrying out within a component.
	 *
	 * Example: If the user was on the page: http://ktr.org/members/andy/groups/leave/34
	 *          $bp->current_action would equal 'leave'.
	 *
	 * $bp->action_variables (array)
	 * This will tell you which action variables are set for a specific action
	 *
	 * Example: If the user was on the page: http://ktr.org/members/andy/groups/join/34
	 *          $bp->action_variables would equal array( '34' );
	 */

	/**
	 * On this screen, as a quick ktr, users can send you a "High Five", by clicking a link.
	 * When a user sends you a high five, you receive a new notification in your
	 * notifications menu, and you will also be notified via email.
	 */

	/**
	 * We need to run a check to see if the current user has clicked on the 'send high five' link.
	 * If they have, then let's send the five, and redirect back with a nice error/success message.
	 */
        
		
	$order_id = $bp->action_variables[0];
	$comments = bp_ktr_get_comments($order_id); 
	if($_REQUEST['send_comment']){		
		bp_ktr_post_comment($order_id);
	}	
	

	/* Add a do action here, so your component can be extended by others. */
	do_action( 'bp_ktr_view_orders' );



	add_action( 'bp_template_title', 'bp_ktr_view_orders_title' );
	add_action( 'bp_template_content', 'bp_ktr_view_orders_content' );

	/****
	 * Displaying Content
	 */

	/****
	 * OPTION 1:
	 * You've got a few options for displaying content. Your first option is to bundle template files
	 * with your plugin that will be used to output content.
	 *
	 * In an earlier function bp_ktr_load_template_filter() we set up a filter on the core BP template
	 * loading function that will make it first look in the plugin directory for template files.
	 * If it doesn't find any matching templates it will look in the active theme directory.
	 *
	 * This ktr component comes bundled with a template for screen one, so we can load that
	 * template to display what we need. If you copied this template from the plugin into your theme
	 * then it would load that one instead. This allows users to override templates in their theme.
	 */

	/* This is going to look in wp-content/plugins/[plugin-name]/includes/templates/ first */
        
	bp_core_load_template( apply_filters( 'bp_ktr_template_ktr_view_orders', 'ktr/view-orders' ) );
       

	/****
	 * OPTION 2 (NOT USED FOR THIS SCREEN):
	 * If your component is simple, and you just want to insert some HTML into the user's active theme
	 * then you can use the bundle plugin template.
	 *
	 * There are two actions you need to hook into. One for the title, and one for the content.
	 * The functions you hook these into should simply output the content you want to display on the
	 * page.
	 *
	 * The follow lines are commented out because we are not using this method for this screen.
	 * You'd want to remove the OPTION 1 parts above and uncomment these lines if you want to use
	 * this option instead.
	 *
	 * Generally, this method of adding content is preferred, as it makes your plugin
	 * work better with a wider variety of themes.
 	 */

//	add_action( 'bp_template_title', 'bp_ktr_screen_one_title' );
//	add_action( 'bp_template_content', 'bp_ktr_screen_one_content' );

//	bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}
	/***
	 * The second argument of each of the above add_action() calls is a function that will
	 * display the corresponding information. The functions are presented below:
	 */
	function bp_ktr_view_orders_title() {
		_e( 'Screen One', 'bp-ktr' );
	}

	function bp_ktr_view_orders_content() {
		global $bp;

		$high_fives = bp_ktr_get_highfives_for_user( $bp->displayed_user->id );

		/**
		 * For security reasons, we MUST use the wp_nonce_url() function on any actions.
		 * This will stop naughty people from tricking users into performing actions without their
		 * knowledge or intent.
		 */
		$send_link = wp_nonce_url( $bp->displayed_user->domain . $bp->current_component . '/view-orders/send-h5', 'bp_ktr_send_high_five' );
	?>
		<h4><?php _e( 'Welcome to Screen One', 'bp-ktr' ) ?></h4>
		<p><?php printf( __( 'Send %s a <a href="%s" title="Send high-five!">high-five!</a>', 'bp-ktr' ), $bp->displayed_user->fullname, $send_link ) ?></p>

		<?php if ( $high_fives ) : ?>
			<h4><?php _e( 'Received High Fives!', 'bp-ktr' ) ?></h4>

			<table id="high-fives">
				<?php foreach ( $high_fives as $user_id ) : ?>
				<tr>
					<td width="1%"><?php echo bp_core_fetch_avatar( array( 'item_id' => $user_id, 'width' => 25, 'height' => 25 ) ) ?></td>
					<td>&nbsp; <?php echo bp_core_get_userlink( $user_id ) ?></td>
	 			</tr>
				<?php endforeach; ?>
			</table>
		<?php endif; ?>
	<?php
	}

/**
 * bp_ktr_screen_two()
 *
 * Sets up and displays the screen output for the sub nav item "ktr/screen-two"
 */
function bp_ktr_screen_two() {
	global $bp;

	/**
	 * On the output for this second screen, as an ktr, there are terms and conditions with an
	 * "Accept" link (directs to http://ktr.org/members/andy/ktr/screen-two/accept)
	 * and a "Reject" link (directs to http://ktr.org/members/andy/ktr/screen-two/reject)
	 */

	if ( $bp->current_component == $bp->ktr->slug && 'screen-two' == $bp->current_action && 'accept' == $bp->action_variables[0] ) {
		if ( bp_ktr_accept_terms() ) {
			/* Add a success message, that will be displayed in the template on the next page load */
			bp_core_add_message( __( 'Terms were accepted!', 'bp-ktr' ) );
		} else {
			/* Add a failure message if there was a problem */
			bp_core_add_message( __( 'Terms could not be accepted.', 'bp-ktr' ), 'error' );
		}

		/**
		 * Now redirect back to the page without any actions set, so the user can't carry out actions multiple times
		 * just by refreshing the browser.
		 */
		bp_core_redirect( $bp->loggedin_user->domain . $bp->current_component );
	}

	if ( $bp->current_component == $bp->ktr->slug && 'screen-two' == $bp->current_action && 'reject' == $bp->action_variables[0] ) {
		if ( bp_ktr_reject_terms() ) {
			/* Add a success message, that will be displayed in the template on the next page load */
			bp_core_add_message( __( 'Terms were rejected!', 'bp-ktr' ) );
		} else {
			/* Add a failure message if there was a problem */
			bp_core_add_message( __( 'Terms could not be rejected.', 'bp-ktr' ), 'error' );
		}

		/**
		 * Now redirect back to the page without any actions set, so the user can't carry out actions multiple times
		 * just by refreshing the browser.
		 */
		bp_core_redirect( $bp->loggedin_user->domain . $bp->current_component );
	}

	/**
	 * If the user has not Accepted or Rejected anything, then the code above will not run,
	 * we can continue and load the template.
	 */
	do_action( 'bp_ktr_screen_two' );

	add_action( 'bp_template_title', 'bp_ktr_screen_two_title' );
	add_action( 'bp_template_content', 'bp_ktr_screen_two_content' );

	/* Finally load the plugin template file. */
	bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}

	function bp_ktr_screen_two_title() {
		_e( 'New Orders', 'bp-ktr' );
	}

	function bp_ktr_screen_two_content() {
           global $bp; ?>

		<h4><?php _e( 'Welcomes to See New Orders', 'bp-ktr' ) ?></h4>

		<?php
			$accept_link = '<a href="' . wp_nonce_url( $bp->loggedin_user->domain . $bp->ktr->slug . '/screen-two/accept', 'bp_ktr_accept_terms' ) . '">' . __( 'Accept', 'bp-ktr' ) . '</a>';
			$reject_link = '<a href="' . wp_nonce_url( $bp->loggedin_user->domain . $bp->ktr->slug . '/screen-two/reject', 'bp_ktr_reject_terms' ) . '">' . __( 'Reject', 'bp-ktr' ) . '</a>';
		?>

		<p><?php printf( __( 'You must %s or %s the terms of use policy.', 'bp-ktr' ), $accept_link, $reject_link ) ?></p>
	<?php
	}
       

function bp_ktr_screen_settings_menu() {
	global $bp, $current_user, $bp_settings_updated, $pass_error;

	if ( isset( $_POST['submit'] ) ) {
		/* Check the nonce */
		check_admin_referer('bp-ktr-admin');

		$bp_settings_updated = true;

		/**
		 * This is when the user has hit the save button on their settings.
		 * The best place to store these settings is in wp_usermeta.
		 */
		update_user_meta( $bp->loggedin_user->id, 'bp-ktr-option-one', attribute_escape( $_POST['bp-ktr-option-one'] ) );
	}

	add_action( 'bp_template_content_header', 'bp_ktr_screen_settings_menu_header' );
	add_action( 'bp_template_title', 'bp_ktr_screen_settings_menu_title' );
	add_action( 'bp_template_content', 'bp_ktr_screen_settings_menu_content' );

	bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}

	function bp_ktr_screen_settings_menu_header() {
		_e( 'Example Settings Header', 'bp-ktr' );
	}

	function bp_ktr_screen_settings_menu_title() {
		_e( 'Example Settings', 'bp-ktr' );
	}

	function bp_ktr_screen_settings_menu_content() {
		global $bp, $bp_settings_updated; ?>

		<?php if ( $bp_settings_updated ) { ?>
			<div id="message" class="updated fade">
				<p><?php _e( 'Changes Saved.', 'bp-ktr' ) ?></p>
			</div>
		<?php } ?>

		<form action="<?php echo $bp->loggedin_user->domain . 'settings/ktr-admin'; ?>" name="bp-ktr-admin-form" id="account-delete-form" class="bp-ktr-admin-form" method="post">

			<input type="checkbox" name="bp-ktr-option-one" id="bp-ktr-option-one" value="1"<?php if ( '1' == get_user_meta( $bp->loggedin_user->id, 'bp-ktr-option-one', true ) ) : ?> checked="checked"<?php endif; ?> /> <?php _e( 'Do you love clicking checkboxes?', 'bp-ktr' ); ?>
			<p class="submit">
				<input type="submit" value="<?php _e( 'Save Settings', 'bp-ktr' ) ?> &raquo;" id="submit" name="submit" />
			</p>

			<?php
			/* This is very important, don't leave it out. */
			wp_nonce_field( 'bp-ktr-admin' );
			?>

		</form>
	<?php
	}


/********************************************************************************
 * Activity & Notification Functions
 *
 * These functions handle the recording, deleting and formatting of activity and
 * notifications for the user and for this specific component.
 */


/**
 * bp_ktr_screen_notification_settings()
 *
 * Adds notification settings for the component, so that a user can turn off email
 * notifications set on specific component actions.
 */
function bp_ktr_screen_notification_settings() {
	global $current_user;

	/**
	 * Under Settings > Notifications within a users profile page they will see
	 * settings to turn off notifications for each component.
	 *
	 * You can plug your custom notification settings into this page, so that when your
	 * component is active, the user will see options to turn off notifications that are
	 * specific to your component.
	 */

	 /**
	  * Each option is stored in a posted array notifications[SETTING_NAME]
	  * When saved, the SETTING_NAME is stored as usermeta for that user.
	  *
	  * For ktr, notifications[notification_friends_friendship_accepted] could be
	  * used like this:
	  *
	  * if ( 'no' == get_user_meta( $bp->displayed_user->id, 'notification_friends_friendship_accepted', true ) )
	  *		// don't send the email notification
	  *	else
	  *		// send the email notification.
      */

	?>
	<table class="notification-settings" id="bp-ktr-notification-settings">
		
		<thead>
		<tr>
			<th class="icon"></th>
			<th class="title"><?php _e( 'Example', 'bp-ktr' ) ?></th>
			<th class="yes"><?php _e( 'Yes', 'bp-ktr' ) ?></th>
			<th class="no"><?php _e( 'No', 'bp-ktr' )?></th>
		</tr>
		</thead>
		
		<tbody>
		<tr>
			<td></td>
			<td><?php _e( 'Action One', 'bp-ktr' ) ?></td>
			<td class="yes"><input type="radio" name="notifications[notification_ktr_action_one]" value="yes" <?php if ( !get_user_meta( $current_user->id, 'notification_ktr_action_one', true ) || 'yes' == get_user_meta( $current_user->id, 'notification_ktr_action_one', true ) ) { ?>checked="checked" <?php } ?>/></td>
			<td class="no"><input type="radio" name="notifications[notification_ktr_action_one]" value="no" <?php if ( get_user_meta( $current_user->id, 'notification_ktr_action_one') == 'no' ) { ?>checked="checked" <?php } ?>/></td>
		</tr>
		<tr>
			<td></td>
			<td><?php _e( 'Action Two', 'bp-ktr' ) ?></td>
			<td class="yes"><input type="radio" name="notifications[notification_ktr_action_two]" value="yes" <?php if ( !get_user_meta( $current_user->id, 'notification_ktr_action_two', true ) || 'yes' == get_user_meta( $current_user->id, 'notification_ktr_action_two', true ) ) { ?>checked="checked" <?php } ?>/></td>
			<td class="no"><input type="radio" name="notifications[notification_ktr_action_two]" value="no" <?php if ( 'no' == get_user_meta( $current_user->id, 'notification_ktr_action_two', true ) ) { ?>checked="checked" <?php } ?>/></td>
		</tr>

		<?php do_action( 'bp_ktr_notification_settings' ); ?>
		
		</tbody>
	</table>
<?php
}
add_action( 'bp_notification_settings', 'bp_ktr_screen_notification_settings' );

/**
 * bp_ktr_record_activity()
 *
 * If the activity stream component is installed, this function will record activity items for your
 * component.
 *
 * You must pass the function an associated array of arguments:
 *
 *     $args = array(
 *	 	 REQUIRED PARAMS
 *		 'action' => For ktr: "Andy high-fived John", "Andy posted a new update".
 *       'type' => The type of action being carried out, for ktr 'new_friendship', 'joined_group'. This should be unique within your component.
 *
 *		 OPTIONAL PARAMS
 *		 'id' => The ID of an existing activity item that you want to update.
 * 		 'content' => The content of your activity, if it has any, for ktr a photo, update content or blog post excerpt.
 *       'component' => The slug of the component.
 *		 'primary_link' => The link for the title of the item when appearing in RSS feeds (defaults to the activity permalink)
 *       'item_id' => The ID of the main piece of data being recorded, for ktr a group_id, user_id, forum_post_id - useful for filtering and deleting later on.
 *		 'user_id' => The ID of the user that this activity is being recorded for. Pass false if it's not for a user.
 *		 'recorded_time' => (optional) The time you want to set as when the activity was carried out (defaults to now)
 *		 'hide_sitewide' => Should this activity item appear on the site wide stream?
 *		 'secondary_item_id' => (optional) If the activity is more complex you may need a second ID. For ktr a group forum post may need the group_id AND the forum_post_id.
 *     )
 *
 * Example usage would be:
 *
 *   bp_ktr_record_activity( array( 'type' => 'new_highfive', 'action' => 'Andy high-fived John', 'user_id' => $bp->loggedin_user->id, 'item_id' => $bp->displayed_user->id ) );
 *
 */
function bp_ktr_record_activity( $args = '' ) {
	global $bp;

	if ( !function_exists( 'bp_activity_add' ) )
		return false;

	$defaults = array(
		'id' => false,
		'user_id' => $bp->loggedin_user->id,
		'action' => '',
		'content' => '',
		'primary_link' => '',
		'component' => $bp->ktr->id,
		'type' => false,
		'item_id' => false,
		'secondary_item_id' => false,
		'recorded_time' => gmdate( "Y-m-d H:i:s" ),
		'hide_sitewide' => false
	);

	$r = wp_parse_args( $args, $defaults );
	extract( $r );

	return bp_activity_add( array( 'id' => $id, 'user_id' => $user_id, 'action' => $action, 'content' => $content, 'primary_link' => $primary_link, 'component' => $component, 'type' => $type, 'item_id' => $item_id, 'secondary_item_id' => $secondary_item_id, 'recorded_time' => $recorded_time, 'hide_sitewide' => $hide_sitewide ) );
}

/**
 * bp_ktr_format_notifications()
 *
 * The format notification function will take DB entries for notifications and format them
 * so that they can be displayed and read on the screen.
 *
 * Notifications are "screen" notifications, that is, they appear on the notifications menu
 * in the site wide navigation bar. They are not for email notifications.
 *
 *
 * The recording is done by using bp_core_add_notification() which you can search for in this file for
 * ktrs of usage.
 */
function bp_ktr_format_notifications( $action, $item_id, $secondary_item_id, $total_items ) {
	global $bp;

	switch ( $action ) {
		case 'new_high_five':
			/* In this case, $item_id is the user ID of the user who sent the high five. */

			/***
			 * We don't want a whole list of similar notifications in a users list, so we group them.
			 * If the user has more than one action from the same component, they are counted and the
			 * notification is rendered differently.
			 */
			if ( (int)$total_items > 1 ) {
				return apply_filters( 'bp_ktr_multiple_new_high_five_notification', '<a href="' . $bp->loggedin_user->domain . $bp->ktr->slug . '/view-orders/" title="' . __( 'Multiple high-fives', 'bp-ktr' ) . '">' . sprintf( __( '%d new high-fives, multi-five!', 'bp-ktr' ), (int)$total_items ) . '</a>', $total_items );
			} else {
				$user_fullname = bp_core_get_user_displayname( $item_id, false );
				$user_url = bp_core_get_userurl( $item_id );
				return apply_filters( 'bp_ktr_single_new_high_five_notification', '<a href="' . $user_url . '?new" title="' . $user_fullname .'\'s profile">' . sprintf( __( '%s sent you a high-five!', 'bp-ktr' ), $user_fullname ) . '</a>', $user_fullname );
			}
		break;
	}

	do_action( 'bp_ktr_format_notifications', $action, $item_id, $secondary_item_id, $total_items );

	return false;
}


/***
 * From now on you will want to add your own functions that are specific to the component you are developing.
 * For ktr, in this section in the friends component, there would be functions like:
 *    friends_add_friend()
 *    friends_remove_friend()
 *    friends_check_friendship()
 *
 * Some guidelines:
 *    - Don't set up error messages in these functions, just return false if you hit a problem and
 *		deal with error messages in screen or action functions.
 *
 *    - Don't directly query the database in any of these functions. Use database access classes
 * 		or functions in your  file to fetch what you need. Spraying database
 * 		access all over your plugin turns into a maintainence nightmare, trust me.
 *
 *	  - Try to include add_action() functions within all of these functions. That way others will find it
 *		easy to extend your component without hacking it to pieces.
 */

/**
 * bp_ktr_accept_terms()
 *
 * Accepts the terms and conditions screen for the logged in user.
 * Records an activity stream item for the user.
 */
function bp_ktr_accept_terms() {
	global $bp;

	/**
	 * First check the nonce to make sure that the user has initiated this
	 * action. Remember the wp_nonce_url() call? The second parameter is what
	 * you need to check for.
	 */
	check_admin_referer( 'bp_ktr_accept_terms' );

	/***
	 * Here is a good ktr of where we can post something to a users activity stream.
	 * The user has excepted the terms on screen two, and now we want to post
	 * "Andy accepted the really exciting terms and conditions!" to the stream.
	 */
	 $user_link = bp_core_get_userlink( $bp->loggedin_user->id );

	bp_ktr_record_activity( array(
		'type' => 'accepted_terms',
		'action' => apply_filters( 'bp_ktr_accepted_terms_activity_action', sprintf( __( '%s accepted the really exciting terms and conditions!', 'bp-ktr' ), $user_link ), $user_link ),
	) );

	/* See bp_ktr_reject_terms() for an explanation of deleting activity items */
	if ( function_exists( 'bp_activity_delete') )
		bp_activity_delete( array( 'type' => 'rejected_terms', 'user_id' => $bp->loggedin_user->id ) );

	/* Add a do_action here so other plugins can hook in */
	do_action( 'bp_ktr_accept_terms', $bp->loggedin_user->id );

	/***
	 * You'd want to do something here, like set a flag in the database, or set usermeta.
	 * just for the sake of the demo we're going to return true.
	 */
  

	return true;
}


function bp_ktr_add_upload_notification(){
global $bp;
if($_REQUEST['action']=='upload_lib_doc')
    check_admin_referer( 'upload_lib_doc' );

   $user_link = bp_core_get_userlink( $bp->loggedin_user->id );
   
    bp_ktr_record_activity( array(
		'type' => 'upload_file',
		'action' => apply_filters( 'bp_ktr_add_upload_notification_activity_action', sprintf( __('%s  has upload a document in his library.', 'bp-ktr'), $user_link  ), $user_link ),
                'content' => "Visit <a href='".($bp->displayed_user->id ? $bp->displayed_user->domain : $bp->loggedin_user->domain)  . "album/".$bp->ktr->upload."'> ".bp_core_get_user_displayname( $bp->loggedin_user->id, false )."'s Library</a>",
	) );

	

	do_action( 'bp_ktr_add_upload_notification', $bp->loggedin_user->id  );

	return true;
}

/**
 * bp_ktr_reject_terms()
 *
 * Rejects the terms and conditions screen for the logged in user.
 * Records an activity stream item for the user.
 */
function bp_ktr_reject_terms() {
	global $bp;

	check_admin_referer( 'bp_ktr_reject_terms' );

	/***
	 * In this ktr component, the user can reject the terms even after they have
	 * previously accepted them.
	 *
	 * If a user has accepted the terms previously, then this will be in their activity
	 * stream. We don't want both 'accepted' and 'rejected' in the activity stream, so
	 * we should remove references to the user accepting from all activity streams.
	 * A real world ktr of this would be a user deleting a published blog post.
	 */

	$user_link = bp_core_get_userlink( $bp->loggedin_user->id );

	/* Now record the new 'rejected' activity item */
	bp_ktr_record_activity( array(
		'type' => 'rejected_terms',
		'action' => apply_filters( 'bp_ktr_rejected_terms_activity_action', sprintf( __( '%s rejected the really exciting terms and conditions.', 'bp-ktr' ), $user_link ), $user_link ),
	) );

	/* Delete any accepted_terms activity items for the user */
	if ( function_exists( 'bp_activity_delete') )
		bp_activity_delete( array( 'type' => 'accepted_terms', 'user_id' => $bp->loggedin_user->id ) );

	do_action( 'bp_ktr_reject_terms', $bp->loggedin_user->id );

	return true;
}

/**
 * bp_ktr_send_high_five()
 *
 * Sends a high five message to a user. Registers an notification to the user
 * via their notifications menu, as well as sends an email to the user.
 *
 * Also records an activity stream item saying "User 1 high-fived User 2".
 */
function bp_ktr_send_highfive( $to_user_id, $from_user_id ) {
	global $bp;

	check_admin_referer( 'bp_ktr_send_high_five' );

	/**
	 * We'll store high-fives as usermeta, so we don't actually need
	 * to do any database querying. If we did, and we were storing them
	 * in a custom DB table, we'd want to reference a function in
	 *  that would run the SQL query.
	 */

	/* Get existing fives */
	$existing_fives = maybe_unserialize( get_user_meta( $to_user_id, 'high-fives', true ) );

	/* Check to see if the user has already high-fived. That's okay, but lets not
	 * store duplicate high-fives in the database. What's the point, right?
	 */
	if ( !in_array( $from_user_id, (array)$existing_fives ) ) {
		$existing_fives[] = (int)$from_user_id;

		/* Now wrap it up and fire it back to the database overlords. */
		update_user_meta( $to_user_id, 'high-fives', serialize( $existing_fives ) );
	}

	/***
	 * Now we've registered the new high-five, lets work on some notification and activity
	 * stream magic.
	 */

	/***
	 * Post a screen notification to the user's notifications menu.
	 * Remember, like activity streams we need to tell the activity stream component how to format
	 * this notification in bp_ktr_format_notifications() using the 'new_high_five' action.
	 */
	bp_core_add_notification( $from_user_id, $to_user_id, $bp->ktr->slug, 'new_high_five' );

	/* Now record the new 'new_high_five' activity item */
	$to_user_link = bp_core_get_userlink( $to_user_id );
	$from_user_link = bp_core_get_userlink( $from_user_id );

	bp_ktr_record_activity( array(
		'type' => 'rejected_terms',
		'action' => apply_filters( 'bp_ktr_new_high_five_activity_action', sprintf( __( '%s high-fived %s!', 'bp-ktr' ), $from_user_link, $to_user_link ), $from_user_link, $to_user_link ),
		'item_id' => $to_user_id,
	) );

	/* We'll use this do_action call to send the email notification. See bp-ktr-notifications.php */
	do_action( 'bp_ktr_send_high_five', $to_user_id, $from_user_id );

	return true;
}

/**
 * bp_ktr_get_highfives_for_user()
 *
 * Returns an array of user ID's for users who have high fived the user passed to the function.
 */
function bp_ktr_get_highfives_for_user( $user_id ) {
	global $bp;

	if ( !$user_id )
		return false;

	return maybe_unserialize( get_user_meta( $user_id, 'high-fives', true ) );
}

/**
 * bp_ktr_remove_screen_notifications()
 *
 * Remove a screen notification for a user.
 */
function bp_ktr_remove_screen_notifications() {
	global $bp;

	/**
	 * When clicking on a screen notification, we need to remove it from the menu.
	 * The following command will do so.
 	 */
	bp_core_delete_notifications_for_user_by_type( $bp->loggedin_user->id, $bp->ktr->slug, 'new_high_five' );
}
add_action( 'bp_ktr_screen_one', 'bp_ktr_remove_screen_notifications' );
add_action( 'xprofile_screen_display_profile', 'bp_ktr_remove_screen_notifications' );

/**
 * bp_ktr_remove_data()
 *
 * It's always wise to clean up after a user is deleted. This stops the database from filling up with
 * redundant information.
 */
function bp_ktr_remove_data( $user_id ) {
	/* You'll want to run a function here that will delete all information from any component tables
	   for this $user_id */

	/* Remember to remove usermeta for this component for the user being deleted */
	delete_user_meta( $user_id, 'bp_ktr_some_setting' );

	do_action( 'bp_ktr_remove_data', $user_id );
}
add_action( 'wpmu_delete_user', 'bp_ktr_remove_data', 1 );
add_action( 'delete_user', 'bp_ktr_remove_data', 1 );

/***
 * Object Caching Support ----
 *
 * It's a good idea to implement object caching support in your component if it is fairly database
 * intensive. This is not a requirement, but it will help ensure your component works better under
 * high load environments.
 *
 * In parts of this ktr component you will see calls to wp_cache_get() often in template tags
 * or custom loops where database access is common. This is where cached data is being fetched instead
 * of querying the database.
 *
 * However, you will need to make sure the cache is cleared and updated when something changes. For ktr,
 * the groups component caches groups details (such as description, name, news, number of members etc).
 * But when those details are updated by a group admin, we need to clear the group's cache so the new
 * details are shown when users view the group or find it in search results.
 *
 * We know that there is a do_action() call when the group details are updated called 'groups_settings_updated'
 * and the group_id is passed in that action. We need to create a function that will clear the cache for the
 * group, and then add an action that calls that function when the 'groups_settings_updated' is fired.
 *
 * Example:
 *
 *   function groups_clear_group_object_cache( $group_id ) {
 *	     wp_cache_delete( 'groups_group_' . $group_id );
 *	 }
 *	 add_action( 'groups_settings_updated', 'groups_clear_group_object_cache' );
 *
 * The "'groups_group_' . $group_id" part refers to the unique identifier you gave the cached object in the
 * wp_cache_set() call in your code.
 *
 * If this has completely confused you, check the function documentation here:
 * http://codex.wordpress.org/Function_Reference/WP_Cache
 *
 * If you're still confused, check how it works in other BuddyPress components, or just don't use it,
 * but you should try to if you can (it makes a big difference). :)
 */
 
 
 function bp_ktr_paypal_success() {
	global $bp, $comments;

	add_action( 'bp_template_title', 'bp_ktr_view_orders_title' );
        
	bp_core_load_template( apply_filters( 'bp_ktr_template_ktr_view_orders', 'ktr/paypal_success' ) );
       

	
}

function z_is_automatic($order){
	global $wpdb;
	$lang_parts = explode(' To ', $order->ktr_language); 
	$langTable = $wpdb->prefix . KTR_LANGUAGE_TABLE;
	$lang = $wpdb->get_row("SELECT * FROM {$langTable} WHERE ktr_trnslt_from = '{$lang_parts[0]}' AND ktr_trnslt_to = '{$lang_parts[1]}'");
	
	if($lang->auto_send && $lang->default_translator && ($order->status <= 3 || ($order->status > 30 && $order->status < 39)) ){
		return 'Yes';
	}else{
		return 'No';
	}
}

?>