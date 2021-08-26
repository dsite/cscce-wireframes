<?php
/**
 * Conditional logic of the condition type User role.
 *
 * @package Stackable
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'stackable_conditional_display/role', function( $should_display, $display, $condition, $block_content, $block ) {
    $options = isset( $condition['options'] ) ? $condition['options'] : null;

    if ( $options ) {
        $selectedValues = $options['selectedValues'];

        if ( $selectedValues ) {
            if ( is_user_logged_in() ) {
                // Get the roles of the current user
                $current_user = wp_get_current_user();
                $user_roles = $current_user->roles;

                // Convert selectedValues to lowercase to compare with the user role
                $values = array_map( 'strtolower', $selectedValues );
                $matched_roles = array_intersect( $user_roles, $values );

                if ( $display === 'hide' ) {
                    $should_display = ! empty( $matched_roles ) ? false : true;
                }

                if ( $display === 'show' ) {
                    $should_display = ! empty( $matched_roles ) ? true : false;
                }

            } else {
                // For non logged in users
                $should_display = $display === 'show' ? false : true;
            }
        }
    }

	return $should_display;
}, 10, 5 );
