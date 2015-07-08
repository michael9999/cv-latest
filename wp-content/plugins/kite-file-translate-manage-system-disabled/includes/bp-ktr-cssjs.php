<?php

/**
 * NOTE: You should always use the wp_enqueue_script() and wp_enqueue_style() functions to include
 * javascript and css files.
 */

/**
 * bp_ktr_add_js()
 *
 * This function will enqueue the components javascript file, so that you can make
 * use of any javascript you bundle with your component within your interface screens.
 */
function bp_ktr_add_js() {
	global $bp;

	if ( $bp->current_action == $bp->ktr->upload )
		wp_enqueue_script( 'bp-ktr-js', plugins_url( '/'.PLUGIN_NAME.'/includes/js/general.js' ) );
}
add_action( 'template_redirect', 'bp_ktr_add_js', 1 );
wp_enqueue_style('ktr-general',plugins_url( '/'.PLUGIN_NAME.'/includes/style/general.css' ));

?>