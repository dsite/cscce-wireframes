<?php

class BlocksyExtensionShortcuts {
	public function __construct() {
		add_action('wp_enqueue_scripts', function () {
			if (! function_exists('get_plugin_data')) {
				require_once(ABSPATH . 'wp-admin/includes/plugin.php');
			}

			$data = get_plugin_data(BLOCKSY__FILE__);

			if (is_admin()) {
				return;
			}

			wp_enqueue_style(
				'blocksy-ext-shortcuts-styles',
				BLOCKSY_URL . 'framework/premium/extensions/shortcuts/static/bundle/main.min.css',
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
					'blocksy-ext-shortcuts-customizer-sync',
					BLOCKSY_URL . 'framework/premium/extensions/shortcuts/static/bundle/sync.js',
					[ 'customize-preview', 'ct-scripts' ],
					$data['Version'],
					true
				);
			}
		);

		add_filter(
			'blocksy_extensions_customizer_options',
			function ($opts) {
				$opts['shortcuts_ext'] = blc_call_fn(
					[
						'fn' => 'blocksy_get_options',
						'default' => 'array'
					],
					dirname(__FILE__) . '/customizer.php',
					[], false
				);

				return $opts;
			}
		);

		add_action('blocksy:template:after', function () {
			$initial_conditions = [
				[
					'type' => 'include',
					'rule' => 'everywhere'
				]
			];

			if (class_exists('WooCommerce')) {
				$initial_conditions[] = [
					'type' => 'exclude',
					'rule' => 'page_ids',
					'payload' => [
						'post_id' => intval(get_option('woocommerce_cart_page_id'))
					]
				];

				$initial_conditions[] = [
					'type' => 'exclude',
					'rule' => 'page_ids',
					'payload' => [
						'post_id' => intval(get_option('woocommerce_checkout_page_id'))
					]
				];
			}

			$conditions = get_theme_mod(
				'shortcuts_bar_conditions',
				$initial_conditions
			);

			$conditions_manager = new \Blocksy\ConditionsManager();

			if (! $conditions_manager->condition_matches($conditions)) {
				return;
			}

			echo blocksy_render_view(
				dirname(__FILE__) . '/views/bar.php',
				[]
			);
		});

		add_action('blocksy:global-dynamic-css:enqueue', function ($args) {
			blocksy_theme_get_dynamic_styles(array_merge([
				'path' => dirname(__FILE__) . '/global.php',
				'chunk' => 'global',
			], $args));
		}, 10, 3);

		add_filter('blocksy:woocommerce:cart-fragments', function ($fragments) {
			$maybe_cart = blocksy_render_view(
				dirname(__FILE__) . '/views/bar.php',
				[
					'only_item' => 'cart'
				]
			);

			if (! empty(trim($maybe_cart))) {
				$fragments['.ct-shortcuts-container [data-shortcut="cart"]'] = $maybe_cart;
			}

			return $fragments;
		});

		add_filter('blocksy:frontend:dynamic-js-chunks', function ($chunks) {
			$chunks[] = [
				'id' => 'blocksy_shortcuts_auto_hide',
				'selector' => '.ct-shortcuts-container[data-behaviour="scroll"]',
				'trigger' => 'scroll',
				'url' => blc_call_fn(
					[
						'fn' => 'blocksy_cdn_url',
						'default' => BLOCKSY_URL . 'framework/premium/extensions/shortcuts/static/bundle/auto-hide.js',
					],
					BLOCKSY_URL . 'framework/premium/extensions/shortcuts/static/bundle/auto-hide.js'
				),
			];

			return $chunks;
		});

		add_filter(
			'blocksy:translations-manager:all-translation-keys',
			function ($all_keys) {
				$shortcuts_bar_items = get_theme_mod(
					'shortcuts_bar_items',
					'__EMPTY__'
				);

				if ($shortcuts_bar_items === '__EMPTY__') {
					return $all_keys;
				}

				foreach ($shortcuts_bar_items as $item) {
					$id_prefix = 'shortcuts:' . $item['id'];

					if ($item['id'] === 'custom_link' && isset($item['__id'])) {
						$id_prefix = 'shortcuts:' . $item['__id'];
					}

					if (isset($item['label']) && ! empty($item['label'])) {
						$all_keys[] = [
							'key' => $id_prefix . ':label',
							'value' => $item['label']
						];
					}

					if (isset($item['link']) && ! empty($item['link'])) {
						$all_keys[] = [
							'key' => $id_prefix . ':link',
							'value' => $item['link']
						];
					}
				}

				return $all_keys;
			}
		);
	}
}

