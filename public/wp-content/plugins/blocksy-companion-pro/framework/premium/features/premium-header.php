<?php

namespace Blocksy;

class PremiumHeader {
	public function __construct() {
		add_filter(
			'blocksy:header:items-config',
			function ($config, $id) {
				if ($id === 'trigger' || $id === 'mobile-menu') {
					$config['devices'] = ['desktop', 'mobile'];
				}

				return $config;
			}, 10, 2
		);

		add_filter('blocksy:header:sections-for-dynamic-css', function ($sections, $value) {
			$result = [];

			foreach ($value['sections'] as $section) {
				if (
					$section['id'] === 'type-1'
					||
					(
						strpos($section['id'], 'ct-custom-') !== false
						&&
						$section['id'] !== 'ct-custom-transparent'
					)
				) {
					$result[] = $section;
				}
			}

			return $result;
		}, 10, 2);

		add_filter('blocksy:register_nav_menus:input', function ($items) {
			$old_item = $items['menu_mobile'];
			unset($items['menu_mobile']);

			$items['menu_3'] = __('Header Menu 3', 'blc');
			$items['menu_mobile'] = $old_item;

			return $items;
		});

		add_filter('blocksy:header:items-paths', function ($paths) {
			$paths[] = dirname(__FILE__) . '/premium-header/items';
			return $paths;
		});

		add_filter('blocksy:header:selective_refresh', function ($selective_refresh) {
			$selective_refresh[] = [
				'id' => 'header_placements_item:language-switcher',
				'fallback_refresh' => false,
				'container_inclusive' => true,
				'selector' => 'header [data-id="language-switcher"]',
				'settings' => ['header_placements'],
				'render_callback' => function () {
					$header = new \Blocksy_Header_Builder_Render();
					echo $header->render_single_item('language-switcher');
				}
			];

			$selective_refresh[] = [
				'id' => 'header_placements_item:contacts',
				'fallback_refresh' => false,
				'container_inclusive' => true,
				'selector' => 'header [data-id="contacts"]',
				'settings' => ['header_placements'],
				'render_callback' => function () {
					$header = new \Blocksy_Header_Builder_Render();
					echo $header->render_single_item('contacts');
				}
			];

			$selective_refresh[] = [
				'id' => 'header_placements_item:menu-tertiary',
				'fallback_refresh' => false,
				'container_inclusive' => true,
				'selector' => '#main-container > header',
				'loader_selector' => '[data-id="menu-tertiary"]',
				'settings' => ['header_placements'],
				'render_callback' => function () {
					echo blocksy_manager()->header_builder->render();
				}
			];

			return $selective_refresh;
		});

		add_action(
			'blocksy:widgets_init',
			function ($sidebar_title_tag) {
				$number_of_sidebars = 1;

				for ($i = 1; $i <= $number_of_sidebars; $i++) {
					register_sidebar(
						[
							'id' => 'ct-header-sidebar-' . $i,
							'name' => esc_html__('Header Widget Area ', 'blc'),
							'before_widget' => '<div class="ct-widget %2$s" id="%1$s">',
							'after_widget' => '</div>',
							'before_title' => '<' . $sidebar_title_tag . ' class="widget-title">',
							'after_title' => '</' . $sidebar_title_tag . '>',
						]
					);
				}
			},
			10
		);

		add_filter(
			'blocksy:header:current_section_id',
			function ($section_id, $all_sections) {
				$maybe_header = $this->maybe_get_header_that_matches($all_sections);

				if ($maybe_header) {
					return $maybe_header;
				}

				return $section_id;
			},
			10, 2
		);

		add_action('wp_ajax_blocksy_header_get_all_conditions', function () {
			if (! current_user_can('manage_options')) {
				wp_send_json_error();
			}

			wp_send_json_success([
				'conditions' => $this->get_conditions()
			]);
		});

		add_action('wp_ajax_blocksy_header_update_all_conditions', function () {
			if (! current_user_can('manage_options')) {
				wp_send_json_error();
			}

			$data = json_decode(
				file_get_contents('php://input'),
				true
			);

			$this->set_conditions($data);

			wp_send_json_success();
		});

		add_filter(
			'blocksy:header:button:options:after-link-options',
			function ($opts) {
				$opts['icon'] = [
					'type' => 'icon-picker',
					'label' => __('Icon', 'blc'),
					'design' => 'inline',
					'divider' => 'top:full',
					'value' => [
						'icon' => ''
					]
				];

				$opts[blocksy_rand_md5()] = [
					'type' => 'ct-condition',
					'condition' => ['icon/icon:truthy' => 'yes'],
					'options' => [

						'cta_button_icon_size' => [
							'label' => __( 'Icons Size', 'blc' ),
							'type' => 'ct-slider',
							'design' => 'block',
							'divider' => 'top',
							'min' => 5,
							'max' => 50,
							'value' => 15,
							'responsive' => true,
						],

						'icon_position' => [
							'type' => 'ct-radio',
							'label' => __( 'Icon Position', 'blc' ),
							'value' => 'left',
							'view' => 'text',
							'design' => 'block',
							'divider' => 'top',

							'choices' => [
								'left' => __( 'Left', 'blc' ),
								'right' => __( 'Right', 'blc' ),
							],
						],

					]

				];

				return $opts;
			}
		);

		add_action('wp_enqueue_scripts', function () {
			if (! function_exists('get_plugin_data')){
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}

			if (is_admin()) return;

			if (! function_exists('blocksy_image')) {
				return;
			}

			$render = new \Blocksy_Header_Builder_Render();

			if (! $render->contains_item('language-switcher')) {
				if (! is_customize_preview()) {
					return '';
				}
			}

			$data = get_plugin_data(BLOCKSY__FILE__);

			wp_enqueue_style(
				'blocksy-pro-language-switcher-styles',
				BLOCKSY_URL . 'framework/premium/static/bundle/language-switcher.min.css',
				['ct-main-styles'],
				$data['Version']
			);
		});
	}

	private function maybe_get_header_that_matches($all_sections) {
		$all_conditions = $this->get_conditions();

		foreach (array_reverse($all_sections['sections']) as $single_section) {
			$conditions = [];

			if (! blc_fs()->is__premium_only()) {
				if (strpos($single_section['id'], 'ct-custom') === false) {
					continue;
				}
			}

			foreach ($all_conditions as $single_condition) {
				if ($single_condition['id'] === $single_section['id']) {
					$conditions = $single_condition['conditions'];
				}
			}

			$conditions_manager = new \Blocksy\ConditionsManager();

			if ($conditions_manager->condition_matches($conditions)) {
				return $single_section['id'];
			}
		}

		return null;
	}

	public function get_conditions() {
		$option = get_theme_mod('blocksy_premium_header_conditions', []);

		if (empty($option)) {
			return [];
		}

		return $option;
	}

	public function set_conditions($conditions) {
		set_theme_mod('blocksy_premium_header_conditions', $conditions);
	}
}

