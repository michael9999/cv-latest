<?php 
	 global $wpdb;
	 global $bp;
	 $table  = $wpdb->prefix.KTR_TRANSLATOR_INFO_TABLE;
	 $table2 = $wpdb->prefix.KTR_TRANSLATOR_SPECIALIZATION_TABLE;
	 $user = wp_get_current_user(); 
	 $user_id = $user->ID;

	 //Add action
	 if ( isset( $_POST['submit'] ) && isset( $_POST['specialisation'] )) {		  
		$check_query = "SELECT COUNT(*) FROM $table 
			WHERE default_user_id=".$user_id ." AND name = 'specilization' AND  value = %s";
		if(!$wpdb->get_var( $wpdb->prepare( $check_query, $_POST['specialisation'] ) )){
			$sql = $wpdb->prepare("INSERT INTO $table 
				SET default_user_id  = '{$user_id}',
					name = 'specilization',
					value = '%s'
					", $_POST['specialisation']);
			$wpdb->query($sql); 
			wp_redirect( $_SERVER['HTTP_REFERER'] . '?added');
		}
	}
	
	//Delete action ----------------------------------
	$url_parts = explode('/',$_SERVER['REQUEST_URI']);
	if ( (isset( $url_parts[7] ) && isset( $url_parts[8] )) && $url_parts[7] == 'del_spec' && $url_parts[8]) {
		$specialisation_id = $url_parts[8];
		$deleted = $wpdb->query( $wpdb->prepare( "DELETE FROM $table 
			WHERE name = 'specilization' AND value = {$specialisation_id} AND default_user_id = '%s' ", $user_id) );
		if($deleted) wp_redirect( $_SERVER['HTTP_REFERER'] . '?deleted');
	}

	$q = "SELECT tinfo.*, spec.* FROM $table AS tinfo
	LEFT JOIN $table2 AS spec ON tinfo.value = spec.ktr_apecialization_id
	WHERE tinfo.default_user_id= '%s' and tinfo.name='specilization'";
	$my_specs = $wpdb->get_results($wpdb->prepare($q, $user_id));

	$in_str = '';
	foreach($my_specs as $ms) $in_str .= $ms->value. ','; 
	$in_str = rtrim($in_str,',');
	$q = "SELECT * FROM $table2
	WHERE ktr_apecialization_id NOT IN ( " . $in_str . " )";
	$other_specs = $wpdb->get_results($wpdb->prepare($q, '')); 
?>
	 
								 
								 
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
				 <div class="wrap"><!--body wrap-->
					
					<h2>My Specialisations</h2>
					<?php if ( isset($_GET['deleted']) ) : ?><?php echo "<div id='message' class='updated fade'><p>" . __( 'Specialisation deleted.', 'bp-ktr' ) . "</p></div>" ?><?php endif; ?>
					<?php if ( isset($_GET['added']) ) : ?><?php echo "<div id='message' class='updated fade'><p>" . __( 'Specialisation added.', 'bp-ktr' ) . "</p></div>" ?><?php endif; ?>
					
					<?php if(count($my_specs)>0): ?>
						<style>
							#content table { border:0; }
							#content tr{ border-bottom:0; }
							#content tr td{ border-top:0; }
						</style>
						<table class="form-table-list ffs_flat_list">
							<!--tr valign="top">
								<th scope="row"><label for="target_uri"><?php _e( 'Name', 'bp-ktr' ) ?></label></th>
								<th scope="row"><label for="target_uri"><?php _e( 'Action', 'bp-ktr' ) ?></label></th>
							</tr-->
							<?php foreach($my_specs as $s): ?>
							<tr>
								<td><?php echo $s->ktr_specialization; ?></td>
								<td><!--a href="javascript:if(confirm('Are you sure?')) document.location = '<?=$bp->loggedin_user->domain . $bp->current_component.'/'.$bp->current_action.'/'?>del_spec/<?php echo $s->ktr_apecialization_id; ?>'">Delete</a--></td>
							</tr>
							<?php  endforeach;?>
						</table>
					<?php endif; ?>
					
					
					<h2>Add new</h2>
					<?php if(count($other_specs)>0): ?>
					<form action="" method="post" name="" id="">
						<table class="form-table-list">
							<tr valign="top">
								<td class="dtl_left_td">Available Specialisations </td>
								<td>
									<select name="specialisation">
										<?php foreach($other_specs as $s): ?>
											<option value="<?php echo $s->ktr_apecialization_id; ?>">
												<?php echo $s->ktr_specialization; ?>
											</option>
										<?php  endforeach;?>
									</select>
								</td>
							</tr>
							<tr>
								<td></td>
								<td>
									<?php
									/*
										if (function_exists('wp_nonce_field')){
											wp_nonce_field('translator-specialisations');
										}
									*/
									?>
									<input  type="submit" name="submit" id="submit" value="Add" />
								</td>
							</tr>
						</table>
				   </form>
				   <?php else: ?>
						Other specialisations aren't available.
				   <?php endif; ?>

					 </div><!-- #item-body wrap -->
			</div><!-- #item-body -->

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php locate_template( array( 'sidebar.php' ), true ) ?>

<?php get_footer() ?>
