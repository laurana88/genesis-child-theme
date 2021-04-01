<?php
/**

* Template Name: Places Template
* Description: Template used for the places page

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




//Links to USA & Europe & Caribbean

add_action( 'genesis_entry_content', 'laura_placelinks', 11 );

function laura_placelinks() {

?>

<div class="place-links">
  <?php the_field('place_links')?>
</div>

<?php
}

// New Place Sections

add_action( 'genesis_entry_content', 'laura_flexible_place', 11 );

function laura_flexible_place() {

// check if the flexible content field has rows of data
if( have_rows('place_section') ):

 	// loop through the rows of data
    while ( have_rows('place_section') ) : the_row();

    // Sub Place Row - like cities and states
		// check current row layout
        if( get_row_layout() == 'sub_place_row' ):

          ?>
          <hr class="places-line">
          <a id="<?php the_sub_field('place_location_id')?>"></a>
          <h2 class="country"><?php the_sub_field('place_location')?></h2>

          <?php

          if( have_rows('sub_place') ):

          while ( have_rows('sub_place') ) : the_row();

           ?>
          <h3 class="region"><?php the_sub_field('place_sub_location')?></h3>
          <div class="grid">
          <?php

            	// check if the nested repeater field has rows of data
            	if( have_rows('place_block') ):

    			 	// loop through the rows of data
    			    while ( have_rows('place_block') ) : the_row();

                ?>
                <figure class="effect-bubba">
                  <img src="<?php the_sub_field('place_image') ?>" alt="<?php the_sub_field('place_name') ?>"/>
                  <figcaption>
                    <h2><?php the_sub_field('place_name') ?></h2>
                    <p></p>
                    <a href="<?php the_sub_field('place_link') ?>"></a>
                  </figcaption>
                </figure>
                <?php

    				   endwhile;

				       echo '</div>';

             endif;

          endwhile;

			endif;

        endif;

    // Country Place
        if( get_row_layout() == 'country_place_row' ):

          ?>
          <hr class="places-line">
          <a id="<?php the_sub_field('place_location_id')?>"></a>
          <h2 class="country"><?php the_sub_field('place_location')?></h2>
          <div class="grid">
          <?php

              // check if the nested repeater field has rows of data
              if( have_rows('place_block') ):

            // loop through the rows of data
              while ( have_rows('place_block') ) : the_row();

                ?>
                <figure class="effect-bubba">
                  <img src="<?php the_sub_field('place_image') ?>" alt="<?php the_sub_field('place_name') ?>"/>
                  <figcaption>
                    <h2><?php the_sub_field('place_name') ?></h2>
                    <p></p>
                    <a href="<?php the_sub_field('place_link') ?>"></a>
                  </figcaption>
                </figure>
                <?php

               endwhile;

               echo '</div>';

             endif;

        endif;

    endwhile;

else :

    // no layouts found

endif;

}



genesis();
