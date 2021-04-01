<?php
/*
 * Template Name: Trail Guide
 * Template Post Type: post

This is my single post template to handle posts with extra info at the top.

 */


  //Entry Header stuff

  //removes the author, comment, dates
  remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

  //adds back in categories and fancy div
  add_action ('genesis_entry_header', 'genesis_post_meta',12);
  add_filter ('genesis_post_meta', 'sp_post_meta_filter' );


  function sp_post_meta_filter($post_meta) {
          	$post_meta = '[post_categories before=""]';
          	return $post_meta;
  }

  // Date to the top
  /*

  add_action( 'genesis_entry_header', 'genesis_post_info', 13 );
  add_filter( 'genesis_post_info', 'post_info_filter' );

  function post_info_filter($post_info) {
            $post_info = '[post_date]';
            return $post_info;
          } */



          //featured image
          add_action ('genesis_entry_header', 'laura_single_post_header', 13);

          function laura_single_post_header() {

            if ( has_post_thumbnail() ) {

                  $featured_image = get_post_thumbnail_id();
                  $size = 'medium';

                  echo wp_get_attachment_image( $featured_image, $size );

                }

          }



// excerpt + trail guide

add_action ('genesis_before_entry_content', 'laura_trail_guide');

function laura_trail_guide() {

  ?>
  <div class="excerpt-mobile"><?php the_excerpt()?> </div>
    <div class="arrow-left"><?php the_field('trail_guide');?></div>
  <?php

}


//Add Pinterest Image
add_filter('the_content', 'laura_pinterest_image');

function laura_pinterest_image($content) {

      $image = get_field('pinterest_image');

      if( !empty($image) ) {
      $content .= '<hr><div class="post_pinterest"><img src="' . $image['url'] . '" alt="' . $image['alt'] . '" data-pin-url="' . get_permalink() . '" data-pin-media="' . $image['url'] . '" data-pin-description="' . $image['alt'] . '" /></div>';
    }
      ?>

        <?php
        return $content;
        ?>

    <?php

}


// Related post
add_action ('genesis_after_entry', 'laura_related_post', 5);

function laura_related_post() {

?>
<hr>
<div class="related-posts clearfix">
<h3>Related Posts</h3>

<?php
// Get a list of the current post's categories
  global $post;
  $categories = get_the_category( $post->ID );

  $catidlist = '';
    foreach( $categories as $category) {
        $catidlist .= $category->cat_ID . ",";
}

// Build our category based custom query arguments
  $custom_query_args = array(
    'posts_per_page' => 3, // Number of related posts to display
    'post__not_in' => array($post->ID), // Ensure that the current post is not displayed
    'orderby' => 'rand', // Randomize the results
    'cat' => $catidlist, // Select posts in the same categories as the current post
);
// Initiate the custom query
$custom_query = new WP_Query( $custom_query_args );

// Run the loop and output data for the results
if ( $custom_query->have_posts() ) : ?>
	<?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
		<?php if ( has_post_thumbnail() ) { ?>
			<div><a href="<?php the_permalink(); ?>"> <?php the_post_thumbnail( 'thumbnail' ); ?></a>
		<?php } ?>
		<a href="<?php the_permalink(); ?>"><b><?php the_title(); ?></b></a></div>
	<?php endwhile;
endif;
// Reset postdata
wp_reset_postdata();
?></div>
<hr>
<?php
}



// Footer Info (Category)
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );



add_filter( 'comment_author_says_text', 'sp_comment_author_says_text' );
function sp_comment_author_says_text() {
	return;
}

add_filter( 'genesis_show_comment_date', 'jmw_show_comment_date_only' );
/**
 * Show date on comments without time or link
 *
 * Stop the output of the Genesis core comment dates and outputs comments with date only
 * The genesis_show_comment_date filter was introduced in Genesis 2.2 (will not work with older versions)
 */
function jmw_show_comment_date_only( $comment_date ) {
	printf('<p %s><time %s>%s</time></p>',
		genesis_attr( 'comment-meta' ),
		genesis_attr( 'comment-time' ),
		esc_html( get_comment_date() )
	);
	// Return false so that the parent function doesn't output the comment date, time and link
	return false;
}


genesis();
