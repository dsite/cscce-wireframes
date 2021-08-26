<?php

if (! function_exists('blocksy_assemble_selector')) {
	return;
}

// Icon size
$icon_size = blocksy_akg('wishlist_icon_size', $atts, 15);

if ($icon_size !== 15) {
	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => blocksy_assemble_selector($root_selector),
		'variableName' => 'icon-size',
		'value' => $icon_size
	]);
}


blocksy_output_font_css([
	'font_value' => blocksy_akg( 'wishlist_label_font', $atts,
		blocksy_typography_default_values([
			'size' => '12px',
			'variation' => 'n6',
			'text-transform' => 'uppercase',
		])
	),
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blc_call_fn([
		'fn' => 'blocksy_assemble_selector',
		'default' => $root_selector
	], blc_call_fn([
		'fn' => 'blocksy_mutate_selector',
	], [
		'selector' => [$root_selector[0]],
		'operation' => 'suffix',
		'to_add' => '.ct-header-wishlist .ct-label'
	])),
]);


// Margin
blocksy_output_spacing([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector($root_selector),
	'important' => true,
	'value' => blocksy_default_akg(
		'header_wishlist_margin', $atts,
		blocksy_spacing_value([
			'linked' => true,
		])
	)
]);


// default state
blocksy_output_colors([
	'value' => blocksy_akg('header_wishlist_font_color', $atts),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'variables' => [
		'default' => [
			'selector' => blocksy_assemble_selector($root_selector),
			'variable' => 'linkInitialColor'
		],

		'hover' => [
			'selector' => blocksy_assemble_selector($root_selector),
			'variable' => 'linkHoverColor'
		],
	],
	'responsive' => true
]);

blocksy_output_colors([
	'value' => blocksy_akg('header_wishlist_icon_color', $atts),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'variables' => [
		'default' => [
			'selector' => blocksy_assemble_selector($root_selector),
			'variable' => 'icon-color'
		],

		'hover' => [
			'selector' => blocksy_assemble_selector($root_selector),
			'variable' => 'icon-hover-color'
		],
	],
	'responsive' => true
]);

blocksy_output_colors([
	'value' => blocksy_akg('header_wishlist_badge_color', $atts),
	'default' => [
		'background' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'text' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'variables' => [
		'background' => [
			'selector' => blocksy_assemble_selector($root_selector),
			'variable' => 'cartBadgeBackground'
		],

		'text' => [
			'selector' => blocksy_assemble_selector($root_selector),
			'variable' => 'cartBadgeText'
		],
	],
	'responsive' => true
]);


// transparent state
if (isset($has_transparent_header) && $has_transparent_header) {

	blocksy_output_colors([
		'value' => blocksy_akg('transparent_header_wishlist_font_color', $atts),
		'default' => [
			'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		],
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,

		'variables' => [
			'default' => [
				'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'between',
					'to_add' => '[data-transparent-row="yes"]'
				])),
				'variable' => 'linkInitialColor'
			],

			'hover' => [
				'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'between',
					'to_add' => '[data-transparent-row="yes"]'
				])),
				'variable' => 'linkHoverColor'
			],
		],
		'responsive' => true
	]);

	blocksy_output_colors([
		'value' => blocksy_akg('transparent_header_wishlist_icon_color', $atts),
		'default' => [
			'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		],
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,

		'variables' => [
			'default' => [
				'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'between',
					'to_add' => '[data-transparent-row="yes"]'
				])),
				'variable' => 'icon-color'
			],

			'hover' => [
				'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'between',
					'to_add' => '[data-transparent-row="yes"]'
				])),
				'variable' => 'icon-hover-color'
			],
		],
		'responsive' => true
	]);

	blocksy_output_colors([
		'value' => blocksy_akg('transparent_header_wishlist_badge_color', $atts),
		'default' => [
			'background' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			'text' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		],
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,

		'variables' => [
			'background' => [
				'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'between',
					'to_add' => '[data-transparent-row="yes"]'
				])),
				'variable' => 'cartBadgeBackground'
			],

			'text' => [
				'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'between',
					'to_add' => '[data-transparent-row="yes"]'
				])),
				'variable' => 'cartBadgeText'
			],
		],
		'responsive' => true
	]);
}


// sticky state
if (isset($has_sticky_header) && $has_sticky_header) {

	blocksy_output_colors([
		'value' => blocksy_akg('sticky_header_wishlist_font_color', $atts),
		'default' => [
			'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		],
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,

		'variables' => [
			'default' => [
				'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'between',
					'to_add' => '[data-sticky*="yes"]'
				])),
				'variable' => 'linkInitialColor'
			],

			'hover' => [
				'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'between',
					'to_add' => '[data-sticky*="yes"]'
				])),
				'variable' => 'linkHoverColor'
			],
		],
		'responsive' => true
	]);

	blocksy_output_colors([
		'value' => blocksy_akg('sticky_header_wishlist_icon_color', $atts),
		'default' => [
			'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		],
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,

		'variables' => [
			'default' => [
				'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'between',
					'to_add' => '[data-sticky*="yes"]'
				])),
				'variable' => 'icon-color'
			],

			'hover' => [
				'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'between',
					'to_add' => '[data-sticky*="yes"]'
				])),
				'variable' => 'icon-hover-color'
			],
		],
		'responsive' => true
	]);

	blocksy_output_colors([
		'value' => blocksy_akg('sticky_header_wishlist_badge_color', $atts),
		'default' => [
			'background' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			'text' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		],
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,

		'variables' => [
			'background' => [
				'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'between',
					'to_add' => '[data-sticky*="yes"]'
				])),
				'variable' => 'cartBadgeBackground'
			],

			'text' => [
				'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'between',
					'to_add' => '[data-sticky*="yes"]'
				])),
				'variable' => 'cartBadgeText'
			],
		],
		'responsive' => true
	]);
}