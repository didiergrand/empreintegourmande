<?php
/**
 * Empreinte Gourmande functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Empreinte_Gourmande
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '25.04.11' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function empreinte_gourmande_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Empreinte Gourmande, use a find and replace
		* to change 'empreinte-gourmande' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'empreinte-gourmande', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'empreinte-gourmande' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'empreinte_gourmande_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'empreinte_gourmande_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function empreinte_gourmande_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'empreinte_gourmande_content_width', 640 );
}
add_action( 'after_setup_theme', 'empreinte_gourmande_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function empreinte_gourmande_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'empreinte-gourmande' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'empreinte-gourmande' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'empreinte_gourmande_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function empreinte_gourmande_scripts() {
	wp_enqueue_style( 'empreinte-gourmande-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'empreinte-gourmande-style', 'rtl', 'replace' );

	wp_enqueue_script( 'empreinte-gourmande-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'empreinte_gourmande_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

function add_hero_banner_image() {
    if (has_post_thumbnail()) { 
        $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
        ?>
        <style type="text/css"> 
            .hero-banner {
                background-image: url(<?php echo esc_url($featured_image[0]); ?>);
            }
        </style>
        <?php
    } elseif (has_header_image()) {
        ?>
        <style type="text/css"> 
            .hero-banner {
                background-image: url(<?php header_image(); ?>);
            }
        </style>
        <?php
    } else {
        ?>
        <style type="text/css"> 
            .hero-banner {
                background-image: url(<?php echo get_template_directory_uri() . '/wp-content/uploads/2022/08/4BC713D4-901B-426F-979B-AF5A69AE371F_1_105_c-1.jpeg'; ?>);
            }
        </style>
        <?php
    }
}
add_action('wp_head', 'add_hero_banner_image');
function custom_image_sizes() {
    add_image_size( 'custom-size', 400, 400, true ); // 400x400px, recadré
    add_theme_support(
        'custom-header',
        apply_filters(
            'empreinte_gourmande_custom_header_args',
            array(
                'default-image'      => get_template_directory_uri() . '/wp-content/uploads/2022/08/4BC713D4-901B-426F-979B-AF5A69AE371F_1_105_c-1.jpeg',
                'width'              => 2000,
                'height'             => 500,
                'flex-height'        => true,
                'flex-width'         => true,
                'header-text'        => false,
            )
        )
    );
}
add_action( 'after_setup_theme', 'custom_image_sizes' );

add_filter(
    'get_the_archive_title',
    function ($title) {
        if (is_category()) {
            $title = single_cat_title('', false);
        } elseif (is_tag()) {
            $title = single_tag_title('', false);
        } elseif (is_author()) {
            $title = get_the_author();
        } elseif (is_post_type_archive()) {
            $title = post_type_archive_title('', false);
        } elseif (is_tax()) {
            $title = single_term_title('', false);
        }
        return $title;
    }
);