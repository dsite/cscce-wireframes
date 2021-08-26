<?php

class BlocksyAdvancedPostTypesDynamicDataAcf {
	public function __construct() {
		add_action('init', [$this, 'init']);
	}

	public function init() {
		if (
			! function_exists('acf_get_field_groups')
			&&
			! function_exists('rwmb_get_object_fields')
			&&
			! function_exists('types_render_field')
			&&
			! function_exists('jet_engine')
		) {
			return;
		}

		// Options

		add_filter(
			'blocksy:options:page-title:design:before_breadcrumbs',
			function ($opts, $prefix) {
				return $this->add_design_options($opts, $prefix, 'hero_elements');
			},
			10, 2
		);

		add_filter(
			'blocksy:options:posts-listing:design:before_card_background',
			function ($opts, $prefix) {
				return $this->add_design_options($opts, $prefix, 'archive_order');
			},
			10, 2
		);

		add_filter(
			'blocksy:options:meta:meta_elements',
			function ($layers, $prefix, $computed_cpt) {
				foreach ($this->complement_layers_option([
					'value' => [],
					'settings' => []
				], $computed_cpt, [
					'has_icon' => true,
					'has_label_option' => false
				])['settings'] as $id => $layer) {
					$layers[$id] = $layer;
				}

				return $layers;
			},
			10, 3
		);

		add_filter(
			'blocksy:options:page-title:hero-elements',
			function ($option, $prefix) {
				if (
					$prefix !== 'single_blog_post'
					&&
					$prefix !== 'single_page'
					&&
					$prefix !== 'product'
					&&
					strpos($prefix, '_single') === false
				) {
					return $option;
				}

				return $this->complement_layers_option($option, $prefix);
			},
			10, 2
		);

		add_filter(
			'blocksy:options:posts-listing-archive-order',
			[$this, 'complement_layers_option'],
			10, 2
		);

		// Rendering

		add_action(
			'blocksy:post-meta:render-meta',
			[$this, 'render_acf_meta'],
			10, 3
		);

		add_action(
			'blocksy:hero:element:render',
			[$this, 'render_dynamic_field_layer']
		);

		add_filter(
			'blocksy:archive:render-card-layer',
			function ($output, $atts) {
				$maybe_layer = $this->render_dynamic_field_layer($atts, false);

				if (! empty($maybe_layer)) {
					return $maybe_layer;
				}

				return $output;
			},
			10, 2
		);
	}

	public function retreive_dynamic_data_fields($args = []) {
		$args = wp_parse_args($args, [
			'prefix' => 'single_blog_post',
			'post_type' => null,
			'provider' => 'acf'
		]);

		$post_type = null;

		if ($args['prefix']) {
			$post_type = 'post';

			if ($args['prefix'] === 'product') {
				$post_type = 'product';
			}

			if ($args['prefix'] === 'single_page') {
				$post_type = 'page';
			}

			$post_types = blocksy_manager()->post_types->get_supported_post_types();

			foreach ($post_types as $single_post_type) {
				if (
					$args['prefix'] === $single_post_type . '_archive'
					||
					$args['prefix'] === $single_post_type . '_single'
				) {
					$post_type = $single_post_type;
				}
			}
		}

		if ($args['post_type']) {
			$post_type = $args['post_type'];
		}

		$result = [];

		if ($args['provider'] === 'acf') {
			if (! function_exists('acf_get_field_groups')) {
				return null;
			}

			foreach (acf_get_field_groups([
				'post_type' => $post_type
			]) as $acf_group) {
				$fields = acf_get_fields($acf_group['key']);

				foreach ($fields as $field) {
					$result[$field['name']] = $field['label'];
				}
			}
		}

		if ($args['provider'] === 'metabox') {
			if (! function_exists('rwmb_get_object_fields')) {
				return null;
			}

			foreach (array_values(rwmb_get_object_fields($post_type)) as $f) {
				$result[$f['id']] = $f['name'];
			}
		}

		if ($args['provider'] === 'toolset') {
			if (! function_exists('types_render_field')) {
				return null;
			}

			foreach (array_values(wpcf_admin_fields_get_active_fields_by_post_type(
				$post_type
			)) as $f) {
				$result[$f['id']] = $f['name'];
			}
		}

		if ($args['provider'] === 'jetengine') {
			if (! function_exists('jet_engine')) {
				return null;
			}

			foreach (jet_engine()->cpt->items as $jet_cpt) {
				if ($jet_cpt['slug'] !== $post_type) {
					continue;
				}

				if (! isset($jet_cpt['meta_fields'])) {
					continue;
				}

				foreach ($jet_cpt['meta_fields'] as $jet_field) {
					$result[$jet_field['name']] = $jet_field['title'];
				}
			}
		}

		return $result;
	}

