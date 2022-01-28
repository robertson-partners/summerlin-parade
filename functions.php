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

function add_fireworks() {
  if( is_front_page() ) {
    wp_enqueue_script( 'fireworksutils-js', get_stylesheet_directory_uri() . '/js/utils.js', [], '1.0' );
    wp_enqueue_script( 'fireworks-js', get_stylesheet_directory_uri() . '/js/fireworks.js', ['fireworksutils-js'], '1.0' );
  }
}
add_action( 'wp_enqueue_scripts', 'add_fireworks', 20 );