<?php
/**
 * Laura New Theme 2.0
 *
 * This file adds functions to the Genesis Sample Theme.
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

// Starts the engine.
require_once get_template_directory() . '/lib/init.php';

// Defines constants to help enqueue scripts and styles.
define( 'CHILD_THEME_HANDLE', sanitize_title_with_dashes( wp_get_theme()->get( 'Name' ) ) );
define( 'CHILD_THEME_VERSION', wp_get_theme()->get( 'Version' ) );

// Sets up the Theme.
require_once get_stylesheet_directory() . '/lib/theme-defaults.php';

add_action( 'after_setup_theme', 'genesis_sample_localization_setup' );
/**
 * Sets localization (do not remove).
 *
 * @since 1.0.0
 */
function genesis_sample_localization_setup() {

	load_child_theme_textdomain( 'genesis-sample', get_stylesheet_directory() . '/languages' );

}

// Adds helper functions.
require_once get_stylesheet_directory() . '/lib/helper-functions.php';

// Adds image upload and color select to Customizer.
require_once get_stylesheet_directory() . '/lib/customize.php';

// Includes Customizer CSS.
require_once get_stylesheet_directory() . '/lib/output.php';

// Adds WooCommerce support.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php';

// Adds the required WooCommerce styles and Customizer CSS.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php';

// Adds the Genesis Connect WooCommerce notice.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php';

add_action( 'after_setup_theme', 'genesis_child_gutenberg_support' );
/**
 * Adds Gutenberg opt-in features and styling.
 *
 * @since 2.7.0
 */
function genesis_child_gutenberg_support() { // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- using same in all child themes to allow action to be unhooked.
	require_once get_stylesheet_directory() . '/lib/gutenberg/init.php';
}

add_action( 'wp_enqueue_scripts', 'genesis_sample_enqueue_scripts_styles' );
/**
 * Enqueues scripts and styles.
 *
 * @since 1.0.0
 */
function genesis_sample_enqueue_scripts_styles() {


	wp_enqueue_style( 'dashicons' );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script(
		'genesis-sample-responsive-menu',
		get_stylesheet_directory_uri() . "/js/responsive-menus{$suffix}.js",
		array( 'jquery' ),
		CHILD_THEME_VERSION,
		true
	);

	wp_localize_script(
		'genesis-sample-responsive-menu',
		'genesis_responsive_menu',
		genesis_sample_responsive_menu_settings()
	);

	wp_enqueue_script(
		'genesis-sample',
		get_stylesheet_directory_uri() . '/js/genesis-sample.js',
		array( 'jquery' ),
		CHILD_THEME_VERSION,
		true
	);

}

// LAURA ADDED -
add_action('wp_enqueue_scripts','my_theme_scripts_function');

function my_theme_scripts_function() {

	// My search
	wp_enqueue_script( 'laura-search-script', get_stylesheet_directory_uri() . '/js/laura-search.js', array(), '1.0.0', true);

	// My css
	wp_enqueue_style('laura_css', get_stylesheet_directory_uri() . '/laura_css.css');
  	wp_enqueue_style('laura_fonts_stylesheet', get_stylesheet_directory_uri() . '/laura_fonts_stylesheet.css');

}

// Laura Remove Font Awesome from Atomic blocks

add_action( 'wp_enqueue_scripts', 'remove_atomic_block_css');

function remove_atomic_block_css(){
    wp_dequeue_style( 'genesis-blocks-fontawesome' );
}

/**
 * Defines responsive menu settings.
 *
 * @since 2.3.0
 */
function genesis_sample_responsive_menu_settings() {

	$settings = array(
		'mainMenu'         => __( 'Menu', 'genesis-sample' ),
		'menuIconClass'    => 'dashicons-before dashicons-menu',
		'subMenu'          => __( 'Submenu', 'genesis-sample' ),
		'subMenuIconClass' => 'dashicons-before dashicons-arrow-down-alt2',
		'menuClasses'      => array(
			'combine' => array(
				'.nav-primary',
			),
			'others'  => array(),
		),
	);

	return $settings;

}

// Adds support for HTML5 markup structure.
add_theme_support( 'html5', genesis_get_config( 'html5' ) );

