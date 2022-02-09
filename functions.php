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

/* Homepage Confetti Generator */
function add_confetti() {
  if( is_front_page() ) {
    /* Confetti - https://github.com/catdad/canvas-confetti */
    wp_enqueue_script( 'confetti-js', get_stylesheet_directory_uri() . '/js/confetti.browser.min.js', [], '1.4.0' );

    /* Vanta JS Clouds - https://github.com/tengbao/vanta */
    wp_enqueue_script( 'three-js', get_stylesheet_directory_uri() . '/js/three.min.js', [], '1.0' );
    wp_enqueue_script( 'vanta-js', get_stylesheet_directory_uri() . '/js/vanta.clouds.min.js', ['three-js'], '1.0' );

    /* Confetti and Clouds Config */
    wp_enqueue_script( 'confetti-config-js', get_stylesheet_directory_uri() . '/js/confetti-fig.js', ['confetti-js'], '1.1', true);
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

/**
 * Gravity Perks // GP Better User Activation // Enable Editor on Activation Page
 * http://gravitywiz.com/documentionat/gravity-forms-better-user-activation/
 */
if ( function_exists('gp_better_user_activation') ){
  add_action( 'init', function() {
    remove_action( 'admin_head', array( gp_better_user_activation(), 'remove_default_content_editor' ) );
  });
}

/**
 * Logout Shortcode
 */
add_shortcode('logout',function(){
  if ( is_user_logged_in() ) {
    $url = wp_logout_url( home_url() );
    return "<a href='$url'>Logout</a>";
  }
});

/**
 * User Application Status Shortcode
 * 
 * Usage ex: [appstatus completed="true"] SHOW IF COMPLETED [/appstatus]
 *       or: [appstatus] SHOW IF INCOMPLETE [/appstatus]
 */

add_shortcode('appstatus', 'app_status_shortcode');

function app_status_shortcode($atts = [], $content = null, $tag = '') {
  $output = '';
  $logged_in = false;
  $atts = array_change_key_case( (array) $atts, CASE_LOWER );
  $status_atts = shortcode_atts( array('completed' => false), $atts, $tag );
  
  /* Test for logged in user state */
  if ( is_user_logged_in() ) {
    $uid = get_current_user_id();
    $usr_meta = get_user_meta( $uid );
    $app_status = $usr_meta['completed_application'][0];
    $logged_in = true;

    /* Atts Conditional */
    $status = ( $status_atts['completed'] == false ) ? 'incomplete' : 'completed';

    /* Content! */
    if ( !is_null($content) ) {
      //$output .= apply_filters( 'the_content', $content );
      $output .= do_shortcode( $content );
    }

    /* Output + Return */
    if ( isset($app_status) && $logged_in) {

      if ( ($status === 'incomplete') && ($app_status == '0') ) {
        
        // DEFAULT or "false"
        return $output;

      } else if ( ($status === 'completed') && ($app_status != '0') ) {
        
        // "true"
        return $output;

      } else {
        
        // All other conditions
        return false;

      }

    } else {
      return false;
    }

  } else {
    return 'Not logged in.';
  }
}
