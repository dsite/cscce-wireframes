<?php

$options = [

	blocksy_rand_md5() => [
		'title' => __( 'General', 'blocksy' ),
		'type' => 'tab',
		'options' => [

			'icon_size' => [
				'label' => __( 'Icon Size', 'blocksy' ),
				'type' => 'ct-slider',
				'min' => 5,
				'max' => 50,
				'value' => 15,
				'responsive' => true,
				'setting' => [ 'transport' => 'postMessage' ],
			],

		],
	],

	blocksy_rand_md5() => [
		'title' => __( 'Design', 'blocksy' ),
		'type' => 'tab',
		'options' => [

			blocksy_rand_md5() => [
				'type' => 'ct-labeled-group',
				'label' => __( 'Icon Color', 'blc' ),
				'responsive' => true,
				'choices' => [
					[
						'id' => 'header_dark_mode_icon_color',
						'label' => __('Default State', 'blc')
					],

					[
						'id' => 'transparent_header_dark_mode_icon_color',
						'label' => __('Transparent State', 'blc'),
						'condition' => [
							'row' => '!offcanvas',
							'builderSettings/has_transparent_header' => 'yes',
						],
					],

					[
						'id' => 'sticky_header_dark_mode_icon_color',
						'label' => __('Sticky State', 'blc'),
						'condition' => [
							'row' => '!offcanvas',
							'builderSettings/has_sticky_header' => 'yes',
						],
					],
				],
				'options' => [
					'header_dark_mode_icon_color' => [
						'label' => __( 'Icon Color', 'blc' ),
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
								'inherit' => 'var(--color)',
							],

							[
								'title' => __( 'Hover', 'blc' ),
								'id' => 'hover',
								'inherit' => 'var(--paletteColor2)',
							],
						],
					],

					'transparent_header_dark_mode_icon_color' => [
						'label' => __( 'Icon Color', 'blc' ),
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

					'sticky_header_dark_mode_icon_color' => [
						'label' => __( 'Icon Color', 'blc' ),
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

		],
	],

];