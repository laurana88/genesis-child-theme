<?php
/**

* Template Name: Frontpage Template
* Description: Template used for the homepage

*/

// This is my homepage Hero

//adding in background size for mobile and desktop
add_action('wp_head', 'laura_background');

function laura_background() {
  $hero = get_field('hero_background');
  $greenville = get_field('greenville_image');
  $size1 = 'full';
  $size2 = 'large';
  $size3 = 'medium';
  $image1 = wp_get_attachment_image_src($hero, $size1);
  $image2 = wp_get_attachment_image_src($hero, $size2);
  $image3 = wp_get_attachment_image_src($hero, $size3);
  $imagelarge = wp_get_attachment_image_src($greenville, $size2);
  $imagemedium = wp_get_attachment_image_src($greenville, $size3);

  ?>
  <style>
  .laura_homepage_hero {
    background-image: linear-gradient(to bottom, rgba(0,0,0,.3), rgba(0,0,0,.1)), url('<?php echo $image3[0];?>');
  }


  @media (min-width: 425px) {
          .laura_homepage_hero {
              background-image: linear-gradient(to bottom, rgba(0,0,0,.3), rgba(0,0,0,.1)), url('<?php echo $image2[0];?>');
            }
          }

    @media (min-width: 769px) {
      .laura_homepage_hero {
          background-image: linear-gradient(to bottom, rgba(0,0,0,.3), rgba(0,0,0,.1)), url('<?php echo $image1[0];?>');
        }
      }

        .home-greenville {
          background-image: linear-gradient(to bottom, rgba(0,0,0,.2), rgba(0,0,0,.2)), url('<?php echo $imagemedium[0];?>');
        }


          @media (min-width: 769px) {
            .home-greenville {
                background-image: linear-gradient(to bottom, rgba(0,0,0,.2), rgba(0,0,0,.2)), url('<?php echo $imagelarge[0];?>');
              }
            }

    </style>
    <?php
  }

//Adds the background size
add_action( 'genesis_before_header', 'laura_homepage_hero');

function laura_homepage_hero() {
 ?>
 <div class="laura_homepage_hero">

 <?php
 }

 add_action( 'genesis_after_header', 'laura_homepage_hero2');

 function laura_homepage_hero2() {

 ?>
</div>
 <?php
 }



// This is the homepage header text
 add_action( 'genesis_header', 'do_homepage_header',12 );

 function do_homepage_header() {


		//Homepage Hero Text

				?>

        <div class="home-main-tagline">
          <h1 class="home-tagline-top"><?php the_field('hero_text_1')?></h1>
          <h2 class="home-tagline-bottom"><?php the_field('hero_text_2')?></h2>
          <h2 class="home-tagline-final"><?php the_field('hero_text_3')?></h2>
        </div>

				<?php

	}

  //* Remove Page Title
  remove_action( 'genesis_entry_header', 'genesis_do_post_title' );




// Featured Posts

add_action ('genesis_after_entry', 'laura_featured2' );

