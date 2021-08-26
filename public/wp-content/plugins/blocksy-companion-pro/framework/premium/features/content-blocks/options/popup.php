<?php

global $post;

$post_id = $post->ID;

$template_type = get_post_meta($post_id, 'template_type', true);

$hooks_manager = new \Blocksy\HooksManager();

$choices = [];

foreach ($hooks_manager->get_all_hooks() as $hook) {
	$choices[] = array_merge([
		'key' => $hook['hook'],
		'value' => isset($hook['title']) ? $hook['title'] : $hook['hook']
	], isset($hook['group']) ? [
		'group' => $hook['group']
	] : []);
}

$choices[] = [
	'key' => 'custom_hook',
	'value' => 'Custom Hook',
	'group' => __('Other', 'blc')
];

$options = [
	blocksy_rand_md5() => [
		'title' => __( 'General', 'blc' ),
		'type' => 'tab',
		'options' => [

			[
				'has_inline_code_editor' => [
					// 'type' => 'ct-switch',
					'type' => 'hidden',
					'value' => 'no'
				],

				'has_content_block_structure' => [
					'label' => __( 'Container Structure', 'blc' ),
					'type' => 'hidden',
					'value' => 'no',
					'design' => 'none'
				],
			],

			'popup_position' => [
				'label' => __('Popup Position', 'blc' ),
				'type' => 'blocksy-position',
				'value' => 'bottom:right',
				'design' => 'block',
			],

			'popup_size' => [
				'label' => __('Popup Size', 'blc' ),
				'type' => 'ct-select',
				'value' => 'medium',
				'design' => 'block',
				'divider' => 'top:full',
				'choices' => blocksy_ordered_keys([
					'small' => __('Small Size', 'blc'),
					'medium' => __('Medium Size', 'blc'),
					'large' => __('Large Size', 'blc'),
					'custom' => __('Custom Size', 'blc'),
				]),
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => ['popup_size' => 'custom'],
				'options' => [

					'popup_max_width' => [
						'label' => __( 'Max Width', 'blc' ),
						'type' => 'ct-slider',
						'value' => '400px',
						'design' => 'block',
						'units' => [
							[ 'unit' => 'px','min' => 0, 'max' => 1500 ],
							[ 'unit' => 'vw', 'min' => 0, 'max' => 100 ],
							[ 'unit' => 'vh', 'min' => 0, 'max' => 100 ],
							[ 'unit' => 'em', 'min' => 0, 'max' => 100 ],
							[ 'unit' => 'rem', 'min' => 0, 'max' => 100 ],
						],
						'responsive' => true,
						'sync' => 'live'
					],

					'popup_max_height' => [
						'label' => __( 'Max Height', 'blc' ),
						'type' => 'ct-slider',
						'value' => 'CT_CSS_SKIP_RULE',
						'design' => 'block',
						'units' => [
							[ 'unit' => 'px','min' => 0, 'max' => 1500 ],
							[ 'unit' => 'vw', 'min' => 0, 'max' => 100 ],
							[ 'unit' => 'vh', 'min' => 0, 'max' => 100 ],
							[ 'unit' => 'em', 'min' => 0, 'max' => 100 ],
							[ 'unit' => 'rem', 'min' => 0, 'max' => 100 ],
						],
						'responsive' => true,
						'sync' => 'live'
					],

				]
			],

			'popup_open_animation' => [
				'label' => __('Popup Animation', 'blc' ),
				'type' => 'ct-select',
				'value' => 'fade-in',
				'design' => 'block',
				'divider' => 'top:full',
				'choices' => blocksy_ordered_keys([
					'fade-in' => __('Fade in fade out', 'blc'),
					'zoom-in' => __('Zoom in zoom out', 'blc'),
					'slide-left' => __('Slide in from left', 'blc'),
					'slide-right' => __('Slide in from right', 'blc'),
					'slide-top' => __('Slide in from top', 'blc'),
					'slide-bottom' => __('Slide in from bottom', 'blc'),
				]),
			],

			'popup_entrance_speed' => [
				'label' => __( 'Animation Speed', 'blc' ),
				'type' => 'ct-number',
				'design' => 'inline',
				'value' => 0.3,
				'min' => 0,
				'max' => 10,
				'step' => 0.1,
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [
					'popup_open_animation' => 'slide-left|slide-right|slide-top|slide-bottom',
				],
				'options' => [

					'popup_entrance_value' => [
						'label' => __( 'Entrance Value', 'blc' ),
						'type' => 'ct-number',
						'design' => 'inline',
						'value' => 50,
						'min' => 0,
						'max' => 500,
					],

				],
			],

			'popup_trigger_condition' => [
				'label' => __('Trigger Condition', 'blc' ),
				'type' => 'ct-select',
				'value' => 'default',
				'design' => 'block',
				'divider' => 'top:full',
				'choices' => blocksy_ordered_keys([
					'default' => __('None', 'blc'),
					'scroll' => __('On scroll', 'blc'),
					'element_reveal' => __('On scroll to element', 'blc'),
					'page_load' => __('On page load', 'blc'),
					'after_inactivity' => __('After inactivity', 'blc'),
					'after_x_time' => __('After x time', 'blc'),
					'exit_intent' => __('On page exit intent', 'blc'),
					// 'click' => __('On Click', 'blc'),
					// 'arriving_from' => __('Arriving From Page', 'blc'),
					// 'viewed_pages' => __('After Viewed Pages', 'blc'),
				]),
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'popup_trigger_condition' => 'element_reveal' ],
				'options' => [

					'scroll_to_element' => [
						'label' => __( 'Element Class', 'blc' ),
						'type' => 'text',
						'design' => 'block',
						'value' => '',
						'attr' => ['placeholder' => '.my-element-class'],
						'sync' => 'live',
						'divider' => 'bottom',
						'desc' => __('Separate each class by comma if you have multiple elements.', 'blc' ),
					],

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'popup_trigger_condition' => 'scroll' ],
				'options' => [

					'scroll_direction' => [
						'label' => __('Scroll Direction', 'blc' ),
						'type' => 'ct-select',
						'value' => 'down',
						'design' => 'block',
						'choices' => blocksy_ordered_keys([
							'down' => __('Scroll Down', 'blc'),
							'up' => __('Scroll Up', 'blc')
						]),
					],

					'scroll_value' => [
						'label' => __( 'Scroll Distance', 'blc' ),
						'type' => 'ct-slider',
						'value' => '200px',
						'design' => 'block',
						'divider' => 'bottom',
						'units' => [
							[ 'unit' => 'px','min' => 0, 'max' => 5000 ],
							[ 'unit' => '%','min' => 0, 'max' => 100 ],
							[ 'unit' => 'vh', 'min' => 0, 'max' => 100 ],
						],
						'desc' => __('Set the scroll distance till the popup block will appear.', 'blc' ),
					],

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'popup_trigger_condition' => 'after_inactivity' ],
				'options' => [

					'inactivity_value' => [
						'label' => __( 'Inactivity Time', 'blc' ),
						'type' => 'ct-number',
						'design' => 'inline',
						'value' => 10,
						'min' => 0,
						'max' => 5000,
						'desc' => __('Set the inactivity time (in seconds) till the popup block will appear.', 'blc' ),
					],

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'popup_trigger_condition' => 'after_x_time' ],
				'options' => [

					'x_time_value' => [
						'label' => __( 'After X Time', 'blc' ),
						'type' => 'ct-number',
						'design' => 'inline',
						'value' => 10,
						'min' => 0,
						'max' => 5000,
						'desc' => __('Set after how much time (in seconds) the popup block will appear.', 'blc' ),
					],

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'popup_trigger_condition' => '!default' ],
				'options' => [

					'popup_trigger_once' => [
						'label' => __( 'Trigger Popup Only Once', 'blc' ),
						'type' => 'ct-switch',
						'value' => 'no',
						'desc' => __('If the close button is clicked the popup won\'t be triggered anymore for the current visitor.', 'blc' ),
					],

				],
			],

			'conditions' => [
				'label' => __('Display Conditions', 'blc'),
				'type' => 'blocksy-display-condition',
				'divider' => 'top:full',
				'sectionAttr' => [ 'class' => 'ct-content-blocks-conditions' ],
				'value' => [
					[
						'type' => 'include',
						'rule' => 'singulars',
						'payload' => []
					]
				],

				'value' => [],
				'design' => 'block',
			],

			'has_content_block_expiration' => [
				'label' => __('Expiration Date/Time', 'blc'),
				'type' => 'ct-switch',
				'value' => 'no',
				'design' => 'inline',
				'divider' => 'top:full'
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => ['has_content_block_expiration' => 'yes'],
				'options' => [
					'expiration_date' => [
						'label' => false,
						'type' => 'date-time-picker',
						'value' => '',
						'disableRevertButton' => true,
					],
				]
			],

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
			],

			'visibility' => [
				'label' => __( 'Visibility', 'blc' ),
				'type' => 'ct-visibility',
				'design' => 'block',

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

		],
	],

	blocksy_rand_md5() => [
		'title' => __( 'Design', 'blc' ),
		'type' => 'tab',
		'options' => [

			'popup_padding' => [
				'label' => __( 'Padding', 'blc' ),
				'type' => 'ct-spacing',
				'divider' => 'top',
				'value' => blocksy_spacing_value([
					'linked' => true,
				]),
				'responsive' => true
			],

			'popup_border_radius' => [
				'label' => __( 'Border Radius', 'blc' ),
				'sync' => 'live',
				'type' => 'ct-spacing',
				'divider' => 'top',
				'value' => blocksy_spacing_value([
					'linked' => true,
				]),
				'responsive' => true
			],

			'popup_shadow' => [
				'label' => __( 'Shadow', 'blc' ),
				'type' => 'ct-box-shadow',
				'divider' => 'top',
				'responsive' => true,
				'value' => blocksy_box_shadow_value([
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

			'popup_edges_offset' => [
				'label' => __( 'Popup Offset', 'blc' ),
				'type' => 'ct-slider',
				'min' => 0,
				'max' => 300,
				'value' => 25,
				'responsive' => true,
				'divider' => 'top',
			],

			'popup_container_overflow' => [
				'label' => __('Container Overflow', 'blc'),
				'type' => 'ct-radio',
				'value' => 'scroll',
				'view' => 'text',
				'design' => 'block',
				'divider' => 'top:full',
				'choices' => [
					'hidden' => __( 'Hidden', 'blc' ),
					'visible' => __( 'Visible', 'blc' ),
					'scroll' => __('Scroll', 'blc'),
				],
				'desc' => __('Control what happens to the content that is too big to fit into the popup.', 'blc'),
			],

			'close_button_type' => [
				'label' => __('Close Button', 'blc'),
				'type' => 'ct-radio',
				'value' => 'outside',
				'view' => 'text',
				'design' => 'block',
				'divider' => 'top:full',
				'choices' => [
					'none' => __('None', 'blc'),
					'inside' => __('Inside', 'blc'),
					'outside' => __( 'Outside', 'blc' ),
				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'has_close_button' => '!none' ],
				'options' => [

					'popup_close_button_color' => [
						'label' => __( 'Close Icon Color', 'blocksy' ),
						'type'  => 'ct-color-picker',
						'design' => 'inline',
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
								'title' => __( 'Initial', 'blocksy' ),
								'id' => 'default',
								'inherit' => 'rgba(255, 255, 255, 0.7)'
							],

							[
								'title' => __( 'Hover', 'blocksy' ),
								'id' => 'hover',
								'inherit' => '#ffffff'
							],
						],
					],

					'popup_close_button_shape_color' => [
						'label' => __( 'Close Icon Background', 'blocksy' ),
						'type'  => 'ct-color-picker',
						'design' => 'inline',
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
								'title' => __( 'Initial', 'blocksy' ),
								'id' => 'default',
								'inherit' => 'rgba(0, 0, 0, 0.5)'
							],

							[
								'title' => __( 'Hover', 'blocksy' ),
								'id' => 'hover',
								'inherit' => 'rgba(0, 0, 0, 0.5)'
							],
						],
					],
				],
			],

			'popup_background' => [
				'label' => __( 'Popup Background', 'blc' ),
				'type'  => 'ct-background',
				'design' => 'inline',
				'divider' => 'top:full',
				'value' => blocksy_background_default_value([
					'backgroundColor' => [
						'default' => [
							'color' => '#ffffff'
						],
					],
				])
			],

			'popup_backdrop_background' => [
				'label' => __( 'Popup Backdrop Background', 'blc' ),
				'type'  => 'ct-background',
				'design' => 'inline',
				'divider' => 'top:full',
				'has_no_color' => true,
				'default_inherit_color' => 'rgba(18, 21, 25, 0.5)',
				'value' => blocksy_background_default_value([
					'backgroundColor' => [
						'default' => [
							'color' => 'CT_CSS_SKIP_RULE'
						],
					],
				])
			],

		],
	],
];

