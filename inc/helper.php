<?php

 function wpnp_woocommerce_product_categories_lite(){
    $terms = get_terms(array(
        'taxonomy' => 'product_cat',
        'hide_empty' => true,
    ));

    if (!empty($terms) && !is_wp_error($terms)) {
        foreach ($terms as $term) {
            $options[$term->slug] = $term->name;
        }
        return $options;
    }
}


function wpnp_pcats_slug_str(){
    $terms = get_the_terms( get_the_ID(), 'product_cat' );
    $term_str = '';
    if( is_array($terms) ){
        foreach( $terms as $term ){
            $term_str .= ' '.$term->slug;
        }
    }
    return $term_str;
}

function wpnp_get_all_products_id_name(){
	$args = array(
		'posts_per_page' => -1,
		'post_type' => array('product','product_variation'),
	);
	$products = [];
	$Q_products = new WP_Query( $args );
	$QP_product = $Q_products->posts;
	if(is_array($QP_product)){
		foreach ($QP_product as $prod ) {
			$products[$prod->ID] = get_the_title($prod->ID);
		}
	}
	return $products;
}

//Example rt_star_rating(['rating' => 4]);
function wpnp_star_rating( $args = array() ) {
    $defaults    = array(
        'rating' => 0,
        'type'   => 'rating',
        'number' => 0,
        'echo'   => true,
    );
    $parsed_args = wp_parse_args( $args, $defaults );
 
    // Non-English decimal places when the $rating is coming from a string.
    $rating = (float) str_replace( ',', '.', $parsed_args['rating'] );
 
    // Convert percentage to star rating, 0..5 in .5 increments.
    if ( 'percent' === $parsed_args['type'] ) {
        $rating = round( $rating / 10, 0 ) / 2;
    }
 
    // Calculate the number of each type of star needed.
    $full_stars  = floor( $rating );
    $half_stars  = ceil( $rating - $full_stars );
    $empty_stars = 5 - $full_stars - $half_stars;
 
    if ( $parsed_args['number'] ) {
        /* translators: 1: The rating, 2: The number of ratings. */
        $format = _n( '%1$s rating based on %2$s rating', '%1$s rating based on %2$s ratings', $parsed_args['number'] );
        $title  = sprintf( $format, number_format_i18n( $rating, 1 ), number_format_i18n( $parsed_args['number'] ) );
    } else {
        /* translators: %s: The rating. */
        $title = sprintf( __( '%s rating', 'nimart' ), number_format_i18n( $rating, 1 ) );
    }
	
    $output  = '<div class="star-rating">';
    
    $output .= str_repeat( '<i class="star star-full rt-star" aria-hidden="true"></i>', $full_stars );
    $output .= str_repeat( '<i class="star star-half rt-star-half-stroke-solid" aria-hidden="true"></i>', $half_stars );
    $output .= str_repeat( '<i class="star star-empty rt-star-regular" aria-hidden="true"></i>', $empty_stars );
    $output .= '</div>';
 
    if ( $parsed_args['echo'] ) {
        echo wp_kses_post($output);
    }
 
    return $output;
}