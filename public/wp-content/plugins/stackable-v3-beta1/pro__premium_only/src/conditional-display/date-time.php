<?php
/**
 * Conditional logic of the condition type Date Time.
 *
 * @package Stackable
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'stackable_conditional_display/date-time', function( $should_display, $display, $condition, $block_content, $block ) {
    $options = isset( $condition['options'] ) ? $condition['options'] : null;

    $startDate = isset( $options['start'] ) ? $options['start'] : null;
    $endDate = isset( $options['end'] ) ? $options['end'] : null;

    $days_of_the_week = array( 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday' );
    $days_selected = array();
    foreach ( $days_of_the_week as $index => $value ) {
        // Create an array of days selected
        if ( array_key_exists( $value, $options ) && $options[ $value ] ) {
            array_push( $days_selected, $value );
        }
    }

    // Skip checking and show the block if start, end date and days are not set
    if ( ! $days_selected && ! $startDate && ! $endDate ) {
        return true;
    }

    // Get the timezone from the WP admin settings.
    $timezone_string = get_option( 'timezone_string' );
    $gmt_offset = get_option( 'gmt_offset', 0 );

    // Set the timezone string as the timezone if it exists
    if ( $timezone_string ) {
        $timezone = $timezone_string;
    }

    if ( $gmt_offset === 0 ) {
        $timezone = 'UTC';
    } else {
        // Set the timezone as the gmt offset
        $timezone = $gmt_offset;
        // Check if the first char does not have the + or -
        // Append the + sign before the offset
        if (
            $gmt_offset[0] !== '-' &&
            $gmt_offset[0] !== '+'
        ) {
            $timezone = '+' . $gmt_offset;
        }
    }

    // Get the current date time based on WP admin settings.
    $current = current_datetime();

    // Convert the dates to a DateTime object.
    // Returns the current datetime if no startDate / endDate set.
    $start_datetime = new DateTime( $startDate, new DateTimeZone( $timezone ) );
    $end_datetime = new DateTime( $endDate, new DateTimeZone( $timezone ) );

    // If no endDate set, but there is a startDate set
    if ( ! $endDate && $startDate && ( $current < $start_datetime ) ) {
        // If the start date has not started yet.
        $should_display = $display === 'hide' ? true : false;
    } else if ( ! $endDate && $startDate && ( $current > $start_datetime ) ) {
        // If the start date has started
        if ( ! empty( $days_selected ) ) {
            // Get the current day of the week. Returns a string number (0 for sunday, 1 for monday...)
            $day_num = date( 'w' );
            $match = in_array( $days_of_the_week[ (int)$day_num ], $days_selected );

            if ( $display === 'hide' ) {
                $should_display = $match ? false : true;
            }
            if ( $display === 'show' ) {
                $should_display = $match ? true : false;
            }
        } else {
            $should_display = $display === 'hide' ? false : true;
        }
    }

    // If no startDate set, but there is an endDate set in the future
    if ( ! $startDate && $endDate && ( $current < $end_datetime ) ) {
        if ( ! empty( $days_selected ) ) {
            // Get the current day of the week. Returns a string number (0 for sunday, 1 for monday...)
            $day_num = date( 'w' );
            $match = in_array( $days_of_the_week[ (int)$day_num ], $days_selected );

            if ( $display === 'hide' ) {
                $should_display = $match ? false : true;
            }
            if ( $display === 'show' ) {
                $should_display = $match ? true : false;
            }
        } else {
            $should_display = $display === 'hide' ? false : true;
        }
    } else if ( ! $startDate && $endDate && ( $current > $end_datetime ) ) {
        // If the end date passed
        $should_display = $display === 'hide' ? true : false;
    }

    // If current date is in the middle of start and end date
    if ( $startDate && $endDate && ( $start_datetime < $current ) && ( $current < $end_datetime ) ) {
        if ( ! empty( $days_selected ) ) {
            // Get the current day of the week. Returns a string number (0 for sunday, 1 for monday...)
            $day_num = date( 'w' );
            $match = in_array( $days_of_the_week[ (int)$day_num ], $days_selected );

            if ( $display === 'hide' ) {
                $should_display = $match ? false : true;
            }
            if ( $display === 'show' ) {
                $should_display = $match ? true : false;
            }
        } else {
            $should_display = $display === 'hide' ? false : true;
        }
    } else if ( $startDate && $endDate && ( $start_datetime > $current ) && ( $current < $end_datetime ) ) {
        // If start and end date is set in the future.
        $should_display = $display === 'hide' ? true : false;
    } else if ( $startDate && $endDate && ( $start_datetime < $current ) && ( $current > $end_datetime ) ) {
        // If both start & end date passed.
        $should_display = $display === 'hide' ? true : false;
    }

    // If no start and end date set, only selected days to show the block
    if ( ! $startDate && ! $endDate && ! empty( $days_selected ) ) {
        // Get the current day of the week. Returns a string number (0 for sunday, 1 for monday...)
        $day_num = date( 'w' );
        $match = in_array( $days_of_the_week[ (int)$day_num ], $days_selected );

        if ( $display === 'hide' ) {
            $should_display = $match ? false : true;
        }
        if ( $display === 'show' ) {
            $should_display = $match ? true : false;
        }
    }

	return $should_display;
}, 10, 5 );