	public function render_acf_meta($id, $meta, $args) {
		$field = $this->get_field_to_render($meta);

		if (! $field) {
			return;
		}

		$value_fallback = blocksy_akg('value_fallback', $meta, '');

		$value = $field['value'];

		$has_fallback = false;

		if (empty($value) && ! empty($value_fallback)) {
			$has_fallback = true;
			$value = $value_fallback;
		}

		if (empty(trim($value))) {
			return;
		}

		$value_after = blocksy_akg('value_after', $meta, '');
		$value_before = blocksy_akg('value_before', $meta, '');

		if (! empty($value_after) && ! $has_fallback) {
			$value .= $value_after;
		}

		if (! empty($value_before) && ! $has_fallback) {
			$value = $value_before . $value;
		}

		if ($args['meta_type'] === 'label') {
			$value = '<span>' . $field['label'] . '</span>' . $value;
		}

		if ($args['meta_type'] === 'icons' || $args['force_icons']) {
			$value = blc_get_icon([
				'icon_descriptor' => blocksy_akg('icon', $meta, [
					'icon' => 'blc blc-heart'
				]),
				'layout' => false
			]) . $value;
		}

		echo blocksy_html_tag(
			'li',
			[],
			$value
		);
	}

	public function complement_layers_option($option, $prefix, $args = []) {
		$args = wp_parse_args($args, [
			'has_icon' => false,
			'has_label_option' => true
		]);

		$option = $this->complement_option_for($option, [
			'has_icon' => $args['has_icon'],
			'has_label_option' => $args['has_label_option'],

			'provider' => 'acf',
			'provider_label' => 'ACF',

			'prefix' => $prefix
		]);

		$option = $this->complement_option_for($option, [
			'has_icon' => $args['has_icon'],
			'has_label_option' => $args['has_label_option'],

			'provider' => 'metabox',
			'provider_label' => 'MetaBox',

			'prefix' => $prefix
		]);

		$option = $this->complement_option_for($option, [
			'has_icon' => $args['has_icon'],
			'has_label_option' => $args['has_label_option'],

			'provider' => 'toolset',
			'provider_label' => 'Toolset',

			'prefix' => $prefix
		]);

		$option = $this->complement_option_for($option, [
			'has_icon' => $args['has_icon'],
			'has_label_option' => $args['has_label_option'],

			'provider' => 'jetengine',
			'provider_label' => 'Jet Engine',

			'prefix' => $prefix
		]);

		return $option;
	}

	public function complement_option_for($option, $args = []) {
		$args = wp_parse_args($args, [
			'provider' => 'acf',
			'provider_label' => 'ACF',

			'has_icon' => false,
			'has_label_option' => true,

			'prefix' => ''
		]);

		$fields = $this->retreive_dynamic_data_fields([
			'prefix' => $args['prefix'],
			'provider' => $args['provider']
		]);

		if (! $fields) {
			return $option;
		}

		$option['value'][] = [
			'id' => $args['provider'] . '_field',
			'enabled' => false
		];

		$options = [
			'text' => [
				'label' => ' ',
				'type' => 'html',
				'html' => sprintf(
					__(
						'You have no %s fields declared for this custom post type.',
						'blc'
					),
					$args['provider_label']
				)
			]
		];

		if (count($fields) > 0) {
			$options = [
				'field' => [
					'label' => __('Field', 'blc'),
					'type' => 'ct-select',
					'view' => 'text',
					'value' => array_keys($fields)[0],
					'design' => 'inline',
					'choices' => $fields,
				]
			];

			if ($args['has_label_option']) {
				$options['label'] = [
					'type' => 'ct-switch',
					'label' => __('Label', 'blc'),
					'design' => 'inline',
					'value' => 'no'
				];
			}

			if ($args['has_icon']) {
				$options[blocksy_rand_md5()] = [
					'type' => 'ct-condition',
					'condition' => [ 'meta_type' => 'icons' ],
					'values_source' => 'parent',
					'options' => [
						'icon' => [
							'type' => 'icon-picker',
							'label' => __('Icon', 'blc'),
							'design' => 'inline',
							'value' => [
								'icon' => 'blc blc-heart'
							]
						]
					],
				];
			}

			$options['value_before'] = [
				'type' => 'text',
				'label' => __('Before', 'blc'),
				'design' => 'inline',
				'value' => ''
			];

			$options['value_after'] = [
				'type' => 'text',
				'label' => __('After', 'blc'),
				'design' => 'inline',
				'value' => ''
			];

			$options['value_fallback'] = [
				'type' => 'text',
				'label' => __('Fallback', 'blc'),
				'design' => 'inline',
				'value' => ''
			];
		}

		$option['settings'][$args['provider'] . '_field'] = [
			'label' => sprintf(
				__('%s Field', 'blc'),
				$args['provider_label']
			) . ' INDEX',
			'options' => $options,
			'clone' => 5
		];

		return $option;
	}

