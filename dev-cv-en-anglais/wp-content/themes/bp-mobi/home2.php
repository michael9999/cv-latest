<?php get_header() ?>

<!-- CHANGE -->
<div class="gap-filler">

        <div class="sixteen columns"><div id="gap"></div></div>

</div>
<div class="band chief">

        <div class="container for-border">

            

                <div class="twelve columns">

                            <div id="content">

                                    <div class="padder">

                                        <div id="featured_content">

                                    <img id="featured_photo" src="http://localhost:8888/wordpress/wp-content/themes/cool_bp_theme/images/the_hills.png" alt="<?php bp_site_name() ?>" />


                                    <p id="intro_text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt. </p>

                                        </div>

                                    <?php do_action( 'bp_before_blog_home' ) ?>

                                    <div class="page" id="blog-latest">

                                        <h1>What's Going On Here</h1>

                                        <?php query_posts('posts_per_page=3'); ?>

                                        <?php if ( have_posts()) : ?>

                                            <?php while (have_posts()) : the_post(); ?>

                                                <?php do_action( 'bp_before_blog_post' ) ?>

                                                <div class="post" id="post-<?php the_ID(); ?>">

                                                    <div class="author-box">
                                                        <?php echo get_avatar( get_the_author_meta( 'user_email' ), '50' ); ?>
                                                        <p><?php printf( __( 'by %s', 'buddypress' ), bp_core_get_userlink( $post->post_author ) ) ?></p>
                                                    </div>

                                                    <div class="post-content">
                                                        <h2 class="posttitle"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ) ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

                                                        <p class="date"><?php the_time() ?> <em><?php _e( 'in', 'buddypress' ) ?> <?php the_category(', ') ?> <?php printf( __( 'by %s', 'buddypress' ), bp_core_get_userlink( $post->post_author ) ) ?></em></p>

                                                        <div class="entry">
                                                            <?php the_content( __( 'Read the rest of this entry &rarr;', 'buddypress' ) ); ?>
                                                        </div>

                                                        <p class="postmetadata"><span class="tags"><?php the_tags( __( 'Tags: ', 'buddypress' ), ', ', '<br />'); ?></span> <span class="comments"><?php comments_popup_link( __( 'No Comments &#187;', 'buddypress' ), __( '1 Comment &#187;', 'buddypress' ), __( '% Comments &#187;', 'buddypress' ) ); ?></span></p>
                                                    </div>

                                                </div>

                                                <?php do_action( 'bp_after_blog_post' ) ?>

                                            <?php endwhile; ?>

                                            <div class="navigation">

                                                <div class="alignleft"><?php next_posts_link( __( '&larr; Previous Entries', 'buddypress' ) ) ?></div>
                                                <div class="alignright"><?php previous_posts_link( __( 'Next Entries &rarr;', 'buddypress' ) ) ?></div>

                                            </div>

                                        <?php else : ?>

                                            <h2 class="center"><?php _e( 'Not Found', 'buddypress' ) ?></h2>
                                            <p class="center"><?php _e( 'Sorry, but you are looking for something that isn\'t here.', 'buddypress' ) ?></p>

                                            <?php locate_template( array( 'searchform.php' ), true ) ?>

                                        <?php endif; ?>
                                    </div>

                                    <h1>The Community Members</h1>

                                    <?php if ( bp_has_members('per_page=5') ) : ?>

                                <div class="pagination">

                                    <div class="pag-count" id="member-dir-count">
                                        <?php bp_members_pagination_count() ?>
                                    </div>

                                    <div class="pagination-links" id="member-dir-pag">
                                        <?php bp_members_pagination_links() ?>
                                    </div>

                                </div>

                                <?php do_action( 'bp_before_directory_members_list' ) ?>

                                <ul id="members-list" class="item-list">
                                <?php while ( bp_members() ) : bp_the_member(); ?>

                                    <li>
                                        <div class="item-avatar">
                                            <a href="<?php bp_member_permalink() ?>"><?php bp_member_avatar() ?></a>
                                        </div>

                                        <div class="item">
                                            <div class="item-title">
                                                <a href="<?php bp_member_permalink() ?>"><?php bp_member_name() ?></a>
                                                <?php if ( bp_get_member_latest_update() ) : ?>
                                                    <span class="update"> - <?php bp_member_latest_update( 'length=10' ) ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="item-meta"><span class="activity"><?php bp_member_last_active() ?></span></div>

                                            <?php do_action( 'bp_directory_members_item' ) ?>

                                            <?php
                                             /***
                                              * If you want to show specific profile fields here you can,
                                              * but it'll add an extra query for each member in the loop
                                              * (only one regadless of the number of fields you show):
                                              *
                                              * bp_member_profile_data( 'field=the field name' );
                                              */
                                            ?>
                                        </div>

                                        <div class="action">
                                            <?php do_action( 'bp_directory_members_actions' ) ?>
                                        </div>

                                        <div class="clear"></div>
                                    </li>

                                <?php endwhile; ?>
                                </ul>

                                <?php do_action( 'bp_after_directory_members_list' ) ?>

                                <?php bp_member_hidden_fields() ?>

                            <?php else: ?>

                                <div id="message" class="info">
                                    <p><?php _e( "Sorry, no members were found.", 'buddypress' ) ?></p>
                                </div>

                            <?php endif; ?>

                                    <?php do_action( 'bp_after_blog_home' ) ?>

                                    </div><!-- .padder -->
                                </div><!-- #content -->
                            </div><!-- .ten columns -->

                          <div class="four columns">

                                <?php locate_template( array( 'sidebar.php' ), true ) ?>

                          </div>

              

                          </div><!-- .container -->


</div><!-- .band chief -->

<?php get_footer() ?>
