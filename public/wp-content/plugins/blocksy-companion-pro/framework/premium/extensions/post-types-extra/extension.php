<?php

require_once dirname(__FILE__) . '/includes/read-progress.php';
require_once dirname(__FILE__) . '/includes/dynamic-data.php';
require_once dirname(__FILE__) . '/includes/filtering.php';
require_once dirname(__FILE__) . '/includes/taxonomies-options.php';
require_once dirname(__FILE__) . '/includes/estimated-read-time.php';

class BlocksyExtensionPostTypesExtra {
	public function __construct() {
		new BlocksyAdvancedPostTypesReadProgress();
		new BlocksyAdvancedPostTypesDynamicDataAcf();
		new BlocksyAdvancedPostTypesFiltering();
		new BlocksyAdvancedPostTypesTaxonomies();
		new BlocksyAdvancedPostTypesEstimatedReadTime();

		add_action('wp_enqueue_scripts', function () {
			if (! function_exists('get_plugin_data')) {
				require_once(ABSPATH . 'wp-admin/includes/plugin.php');
			}

			$data = get_plugin_data(BLOCKSY__FILE__);

			if (is_admin()) {
				return;
			}

			wp_enqueue_style(
				'blocksy-ext-post-types-extra-styles',
				BLOCKSY_URL . 'framework/premium/extensions/post-types-extra/static/bundle/main.min.css',
				['ct-main-styles'],
				$data['Version']
			);
		});

		add_action(
			'customize_preview_init',
			function () {
				if (! function_exists('get_plugin_data')) {
					require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				}

				$data = get_plugin_data(BLOCKSY__FILE__);

				wp_enqueue_script(
					'blocksy-ext-post-types-extra-customizer-sync',
					BLOCKSY_URL . 'framework/premium/extensions/post-types-extra/static/bundle/sync.js',
					['customize-preview', 'ct-scripts'],
					$data['Version'],
					true
				);
			}
		);
	}
}

