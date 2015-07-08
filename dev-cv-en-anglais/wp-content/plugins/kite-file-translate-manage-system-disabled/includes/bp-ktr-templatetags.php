<?php

/**
 * In this file you should define template tag functions that end users can add to their template files.
 * Each template tag function should echo the final data so that it will output the required information
 * just by calling the function name.
 */

/**
 * If you want to go a step further, you can create your own custom WordPress loop for your component.
 * By doing this you could output a number of items within a loop, just as you would output a number
 * of blog posts within a standard WordPress loop.
 *
 * The ktr template class below would allow you do the following in the template file:
 *
 * 	<?php if ( bp_get_ktr_has_items() ) : ?>
 *
 *		<?php while ( bp_get_ktr_items() ) : bp_get_ktr_the_item(); ?>
 *
 *			<p><?php bp_get_ktr_item_name() ?></p>
 *
 *		<?php endwhile; ?>
 *
 *	<?php else : ?>
 *
 *		<p class="error">No items!</p>
 *
 *	<?php endif; ?>
 *
 * Obviously, you'd want to be more specific than the word 'item'.
 *
 */


class BP_Example_Template {
	var $current_item = -1;
	var $item_count;
	var $items;
	var $item;

	var $in_the_loop;

	var $pag_page;
	var $pag_num;
	var $pag_links;
        var $r;

	function bp_ktr_template( $user_id, $type, $page, $per_page, $max,$r='' ) {
		global $bp;

		if ( !$user_id )
			$user_id = $bp->displayed_user->id;

		/***
		 * If you want to make parameters that can be passed, then append a
		 * character or two to "page" like this: $_REQUEST['xpage']
		 * You can add more than a single letter.
		 */
                
                
		$this->pag_page = isset( $_REQUEST['xpage'] ) ? intval( $_REQUEST['xpage'] ) : $page;
		$this->pag_num = isset( $_GET['num'] ) ? intval( $_GET['num'] ) : $per_page;
		$this->user_id = $user_id;

               

		/***
		 * You can use the "type" variable to fetch different things to output.
		 * For ktr on the groups template loop, you can fetch groups by "newest", "active", "alphabetical"
		 * and more. This would be the "type". You can then call different functions to fetch those
		 * different results.
		 */
                
		 switch ( $type ) {
		 	case 'newest':
		 		$this->items = bp_ktr_get_newest( $user_id, $this->pag_num, $this->pag_page );
		 		break;
		
		 	case 'popular':
		 		$this->items = bp_ktr_get_popular( $user_id, $this->pag_num, $this->pag_page );
		 		break;
		
		 	case 'alphabetical':
		 		$this->items = bp_ktr_get_alphabetical( $user_id, $this->pag_num, $this->pag_page );
		 		break;
                        case 'upload-lib-doc':
		 		$this->items = bp_ktr_get_upload_item( $r);
		 		break;
		 }

		// Item Requests

                      
              
             //echo  $this->items['total'];
  
		if ( !$max || $max >= (int)$this->items['total'] )
			$this->total_item_count = (int)$this->items['total'];
		else
			$this->total_item_count = (int)$max;

		$this->items = $this->items['items'];

		if ( $max ) {
			if ( $max >= count($this->items) )
				$this->item_count = count($this->items);
			else
				$this->item_count = (int)$max;
		} else {
			$this->item_count = count($this->items);
		}

		/* Remember to change the "x" in "xpage" to match whatever character(s) you're using above */
		$this->pag_links = paginate_links( array(
			'base' => $bp->displayed_user->domain . $bp->album->slug .'/'. $bp->ktr->upload .'/%_%',//add_query_arg( 'xpage', '%#%' ),
			'format' => '%#%',
			'total' => ceil( (int) $this->total_item_count / (int) $this->pag_num ),
			'current' => (int) $this->pag_page,
			'prev_text' => '&larr;',
			'next_text' => '&rarr;',
			'mid_size' => 1,
                        'prev_title'   => __( 'Previous page' ), // Not from WP version
                        'next_title'   => __( 'Next page' )
		));



	}

	function has_items() {
		if ( $this->item_count )
			return true;

		return false;
	}

	function next_item() {
		$this->current_item++;
		$this->item = $this->items[$this->current_item];

		return $this->item;
	}

	function rewind_items() {
		$this->current_item = -1;
		if ( $this->item_count > 0 ) {
			$this->item = $this->items[0];
		}
	}

	function user_items() {
		if ( $this->current_item + 1 < $this->item_count ) {
			return true;
		} elseif ( $this->current_item + 1 == $this->item_count ) {
			do_action('bp_ktr_loop_end');
			// Do some cleaning up after the loop
			$this->rewind_items();
		}

		$this->in_the_loop = false;
		return false;
	}

	function the_item() {
		global $item, $bp;

		$this->in_the_loop = true;
		$this->item = $this->next_item();

		if ( 0 == $this->current_item ) // loop has just started
			do_action('bp_ktr_loop_start');
	}
}

