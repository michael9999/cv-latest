<?php
/** _help_center.php
 *
 * Template Name: Entretien2
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
				else{ ?>
				
				// ADD CONTENT HERE 

<div class="main-container">

<div class="col1-sale">
<div class="con1">
</div>
<div class="sue-plan-head">
<div class="sue-plan-name">
<img src="http://www.test-sw2.com/staging-cv-en-anglais/wp-content/uploads/2014/12/nb1-green-300x300.png" alt="nb1-green" width="40" height="40" class="alignnone size-medium wp-image-456" />
<p class="sue-plan-name-text">Vérification de CV</p>
</div>
<div class="sue-plan-price">
<span class="sue-plan-price-value">Free</span>
</div>
<div class="sue-plan-icon">

<img src="http://www.test-sw2.com/staging-cv-en-anglais/wp-content/uploads/2014/12/star-gold.png" alt="star-gold" width="40" height="40" class="alignnone size-full wp-image-437" />

</div>

<div class="sue-plan-options" style="min-height: 123px;">

<ul class="service-list">
<li>Relecture complète de votre CV</li>
<li>Indentification des erreurs</li>
<li>Correction humaine uniquement</li>
<li><input type="submit" value="Prêt en 1 heure" class="wpcf7-form-control wpcf7-submit" id="test-paypal"></li>
</ul>
</div>

</div>


</div>
<div class="col2-sale">
<div class="con1">
<div class="con1text">
<img src="http://www.test-sw2.com/staging-cv-en-anglais/wp-content/uploads/2014/12/nb2-blue-300x300.png" alt="nb2-blue" width="60" height="60" class="alignnone size-medium wp-image-466" />
<p class="sue-plan-name-text2">Démarrer mon projet</p>
<img src="http://www.test-sw2.com/staging-cv-en-anglais/wp-content/uploads/2014/12/tick-green.png" alt="tick-green" width="30" height="30" class="alignnone size-full wp-image-451" />
</div>
</div>
<div class="con2">
<!--[contact-form-7 id="357" title="Verification de CV"]-->
<div id="paypal-send-to-msg">Votre demande est en cours de traitement, merci de patienter... <br>   <br> </div>
</div>
<div class="con3"></div>
<div class="con4"></div>


</div>
<div class="col3-sale">

<div class="con1">
<div class="con2text">
<img src="http://www.test-sw2.com/staging-cv-en-anglais/wp-content/uploads/2014/12/1420589119_guarantee.png" alt="edit26" width="100" height="100" class="alignnone size-full wp-image-472" />
<p class="sue-plan-name-text2">Nos garanties </p>
</div>
</div>
<div class="con2"><img src="http://www.test-sw2.com/staging-cv-en-anglais/wp-content/uploads/2014/12/PP_logo_h_100x26.png" width="100" height="26" class="alignnone size-full wp-image-452">Paiement sécurisé </div>
<div class="con3"><img src="http://www.test-sw2.com/staging-cv-en-anglais/wp-content/uploads/2014/12/tick-green.png" alt="tick-green" width="30" height="30" class="alignnone size-full wp-image-453">Traducteurs de langue maternelle anglaise</div>
<div class="con3"><img src="http://www.test-sw2.com/staging-cv-en-anglais/wp-content/uploads/2014/12/tick-green.png" alt="tick-green" width="30" height="30" class="alignnone size-full wp-image-453">Livraison sous 24 heures</div>
<div class="con4"><img src="http://www.test-sw2.com/staging-cv-en-anglais/wp-content/uploads/2014/12/tick-green.png" alt="tick-green" width="30" height="30" class="alignnone size-full wp-image-453">Service clientèle
</div>

<div class="con5">

<div id="holder-help-btn-3">
<div id="holder-help-btn-4">
<a id="help-btn-cv-3" href="http://www.test-sw2.com/staging-cv-en-anglais/centre-daide.html">Besoin d'aide ?</a><br><br>
</div>
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

get_footer();

?>
	</div>
</div>
<?php