<?php

class BlocksyExtensionCustomFontsPreBoot {
	public function __construct() {
		add_action('admin_enqueue_scripts', function () {
			if (! function_exists('get_plugin_data')) {
				require_once(ABSPATH . 'wp-admin/includes/plugin.php');
			}

			$data = get_plugin_data(BLOCKSY__FILE__);

			if (! function_exists('blocksy_is_dashboard_page')) return;
			if (! blocksy_is_dashboard_page()) return;

			wp_enqueue_script(
				'blocksy-ext-custom-fonts-admin-dashboard-scripts',
				BLOCKSY_URL . 'framework/premium/extensions/custom-fonts/dashboard-static/bundle/main.js',
				['ct-options-scripts', 'ct-dashboard-scripts'],
				$data['Version']
			);

			wp_enqueue_style(
				'blocksy-ext-custom-fonts-admin-dashboard-styles',
				BLOCKSY_URL . 'framework/premium/extensions/custom-fonts/dashboard-static/bundle/main.min.css',
				[],
				$data['Version']
			);
		});
	}

	public function ext_data() {
		$custom_fonts = apply_filters('blocksy_ext_custom_fonts:dynamic_fonts', []);

		$result = get_option('blocksy_ext_custom_fonts_settings', [
			'fonts' => []
		]);

		foreach ($custom_fonts as $index => $custom_font) {
			$custom_font['__custom'] = true;

			foreach ($custom_font['variations'] as $variation_index => $variation) {
				if (
					isset($variation['attachment_id'])
					&&
					! isset($variation['url'])
				) {
					$custom_font['variations'][$variation_index]['url'] = wp_get_attachment_url(
						$variation['attachment_id']
					);
				} else {
					if (empty(
						$custom_font['variations'][$variation_index]['url']
					)) {
						$custom_font['variations'][$variation_index]['url'] = '';
					}
				}
			}

			$result['fonts'][] = $custom_font;
		}

		return $result;
	}
}

