<?php

namespace Blocksy;

class ContentBlocks {
	private $post_type = 'ct_content_block';
	private $shortcode = 'blocksy-content-block';

	public function __construct() {
		add_action(
			'admin_bar_menu',
			function ($wp_admin_bar) {
				if (is_admin()) {
					return;
				}

				if (! apply_filters(
					'blocksy:content-blocks:has-actions-debugger',
					true
				)) {
					return;
				}

				if (! function_exists('is_woocommerce')) {
					$wp_admin_bar->add_menu([
						'title' => isset($_GET['blocksy_preview_hooks']) ? (
							__('Hide Hooks', 'blc')
						) : __('Show Hooks', 'blc'),
						'id' => 'blocksy_preview_hooks',
						'href' => isset($_GET['blocksy_preview_hooks']) ? (
							remove_query_arg('blocksy_preview_hooks')
						) : add_query_arg('blocksy_preview_hooks', 'theme')
					]);

					return;
				}

				$wp_admin_bar->add_menu([
					'title' => __('Hooks Locations', 'blc'),
					'id' => 'blocksy_preview_hooks',
				]);

				$components = [];

				if (isset($_GET['blocksy_preview_hooks'])) {
					$current_value = $_GET['blocksy_preview_hooks'];

					if (! empty($current_value)) {
						$components = explode(':', $current_value);
					}
				}

				$theme_components = $components;
				$woo_components = $components;

				if (in_array('theme', $components)) {
					$theme_components = array_filter($theme_components, function ($el) {
						return $el !== 'theme';
					});
				} else {
					$theme_components[] = 'theme';
				}

				$theme_url = count($theme_components) > 0 ? add_query_arg(
					'blocksy_preview_hooks',
					implode(':', $theme_components)
				) : remove_query_arg('blocksy_preview_hooks');

				if (in_array('woo', $components)) {
					$woo_components = array_filter($woo_components, function ($el) {
						return $el !== 'woo';
					});
				} else {
					$woo_components[] = 'woo';
				}

				$woo_url = count($woo_components) > 0 ? add_query_arg(
					'blocksy_preview_hooks',
					implode(':', $woo_components)
				) : remove_query_arg('blocksy_preview_hooks');

				$wp_admin_bar->add_menu([
					'title' => in_array('theme', $components) ? (
						__('Hide Theme Hooks', 'blc')
					) : __('Show Theme Hooks', 'blc'),
					'parent' => 'blocksy_preview_hooks',
					'id' => 'blocksy_preview_hooks_theme',
					'href' => $theme_url
				]);

				$wp_admin_bar->add_menu([
					'title' => in_array('woo', $components) ? (
						__('Hide WooCommerce Hooks', 'blc')
					) : __('Show WooCommerce Hooks', 'blc'),
					'id' => 'blocksy_preview_hooks_woo',
					'parent' => 'blocksy_preview_hooks',
					'href' => $woo_url
				]);
			},
			2000
		);

		add_filter('blocksy:frontend:dynamic-js-chunks', function ($chunks) {
			$chunks[] = [
				'id' => 'blocksy_pro_micro_popups',
				'selector' => '.ct-popup',
				'url' => blc_call_fn(
					[
						'fn' => 'blocksy_cdn_url',
						'default' => BLOCKSY_URL . 'framework/premium/static/bundle/micro-popups.js',
					],
					BLOCKSY_URL . 'framework/premium/static/bundle/micro-popups.js'
				),
				// 'trigger' => 'submit'
			];

			return $chunks;
		});

		add_shortcode(
			$this->shortcode,
			function ($atts) {
				if (
					! $atts
					||
					! isset($atts['id'])
				) {
					return;
				}

				if (! function_exists('blocksy_get_post_options')) {
					return;
				}

				return $this->output_hook($atts['id'], [
					'hook_class' => 'alignfull'
				]);
			}
		);

		add_action('blocksy:content-blocks:display-hooks', function () {
			$this->maybe_display_hooks_preview();
			$this->display_hooks();
			$this->display_popups();
		});

		add_action('wp', function () {
			if (! function_exists('blocksy_get_post_options')) {
				return;
			}

			do_action('blocksy:content-blocks:display-hooks');
		}, 10000);

		if (class_exists('\Elementor\Plugin')) {
			add_filter(
				'get_post_metadata',
				function ($value, $post_id, $meta_key, $single) {
					if (
						get_post_type($post_id) !== $this->post_type
						||
						$meta_key !== '_wp_page_template'
					) {
						return $value;
					}

					return 'elementor_canvas';
				},
				20,
				4
			);
		}

		add_filter('blocksy:editor:post_types_for_rest_field', function ($post_types) {
			$post_types[] = $this->post_type;
			return $post_types;
		});

		add_filter('blocksy:editor:post_meta_options', function ($options, $post_type) {
			if ($post_type !== $this->post_type) {
				return $options;
			}

			global $post;

			$post_id = $post->ID;

			$template_type = get_post_meta($post_id, 'template_type', true);

			return blocksy_akg(
				'options',
				blocksy_get_variables_from_file(
					dirname(
						__FILE__
					) . '/content-blocks/options/' . $template_type . '.php',
					['options' => []]
				)
			);
		}, 10, 2);

		add_action('init', [$this, 'register_post_type']);

		add_filter('manage_ct_content_block_posts_columns', function ($columns) {
			$columns['template_type'] = __('Type', 'blc');
			$columns['location'] = __('Location/Trigger', 'blc');
			$columns['conditions'] = __('Conditions', 'blc');
			$columns['shortcode'] = __('Output', 'blc');
			$columns['actions'] = __('Enable/Disable', 'blc');

			return $columns;
		});

		add_action(
			'manage_ct_content_block_posts_custom_column',
			function ($column, $post_id) {
				$template_type = get_post_meta($post_id, 'template_type', '')[0];
				$atts = blocksy_get_post_options($post_id);

				if ($column === 'location') {
					if ($template_type === 'popup') {
						$popup_trigger_condition = blocksy_akg(
							'popup_trigger_condition',
							$atts,
							'default'
						);

						$humanized_triggers = [
							'default' => __('None', 'blc'),
							'scroll' => __('On scroll', 'blc'),
							'element_reveal' => __('On scroll to element', 'blc'),
							'page_load' => __('On page load', 'blc'),
							'after_inactivity' => __('After inactivity', 'blc'),
							'after_x_time' => __('After x time', 'blc'),
							'exit_intent' => __('On page exit intent', 'blc'),
						];

						$humanized_direction = [
							'down' => __('Down', 'blc'),
							'up' => __('Up', 'blc')
						];

						$once_text = '';

						if (
							$popup_trigger_condition !== 'default'
							&&
							blocksy_akg('popup_trigger_once', $atts, 'no') === 'yes'
						) {
							$once_text = ', once';
						}

						if (isset($humanized_triggers[$popup_trigger_condition])) {
							echo $humanized_triggers[$popup_trigger_condition];

							if ($popup_trigger_condition === 'element_reveal') {
								$scroll_to_element = blocksy_akg(
									'scroll_to_element',
									$atts,
									''
								);

								if (! empty($scroll_to_element)) {
									echo ' (' . $scroll_to_element . $once_text . ')';
								}
							}

							if (
								$popup_trigger_condition === 'page_load'
								||
								$popup_trigger_condition === 'exit_intent'
							) {
								if (! empty($once_text)) {
									echo ' (' . trim(str_replace(',', '', $once_text)) . ')';
								}
							}

							if ($popup_trigger_condition === 'after_inactivity') {
								echo ' (' . blocksy_akg(
									'inactivity_value',
									$atts,
									'10'
								) . 's' . $once_text . ')';
							}

							if ($popup_trigger_condition === 'after_x_time') {
								echo ' (' . blocksy_akg(
									'x_time_value',
									$atts,
									'10'
								) . 's' . $once_text . ')';
							}

							if ($popup_trigger_condition === 'scroll') {
								echo ' (' . $humanized_direction[blocksy_akg(
									'scroll_direction',
									$atts,
									'down'
								)] . ' ' . blocksy_akg(
									'scroll_value',
									$atts,
									'200px'
								) . $once_text . ')';
							}
						}
					}

					if ($template_type === 'hook') {
						$locations = array_merge([
							[
								'location' => blocksy_default_akg('location', $atts, ''),
								'priority' => blocksy_default_akg('priority', $atts, '10'),
								'custom_location' => blocksy_default_akg('custom_location', $atts, ''),
								'paragraphs_count' => blocksy_default_akg('paragraphs_count', $atts, '5'),
								'headings_count' => blocksy_default_akg('headings_count', $atts, '5'),
							]
						], blocksy_default_akg('additional_locations', $atts, []));

						$hooks_manager = new HooksManager();

						echo implode(
							'<br>',
							$hooks_manager->humanize_locations($locations)
						);
					}
				}

				if ($column === 'conditions') {
					$conditions = blocksy_default_akg('conditions', $atts, []);

					$conditions_manager = new ConditionsManager();

					echo implode(
						'<br>',
						$conditions_manager->humanize_conditions($conditions)
					);
				}

				if ($column === 'shortcode') {
					if (is_array($template_type) && isset($template_type[0])) {
						$template_type = $template_type[0];
					}


					if ($template_type === 'hook' || $template_type === 'popup') {
						$shortcode_column_value = '[' . $this->shortcode . ' id="' . $post_id . '"]';

						if ($template_type === 'popup') {
							$shortcode_column_value = '#ct-popup-' . $post_id;
						}

						echo blocksy_html_tag(
							'input',
							[
								'class' => 'blocksy-shortcode',
								'type' => 'text',
								'readonly' => '',
								'onfocus' => 'this.select()',
								'value' => $shortcode_column_value
							],
							false
						);
					}
				}

				if ($column === 'template_type') {
					$template_type = get_post_meta($post_id, 'template_type', '');

					if (is_array($template_type) && isset($template_type[0])) {
						echo ucfirst($template_type[0]);
					}
				}

				if ($column === 'actions') {
					$switch_class = 'ct-content-block-switch ct-option-switch';

					$atts = blocksy_get_post_options($post_id);

					if (blocksy_akg('is_hook_enabled', $atts, 'yes') === 'yes') {
						$switch_class .= ' ct-active';
					}

					$attr = [
						'class' => $switch_class,
						'data-post-id' => $post_id
					];

					echo '<div ' . blocksy_attr_to_html($attr) . '><span></div>';
				}
			}, 10, 2
		);

		add_action('admin_body_class', function ($classes) {
			global $pagenow;
			global $post;

			$screen = get_current_screen();

			if ('post-new.php' !== $pagenow && 'post.php' !== $pagenow) {
				return $classes;
			}

			if ($screen->post_type !== $this->post_type) {
				return $classes;
			}

			$atts = blocksy_get_post_options($post->ID);

			if (blocksy_akg('has_inline_code_editor', $atts, 'no') === 'yes') {
				$classes .= ' blocksy-inline-code-editor';
			}

			return $classes;
		});

		add_action('wp_ajax_blocksy_content_blocksy_create', function () {
			if (! current_user_can('manage_options')) {
				wp_send_json_error();
			}

			if (! isset($_REQUEST['name'])) {
				wp_send_json_error();
			}

			if (! isset($_REQUEST['type'])) {
				wp_send_json_error();
			}

			$post = [];

			$post['post_title'] = $_REQUEST['name'];
			$post['post_status'] = 'publish';
			$post['post_type'] = $this->post_type;

			$post_id = wp_insert_post($post);

			if (! $post_id) {
				wp_send_json_error();
			}

			update_post_meta($post_id, 'template_type', $_REQUEST['type']);

			if (
				isset($_GET['predefined_hook'])
				&&
				is_string($_GET['predefined_hook'])
			) {
				$predefined_values = explode(
					'::',
					sanitize_text_field($_GET['predefined_hook'])
				);

				$default_hook = $predefined_values[0];
				$default_priority = 10;

				if (count($predefined_values) > 1) {
					$default_priority = intval($predefined_values[1]);
				}

				$value = [
					'location' => $default_hook,
					'priority' => $default_priority
				];

				update_post_meta($post_id, 'blocksy_post_meta_options', $value);
			}

			wp_send_json_success([
				'name' => $_REQUEST['name'],
				'url' => get_edit_post_link($post_id, '&')
			]);
		});

		add_action('wp_ajax_blocksy_content_blocksy_toggle', function () {
			if (! current_user_can('manage_options')) {
				wp_send_json_error();
			}

			if (! isset($_REQUEST['post_id'])) {
				wp_send_json_error();
			}

			if (! isset($_REQUEST['enabled'])) {
				wp_send_json_error();
			}

			$post_id = intval($_REQUEST['post_id']);
			$enabled = $_REQUEST['enabled'];

			if ($enabled !== 'yes' && $enabled !== 'no') {
				wp_send_json_error();
			}

			if (! $post_id) {
				wp_send_json_error();
			}

			$atts = blocksy_get_post_options($post_id);
			$atts['is_hook_enabled'] = $enabled;
			update_post_meta($post_id, 'blocksy_post_meta_options', $atts);

			wp_send_json_success([]);
		});

		add_action(
			'wp',
			function () {
				$maybe_header_hook = blc_get_content_block_that_matches([
					'template_type' => 'header'
				]);

				if ($maybe_header_hook) {
					$content_block_renderer = new ContentBlocksRenderer(
						$maybe_header_hook
					);

					$content_block_renderer->pre_output();
				}

				$maybe_footer_hook = blc_get_content_block_that_matches([
					'template_type' => 'footer'
				]);

				if ($maybe_footer_hook) {
					$content_block_renderer = new ContentBlocksRenderer(
						$maybe_footer_hook
					);

					$content_block_renderer->pre_output();
				}

				if (is_404()) {
					$maybe_404_hook = blc_get_content_block_that_matches([
						'template_type' => '404',
						'match_conditions' => false
					]);

					if ($maybe_404_hook) {
						$content_block_renderer = new ContentBlocksRenderer(
							$maybe_404_hook
						);

						$content_block_renderer->pre_output();
					}
				}
			}
		);

		add_filter(
			'wp_sitemaps_post_types',
			function($post_types) {
				unset($post_types['ct_content_block']);
				return $post_types;
			}
		);

		add_filter(
			'the_seo_framework_sitemap_supported_post_types',
			function($post_types) {
				return array_diff(
					$post_types,
					['ct_content_block']
				);
			}
		);

		add_filter(
			'wpseo_sitemap_exclude_post_type',
			function ($excluded, $post_type) {
				if ($post_type === 'ct_content_block') {
					return true;
				}

				return $excluded;
			},
			10, 2
		);
	}

