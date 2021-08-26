<?php

if (! function_exists('blocksy_assemble_selector')) {
	return;
}

$has_mega_menu = blocksy_akg('has_mega_menu', $atts, 'no' );
$mega_menu_width = blocksy_akg('mega_menu_width', $atts, 'custom' );

blocksy_output_colors([
	'value' => blocksy_akg('menu_items_text', $atts),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'important' => true,

	'variables' => [
		'default' => [
			'selector' => blocksy_assemble_selector(
				blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'container-suffix',
					'to_add' => '[class*="ct-mega-menu"] .sub-menu'
				])
			),
			'variable' => 'color'
		],
	],
]);

// column
blocksy_output_spacing([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector($root_selector),
	'property' => 'columns-padding',
	'value' => blocksy_default_akg(
		'menu_column_padding', $atts,
		blocksy_spacing_value([
			'linked' => true,
		])
	)
]);

// heading
blocksy_output_colors([
	'value' => blocksy_akg('menu_items_heading', $atts),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,

	'variables' => [
		'default' => [
			'selector' => blocksy_assemble_selector(
				blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'container-suffix',
					'to_add' => '[class*="ct-mega-menu"] .ct-column-heading'
				])
			),
			'variable' => 'headings-color'
		],
	],
]);

blocksy_output_colors([
	'value' => blocksy_akg('menu_item_heading', $atts),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'important' => true,

	'variables' => [
		'default' => [
			'selector' => blocksy_assemble_selector(
				blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'suffix',
					'to_add' => '> .ct-column-heading'
				])
			),
			'variable' => 'headings-color'
		],
	],
]);

blocksy_output_colors([
	'value' => blocksy_akg('menu_items_links', $atts),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'bg_hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'important' => true,

	'variables' => [
		'default' => [
			'selector' => blocksy_assemble_selector(
				blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'container-suffix',
					'to_add' => '[class*="ct-mega-menu"] .sub-menu'
				])
			),
			'variable' => 'linkInitialColor'
		],

		'hover' => [
			'selector' => blocksy_assemble_selector(
				blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'container-suffix',
					'to_add' => '[class*="ct-mega-menu"] .sub-menu'
				])
			),
			'variable' => 'linkHoverColor'
		],

		'bg_hover' => [
			'selector' => blocksy_assemble_selector(
				blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'container-suffix',
					'to_add' => '[class*="ct-mega-menu"] .sub-menu'
				])
			),
			'variable' => 'dropdown-background-hover-color'
		],
	],
]);

blocksy_output_background_css([
	'selector' => blocksy_assemble_selector(
		blocksy_mutate_selector([
			'selector' => $root_selector,
			'operation' => 'container-suffix',
			'to_add' => '[class*="ct-mega-menu"] > .sub-menu'
		])
	),
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'value' => blocksy_akg('mega_menu_background', $atts,
		blocksy_background_default_value([
			'backgroundColor' => [
				'default' => [
					'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT')
				],
			],
		])
	)
]);

// shadow
blocksy_output_box_shadow([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector(
		blocksy_mutate_selector([
			'selector' => $root_selector,
			'operation' => 'container-suffix',
			'to_add' => '[class*="ct-mega-menu"] > .sub-menu'
		])
	),
	'important' => true,
	'value' => blocksy_akg('mega_menu_shadow', $atts, blocksy_box_shadow_value([
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
	])),
]);

// divider
$mega_menu_columns_divider_default = [
	'inherit' => true,
	'width' => 1,
	'style' => 'dashed',
	'color' => [
		'color' => 'rgba(255, 255, 255, 0.1)',
	]
];

$mega_menu_items_divider = blocksy_akg(
	'mega_menu_items_divider',
	$atts,
	$mega_menu_columns_divider_default
);

blocksy_output_border([
	'css' => $css,
	'selector' => blocksy_assemble_selector(
		blocksy_mutate_selector([
			'selector' => $root_selector,
			'operation' => 'container-suffix',
			'to_add' => '[class*="ct-mega-menu"] .sub-menu'
		])
	),
	'variableName' => 'dropdown-divider',
	'important' => true,
	'value' => $mega_menu_items_divider,
	'default' => $mega_menu_columns_divider_default
]);

