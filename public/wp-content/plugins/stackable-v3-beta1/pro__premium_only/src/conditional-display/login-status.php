<?php
/**
 * Conditional logic of the condition type Login status.
 *
 * @package Stackable
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'stackable_conditional_display/login-status', function( $should_display, $display, $condition, $block_content, $block ) {
    $options = isset( $condition['options'] ) ? $condition['options'] : null;

    if ( $options ) {
        $status = $options['status'];
        if ( $display === 'hide' ) {
            if ( $status === 'logged-in' ) {
                $should_display = is_user_logged_in() ? false : true;
            }
            if ( $status === 'logged-out' ) {
                $should_display = ! is_user_logged_in() ? false : true;
            }
        }
        if ( $display === 'show' ) {
            if ( $status === 'logged-in' ) {
                $should_display = is_user_logged_in() ? true : false;
            }
            if ( $status === 'logged-out' ) {
                $should_display = ! is_user_logged_in() ? true : false;
            }
        }
    }

	return $should_display;
}, 10, 5 );