// Adds support for accessibility.
add_theme_support( 'genesis-accessibility', genesis_get_config( 'accessibility' ) );

// Adds viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Adds custom logo in Customizer > Site Identity.
add_theme_support( 'custom-logo', genesis_get_config( 'custom-logo' ) );

// Renames primary and secondary navigation menus.
add_theme_support( 'genesis-menus', genesis_get_config( 'menus' ) );

// Adds image sizes.
add_image_size( 'sidebar-featured', 75, 75, true );

// Adds support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Adds support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 3 );

// Removes header right widget area.
unregister_sidebar( 'header-right' );

// Removes secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Removes site layouts.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Removes output of primary navigation right extras.
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

add_action( 'genesis_theme_settings_metaboxes', 'genesis_sample_remove_metaboxes' );
/**
 * Removes output of unused admin settings metaboxes.
 *
 * @since 2.6.0
 *
 * @param string $_genesis_admin_settings The admin screen to remove meta boxes from.
 */
function genesis_sample_remove_metaboxes( $_genesis_admin_settings ) {

	remove_meta_box( 'genesis-theme-settings-header', $_genesis_admin_settings, 'main' );
	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_admin_settings, 'main' );

}

add_filter( 'genesis_customizer_theme_settings_config', 'genesis_sample_remove_customizer_settings' );
/**
 * Removes output of header and front page breadcrumb settings in the Customizer.
 *
 * @since 2.6.0
 *
 * @param array $config Original Customizer items.
 * @return array Filtered Customizer items.
 */
function genesis_sample_remove_customizer_settings( $config ) {

	unset( $config['genesis']['sections']['genesis_header'] );
	unset( $config['genesis']['sections']['genesis_breadcrumbs']['controls']['breadcrumb_front_page'] );
	return $config;

}

// Displays custom logo.
add_action( 'genesis_site_title', 'the_custom_logo', 0 );

// Repositions primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

// Repositions the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 10 );

add_filter( 'wp_nav_menu_args', 'genesis_sample_secondary_menu_args' );
/**
 * Reduces secondary navigation menu to one level depth.
 *
 * @since 2.2.3
 *
 * @param array $args Original menu options.
 * @return array Menu options with depth set to 1.
 */
function genesis_sample_secondary_menu_args( $args ) {

	if ( 'secondary' !== $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;
	return $args;

}

add_filter( 'genesis_author_box_gravatar_size', 'genesis_sample_author_box_gravatar' );
/**
 * Modifies size of the Gravatar in the author box.
 *
 * @since 2.2.3
 *
 * @param int $size Original icon size.
 * @return int Modified icon size.
 */
function genesis_sample_author_box_gravatar( $size ) {

	return 90;

}

add_filter( 'genesis_comment_list_args', 'genesis_sample_comments_gravatar' );
/**
 * Modifies size of the Gravatar in the entry comments.
 *
 * @since 2.2.3
 *
 * @param array $args Gravatar settings.
 * @return array Gravatar settings with modified size.
 */
function genesis_sample_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;
	return $args;

}



//Laura Additions Start Below (except for some script loading above)


//* Customize search form input box text
add_filter( 'genesis_search_text', 'sp_search_text' );
	function sp_search_text( $text ) {
		return esc_attr( 'Search...' );
	}

// Add search icon to navigation menu
add_filter( 'wp_nav_menu_items', 'be_add_search_to_menu', 10, 2 );

function be_add_search_to_menu( $menu, $args ) {

	if ( 'primary' !== $args->theme_location )
			return $menu;

	$menu .= '<li class="menu-item search"><a href="#"><span class="dashicons dashicons-search"></span></span></a></li>';
	return $menu;
}


//* Remove the site description - I ADDED THIS
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

//* Remove the standard do header function so I can replace it with MINE
// Laura REMOVE??? remove_action( 'genesis_header', 'genesis_do_header' );

// Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
    'menu-primary',
    'menu-secondary',
    'site-inner',
    'footer-widgets',
) );