if ($mega_menu_items_divider['style'] === 'none') {
	$css->put(
		blocksy_assemble_selector(
			blocksy_mutate_selector([
				'selector' => $root_selector,
				'operation' => 'container-suffix',
				'to_add' => '[class*="ct-mega-menu"] .sub-menu'
			])
		),
		'--dropdown-divider-margin: 0px'
	);
} else {
	if (! $mega_menu_items_divider['inherit']) {
		$css->put(
			blocksy_assemble_selector(
				blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'container-suffix',
					'to_add' => '[class*="ct-mega-menu"] .sub-menu'
				])
			),
			'--dropdown-divider-margin: calc(var(--dropdown-items-spacing, 13px) - 3px)'
		);
	}
}


if ($has_mega_menu !== 'no') {
	blocksy_output_border([
		'css' => $css,
		'selector' => blocksy_assemble_selector(
			blocksy_mutate_selector([
				'selector' => $root_selector,
				'operation' => 'container-suffix',
				'to_add' => '[class*="ct-mega-menu"] > .sub-menu'
			])
		),
		'variableName' => 'dropdown-columns-divider',
		'value' => blocksy_akg('mega_menu_columns_divider', $atts),
		'default' => [
			// 'inherit' => true,
			'width' => 1,
			'style' => 'solid',
			'color' => [
				'color' => 'rgba(255, 255, 255, 0.1)',
			],
		]
	]);
}

// icon
$menu_item_icon_size = blocksy_akg( 'menu_item_icon_size', $atts, 20 );

if ($menu_item_icon_size !== 20) {
	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => blocksy_assemble_selector($root_selector),
		'variableName' => 'icon-size',
		'value' => $menu_item_icon_size,
	]);
}

blocksy_output_colors([
	'value' => blocksy_akg('menu_item_icon_color', $atts),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'active' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
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

		'active' => [
			'selector' => blocksy_assemble_selector($root_selector),
			'variable' => 'icon-active-color'
		],
	],
]);


// badge
$menu_badge_vertical_alignment = blocksy_akg( 'menu_badge_vertical_alignment', $atts, 0 );

if ($menu_badge_vertical_alignment !== 0) {
	$css->put(
		blocksy_assemble_selector(
			blocksy_mutate_selector([
				'selector' => $root_selector,
				'operation' => 'suffix',
				'to_add' => '.ct-menu-badge'
			])
		),
		'--margin-top: ' . $menu_badge_vertical_alignment . 'px'
	);
}

$has_menu_badge = blocksy_akg( 'has_menu_badge', $atts, 'no' );

if ($has_menu_badge !== 'no' ) {
	blocksy_output_colors([
		'value' => blocksy_akg('menu_badge_font_color', $atts),
		'default' => [
			'default' => [ 'color' => '#ffffff' ],
		],
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,

		'variables' => [
			'default' => [
				'selector' => blocksy_assemble_selector(
					blocksy_mutate_selector([
						'selector' => $root_selector,
						'operation' => 'suffix',
						'to_add' => '.ct-menu-badge'
					])
				),
				'variable' => 'color'
			],
		],
	]);

	blocksy_output_colors([
		'value' => blocksy_akg('menu_badge_background', $atts),
		'default' => [
			'default' => [ 'color' => 'var(--paletteColor1)' ],
		],
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,

		'variables' => [
			'default' => [
				'selector' => blocksy_assemble_selector(
					blocksy_mutate_selector([
						'selector' => $root_selector,
						'operation' => 'suffix',
						'to_add' => '.ct-menu-badge'
					])
				),
				'variable' => 'background-color'
			],
		],
	]);
}


$mega_menu_columns = blocksy_akg('mega_menu_columns', $atts, '4');

if (
	$has_mega_menu === 'yes'
	&&
	intval($mega_menu_columns) !== 1
) {
	$css->put(
		blocksy_assemble_selector(
			blocksy_mutate_selector([
				'selector' => $root_selector,
				'operation' => 'container-suffix',
				'to_add' => '[class*="ct-mega-menu"] > .sub-menu'
			])
		),
		'--grid-template-columns: ' . blocksy_akg(
			$mega_menu_columns . '_columns_layout',
			$atts,
			'repeat(' . $mega_menu_columns . ', 1fr)'
		)
	);
}


// custom width
if ($has_mega_menu !== 'no' && $mega_menu_width === 'custom') {
	$css->put(
		blocksy_assemble_selector(
			blocksy_mutate_selector([
				'selector' => $root_selector,
				'operation' => 'container-suffix',
				'to_add' => '.ct-mega-menu-custom-width .sub-menu'
			])
		),
		'--mega-menu-max-width: ' . blocksy_akg( 'mega_menu_custom_width', $atts, '400px' )
	);
}
