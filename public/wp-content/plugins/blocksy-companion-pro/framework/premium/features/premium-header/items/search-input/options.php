<?php

$cpt_choices = [
	'post' => __('Posts', 'blc'),
	'page' => __('Pages', 'blc'),
	'product' => __('Products', 'blc')
];

$cpt_options = [
	'post' => true,
	'page' => true,
	'product' => true
];

$all_cpts = blocksy_manager()->post_types->get_supported_post_types();

if (function_exists('is_bbpress')) {
	$all_cpts[] = 'forum';
	$all_cpts[] = 'topic';
	$all_cpts[] = 'reply';
}

foreach ($all_cpts as $single_cpt) {
	if (get_post_type_object($single_cpt)) {
		$cpt_choices[$single_cpt] = get_post_type_labels(
			get_post_type_object($single_cpt)
		)->singular_name;
	} else {
		$cpt_choices[$single_cpt] = ucfirst($single_cpt);
	}

	$cpt_options[$single_cpt] = true;
}

$options = [
	blocksy_rand_md5() => [
		'title' => __( 'General', 'blc' ),
		'type' => 'tab',
		'options' => array_merge([

			'search_box_placeholder' => [
				'label' => __( 'Placeholder Text', 'blc' ),
				'type' => 'text',
				'design' => 'block',
				'value' => __( 'Search', 'blc' ),
				'setting' => [
					'transport' => 'postMessage'
				],
			],

			'searchBoxMaxWidth' => [
				'label' => __( 'Input Maximum Width', 'blc' ),
				'type' => 'ct-slider',
				'min' => 10,
				'max' => 100,
				'value' => 50,
				'responsive' => true,
				'divider' => 'top',
				'defaultUnit' => '%',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'headerSearchBoxHeight' => [
				'label' => __( 'Input Height', 'blc' ),
				'type' => 'ct-slider',
				'min' => 20,
				'max' => 80,
				'value' => 40,
				'responsive' => true,
				'divider' => 'top',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
			],

			'enable_live_results' => [
				'label' => __( 'Live Results', 'blc' ),
				'type' => 'ct-switch',
				'value' => 'no',
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'enable_live_results' => 'yes' ],
				'options' => [

					'live_results_images' => [
						'label' => __( 'Live Results Images', 'blc' ),
						'type' => 'ct-switch',
						'value' => 'yes',
						'divider' => 'top',
					],

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-title',
				'label' => __('Search Through Criteria', 'blc'),
				'desc' => __(
					'Chose in which post types do you want to perform searches.',
					'blc'
				)
			],

			'search_through' => [
				'label' => false,
				'type' => 'ct-checkboxes',
				'attr' => ['data-columns' => '2'],
				'disableRevertButton' => true,
				'choices' => blocksy_ordered_keys($cpt_choices),
				'value' => $cpt_options
			],

		], $panel_type === 'footer' ? [

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
			],

			'footer_search_box_horizontal_alignment' => [
				'type' => 'ct-radio',
				'label' => __( 'Horizontal Alignment', 'blocksy' ),
				'view' => 'text',
				'design' => 'block',
				'responsive' => true,
				'attr' => [ 'data-type' => 'alignment' ],
				'setting' => [ 'transport' => 'postMessage' ],
				'value' => 'CT_CSS_SKIP_RULE',
				'choices' => [
					'flex-start' => '',
					'center' => '',
					'flex-end' => '',
				],
			],

			'footer_search_box_vertical_alignment' => [
				'type' => 'ct-radio',
				'label' => __( 'Vertical Alignment', 'blocksy' ),
				'view' => 'text',
				'design' => 'block',
				'divider' => 'top',
				'responsive' => true,
				'attr' => [ 'data-type' => 'vertical-alignment' ],
				'setting' => [ 'transport' => 'postMessage' ],
				'value' => 'CT_CSS_SKIP_RULE',
				'choices' => [
					'flex-start' => '',
					'center' => '',
					'flex-end' => '',
				],
			],

			'footer_visibility' => [
				'label' => __('Element Visibility', 'blc'),
				'type' => 'ct-visibility',
				'design' => 'block',
				'divider' => 'top',
				'sync' => 'live',
				'value' => [
					'desktop' => true,
					'tablet' => true,
					'mobile' => true,
				],
				'choices' => blocksy_ordered_keys([
					'desktop' => __( 'Desktop', 'blocksy' ),
					'tablet' => __( 'Tablet', 'blocksy' ),
					'mobile' => __( 'Mobile', 'blocksy' ),
				]),
			],

		] : []),
	],

	blocksy_rand_md5() => [
		'title' => __( 'Design', 'blc' ),
		'type' => 'tab',
		'options' => [

			blocksy_rand_md5() => [
				'type' => 'ct-labeled-group',
				'label' => __( 'Input Font Color', 'blc' ),
				'responsive' => true,
				'choices' => [
					[
						'id' => 'sb_font_color',
						'label' => __('Default State', 'blc')
					],

					[
						'id' => 'transparent_sb_font_color',
						'label' => __('Transparent State', 'blc'),
						'condition' => [
							'row' => '!offcanvas',
							'builderSettings/has_transparent_header' => 'yes',
						],
					],

					[
						'id' => 'sticky_sb_font_color',
						'label' => __('Sticky State', 'blc'),
						'condition' => [
							'row' => '!offcanvas',
							'builderSettings/has_sticky_header' => 'yes',
						],
					],
				],
				'options' => [

					'sb_font_color' => [
						'label' => __( 'Input Font Color', 'blc' ),
						'type'  => 'ct-color-picker',
						'design' => 'block:right',
						'responsive' => true,
						'setting' => [ 'transport' => 'postMessage' ],

						'value' => [
							'default' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],

							'focus' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],
						],

						'pickers' => [
							[
								'title' => __( 'Initial', 'blc' ),
								'id' => 'default',
								'inherit' => 'var(--form-text-initial-color, var(--color))'
							],

							[
								'title' => __( 'Focus', 'blc' ),
								'id' => 'focus',
								'inherit' => 'var(--form-text-focus-color, var(--color))'
							],
						],
					],

					'transparent_sb_font_color' => [
						'label' => __( 'Input Font Color', 'blc' ),
						'type'  => 'ct-color-picker',
						'design' => 'block:right',
						'responsive' => true,
						'setting' => [ 'transport' => 'postMessage' ],

						'value' => [
							'default' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],

							'focus' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],
						],

						'pickers' => [
							[
								'title' => __( 'Initial', 'blc' ),
								'id' => 'default',
							],

							[
								'title' => __( 'Focus', 'blc' ),
								'id' => 'focus',
							],
						],
					],

					'sticky_sb_font_color' => [
						'label' => __( 'Input Font Color', 'blc' ),
						'type'  => 'ct-color-picker',
						'design' => 'block:right',
						'responsive' => true,
						'setting' => [ 'transport' => 'postMessage' ],

						'value' => [
							'default' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],

							'focus' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],
						],

						'pickers' => [
							[
								'title' => __( 'Initial', 'blc' ),
								'id' => 'default',
							],

							[
								'title' => __( 'Focus', 'blc' ),
								'id' => 'focus',
							],
						],
					],

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
				'attr' => [ 'data-type' => 'small' ],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-labeled-group',
				'label' => __( 'Input Icon Color', 'blc' ),
				'responsive' => true,
				'choices' => [
					[
						'id' => 'sb_icon_color',
						'label' => __('Default State', 'blc')
					],

					[
						'id' => 'transparent_sb_icon_color',
						'label' => __('Transparent State', 'blc'),
						'condition' => [
							'row' => '!offcanvas',
							'builderSettings/has_transparent_header' => 'yes',
						],
					],

					[
						'id' => 'sticky_sb_icon_color',
						'label' => __('Sticky State', 'blc'),
						'condition' => [
							'row' => '!offcanvas',
							'builderSettings/has_sticky_header' => 'yes',
						],
					],
				],
				'options' => [

					'sb_icon_color' => [
						'label' => __( 'Input Icon Color', 'blc' ),
						'type'  => 'ct-color-picker',
						'design' => 'block:right',
						'responsive' => true,
						'setting' => [ 'transport' => 'postMessage' ],

						'value' => [
							'default' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],

							'focus' => [
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
								'title' => __( 'Focus', 'blc' ),
								'id' => 'focus',
								'inherit' => 'var(--color)'
							],
						],
					],

					'transparent_sb_icon_color' => [
						'label' => __( 'Input Icon Color', 'blc' ),
						'type'  => 'ct-color-picker',
						'design' => 'block:right',
						'responsive' => true,
						'setting' => [ 'transport' => 'postMessage' ],

						'value' => [
							'default' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],

							'focus' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],
						],

						'pickers' => [
							[
								'title' => __( 'Initial', 'blc' ),
								'id' => 'default',
							],

							[
								'title' => __( 'Focus', 'blc' ),
								'id' => 'focus',
							],
						],
					],

					'sticky_sb_icon_color' => [
						'label' => __( 'Input Icon Color', 'blc' ),
						'type'  => 'ct-color-picker',
						'design' => 'block:right',
						'responsive' => true,
						'setting' => [ 'transport' => 'postMessage' ],

						'value' => [
							'default' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],

							'focus' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],
						],

						'pickers' => [
							[
								'title' => __( 'Initial', 'blc' ),
								'id' => 'default',
							],

							[
								'title' => __( 'Focus', 'blc' ),
								'id' => 'focus',
							],
						],
					],

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
				'attr' => [ 'data-type' => 'small' ],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-labeled-group',
				'label' => __( 'Input Border Color', 'blc' ),
				'responsive' => true,
				'choices' => [
					[
						'id' => 'sb_border_color',
						'label' => __('Default State', 'blc')
					],

					[
						'id' => 'transparent_sb_border_color',
						'label' => __('Transparent State', 'blc'),
						'condition' => [
							'row' => '!offcanvas',
							'builderSettings/has_transparent_header' => 'yes',
						],
					],

					[
						'id' => 'sticky_sb_border_color',
						'label' => __('Sticky State', 'blc'),
						'condition' => [
							'row' => '!offcanvas',
							'builderSettings/has_sticky_header' => 'yes',
						],
					],
				],
				'options' => [

					'sb_border_color' => [
						'label' => __( 'Input Border Color', 'blc' ),
						'type'  => 'ct-color-picker',
						'design' => 'block:right',
						'responsive' => true,
						'setting' => [ 'transport' => 'postMessage' ],

						'value' => [
							'default' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],

							'focus' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],
						],

						'pickers' => [
							[
								'title' => __( 'Initial', 'blc' ),
								'id' => 'default',
								'inherit' => 'var(--form-field-border-initial-color)'
							],

							[
								'title' => __( 'Focus', 'blc' ),
								'id' => 'focus',
								'inherit' => 'var(--form-field-border-focus-color)'
							],
						],
					],

					'transparent_sb_border_color' => [
						'label' => __( 'Input Border Color', 'blc' ),
						'type'  => 'ct-color-picker',
						'design' => 'block:right',
						'responsive' => true,
						'setting' => [ 'transport' => 'postMessage' ],

						'value' => [
							'default' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],

							'focus' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],
						],

						'pickers' => [
							[
								'title' => __( 'Initial', 'blc' ),
								'id' => 'default',
							],

							[
								'title' => __( 'Focus', 'blc' ),
								'id' => 'focus',
							],
						],
					],

					'sticky_sb_border_color' => [
						'label' => __( 'Input Border Color', 'blc' ),
						'type'  => 'ct-color-picker',
						'design' => 'block:right',
						'responsive' => true,
						'setting' => [ 'transport' => 'postMessage' ],

						'value' => [
							'default' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],

							'focus' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],
						],

						'pickers' => [
							[
								'title' => __( 'Initial', 'blc' ),
								'id' => 'default',
							],

							[
								'title' => __( 'Focus', 'blc' ),
								'id' => 'focus',
							],
						],
					],

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => ['forms_type' => 'classic-forms'],
				'values_source' => 'global',
				'options' => [

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
						'attr' => [ 'data-type' => 'small' ],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-labeled-group',
						'label' => __( 'Input Background Color', 'blc' ),
						'responsive' => true,
						'choices' => [
							[
								'id' => 'sb_background',
								'label' => __('Default State', 'blc'),
							],

							[
								'id' => 'transparent_sb_background',
								'label' => __('Transparent State', 'blc'),
								'condition' => [
									'row' => '!offcanvas',
									'builderSettings/has_transparent_header' => 'yes',
								],
							],

							[
								'id' => 'sticky_sb_background',
								'label' => __('Sticky State', 'blc'),
								'condition' => [
									'row' => '!offcanvas',
									'builderSettings/has_sticky_header' => 'yes',
								],
							],
						],
						'options' => [
							'sb_background' => [
								'label' => __( 'Input Background Color', 'blc' ),
								'type'  => 'ct-color-picker',
								'design' => 'block:right',
								'responsive' => true,
								'setting' => [ 'transport' => 'postMessage' ],

								'value' => [
									'default' => [
										'color' => Blocksy_Css_Injector::get_skip_rule_keyword(),
									],

									'focus' => [
										'color' => Blocksy_Css_Injector::get_skip_rule_keyword(),
									],
								],

								'pickers' => [
									[
										'title' => __( 'Initial', 'blc' ),
										'id' => 'default',
									],

									[
										'title' => __( 'Focus', 'blc' ),
										'id' => 'focus',
									],
								],
							],

							'transparent_sb_background' => [
								'label' => __( 'Input Background Color', 'blc' ),
								'type'  => 'ct-color-picker',
								'design' => 'block:right',
								'responsive' => true,
								'setting' => [ 'transport' => 'postMessage' ],

								'value' => [
									'default' => [
										'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
									],

									'focus' => [
										'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
									],
								],

								'pickers' => [
									[
										'title' => __( 'Initial', 'blc' ),
										'id' => 'default',
									],

									[
										'title' => __( 'Focus', 'blc' ),
										'id' => 'focus',
									],
								],
							],

							'sticky_sb_background' => [
								'label' => __( 'Input Background Color', 'blc' ),
								'type'  => 'ct-color-picker',
								'design' => 'block:right',
								'responsive' => true,
								'setting' => [ 'transport' => 'postMessage' ],

								'value' => [
									'default' => [
										'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
									],

									'focus' => [
										'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
									],
								],

								'pickers' => [
									[
										'title' => __( 'Initial', 'blc' ),
										'id' => 'default',
									],

									[
										'title' => __( 'Focus', 'blc' ),
										'id' => 'focus',
									],
								],
							],

						],
					],
				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => ['forms_type' => 'classic-forms'],
				'values_source' => 'global',
				'options' => [

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
					],

					'sb_radius' => [
						'label' => __( 'Input Border Radius', 'blocksy' ),
						'type' => 'ct-spacing',
						'value' => blocksy_spacing_value([
							'linked' => true,
						]),
						'responsive' => true
					],
				],
			],

			'sb_margin' => [
				'label' => __( 'Margin', 'blc' ),
				'type' => 'ct-spacing',
				'divider' => 'top',
				'value' => blocksy_spacing_value([
					'linked' => true,
				]),
				'responsive' => true
			],


			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'enable_live_results' => 'yes' ],
				'options' => [

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
					],

					'sb_dropdown_text' => [
						'label' => __( 'Dropdown Text Color', 'blc' ),
						'type'  => 'ct-color-picker',
						'design' => 'block:right',
						'responsive' => true,
						'setting' => [ 'transport' => 'postMessage' ],

						'value' => [
							'default' => [
								'color' => 'var(--color)',
							],

							'hover' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],
						],

						'pickers' => [
							[
								'title' => __( 'Initial', 'blc' ),
								'id' => 'default',
							],

							[
								'title' => __( 'Hover', 'blc' ),
								'id' => 'hover',
								'inherit' => 'var(--linkHoverColor)'
							],
						],
					],

					'sb_dropdown_background' => [
						'label' => __( 'Dropdown Background', 'blc' ),
						'type'  => 'ct-color-picker',
						'design' => 'block:right',
						'divider' => 'top',
						'responsive' => true,
						'setting' => [ 'transport' => 'postMessage' ],

						'value' => [
							'default' => [
								'color' => '#ffffff',
							],
						],

						'pickers' => [
							[
								'title' => __( 'Initial', 'blc' ),
								'id' => 'default',
							],
						],
					],

					'sb_dropdown_shadow' => [
						'label' => __( 'Dropdown Shadow', 'blc' ),
						'type' => 'ct-box-shadow',
						'divider' => 'top',
						'responsive' => true,
						'value' => blocksy_box_shadow_value([
							'enable' => true,
							'h_offset' => 0,
							'v_offset' => 50,
							'blur' => 70,
							'spread' => 0,
							'inset' => false,
							'color' => [
								'color' => 'rgba(210, 213, 218, 0.4)',
							],
						])
					],

					'sb_dropdown_divider' => [
						'label' => __( 'Items Divider', 'blc' ),
						'type' => 'ct-border',
						'design' => 'inline',
						'divider' => 'top',
						'value' => [
							'width' => 1,
							'style' => 'dashed',
							'color' => [
								'color' => 'rgba(0, 0, 0, 0.05)',
							],
						]
					],

				],
			],

		],
	],
];

if ($panel_type === 'header') {
	$options[blocksy_rand_md5()] = [
		'type' => 'ct-condition',
		'condition' => [
			'wp_customizer_current_view' => 'tablet|mobile'
		],
		'options' => [
			blocksy_rand_md5() => [
				'type' => 'ct-divider',
			],

			'visibility' => [
				'label' => __( 'Element Visibility', 'blocksy' ),
				'type' => 'ct-visibility',
				'design' => 'block',
				'setting' => [ 'transport' => 'postMessage' ],
				'allow_empty' => true,
				'value' => [
					'tablet' => true,
					'mobile' => true,
				],

				'choices' => blocksy_ordered_keys([
					'tablet' => __( 'Tablet', 'blocksy' ),
					'mobile' => __( 'Mobile', 'blocksy' ),
				]),
			],

		],
	];
}
