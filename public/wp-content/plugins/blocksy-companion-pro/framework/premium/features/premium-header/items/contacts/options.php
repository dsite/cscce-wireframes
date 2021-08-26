<?php

$options = [
	blocksy_rand_md5() => [
		'title' => __( 'General', 'blc' ),
		'type' => 'tab',
		'options' => array_merge([

			'contact_items' => [
				'label' => false,
				'type' => 'ct-layers',
				'manageable' => true,
				'sync' => [
					'id' => $panel_type . '_placements_item:contacts'
				],
				'value' => [
					[
						'id' => 'address',
						'enabled' => true,
						'title' => __('Address:', 'blc'),
						'content' => 'Street Name, NY 38954',
					],

					[
						'id' => 'phone',
						'enabled' => true,
						'title' => __('Phone:', 'blc'),
						'content' => '578-393-4937',
						'link' => 'tel:578-393-4937',
					],

					[
						'id' => 'mobile',
						'enabled' => true,
						'title' => __('Mobile:', 'blc'),
						'content' => '578-393-4937',
						'link' => 'tel:578-393-4937',
					],

				],

				'settings' => [
					'address' => [
						'label' => __( 'Address', 'blc' ),
						'options' => [
							'title' => [
								'type' => 'text',
								'label' => __('Title', 'blc'),
								'value' => __('Address:', 'blc'),
								'design' => 'inline',
							],

							'content' => [
								'type' => 'text',
								'label' => __('Content', 'blc'),
								'value' => 'Street Name, NY 38954',
								'design' => 'inline',
							],

							'link' => [
								'type' => 'text',
								'label' => __('Link (optional)', 'blc'),
								'design' => 'inline',
							]
						]
					],

					'phone' => [
						'label' => __( 'Phone', 'blc' ),
						'options' => [

							'title' => [
								'type' => 'text',
								'label' => __('Title', 'blc'),
								'value' => __('Phone:', 'blc'),
								'design' => 'inline',
							],

							'content' => [
								'type' => 'text',
								'label' => __('Content', 'blc'),
								'value' => '578-393-4937',
								'design' => 'inline',
							],

							'link' => [
								'type' => 'text',
								'label' => __('Link (optional)', 'blc'),
								'value' => 'tel:578-393-4937',
								'design' => 'inline',
							]

						]
					],

					'mobile' => [
						'label' => __( 'Mobile', 'blc' ),
						'options' => [
							'title' => [
								'type' => 'text',
								'label' => __('Title', 'blc'),
								'value' => __('Mobile:', 'blc'),
								'design' => 'inline',
							],

							'content' => [
								'type' => 'text',
								'label' => __('Content', 'blc'),
								'value' => '578-393-4937',
								'design' => 'inline',
							],

							'link' => [
								'type' => 'text',
								'label' => __('Link (optional)', 'blc'),
								'value' => 'tel:578-393-4937',
								'design' => 'inline',
							],

						]
					],

					'hours' => [
						'label' => __( 'Work Hours', 'blc' ),
						'options' => [
							'title' => [
								'type' => 'text',
								'label' => __('Title', 'blc'),
								'value' => __('Opening hours', 'blc'),
								'design' => 'inline',
							],

							'content' => [
								'type' => 'text',
								'label' => __('Content', 'blc'),
								'value' => '9AM - 5PM',
								'design' => 'inline',
							],

							'link' => [
								'type' => 'text',
								'label' => __('Link (optional)', 'blc'),
								'value' => '',
								'design' => 'inline',
							],

						]
					],

					'fax' => [
						'label' => __( 'Fax', 'blc' ),
						'options' => [
							'title' => [
								'type' => 'text',
								'label' => __('Title', 'blc'),
								'value' => __('Fax:', 'blc'),
								'design' => 'inline',
							],

							'content' => [
								'type' => 'text',
								'label' => __('Content', 'blc'),
								'value' => '578-393-4937',
								'design' => 'inline',
							],

							'link' => [
								'type' => 'text',
								'label' => __('Link (optional)', 'blc'),
								'value' => 'tel:578-393-4937',
								'design' => 'inline',
							],

						]
					],

					'email' => [
						'label' => __( 'Email', 'blc' ),
						'options' => [
							'title' => [
								'type' => 'text',
								'label' => __('Title', 'blc'),
								'value' => __('Email:', 'blc'),
								'design' => 'inline',
							],

							'content' => [
								'type' => 'text',
								'label' => __('Content', 'blc'),
								'value' => 'contact@yourwebsite.com',
								'design' => 'inline',
							],

							'link' => [
								'type' => 'text',
								'label' => __('Link (optional)', 'blc'),
								'value' => 'mailto:contact@yourwebsite.com',
								'design' => 'inline',
							],

						]
					],

					'website' => [
						'label' => __( 'Website', 'blc' ),
						'options' => [
							'title' => [
								'type' => 'text',
								'label' => __('Title', 'blc'),
								'value' => __('Website:', 'blc'),
								'design' => 'inline',
							],

							'content' => [
								'type' => 'text',
								'label' => __('Content', 'blc'),
								'value' => 'creativethemes.com',
								'design' => 'inline',
							],

							'link' => [
								'type' => 'text',
								'label' => __('Link (optional)', 'blc'),
								'value' => 'https://creativethemes.com',
								'design' => 'inline',
							],

						]
					],
				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
			],

			'link_target' => [
				'type'  => 'ct-switch',
				'label' => __( 'Open Links In New Tab', 'blc' ),
				'value' => 'no',
				'disableRevertButton' => true,
			],

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
			],

			'contacts_icon_size' => [
				'label' => __( 'Icons Size', 'blc' ),
				'type' => 'ct-slider',
				'min' => 5,
				'max' => 50,
				'value' => 15,
				'responsive' => true,
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'contacts_spacing' => [
				'label' => __( 'Items Spacing', 'blc' ),
				'type' => 'ct-slider',
				'min' => 0,
				'max' => 50,
				'value' => 15,
				'responsive' => true,
				'divider' => 'bottom',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'contacts_icon_shape' => [
				'label' => __('Icons Shape Type', 'blc'),
				'type' => 'ct-radio',
				'value' => 'rounded',
				'view' => 'text',
				'design' => 'block',
				'setting' => [ 'transport' => 'postMessage' ],
				'choices' => [
					'simple' => __( 'None', 'blc' ),
					'rounded' => __( 'Rounded', 'blc' ),
					'square' => __( 'Square', 'blc' ),
				],
				'sync' => 'live',
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'contacts_icon_shape' => '!simple' ],
				'options' => [

					'contacts_icon_fill_type' => [
						'label' => __('Shape Fill Type', 'blc'),
						'type' => 'ct-radio',
						'value' => 'outline',
						'view' => 'text',
						'design' => 'block',
						'sync' => 'live',
						'choices' => [
							'solid' => __( 'Solid', 'blc' ),
							'outline' => __( 'Outline', 'blc' ),
						],
					],

				],
			],

		], $panel_type === 'footer' ? [
			'contacts_items_direction' => [
				'type' => 'ct-radio',
				'label' => __( 'Items Direction', 'blc' ),
				'view' => 'text',
				'design' => 'block',
				'value' => 'vertical',
				'divider' => 'top:full',
				'choices' => [
					'horizontal' => __( 'Horizontal', 'blc' ),
					'vertical' => __( 'Vertical', 'blc' ),
				],
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'footer_contacts_visibility' => [
				'label' => __( 'Element Visibility', 'blocksy' ),
				'type' => 'ct-visibility',
				'design' => 'block',
				'divider' => 'top:full',
				// 'allow_empty' => true,
				'setting' => [ 'transport' => 'postMessage' ],
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

			'contacts_font' => [
				'type' => 'ct-typography',
				'label' => __( 'Font', 'blc' ),
				'value' => blocksy_typography_default_values([
					'size' => '13px',
					'line-height' => '1.3',
				]),
				'setting' => [ 'transport' => 'postMessage' ],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-labeled-group',
				'label' => __( 'Font Color', 'blc' ),
				'responsive' => true,
				'choices' => [
					[
						'id' => 'contacts_font_color',
						'label' => __('Default State', 'blc')
					],

					[
						'id' => 'transparent_contacts_font_color',
						'label' => __('Transparent State', 'blc'),
						'condition' => [
							'row' => '!offcanvas',
							'builderSettings/has_transparent_header' => 'yes',
						],
					],

					[
						'id' => 'sticky_contacts_font_color',
						'label' => __('Sticky State', 'blc'),
						'condition' => [
							'row' => '!offcanvas',
							'builderSettings/has_sticky_header' => 'yes',
						],
					],
				],
				'options' => [

					'contacts_font_color' => [
						'label' => __( 'Font Color', 'blc' ),
						'type'  => 'ct-color-picker',
						'design' => 'block:right',
						'divider' => 'bottom',
						'responsive' => true,
						'setting' => [ 'transport' => 'postMessage' ],

						'value' => [
							'default' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],

							'link_initial' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
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
								'inherit' => 'var(--linkInitialColor)'
							],

							[
								'title' => __( 'Link Hover', 'blc' ),
								'id' => 'link_hover',
								'inherit' => 'var(--linkHoverColor)'
							],
						],
					],

					'transparent_contacts_font_color' => [
						'label' => __( 'Font Color', 'blc' ),
						'type'  => 'ct-color-picker',
						'design' => 'block:right',
						'divider' => 'bottom',
						'responsive' => true,
						'setting' => [ 'transport' => 'postMessage' ],

						'value' => [
							'default' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],

							'link_initial' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],

							'link_hover' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],
						],

						'pickers' => [
							[
								'title' => __( 'Text Initial', 'blc' ),
								'id' => 'default',
							],

							[
								'title' => __( 'Link Initial', 'blc' ),
								'id' => 'link_initial',
							],

							[
								'title' => __( 'Link Hover', 'blc' ),
								'id' => 'link_hover',
							],
						],
					],

					'sticky_contacts_font_color' => [
						'label' => __( 'Font Color', 'blc' ),
						'type'  => 'ct-color-picker',
						'design' => 'block:right',
						'divider' => 'bottom',
						'responsive' => true,
						'setting' => [ 'transport' => 'postMessage' ],

						'value' => [
							'default' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],

							'link_initial' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],

							'link_hover' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],
						],

						'pickers' => [
							[
								'title' => __( 'Text Initial', 'blc' ),
								'id' => 'default',
							],

							[
								'title' => __( 'Link Initial', 'blc' ),
								'id' => 'link_initial',
							],

							[
								'title' => __( 'Link Hover', 'blc' ),
								'id' => 'link_hover',
							],
						],
					],

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [
					'builderSettings/has_transparent_header' => 'yes',
					'builderSettings/has_sticky_header' => 'yes',
					'row' => '!offcanvas',
				],
				'options' => [
					blocksy_rand_md5() => [
						'type' => 'ct-divider',
					],
				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-labeled-group',
				'label' => __( 'Icons Color', 'blc' ),
				'responsive' => true,
				'choices' => [
					[
						'id' => 'contacts_icon_color',
						'label' => __('Default State', 'blc')
					],

					[
						'id' => 'transparent_contacts_icon_color',
						'label' => __('Transparent State', 'blc'),
						'condition' => [
							'row' => '!offcanvas',
							'builderSettings/has_transparent_header' => 'yes',
						],
					],

					[
						'id' => 'sticky_contacts_icon_color',
						'label' => __('Sticky State', 'blc'),
						'condition' => [
							'row' => '!offcanvas',
							'builderSettings/has_sticky_header' => 'yes',
						],
					],
				],
				'options' => [

					'contacts_icon_color' => [
						'label' => __( 'Icons Color', 'blc' ),
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

					'transparent_contacts_icon_color' => [
						'label' => __( 'Icons Color', 'blc' ),
						'type'  => 'ct-color-picker',
						'design' => 'block:right',
						'responsive' => true,
						'setting' => [ 'transport' => 'postMessage' ],

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
							],

							[
								'title' => __( 'Hover', 'blc' ),
								'id' => 'hover',
							],
						],
					],

					'sticky_contacts_icon_color' => [
						'label' => __( 'Icons Color', 'blc' ),
						'type'  => 'ct-color-picker',
						'design' => 'block:right',
						'responsive' => true,
						'setting' => [ 'transport' => 'postMessage' ],

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
							],

							[
								'title' => __( 'Hover', 'blc' ),
								'id' => 'hover',
							],
						],
					],

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [
					'builderSettings/has_transparent_header' => 'yes',
					'builderSettings/has_sticky_header' => 'yes',
					'row' => '!offcanvas',
				],
				'options' => [
					blocksy_rand_md5() => [
						'type' => 'ct-divider',
					],
				],
			],


			blocksy_rand_md5() => [
				'type' => 'ct-labeled-group',
				'label' => [
					__('Icons Background Color', 'blc') => [
						'contacts_icon_fill_type' => 'solid'
					],

					__('Icons Border Color', 'blc') => [
						'contacts_icon_fill_type' => 'outline'
					]
				],
				'responsive' => true,
				'choices' => [
					[
						'id' => 'contacts_icon_background',
						'label' => __('Default State', 'blc'),
						'condition' => [
							'contacts_icon_shape' => '!simple'
						],
					],

					[
						'id' => 'transparent_contacts_icon_background',
						'label' => __('Transparent State', 'blc'),
						'condition' => [
							'row' => '!offcanvas',
							'contacts_icon_shape' => '!simple',
							'builderSettings/has_transparent_header' => 'yes',
						],
					],

					[
						'id' => 'sticky_contacts_icon_background',
						'label' => __('Sticky State', 'blc'),
						'condition' => [
							'row' => '!offcanvas',
							'contacts_icon_shape' => '!simple',
							'builderSettings/has_sticky_header' => 'yes',
						],
					],
				],
				'options' => [

					'contacts_icon_background' => [
						'label' => [
							__('Icons Background Color', 'blc') => [
								'contacts_icon_fill_type' => 'solid'
							],

							__('Icons Border Color', 'blc') => [
								'contacts_icon_fill_type' => 'outline'
							]
						],
						'type'  => 'ct-color-picker',
						'design' => 'block:right',
						'responsive' => true,
						'divider' => 'top',
						'setting' => [ 'transport' => 'postMessage' ],

						'value' => [
							'default' => [
								'color' => 'rgba(218, 222, 228, 0.5)',
							],

							'hover' => [
								'color' => 'rgba(218, 222, 228, 0.7)',
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

					'transparent_contacts_icon_background' => [
						'label' => [
							__('Icons Background Color', 'blc') => [
								'contacts_icon_fill_type' => 'solid'
							],

							__('Icons Border Color', 'blc') => [
								'contacts_icon_fill_type' => 'outline'
							]
						],
						'type'  => 'ct-color-picker',
						'design' => 'block:right',
						'responsive' => true,
						'divider' => 'top',
						'setting' => [ 'transport' => 'postMessage' ],

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
							],

							[
								'title' => __( 'Hover', 'blc' ),
								'id' => 'hover',
							],
						],
					],

					'sticky_contacts_icon_background' => [
						'label' => [
							__('Icons Background Color', 'blc') => [
								'contacts_icon_fill_type' => 'solid'
							],

							__('Icons Border Color', 'blc') => [
								'contacts_icon_fill_type' => 'outline'
							]
						],
						'type'  => 'ct-color-picker',
						'design' => 'block:right',
						'responsive' => true,
						'divider' => 'top',
						'setting' => [ 'transport' => 'postMessage' ],

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
							],

							[
								'title' => __( 'Hover', 'blc' ),
								'id' => 'hover',
							],
						],
					],

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
			],

			'contacts_margin' => [
				'label' => __( 'Margin', 'blc' ),
				'type' => 'ct-spacing',
				'setting' => [ 'transport' => 'postMessage' ],
				'value' => blocksy_spacing_value([
					'linked' => true,
				]),
				'responsive' => true
			],

		],
	],
];