// This is my search box - I think I need this

 add_action( 'genesis_header', 'do_laura_header' );

 function do_laura_header() {

 	global $wp_registered_sidebars;

// Add Search Popup Box
	?>
	<div class="laura_search_popup_box">
				<div class="laura_search_popup">
				<?php
					get_search_form()
					?>
				</div>
	</div>
	<?php



	}

	// This is my subscribe section. Displays above instagram except on homepage and on single post it displays after entry

	add_action ('genesis_before_footer', 'do_laura_subscribe_footer', 4);

	function do_laura_subscribe_footer() {
		if ( ! is_front_page() ) {
			?>
			<div class="moar-subscribe">
			<div class="subscribe-section clearfix">
        <div class="white-header">
							<h2>Want help with all that planning stuff?</h2>
							<p>Sign up for my newsletter and get access to some of my best tips.</p>
            </div>
              <div class="my-subscribe-form my-subscribe-form2">

								<!-- Begin MailChimp Signup Form -->
					<div id="mc_embed_signup">
					<form action="//musingsofarover.us10.list-manage.com/subscribe/post?u=8586929758afca3cea8a8e13f&amp;id=39dbdd7a02" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
							<div id="mc_embed_signup_scroll">

						<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Enter Your Email!" required>
							<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
							<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_8586929758afca3cea8a8e13f_39dbdd7a02" tabindex="-1" value=""></div>
							<div class="clear"><input class="button" type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe"></div>
							</div>
					</form>
					</div>
			</div>
			<!--End mc_embed_signup-->
			</div>
		</div>
		<?php
		}
	}


	// This is my Instagram code to add widget area above footer

		//creating new widget area
		genesis_register_widget_area( array(
			'id'          => 'instagram-footer',
			'name'        => __( 'Instagram Footer', 'Musings of a Rover' ),
			'description' => __( 'This widget area appears before the footer', 'Musings of a Rover' ),
			) );


		//add widget to the footer
		add_action ('genesis_before_footer', 'do_laura_instagram', 5);
		function do_laura_instagram() {

	    genesis_widget_area( 'instagram-footer', array(
			'before' => '<div class="instagram-footer">',
	    'after' => '</div>',
		) );

	}

	//add widget title hyperlink
	add_filter( 'widget_title', 'accept_html_widget_title' );
	function accept_html_widget_title( $mytitle ) {

  // The sequence of String Replacement is important!!

	$mytitle = str_replace( '[link', '<a', $mytitle );
	$mytitle = str_replace( '[/link]', '</a>', $mytitle );
  $mytitle = str_replace( ']', '>', $mytitle );

	return $mytitle;
}

	// This is my Footer

	remove_action( 'genesis_footer', 'genesis_do_footer' );
	add_action ('genesis_footer', 'do_laura_footer');
	function do_laura_footer() {
		?>

	<div class="laura-copyright">
	<p>Copyright &copy; <?php echo date("Y"); ?> &#183; Musings of a Rover &#183; All Rights Reserved</p>
	</div>

		<?php
	}

//Shortcodes!!!!!

// Social Icons Shortcode
add_shortcode( 'laurasocial', 'laura_social_function' );

function laura_social_function( $atts ){

	$instagram = '<a href="https://www.instagram.com/musingsofarover/"><span class="dashicons dashicons-instagram"></span></a>';
	$pinterest = '<a href="https://www.pinterest.com/musingsofarover/"><span class="dashicons dashicons-pinterest"></span></a>';
	$socialmedia = $instagram . $pinterest;

	return '<div class="shortcode-social">' . $socialmedia . '</div>';
}


// Itinerary Signup Shortcodes

add_shortcode( 'lauraitinerary', 'laura_itinerary_function' );

function laura_itinerary_function() {

	$lauraitinerary = '<div class="itinerary">
<div class="itinerary-info">
<h3>Download the Itinerary!</h3>
<p>Subscribe below and you will receive my FREE simplified travel guides that you can take with you anywhere!</p>
</div>
<div class="itinerary-subscribe"><div class="shortcode-mail clearfix">
	<div id="mc_embed_signup">
		<form action="//musingsofarover.us10.list-manage.com/subscribe/post?u=8586929758afca3cea8a8e13f&amp;id=39dbdd7a02" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate="">
				<div id="mc_embed_signup_scroll" class="itinerary-flex">

			<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Enter Your Email" required="">
				<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
				<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_8586929758afca3cea8a8e13f_39dbdd7a02" tabindex="-1" value=""></div>
				<div class="clear"><input class="button" type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe"></div>
				</div>
		</form>
		</div>
		</div>

  </div>
</div>';

return $lauraitinerary;

}


