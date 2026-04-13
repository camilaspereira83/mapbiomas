<?php
# Load components
require_once __DIR__ . '/classes/components/Component.php';
require_once __DIR__ . '/classes/components/Home.php';
require_once __DIR__ . '/classes/components/QuemSomos.php';

# Register custom fields using PHP
# See: https://www.advancedcustomfields.com/resources/register-fields-via-php/


//Aumentando Limite Upload
@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );

//Suporte à Thumbnails
if (function_exists('add_theme_support')) { 
  add_theme_support('post-thumbnails');
  set_post_thumbnail_size( 220, 153 ); 
}

//Register Sidebar
if (function_exists('register_sidebar')) {
    register_sidebar(
		array(
			'name' => 'Barra Lateral',
			'before_widget' => '<li id="%1$s" class="widget %2$s">',
			'after_widget'  => '</li>',
			'before_title'  => '<h2 class="widgettitle">',
			'after_title'   => '</h2>' 
		)
	);
}

//Suporte à Custom Menus
if (function_exists('register_nav_menu')) {
	register_nav_menus( array(
		'navegacao-principal' => __( 'Navegacao Principal', 'menuadd' ),
		
	) );
	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'menuadd');
}


//Control Excerpt Length using Filters
function new_excerpt_length($length) {
	return 30;
}
add_filter('excerpt_length', 'new_excerpt_length');