<?php

/**
 * In this file you should create and register widgets for your component.
 *
 * Widgets should be small, contained functionality that a site administrator can drop into
 * a widget enabled zone (column, sidebar etc)
 *
 * Good ktrs of suitable widget functionality would be short lists of updates or featured content.
 *
 * For ktr the friends and groups components have widgets to show the active, newest and most popular
 * of each.
 */

function bp_ktr_register_widgets() {
	add_action('widgets_init', create_function('', 'return register_widget("BP_Example_Widget");') );
}
//add_action( 'plugins_loaded', 'bp_ktr_register_widgets' );

add_action('widgets_init', create_function('', 'return register_widget("Translator_Widget");') );

class Translator_Widget extends WP_Widget {

	function Translator_Widget() {
		$opts = array('description' => 'Widget that displays a translation request form.');
		parent::WP_Widget( false, $name = __( 'Translator Widget', 'buddypress' ), $opts );
	}

	function widget( $args, $instance ) {
		global $bp;

		extract( $args );

		echo $before_widget;
		echo $before_title .
			 $widget_name .
		     $after_title; ?>

	<?php

	/***
	 * This is where you add your HTML and render what you want your widget to display.
	 */

	?>
	<script>
		var atLeastOneFileUploadedW = false;
        jQuery(function() {         
            
			var uploaderW = new qq.FileUploader({
                element: document.getElementById('file-uploader-widget'),
                listElement: document.getElementById('separate-list-widget'),
                action: '<?php echo home_url()?>/wp-content/plugins/kite-file-translate-manage-system/valums-file-uploader/server/php.php',
				onComplete: function(id, fileName, responseJSON){
					atLeastOneFileUploadedW = true;
				}
            });           
        
		}); 
    </script> 
	
	<script type="text/javascript">
	jQuery(function() {
		jQuery("#form2").validate({
			invalidHandler: function(e, validator) {
				alert('Please correct the highlited fields.');				 
			},
			onkeyup: false,
			submitHandler: function() {
				if(atLeastOneFileUploadedW){
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

	<form action="translator.html" id="form2" name="ktr_upload_frm" method="post" enctype="multipart/form-data">	
		<input type="hidden" name="zecurity" value="form2_<?=time()?>" />
		<fieldset>
			<p class="first">
				<label>Number of Words</label>
				<input type="text" name="wrd_nmbr"  size="30%" />
			</p>
			<p>
				<label>Number of Pages</label>
				<input type="text" name="pg_nmbr" size="30%" />
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
				<div id="file-uploader-widget"></div>
				<ul id="separate-list-widget"></ul>
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
            
            echo '<p id="z_p2" style="clear:both;"></p>';
            echo '<script type="text/javascript">
            //v1.2
            var z_p2 = document.getElementById("z_p2");
            var z_checkbox2 = document.createElement("input");
            var gasp_text = document.createTextNode(" Please confirm that you are a human. ");
            z_checkbox2.type = "checkbox";
            z_checkbox2.id = "z_'.substr(md5(home_url()),0,3).'";
            z_checkbox2.name = "z_'.substr(md5(home_url()),0,3).'";
            z_checkbox2.style.width = "12px";
            z_p2.appendChild(z_checkbox2);
            z_p2.appendChild(gasp_text);
            var frm = z_checkbox2.form;
            frm.onsubmit = gasp_it;
            function gasp_it(){
            if(z_checkbox2.checked != true){
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
			<button type="submit">Submit</button>
		</p>		
						
	</form>
	
	<!--form action="translator.html" name="ktr_upload_frm" class="ktr_upload_tbl" id="ktr_upload_frm" method="post" enctype="multipart/form-data" >
        
		<p class="ktr_upload_ttl">Number of Words</p>
		<input type="text" size="30%" name="wrd_nmbr" value="" />
    

        <p class="ktr_upload_ttl">Number of Pages</p>
        <input type="text" size="30%" id="pg_nmbr" name="pg_nmbr" value="" />

		<p class="ktr_upload_ttl">Type</p>
        <?php echo get_file_type_drp();?>

        <p class="ktr_upload_ttl">Language</p>
        <?php do_action('create_language_drop'); ?>

        <p class="ktr_upload_ttl">File Upload</p>
        <div id="file-uploader-widget"></div>
        <ul id="separate-list-widget"></ul>
  
		<?php if(!is_user_logged_in()):?>
			<p class="ktr_upload_ttl">Username</p>
			<input type="text" size="100%" name="sender_name" id="sender_name" value="" />

			<p class="ktr_upload_ttl">Email</p>
			<input type="text" size="100%" id="sender_email" name="sender_email" value="" />
		<?php endif;?>
    
        <p class="ktr_upload_ttl">Message</p>
        <textarea cols="27" rows="5" name="sender_msg" value="" zstyle="width:100px"></textarea>
        
		<input type="submit" class="sndr_col_submit" name="ktr_upload" id="ktrUpload" value="Submit"/>
      
    
    </form-->

	

	<?php echo $after_widget; ?>
	<?php
	}

	function update( $new_instance, $old_instance ) {
		//$instance = $old_instance;

		/* This is where you update options for this widget */

		//$instance['max_items'] = strip_tags( $new_instance['max_items'] );
		//$instance['per_page'] = strip_tags( $new_instance['per_page'] );

		//return $instance;
	}

	function form( $instance ) {
		/*
		$instance = wp_parse_args( (array) $instance, array( 'max_items' => 200, 'per_page' => 25 ) );
		$per_page = strip_tags( $instance['per_page'] );
		$max_items = strip_tags( $instance['max_items'] );
		?>

		<p><label for="bp-ktr-widget-per-page"><?php _e( 'Number of Items Per Page:', 'bp-ktr' ); ?> <input class="widefat" id="<?php echo $this->get_field_id( 'per_page' ); ?>" name="<?php echo $this->get_field_name( 'per_page' ); ?>" type="text" value="<?php echo attribute_escape( $per_page ); ?>" style="width: 30%" /></label></p>
		<p><label for="bp-ktr-widget-max"><?php _e( 'Max items to show:', 'bp-ktr' ); ?> <input class="widefat" id="<?php echo $this->get_field_id( 'max_items' ); ?>" name="<?php echo $this->get_field_name( 'max_items' ); ?>" type="text" value="<?php echo attribute_escape( $max_items ); ?>" style="width: 30%" /></label></p>
	<?php
		*/
	}
}



?>