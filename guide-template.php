<?php
/**

* Template Name: Destination Guide Template
* Description: Template used for the destination guides

*/


add_action ('genesis_before_content_sidebar_wrap', 'laura_page_header');

function laura_page_header() {

  if ( has_post_thumbnail() ) {
    $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(), $size = 'large');
    ?>

    <div class="laura-page-header2" style="background-image:url('<?php echo $featured_image[0] ?>')">
      <?php
    }

    else {
      ?>
        <div class="laura-page-header2">
          <?php
        }

    ?>
        <h1 class="page-header"><?php
        echo get_the_title();
      ?></h1>
    </div>
    <?php

}


remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );




add_action ('genesis_after_entry', 'laura_guide', 5);

function laura_guide() {


  // Flexible Content Start

  // check if the flexible content field has rows of data
  if( have_rows('content') ):

   	// loop through the rows of data
      while ( have_rows('content') ) : the_row();


        // Guide Navigation
          if( get_row_layout() == 'navigation' ):

            ?>

            <div class="moarguide-navigation">
              <div class="guide-section">
                <div class="guide-flexcontainer flexcontainer-margin-right">

            <?php

                // check if the nested repeater field has rows of data
                if( have_rows('navigation_row') ):

              // loop through the rows of data
                while ( have_rows('navigation_row') ) : the_row();

                  ?>
                  <a class="navigationblock" href="<?php the_sub_field('navigation_link')?>">
                      <i class="fa <?php the_sub_field('fa_code'); ?>" aria-hidden="true"></i>
                      <span><?php the_sub_field('navigation_name')?></span>
                  </a>
                  <?php

                 endwhile;

                 echo '</div></div></div>';

               endif;

          endif; // this ends the navigation row layout


        // This is the start of the top 5 layout
        if( get_row_layout() == 'top5_blocks' ):

              ?>
              <a id="<?php the_sub_field('id')?>"></a>
              <div class="moarguide-top5">
              <div class="guide-section">
                <h2 class="guidesection-header"><?php the_sub_field('title')?></h2>
                <div class="guide-flexcontainer">
              <?php

                  // check if the nested repeater field has rows of data
                  if( have_rows('top5_row') ):

                // loop through the rows of data
                  while ( have_rows('top5_row') ) : the_row();

                  $image = get_sub_field('block_img');
                  $url = $image['url'];
                  $size = 'medium';
  	              $thumb = $image['sizes'][ $size ];

                  $link = get_sub_field('block_link');

                    ?>
                    <a href="<?php echo $link['url']; ?>">
                      <div class="top5block" style="background-image:url('<?php echo $thumb; ?>')">
                        <h5 class="top5description"><?php the_sub_field('block_description')?></h5>
                        <h5 class="top5name"><?php the_sub_field('block_name')?></h5>
                      </div>
                    </a>
                    <?php

                   endwhile;

                   echo '</div></div></div>';

                 endif;

            endif; // this ends the top 5 row layout



      // This is the gray icon blocks
        if( get_row_layout() == 'icon_blocks' ):

          ?>
          <a id="<?php the_sub_field('id')?>"></a>
          <div class="moarguide-iconblocks">
          <div class="guide-section">
            <h2 class="guidesection-header"><?php the_sub_field('title')?></h2>
            <div class="guide-flexcontainer">
          <?php

              // check if the nested repeater field has rows of data
              if( have_rows('icon_row') ):

            // loop through the rows of data
              while ( have_rows('icon_row') ) : the_row();

              $link = get_sub_field('block_link');

                ?>

                <a class="no-hover" href="<?php echo $link['url']; ?>" target="<?php echo $link['target']; ?>">
                  <div class="guide-block">
                    <h4><?php the_sub_field('block_name')?></h4>
                    <div class="blockicon">

                    <?php
                    if( get_sub_field('icon_type') == 'font' ):

                        ?><i class="guide-icon fas <?php the_sub_field('fa_code'); ?>"></i><?php

                    elseif( get_sub_field('icon_type') == 'image' ):

                      ?>
                      <img src="<?php the_sub_field('icon_img')?>">
                      <?php
                    endif;

                  ?>
                      </div>
                    </div>
                  </a>
                <?php

               endwhile;

               echo '</div></div></div>';

             endif;

        endif; // this ends the icon gray row layout



        // This is the start of the picture block layout
          if( get_row_layout() == 'picture_blocks' ):

            ?>
            <a id="<?php the_sub_field('id')?>"></a>
            <div class="moarguide-pictureblocks">
            <div class="guide-section">
              <h2 class="guidesection-header"><?php the_sub_field('title')?></h2>
              <div class="guide-flexcontainer">
            <?php

                // check if the nested repeater field has rows of data
                if( have_rows('pictureblock_row') ):

              // loop through the rows of data
                while ( have_rows('pictureblock_row') ) : the_row();

                $image = get_sub_field('block_img');
                $url = $image['url'];
                $size = 'large';
                $thumb = $image['sizes'][ $size ];

                $link = get_sub_field('block_link');

                  ?>
                  <a href="<?php echo $link['url']; ?>" target="<?php echo $link['target']; ?>">
                    <div class="season-block" style="background-image:url('<?php echo $thumb; ?>')">
                      <h2 class="guide-white"><?php the_sub_field('block_name')?></h2>
                    </div>
                  </a>
                  <?php

                 endwhile;

                 echo '</div></div></div>';

               endif;

          endif; // this ends the season row layout




  // while flexible content
      endwhile;

  else :

      // no layouts found

  endif;



?>


<!-- Recent Greenville Posts -->
<a id="<?php the_field('recent_posts_id')?>"></a>
<div class="moarguide-recentposts">
<div class="guide-section">
  <h2 class="guidesection-header"><?php the_field('recent_posts_title')?></h2>
    <div class="guide-posts">

<?php

// this is the array that controls what displays in the loop

  $category = get_field('select_category');

  $args = array(
  		'orderby'       => 'date',
  		'order'         => 'DESC',
  		'posts_per_page'=> '15', // overrides posts per page in theme settings
      'post_type'     => 'post',
      'post_status'   => 'publish',
      'category_name' => $category
  	);

  	$loop = new WP_Query( $args );
  	if( $loop->have_posts() ) {

  		// loop through posts
  		while( $loop->have_posts() ): $loop->the_post();
      echo '<div class="homepage-post guide-post">';
      echo '<a href="' . get_the_permalink() .'"><div class="homepage-post-background">';
      echo the_post_thumbnail( 'medium' ). '</a>';
      echo '<a href="' . get_the_permalink() .'"><h4>'. get_the_title() . '</a></h4>';
      echo '</div>';
      echo '</div>';
  		endwhile;

    }

wp_reset_postdata();

      ?>
      </div>

      <div class="homepage-section-button">
        <a class="button button-alt" href="<?php the_field('recent_posts_link');?>"><?php the_field('recent_posts_button_text');?></a>
      </div>


</div>
</div>

<?php


}

genesis();
