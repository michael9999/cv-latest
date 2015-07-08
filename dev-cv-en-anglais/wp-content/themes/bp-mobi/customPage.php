<?php
/*
Template Name: customPage
*/
?>

<!DOCTYPE HTML>

<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
	<head profile="http://gmpg.org/xfn/11">
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
		<script type="text/javascript">
            $(document).bind("mobileinit", function() {
              $.mobile.ajaxEnabled = false;
            });
        </script>

		<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/jq/jqm.js"></script>
		<!--<script type="text/javascript" src="<?php //bloginfo('stylesheet_directory'); ?>/jq/jqm-custom.js"></script> -->
		
	</head>
	<body <?php body_class() ?> id="bp-default">

		<?php do_action( 'bp_before_header' ) ?>
		
		<div class="header">
			<div id="backBtn">
				<a rel="external" href="javascript:history.go(-1)" data-icon="back" data-role="button" data-theme="b" >Back </a>
			</div>
			<div id="logo" align="center">
				 <a href="<?php echo site_url(); ?>" rel="external" ><img src="<?php bloginfo('stylesheet_directory'); ?>/logo.png" alt="<?php bp_site_name() ?>" /></a>	
			</div>
			<div id="signing">
			<?php 
			if ( is_user_logged_in() )
			{
			global $bp;
			}
			else
			{
			
			}
			
			?>

				
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
</div>
</body>
</html>
