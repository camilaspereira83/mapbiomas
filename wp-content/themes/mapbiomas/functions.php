<?php
# Load components
require_once __DIR__ . '/classes/components/Component.php';
require_once __DIR__ . '/classes/components/Home.php';
require_once __DIR__ . '/classes/components/QuemSomos.php';
require_once __DIR__ . '/classes/components/ConhecaRede.php';
require_once __DIR__ . '/classes/components/FAQ.php';
require_once __DIR__ . '/classes/components/Glossario.php';

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
		'navegacao-rodape-mapa' => __( 'Navegacao Rodape Mapa', 'menuadd' ),
		'navegacao-rodape-contato' => __( 'Navegacao Rodape Contato', 'menuadd' ),
		
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

// Enqueue Foundation Icons
function enqueue_foundation_icons() {
    wp_enqueue_style( 'foundation-icons', 'https://cdnjs.cloudflare.com/ajax/libs/foundicons/3.0.0/foundation-icons.css', array(), '3.0.0' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_foundation_icons' );