function laura_featured2() {

  $image1 = get_field('featured_image_1');
  $image2 = get_field('featured_image_2');
  $image3 = get_field('featured_image_3');
  $image4 = get_field('featured_image_4');
  $image5 = get_field('featured_image_5');
  $size1 = 'blogindex-size';
  $size2 = 'medium';


?>
  <div class="moarhome">
    <div class="homepage-section homepage-section-first clearfix">
      <h2 class="section-header"><?php the_field('featured_title')?><span class="section-header-sub sub-desktop">&nbsp;&nbsp;&nbsp;&nbsp;<?php the_field('featured_title_sub')?></span>
      <span class="section-header-sub sub-mobile"><br><?php the_field('featured_title_sub')?></span></h2>

      <div class="featured-section featured-top">
        <a href="<?php the_field('featured_link_1')?>">
          <?php echo wp_get_attachment_image( $image1, $size1 );?>
          <div class="featured-text2">
            <h6 class="featured-headingsub">Explore</h6>
            <h4 class="featured-heading2"><?php the_field('featured_text_1');?>
              </h4>
          </div>
          </a>
      </div>

      <div class="featured-section featured-top">
        <a href="<?php the_field('featured_link_2')?>">
          <?php echo wp_get_attachment_image( $image2, $size1 );?>
          <div class="featured-text2">
            <h6 class="featured-headingsub">Explore</h6>
            <h4 class="featured-heading2"><?php the_field('featured_text_2');?>
              </h4>
          </div>
          </a>
      </div>

      <div class="featured-section featured-top">
        <a href="<?php the_field('featured_link_3')?>">
          <?php echo wp_get_attachment_image( $image3, $size1 );?>
          <div class="featured-text2">
            <h6 class="featured-headingsub">Explore</h6>
            <h4 class="featured-heading2"><?php the_field('featured_text_3');?>
              </h4>
          </div>
          </a>
      </div>


      <div class="featured-section featured-bottom">
        <a href="<?php the_field('featured_link_4')?>">
          <?php echo wp_get_attachment_image( $image4, $size2 );?>
          <div class="featured-text2">
            <h6 class="featured-headingsub">Explore</h6>
            <h4 class="featured-heading2"><?php the_field('featured_text_4');?>
              </h4>
          </div>
          </a>
      </div>

      <div class="featured-section featured-bottom">
        <a href="<?php the_field('featured_link_5')?>">
          <?php echo wp_get_attachment_image( $image5, $size2 );?>
          <div class="featured-text2">
            <h6 class="featured-headingsub">Explore</h6>
            <h4 class="featured-heading2"><?php the_field('featured_text_5');?>
              </h4>
          </div>
          </a>
      </div>


    </div>
  </div>

<?php
}

// About Me

add_action ('genesis_after_entry', 'laura_about' );

function laura_about() {

  $image1 = get_field('about_image');
  $size1 = 'large';

  ?>

  <div class="moarhome">
    <div class="homepage-section clearfix">

      <div class="home-aboutimage-section desktop">
          <?php echo wp_get_attachment_image( $image1, $size1 );?>
      </div>

      <div class="home-abouttext-section">
        <h4 class="home-subtext"><?php the_field('about_subtext')?></h4>
        <h2 class="home-tagline"><?php the_field('about_tagline')?></h2>
        <p class="home-abouttext"><?php the_field('about_text')?></p>

          <!-- Begin MailChimp Signup Form -->
        <div class="my-subscribe-form clearfix">
          <div id="mc_embed_signup">
          <form action="//musingsofarover.us10.list-manage.com/subscribe/post?u=8586929758afca3cea8a8e13f&amp;id=39dbdd7a02" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
              <div id="mc_embed_signup_scroll">

            <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="EMAIL ADDRESS" required>
              <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
              <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_8586929758afca3cea8a8e13f_39dbdd7a02" tabindex="-1" value=""></div>
              <div class="clear"><input class="button" type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe"></div>
              </div>
          </form>
          </div>
      </div>
<!--End mc_embed_signup-->
      </div>

      <div class="home-aboutimage-section tablet">
        <?php echo wp_get_attachment_image( $image1, $size1 );?>
      </div>

    </div>
  </div>


<?php
}

// Homepage Sections
add_action( 'genesis_loop', 'laura_homepage_loop' );

