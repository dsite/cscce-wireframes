<?php

$options = [
	'label' => __('Floating Cart', 'blc'),
	'type' => 'ct-panel',
	'switch' => true,
	'value' => 'yes',
	'inner-options' => [

		blocksy_rand_md5() => [
			'title' => __( 'General', 'blc' ),
			'type' => 'tab',
			'options' => [

				'floating_bar_position' => [
					'type' => 'ct-radio',
					'label' => __( 'Position', 'blc' ),
					'view' => 'text',
					'design' => 'block',
					'responsive' => true,
					'setting' => [ 'transport' => 'postMessage' ],
					'value' => 'top',
					'choices' => [
						'top' => __( 'Top', 'blc' ),
						'bottom' => __( 'Bottom', 'blc' ),
					],
				],

				blocksy_rand_md5() => [
					'type' => 'ct-divider',
				],

				'floatingBarTitleVisibility' => [
					'label' => __('Product Title Visibility', 'blc'),
					'type' => 'ct-visibility',
					'design' => 'block',
					'setting' => ['transport' => 'postMessage'],
					'allow_empty' => true,

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

				'floatingBarVisibility' => [
					'label' => __('Floating Cart Visibility', 'blc'),
					'type' => 'ct-visibility',
					'design' => 'block',
					'setting' => ['transport' => 'postMessage'],
					'allow_empty' => true,

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

				'floatingBarFontColor' => [
					'label' => __( 'Font Color', 'blc' ),
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
							'inherit' => 'var(--color)'
						],
					],
				],

				'floatingBarBackground' => [
					'label' => __( 'Background Color', 'blocksy' ),
					'type' => 'ct-background',
					'design' => 'block:right',
					'responsive' => true,
					'divider' => 'top',
					'sync' => 'live',
					'value' => blocksy_background_default_value([
						'backgroundColor' => [
							'default' => [
								'color' => '#ffffff',
							],
						],
					])
				],

				'floatingBarShadow' => [
					'label' => __( 'Shadow', 'blc' ),
					'type' => 'ct-box-shadow',
					'responsive' => true,
					'divider' => 'top',
					'value' => blc_call_fn(['fn' => 'blocksy_box_shadow_value'], [
						'enable' => true,
						'h_offset' => 0,
						'v_offset' => 10,
						'blur' => 20,
						'spread' => 0,
						'inset' => false,
						'color' => [
							'color' => 'rgba(44,62,80,0.15)',
						],
					]),
					'setting' => [ 'transport' => 'postMessage' ],
				],

			],
		],

	],
];

