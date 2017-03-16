<?php

add_action( 'wp_enqueue_scripts', 'hatch_parent_theme_styles' );
function hatch_parent_theme_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}