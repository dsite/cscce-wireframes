<?php

class BlocksyExtensionMegaMenu {
	public function __construct() {
		add_action('admin_enqueue_scripts', function () {
			if (! function_exists('get_plugin_data')) {
				require_once(ABSPATH . 'wp-admin/includes/plugin.php');
			}

			$data = get_plugin_data(BLOCKSY__FILE__);

			$current_screen = get_current_screen();

			if (! isset($current_screen->base)) {
				return;
			}

			if ($current_screen->base !== 'nav-menus') {
				return;
			}

			wp_enqueue_script(
				'blocksy-ext-mega-menu-admin-scripts',
				BLOCKSY_URL . 'framework/premium/extensions/mega-menu/static/bundle/main.js',
				['ct-options-scripts'],
				$data['Version']
			);

			wp_enqueue_style(
				'blocksy-ext-mega-menu-admin-styles',
				BLOCKSY_URL . 'framework/premium/extensions/mega-menu/static/bundle/admin.min.css',
				[],
				$data['Version']
			);

			wp_localize_script(
				'blocksy-ext-mega-menu-admin-scripts',
				'blocksy_ext_mega_menu_localization',
				[
					'public_url' => BLOCKSY_URL . 'framework/premium/extensions/mega-menu/static/bundle/',
					'mega_menu_options' => blc_call_fn(
						[
							'fn' => 'blocksy_get_options',
							'default' => 'array'
						],
						dirname(__FILE__) . '/options.php',
						[], false
					)
				]
			);
		});

		add_action(
			'wp_update_nav_menu',
			function () {
				do_action('blocksy:dynamic-css:refresh-caches');
			}
		);

		add_action('wp_enqueue_scripts', function () {
			if (! function_exists('get_plugin_data')){
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}

			$data = get_plugin_data(BLOCKSY__FILE__);

			if (is_admin()) return;

			wp_enqueue_style(
				'blocksy-ext-mega-menu-styles',
				BLOCKSY_URL . 'framework/premium/extensions/mega-menu/static/bundle/main.min.css',
				['ct-main-styles'],
				$data['Version']
			);
		});

		add_filter('wp_edit_nav_menu_walker', function ($walker) {
			require_once dirname(__FILE__) . '/custom-menu-walker.php';
			return 'Blocksy_Walker_Nav_Menu_Edit_Custom';
		}, 12);

		add_action(
			'wp_nav_menu_item_custom_fields',
			function ($item_id, $item, $depth, $args, $id) {
				echo blocksy_html_tag(
					'p',

					[
						'class' => 'blocksy-mega-menu-trigger description-wide',
						'data-item-id' => $item_id,
						'data-nav-id' => $id
					],

					blocksy_html_tag(
						'button',
						[
							'class' => 'button'
						],
						__('Menu Item Settings', 'blc')
					)
				);
			},
			10, 5
		);

		add_action('wp_ajax_blocksy_ext_mega_menu_get_nav_item_settings', function () {
			if (! current_user_can('manage_options')) {
				wp_send_json_error();
			}

			if (! isset($_POST['item_id'])) {
				wp_send_json_error();
			}

			wp_send_json_success([
				'settings' => blocksy_get_post_options($_POST['item_id']),
			]);
		});

		add_action('wp_ajax_blocksy_ext_mega_menu_update_nav_item_setting', function () {
			if (! current_user_can('manage_options')) {
				wp_send_json_error();
			}

			if (! isset($_REQUEST['item_id'])) {
				wp_send_json_error();
			}


			$data = json_decode(
				file_get_contents('php://input'),
				true
			);

			update_post_meta(
				$_REQUEST['item_id'],
				'blocksy_post_meta_options',
				$data
			);

			do_action('blocksy:dynamic-css:refresh-caches');

			wp_send_json_success();
		});

		add_filter(
			'blocksy:menu:has_animated_submenu',
			function ($has_animated, $item, $args) {
				$parent = $this->get_topmost_parent($item);

				$atts = blocksy_get_post_options($parent->ID);

				if (blocksy_akg('has_mega_menu', $atts, 'no') !== 'no') {
					return false;
				}

				return true;
			},
			10, 3
		);

		add_filter(
			'nav_menu_css_class',
			function ($classes, $item, $args, $depth) {
				if (
					! isset($args->blocksy_mega_menu)
					||
					! $args->blocksy_mega_menu
				) {
					return $classes;
				}

				if ($depth > 0) {
					return $classes;
				}

				$atts = blocksy_get_post_options($item->ID);

				if (blocksy_akg('has_mega_menu', $atts, 'no') === 'no') {
					return $classes;
				}

				$mega_menu_width = blocksy_akg('mega_menu_width', $atts, 'content');

				if ($mega_menu_width === 'content') {
					$classes[] = 'ct-mega-menu-content-width';
				} else {
					if ($mega_menu_width === 'full_width') {
						$classes[] = 'ct-mega-menu-full-width';
					} else {
						$classes[] = 'ct-mega-menu-custom-width';
					}
				}

				$mega_menu_content_width = blocksy_akg('mega_menu_content_width', $atts, 'default');

				if ($mega_menu_content_width === 'full_width') {
					$classes[] = 'ct-mega-menu-content-full';
				}

				$classes[] = 'ct-mega-menu-columns-' . blocksy_akg(
					'mega_menu_columns',
					$atts,
					'4'
				);

				return $classes;
			},
			10, 4
		);

		add_filter(
			'nav_menu_item_title',
			function ($title, $item, $args, $depth) {
				if (
					! isset($args->blocksy_advanced_item)
					||
					! $args->blocksy_advanced_item
				) {
					return $title;
				}

				$atts = blocksy_get_post_options($item->ID);

				$mega_menu_label = blocksy_akg('mega_menu_label', $atts, 'default');

				$icon_args = [
					'icon_descriptor' => blocksy_akg('menu_item_icon', $atts, [
						'icon' => ''
					])
				];

				if ($mega_menu_label !== 'disabled') {
					$icon_args['class'] = 'ct-' . blocksy_akg(
						'menu_item_position',
						$atts,
						'left'
					);
				} else {
					$title = '';
				}

				$icon = blc_get_icon($icon_args);

				if (blocksy_akg('menu_item_position', $atts, 'left') !== 'left') {
					$title = $title . $icon;
				} else {
					$title = $icon . $title;
				}

				if (blocksy_akg('has_menu_badge', $atts, 'no') === 'yes') {
					$title .= blocksy_html_tag(
						'span',
						[
							'class' => 'ct-menu-badge'
						],
						blocksy_akg('menu_badge_text', $atts, __('New', 'blc'))
					);
				}

				return $title;
			},
			9, 4
		);

		add_filter(
			'walker_nav_menu_start_el',
			function ($item_output, $item, $depth, $args) {
				if (
					! isset($args->blocksy_mega_menu)
					||
					! $args->blocksy_mega_menu
				) {
					return $item_output;
				}

				$atts = blocksy_get_post_options($item->ID);

				$mega_menu_content_type = blocksy_akg(
					'mega_menu_content_type',
					$atts,
					'default'
				);

				if ($mega_menu_content_type === 'default') {
					return $item_output;
				}

				$text = '';

				if ($mega_menu_content_type === 'text') {
					$text = do_shortcode(
						blocksy_default_akg(
							'mega_menu_text',
							$atts,
							''
						)
					);

					$item_output .= '<div class="entry-content">';
				}

				if (
					$mega_menu_content_type === 'hook'
					&&
					blocksy_get_default_content_block()
				) {
					$text = \Blocksy\Plugin::instance()
						->premium
						->content_blocks
						->output_hook(blocksy_default_akg(
							'mega_menu_hook',
							$atts,
							blocksy_get_default_content_block()
						), [
							'layout' => false
						]);
				}

				$item_output .= $text;

				if ($mega_menu_content_type === 'text') {
					$item_output .= '</div>';
				}

				return $item_output;
			},
			9, 4
		);

		add_action('blocksy:global-dynamic-css:enqueue', function ($args) {
			$my_items = get_posts([
				'post_type'   => 'nav_menu_item',
				'numberposts' => -1
			]);

			foreach ($my_items as $single_item_menu) {
				$atts = blocksy_get_post_options($single_item_menu->ID);

				blocksy_theme_get_dynamic_styles(array_merge([
					'path' => dirname(__FILE__) . '/item-dynamic-styles.php',
					'chunk' => 'global',
					'atts' => $atts,
					'root_selector' => ['.menu-item-' . $single_item_menu->ID]
				], $args));
			}
		});

		add_filter(
			'nav_menu_link_attributes',
			function ($attr, $item, $args, $depth) {
				if (
					! isset($args->blocksy_advanced_item)
					||
					! $args->blocksy_advanced_item
				) {
					return $attr;
				}

				$atts = blocksy_get_post_options($item->ID);

				$class = '';

				if (blocksy_akg('has_menu_item_link', $atts, 'yes') !== 'yes') {
					$class .= 'ct-disabled-link';
				}

				if (blocksy_akg('mega_menu_label', $atts, 'default') === 'heading') {
					$class .= ' ct-column-heading';
				}

				if (! empty($class)) {
					$attr['class'] = trim($class);
				}

				return $attr;
			},
			9, 4
		);
	}

	private function get_topmost_parent($item) {
		$current_parent = $item;

		$parents = [];

		while (intval($current_parent->menu_item_parent) !== 0) {
			$current_parent = wp_setup_nav_menu_item(get_post($current_parent->menu_item_parent));
		}

		return $current_parent;
	}
}