	public function get_admin_localizations() {
		global $pagenow;
		global $post;

		$screen = get_current_screen();

		$localize = [];

		if ($pagenow === 'post-new.php' || $pagenow === 'post.php') {
			if ($screen->post_type === $this->post_type && function_exists('wp_enqueue_code_editor')) {
				$localize['editor_settings'] = wp_enqueue_code_editor(
					[
						'type' => 'application/x-httpd-php',
						'codemirror' => [
							'indentUnit' => 2,
							'tabSize' => 2,
						]
					]
				);
			}
		}

		return $localize;
	}

	public function register_post_type() {
		register_post_type($this->post_type, [
			'labels' => [
				'name' => __('Content Blocks', 'blc'),
				'singular_name' => __('Content Block', 'blc'),
				'add_new' => __('Add New', 'blc'),
				'add_new_item' => __('Add New Content Block', 'blc'),
				'edit_item' => __('Edit Content Block', 'blc'),
				'new_item' => __('New Content Block', 'blc'),
				'all_items' => __('Content Blocks', 'blc'),
				'view_item' => __('View Content Block', 'blc'),
				'search_items' => __('Search Content Blocks', 'blc'),
				'not_found' => __('Nothing found', 'blc'),
				'not_found_in_trash' => __('Nothing found in Trash', 'blc'),
				'parent_item_colon' => '',
			],

			'public' => true,
			'show_ui' => true,
			'show_in_menu' => 'ct-dashboard',
			'publicly_queryable' => true,
			'can_export' => true,
			'query_var' => true,
			'has_archive' => false,
			'hierarchical' => false,
			'show_in_rest' => true,
			'exclude_from_search' => true,

			'supports' => [
				'title',
				'editor',
				'custom-fields'
				// 'fw-page-builder'
				// 'thumbnail',
				// 'revisions'
			],

			'capabilities' => [
				'edit_post' => 'edit_pages',
				'read_post' => 'edit_pages',
				'delete_post' => 'edit_pages',
				'edit_posts' => 'edit_pages',
				'edit_others_posts' => 'edit_pages',
				'publish_posts' => 'edit_pages',
				'read_private_posts' => 'edit_pages',
				'read' => 'edit_pages',
				'delete_posts' => 'edit_pages',
				'delete_private_posts' => 'edit_pages',
				'delete_published_posts' => 'edit_pages',
				'delete_others_posts' => 'edit_pages',
				'edit_private_posts' => 'edit_pages',
				'edit_published_posts' => 'edit_pages',
			],
		]);
	}

