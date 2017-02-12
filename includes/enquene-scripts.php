<?php
// enquene scripts for back end
function tandem_360_load_wp_media_files() {
    wp_enqueue_media();
    wp_enqueue_script( 'tandem_360_scripts_backend', TANDEM360.'/src/tandem-360-backend.min.js', array( 'jquery' ), '', true );
    wp_enqueue_style( 'tandem_360_css_backend', TANDEM360.'/src/tandem_360_style_backend.min.css' );
}
add_action( 'admin_enqueue_scripts',  'tandem_360_load_wp_media_files');


// enquene scripts for frontend
function tandem_360_scripts(){
    wp_enqueue_script( 'tandem_360_scripts', TANDEM360.'/src/tandem-360-frontend.min.js', array( 'jquery' ), '', true );
    wp_enqueue_style( 'tandem_360_css_frontend', TANDEM360.'/src/tandem_360_style_frontend.min.css' );
}

add_action('wp_enqueue_scripts', 'tandem_360_scripts', 999);
