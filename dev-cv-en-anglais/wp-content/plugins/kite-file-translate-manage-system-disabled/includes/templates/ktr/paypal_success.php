
<?php get_header() ?>

	<div id="content">
		<div class="padder">

			<div id="item-header">
				<?php locate_template( array( 'members/single/member-header.php' ), true ) ?>
			</div>

			<div id="item-nav">
				<div class="item-list-tabs no-ajax" id="object-nav">
					<ul>
						<?php bp_get_displayed_user_nav() ?>
					</ul>
				</div>
			</div>

			<div id="item-body">
                Payment completed successfully.
			</div><!-- #item-body -->

			
		</div><!-- .padder -->
	</div><!-- #content -->

	<?php locate_template( array( 'sidebar.php' ), true ) ?>

<?php get_footer() ?>