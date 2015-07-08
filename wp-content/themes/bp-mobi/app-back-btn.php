<?php
/*
Template Name: App
*/
?>

<!DOCTYPE HTML>

<html>
	<head profile="http://gmpg.org/xfn/11">
		<meta charset="utf-8">
		<meta content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name="viewport" />
		<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ) ?>; charset=<?php bloginfo( 'charset' ) ?>" />
		<title><?php wp_title( '|', true, 'right' ); bloginfo( 'name' ); ?></title>

		<?php do_action( 'bp_head' ) ?>

		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ) ?>" />
		
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/jqm.css" />
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/app.css" />

		<?php
			if ( is_singular() && bp_is_blog_page() && get_option( 'thread_comments' ) )
				wp_enqueue_script( 'comment-reply' );

			wp_head();
		?>
		<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/jq/jq.js"></script>
		<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/jq/custom.js"></script>
		<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/jq/accordion-trial.js"></script>
		<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/jq/help.js"></script>
        
		<script type="text/javascript">
            $(document).bind("mobileinit", function() {
              $.mobile.ajaxEnabled = false;
            });
			
			$(document).bind("mobileinit", function(){
			  $.mobile.page.prototype.options.addBackBtn = true;
			});
        </script>

		<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/jq/jqm.js"></script>
		<!--<script type="text/javascript" src="<?php //bloginfo('stylesheet_directory'); ?>/jq/jqm-custom.js"></script> -->
		
	</head>
	<body <?php body_class() ?> id="bp-default">

		<?php do_action( 'bp_before_header' ) ?>
		
		<div class="header">
			<div id="backBtn">
				<a rel="external" href="javascript:history.go(-1)" data-icon="back" data-role="button" data-theme="b" ><!--<img src="<?php// bloginfo('stylesheet_directory'); ?>/back.png" alt="Back" />-->Back </a>
			</div>
			<div id="logo" align="center">
				 <a href="<?php echo site_url(); ?>" rel="external" ><img src="<?php bloginfo('stylesheet_directory'); ?>/logo.png" alt="<?php bp_site_name() ?>" /></a>	
			</div>
			<div id="signing">
			<?php 
			if ( is_user_logged_in() )
			{
			global $bp;
			
/*			echo '<div id="myprofile"><div>My Profile</div>';
			echo '<ul>';
		
			// Loop through each navigation item
			$counter = 0;
			foreach( (array)$bp->bp_nav as $nav_item ) {
				$alt = ( 0 == $counter % 2 ) ? ' class="alt"' : '';
		
				if ( -1 == $nav_item['position'] )
					continue;
		
				echo '<li' . $alt . '>';
				echo '<a rel="external" id="bp-admin-' . $nav_item['css_id'] . '" href="' . $nav_item['link'] . '">' . $nav_item['name'] . '</a>';
		
				
		
				echo '</li>';
		
				$counter++;
			}
		
			$alt = ( 0 == $counter % 2 ) ? ' class="alt"' : '';
		
			echo '<li' . $alt . '><a rel="external" id="bp-admin-logout" class="logout" href="' . wp_logout_url( home_url() ) . '">' . __( 'Log Out', 'buddypress' ) . '</a></li>';
			echo '</ul>';
			echo '</div>';*/
			}
			else
			{
			/*	
				echo '<span><a rel="external" href="' . bp_get_root_domain() . '/wp-login.php?redirect_to=' . urlencode( bp_get_root_domain() ) . '">Sign In</a></span>|';

			// Show "Sign Up" link if user registrations are allowed
			if ( bp_get_signup_allowed() )
			echo '<span><a rel="external" href="' . bp_get_signup_page(false) . '">Register</a></span>'; 
			*/
			}
			
			?>

				<!--<span><a href="http://localhost/wp/wp-login.php?redirect_to=http%3A%2F%2Flocalhost%2Fwp">Sign In</a></span>|<span><a href="">Register</a></span> -->
			</div>
		</div>
<!--		<div class="searchbar">
			<form action="<?php// echo bp_search_form_action() ?>" method="post" id="search-form">
				<div id="searchinput" >
					<label for="search-terms" class="accessibly-hidden"><?php// _e( 'Search for:', 'buddypress' ); ?></label>
					<input type="search" name="search-terms" id="search-terms" value="<?php// echo isset( $_REQUEST['s'] ) ? esc_attr( $_REQUEST['s'] ) : ''; ?>" />
				</div>
				<div id="searchSelection">
					<?php// echo bp_search_form_type_select() ?>
				</div>
				<div id="searchgo" >
					<input type="submit" data-role="none" class="searchgobtn" name="search-submit" id="search-submit" value="<?php// _e( 'Go', 'buddypress' ) ?>" />
				</div>
				<?php// wp_nonce_field( 'bp_search_form' ) ?>
			</form>
		</div> -->
		<div id="appheader" align="center">
			<div data-role="controlgroup" data-type="horizontal">
				<a href="<?php echo site_url(); ?>" data-role="button" data-theme="b">Search</a>
				<a href="<?php echo site_url(); ?>" data-role="button" data-theme="b">Main Menu</a>
				<a href="index.html" data-role="button" data-theme="b">My Profile</a>
			</div>
		</div>

		<?php do_action( 'bp_search_login_bar' ) ?>

		<?php do_action( 'bp_after_header' ) ?>
		<?php do_action( 'bp_before_container' ) ?>
		
		

		<div id="Appcontainer">

	<div id="Appcontent">
		<div class="Apppadder">

		<?php do_action( 'bp_before_blog_page' ) ?>

		<div class="page" id="blog-page" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<!-- <h2 class="pagetitle"><?php //the_title(); ?></h2> -->

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<div class="entry" align="center">

						<?php the_content( __( '<p class="serif">Read the rest of this page &rarr;</p>', 'buddypress' ) ); ?>

						<?php wp_link_pages( array( 'before' => '<div class="page-link"><p>' . __( 'Pages: ', 'buddypress' ), 'after' => '</p></div>', 'next_or_number' => 'number' ) ); ?>
						<?php //edit_post_link( __( 'Edit this page.', 'buddypress' ), '<p class="edit-link">', '</p>'); ?>

					</div>

				</div>

			<?php //comments_template(); ?>

			<?php endwhile; endif; ?>

		</div><!-- .page -->

		<?php// do_action( 'bp_after_blog_page' ) ?>

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php //get_sidebar() ?>

<div id="appheader" align="center">
			<div data-role="controlgroup" data-type="horizontal">
				<a href="<?php echo site_url(); ?>" data-role="button" data-theme="b">Search</a>
				<a href="<?php echo site_url(); ?>" data-role="button" data-theme="b">Main Menu</a>
				<a href="index.html" data-role="button" data-theme="b">My Profile</a>
			</div>
		</div>
</div>
</body>
</html>
