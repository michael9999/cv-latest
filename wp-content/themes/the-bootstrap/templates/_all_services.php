<?php
/** _help_center.php
 *
 * Template Name: All Services
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
			<div class="content-right-new span9">
				

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
				else
					
					echo "<h1 class='entry-title-updated'>Nos services</h1>
					
					
					<table cellspacing='0' cellpadding='0' border='0' summary='' class='compare-table col-960'>
 

<tbody><tr class='compare-table-key' style=''>
<td class='col1'></td>
<td class='pricing-choice'>
<div class='pricing-choice-plan starter'>
<div class='pricing-choice-plan-overview'>
<h1 class='pricing-choice-plan-title'>Verification de CV</h1>
<div class='pricing-choice-plan-cta'>
<div class='pricing-choice-plan-buy'><a data-plan='starter' href='https://www.zendesk.com/register/starter' class='serv-sell-btn'>Gratuit</a>
<a data-plan='starter' href='https://www.zendesk.com/register/starter' class='serv-sell-btn m-hide'>+ d'info</a></div>
</div>
</div>
</div>
</td>
<td class='pricing-choice'>
<div class='pricing-choice-plan regular'>
<div class='pricing-choice-plan-overview'>
<h1 class='pricing-choice-plan-title'>Correction de CV</h1>
<div class='pricing-choice-plan-cta'>
<div class='pricing-choice-plan-buy'><a data-plan='regular' href='https://www.zendesk.com/register/regular' class='serv-sell-btn'>39€</a>
<a data-plan='starter' href='https://www.zendesk.com/register/starter' class='serv-sell-btn m-hide'>+ d'info</a></div></div>
</div>
</div>
</div>
</td>
<td class='pricing-choice'>
<div class='pricing-choice-plan plus'>
<div class='pricing-choice-plan-overview'>
<h1 class='pricing-choice-plan-title'>Traduction de CV</h1>
<div class='pricing-choice-plan-cta'>

<div class='pricing-choice-plan-buy'><a data-plan='plus' href='https://www.zendesk.com/register/plus' class='serv-sell-btn'>49€</a>
<a data-plan='starter' href='https://www.zendesk.com/register/starter' class='serv-sell-btn m-hide'>+ d'info</a></div></div>
</div>
</div>
</div>
</td>
<td class='pricing-choice'>
<div class='pricing-choice-plan enterprise'>
<div class='pricing-choice-plan-overview enterprise-dark'>
<h1 class='pricing-choice-plan-title'>Entretien en anglais</h1>
<div class='pricing-choice-plan-cta'>
<div class='pricing-choice-plan-buy'><a data-plan='enterprise' href='#' class='serv-sell-btn'>45€</a>
<a data-plan='starter' href='#' class='serv-sell-btn m-hide'>+ d'info</a></div>
</div>
</div>
</div>
</td>
</tr>


<tr class='compare-table-sub annual-pricing'>
<td class='col1'><span class='compare-table-feature-name'>Relecture complete de votre CV</span></td>
<td class='col2'><span class='imagetick'><img src='wp-content/themes/the-bootstrap/img/nice-green-tick.gif'></span></td>
<td class='col3'><span class='compare-table-feature-name annual-regular'><img src='wp-content/themes/the-bootstrap/img/nice-green-tick.gif'></span></td>
<td><span class='compare-table-feature-name annual-plus'><img src='wp-content/themes/the-bootstrap/img/nice-green-tick.gif'></span></td>
<td><span class='compare-table-feature-name annual-enterprise'>-</span></td>
</tr>
<tr class='compare-table-sub compare-table-sub-header monthly-pricing'>
<td class='col1'><span class='compare-table-feature-name'>Identification des erreurs de langue</span></td>
<td class='col2'><span class='compare-table-feature-name monthly-starter'><img src='wp-content/themes/the-bootstrap/img/nice-green-tick.gif'></span></td>
<td class='col3'><span class='compare-table-feature-name monthly-regular'><img src='wp-content/themes/the-bootstrap/img/nice-green-tick.gif'></span></td>
<td><span class='compare-table-feature-name monthly-plus'><img src='wp-content/themes/the-bootstrap/img/nice-green-tick.gif'></td>
<td><span class='compare-table-feature-name monthly-enterprise'>-</td>
</tr>
<tr class='compare-table-sub'>
<td class='col1'><span class='compare-table-feature-name'>Correction des erreurs</span></td>
<td class='col2'><span class='compare-table-feature-name'>3</span></td>
<td class='col3'><span class='compare-table-feature-name'>Unlimited</span></td>
<td><span class='compare-table-feature-name'>Unlimited</span></td>
<td><span class='compare-table-feature-name'>Unlimited</span></td>
</tr>
<tr class='compare-table-sub'>
<td class='col1'>
<div class='compare-table-tooltip'><span class='compare-table-feature-name'>Annual invoicing option</span><span class='compare-table-tooltip-txt'><span class='pin'></span>Contact sales for more details.</span></div>
</td>
<td class='col2'></td>
<td class='col3'></td>
<td class='compare-table-check ico-check'></td>
<td class='compare-table-check ico-check'></td>
</tr>
<tr class='compare-table-sub'>
<td class='col1'>
<div class='compare-table-tooltip'><span class='compare-table-feature-name'>Free internal usage</span><span class='compare-table-tooltip-txt'><span class='pin'></span>Light agents are able to read and make private comments on a ticket. Good for internal collaboration with non-support departments.</span></div>
</td>
<td class='col2'></td>
<td class='col3'></td>
<td class='col4'></td>
<td><span class='compare-table-feature-name'>Unlimited</span></td>
</tr>


<tr class='compare-table-header'>
<td class='col1'>CUSTOMER SELF-SERVICE</td>
<td class='col2'></td>
<td class='col3'></td>
<td></td>
<td></td>
</tr>
<tr class='compare-table-sub compare-table-sub-header'>
<td class='col1'>
<div class='compare-table-tooltip'><span class='compare-table-feature-name'>Custom-branded Help Center with knowledge base, customer portal, and mobile-optimized interface</span><span class='compare-table-tooltip-txt'><span class='pin'></span>Help Center comes with your Zendesk and supports 40+ languages, even ones that read right to left.</span></div>
</td>
<td class='col2 ico-check'></td>
<td class='col3 ico-check'></td>
<td class='compare-table-check ico-check'></td>
<td class='compare-table-check ico-check'></td>
</tr>
<tr class='compare-table-sub compare-table-sub-header'>
<td class='col1'>
<div class='compare-table-tooltip'><span class='compare-table-feature-name'>Support for 40+ languages</span><span class='compare-table-tooltip-txt'><span class='pin'></span>Specify the languages you want to support in your Help Center, and set a different name for the Help Center for each of your supported languages. On Starter and Regular plans, Help Center supports one language. On Plus and Enterprise plans, you can select multiple languages to support. Zendesk supports the following languages: English, English (Canada), English (GB), French, French (Canada), Spanish, Japanese, Portuguese (Brazil), German, Latin American Spanish, Italian, Dutch, Russian, Trad. Chinese, Simpl. Chinese, Korean, Danish, Norwegian, Turkish, Swedish, Arabic, Hebrew, Polish, Bosnian, Bulgarian, Catalan, Croatian, Czech, Estonian, Finnish, Georgian, Greek, Hungarian, Icelandic, Indonesian, Latvian, Lithuanian, Filipino, Portuguese (Portugal), Romanian, Serbian, Slovakian, Slovenian, Thai, Ukrainian, Vietnamese, Persian.</span></div>
</td>
<td class='col2'>1</td>
<td class='col3'>1</td>
<td class='compare-table-check'>Multiple</td>
<td class='compare-table-check'>Multiple</td>
</tr>

<tr class='compare-table-header'>
<td class='col1'>API &amp; INTEGRATIONS</td>
<td class='col2'></td>
<td class='col3'></td>
<td></td>
<td></td>
</tr>
<tr class='compare-table-sub'>
<td class='col1'>
<div class='compare-table-tooltip'><span class='compare-table-feature-name'>Third party apps &amp; integrations (<a target='_blank' href='http://www.zendesk.com/apps/salesforce'>Salesforce</a>, <a target='_blank' href='http://www.zendesk.com/apps/sugarcrm'>SugarCRM</a>, <a target='_blank' href='http://www.zendesk.com/apps/microsoft'>Microsoft Dynamics CRM</a>, <a target='_blank' href='http://www.zendesk.com/apps/jira'>JIRA</a>)</span><span class='compare-table-tooltip-txt'><span class='pin'></span>Zendesk plugs into 100+ apps and integrations so you can unite your business by integrating your favorite tools.</span></div>
</td>
<td class='col2'><a href='//www.zendesk.com/apps'>See all</a></td>
<td class='col3'><a href='//www.zendesk.com/apps'>See all</a></td>
<td class='compare-table-check'><a href='//www.zendesk.com/apps'>See all</a></td>
<td class='compare-table-check'><a href='//www.zendesk.com/apps'>See all</a></td>
</tr>
<tr class='compare-table-sub'>
<td class='col1'>
<div class='compare-table-tooltip'><span class='compare-table-feature-name'>REST, Email, Javascript API</span><span class='compare-table-tooltip-txt'><span class='pin'></span>Visit developer.zendesk.com for more details.</span></div>
</td>
<td class='col2 ico-check'></td>
<td class='col3 ico-check'></td>
<td class='compare-table-check ico-check'></td>
<td class='compare-table-check ico-check'></td>
</tr>
<tr class='compare-table-sub'>
<td class='col1'>
<div class='compare-table-tooltip'><span class='compare-table-feature-name'>Full tech specs</span><span class='compare-table-tooltip-txt'><span class='pin'></span>Take a look under the hood and read about the inner workings of Zendesk.</span></div>
</td>
<td class='col2'><a href='//www.zendesk.com/product/tech-specs'>View specs</a></td>
<td class='col3'><a href='//www.zendesk.com/product/tech-specs'>View specs</a></td>
<td class='compare-table-check'><a href='//www.zendesk.com/product/tech-specs'>View specs</a></td>
<td class='compare-table-check'><a href='//www.zendesk.com/product/tech-specs'>View specs</a></td>
</tr>
</tbody></table>";
					
					//get_template_part( '/partials/content', 'page' );
				
				 ?>
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