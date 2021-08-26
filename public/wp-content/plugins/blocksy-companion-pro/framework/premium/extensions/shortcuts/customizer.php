<?php

$initial_conditions = [
	[
		'type' => 'include',
		'rule' => 'everywhere'
	]
];

$layer_settings = [
	'home' => [
		'label' => __('Home', 'blc'),
		'options' => [
			'icon' => [
				'type' => 'icon-picker',
				'design' => 'inline',
				'value' => [
					'icon' => 'blc blc-home'
				]
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [
					'any' => [
						'shortcuts_label_visibility/desktop' => true,
						'shortcuts_label_visibility/tablet' => true,
						'shortcuts_label_visibility/mobile' => true,
					]
				],
				'values_source' => 'parent',
				'options' => [
					'label' => [
						'type' => 'text',
						'value' => __('Home', 'blc'),
						'design' => 'inline',
					],
				],
			],

			'item_visibility' => [
				'label' => __( 'Visibility', 'blc' ),
				'type' => 'ct-visibility',
				'design' => 'block',
				'sync' => 'live',

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
		]
	],

	'phone' => [
		'label' => __('Phone', 'blc'),
		'options' => [
			'icon' => [
				'type' => 'icon-picker',
				'design' => 'inline',
				'value' => [
					'icon' => 'blc blc-phone'
				]
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [
					'any' => [
						'shortcuts_label_visibility/desktop' => true,
						'shortcuts_label_visibility/tablet' => true,
						'shortcuts_label_visibility/mobile' => true,
					]
				],
				'values_source' => 'parent',
				'options' => [
					'label' => [
						'type' => 'text',
						'value' => __('Phone', 'blc'),
						'design' => 'inline',
					],
				],
			],

			'phone_number' => [
				'type' => 'text',
				'value' => '#',
				'design' => 'inline',
			],

			'item_visibility' => [
				'label' => __( 'Visibility', 'blc' ),
				'type' => 'ct-visibility',
				'design' => 'block',
				'sync' => 'live',

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
		]
	],

	'email' => [
		'label' => __('Email', 'blc'),
		'options' => [
			'icon' => [
				'type' => 'icon-picker',
				'design' => 'inline',
				'value' => [
					'icon' => 'blc blc-email'
				]
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [
					'any' => [
						'shortcuts_label_visibility/desktop' => true,
						'shortcuts_label_visibility/tablet' => true,
						'shortcuts_label_visibility/mobile' => true,
					]
				],
				'values_source' => 'parent',
				'options' => [
					'label' => [
						'type' => 'text',
						'value' => __('Email', 'blc'),
						'design' => 'inline',
					],
				],
			],

			'email' => [
				'type' => 'text',
				'value' => '#',
				'design' => 'inline',
			],

			'item_visibility' => [
				'label' => __( 'Visibility', 'blc' ),
				'type' => 'ct-visibility',
				'design' => 'block',
				'sync' => 'live',

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
		]
	],

	'scroll_top' => [
		'label' => __('Scroll Top', 'blc'),
		'options' => [
			'icon' => [
				'type' => 'icon-picker',
				'design' => 'inline',
				'value' => [
					'icon' => 'blc blc-arrow-up-circle'
				]
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [
					'any' => [
						'shortcuts_label_visibility/desktop' => true,
						'shortcuts_label_visibility/tablet' => true,
						'shortcuts_label_visibility/mobile' => true,
					]
				],
				'values_source' => 'parent',
				'options' => [
					'label' => [
						'type' => 'text',
						'value' => __('Scroll Top', 'blc'),
						'design' => 'inline',
					],
				],
			],

			'item_visibility' => [
				'label' => __( 'Visibility', 'blc' ),
				'type' => 'ct-visibility',
				'design' => 'block',
				'sync' => 'live',

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
		]
	],

	'custom_link' => [
		'label' => sprintf(
			'<%%= label || "%s" %%>',
			__('Custom', 'blc')
		),

		'clone' => 4,
		'options' => [
			'icon' => [
				'type' => 'icon-picker',
				'design' => 'inline',
				'value' => [
					'icon' => 'far fa-smile'
				]
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [
					'any' => [
						'shortcuts_label_visibility/desktop' => true,
						'shortcuts_label_visibility/tablet' => true,
						'shortcuts_label_visibility/mobile' => true,
					]
				],
				'values_source' => 'parent',
				'options' => [
					'label' => [
						'type' => 'text',
						'value' => __('Custom', 'blc'),
						'design' => 'inline',
					],
				],
			],

			'link' => [
				'type' => 'text',
				'value' => '#',
				'design' => 'inline',
			],

			'item_visibility' => [
				'label' => __( 'Visibility', 'blc' ),
				'type' => 'ct-visibility',
				'design' => 'block',
				'sync' => 'live',

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
		]
	]
];

if (class_exists('WooCommerce')) {
	$layer_settings['cart'] = [
		'label' => __('Cart', 'blc'),
		'options' => [
			'icon' => [
				'type' => 'icon-picker',
				'design' => 'inline',
				'value' => [
					'icon' => 'blc blc-cart'
				]
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [
					'any' => [
						'shortcuts_label_visibility/desktop' => true,
						'shortcuts_label_visibility/tablet' => true,
						'shortcuts_label_visibility/mobile' => true,
					]
				],
				'values_source' => 'parent',
				'options' => [
					'label' => [
						'type' => 'text',
						'value' => __('Cart', 'blc'),
						'design' => 'inline',
					],
				],
			],

			'item_visibility' => [
				'label' => __( 'Visibility', 'blc' ),
				'type' => 'ct-visibility',
				'design' => 'block',
				'sync' => 'live',

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
		]
	];

	$layer_settings['shop'] = [
		'label' => __('Shop', 'blc'),
		'options' => [
			'icon' => [
				'type' => 'icon-picker',
				'design' => 'inline',
				'value' => [
					'icon' => 'blc blc-shop'
				]
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [
					'any' => [
						'shortcuts_label_visibility/desktop' => true,
						'shortcuts_label_visibility/tablet' => true,
						'shortcuts_label_visibility/mobile' => true,
					]
				],
				'values_source' => 'parent',
				'options' => [
					'label' => [
						'type' => 'text',
						'value' => __('Shop', 'blc'),
						'design' => 'inline',
					],
				],
			],

			'item_visibility' => [
				'label' => __( 'Visibility', 'blc' ),
				'type' => 'ct-visibility',
				'design' => 'block',
				'sync' => 'live',

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
		]
	];

	$layer_settings['wishlist'] = [
		'label' => __('Wishlist', 'blc'),
		'options' => [
			'icon' => [
				'type' => 'icon-picker',
				'design' => 'inline',
				'value' => [
					'icon' => 'blc blc-heart'
				]
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [
					'any' => [
						'shortcuts_label_visibility/desktop' => true,
						'shortcuts_label_visibility/tablet' => true,
						'shortcuts_label_visibility/mobile' => true,
					]
				],
				'values_source' => 'parent',
				'options' => [
					'label' => [
						'type' => 'text',
						'value' => __('Wishlist', 'blc'),
						'design' => 'inline',
					],
				],
			],

			'item_visibility' => [
				'label' => __( 'Visibility', 'blc' ),
				'type' => 'ct-visibility',
				'design' => 'block',
				'sync' => 'live',

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
		]
	];

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

$options = [
	'title' => __('Shortcuts Bar', 'blc'),
	'container' => [ 'priority' => 8 ],
	'options' => [

		'shortcuts_section_options' => [
			'type' => 'ct-options',
			'setting' => [ 'transport' => 'postMessage' ],
			'inner-options' => [

				blocksy_rand_md5() => [
					'title' => __( 'General', 'blc' ),
					'type' => 'tab',
					'options' => [
						'shortcuts_bar_type' => [
							'label' => __('Type', 'blc'),
							'type' => 'ct-image-picker',
							'value' => 'type-1',
							'design' => 'block',
							'sync' => 'live',
							'choices' => [
								'type-1' => [
									'src' => blocksy_image_picker_url('shortcuts-type-1.svg'),
									'title' => __('Type 1', 'blc'),
								],

								'type-2' => [
									'src' => blocksy_image_picker_url('shortcuts-type-2.svg'),
									'title' => __('Type 2', 'blc'),
								],
							],
						],

						'shortcuts_bar_items' => [
							'label' => __('Shortcuts', 'blc' ),
							'type' => 'ct-layers',
							'value' => [
								[
									'id' => 'home',
									'enabled' => true,
									'label' => __('Home', 'blc'),
									'icon' => [
										'icon' => 'blc blc-home'
									]
								],

								[
									'id' => 'phone',
									'enabled' => true,
									'label' => __('Phone', 'blc'),
									'icon' => [
										'icon' => 'blc blc-phone'
									]
								]
							],

							'manageable' => true,
							'sync' => 'live',
							'sync' => [
								'selector' => '.ct-shortcuts-container',
								'render' => function () {
									echo blocksy_render_view(
										dirname(__FILE__) . '/views/bar.php',
										[]
									);
								}
							],
							'settings' => $layer_settings
						],

						blocksy_rand_md5() => [
							'type' => 'ct-divider',
						],

						'shortcuts_label_visibility' => [
							'label' => __( 'Label Visibility', 'blc' ),
							'type' => 'ct-visibility',
							'design' => 'block',
							'allow_empty' => true,
							'setting' => [ 'transport' => 'postMessage' ],
							'value' => [
								'desktop' => false,
								'tablet' => false,
								'mobile' => false,
							],

							'sync' => [
								'selector' => '.ct-shortcuts-container',
								'render' => function () {
									echo blocksy_render_view(
										dirname(__FILE__) . '/views/bar.php',
										[]
									);
								}
							],

							'choices' => blocksy_ordered_keys([
								'desktop' => __( 'Desktop', 'blc' ),
								'tablet' => __( 'Tablet', 'blc' ),
								'mobile' => __( 'Mobile', 'blc' ),
							]),
						],

						blocksy_rand_md5() => [
							'type' => 'ct-condition',
							'condition' => [
								'any' => [
									'shortcuts_label_visibility/desktop' => true,
									'shortcuts_label_visibility/tablet' => true,
									'shortcuts_label_visibility/mobile' => true,
								]
							],
							'options' => [
								'shortcuts_label_position' => [
									'type' => 'ct-radio',
									'label' => __( 'Label Position', 'blc' ),
									'value' => 'bottom',
									'view' => 'text',
									'divider' => 'top',
									'design' => 'block',
									'sync' => 'live',
									'choices' => [
										'left' => __( 'Left', 'blc' ),
										'right' => __( 'Right', 'blc' ),
										'bottom' => __( 'Bottom', 'blc' ),
									],
								],
							],
						],

						blocksy_rand_md5() => [
							'type' => 'ct-divider',
						],

						'shortcuts_icon_size' => [
							'label' => __( 'Icon Size', 'blc' ),
							'type' => 'ct-slider',
							'min' => 5,
							'max' => 50,
							'value' => 15,
							'responsive' => true,
							'setting' => [ 'transport' => 'postMessage' ],
						],

						'shortcuts_container_height' => [
							'label' => __( 'Container Height', 'blc' ),
							'type' => 'ct-slider',
							'min' => 5,
							'max' => 150,
							'value' => 70,
							'divider' => 'top',
							'responsive' => true,
							'setting' => [ 'transport' => 'postMessage' ],
						],

						blocksy_rand_md5() => [
							'type' => 'ct-condition',
							'condition' => [ 'shortcuts_bar_type' => 'type-2' ],
							'options' => [
								'shortcuts_container_width' => [
									'label' => __( 'Container Max Width', 'blc' ),
									'type' => 'ct-slider',
									'value' => '100%',
									'divider' => 'top',
									'responsive' => true,
									'units' => blocksy_units_config([
										[ 'unit' => '%', 'min' => 0, 'max' => 100 ],
										[ 'unit' => 'px', 'min' => 0, 'max' => 1500 ],
										[ 'unit' => 'pt', 'min' => 0, 'max' => 1500 ],
										[ 'unit' => 'em', 'min' => 0, 'max' => 200 ],
										[ 'unit' => 'rem', 'min' => 0, 'max' => 200 ],
										[ 'unit' => 'vw', 'min' => 0, 'max' => 100 ],
										[ 'unit' => 'vh', 'min' => 0, 'max' => 100 ],
									]),
									'setting' => [ 'transport' => 'postMessage' ],
								],
							],
						],

						blocksy_rand_md5() => [
							'type' => 'ct-divider',
						],

						'shortcuts_interaction' => [
							'label' => __('Scroll Interaction', 'blc'),
							'type' => 'ct-radio',
							'value' => 'none',
							'view' => 'text',
							'choices' => [
								'none' => __('None', 'blc'),
								'scroll' => __('Hide', 'blc'),
							],

							'sync' => [
								'selector' => '.ct-shortcuts-container',
								'render' => function () {
									echo blocksy_render_view(
										dirname(__FILE__) . '/views/bar.php',
										[]
									);
								}
							],
						],

						'shortcuts_bar_visibility' => [
							'label' => __( 'Visibility', 'blc' ),
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
								'desktop' => __( 'Desktop', 'blc' ),
								'tablet' => __( 'Tablet', 'blc' ),
								'mobile' => __( 'Mobile', 'blc' ),
							]),
						],

						'shortcuts_bar_conditions' => [
							'label' => __('Display Conditions', 'blc'),
							'type' => 'blocksy-display-condition',
							'divider' => 'top',
							'value' => $initial_conditions,
							'display' => 'modal',

							'modalTitle' => __('Shortcuts Bar Display Conditions', 'blc'),
							'modalDescription' => __('Add one or more conditions to display the shortcuts bar.', 'blc'),
							'design' => 'block',
							'sync' => 'live'
						],
					],
				],

				blocksy_rand_md5() => [
					'title' => __( 'Design', 'blc' ),
					'type' => 'tab',
					'options' => [

						'shortcuts_font' => [
							'type' => 'ct-typography',
							'label' => __( 'Font', 'blc' ),
							'value' => blocksy_typography_default_values([
								'size' => '12px',
								'variation' => 'n5',
								'text-transform' => 'uppercase',
							]),
							'setting' => [ 'transport' => 'postMessage' ],
						],

						'shortcuts_font_color' => [
							'label' => __( 'Font Color', 'blc' ),
							'type'  => 'ct-color-picker',
							'design' => 'block:right',
							'divider' => 'top',
							'responsive' => true,
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
									'title' => __( 'Hover', 'blc' ),
									'id' => 'hover',
									'inherit' => 'var(--linkHoverColor)'
								],
							],
						],

						'shortcuts_icon_color' => [
							'label' => __( 'Icons Color', 'blc' ),
							'type'  => 'ct-color-picker',
							'design' => 'block:right',
							'divider' => 'top',
							'responsive' => true,
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
									'title' => __( 'Hover', 'blc' ),
									'id' => 'hover',
									'inherit' => 'var(--paletteColor2)'
								],
							],
						],

						'shortcuts_divider' => [
							'label' => __( 'Items Divider', 'blc' ),
							'type' => 'ct-border',
							'sync' => 'live',
							'design' => 'inline',
							'divider' => 'top',
							'value' => [
								'width' => 1,
								'style' => 'dashed',
								'color' => [
									'color' => 'var(--paletteColor5)',
								],
							]
						],

						blocksy_rand_md5() => [
							'type' => 'ct-condition',
							'condition' => [ 'shortcuts_divider/style' => '!none' ],
							'options' => [

								'shortcuts_divider_height' => [
									'label' => __( 'Items Divider Height', 'blc' ),
									'type' => 'ct-slider',
									'value' => 40,
									'min' => 10,
									'max' => 100,
									'defaultUnit' => '%',
									'divider' => 'top',
									'setting' => [ 'transport' => 'postMessage' ],
								],

							],
						],

						'shortcuts_container_shadow' => [
							'label' => __( 'Shadow', 'blc' ),
							'type' => 'ct-box-shadow',
							'responsive' => true,
							'divider' => 'top',
							'value' => blc_call_fn(['fn' => 'blocksy_box_shadow_value'], [
								'enable' => true,
								'h_offset' => 0,
								'v_offset' => -10,
								'blur' => 20,
								'spread' => 0,
								'inset' => false,
								'color' => [
									'color' => 'rgba(44,62,80,0.04)',
								],
							]),
							'setting' => [ 'transport' => 'postMessage' ],
						],

						'shortcuts_container_background' => [
							'label' => __( 'Container Background', 'blc' ),
							'type' => 'ct-background',
							'design' => 'block:right',
							'responsive' => true,
							'divider' => 'top',
							'sync' => 'live',
							'value' => blocksy_background_default_value([
								'backgroundColor' => [
									'default' => [
										'color' => 'var(--paletteColor8)',
									],
								],
							])
						],

						blocksy_rand_md5() => [
							'type' => 'ct-condition',
							'condition' => [ 'shortcuts_bar_type' => 'type-2' ],
							'options' => [

								'shortcuts_container_border_radius' => [
									'label' => __( 'Container Border Radius', 'blc' ),
									'type' => 'ct-spacing',
									'divider' => 'top',
									'setting' => [ 'transport' => 'postMessage' ],
									'value' => blocksy_spacing_value([
										'linked' => true,
										'top' => '7px',
										'left' => '7px',
										'right' => '7px',
										'bottom' => '7px',
									]),
									'responsive' => true
								],

							],
						],
					],
				],
			]
		]
	]
];