	public function maybe_display_hooks_preview() {
		if (
			! is_user_logged_in()
			||
			! current_user_can('manage_options')
			||
			(
				! isset($_GET['blocksy_preview_hooks'])
				&&
				(
					! wp_doing_ajax()
					||
					empty($_SERVER['HTTP_REFERER'])
					||
					strpos(
						$_SERVER['HTTP_REFERER'],
						'blocksy_preview_hooks'
					) === false
				)
			)
		) {
			return;
		}

		$hooks_manager = new HooksManager();

		$components = [];

		if (isset($_GET['blocksy_preview_hooks'])) {
			$current_value = $_GET['blocksy_preview_hooks'];

			if (strlen($current_value) > 0) {
				$components = explode(':', $current_value);
			}
		} else {
			if (! empty($_SERVER['HTTP_REFERER'])) {
				parse_str(
					parse_url($_SERVER['HTTP_REFERER'])['query'],
					$query_string
				);

				if (
					isset($query_string['blocksy_preview_hooks'])
					&&
					strlen($query_string['blocksy_preview_hooks']) > 0
				) {
					$components = explode(
						':',
						$query_string['blocksy_preview_hooks']
					);
				}
			}
		}

		foreach ($hooks_manager->get_all_hooks() as $hook) {
			if (isset($hook['visual']) && ! $hook['visual']) {
				continue;
			}

			if ($hook['type'] !== 'action') {
				continue;
			}

			if (strpos($hook['group'], __('WooCommerce', 'blc')) !== false) {
				if (! in_array('woo', $components)) {
					continue;
				}
			} else {
				if (! in_array('theme', $components)) {
					continue;
				}
			}

			$priority = 10;

			if (isset($hook['priority'])) {
				$priority = $hook['priority'];
			}

			add_action(
				$hook['hook'],
				function () use ($hook, $priority) {
					$class = 'blocksy-hook-indicator';

					if (isset($hook['group']) && $hook['group'] === __('WooCommerce', 'blc')) {
						$class .= ' blocksy-woo-indicator';
					}

					if (! isset($hook['attr'])) {
						$hook['attr'] = ['class' => $class];
					} else {
						$old = $hook['attr'];
						$hook['attr'] = [];

						$hook['attr']['class'] = 'blocksy-hook-indicator';

						$hook['attr'] = array_merge(
							$hook['attr'],
							$old
						);
					}

					echo '<div ' . blocksy_attr_to_html($hook['attr']) . '>';
					echo $hook['hook'];
					echo '<span data-hook="' . $hook['hook'] . '::' . $priority . '"></span>';
					echo '</div>';
				},
				$priority
			);
		}
	}

