<?php
/*
Plugin Name: Switch Themes
Version: 1.0
Author URI: -
Plugin URI: -
Description:  Switch themes dynamically. 
Author: Rakhitha Nimesh
License: GPL2
*/


/*
*
* Switch Between Old and New Themes
*
*/



/*add_filter('template', 'switch_to_old_theme');
add_filter('stylesheet', 'switch_to_old_theme');


function switch_to_old_theme($theme) {

    if(isset($_COOKIE['acttheme']) && $_COOKIE['acttheme'] == 'old'){
	$theme = 'twentyeleven';
    }else{
	$theme = 'twentyten';
    }

    return $theme;
}

function switch_to_old_theme_footer() {

?>

	<style>
		#switcherPanel{
			background: none repeat scroll 0 0 #FFFFFF;
    			border-color: #CFCFCF #CFCFCF #CFCFCF -moz-use-text-color;
    			border-style: solid solid solid none;
    			border-width: 1px 1px 1px medium;
    			font-weight: bold;
    			padding: 10px;
    			width: 150px;
			position:absolute;
			top:30px;
			left:0px;
		}
	</style>
	<p id="switcherPanel"><a href="javascript:void(0);" onclick="switch_theme();" ></a></p>

<?php
}
add_action('wp_head', 'switch_to_old_theme_footer');



function switch_to_old_theme_scripts() {
    $plugin_dir = WP_PLUGIN_URL . "/";

    
    wp_enqueue_script( 'jquery' );
    wp_register_script( 'switchjs', $plugin_dir ."switch-theme/switcher.js");
    wp_enqueue_script( 'switchjs' );

}

add_action('wp_enqueue_scripts', 'switch_to_old_theme_scripts');*/




/*
*
*
* Change Theme By Browser
*
*/
/*
add_filter('template', 'switch_theme_by_browser');
add_filter('stylesheet', 'switch_theme_by_browser');



function switch_theme_by_browser($theme) {


	$browser = $_SERVER['HTTP_USER_AGENT'];


if(preg_match('/MSIE/i',$browser) && !preg_match('/Opera/i',$browser))
    {
        $theme = "twentyeleven";
    }
    elseif(preg_match('/Firefox/i',$browser))
    {
        $theme = "twentytwelve";
    }
    elseif(preg_match('/Chrome/i',$browser))
    {
        $theme = "sliding-door";
    }
    elseif(preg_match('/Safari/i',$browser))
    {
        $theme = "presswork";
    }
    elseif(preg_match('/Opera/i',$browser))
    {
        $theme = "fotofolio";
    }
    elseif(preg_match('/Netscape/i',$browser))
    {
        $theme = "colorway";
    } 

    return $theme;
}*/



/*
*
* Change Theme By Device
*
*/


add_filter('template', 'switch_theme_by_device');
add_filter('stylesheet', 'switch_theme_by_device');


function switch_theme_by_device($theme){

	if (preg_match('/ipad/',strtolower($useragent))) {
        	$theme = 'twentyeleven';
    	}
	elseif (preg_match('/iphone/',strtolower($useragent))) {
        	$theme = 'twentytwelve';
    	}
    	
/*	elseif (preg_match('/blackberry/',strtolower($useragent))) {
        	$theme = 'colorway';
    	}
	elseif (preg_match('/android/',strtolower($useragent))) {
        	$theme = 'simplio';
    	}
*/    	

	return $theme;


}





