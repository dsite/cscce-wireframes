<?php

class BlocksyAdvancedPostTypesFiltering {
	public function __construct() {
		add_filter(
			'blocksy_posts_home_page_elements_end',
			function ($options, $prefix, $post_type) {
				$options[$prefix . '_has_archive_filtering'] = blc_call_fn(
					[
						'fn' => 'blocksy_get_options',
						'default' => 'array'
					],
					dirname(__FILE__) . '/filtering/customizer.php',
					[
						'prefix' => $prefix,
						'post_type' => $post_type
					], false
				);

				return $options;
			},
			10, 3
		);

		add_action('blocksy:global-dynamic-css:enqueue', function ($args) {
			blocksy_theme_get_dynamic_styles(array_merge([
				'path' => dirname(__FILE__) . '/filtering/global.php',
				'chunk' => 'global',
				'prefixes' => blocksy_manager()->screen->get_archive_prefixes([
					'has_categories' => true,
					'has_author' => false,
					'has_search' => false
				])
			], $args));
		}, 10, 3);

		add_filter('blocksy:frontend:dynamic-js-chunks', function ($chunks) {
			$prefix = blocksy_manager()->screen->get_prefix([
				'allowed_prefixes' => [
					'blog'
				],
				'default_prefix' => 'blog'
			]);

			if (get_theme_mod($prefix . '_filter_behavior', 'ajax') === 'ajax') {
				$chunks[] = [
					'id' => 'blocksy_adv_cpt_filtering',
					'selector' => '.ct-dynamic-filter a',
					'trigger' => 'click',
					'url' => blc_call_fn(
						[
							'fn' => 'blocksy_cdn_url',
							'default' => BLOCKSY_URL . 'framework/premium/extensions/post-types-extra/static/bundle/filtering.js',
						],
						BLOCKSY_URL . 'framework/premium/extensions/post-types-extra/static/bundle/filtering.js'
					),
				];
			}

			$chunks[] = [
				'id' => 'blocksy_adv_cpt_filtering',
				'selector' => '.ct-dynamic-filter, .ct-dynamic-filter + .entries',
				'trigger' => 'hover',
				'url' => blc_call_fn(
					[
						'fn' => 'blocksy_cdn_url',
						'default' => BLOCKSY_URL . 'framework/premium/extensions/post-types-extra/static/bundle/filtering.js',
					],
					BLOCKSY_URL . 'framework/premium/extensions/post-types-extra/static/bundle/filtering.js'
				),
			];

			return $chunks;
		});

		add_action(
			'blocksy:loop:before',
			function () {
				if (
					! is_tax()
					&&
					! is_category()
					&&
					! is_tag()
					&&
					! is_home()
					&&
					! is_post_type_archive()
				) {
					return;
				}

				blc_cpt_extra_filtering_output();
			}
		);

		add_action('pre_get_posts', function ($query) {
			if (! $query->is_main_query()) {
				return;
			}

			if (
				! is_tax()
				&&
				! is_category()
				&&
				! is_tag()
			) {
				return;
			}

			$post_type = $query->get('post_type');

			if (is_tag() || is_category()) {
				$post_type = 'post';
			}

			$prefix = blocksy_manager()->screen->get_prefix([
				'allowed_prefixes' => [
					'blog'
				],
				'default_prefix' => 'blog'
			]);

			$maybe_current_tax = null;

			if (isset($_GET['blocksy_term_id'])) {
				$maybe_current_tax = $_GET['blocksy_term_id'];
			}

			if (! $maybe_current_tax) {
				return;
			}

			$maybe_tax = get_theme_mod(
				$prefix . '_filter_source',
				blocksy_maybe_get_matching_taxonomy($post_type)
			);

			$current_tax_query = [
				'taxonomy' => $maybe_tax,
				'field' => 'term_id',
				'terms' => [$maybe_current_tax]
			];

			$query->tax_query->queries[] = $current_tax_query;

			$query->set('tax_query', $query->tax_query);
			$query->query_vars['tax_query'] = $query->tax_query->queries;
		});
	}
}

