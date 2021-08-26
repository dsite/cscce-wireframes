<?php

namespace Blocksy;

class ContentBlocksRenderer {
	private $id = '';

	public function __construct($id) {
		$this->id = $id;
	}

	public function get_content() {
		$id = $this->id;

		$atts = blocksy_get_post_options($id);
		$post = get_post($id);

		if (blocksy_akg('has_inline_code_editor', $atts, 'no') === 'yes') {
			$blocks = parse_blocks($post->post_content);

			if (empty($blocks)) {
				return '';
			}

			if ($blocks[0]['blockName'] !== 'core/code') {
				return '';
			}

			$inline_code = str_replace(
				'<pre class="wp-block-code"><code>',
				'',
				str_replace(
					'</code></pre>',
					'',
					html_entity_decode(htmlspecialchars_decode($blocks[0]['innerHTML']))
				)
			);

			$ending = '<?php ';

			if (strpos($inline_code, '<?php') !== false) {
				if (strpos($inline_code, '?>') === false) {
					$ending = '';
				}
			}

			ob_start();
			eval('?>' . $inline_code . $ending);
			return ob_get_clean();
		}

		if (
			class_exists('\Elementor\Plugin')
			&&
			\Elementor\Plugin::$instance->db->is_built_with_elementor($id)
		) {
			return \Elementor\Plugin::$instance
				->frontend
				->get_builder_content_for_display($id);
		}

		if (class_exists('\ZionBuilder\Plugin')) {
			$post_instance = \ZionBuilder\Plugin::instance()
				->post_manager
				->get_post_instance($id);

			if ($post_instance->is_built_with_zion()) {
				return \ZionBuilder\Plugin::instance()->renderer->get_content($id);
			}
		}

		if (class_exists('Brizy_Editor')) {
			try {
				if (
					in_array(
						get_post_type($id),
						\Brizy_Editor::get()->supported_post_types()
					)
					&&
					\Brizy_Editor_Post::get($id)->uses_editor()
				) {
					$brizy = \Brizy_Editor_Post::get( $post->ID );

					return apply_filters(
						'brizy_content',
						$brizy->get_compiled_page()->get_body(),
						\Brizy_Editor_Project::get(),
						$brizy->getWpPost()
					);
				}
			} catch (Exception $e) {
			}
		}

		$result = '';

		if (has_blocks($post)) {
			$blocks = parse_blocks($post->post_content);

			foreach ($blocks as $block) {
				$block['ct_hook_block'] = true;
				$result .= render_block($block);
			}
		} else {
			$result = $post->post_content;
		}

		global $wp_embed;

		if ($wp_embed) {
			$result = $wp_embed->autoembed($result);
		}

		// return do_shortcode(get_the_content(null, false, $id));
		return do_shortcode($result);
	}

	public function pre_output() {
		$id = $this->id;

		$atts = blocksy_get_post_options($id);
		$template_type = get_post_meta($id, 'template_type', true);

		if ($template_type === 'popup') {
			add_action('wp_enqueue_scripts', function () {
				if (! function_exists('get_plugin_data')){
					require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				}

				$data = get_plugin_data(BLOCKSY__FILE__);

				if (is_admin()) return;

				wp_enqueue_style(
					'blocksy-pro-popup-styles',
					BLOCKSY_URL . 'framework/premium/static/bundle/popups.min.css',
					['ct-main-styles'],
					$data['Version']
				);
			});
		}

		add_filter(
			'generateblocks_do_content',
			function ($content) use ($id) {
				$post = get_post($id);
				return $content . $post->post_content;
			}
		);

		do_action('blocksy:pro:content-blocks:pre-output', $id);

		if (class_exists('\ZionBuilder\Plugin')) {
			$post_instance = \ZionBuilder\Plugin::instance()
				->post_manager
				->get_post_instance($id);

			if ($post_instance->is_built_with_zion()) {
				$post_template_data = $post_instance->get_template_data();

				\ZionBuilder\Plugin::instance()
					->renderer
					->register_area($id, $post_template_data);

				\ZionBuilder\Plugin::instance()->cache->register_post_id($id);
			}
		}

		if (
			class_exists('\Elementor\Plugin')
			&&
			\Elementor\Plugin::$instance->db->is_built_with_elementor($id)
			&&
			! (
				isset($_POST['wp_customize_render_partials'])
				||
				wp_doing_ajax()
			)
		) {
			$document = \Elementor\Plugin::$instance->documents->get_doc_for_frontend(
				$id
			);

			// Change the current post, so widgets can use `documents->get_current`.
			\Elementor\Plugin::$instance->documents->switch_to_document($document);
			$data = $document->get_elements_data();
			$data = apply_filters('elementor/frontend/builder_content_data', $data, $id);

			if (!empty($data)) {
				if ($document->is_autosave()) {
					$css_file = new \Elementor\Core\Files\CSS\Post_Preview(
						$document->get_post()->ID
					);
				} else {
					$css_file = new \Elementor\Core\Files\CSS\Post($id);
				}

				$css_file->enqueue();
				$css_file->print_css();
			}
		}

		if (class_exists('Brizy_Editor')) {
			try {
				if (
					in_array(get_post_type($id), \Brizy_Editor::get()->supported_post_types())
					&&
					\Brizy_Editor_Post::get($id)->uses_editor()
				) {
					$brizy_element = \Brizy_Editor_Post::get($id);

					global $post;

					if (
						! is_singular()
						||
						! \Brizy_Editor_Post::get($post->ID)->uses_editor()
					) {
						if (method_exists('\Brizy_Public_Main', 'get')) {
							$brizy_class = \Brizy_Public_Main::get($brizy_element);
						} else {
							$brizy_class = new \Brizy_Public_Main($brizy_element);
						}

						add_action(
							'wp_enqueue_scripts',
							[$brizy_class, '_action_enqueue_preview_assets'],
							999
						);
					}

					add_filter(
						'body_class',
						function ($classes) {
							$classes[] = 'brz';
							$classes[] = ( function_exists( 'wp_is_mobile' ) && wp_is_mobile() ) ? 'brz-is-mobile' : '';

							return $classes;
						}
					);

					add_action('wp_head', function() use ($brizy_element) {
						$brizy_project = \Brizy_Editor_Project::get();

						$brizy_html = new \Brizy_Editor_CompiledHtml(
							$brizy_element->get_compiled_html()
						);

						echo apply_filters(
							'brizy_content',
							$brizy_html->get_head(),
							$brizy_project,
							$brizy_element->get_wp_post()
						);
					});
				}
			} catch (Exception $e) {
			}
		}

		if ($template_type === 'popup') {
			add_action(
				'blocksy:global-dynamic-css:enqueue:inline',
				function ($args) use ($id) {
					$atts = blocksy_get_post_options($id);

					blocksy_theme_get_dynamic_styles(array_merge([
						'path' => dirname(__FILE__) . '/popup-dynamic-styles.php',
						'chunk' => 'hooks',
						'id' => $id,
						'atts' => $atts
					], $args));
				},
				10, 3
			);
		}

		if (blocksy_akg(
			'has_content_block_structure',
			$atts,
			$template_type === 'hook' ? 'no' : 'yes'
		) === 'yes') {
			add_action(
				'blocksy:global-dynamic-css:enqueue:inline',
				function ($args) use ($id) {
					$atts = blocksy_get_post_options($id);

					blocksy_theme_get_dynamic_styles(array_merge([
						'path' => dirname(__FILE__) . '/dynamic-styles.php',
						'chunk' => 'hooks',
						'id' => $id,
						'atts' => $atts
					], $args));
				},
				10, 3
			);
		}
	}
}

