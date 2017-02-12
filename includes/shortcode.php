<?php
// Adding shortcode to display 360 objest in post or page

function tandem_360_shortcode( $atts ) {
    $a = shortcode_atts( array(
        'id' => 0
    ), $atts );

    $output = '';

    $output = display_tandem_360_object($a['id']);

    return $output;
}
add_shortcode( 'tandem-360', 'tandem_360_shortcode' );