if ( ! function_exists( 'blc_cpt_extra_filtering_output' ) ) {
	function blc_cpt_extra_filtering_output($args = []) {
		$args = wp_parse_args($args, [
			'prefix' => null,
			'post_type' => get_post_type(),

			'term_ids' => [],

			// default | current_page
			'links_strategy' => 'default'
		]);

		if (! $args['prefix']) {
			$args['prefix'] = blocksy_manager()->screen->get_prefix([
				'allowed_prefixes' => [
					'blog'
				],
				'default_prefix' => 'blog'
			]);
		}

		$prefix = $args['prefix'];

		$maybe_tax = get_theme_mod(
			$prefix . '_filter_source',
			blocksy_maybe_get_matching_taxonomy($args['post_type'])
		);

		if (! $maybe_tax) {
			return;
		}

		$has_archive_filtering = get_theme_mod(
			$prefix . '_has_archive_filtering',
			'no'
		);

		$class = 'ct-dynamic-filter';

		$class .= ' ' . blc_call_fn(
			['fn' => 'blocksy_visibility_classes'],
			get_theme_mod($prefix . '_filter_visibility', [
				'desktop' => true,
				'tablet' => true,
				'mobile' => false,
			])
		);

		$type = get_theme_mod(
			$prefix . '_filter_type',
			'simple'
		);

		if ($has_archive_filtering === 'no') {
			return;
		}

		$all_terms = get_terms([
			'taxonomy' => $maybe_tax,
			'parent' => 0,
			'hide_empty' => true,
		]);

		if (empty($all_terms)) {
			return;
		}

		$post_type_object = get_post_type_object($args['post_type']);

		if (! $post_type_object->has_archive && $args['post_type'] !== 'post') {
			return;
		}

		echo '<div class="' . $class . '" data-type="' . $type . '">';

		$parent_attr = [
			'href' => get_post_type_archive_link($args['post_type'])
		];

		$maybe_current_tax = null;

		if (isset($_GET['blocksy_term_id'])) {
			$maybe_current_tax = $_GET['blocksy_term_id'];
		}

		if ($args['links_strategy'] === 'current_page') {
			$parent_attr['href'] = get_permalink();

			if (! $maybe_current_tax) {
				$parent_attr['class'] = 'active';
			}
		}

		if (
			(
				is_post_type_archive($args['post_type'])
				&&
				! is_tax($maybe_tax)
			) || is_home()
		) {
			$parent_attr['class'] = 'active';
		}

		if (
			is_tax()
			||
			is_category()
			||
			is_tag()
		) {
			$current_tax = get_queried_object();

			if (
				$current_tax
				&&
				$current_tax->taxonomy !== $maybe_tax
			) {
				$parent_attr['href'] = get_term_link(
					$current_tax->term_id,
					$current_tax->taxonomy
				);

				if (! $maybe_current_tax) {
					$parent_attr['class'] = 'active';
				}
			}
		}

		echo blocksy_html_tag('a', $parent_attr, __('All', 'blc'));

		foreach ($all_terms as $term) {
			$attr = [
				'href' => get_term_link($term, $maybe_tax)
			];

			if (
				is_tax()
				||
				is_category()
				||
				is_tag()
			) {
				$current_tax = get_queried_object();

				if ($current_tax && $current_tax->taxonomy !== $maybe_tax) {
					$attr['href'] = add_query_arg(
						'blocksy_term_id',
						$term->term_id,
						get_term_link(
							$current_tax->term_id,
							$current_tax->taxonomy
						)
					);
				}
			}

			if ($args['links_strategy'] === 'current_page') {
				$attr['href'] = add_query_arg(
					'blocksy_term_id',
					$term->term_id,
					get_permalink()
				);
			}

			if (
				is_tax($maybe_tax, $term->term_id)
				||
				is_category($term->term_id)
				||
				is_tag($term->term_id)
				||
				(
					$maybe_current_tax
					&&
					intval($maybe_current_tax) === $term->term_id
				)
			) {
				$attr['class'] = 'active';
			}

			echo blocksy_html_tag('a', $attr, $term->name);
		}

		echo '</div>';
	}
}
