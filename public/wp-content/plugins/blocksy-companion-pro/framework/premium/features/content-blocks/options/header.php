<?php

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
	[
		'has_inline_code_editor' => [
			// 'type' => 'ct-switch',
			'type' => 'hidden',
			'value' => 'no'
		],

		blocksy_rand_md5() => [
			'type' => 'ct-condition',
			'condition' => [ 'has_inline_code_editor' => 'no' ],
			'options' => [
				'has_content_block_structure' => [
					'label' => __( 'Container Structure', 'blc' ),
					'type' => "hidden",
					'value' => 'yes',
					'design' => 'inline'
				],
			]
		],
	],

	[
		blocksy_rand_md5() => [
			'type' => 'ct-condition',
			'condition' => [
				'has_inline_code_editor' => 'no',
				'has_content_block_structure' => 'yes'
			],
			'options' => [
				blocksy_rand_md5() => [
					'title' => __( 'General', 'blocksy' ),
					'type' => 'tab',
					'options' => [
						'content_block_structure' => [
							'label' => false,
							'type' => 'ct-image-picker',
							'value' => 'type-4',
							'choices' => [
								'type-3' => [
									'src' => blocksy_image_picker_url('narrow.svg'),
									'title' => __('Narrow Width', 'blc'),
								],

								'type-4' => [
									'src' => blocksy_image_picker_url('normal.svg'),
									'title' => __('Normal Width', 'blc'),
								],
							],
						],

						'content_style' => [
							'label' => __('Content Area Style', 'blc'),
							'type' => 'ct-radio',
							'value' => 'wide',
							'view' => 'text',
							'design' => 'block',
							'divider' => 'top',
							'responsive' => true,
							'choices' => [
								'wide' => __( 'Wide', 'blocksy' ),
								'boxed' => __( 'Boxed', 'blocksy' ),
							],
						],

						'content_block_spacing' => [
							'label' => __('Content Area Vertical Spacing', 'blc'),
							'type' => 'ct-radio',
							'value' => 'both',
							'divider' => 'top',
							'view' => 'text',
							'design' => 'block',
							'disableRevertButton' => true,
							'attr' => [ 'data-type' => 'content-spacing' ],
							'setting' => [ 'transport' => 'postMessage' ],
							'choices' => [
								'both'   => '<span></span>
								<i class="ct-tooltip-top">' . __( 'Top & Bottom', 'blc' ) . '</i>',

								'top'    => '<span></span>
								<i class="ct-tooltip-top">' . __( 'Only Top', 'blc' ) . '</i>',

								'bottom' => '<span></span>
								<i class="ct-tooltip-top">' . __( 'Only Bottom', 'blc' ) . '</i>',

								'none'   => '<span></span>
								<i class="ct-tooltip-top">' . __( 'Disabled', 'blc' ) . '</i>',
							]
						],

					],
				],

				blocksy_rand_md5() => [
					'title' => __( 'Design', 'blocksy' ),
					'type' => 'tab',
					'options' => [

						blocksy_get_options('single-elements/structure-design', [
							// 'has_background' => false
						])

					]
				],
			]
		],


		blocksy_rand_md5() => [
			'type' => 'ct-condition',
			'condition' => [ 'has_inline_code_editor' => 'no' ],
			'options' => [
				blocksy_rand_md5() => [
					'type' => 'ct-divider',
				],
			]
		],
	],

	'conditions' => [
		'label' => __('Display Conditions', 'blc'),
		'type' => 'blocksy-display-condition',
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

	blocksy_rand_md5() => [
		'type' => 'ct-divider',
	],

	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => [ 'has_inline_code_editor' => 'no' ],
		'options' => [
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
		]
	],
];

