<?php
/**
 * Conditional logic of the condition type Post type.
 *
 * @package Stackable
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'stackable_conditional_display/post-type', function( $should_display, $display, $condition, $block_content, $block ) {
    $options = isset( $condition['options'] ) ? $condition['options'] : null;

    if ( $options ) {
        $selectedValues = $options['selectedValues'];
        if ( $selectedValues ) {
            // Post type of the current page
            $current_post_type = get_post_type( get_the_ID() );

            if ( in_array( $current_post_type, array_map( 'strtolower', $selectedValues ) ) ) {
                $should_display = $display === 'hide' ? false : true;
            } else {
                // If current page is not in selected post types
                $should_display = $display === 'hide' ? true : false;
            }
        } else {
            return true;
        }
    }

	return $should_display;
}, 10, 5 );