	public function display_popups() {
		$all_popups = array_keys(blc_get_content_blocks([
			'template_type' => 'popup'
		]));

		foreach ($all_popups as $hook_id) {
			if (! $this->is_hook_eligible_for_display($hook_id)) {
				continue;
			}

			$content_block_renderer = new ContentBlocksRenderer($hook_id);
			$content_block_renderer->pre_output();

			add_filter(
				'blocksy:footer:offcanvas-drawer',
				function ($els) use ($hook_id) {
					$values = blocksy_get_post_options($hook_id);

					$placement = blocksy_akg('popup_size', $values, 'medium');

					$overflow = blocksy_akg('popup_container_overflow', $values, 'scroll');

					$attr = [
						'id' => 'ct-popup-' . $hook_id,
						'data-popup-size' => $placement
					];


					if ($placement !== 'full') {
						$attr['data-popup-position'] = blocksy_akg(
							'popup_position',
							$values,
							'bottom:right'
						);
					}

					if ($overflow !== 'visible') {
						$attr['data-popup-overflow'] = $overflow;
					}

					$popup_backdrop_background = blocksy_akg(
						'popup_backdrop_background',
						$values,
						blocksy_background_default_value([
							'backgroundColor' => [
								'default' => [
									'color' => 'CT_CSS_SKIP_RULE'
								],
							],
						])
					);

					$attr['data-popup-backdrop'] = $popup_backdrop_background[
						'backgroundColor'
					]['default']['color'] !== 'CT_CSS_SKIP_RULE' ? 'yes' : 'no';

					$attr['data-popup-animation'] = blocksy_akg(
						'popup_open_animation',
						$values,
						'fade-in'
					);

					$popup_trigger_condition = blocksy_akg(
						'popup_trigger_condition',
						$values,
						'default'
					);

					if ($popup_trigger_condition !== 'default') {
						$attr['data-popup-mode'] = $popup_trigger_condition;

						if (blocksy_akg('popup_trigger_once', $values, 'no') === 'yes') {
							$attr['data-popup-mode'] .= '_once';
						}

						if ($popup_trigger_condition === 'after_x_time') {
							$attr['data-popup-mode'] .= ':' . blocksy_akg(
								'x_time_value',
								$values,
								200
							);
						}

						if ($popup_trigger_condition === 'after_inactivity') {
							$attr['data-popup-mode'] .= ':' . blocksy_akg(
								'inactivity_value',
								$values,
								200
							);
						}

						if ($popup_trigger_condition === 'element_reveal') {
							$scroll_to_element = blocksy_akg(
								'scroll_to_element',
								$values,
								''
							);

							if (! empty($scroll_to_element)) {
								$attr['data-popup-mode'] .= ':' . $scroll_to_element;
							} else {
								unset($attr['data-popup-mode']);
							}
						}

						if ($popup_trigger_condition === 'scroll') {
							$attr['data-popup-mode'] .= ':' . blocksy_akg(
								'scroll_value',
								$values,
								'200px'
							);

							$scroll_direction = blocksy_akg(
								'scroll_direction',
								$values,
								'down'
							);

							if ($scroll_direction === 'up') {
								$attr['data-popup-mode'] .= ':up';
							}
						}

					}

					$output_hook_args = [
						'layout' => true,
						'hook_class' => 'ct-popup',
						'hook_attr' => $attr,
						'article_wrapper' => [
							'class' => 'ct-popup-inner'
						]
					];

					$close_button_type = blocksy_akg(
						'close_button_type',
						$values,
						'outside'
					);

					if ($close_button_type !== 'none') {
						$output_hook_args['article_inside'] = '<span class="ct-close-button" data-location="' . $close_button_type . '">
							<svg class="ct-icon" width="12" height="12" viewBox="0 0 15 15">
								<path d="M1 15a1 1 0 01-.71-.29 1 1 0 010-1.41l5.8-5.8-5.8-5.8A1 1 0 011.7.29l5.8 5.8 5.8-5.8a1 1 0 011.41 1.41l-5.8 5.8 5.8 5.8a1 1 0 01-1.41 1.41l-5.8-5.8-5.8 5.8A1 1 0 011 15z"></path>
							</svg>
						</span>';
					}

					$els[] = $this->output_hook($hook_id, $output_hook_args);

					return $els;
				}
			);

		}
	}

