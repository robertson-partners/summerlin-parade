<?php

function theme_enqueue_styles() {
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', [] );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles', 20 );

function avada_lang_setup() {
	$lang = get_stylesheet_directory() . '/languages';
	load_child_theme_textdomain( 'Avada', $lang );
}
add_action( 'after_setup_theme', 'avada_lang_setup' );

function add_confetti() {
  if( is_front_page() ) {
    wp_enqueue_script( 'confetti-js', get_stylesheet_directory_uri() . '/js/confetti.browser.min.js', [], '1.4.0' );
    wp_enqueue_script( 'confetti-config-js', get_stylesheet_directory_uri() . '/js/confetti-fig.js', ['confetti-js'], '1.0', true);
  }
}
add_action( 'wp_enqueue_scripts', 'add_confetti', 20 );

/* Participant Application Form Options */
require get_stylesheet_directory() . '/includes/form_helpers.php';

if ( class_exists("GFForms") ){
  new GW_Minimum_Characters( array( 
    'form_id' => 3,
    'field_id' => 14,
    'min_chars' => 250,
    'min_validation_message' => __( 'Oops! Your description needs to be at least %s characters.' )
  ));
}