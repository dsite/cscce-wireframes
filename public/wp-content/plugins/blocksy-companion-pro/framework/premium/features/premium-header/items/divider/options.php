<?php

$options = [

	'divider_height' => [
		'label' => __( 'Size', 'blc' ),
		'type' => 'ct-slider',
		'min' => 10,
		'max' => 100,
		'value' => '100',
		'defaultUnit' => '%',
		'responsive' => true,
		'setting' => [ 'transport' => 'postMessage' ],
	],

	blocksy_rand_md5() => [
		'type' => 'ct-divider',
	],

	blocksy_rand_md5() => [
		'type' => 'ct-labeled-group',
		'label' => __( 'Style & Color', 'blocksy' ),
		'responsive' => true,
		'choices' => [
			[
				'id' => 'header_divider',
				'label' => __('Default State', 'blocksy')
			],

			[
				'id' => 'transparent_header_divider',
				'label' => __('Transparent State', 'blocksy'),
				'condition' => [
					'row' => '!offcanvas',
					'builderSettings/has_transparent_header' => 'yes',
				],
			],

			[
				'id' => 'sticky_header_divider',
				'label' => __('Sticky State', 'blocksy'),
				'condition' => [
					'row' => '!offcanvas',
					'builderSettings/has_sticky_header' => 'yes',
				],
			],
		],
		'options' => [

			'header_divider' => [
				'label' => __( 'Style & Color', 'blocksy' ),
				'type' => 'ct-border',
				'design' => 'block',
				'sync' => 'live',
				'responsive' => true,
				'value' => [
					'width' => 1,
					'style' => 'solid',
					'color' => [
						'color' => 'rgba(44,62,80,0.2)',
					],
				]
			],

			'transparent_header_divider' => [
				'label' => __( 'Style & Color', 'blocksy' ),
				'type' => 'ct-border',
				'design' => 'block',
				'sync' => 'live',
				'responsive' => true,
				'value' => [
					'width' => 1,
					'style' => 'solid',
					'color' => [
						'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
					],
				]
			],

			'sticky_header_divider' => [
				'label' => __( 'Style & Color', 'blocksy' ),
				'type' => 'ct-border',
				'design' => 'block',
				'sync' => 'live',
				'responsive' => true,
				'value' => [
					'width' => 1,
					'style' => 'solid',
					'color' => [
						'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
					],
				]
			],
		],
	],

	blocksy_rand_md5() => [
		'type' => 'ct-divider',
	],

	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => [ 'row' => '!offcanvas', ],
		'options' => [

			'divider_horizontal_margin' => [
				'label' => __( 'Margin', 'blc' ),
				'type' => 'ct-spacing',
				'value' => blocksy_spacing_value([
					'top' => 'auto',
					'bottom' => 'auto',
					'linked' => true,
				]),
				'responsive' => true
			],

		],
	],

	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => [ 'row' => 'offcanvas', ],
		'options' => [

			'divider_vertical_margin' => [
				'label' => __( 'Margin', 'blc' ),
				'type' => 'ct-spacing',
				'value' => blocksy_spacing_value([
					'left' => 'auto',
					'right' => 'auto',
					'linked' => true,
				]),
				'responsive' => true
			],

		],
	],
];