	public function display_hooks() {
		$all_hooks = array_keys(blc_get_content_blocks());

		foreach ($all_hooks as $hook_id) {
			if (! $this->is_hook_eligible_for_display($hook_id)) {
				continue;
			}

			$values = blocksy_get_post_options($hook_id);

			$locations = array_merge([
				[
					'location' => blocksy_default_akg('location', $values, ''),
					'priority' => blocksy_default_akg('priority', $values, '10'),
					'custom_location' => blocksy_default_akg('custom_location', $values, ''),
					'paragraphs_count' => blocksy_default_akg('paragraphs_count', $values, '5'),
					'headings_count' => blocksy_default_akg('headings_count', $values, '5'),
				]
			], blocksy_default_akg('additional_locations', $values, []));

			$content_block_renderer = new ContentBlocksRenderer($hook_id);
			$content_block_renderer->pre_output();

			foreach ($locations as $location) {
				if (
					$location['location'] === 'custom_hook'
					&&
					! empty($location['custom_location'])
				) {
					$location['location'] = $location['custom_location'];
				}

				if (empty($location['location'])) {
					continue;
				}

				if ($location['location'] === 'blocksy:single:content:paragraphs-number') {
					add_filter(
						'render_block',
						function ($content, $parsed_block) use ($location, $hook_id) {
							if (isset($parsed_block['ct_hook_block'])) {
								return $content;
							}

							if (
								isset($parsed_block['firstLevelBlock'])
								&&
								$parsed_block['firstLevelBlock']
								&&
								isset($parsed_block['firstLevelBlockIndex'])
								&&
								intval(
									$parsed_block['firstLevelBlockIndex']
								) + 1 === intval($location['paragraphs_count'])
							) {
								$content .= $this->output_hook($hook_id, [
									'hook_class' => 'alignfull'
								]);
							}

							return $content;
						},
						intval($location['priority']), 2
					);

					continue;
				}

				if ($location['location'] === 'blocksy:single:content:headings-number') {
					add_filter(
						'render_block',
						function ($content, $parsed_block) use ($location, $hook_id) {
							if (isset($parsed_block['ct_hook_block'])) {
								return $content;
							}

							if (
								isset($parsed_block['firstLevelBlock'])
								&&
								$parsed_block['firstLevelBlock']
								&&
								isset($parsed_block['firstLevelHeadingIndex'])
								&&
								intval(
									$parsed_block['firstLevelHeadingIndex']
								) + 1 === intval($location['headings_count'])
							) {
								$content = $this->output_hook($hook_id, [
									'hook_class' => 'alignfull'
								]) . $content;
							}

							return $content;
						},
						intval($location['priority']), 2
					);

					continue;
				}

				add_action(
					$location['location'],
					function () use ($hook_id) {
						echo $this->output_hook($hook_id);
					},
					intval($location['priority'])
				);
			}
		}
	}

