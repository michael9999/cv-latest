<?php
/** sidebar.php
 *
 * @author		Konstantin Obenland
 * @package		The Bootstrap
 * @since		1.0.0	- 05.02.2012
 */

tha_sidebars_before(); ?>
<section id="secondary" class="widget-area span3" role="complementary">
	<?php tha_sidebar_top();
	
// ADD HELP BUTTON

if (is_user_logged_in()){

//echo  "<div id='holder-help-btn'><a href='http://www.test-sw2.com/staging-cv-en-anglais/centre-daide.html' id='help-btn-cv'>Besoin d'aide ?</a><br><br></div>";

//$myClass ="";

}

else{
    
    
echo "<div id='holder-help-btn'><a href='http://www.test-sw2.com/staging-cv-en-anglais/centre-daide.html' id='help-btn-cv-2'>Besoin d'aide ?</a><br><br></div>";
    
    
    
}



// END HELP BUTTON
	
	if ( ! dynamic_sidebar( 'main' ) ) {
		the_widget( 'WP_Widget_Archives', array(
			'count'		=>	0,
			'dropdown'	=>	0
		), array(
			'before_widget'	=>	'<aside id="archives" class="widget well well2 widget_archives">',
			'after_widget'	=>	'</aside>',
			'before_title'	=>	'<h3 class="widget-title">',
			'after_title'	=>	'</h3>',
		) );
		the_widget( 'WP_Widget_Meta', array(), array(
			'before_widget'	=>	'<aside id="meta" class="widget well well2 widget_meta">',
			'after_widget'	=>	'</aside>',
			'before_title'	=>	'<h3 class="widget-title">',
			'after_title'	=>	'</h3>',
		) );
	} // end sidebar widget area

// My modification - Site presentatin button for users who are not logged in

    global $current_user;
          get_currentuserinfo();

    $cur_user = $current_user->user_login;

    // Add current user to javascript var
    
if (!empty($cur_user)){
echo"<div id='cv-service-block'>
<p id='services-text'> Nos services </p>
<table class='me-service'><tr><td id='service-text'>Verification de CV</td><td id='service-text-more'>+info</td><td id='small-mike'><a href='#' class='btn btn-home-btn-mike btn-small' style='' target='_self'>Free</a></td></tr>
<tr><td id='service-text'>Correction de CV</td><td id='service-text-more'>+info</td><td id='small-mike'><a href='#' class='btn btn-home-btn-mike btn-small' style='' target='_self'>39 €</a></td></tr>
<tr><td id='service-text'>Traduction de CV</td><td id='service-text-more'>+info</td><td id='small-mike'><a href='#' class='btn btn-home-btn-mike btn-small' style='' target='_self'>49 €</a></td></tr>
<tr><td id='service-text'>Entretien en anglais</td><td id='service-text-more'>+info</td><td id='small-mike'><a href='#' class='btn btn-home-btn-mike btn-small' style='' target='_self'>45 €</a></td></tr></table></div>";
}
else{

echo "<div id='pres-not-logged2'><a href='#'>Presentation du site (video)</a></div>";

}


// End my modification
	
	tha_sidebar_bottom(); ?>
</section><!-- #secondary .widget-area -->
<?php tha_sidebars_after();


/* End of file sidebar.php */
/* Location: ./wp-content/themes/the-bootstrap/sidebar.php */