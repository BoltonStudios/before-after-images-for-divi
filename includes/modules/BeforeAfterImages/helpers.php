<?php

/**
 * Definition
 *
 * Description
 *
 * @since      1.4.0
 * @package    Before_After_Images_For_Divi
 * @subpackage Before_After_Images_For_Divi/includes
 * @author     Bolton Studios LLC <dev@boltonstudios.com>
 */

 /**
 * Simple function to sort an array by a specific key. Maintains index association.
 * http://php.net/manual/en/function.sort.php
 * @param mixed $array 
 * @param mixed $on 
 * @param int $order 
 * @return array 
 */
function array_sort( $array, $on, $order=SORT_ASC ){

    //
    $new_array = array();
    $sortable_array = array();

    //
    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }
        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }
        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    //
    return $new_array;
}

/**
 * Get the WordPress image objects for the images selected by the user.
 * Extract properties from the image objects and return an array with those values.
 * 
 * @param mixed $srcs 
 * @return array 
 */
function get_images( $srcs, $attributes ){

    // Initialize variables.
    $images = array();
    $size_width = 376;
    $size_height = 220;
    $i = 0; // 0 = Before Image, 1 = After Image
    $imageClass = array(
        'baie_before_image',
        'baie_after_image'
    );

    /**
     * According to WP Rocket, these attributes are part of a cooperation between LazyLoad plugin authors
     * to standardize exclusions.
     * */ 
    $lazy_load_attr = 'data-skip-lazy="1" data-no-lazy="1"';

    // Get selected image labels.
    $beforeLabel = ( isset( $attributes['label_before']) ) ? $attributes['label_before'] : '';
    $afterLabel = ( isset( $attributes['label_after']) ) ? $attributes['label_after'] : '';
    
    // Get selected slider offset.
    $sliderOffset = ( isset( $attributes['slider_offset']) ) ? $attributes['slider_offset'] : '';

    // Get selected image attributes.
    $alt = ( isset( $attributes[ 'alt' ] ) ) ? $attributes[ 'alt' ] : '';
    $title_text = ( isset( $attributes[ 'title_text' ] ) ) ? $attributes[ 'title_text' ] : '';
    $src_placeholder = "data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTA4MCIgaGVpZ2h0PSI1NDAiIHZpZXdCb3g9IjAgMCAxMDgwIDU0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgIDxnIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+CiAgICAgICAgPHBhdGggZmlsbD0iI0VCRUJFQiIgZD0iTTAgMGgxMDgwdjU0MEgweiIvPgogICAgICAgIDxwYXRoIGQ9Ik00NDUuNjQ5IDU0MGgtOTguOTk1TDE0NC42NDkgMzM3Ljk5NSAwIDQ4Mi42NDR2LTk4Ljk5NWwxMTYuMzY1LTExNi4zNjVjMTUuNjItMTUuNjIgNDAuOTQ3LTE1LjYyIDU2LjU2OCAwTDQ0NS42NSA1NDB6IiBmaWxsLW9wYWNpdHk9Ii4xIiBmaWxsPSIjMDAwIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz4KICAgICAgICA8Y2lyY2xlIGZpbGwtb3BhY2l0eT0iLjA1IiBmaWxsPSIjMDAwIiBjeD0iMzMxIiBjeT0iMTQ4IiByPSI3MCIvPgogICAgICAgIDxwYXRoIGQ9Ik0xMDgwIDM3OXYxMTMuMTM3TDcyOC4xNjIgMTQwLjMgMzI4LjQ2MiA1NDBIMjE1LjMyNEw2OTkuODc4IDU1LjQ0NmMxNS42Mi0xNS42MiA0MC45NDgtMTUuNjIgNTYuNTY4IDBMMTA4MCAzNzl6IiBmaWxsLW9wYWNpdHk9Ii4yIiBmaWxsPSIjMDAwIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz4KICAgIDwvZz4KPC9zdmc+Cg==";
    
    // Use a placeholder image if the user did not select images. 
    if( $srcs[0] == null || $srcs[0] == '' ){
        
        $placeholder_string = '';
        for( $n = 0; $n <= 1; $n++){
            $placeholder_string .= sprintf(
                '<img src="%1$s" data-before-label="%2$s" data-after-label="%3$s" data-slider-offset="%4$s" %8$s alt="%5$s" title="%6$s" class="%7$s" />',
                esc_attr( $src_placeholder ),
                esc_attr( $beforeLabel ),
                esc_attr( $afterLabel ),
                esc_attr( $sliderOffset ),
                esc_attr( $alt ),
                esc_attr( $title_text ),
                esc_attr( $imageClass[ $n ] ),
                $lazy_load_attr
            );
        }
        array_push( $images, array(
            'output' => $placeholder_string,
            'size_width' => $size_width,
            'size_height' => $size_height,
            'is_svg' => false
            )
        );
    } else{

        // Extract properties from selected WordPress image objects.
        foreach( $srcs as $src ){
            
            $src_id = attachment_url_to_postid( $src );
            if( $src_id == ''){
                // Break if there is no src id, image missing, etc.
                break;
            }
            $src_url = parse_url( $src );
            $src_path = $src_url[ 'path' ];
            $src_path_parts = pathinfo( $src_path );
            $src_file_extension = $src_path_parts['extension'];

            // Get selected size.
            $default_size = 'Width: '. $size_width .'px. Height: '. $size_height .'px. (cropped).'; // default
            $size = ( isset( $attributes['size'] ) )
            ? $attributes['size']
            : $default_size;
            
            // Use default size if no size selected.
            if( $size === 'selectasize.' ){
                $size = $default_size;
            }

            // Extract integers from selected size.
            $size_explode = explode( '.', $size );
            
            if( array_key_exists( 1, $size_explode ) ){

                // If $size does not contain multiple strings, no size was selected and the named size will be set to a default size.
                $size_width = (int) filter_var( $size_explode[0], FILTER_SANITIZE_NUMBER_INT );
                $size_height = (int) filter_var( $size_explode[1], FILTER_SANITIZE_NUMBER_INT );
            }

            // Get named size.
            // If no size was selected, set the named size to "large".
            if( $size === "selectasize." ){
                $named_size = "large";
            } else if( $size === "fullsize." ){
                $named_size = "full";
            } else{
                $named_size = get_named_size( array( $size_width, $size_height ) );
            }
            
            // Get image source URL at named size.
            $src_url = wp_get_attachment_image_src( $src_id, $named_size );

            // If there is no source URL at the named size, use the image placeholder.
            ( $src_url ) ? $src_url = $src_url[0] : $src_placeholder;

            // For full size images, update size and height values with data from WordPress.
            if( $size === "fullsize." ){
                $size_width = $src_url[1];
                $size_height = $src_url[2];
            }

            // Get the image source set.
            $src_set = wp_get_attachment_image_srcset( $src_id, $named_size );
            ($src_set) ? $src_set_output = 'srcset="'. esc_attr( $src_set ) .'"' : $src_set_output ='';
            
            // Create a 'sizes' attribute value for the image.
            $src_sizes = wp_calculate_image_sizes( $named_size, $src_url, wp_get_attachment_metadata( $src_id ), $src_id );  
            ($src_sizes) ? $src_sizes_output = 'sizes="'. esc_attr( $src_sizes ) .'"' : $src_sizes_output ='';
            
            // Handle svg image behaviour
            $is_src_svg = isset( $src_file_extension ) ? 'svg' === $src_file_extension : false;
            
            // Construct HTML image elements.
            $image_string = sprintf(
                '<img src="%1$s" %2$s %3$s data-before-label="%4$s" data-after-label="%5$s" data-slider-offset="%6$s" %10$s alt="%7$s" title="%8$s" class="%9$s" />',
                esc_attr( $src_url ),
                $src_set_output,
                $src_sizes_output,
                esc_attr( $beforeLabel ),
                esc_attr( $afterLabel ),
                esc_attr( $sliderOffset ),
                esc_attr( $alt ),
                esc_attr( $title_text ),
                esc_attr( $imageClass[ $i ] . ' skip-lazy' ),
                $lazy_load_attr
            );
            
            array_push( $images, array(
                'output' => $image_string,
                'size_width' => $size_width,
                'size_height' => $size_height,
                'is_svg' => $is_src_svg
                )
            );
            $i++;
        } 
    }
    return $images;
}

