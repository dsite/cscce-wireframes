<?php
/**
 * Conditional logic of the condition type Post Meta Data.
 *
 * @package Stackable
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'stackable_conditional_display/post-meta', function( $should_display, $display, $condition, $block_content, $block ) {
    $options = isset( $condition['options'] ) ? $condition['options'] : null;

    if ( $options ) {
        $key = isset( $options['key'] ) ? $options['key'] : '';
        $operator = isset( $options['operator'] ) ? $options['operator'] : '';
        $expected = isset( $options['expectedVal'] ) ? $options['expectedVal'] : '';
        $found = get_post_meta( get_the_ID(), $key, true );

        if ( $key && $operator || $key && $operator && $expected ) {
            if ( $display === 'hide' ) {
                if ( $operator === 'equal' ) {
                    $should_display = $expected === $found ? false : true;
                }
                if ( $operator === 'not-equal' ) {
                    $should_display = $expected !== $found ? false : true;
                }
                if ( $operator === 'true' ) {
                    $should_display = $found ? false : true;

                    // Falsy values should be displayed.
                    if ( strtolower( $found ) === 'false' ) {
                        $should_display = true;
                    }
                    if ( strtolower( $found ) === 'null' ) {
                        $should_display = true;
                    }
                    if ( strtolower( $found ) === 'undefined' ) {
                        $should_display = true;
                    }
                    if ( $found === 'NaN' ) {
                        $should_display = true;
                    }
                }
                if ( $operator === 'false' ) {
                    $should_display = ! $found ? false : true;

                    // Check falsy values.
                    if ( strtolower( $found ) === 'false' ) {
                        $should_display = false;
                    }
                    if ( strtolower( $found ) === 'null' ) {
                        $should_display = false;
                    }
                    if ( strtolower( $found ) === 'undefined' ) {
                        $should_display = false;
                    }
                    if ( $found === 'NaN' ) {
                        $should_display = false;
                    }
                }
                if ( $operator === 'less-than' ) {
                    $should_display = $expected < $found ? false : true;
                }
                if ( $operator === 'less-than-equal' ) {
                    $should_display = $expected <= $found ? false : true;
                }
                if ( $operator === 'greater-than' ) {
                    $should_display = $expected > $found ? false : true;
                }
                if ( $operator === 'greater-than-equal' ) {
                    $should_display = $expected >= $found ? false : true;
                }
                if ( $operator === 'contains' ) {
                    $should_display = strpos( $found, $expected ) ? false : true;
                }
                if ( $operator === 'does-not-contain' ) {
                    $should_display = ! strpos( $found, $expected ) ? false : true;
                }
                if ( $operator === 'regex' ) {
                    $should_display = preg_match( $expected, $found ) ? false : true;
                }
            }

            if ( $display === 'show' ) {
                if ( $operator === 'equal' ) {
                    $should_display = $expected === $found ? true : false;
                }
                if ( $operator === 'not-equal' ) {
                    $should_display = $expected !== $found ? true : false;
                }
                if ( $operator === 'true' ) {
                    $should_display = $found ? true : false;

                    // Falsy values should not be displayed.
                    if ( strtolower( $found ) === 'false' ) {
                        $should_display = false;
                    }
                    if ( strtolower( $found ) === 'null' ) {
                        $should_display = false;
                    }
                    if ( strtolower( $found ) === 'undefined' ) {
                        $should_display = false;
                    }
                    if ( $found === 'NaN' ) {
                        $should_display = false;
                    }
                }
                if ( $operator === 'false' ) {
                    $should_display = ! $found ? true : false;

                    // Check falsy values.
                    if ( strtolower( $found ) === 'false' ) {
                        $should_display = true;
                    }
                    if ( strtolower( $found ) === 'null' ) {
                        $should_display = true;
                    }
                    if ( strtolower( $found ) === 'undefined' ) {
                        $should_display = true;
                    }
                    if ( $found === 'NaN' ) {
                        $should_display = true;
                    }
                }
                if ( $operator === 'less-than' ) {
                    $should_display = $expected < $found ? true : false;
                }
                if ( $operator === 'less-than-equal' ) {
                    $should_display = $expected <= $found ? true : false;
                }
                if ( $operator === 'greater-than' ) {
                    $should_display = $expected > $found ? true : false;
                }
                if ( $operator === 'greater-than-equal' ) {
                    $should_display = $expected >= $found ? true : false;
                }
                if ( $operator === 'contains' ) {
                    $should_display = strpos( $found, $expected ) ? true : false;
                }
                if ( $operator === 'does-not-contain' ) {
                    $should_display = ! strpos( $found, $expected ) ? true : false;
                }
                if ( $operator === 'regex' ) {
                    $should_display = preg_match( $expected, $found ) ? true : false;
                }
            }
        }
    }

	return $should_display;
}, 10, 5 );
