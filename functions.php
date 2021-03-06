<?php

function naturelle_enqueue_styles() {

    $parent_style = 'naturelle-parent-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );

    wp_enqueue_style( 'naturelle-fonts', naturelle_fonts_url(), array(), null );

}
add_action( 'wp_enqueue_scripts', 'naturelle_enqueue_styles' );



if ( get_stylesheet() !== get_template() ) {
    add_filter( 'pre_update_option_theme_mods_' . get_stylesheet(), function ( $value, $old_value ) {
         update_option( 'theme_mods_' . get_template(), $value );
         return $old_value; // prevent update to child theme mods
    }, 10, 2 );
    add_filter( 'pre_option_theme_mods_' . get_stylesheet(), function ( $default ) {
        return get_option( 'theme_mods_' . get_template(), $default );
    } );
}


function naturelle_image_sizes() {
	add_image_size( 'naturelle-post-thumbnail', 1366, 550, true ); // Custom image sizes
}
add_action( 'after_setup_theme', 'naturelle_image_sizes', 11 );

/**
 * Return the Google font stylesheet URL, if available.
 *
 * The use of Source Sans Pro and Bitter by default is localized. For languages
 * that use characters not supported by the font, the font can be disabled.
 *
 * @since InMotion 1.0
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function naturelle_fonts_url() {
    $fonts_url = '';
    /* Translators: If there are characters in your language that are not
     * supported by Bitter, translate this to 'off'. Do not translate into your
     * own language.
     */
    $bitter = _x( 'on', 'Cabin font: on or off', 'zillah' );
    if ( 'off' !== $bitter ) {
        $font_families = array();
        if ( 'off' !== $bitter )
            $font_families[] = 'Bitter:400,400i';
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );
        $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
    }
    return $fonts_url;
}


function naturelle_filter_powered_by( $copyright ) {
	$copyright = "<a href=\"http://themeisle.com/themes/naturelle/\" target=\"_blank\" rel=\"nofollow\">Naturelle</a> ".esc_html__( 'powered by', 'naturelle' )." <a href=\"http://wordpress.org/\"  target=\"_blank\" rel=\"nofollow\">".esc_html__( 'WordPress', 'naturelle' )."</a>";
	return $copyright;
}
add_filter( 'llorix_one_lite_powered_by', 'naturelle_filter_powered_by' );



