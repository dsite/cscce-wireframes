<?php

$options = [
	blocksy_rand_md5() => [
		'type' => 'tab',
		'title' => __('General', 'blc'),
		'options' => [

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'menu_item_level' => '1' ],
				'options' => [

					'has_mega_menu' => [
						'type' => 'ct-switch',
						'label' => __('Mega Menu Settings', 'blc'),
						'value' => 'no',
						'wrapperAttr' => ['data-label' => 'heading-label'],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => ['has_mega_menu' => 'yes'],
						'options' => [

							'mega_menu_width' => [
								'label' => __( 'Dropdown Width', 'blc' ),
								'type' => 'ct-select',
								'value' => 'content',
								'view' => 'text',
								'design' => 'inline',
								'divider' => 'top',
								'choices' => blocksy_ordered_keys(
									[
										'content' => __( 'Content Width', 'blc' ),
										'full_width' => __( 'Full Width', 'blc' ),
										'custom' => __( 'Custom Width', 'blc' ),
									]
								),
							],

							blocksy_rand_md5() => [
								'type' => 'ct-condition',
								'condition' => [ 'mega_menu_width' => 'full_width' ],
								'options' => [

									'mega_menu_content_width' => [
										'label' => __( 'Content Width', 'blc' ),
										'type' => 'ct-select',
										'value' => 'default',
										'view' => 'text',
										'design' => 'inline',
										'divider' => 'top',
										'choices' => blocksy_ordered_keys(
											[
												'default' => __( 'Default Width', 'blc' ),
												'full_width' => __( 'Full Width', 'blc' ),
											]
										),
									],

								],
							],

							blocksy_rand_md5() => [
								'type' => 'ct-condition',
								'condition' => [ 'mega_menu_width' => 'custom' ],
								'options' => [

									'mega_menu_custom_width' => [
										'label' => __( 'Dropdown Custom Width', 'blocksy' ),
										'type' => 'ct-slider',
										'value' => '400px',
										'units' => blocksy_units_config([
											[ 'unit' => 'px', 'min' => 0, 'max' => 1000 ],
										]),
										'divider' => 'top',
										'design' => 'inline',
									],

								],
							],

							'mega_menu_columns' => [
								'label' => __( 'Columns', 'blc' ),
								'type' => 'ct-radio',
								'value' => '4',
								'view' => 'text',
								'design' => 'inline',
								'allow_empty' => true,
								'divider' => 'top',
								'choices' => [
									'1' => 1,
									'2' => 2,
									'3' => 3,
									'4' => 4,
									'5' => 5,
									'6' => 6,
								],
							],

							// 2 columns
							blocksy_rand_md5() => [
								'type' => 'ct-condition',
								'condition' => [ 'mega_menu_columns' => '2' ],
								'options' => [

									'2_columns_layout' => [
										'label' => false,
										'type' => 'ct-image-picker',
										'attr' => ['data-ratio' => '2:1'],
										'value' => 'repeat(2, 1fr)',
										'divider' => 'top',
										'design' => 'inline',
										'disableRevertButton' => true,
										'wrapperAttr' => [ 'class' => 'ct-control full-width' ],
										'setting' => [ 'transport' => 'postMessage' ],
										'choices' => [
											'repeat(2, 1fr)' => [
												'src' => blocksy_image_picker_file( '1-1' ),
											],

											'2fr 1fr' => [
												'src' => blocksy_image_picker_file( '2-1' ),
											],

											'1fr 2fr' => [
												'src' => blocksy_image_picker_file( '1-2' ),
											],

											'3fr 1fr' => [
												'src' => blocksy_image_picker_file( '3-1' ),
											],

											// '1fr 3fr' => [
											// 	'src' => blocksy_image_picker_file( '1-3' ),
											// ],
										],
									],

								],
							],

							// 3 columns
							blocksy_rand_md5() => [
								'type' => 'ct-condition',
								'condition' => [ 'mega_menu_columns' => '3' ],
								'options' => [

									'3_columns_layout' => [
										'label' => false,
										'type' => 'ct-image-picker',
										'attr' => ['data-ratio' => '2:1'],
										'value' => 'repeat(3, 1fr)',
										'divider' => 'top',
										'design' => 'inline',
										'disableRevertButton' => true,
										'wrapperAttr' => [ 'class' => 'ct-control full-width' ],
										'setting' => ['transport' => 'postMessage'],
										'choices' => [
											'repeat(3, 1fr)' => [
												'src' => blocksy_image_picker_file( '1-1-1' ),
											],

											'1fr 2fr 1fr' => [
												'src' => blocksy_image_picker_file( '1-2-1' ),
											],

											'2fr 1fr 1fr' => [
												'src' => blocksy_image_picker_file( '2-1-1' ),
											],

											'1fr 1fr 2fr' => [
												'src' => blocksy_image_picker_file( '1-1-2' ),
											],
										],
									],

								],
							],

							// 4 columns
							blocksy_rand_md5() => [
								'type' => 'ct-condition',
								'condition' => [
									'any' => [
										'mega_menu_columns' => '4',
										'mega_menu_columns:truthy' => 'no'
									]
								],
								'options' => [

									'4_columns_layout' => [
										'label' => false,
										'type' => 'ct-image-picker',
										'attr' => ['data-ratio' => '2:1'],
										'value' => 'repeat(4, 1fr)',
										'divider' => 'top',
										'design' => 'inline',
										'disableRevertButton' => true,
										'wrapperAttr' => [ 'class' => 'ct-control full-width' ],
										'setting' => [ 'transport' => 'postMessage' ],
										'choices' => [
											'repeat(4, 1fr)' => [
												'src'   => blocksy_image_picker_file( '1-1-1-1' ),
											],

											'1fr 2fr 2fr 1fr' => [
												'src'   => blocksy_image_picker_file( '1-2-2-1' ),
											],

											'2fr 1fr 1fr 1fr' => [
												'src'   => blocksy_image_picker_file( '2-1-1-1' ),
											],

											'1fr 1fr 1fr 2fr' => [
												'src'   => blocksy_image_picker_file( '1-1-1-2' ),
											],
										],
									],

								],
							],

							// 5 columns
							blocksy_rand_md5() => [
								'type' => 'ct-condition',
								'condition' => [ 'mega_menu_columns' => '5' ],
								'options' => [

									'5_columns_layout' => [
										'label' => false,
										'type' => 'ct-image-picker',
										'attr' => ['data-ratio' => '2:1'],
										'value' => 'repeat(5, 1fr)',
										'divider' => 'top',
										'design' => 'inline',
										'disableRevertButton' => true,
										'wrapperAttr' => [ 'class' => 'ct-control full-width' ],
										'setting' => [ 'transport' => 'postMessage' ],
										'choices' => [
											'repeat(5, 1fr)' => [
												'src'   => blocksy_image_picker_file( '1-1-1-1-1' ),
											],

											'2fr 1fr 1fr 1fr 1fr' => [
												'src'   => blocksy_image_picker_file( '2-1-1-1-1' ),
											],

											'1fr 1fr 1fr 1fr 2fr' => [
												'src'   => blocksy_image_picker_file( '1-1-1-1-2' ),
											],

											'1fr 1fr 2fr 1fr 1fr' => [
												'src'   => blocksy_image_picker_file( '1-1-2-1-1' ),
											],
										],
									],

								],
							],

							// 6 columns
							blocksy_rand_md5() => [
								'type' => 'ct-condition',
								'condition' => [ 'mega_menu_columns' => '6' ],
								'options' => [

									'6_columns_layout' => [
										'label' => false,
										'type' => 'ct-image-picker',
										'attr' => ['data-ratio' => '2:1'],
										'value' => 'repeat(6, 1fr)',
										'divider' => 'top',
										'design' => 'inline',
										'disableRevertButton' => true,
										'wrapperAttr' => [ 'class' => 'ct-control full-width' ],
										'setting' => [ 'transport' => 'postMessage' ],
										'choices' => [
											'repeat(6, 1fr)' => [
												'src'   => blocksy_image_picker_file( '1-1-1-1-1-1' ),
											],

											'2fr 1fr 1fr 1fr 1fr 1fr' => [
												'src'   => blocksy_image_picker_file( '2-1-1-1-1-1' ),
											],

											'1fr 1fr 1fr 1fr 1fr 2fr' => [
												'src'   => blocksy_image_picker_file( '1-1-1-1-1-2' ),
											],

											'1fr 1fr 2fr 2fr 1fr 1fr' => [
												'src'   => blocksy_image_picker_file( '1-1-2-2-1-1' ),
											],
										],
									],

								],
							],

						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
						'attr' => [ 'data-type' => 'full-modal' ],
					],

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'menu_item_level' => '!1' ],
				'options' => [

					blocksy_rand_md5() => [
						'type' => 'ct-title',
						'variation' => 'no-border',
						'label' => __( 'Custom Content', 'blc' ),
					],

					'mega_menu_content_type' => [
						'label' => __( 'Content Type', 'blc' ),
						'type' => 'ct-select',
						'value' => 'default',
						'view' => 'text',
						'design' => 'inline',
						'choices' => blocksy_ordered_keys(
							[
								'default' => __( 'Default (Menu Item)', 'blc' ),
								'text' => __( 'Custom Text', 'blc' ),
								'hook' => __( 'Content Block/Hook', 'blc' ),
							]
						),
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'mega_menu_content_type' => 'text' ],
						'options' => [
							'mega_menu_text' => [
								'label' => false,
								'type' => 'wp-editor',
								'value' => '',
								'disableRevertButton' => true,
								'wrapperAttr' => [ 'class' => 'ct-control full-width' ],
								'quicktags' => false,
								'mediaButtons' => false,
								'tinymce' => [
									'toolbar1' => 'bold,italic,link,alignleft,aligncenter,alignright,undo,redo',
								],
							],
						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => ['mega_menu_content_type' => 'hook'],
						'options' => empty(blc_get_content_blocks()) ? [

							blocksy_rand_md5() => [
								'type' => 'html',
								'label' => __('Select Custom Template', 'blc'),
								'value' => '',
								'design' => 'inline',
								'html' => '<a href="' . admin_url('/edit.php?post_type=ct_content_block') .'" target="_blank" class="button" style="width: 100%; text-align: center;">' . __('Create a new content Block/Hook', 'blc') . '</a>',
							],
						] : [
							'mega_menu_hook' => [
								'label' => __('Select Custom Template', 'blc'),
								'type' => 'ct-select',
								'value' => blocksy_get_default_content_block(),
								'view' => 'text',
								'design' => 'inline',
								'choices' => blocksy_ordered_keys(blc_get_content_blocks()),
							],
						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
						'attr' => [ 'data-type' => 'full-modal' ],
					],

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-title',
				'variation' => 'no-border',
				'label' => __( 'Item Label Settings', 'blc' ),
			],

			'mega_menu_label' => [
				'type' => 'ct-radio',
				'label' => __( 'Item Label', 'blc' ),
				'value' => 'default',
				'view' => 'text',
				'design' => 'inline',
				'conditions' => [
					'heading' => [ 'menu_item_level' => '!1' ]
				],
				'choices' => [
					'default' => __('Enabled', 'blc'),
					'disabled' => __('Disabled', 'blc'),
					'heading' => __('Heading', 'blc'),
				],
			],

			'has_menu_item_link' => [
				'type' => 'ct-switch',
				'label' => __('Label Link', 'blc'),
				'value' => 'yes',
				'divider' => 'top',
			],

			'menu_item_icon' => [
				'type' => 'icon-picker',
				'label' => __('Icon', 'blc'),
				'design' => 'inline',
				'divider' => 'top',
				'value' => [
					'icon' => ''
				]
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => ['menu_item_icon/icon:truthy' => 'yes'],
				'options' => [

					'menu_item_icon_size' => [
						'label' => __( 'Icons Size', 'blc' ),
						'type' => 'ct-slider',
						'design' => 'inline',
						'divider' => 'top',
						'min' => 5,
						'max' => 50,
						'value' => 20,
					],

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [
					'mega_menu_label' => '!disabled',
					'menu_item_icon/icon:truthy' => 'yes',
				],
				'options' => [

					'menu_item_position' => [
						'type' => 'ct-radio',
						'label' => __( 'Icon Position', 'blc' ),
						'value' => 'left',
						'view' => 'text',
						'design' => 'inline',
						'divider' => 'top',

						'choices' => [
							'left' => __( 'Left', 'blc' ),
							'right' => __( 'Right', 'blc' ),
						],
					],

				],
			],


			blocksy_rand_md5() => [
				'type' => 'ct-divider',
				'attr' => [ 'data-type' => 'full-modal' ],
			],

			'has_menu_badge' => [
				'type' => 'ct-switch',
				'label' => __('Menu Badge Settings', 'blc'),
				'value' => 'no',
				'wrapperAttr' => [ 'data-label' => 'heading-label' ],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'has_menu_badge' => 'yes' ],
				'options' => [

					'menu_badge_text' => [
						'type' => 'text',
						'label' => __('Text', 'blc'),
						'design' => 'inline',
						'value' => '',
					],

					'menu_badge_vertical_alignment' => [
						'label' => __( 'Vertical Alignment', 'blc' ),
						'type' => 'ct-slider',
						'design' => 'inline',
						'value' => 0,
						'min' => -20,
						'max' => 20,
						'steps' => 'half',
					],

				],
			],

		]
	],

	blocksy_rand_md5() => [
		'type' => 'tab',
		'title' => __('Design', 'blc'),
		'options' => [

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [
					'menu_item_level' => '1',
					'has_mega_menu' => 'yes',
				],
				'options' => [

					blocksy_rand_md5() => [
						'type' => 'ct-title',
						'variation' => 'no-border',
						'label' => __( 'Mega Menu Settings', 'blc' ),
					],

					'mega_menu_background' => [
						'label' => __( 'Background', 'blc' ),
						'type' => 'ct-background',
						'design' => 'inline',
						'divider' => 'bottom',
						'value' => blocksy_background_default_value([
							'backgroundColor' => [
								'default' => [
									'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT')
								],
							],
						])
					],

					'menu_items_links' => [
						'label' => __( 'Link Color', 'blc' ),
						'type'  => 'ct-color-picker',
						'design' => 'inline',
						'divider' => 'bottom',
						'value' => [
							'default' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],

							'hover' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],

							'bg_hover' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],
						],

						'pickers' => [
							[
								'title' => __( 'Link Initial', 'blc' ),
								'id' => 'default',
							],

							[
								'title' => __( 'Link Hover/Active', 'blc' ),
								'id' => 'hover',
							],

							[
								'title' => __( 'Background Hover', 'blc' ),
								'id' => 'bg_hover',
							],
						],
					],

					'menu_items_heading' => [
						'label' => __( 'Heading Color', 'blc' ),
						'type'  => 'ct-color-picker',
						'design' => 'inline',
						'divider' => 'bottom',
						'value' => [
							'default' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],
						],

						'pickers' => [
							[
								'title' => __( 'Initial Color', 'blc' ),
								'id' => 'default',
								'inherit' => 'var(--headings-color)',
							],
						],
					],

					'menu_items_text' => [
						'label' => __( 'Text Color', 'blc' ),
						'type'  => 'ct-color-picker',
						'design' => 'inline',
						'divider' => 'bottom',
						'value' => [
							'default' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],
						],

						'pickers' => [
							[
								'title' => __( 'Initial Color', 'blc' ),
								'id' => 'default',
							],
						],
					],

					'mega_menu_items_divider' => [
						'label' => __( 'Items Divider', 'blc' ),
						'type' => 'ct-border',
						'design' => 'inline',
						'divider' => 'bottom',
						'value' => [
							'inherit' => true,
							'width' => 1,
							'style' => 'dashed',
							'color' => [
								'color' => 'rgba(255, 255, 255, 0.1)',
							],
						]
					],

					'mega_menu_columns_divider' => [
						'label' => __( 'Columns Divider', 'blc' ),
						'type' => 'ct-border',
						'design' => 'inline',
						'divider' => 'bottom',
						'value' => [
							// 'inherit' => true,
							'width' => 1,
							'style' => 'solid',
							'color' => [
								'color' => 'rgba(255, 255, 255, 0.1)',
							],
						]
					],

					'mega_menu_shadow' => [
						'label' => __( 'Dropdown Shadow', 'blc' ),
						'type' => 'ct-box-shadow',
						'design' => 'inline',
						'value' => blocksy_box_shadow_value([
							'inherit' => true,
							'enable' => true,
							'h_offset' => 0,
							'v_offset' => 10,
							'blur' => 20,
							'spread' => 0,
							'inset' => false,
							'color' => [
								'color' => 'rgba(41, 51, 61, 0.1)',
							],
						])
					],

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
						'attr' => [ 'data-type' => 'full-modal' ],
					],

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'menu_item_level' => '2' ],
				'options' => [
					blocksy_rand_md5() => [
						'type' => 'ct-title',
						'variation' => 'no-border',
						'label' => __( 'Column Settings', 'blc' ),
					],

					'menu_column_padding' => [
						'label' => __( 'Column Spacing', 'blc' ),
						'type' => 'ct-spacing',
						'design' => 'inline',
						'setting' => [ 'transport' => 'postMessage' ],
						'value' => blocksy_spacing_value([
							'linked' => true,
						]),
					],

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
						'attr' => [ 'data-type' => 'full-modal' ],
					],
				],
			],


			blocksy_rand_md5() => [
				'type' => 'ct-title',
				'variation' => 'no-border',
				'label' => __( 'Item Label Settings', 'blc' ),
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'mega_menu_label' => 'heading' ],
				'options' => [

					'menu_item_heading' => [
						'label' => __( 'Heading Color', 'blc' ),
						'type'  => 'ct-color-picker',
						'design' => 'inline',
						'divider' => 'bottom',
						'value' => [
							'default' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
							],
						],

						'pickers' => [
							[
								'title' => __( 'Initial Color', 'blc' ),
								'id' => 'default',
								'inherit' => 'var(--headings-color)',
							],
						],
					],

				],
			],

			'menu_item_icon_color' => [
				'label' => __( 'Icon Color', 'blc' ),
				'type'  => 'ct-color-picker',
				'design' => 'inline',

				'value' => [
					'default' => [
						'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
					],

					'hover' => [
						'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
					],

					'active' => [
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

					[
						'title' => __( 'Active', 'blc' ),
						'id' => 'active',
						'inherit' => 'self:hover'
					],
				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'has_menu_badge' => 'yes' ],
				'options' => [

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
						'attr' => [ 'data-type' => 'full-modal' ],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-title',
						'variation' => 'no-border',
						'label' => __('Menu Badge Settings', 'blc'),
					],

					'menu_badge_font_color' => [
						'label' => __( 'Font Color', 'blc' ),
						'type'  => 'ct-color-picker',
						'design' => 'inline',
						'divider' => 'bottom',

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

					'menu_badge_background' => [
						'label' => __( 'Background Color', 'blc' ),
						'type'  => 'ct-color-picker',
						'design' => 'inline',

						'value' => [
							'default' => [
								'color' => 'var(--paletteColor1)',
							],
						],

						'pickers' => [
							[
								'title' => __( 'Initial', 'blc' ),
								'id' => 'default',
							],
						],
					],

				],
			],


		]
	]
];