	public function render_dynamic_field_layer($atts, $echo = true) {
		$field = $this->get_field_to_render($atts);

		if (! $field) {
			return '';
		}

		$output = $field['value'];

		$value_fallback = blocksy_akg('value_fallback', $atts, '');

		$has_fallback = false;

		if (empty($output) && ! empty($value_fallback)) {
			$has_fallback = true;
			$output = $value_fallback;
		}

		if (empty($output)) {
			return '';
		}

		$value_after = blocksy_akg('value_after', $atts, '');
		$value_before = blocksy_akg('value_before', $atts, '');

		if (! empty($value_after) && ! $has_fallback) {
			$output .= $value_after;
		}

		if (! empty($value_before) && ! $has_fallback) {
			$output = $value_before . $output;
		}

		if (blocksy_akg('label', $atts, 'no') === 'yes') {
			$output = '<span>' . $field['label'] . '</span>' . $output;
		}

		$attr = [
			'class' => 'ct-dynamic-data'
		];

		if (isset($atts['__id'])) {
			$attr['data-id'] = substr($atts['__id'], 0, 6);
		}

		$layer = blocksy_html_tag('div', $attr, $output);

		if ($echo) {
			echo $layer;
		}

		return $layer;
	}

	public function get_field_to_render($atts) {
		$provider = null;

		if ($atts['id'] === 'acf_field') {
			$provider = 'acf';
		}

		if ($atts['id'] === 'metabox_field') {
			$provider = 'metabox';
		}

		if ($atts['id'] === 'toolset_field') {
			$provider = 'toolset';
		}

		if ($atts['id'] === 'jetengine_field') {
			$provider = 'jetengine';
		}

		if (! $provider) {
			return null;
		}

		$fields = $this->retreive_dynamic_data_fields([
			'post_type' => get_post_type(),
			'provider' => $provider
		]);

		if (empty($fields)) {
			return null;
		}

		$field = array_keys($fields)[0];

		if (
			isset($atts['field'])
			&&
			$atts['field']
			&&
			isset($fields[$atts['field']])
			&&
			$fields[$atts['field']]
		) {
			$field = $atts['field'];
		}

		if ($provider === 'acf') {
			if (! function_exists('get_field_object')) {
				return null;
			}

			$field = [
				'name' => $field,
				'label' => $fields[$field]
			];

			$field_value = get_field($field['name']);

			if (! is_array($field_value)) {
				$field_value = [$field_value];
			}

			if (is_array($field_value)) {
				$field_descriptor = get_field_object($field['name']);

				$mapped_value = [];

				foreach ($field_value as $single_field) {
					if (is_object($single_field) && get_class($single_field) === 'WP_Term') {
						$mapped_value[] = blocksy_html_tag(
							'a',
							[
								'href' => get_term_link($single_field, $single_field->taxonomy)
							],
							$single_field->name
						);
					} else {
						$mapped_value[] = $single_field;
					}
				}

				$field_value = $mapped_value;

				if (
					$field_descriptor
					&&
					isset($field_descriptor['choices'])
				) {
					$mapped_value = [];

					foreach (array_values($field_value) as $single_field) {
						if (
							isset($field_descriptor['choices'][$single_field])
						) {
							$mapped_value[] = $field_descriptor[
								'choices'
							][$single_field];
						} else {
							$mapped_value[] = $single_field;
						}
					}

					$field_value = $mapped_value;
				}

				$field_value = implode(', ', array_values($field_value));
			}

			$value = apply_filters(
				'blocksy:pro:post-types-extra:acf:field-value-render',
				$field_value,
				$field['name'],
				$field
			);

			return [
				'value' => $value,
				'label' => $field['label'],
				'provider' => $provider
			];
		}

		if ($provider === 'metabox') {
			if (! function_exists('rwmb_get_field_settings')) {
				return null;
			}

			$field = rwmb_get_field_settings($field);

			if (! $field) {
				return null;
			}

			$value = apply_filters(
				'blocksy:pro:post-types-extra:metabox:field-value-render',
				rwmb_the_value($field['id'], [], null, false),
				$field['name'],
				$field
			);

			return [
				'value' => $value,
				'label' => $field['name'],
				'provider' => $provider
			];
		}

		if ($provider === 'toolset') {
			if (! function_exists('types_render_field')) {
				return null;
			}

			$all_fields = wpcf_admin_fields_get_active_fields_by_post_type(
				get_post_type()
			);

			if (isset($all_fields[$field])) {
				$field = $all_fields[$field];
			} else {
				$field = null;
			}

			if (! $field) {
				return null;
			}

			$value = apply_filters(
				'blocksy:pro:post-types-extra:toolset:field-value-render',
				types_render_field($field['id']),
				$field['name'],
				$field
			);

			return [
				'value' => $value,
				'label' => $field['name'],
				'provider' => $provider
			];
		}

		if ($provider === 'jetengine') {
			if (! function_exists('jet_engine')) {
				return null;
			}

			$post_type = get_post_type();

			$all_fields = [];

			foreach (jet_engine()->cpt->items as $jet_cpt) {
				if ($jet_cpt['slug'] !== $post_type) {
					continue;
				}

				if (! isset($jet_cpt['meta_fields'])) {
					continue;
				}

				foreach ($jet_cpt['meta_fields'] as $jet_field) {
					$all_fields[$jet_field['name']] = $jet_field;
				}
			}

			if (isset($all_fields[$field])) {
				$field = $all_fields[$field];
			} else {
				$field = null;
			}

			if (! $field) {
				return null;
			}

			$value = apply_filters(
				'blocksy:pro:post-types-extra:jetengine:field-value-render',
				get_post_meta(get_the_ID(), $field['name'], true),
				$field['title'],
				$field
			);

			return [
				'value' => $value,
				'label' => $field['name'],
				'provider' => $provider
			];
		}

		return [
			'value' => $field,
			'label' => $field,
			'provider' => $provider
		];
	}