function bp_ktr_has_items( $args = '' ,$ajaxurl='') {
	global $bp, $items_template;

	/***
	 * This function should accept arguments passes as a string, just the same
	 * way a 'query_posts()' call accepts parameters.
	 * At a minimum you should accept 'per_page' and 'max' parameters to determine
	 * the number of items to show per page, and the total number to return.
	 *
	 * e.g. bp_get_ktr_has_items( 'per_page=10&max=50' );
	 */

	/***
	 * Set the defaults for the parameters you are accepting via the "bp_get_ktr_has_items()"
	 * function call
	 */
if($ajaxurl){

    $rquestUrlArray=explode('members',$_REQUEST['current_action']);
    $actionPageArray=explode("/",$rquestUrlArray[1]);
    $displayed_user_name=$actionPageArray[1];
    $user = get_userdatabylogin($displayed_user_name);
    $user_id=$user->ID;
    $bp->album->slug=$actionPageArray[2];
    $page= (int)$actionPageArray[4];
    
 $defaults = array(
		'user_id' => (int)$user_id ,
		'page' =>$page? $page:1,
		'per_page' => 4,
		'max' => false,
		'type' => 'upload-lib-doc',
                'privacy'=>'public'
	);

        
	/***
	 * This function will extract all the parameters passed in the string, and turn them into
	 * proper variables you can use in the code - $per_page, $max
	 */
	$r = wp_parse_args( $args, $defaults );


	extract( $r, EXTR_SKIP );

	$items_template = new BP_Example_Template( $user_id, $type, $page, $per_page, $max, $r );
        $items_template->has_items();


}else{
    
	 $defaults = array(
		'user_id' => $bp->displayed_user->id ? $bp->displayed_user->id : false,
		'page' => 1,
		'per_page' => 4,
		'max' => false,
		'type' => 'upload-lib-doc',
                'privacy'=>'public'
	);
       
        if($bp->ktr->upload== $bp->current_action){
		$defaults['page'] = ( isset($bp->action_variables[0]) && (string)(int) $bp->action_variables[0] === (string) $bp->action_variables[0] ) ? (int) $bp->action_variables[0] : 1 ;
	}
	/***
	 * This function will extract all the parameters passed in the string, and turn them into
	 * proper variables you can use in the code - $per_page, $max
	 */
	$r = wp_parse_args( $args, $defaults );
    
        
	extract( $r, EXTR_SKIP );
   
	$items_template = new BP_Example_Template( $user_id, $type, $page, $per_page, $max, $r );
        $items_template->has_items();
}
	return $items_template->has_items();
}

function bp_ktr_the_item() {
	global $items_template;
	return $items_template->the_item();
}



function bp_ktr_items() {
	global $items_template;
	return $items_template->user_items();
}

/**
 * here is code for may be single item info
 */
function bp_ktr_item_title() {
	echo bp_ktr_get_item_title();
}
function bp_ktr_get_item_title() {
        global $items_template;
        return apply_filters( 'bp_ktr_get_item_title', $items_template->item->title);
}

function bp_ktr_item_title_truncate($length = 11) {
	echo bp_ktr_get_item_title_truncate($length);
}
	function bp_ktr_get_item_title_truncate($length) {

		global $items_template;

		$title = $items_template->item->title;

		$title = apply_filters( 'bp_ktr_get_item_title_truncate', $title);

		$r = wp_specialchars_decode($title, ENT_QUOTES);


		if ( function_exists('mb_strlen') && strlen($r) > mb_strlen($r) ) {

			$length = round($length / 2);
		}

		if ( function_exists( 'mb_substr' ) ) {


			$r = mb_substr($r, 0, $length);
		}
		else {
			$r = substr($r, 0, $length);
		}

		$result = _wp_specialchars($r) . '&#8230;';

		return $result;

	}

        function bp_ktr_item_desc() {
                echo bp_ktr_get_item_desc();
        }
	function bp_ktr_get_item_desc() {
		global $items_template;
		return apply_filters( 'bp_ktr_get_item_desc', $items_template->item->description );
	}

        function bp_ktr_item_desc_truncate($words=55) {
	echo bp_ktr_get_item_desc_truncate($words);
}
	function bp_ktr_get_item_desc_truncate($words=55) {
		global $items_template;
		$exc = bp_create_excerpt($items_template->item->description, $words, true) ;

		return apply_filters( 'bp_ktr_get_item_desc_truncate', $exc, $items_template->item->description, $words );
	}

        function bp_ktr_item_id() {
	echo bp_ktr_get_item_id();
}
	function bp_ktr_get_item_id() {
		global $items_template;
		return apply_filters( 'bp_ktr_get_item_id', $items_template->item->id );
	}

        function bp_ktr_item_url() {
	echo bp_ktr_get_item_url();
}
	function bp_ktr_get_item_url() {
		global $bp,$items_template;

		$owner_domain = bp_core_get_user_domain($items_template->item->user_id);
		return apply_filters( 'bp_ktr_get_item_url', $owner_domain . $bp->ktr->slug . '/'.$bp->ktr->single_slug.'/'.$items_template->item->id  . '/');
	}

        function bp_ktr_item_org_path() {
	echo bp_ktr_get_item_org_path();
}
	function bp_ktr_get_item_org_path() {

		global $bp, $items_template;

		if($bp->ktr->bp_ktr_url_remap == true){

		    $filename = substr( $items_template->item->pic_thumb_url, strrpos($items_template->item->pic_org_url, '/') + 1 );
		    $owner_id = $items_template->item->owner_id;
		    $result = $bp->ktr->bp_ktr_base_url . '/' . $owner_id . '/' . $filename;

		    return $result;
		}
		else {
		    return apply_filters( 'bp_ktr_get_item_org_path', bp_get_root_domain().$items_template->item->pic_org_url );
		}
	}

/**
 * End here is code for may be single item info
 */

function bp_ktr_item_name() {
	echo bp_ktr_get_item_name();
}
	/* Always provide a "get" function for each template tag, that will return, not echo. */
	function bp_ktr_get_item_name() {
		global $items_template;
		echo apply_filters( 'bp_ktr_get_item_name', $items_template->item->name ); // Example: $items_template->item->name;
	}

function bp_ktr_item_pagination() {
	echo bp_ktr_get_item_pagination();
}
	function bp_ktr_get_item_pagination() {
		global $items_template;
		return apply_filters( 'bp_ktr_get_item_pagination', $items_template->pag_links );
	}

?>