<?php
/**
 * Conditional logic of the condition type Custom PHP.
 *
 * @package Stackable
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'stackable_conditional_display/custom-php', function( $should_display, $display, $condition, $block_content, $block ) {
    $options = isset( $condition['options'] ) ? $condition['options'] : null;

    if ( $options ) {
        $custom_php = $options['customPHP'];
        // Skip checking if custom PHP is empty.
        if ( empty( $custom_php ) ) {
            return true;
        }

        if ( stripos( $custom_php, 'return' ) === false ) {
            $custom_php = 'return ' . $custom_php;
        }
        $code = urldecode( $custom_php );

        if ( ! is_admin() ) {
            try {
                ob_start();
                $should_display = eval( $code . ';' );
                ob_end_clean();
            }
            catch ( Error $e ) {
                trigger_error( $e->getMessage(), E_USER_WARNING );

                $should_display = true;
            }
        }
    }

	return $should_display;
}, 10, 5 );