	public function add_design_options($opts, $prefix, $key) {
		$fields = [
			[
				'id' => 'acf_field',
				'title' => 'ACF'
			],

			[
				'id' => 'metabox_field',
				'title' => 'MetaBox'
			],

			[
				'id' => 'toolset_field',
				'title' => 'Toolset'
			],

			[
				'id' => 'jetengine_field',
				'title' => 'Jet Engine'
			]
		];

		foreach ($fields as $single_field) {
			$opts[$single_field['id'] . '_' . $key] = [
				'type' => 'ct-layers-mirror',
				'layers' => $prefix . '_' . $key,
				'field' => $single_field['id'],
				'value' => '',
				'inner-options' => [
					'typography' => [
						'type' => 'ct-typography',
						'label' => sprintf(
							__('%s %s Font', 'blc'),
							$single_field['title'],
						   __('Field', 'blc') . ' INDEX'
						),
						'divider' => 'top:full',
						'sync' => 'live',
						'value' => blocksy_typography_default_values([]),
					],

					'color' => [
						'label' => sprintf(
							__('%s %s Color', 'blc'),
							$single_field['title'],
						   __('Field', 'blc') . ' INDEX'
						),
						'type'  => 'ct-color-picker',
						'design' => 'inline',
						'noColor' => [ 'background' => 'var(--color)'],
						'sync' => 'live',
						'value' => [
							'default' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],

							'hover' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],
						],

						'pickers' => [
							[
								'title' => __( 'Initial', 'blocksy' ),
								'id' => 'default',
								'inherit' => 'var(--color)'
							],

							[
								'title' => __( 'Hover', 'blocksy' ),
								'id' => 'hover',
								'inherit' => 'var(--linkHoverColor)'
							],
						],
					],
				]
			];
		}

		return $opts;
	}
}

