<?php
$options = [
	'label' => __( 'Off Canvas Filter', 'blc' ),
	'type' => 'ct-panel',
	'switch' => true,
	'value' => 'no',
	'sync' => blocksy_sync_whole_page([
		'loader_selector' => '.woo-listing-top'
	]),
	'inner-options' => [

		blocksy_rand_md5() => [
			'type' => 'ct-title',
			'label' => __( 'Filter Widgets', 'blc' ),
		],

		blocksy_rand_md5() => [
			'title' => __( 'Widgets', 'blc' ),
			'type' => 'tab',
			'options' => [

				'widget' => [
					'type' => 'ct-widget-area',
					'sidebarId' => 'sidebar-woocommerce-offcanvas-filters'
				]

			]
		],

		blocksy_rand_md5() => [
			'title' => __( 'Design', 'blc' ),
			'type' => 'tab',
			'options' => [

				'panel_widgets_spacing' => [
					'label' => __( 'Widgets Vertical Spacing', 'blc' ),
					'type' => 'ct-slider',
					'min' => 0,
					'max' => 100,
					'value' => 60,
					'responsive' => true,
					'setting' => [ 'transport' => 'postMessage' ],
				],

				blocksy_rand_md5() => [
					'type' => 'ct-divider',
				],

				'filter_panel_widgets_title_font' => [
					'type' => 'ct-typography',
					'label' => __( 'Widgets Title Font', 'blc' ),
					'value' => blocksy_typography_default_values([
						// 'size' => '18px',
					]),
					'setting' => [ 'transport' => 'postMessage' ],
				],

				'filter_panel_widgets_title_color' => [
					'label' => __( 'Widgets Title Font Color', 'blc' ),
					'type'  => 'ct-color-picker',
					'design' => 'block:right',
					'responsive' => true,
					'setting' => [ 'transport' => 'postMessage' ],

					'value' => [
						'default' => [
							'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
						],
					],

					'pickers' => [
						[
							'title' => __( 'Initial', 'blc' ),
							'id' => 'default',
							'inherit_source' => 'global',
							'inherit' => [
								'var(--heading-1-color, var(--headings-color))' => [
									'widgets_title_wrapper' => 'h1'
								],

								'var(--heading-2-color, var(--headings-color))' => [
									'widgets_title_wrapper' => 'h2'
								],

								'var(--heading-3-color, var(--headings-color))' => [
									'widgets_title_wrapper' => 'h3'
								],

								'var(--heading-4-color, var(--headings-color))' => [
									'widgets_title_wrapper' => 'h4'
								],

								'var(--heading-5-color, var(--headings-color))' => [
									'widgets_title_wrapper' => 'h5'
								],

								'var(--heading-6-color, var(--headings-color))' => [
									'widgets_title_wrapper' => 'h6'
								]
							]
						],
					],
				],

				'filter_panel_widgets_font' => [
					'type' => 'ct-typography',
					'label' => __( 'Widgets Font', 'blc' ),
					'value' => blocksy_typography_default_values([
						// 'size' => '16px',
					]),
					'divider' => 'top',
					'setting' => [ 'transport' => 'postMessage' ],
				],

				'filter_panel_widgets_font_color' => [
					'label' => __( 'Widgets Font Color', 'blc' ),
					'type'  => 'ct-color-picker',
					'design' => 'block:right',
					'responsive' => true,
					'divider' => 'bottom',
					'setting' => [ 'transport' => 'postMessage' ],
					'value' => [
						'default' => [
							'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
						],

						'link_initial' => [
							'color' => 'var(--color)',
						],

						'link_hover' => [
							'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
						],
					],

					'pickers' => [
						[
							'title' => __( 'Text Initial', 'blc' ),
							'id' => 'default',
							'inherit' => 'var(--color)'
						],

						[
							'title' => __( 'Link Initial', 'blc' ),
							'id' => 'link_initial',
						],

						[
							'title' => __( 'Link Hover', 'blc' ),
							'id' => 'link_hover',
							'inherit' => 'var(--linkHoverColor)'
						],
					],
				],
			]
		],

		blocksy_rand_md5() => [
			'type' => 'ct-title',
			'label' => __( 'Filter Button & Panel', 'blc' ),
		],

		blocksy_rand_md5() => [
			'title' => __( 'General', 'blc' ),
			'type' => 'tab',
			'options' => [

				'woocommerce_filter_type' => [
					'label' => __( 'Filter Icon Type', 'blc' ),
					'type' => 'ct-image-picker',
					'value' => 'type-1',
					'attr' => [
						'data-type' => 'background',
						'data-columns' => '4',
					],
					'sync' => [
						'selector' => '[href*="woo-filters-panel"]',
						'render' => function () {
							echo blc_get_woo_offcanvas_trigger();
						}
					],
					'choices' => [

						'type-1' => [
							'src'   => blocksy_image_picker_file( 'filter-1' ),
							'title' => __( 'Type 1', 'blc' ),
						],

						'type-2' => [
							'src'   => blocksy_image_picker_file( 'filter-2' ),
							'title' => __( 'Type 2', 'blc' ),
						],

						'type-3' => [
							'src'   => blocksy_image_picker_file( 'filter-3' ),
							'title' => __( 'Type 3', 'blc' ),
						],

						'type-4' => [
							'src'   => blocksy_image_picker_file( 'filter-4' ),
							'title' => __( 'Type 4', 'blc' ),
						],
					],
				],

				'woocommerce_filter_visibility' => [
					'label' => __( 'Filter Button Visibility', 'blc' ),
					'type' => 'ct-visibility',
					'design' => 'block',
					'divider' => 'top',
					'setting' => [ 'transport' => 'postMessage' ],
					'value' => [
						'desktop' => true,
						'tablet' => true,
						'mobile' => true,
					],

					'choices' => blocksy_ordered_keys([
						'desktop' => __( 'Desktop', 'blc' ),
						'tablet' => __( 'Tablet', 'blc' ),
						'mobile' => __( 'Mobile', 'blc' ),
					]),
				],

				blocksy_rand_md5() => [
					'type' => 'ct-divider',
				],

				'filter_panel_position' => [
					'label' => __('Panel Reveal', 'blc'),
					'type' => 'ct-radio',
					'value' => 'right',
					'view' => 'text',
					'design' => 'block',
					'setting' => [ 'transport' => 'postMessage' ],
					'choices' => [
						'left' => __( 'Left Side', 'blc' ),
						'right' => __( 'Right Side', 'blc' ),
					],
				],

				'filter_panel_width' => [
					'label' => __( 'Panel Width', 'blc' ),
					'type' => 'ct-slider',
					'value' => [
						'desktop' => '500px',
						'tablet' => '65vw',
						'mobile' => '90vw',
					],
					'units' => blocksy_units_config([
						[ 'unit' => 'px', 'min' => 0, 'max' => 1000 ],
					]),
					'divider' => 'top',
					'responsive' => true,
					'setting' => [ 'transport' => 'postMessage' ],
				],

				'filter_panel_content_vertical_alignment' => [
					'type' => 'ct-radio',
					'label' => __( 'Vertical Alignment', 'blc' ),
					'view' => 'text',
					'design' => 'block',
					'divider' => 'top',
					'responsive' => true,
					'attr' => [ 'data-type' => 'vertical-alignment' ],
					'setting' => [ 'transport' => 'postMessage' ],
					'value' => 'flex-start',
					'choices' => [
						'flex-start' => '',
						'center' => '',
						'flex-end' => '',
					],
				],

			],
		],

		blocksy_rand_md5() => [
			'title' => __( 'Design', 'blc' ),
			'type' => 'tab',
			'options' => [

				'filter_panel_shadow' => [
					'label' => __( 'Panel Shadow', 'blc' ),
					'type' => 'ct-box-shadow',
					'design' => 'block',
					'responsive' => true,
					'value' => blocksy_box_shadow_value([
						'enable' => true,
						'h_offset' => 0,
						'v_offset' => 0,
						'blur' => 70,
						'spread' => 0,
						'inset' => false,
						'color' => [
							'color' => 'rgba(0, 0, 0, 0.35)',
						],
					])
				],

				'filter_panel_background' => [
					'label' => __( 'Panel Background', 'blc' ),
					'type'  => 'ct-background',
					'design' => 'block:right',
					'responsive' => true,
					'divider' => 'top',
					'setting' => [ 'transport' => 'postMessage' ],
					'value' => blocksy_background_default_value([
						'backgroundColor' => [
							'default' => [
								'color' => '#ffffff'
							],
						],
					])
				],

				'filter_panel_backgrop' => [
					'label' => __( 'Panel Backdrop', 'blocksy' ),
					'type'  => 'ct-background',
					'design' => 'block:right',
					'responsive' => true,
					'divider' => 'top',
					'setting' => [ 'transport' => 'postMessage' ],
					'value' => blocksy_background_default_value([
						'backgroundColor' => [
							'default' => [
								'color' => 'rgba(18, 21, 25, 0.6)'
							],
						],
					])
				],

				'filter_panel_close_button_color' => [
					'label' => __( 'Close Icon Color', 'blc' ),
					'type'  => 'ct-color-picker',
					'design' => 'inline',
					'divider' => 'top',
					'setting' => [ 'transport' => 'postMessage' ],

					'value' => [
						'default' => [
							'color' => 'rgba(0, 0, 0, 0.5)',
						],

						'hover' => [
							'color' => 'rgba(0, 0, 0, 0.8)',
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
						],
					],
				],

				'filter_panel_close_button_shape_color' => [
					'label' => __( 'Close Icon Background', 'blc' ),
					'type'  => 'ct-color-picker',
					'design' => 'inline',
					'setting' => [ 'transport' => 'postMessage' ],

					'value' => [
						'default' => [
							'color' => 'rgba(0, 0, 0, 0)',
						],

						'hover' => [
							'color' => 'rgba(0, 0, 0, 0)',
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
						],
					],
				],

			],
		],

	],
];
