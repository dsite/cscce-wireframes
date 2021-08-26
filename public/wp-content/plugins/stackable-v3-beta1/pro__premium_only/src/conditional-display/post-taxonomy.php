<?php
/**
 * Conditional logic of the condition type Post taxonomy.
 *
 * @package Stackable
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'stackable_conditional_display/post-taxonomy', function( $should_display, $display, $condition, $block_content, $block ) {
    $options = isset( $condition['options'] ) ? $condition['options'] : null;

    if ( $options ) {
        // Default values:
        // postType = post
        // taxonomyType = category
        // taxonomyFilterType = __in
        $post_type = isset( $options['postType'] ) ? $options['postType'] : 'post';
        $taxonomy_type = isset( $options['taxonomyType'] ) ? $options['taxonomyType'] : 'category';
        $taxonomy_filter_type = isset( $options['taxonomyFilterType'] ) ? $options['taxonomyFilterType'] : '__in';
        $taxonomy = isset( $options['taxonomy'] ) ? $options['taxonomy'] : '';
        $selected_term_ids = array_map( 'intval', explode( ",", $taxonomy ) );

        if ( $taxonomy ) {
            $current_post_type = get_post_type( get_the_ID() );

            if ( $current_post_type === $post_type ) {
                // Terms attached to the current page based on the set taxonomy_type
                $attached_terms = get_the_terms( get_the_ID(), $taxonomy_type );

                if ( $attached_terms ) {
                    // Returns an array of the term_ids that are attached to the current page
                    $term_ids = wp_list_pluck( $attached_terms, 'term_id' );
                    $matched_term_ids = array_intersect( $term_ids, $selected_term_ids );

                    if ( $display === 'hide' ) {
                        if ( $taxonomy_filter_type === '__in' ) {
                            $should_display = ! empty( $matched_term_ids ) ? false : true;
                        }
                        if ( $taxonomy_filter_type === '__not_in' ) {
                            $should_display = empty( $matched_term_ids ) ? false : true;
                        }
                    }
                    if ( $display === 'show' ) {
                        if ( $taxonomy_filter_type === '__in' ) {
                            $should_display = ! empty( $matched_term_ids ) ? true : false;
                        }
                        if ( $taxonomy_filter_type === '__not_in' ) {
                            $should_display = empty( $matched_term_ids ) ? true : false;
                        }
                    }
                } else {
                    // If no attached terms to the current page
                    if ( $taxonomy_filter_type === '__in' ) {
                        $should_display = $display === 'show' ? false : true;
                    }
                    if ( $taxonomy_filter_type === '__not_in' ) {
                        $should_display = $display === 'show' ? true : false;
                    }
                }
            } else {
                // If current page is not the chosen post_type
                $should_display = $display === 'show' ? false : true;
            }
        }
    }

	return $should_display;
}, 10, 5 );
