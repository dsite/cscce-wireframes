<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'stackable_premium_block_assets' ) ) {

	/**
	* Register block assets for both frontend + backend.
	*
	* @since 0.1
	*/
	function stackable_premium_block_assets() {
		wp_register_style(
			'ugb-style-css-premium',
			plugins_url( 'dist/frontend_blocks__premium_only.css', STACKABLE_FILE ),
			array(),
			STACKABLE_VERSION
		);

		if ( ! is_admin() ) {
			wp_register_script(
				'ugb-block-frontend-js-premium',
				plugins_url( 'dist/frontend_blocks__premium_only.js', STACKABLE_FILE ),
				array(),
				STACKABLE_VERSION
			);
		}
	}
	add_action( 'init', 'stackable_premium_block_assets' );
}

if ( ! function_exists( 'stackable_premium_block_editor_assets' ) ) {

	/**
	 * Register block assets for backend editor.
	 *
	 * @since 0.1
	 */
	function stackable_premium_block_editor_assets() {
		if ( ! is_admin() ) {
			return;
		}

		// This should enqueue BEFORE the main Stackable block script.
		wp_register_script(
			'ugb-block-js-premium',
			plugins_url( 'dist/editor_blocks__premium_only.js', STACKABLE_FILE ),
			array(),
			STACKABLE_VERSION
		);

		// Add translations.
		wp_set_script_translations( 'ugb-block-js-premium', STACKABLE_I18N );

		wp_register_style(
			'ugb-block-editor-css-premium',
			plugins_url( 'dist/editor_blocks__premium_only.css', STACKABLE_FILE ),
			array(),
			STACKABLE_VERSION
		);
	}
	add_action( 'init', 'stackable_premium_block_editor_assets' );
}

/**
 * Add the premium block assets as dependencies to the free version, so that our
 * premium block assets load first.
 *
 * @since 2.17.2
 */
if ( ! function_exists( 'stackable_frontend_css_dependencies_premium' ) ) {
	function stackable_frontend_css_dependencies_premium( $deps ) {
		$deps[] = 'ugb-style-css-premium';
		return $deps;
	}
	add_filter( 'stackable_frontend_css_dependencies', 'stackable_frontend_css_dependencies_premium' );

	function stackable_frontend_js_dependencies_premium( $deps ) {
		$deps[] = 'ugb-block-frontend-js-premium';
		return $deps;
	}
	add_filter( 'stackable_frontend_js_dependencies', 'stackable_frontend_js_dependencies_premium' );

	function stackable_editor_js_dependencies_premium( $deps ) {
		$deps[] = 'ugb-block-js-premium';
		return $deps;
	}
	add_filter( 'stackable_editor_js_dependencies', 'stackable_editor_js_dependencies_premium' );

	function stackable_editor_css_dependencies_premium( $deps ) {
		$deps[] = 'ugb-block-editor-css-premium';
		return $deps;
	}
	add_filter( 'stackable_editor_css_dependencies', 'stackable_editor_css_dependencies_premium' );
}
