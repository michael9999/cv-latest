<?php
/** _help_center.php
 *
 * Template Name: Verification de CV
 *
 * @author 	Tom Brehm / InDaCloud
 * @package The Bootstrap
 * @since	1.3.0	- 29.04.2012
 */

get_header(); ?>

<section id="primary" class="span9">
	<?php tha_content_before(); ?>
	<div id="content" role="main">
		<?php tha_content_top();
		
		the_post();
		
		//	find the top level page
		
		$top_level_id = get_the_ID();
		$level1_id = get_the_ID();
		$ancestors = get_ancestors( get_the_ID(), 'page');
		
		if(is_array($ancestors)){
			if(count($ancestors)>=1)
				$top_level_id = $ancestors[count($ancestors)-1]	;
			if(count($ancestors)>=2)
				$level1_id = $ancestors[count($ancestors)-2];			
		}
		
		
		echo the_breadcrumbs();

		$args = array(
			'sort_order' => 'ASC',
			'sort_column' => 'menu_order',
			'hierarchical' => 0,
			'parent' => $top_level_id,
			'post_type' => 'page',
			'post_status' => 'publish'
		); 
		$siblings = get_pages($args); 

		?>
		<div class="content-help row-fluid">
			<div class="content-left span3">
				<ul class="nav">
			<?php

				foreach ($siblings as $index => $sibling) {
					
					$active = ($sibling->ID == $level1_id)?'active':'';
					$icon = get_post_meta( $sibling->ID, '_custom_icon', true );
					if($icon)
						$icon_tag = '<i class="'.$icon.'"></i> ';
					else
						$icon_tag = '';
					?>
					<li class="<?php echo $active; ?>"><a href="<?php echo get_permalink($sibling->ID) ?>"><?php echo $icon_tag . get_the_title($sibling->ID); ?></a></li>
					<?php
				}

			?>
				</ul>
			</div>
			<div class="content-right-new span9 white2">
				

				<?php 
				
				$args = array(
					'sort_order' => 'ASC',
					'sort_column' => 'menu_order',
					'hierarchical' => 0,
					'parent' => get_the_ID(),
					'post_type' => 'page',
					'post_status' => 'publish'
				); 
				$childrens = get_pages($args);
				if(count($childrens) > 0){
					?>
					<header class="page-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header>
					<div class="parent-content">
						<?php the_content( ); ?>
					</div> 

					<ul class="childrens">
					<?php
					foreach ($childrens as $children) {
						?>
						<li class="child"><a href="<?php echo get_permalink($children->ID) ?>"><?php echo get_the_title( $children->ID ); ?></a></li>
						<?php
					}
					?>
					</ul>
					<?php
				}
				else{
				
				// ADD CONTENT HERE 
					
					echo "<div id='title-serv'><h1 class='entry-title-updated'>Verification CV</h1></div>";
					
					}
				 ?>

<!-- content -->
	
<div class="sales-qa">

<p>
<h2 class="qa-list-question">Qu'est-que c'est ?</h2></p>
<p class="qa-list-answer">Nous relisons et corrigons d'eventuelles erreurs de langue se trouvant dans votre CV</p>

<ul id="buttons-sell-trad"><li><a id="pp-show-hide" class="serv-sell-btn-corr" href="#" data-plan="enterprise">Commander</a></li>
<li><a href="http://www.test-sw2.com/staging-cv-en-anglais/centre-daide.html" id="serv-help-btn-corr">Help?</a></li>
<li id="pay-pal-sign">

Nos paiements sont effectués par : <a href="#" onclick="javascript:window.open('https://www.paypal.com/us/cgi-bin/webscr?cmd=xpt/cps/popup/OLCWhatIsPayPal-outside','olcwhatispaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=400, height=350');"><img src="https://www.paypal.com/en_US/i/logo/PayPal_mark_50x34.gif" border="0" alt="Acceptance Mark"></a>

</li>


</ul>


<!-- <a data-plan='enterprise' href='#' class='serv-sell-btn-corr'>Commander</a> -->
<a name="id3"></a>


<div id="pp-holder">
<div id="paypal-break-line"></div>

<!-- paypal form -->

<?php echo 
do_shortcode('[contact-form-7 id="357" title="Paypal form"]'); ?>


<div id="paypal-send-to-msg">Connexion à Paypal en cours, merci de patienter... <br>   <br>

<a href="#" id="pp-large" onclick="javascript:window.open('https://www.paypal.com/us/cgi-bin/webscr?cmd=xpt/cps/popup/OLCWhatIsPayPal-outside','olcwhatispaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=200, height=250');"><img src="https://www.paypal.com/en_US/i/bnr/horizontal_solution_PPeCheck.gif" border="0" alt="Solution Graphics"></a>


</div>

<div id="free-send-to-msg">Votre demande est en cours de traitement, merci de patienter... <br>   <br> </div>

<div id="wait-plz">Votre demande est en cours de traitement, merci de patienter... <br>   <br> </div>


Après validation vous serez redirigé vers notre site de paiement : <a href="#" onclick="javascript:window.open('https://www.paypal.com/us/cgi-bin/webscr?cmd=xpt/cps/popup/OLCWhatIsPayPal-outside','olcwhatispaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=400, height=350');"><img src="https://www.paypal.com/en_US/i/logo/PayPal_mark_50x34.gif" border="0" alt="Acceptance Mark"></a>

</div>



</div>
				 
				 
				 
				 
				 
			</div>
		</div>
		<?php
		
		tha_content_bottom(); ?>
	</div><!-- #content -->
	<?php tha_content_after(); ?>
</section><!-- #primary -->

<?php

get_sidebar(  );
get_footer();

?>
	</div>
</div>
<?php

/* End of file _help_center.php */
/* Location: ./wp-content/themes/the-bootstrap/_help_center.php */