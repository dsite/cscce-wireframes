<?php

$taxonomies = array_values(array_diff(
	get_object_taxonomies($post_type),
	['post_format']
));

$taxonomies_choices = [];

foreach ($taxonomies as $taxonomy) {
	$taxonomy_object = get_taxonomy($taxonomy);

	if (! $taxonomy_object) {
		continue;
	}

	if (! $taxonomy_object->public) {
		continue;
	}

	$taxonomies_choices[$taxonomy] = $taxonomy_object->label;
}

$options = [
	'label' => __('Posts Filter', 'blc'),
	'type' => 'ct-panel',
	'switch' => true,
	'value' => 'no',
	'sync' => blocksy_sync_whole_page([
		'prefix' => $prefix,
	]),
	'inner-options' => [

		blocksy_rand_md5() => [
			'title' => __( 'General', 'blc' ),
			'type' => 'tab',
			'options' => [
				[
					$prefix . '_filter_type' => [
						'label' => false,
						'type' => 'ct-image-picker',
						'value' => 'simple',
						'setting' => [ 'transport' => 'postMessage' ],
						'choices' => [

							'simple' => [
								'src' => blocksy_image_picker_url( 'filter-type-1.svg' ),
								'title' => __( 'Type 1', 'blc' ),
							],

							'buttons' => [
								'src' => blocksy_image_picker_url( 'filter-type-2.svg' ),
								'title' => __( 'Type 2', 'blc' ),
							],

						],
					],

					$prefix . '_filter_behavior' => [
						'label' => __( 'Filtering Behavior', 'blc' ),
						'type' => 'ct-select',
						'value' => 'ajax',
						'view' => 'text',
						'design' => 'inline',
						'divider' => 'top',
						'choices' => blocksy_ordered_keys(
							[
								'ajax' => __( 'Instant Reload', 'blc' ),
								'reload' => __( 'Page Reload', 'blc' ),
							]
						),
					],
				],

				count($taxonomies_choices) <= 1 ? [
					$prefix . '_filter_source' => [
						'type' => 'hidden',
						'value' => blocksy_maybe_get_matching_taxonomy($post_type),
					],
				] : [
					$prefix . '_filter_source' => [
						'label' => __('Filter Source', 'blc'),
						'type' => 'ct-select',
						'value' => blocksy_maybe_get_matching_taxonomy($post_type),
						'divider' => 'top',
						'design' => 'inline',
						'choices' => blocksy_ordered_keys($taxonomies_choices)
					],
				],

				$prefix . '_filter_items_horizontal_spacing' => [
					'label' => __( 'Items Horizontal Spacing', 'blc' ),
					'type' => 'ct-slider',
					'value' => 30,
					'min' => 0,
					'max' => 100,
					'defaultUnit' => 'px',
					'responsive' => true,
					'divider' => 'top',
					'setting' => [ 'transport' => 'postMessage' ],
				],

				$prefix . '_filter_items_vertical_spacing' => [
					'label' => __( 'Items Vertical Spacing', 'blc' ),
					'type' => 'ct-slider',
					'value' => 10,
					'min' => 0,
					'max' => 100,
					'defaultUnit' => 'px',
					'responsive' => true,
					'divider' => 'top',
					'setting' => [ 'transport' => 'postMessage' ],
				],

				$prefix . '_filter_container_spacing' => [
					'label' => __( 'Container Bottom Spacing', 'blc' ),
					'type' => 'ct-slider',
					'value' => 40,
					'min' => 0,
					'max' => 300,
					'responsive' => true,
					'divider' => 'top',
					'setting' => [ 'transport' => 'postMessage' ],
				],

				$prefix . '_horizontal_alignment' => [
					'type' => 'ct-radio',
					'label' => __( 'Horizontal Alignment', 'blc' ),
					'view' => 'text',
					'design' => 'block',
					'responsive' => true,
					'divider' => 'top',
					'attr' => [ 'data-type' => 'alignment' ],
					'setting' => [ 'transport' => 'postMessage' ],
					'value' => 'center',
					'choices' => [
						'left' => '',
						'center' => '',
						'right' => '',
					],
				],

				$prefix . '_filter_visibility' => [
					'label' => __( 'Visibility', 'blc' ),
					'type' => 'ct-visibility',
					'design' => 'block',
					'divider' => 'top',
					'setting' => [ 'transport' => 'postMessage' ],

					'value' => [
						'desktop' => true,
						'tablet' => true,
						'mobile' => false,
					],

					'choices' => blocksy_ordered_keys([
						'desktop' => __( 'Desktop', 'blc' ),
						'tablet' => __( 'Tablet', 'blc' ),
						'mobile' => __( 'Mobile', 'blc' ),
					]),
				],

			],
		],

		blocksy_rand_md5() => [
			'title' => __( 'Design', 'blc' ),
			'type' => 'tab',
			'options' => [

				$prefix . '_filter_font' => [
					'type' => 'ct-typography',
					'label' => __( 'Font', 'blc' ),
					'value' => blocksy_typography_default_values([
						'size' => '12px',
						'variation' => 'n6',
						'text-transform' => 'uppercase',
					]),
					'design' => 'block',
					'sync' => 'live'
				],

				$prefix . '_filter_font_color' => [
					'label' => __( 'Font Color', 'blc' ),
					'type'  => 'ct-color-picker',
					'design' => 'inline',
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
							'title' => __( 'Initial', 'blc' ),
							'id' => 'default',
							'inherit' => 'var(--color)'
						],

						[
							'title' => __( 'Hover/Active', 'blc' ),
							'id' => 'hover',
							'inherit' => 'var(--linkHoverColor)'
						],
					],
				],

				blocksy_rand_md5() => [
					'type' => 'ct-condition',
					'condition' => [ $prefix . '_filter_type' => 'buttons' ],
					'options' => [

						$prefix . '_filter_button_color' => [
							'label' => __( 'Button Color', 'blc' ),
							'type'  => 'ct-color-picker',
							'design' => 'inline',
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
									'title' => __( 'Initial', 'blc' ),
									'id' => 'default',
									'inherit' => 'var(--buttonInitialColor)'
								],

								[
									'title' => __( 'Hover/Active', 'blc' ),
									'id' => 'hover',
									'inherit' => 'var(--buttonHoverColor)'
								],
							],
						],

						$prefix . '_filter_button_padding' => [
							'label' => __( 'Button Padding', 'blc' ),
							'type' => 'ct-spacing',
							'divider' => 'top',
							'value' => blocksy_spacing_value([
								'linked' => true,
								// 'top' => '8px',
								// 'left' => '15px',
								// 'right' => '15px',
								// 'bottom' => '8px',
							]),
							'responsive' => true,
							'sync' => 'live',
						],

						$prefix . '_filter_button_border_radius' => [
							'label' => __( 'Border Radius', 'blc' ),
							'type' => 'ct-spacing',
							'divider' => 'top',
							'setting' => [ 'transport' => 'postMessage' ],
							'value' => blocksy_spacing_value([
								'linked' => true,
								'top' => '3px',
								'left' => '3px',
								'right' => '3px',
								'bottom' => '3px',
							]),
							'responsive' => true
						],

					],
				],

			],
		],
	],

];

