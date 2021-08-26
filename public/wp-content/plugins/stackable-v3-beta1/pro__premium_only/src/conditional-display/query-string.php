<?php
/**
 * Conditional logic of the condition type Query string.
 *
 * @package Stackable
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'stackable_conditional_display/query-string', function( $should_display, $display, $condition, $block_content, $block ) {
    $options = isset( $condition['options'] ) ? $condition['options'] : null;

    if ( $options ) {
        $queries = isset( $options['queries'] ) ? $options['queries'] : null;

        if ( $queries ) {
            // Convert the queries into an array
            $query_arr = explode( "\n", $queries );

            $query_strings = array();
            foreach ( $query_arr as $query ) {
                parse_str( $query, $parsed_query );
                $query_strings = array_merge( $query_strings, $parsed_query );
            }

            if ( $display === 'hide' ) {
                foreach ( $query_strings as $param => $value ) {
                    if ( isset( $_REQUEST[ $param ] ) ) { // phpcs:ignore
                        // If param only or param=
                        if ( ! $value ) {
                            $should_display = false;
                            break;
                        } else if ( $_REQUEST[ $param ] === $value ) { // phpcs:ignore
                            $should_display = false;
                            break;
                        }
                    }
                }
            } else if ( $display === 'show' ) {
                $pattern_match = 0;

                foreach ( $query_strings as $param => $value ) {
                    if ( isset( $_REQUEST[ $param ] ) ) { // phpcs:ignore
                        // If param only or param=
                        if ( ! $value ) {
                            $pattern_match++;
                        } else if ( $_REQUEST[ $param ] === $value ) { // phpcs:ignore
                            $pattern_match++;
                        }
                    }
                }

                // Block should be displayed if any of the queries matched
                if ( $pattern_match === 0 ) {
                    $should_display = false;
                } else {
                    $should_display = true;
                }
            }
        }
    }

	return $should_display;
}, 10, 5 );
