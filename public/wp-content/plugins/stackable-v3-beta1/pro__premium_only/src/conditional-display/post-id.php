<?php
/**
 * Conditional logic of the condition type Post IDs.
 *
 * @package Stackable
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'stackable_conditional_display/post-id', function( $should_display, $display, $condition, $block_content, $block ) {
    $options = isset( $condition['options'] ) ? $condition['options'] : null;

    if ( $options ) {
        $selectedValues = $options['selectedValues'];

        if ( $selectedValues ) {
            $values = array_map( 'intval', $selectedValues );
            $is_id_match = in_array( get_the_ID(), $values );

            if ( $display === 'hide' ) {
                $should_display = $is_id_match ? false : true;
            }

            if ( $display === 'show' ) {
                $should_display = $is_id_match ? true : false;
            }
        }
    }

	return $should_display;
}, 10, 5 );
