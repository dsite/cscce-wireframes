<?php

$type = get_theme_mod('shortcuts_bar_type', 'type-1');

// Container height
$container_height = get_theme_mod('shortcuts_container_height', 70);

blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ':root',
	'variableName' => 'shortcuts-container-height',
	'value' => $container_height
]);

// Container max width
$container_width = get_theme_mod('shortcuts_container_width', '100%');

if ($container_width !== '100%') {
	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => ':root',
		'variableName' => 'shortcuts-container-width',
		'value' => $container_width,
		'unit' => ''
	]);
}

// Icon size
$icon_size = get_theme_mod('shortcuts_icon_size', 15);

if ($icon_size !== 15) {
	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => '.ct-shortcuts-container',
		'variableName' => 'icon-size',
		'value' => $icon_size
	]);
}

blc_call_fn(['fn' => 'blocksy_output_font_css'], [
	'font_value' => get_theme_mod( 'shortcuts_font',
		blocksy_typography_default_values([
			'size' => '12px',
			'variation' => 'n5',
			'text-transform' => 'uppercase',
		])
	),
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '.ct-shortcuts-container',
]);

blc_call_fn(['fn' => 'blocksy_output_colors'], [
	'value' => get_theme_mod('shortcuts_font_color'),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'variables' => [
		'default' => [
			'selector' => '.ct-shortcuts-container a',
			'variable' => 'linkInitialColor'
		],

		'hover' => [
			'selector' => '.ct-shortcuts-container a',
			'variable' => 'linkHoverColor'
		],
	],
	'responsive' => true,
]);

blc_call_fn(['fn' => 'blocksy_output_colors'], [
	'value' => get_theme_mod('shortcuts_icon_color'),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'variables' => [
		'default' => [
			'selector' => '.ct-shortcuts-container',
			'variable' => 'icon-color'
		],

		'hover' => [
			'selector' => '.ct-shortcuts-container',
			'variable' => 'icon-hover-color'
		],
	],
	'responsive' => true,
]);

blc_call_fn(['fn' => 'blocksy_output_border'], [
	'css' => $css,
	'selector' => '.ct-shortcuts-container',
	'variableName' => 'shortcuts-divider',
	'value' => get_theme_mod('shortcuts_divider'),
	'skip_none' => true,
	'default' => [
		'width' => 1,
		'style' => 'dashed',
		'color' => [
			'color' => 'var(--paletteColor5)',
		],
	],
]);

$divider_height = get_theme_mod( 'shortcuts_divider_height', 40 );

$divider_style = get_theme_mod('shortcuts_divider', [
	'width' => 1,
	'style' => 'dashed',
	'color' => [
		'color' => 'var(--paletteColor5)',
	],
]);

if (
	(
		$divider_height !== 40
		&&
		is_array($divider_style)
		&&
		isset($divider_style['style'])
		&&
		$divider_style['style'] !== 'none'
	) || is_customize_preview()
) {

	$css->put(
		'.ct-shortcuts-container',
		'--shortcuts-divider-height: ' . $divider_height . '%'
	);
}

blc_call_fn(['fn' => 'blocksy_output_background_css'], [
	'selector' => '.ct-shortcuts-container',
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'value' => get_theme_mod(
		'shortcuts_container_background',
		blc_call_fn([
			'fn' => 'blocksy_background_default_value',
			'default' => null
		], [
			'backgroundColor' => [
				'default' => [
					'color' => 'var(--paletteColor8)'
				],
			],
		])
	),
	'responsive' => true,
]);

blc_call_fn(['fn' => 'blocksy_output_box_shadow'], [
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '.ct-shortcuts-container',
	'should_skip_output' => false,
	'value' => get_theme_mod(
		'shortcuts_container_shadow',
		blc_call_fn(['fn' => 'blocksy_box_shadow_value'], [
			'enable' => true,
			'h_offset' => 0,
			'v_offset' => -10,
			'blur' => 20,
			'spread' => 0,
			'inset' => false,
			'color' => [
				'color' => 'rgba(44,62,80,0.04)',
			],
		])
	),
	'responsive' => true
]);

if ($type === 'type-2') {
	blc_call_fn(['fn' => 'blocksy_output_spacing'], [
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => '.ct-shortcuts-container',
		'property' => 'border-radius',
		'value' => get_theme_mod(
			'shortcuts_container_border_radius',
			blocksy_spacing_value([
				'linked' => true,
				'top' => '7px',
				'left' => '7px',
				'right' => '7px',
				'bottom' => '7px',
			])
		)
	]);
}
