<?php
/** sidebar.php
 *
 * @author		Konstantin Obenland
 * @package		The Bootstrap
 * @since		1.0.0	- 05.02.2012
 */
//echo "This is the sidebar";
tha_sidebars_before(); ?>
<section id="secondary" class="widget-area span3" role="complementary">
	<?php tha_sidebar_top();

// check if user is logged in 

global $current_user;
get_currentuserinfo();
$cur_user = $current_user->user_login;

if (!empty($cur_user)){

	
	if ( ! dynamic_sidebar( 'main' ) ) {
		the_widget( 'WP_Widget_Archives', array(
			'count'		=>	0,
			'dropdown'	=>	0
		), array(
			'before_widget'	=>	'<aside id="archives" class="widget well widget_archives">',
			'after_widget'	=>	'</aside>',
			'before_title'	=>	'<h3 class="widget-title">',
			'after_title'	=>	'</h3>',
		) );
		the_widget( 'WP_Widget_Meta', array(), array(
			'before_widget'	=>	'<aside id="meta" class="widget well widget_meta">',
			'after_widget'	=>	'</aside>',
			'before_title'	=>	'<h3 class="widget-title">',
			'after_title'	=>	'</h3>',
		) );
	} // end sidebar widget area
	
	tha_sidebar_bottom();
	
}
else{
//echo "you are not logged in";
/*echo "<section role=complementary class=widget-area span3 id=secondary>
	<aside class=widget well Accordion_widget id=wp-accordion><h2 class=widget-title></h2>";*/
        
echo"<aside>";
// start

echo "<ul class='accWidget' style='display: block;'>

You're missing out on our step-by-step application <br><br>
<a target='_self' style='' class='btn btn-home-btn-mike btn-large' href='#'>Get started!</a><br><br>
<a href='#'>Ou en savoir plus</a>

</ul>";

// end

// 2nd bubble 

echo "<ul class='accWidget' style='display: block;'>

Nos services <br><br>
<table><tr><td>Verification de CV</td><td>en savoir plus</td><td>----------</td></tr>
<tr><td>Correction de CV</td><td>en savoir plus</td><td>----------</td></tr>
<tr><td>Traduction de CV</td><td>en savoir plus</td><td>----------</td></tr>
<tr><td>Entretien en anglais</td><td>en savoir plus</td><td>----------</td></tr><table>

</ul>";

//tha_sidebar_bottom();

//echo "</aside></section>";
echo"<h1>Michael</h1>";
//echo "</section>";

echo"</aside>";
echo "</section>";

}
	
	?>
<!--</section>-->


<!-- #secondary .widget-area -->
<?php tha_sidebars_after();


/* End of file sidebar.php */
/* Location: ./wp-content/themes/the-bootstrap/sidebar.php */