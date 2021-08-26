<?php
/**
 * Conditional logic of the condition type Conditional tag.
 *
 * @package Stackable
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'stackable_conditional_display/conditional-tag', function( $should_display, $display, $condition, $block_content, $block ) {
    $options = isset( $condition['options'] ) ? $condition['options'] : null;

    if ( $options ) {
        $selectedValues = $options['selectedValues'];

        if ( $selectedValues ) {
            if ( $display === 'hide' ) {
                foreach ( $selectedValues as $index => $value ) {
                    if ( strpos( $value, 'is_home' ) && is_home() ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'is_front_page' ) && is_front_page() ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'is_404' ) && is_404() ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'is_single' ) && is_single( get_the_ID() ) ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'is_attachment' ) && is_attachment() ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'is_preview' ) && is_preview() ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'is_page' ) && is_page( get_the_ID() ) ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'is_privacy_policy' ) && is_privacy_policy() ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'is_archive' ) && is_archive() ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'is_category' ) && is_category() ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'is_tag' ) && is_tag() ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'is_tax' ) && is_tax() ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'is_author' ) && is_author() ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'is_date' ) && is_date() ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'is_year' ) && is_year() ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'is_search' ) && is_search() ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'is_trackback' ) && is_trackback() ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'is_dynamic_sidebar' ) && is_dynamic_sidebar() ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'is_rtl' ) && is_rtl() ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'is_multisite' ) && is_multisite() ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'is_main_site' ) && is_main_site() ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'is_child_theme' ) && is_child_theme() ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'is_customize_preview' ) && is_customize_preview() ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'is_multi_author' ) && is_multi_author() ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'is_feed' ) && is_feed() ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'is_sticky' ) && is_sticky( get_the_ID() ) ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'is_post_type_hierarchical' ) && is_post_type_hierarchical( get_post_type( get_the_ID() ) ) ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'is_post_type_archive' ) && is_post_type_archive( get_post_type( get_the_ID() ) ) ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'comments_open' ) && comments_open( get_the_ID() ) ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'pings_open' ) && pings_open( get_the_ID() ) ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'has_excerpt' ) && has_excerpt( get_the_ID() ) ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'has_post_thumbnail' ) && has_post_thumbnail( get_the_ID() ) ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'has_tag' ) && has_tag() ) {
                        $should_display = false;
                        break;
                    }

                    if ( strpos( $value, 'has_term' ) && has_term() ) {
                        $should_display = false;
                        break;
                    }

                    // Has Primary Nav Menu
                    if ( strpos( $value, 'has_nav_menu' ) && has_nav_menu( 'primary' ) ) {
                        $should_display = false;
                        break;
                    }

                    $should_display = true;
                }
            }

            if ( $display === 'show' ) {
                foreach ( $selectedValues as $index => $value ) {
                    if ( strpos( $value, 'is_home' ) && is_home() ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'is_front_page' ) && is_front_page() ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'is_404' ) && is_404() ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'is_single' ) && is_single( get_the_ID() ) ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'is_attachment' ) && is_attachment() ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'is_preview' ) && is_preview() ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'is_page' ) && is_page( get_the_ID() ) ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'is_privacy_policy' ) && is_privacy_policy() ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'is_archive' ) && is_archive() ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'is_category' ) && is_category() ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'is_tag' ) && is_tag() ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'is_tax' ) && is_tax() ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'is_author' ) && is_author() ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'is_date' ) && is_date() ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'is_year' ) && is_year() ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'is_search' ) && is_search() ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'is_trackback' ) && is_trackback() ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'is_dynamic_sidebar' ) && is_dynamic_sidebar() ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'is_rtl' ) && is_rtl() ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'is_multisite' ) && is_multisite() ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'is_main_site' ) && is_main_site() ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'is_child_theme' ) && is_child_theme() ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'is_customize_preview' ) && is_customize_preview() ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'is_multi_author' ) && is_multi_author() ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'is_feed' ) && is_feed() ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'is_sticky' ) && is_sticky( get_the_ID() ) ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'is_post_type_hierarchical' ) && is_post_type_hierarchical( get_post_type( get_the_ID() ) ) ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'is_post_type_archive' ) && is_post_type_archive( get_post_type( get_the_ID() ) ) ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'comments_open' ) && comments_open( get_the_ID() ) ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'pings_open' ) && pings_open( get_the_ID() ) ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'has_excerpt' ) && has_excerpt( get_the_ID() ) ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'has_post_thumbnail' ) && has_post_thumbnail( get_the_ID() ) ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'has_tag' ) && has_tag() ) {
                        $should_display = true;
                        break;
                    }

                    if ( strpos( $value, 'has_term' ) && has_term() ) {
                        $should_display = true;
                        break;
                    }

                    // Has Primary Nav Menu
                    if ( strpos( $value, 'has_nav_menu' ) && has_nav_menu( 'primary' ) ) {
                        $should_display = true;
                        break;
                    }

                    $should_display = false;
                }
            }
        }
    }

	return $should_display;
}, 10, 5 );