// Affiliate Shortcode

add_shortcode( 'affiliate', 'laura_affiliate_function' );

function laura_affiliate_function() {

	$lauraaffiliate = '<div class="affiliate">
  <p><i>Some of the links in this post are affiliate links. If you buy something through these thinks, I may earn a commission from the sale (at no extra cost to you!). As an Amazon Associate I earn from qualifying purchases. Thank you for reading along!</i></p>
</div>';

return $lauraaffiliate;

}

// Read Next Shortcode

add_shortcode( 'readnext', 'laura_read_next_function' );

function laura_read_next_function( $atts) {

  $laurareadnext = shortcode_atts( array(
    'text' => 'text',
    'url' => 'url',
  ), $atts );

return "<h5 class='readnext'>Read Next: <a href='{$laurareadnext['url']}''>{$laurareadnext['text']}</a></h5>";

}

//Read Next Shortcode x2

add_shortcode( 'readnextlaura', 'laura_read_next_function2' );

function laura_read_next_function2( $atts, $content = null ) {

return "<h5 class='readnext'>" . $content . "</h5>";

}

// Attention Block 1 Shortcode

add_shortcode('block1', 'laura_block1_function');

function laura_block1_function( $atts, $content = null ) {

	return "<div class='block1'>" . $content . "</div>";

}

// fancy h2

add_shortcode( 'h2laura', 'laura_h2' );

function laura_h2( $atts, $content = null ) {

return "<h2 class='fancyh2'>" . $content . "</h2>";

}

// Fancy HR

add_shortcode( 'laurahr', 'hr_laura_function' );

function hr_laura_function() {

  $laurahr = "<hr class='laurahrfancy'>";

return $laurahr;

}

// Add Blog Index Size
//this adds the image size
add_image_size('blogindex-size', 500, 500, true);

//remove the slider size
remove_image_size($slider);

//this adds the new image size to the media library
add_filter( 'image_size_names_choose', 'my_custom_sizes' );

function my_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'blogindex-size' => __( 'Tall Index Size' ),
    ) );
}

// Add custom color palettes in Gutenberg.
function smith_gutenberg_color_palette() {
	add_theme_support(
		'editor-color-palette', array(
			array(
				'name' => __( 'gray light', 'themeSmith' ),
				'slug' => 'gray-light',
				'color' => '#f9f9f9',
			),
			array(
				'name' => __( 'warm gray light', 'themeSmith' ),
        'slug' => 'warm-gray-light',
        'color' => '#EEEBEA',
			),
			array(
				'name' => __( 'warm gray dark', 'themeSmith' ),
				'slug' => 'warm-gray-dark',
				'color' => '#a1887e',
			),
			array(
				'name' => __( 'warm red', 'themeSmith' ),
				'slug' => 'warm-red',
				'color' => '#9b4a2f',
			),
			array(
				'name' => __( 'light green', 'themeSmith' ),
				'slug' => 'light-green',
				'color' => '#608769',
			),
			array(
				'name' => __( 'dark green', 'themeSmith' ),
				'slug' => 'dark-green',
				'color' => '#1e402e',
			),
			array(
				'name' => __( 'light purple', 'themeSmith' ),
				'slug' => 'light-purple',
				'color' => '#563A4B',
			),
			array(
				'name' => __( 'warm gray alt', 'themeSmith' ),
				'slug' => 'warm-gray-alt',
				'color' => '#f6f3f0',
			),
			array(
				'name' => __( 'gray light alt', 'themeSmith' ),
				'slug' => 'gray-light-alt',
				'color' => '#ccc',
			),
			array(
				'name' => __( 'gray text alt', 'themeSmith' ),
				'slug' => 'gray-text-alt',
				'color' => '#737373',
			),
			array(
				'name' => __( 'normal text', 'themeSmith' ),
				'slug' => 'normal-text',
				'color' => '#333',
			)
		)
	);
}
add_action( 'after_setup_theme', 'smith_gutenberg_color_palette' );