	public function output_hook($id, $args = []) {
		$args = wp_parse_args($args, [
			'layout' => true,
			'article_wrapper' => false,
			'hook_class' => '',
			'hook_attr' => [],
			'article_inside' => ''
		]);

		$content_block_renderer = new ContentBlocksRenderer($id);

		$content = apply_filters(
			'blocksy:pro:content-blocks:output-content',
			$content_block_renderer->get_content(),
			$id
		);

		if (empty($content)) {
			return '';
		}

		$atts = blocksy_get_post_options($id);

		if (blocksy_akg('has_inline_code_editor', $atts, 'no') === 'yes') {
			return $content;
		}

		$entry_content_class = 'entry-content';
		$container_class = '';

		$attr = array_merge([
			'data-block' => get_post_meta($id, 'template_type', true) . ':' . $id,
			'class' => $args['hook_class']
		], $args['hook_attr']);

		$content_block_position = blocksy_akg(
			'content_block_position',
			$atts,
			'default'
		);

		if ($content_block_position !== 'default') {
			$attr['data-block'] .= ':' . $content_block_position . ':' . blocksy_akg(
				'fixed_location',
				$atts,
				'bottom'
			);
		}

		$container_attr = [
			'class' => ''
		];

		$template_type = get_post_meta($id, 'template_type', true);

		$has_content_block_structure = blocksy_akg(
			'has_content_block_structure',
			$atts,
			$template_type === 'hook' ? 'no' : 'yes'
		);

		if ($has_content_block_structure === 'yes') {
			$container_class = 'ct-container-full';
			$data_content_output = 'normal';

			if (blocksy_akg('content_block_structure', $atts, 'type-4') === 'type-3') {
				$data_content_output = 'narrow';
			}

			$content_block_spacing = blocksy_akg(
				'content_block_spacing',
				$atts,
				'both'
			);

			$data_v_spacing_components = [];

			if (
				$content_block_spacing === 'both'
				||
				$content_block_spacing === 'top'
			) {
				$data_v_spacing_components[] = 'top';
			}

			if (
				$content_block_spacing === 'both'
				||
				$content_block_spacing === 'bottom'
			) {
				$data_v_spacing_components[] = 'bottom';
			}

			if (! empty($data_v_spacing_components)) {
				$attr['data-vertical-spacing'] = implode(
					':',
					$data_v_spacing_components
				);
			}
		}

		$attr['class'] = trim(
			$attr['class'] . ' ' . blocksy_visibility_classes(
				blocksy_default_akg('visibility', $atts, [
					'desktop' => true,
					'tablet' => true,
					'mobile' => true,
				])
			)
		);

		if (empty($attr['class'])) {
			unset($attr['class']);
		}

		if (! $args['layout']) {
			return blocksy_html_tag(
				'div',
				['class' => $entry_content_class],
				$content
			);
		}

		$article_wrapper = blocksy_html_tag(
			'article',
			[],
			$args['article_inside'] . blocksy_html_tag(
				'div',
				[
					'class' => $entry_content_class
				],
				$content
			)
		);

		if ($args['article_wrapper']) {
			$article_wrapper = blocksy_html_tag(
				'div',
				$args['article_wrapper'],
				$article_wrapper
			);
		}

		return blocksy_html_tag(
			'div',
			$attr,
			$container_class ? blocksy_html_tag('div', [
				'class' => $container_class,
				'data-content' => $data_content_output
			], $article_wrapper) : $article_wrapper
		);
	}

	private function is_hook_eligible_for_display($id) {
		$values = blocksy_get_post_options($id);
		$conditions = blocksy_default_akg(
			'conditions',
			$values,
			[]
		);

		$conditions_manager = new ConditionsManager();

		$timezone = null;

		if (function_exists('wp_timezone')) {
			$timezone = wp_timezone();
		}

		$then = new \DateTime(
			blocksy_default_akg('expiration_date', $values, ''),
			$timezone
		);
		$now = new \DateTime('now', $timezone);

		if (
			blocksy_default_akg(
				'has_content_block_expiration',
				$values,
				'no'
			) === 'yes'
			&&
			$then < $now
		) {
			return false;
		}

		if (blocksy_default_akg('is_hook_enabled', $values, 'yes') !== 'yes') {
			return false;
		}

		if (! $conditions_manager->condition_matches(
			$conditions ,
			apply_filters(
				'blocksy:pro:content-blocks:condition-match-args',
				[
					'relation' => 'OR'
				],
				$id
			)
		)) {
			return false;
		}

		return true;
	}
}