function laura_homepage_loop() {

// Recent Posts Section
  ?>
  <div class="moarhome">
  <div class="homepage-section">
  <?php

	$args = array(
		'orderby'       => 'date',
		'order'         => 'DESC',
		'posts_per_page'=> '3', // overrides posts per page in theme settings
    'post_type'     => 'post',
    'post_status'   => 'publish',
	);

	$loop = new WP_Query( $args );
	if( $loop->have_posts() ) {

		// this is shown before the loop
    ?>
		<h2 class="section-header">Recent Posts</h2>
      <div class="row-of-posts clearfix">
    <?php

		// loop through posts
		while( $loop->have_posts() ): $loop->the_post();
    echo '<div class="homepage-post">';
    echo '<a href="' . get_the_permalink() .'"><div class="homepage-post-background">';
    echo the_post_thumbnail( 'blogindex-size' ). '</a>';
    echo '<div class="post-text">';
    echo '<h4><a href="' . get_the_permalink() .'">'. get_the_title() . '</a></h4>';
    echo '<p>' . get_the_excerpt() . '</p>';
    echo '<p class="readmorelink"><a href=" '.get_the_permalink() . '">READ MORE&nbsp<i class="fas fa-angle-double-right"></i></a></p>';
		echo '</div>';
    echo '</div>';
    echo '</div>';
		endwhile;
    ?>
    </div>

    <div class="homepage-section-button">
    <a class="button button-alt" href="./blog/">More on the blog</a>
    </div>
    <?php
	}
	wp_reset_postdata();

  ?>
</div>
</div>

<?php



// Greenville

  ?>

  <div class="moarhome">
    <div class="homepage-section clearfix">
      <div class="home-greenville">
        <div class="greenville-title"><h3>greenville, SC</h3>
        </div>
        <div class="greenville-sub">
          <h5><?php the_field('greenville_description')?></h5>
          <a class="button button2" href="<?php the_field('greenville_url')?>">Explore Greenville</a>
        </div>

      </div>

    </div>
  </div>

  <?php



// New Travel guides

  ?>

  <div class="moarhome">
    <div class="homepage-section flex-container">

      <div class="content-text">
        <h4 class="home-subtext">Let's do this.</h4>
        <?php the_field('content')?>
        <div class="two-buttons">
        <a class="button button-alt" href="<?php the_field('guidebutton-url1')?>"><?php the_field('guidebutton-text1')?></a>
        <a class="button button-alt" href="<?php the_field('guidebutton-url2')?>"><?php the_field('guidebutton-text2')?></a>
      </div>
      </div>

      <div class="content-imageblock">

        <?php

        // Add Travel guides

          // check if the flexible content field has rows of data
          if( have_rows('homepage_content') ):

           	// loop through the rows of data
              while ( have_rows('homepage_content') ) : the_row();

              // This is the start of the travel guides layout
                if( get_row_layout() == 'travelguides_home' ):

                      // check if the nested repeater field has rows of data - COLUMN 1
                      if( have_rows('travelguide_column1') ):
                        ?>
                        <div class="content-column">
                          <?php

                    // loop through the rows of data
                      while ( have_rows('travelguide_column1') ) : the_row();

                      $image1 = get_sub_field('travelguide_img');
                      $size1 = 'medium';

                        ?>
                        <div class="travelimage">
                        <a href="<?php the_sub_field('travelguide_link')?>">
                          <?php echo wp_get_attachment_image( $image1, $size1 );?>
                          <div class="guidetext"><h4><?php the_sub_field('travelguide_text')?></h4></div>
                        </a></div>
                        <?php

                       endwhile;
                       ?>
                     </div>
                         <?php

                     endif; // this ends the COLUMN 1

                     // check if the nested repeater field has rows of data - COLUMN 2
                     if( have_rows('travelguide_column2') ):
                       ?>
                       <div class="content-column">
                         <?php

                   // loop through the rows of data
                     while ( have_rows('travelguide_column2') ) : the_row();

                     $image1 = get_sub_field('travelguide_img');
                     $size1 = 'medium';

                       ?>
                       <div class="travelimage">
                       <a href="<?php the_sub_field('travelguide_link')?>">
                         <?php echo wp_get_attachment_image( $image1, $size1 );?>
                         <div class="guidetext"><h4><?php the_sub_field('travelguide_text')?></h4></div>
                       </a></div>
                       <?php

                      endwhile;
                      ?>
                    </div>
                        <?php

                    endif; // this ends COLUMN 2



                endif; // this ends the row layout


        // while flexible content
            endwhile;

        else :

            // no layouts found

        endif;

?>


      </div>

    </div>
    </div>


<?php




// This is the end of the whole homepage fun
	wp_reset_postdata();
}

genesis();