/**
 * Get size information for all currently-registered image sizes.
 * 
 * Source: https://codex.wordpress.org/Function_Reference/get_intermediate_image_sizes
 * 
 * @global $_wp_additional_image_sizes
 * @uses   get_intermediate_image_sizes()
 * @return array $sizes Data for all currently-registered image sizes.
 */
function get_image_sizes() {

    global $_wp_additional_image_sizes;
    $sizes = array();

    foreach ( get_intermediate_image_sizes() as $_size ) {

        if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {

            $sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
            $sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
            $sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
        } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {

            $sizes[ $_size ] = array(
                'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
                'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
            );
        }
    }
    return $sizes;
}

/**
 * Return the closest named size from an array of width and height values.
 *
 * Based off of WordPress's image_get_intermediate_size()
 * If the size matches an existing size then it will be used. If there is no
 * direct match, then the nearest image size larger than the specified size
 * will be used. If nothing is found, then the function will return false.
 * Uses get_image_sizes() to get all available sizes.
 * 
 * Source: https://wordpress.stackexchange.com/a/254064
 *
 * @param  array|string $size   Image size. Accepts an array of width and height (in that order).
 * @return false|string $data   named image size e.g. 'thumbnail'.
 */
function get_named_size( $size ) {

    $data = array();
    $image_sizes = get_image_sizes();

    // Find the best match when '$size' is an array.
    if ( is_array( $size ) ) {

        $candidates = array();

        foreach ( $image_sizes as $_size => $data ) {

            // If there's an exact match to an existing image size, short circuit.
            if ( $data['width'] == $size[0] && $data['height'] == $size[1] ) {
                $candidates[ $data['width'] * $data['height'] ] = array( $_size, $data );
                break;
            }
            // If it's not an exact match, consider larger sizes with the same aspect ratio.
            if ( $data['width'] >= $size[0] && $data['height'] >= $size[1] ) {
                if ( wp_image_matches_ratio( $data['width'], $data['height'], $size[0], $size[1] ) ) {
                    $candidates[ $data['width'] * $data['height'] ] = array( $_size, $data );
                }
            }
        }
        if ( ! empty( $candidates ) ) {

            // Sort the array by size if we have more than one candidate.
            if ( 1 < count( $candidates ) ) {
                ksort( $candidates );
            }

            $data = array_shift( $candidates );
            $data = $data[0];
        /*
        * When the size requested is smaller than the thumbnail dimensions, we
        * fall back to the thumbnail size to maintain backwards compatibility with
        * pre 4.6 versions of WordPress.
        */
        } elseif ( ! empty( $image_sizes['thumbnail'] ) && $image_sizes['thumbnail']['width'] >= $size[0] && $image_sizes['thumbnail']['width'] >= $size[1] ) {
            $data = 'thumbnail';
        } else {
            return false;
        }
    } elseif ( ! empty( $image_sizes[ $size ] ) ) {
        $data = $size;
    }
    // If we still don't have a match at this point, return false.
    if ( empty( $data ) ) {
        return false;
    }
    return $data;
}

/**
 * Create a string array of available image dimensions.
 * This is used to populate the image size selector in the module settings.
 * 
 * @return string[] 
 */
function get_image_dimensions(){

    // Get the available image sizes.
    $image_sizes = get_image_sizes();
    $image_sizes = array_sort( $image_sizes, 'width' ); // Sort sizes from smallest to largest.
    $image_dimensions = array( 'selectasize.' => 'Select a size.' );

    foreach( $image_sizes as $size ){

        $width = 'Width: ' . $size['width'] .'px.';
        $height = 'Height: '. $size['height'] .'px.';
        ( $size['crop'] ) ? $cropped = '(cropped).' : $cropped = '(best fit)';
        $size_str = $width .' '. $height .' '. $cropped;

        if( $size['width'] !== 0 && $size['height'] !== 0 && $cropped == '(cropped).' ){

            $image_dimensions += [ strtolower( preg_replace('/\s*/', '', $size_str) ) => esc_html__( $size_str, 'before_after_images_for_divi') ];
        }
    }
    $image_dimensions += [ 'fullsize.' => esc_html__( 'Full size.', 'before_after_images_for_divi') ];
    return $image_dimensions;
}
