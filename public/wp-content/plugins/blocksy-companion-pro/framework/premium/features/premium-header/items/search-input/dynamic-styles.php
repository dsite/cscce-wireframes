<?php

$forms_type =  get_theme_mod('forms_type', 'classic-forms');

$headerSearchBoxMaxWidth = blocksy_akg( 'searchBoxMaxWidth', $atts, 50 );

if ($headerSearchBoxMaxWidth !== 50) {
	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => blocksy_assemble_selector($root_selector),
		'variableName' => 'max-width',
		'value' => $headerSearchBoxMaxWidth,
		'unit' => '%'
	]);

	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => blocksy_assemble_selector(
			blocksy_mutate_selector([
				'selector' => [$root_selector[0]],
				'operation' => 'suffix',
				'to_add' => '[data-middle="search-input"]'
			])
		),
		'variableName' => 'search-box-max-width',
		'value' => $headerSearchBoxMaxWidth,
		'unit' => '%'
	]);
}

$headerSearchBoxHeight = blocksy_akg( 'headerSearchBoxHeight', $atts, 40 );

if ($headerSearchBoxHeight !== 40) {
	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => blocksy_assemble_selector($root_selector),
		'variableName' => 'form-field-height',
		'value' => $headerSearchBoxHeight,
		'unit' => 'px'
	]);
}


// default state
blocksy_output_colors([
	'value' => blocksy_akg('sb_font_color', $atts),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'focus' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,

	'variables' => [
		'default' => [
			'selector' => blocksy_assemble_selector($root_selector),
			'variable' => 'form-text-initial-color'
		],

		'focus' => [
			'selector' => blocksy_assemble_selector($root_selector),
			'variable' => 'form-text-focus-color'
		],
	],
	'responsive' => true
]);

blocksy_output_colors([
	'value' => blocksy_akg('sb_icon_color', $atts),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'focus' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,

	'variables' => [
		'default' => [
			'selector' => blocksy_assemble_selector($root_selector),
			'variable' => 'icon-color'
		],

		'focus' => [
			'selector' => blocksy_assemble_selector($root_selector),
			'variable' => 'icon-focus-color'
		],
	],
	'responsive' => true
]);

blocksy_output_colors([
	'value' => blocksy_akg('sb_border_color', $atts),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'focus' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,

	'variables' => [
		'default' => [
			'selector' => blocksy_assemble_selector($root_selector),
			'variable' => 'form-field-border-initial-color'
		],

		'focus' => [
			'selector' => blocksy_assemble_selector($root_selector),
			'variable' => 'form-field-border-focus-color'
		],
	],
	'responsive' => true
]);


if ($forms_type !== 'classic-forms' || is_customize_preview()) {
	blocksy_output_colors([
		'value' => blocksy_akg('sb_background', $atts),
		'default' => [
			'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword() ],
			'focus' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword() ],
		],
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,

		'variables' => [
			'default' => [
				'selector' => blocksy_assemble_selector($root_selector),
				'variable' => 'form-field-initial-background'
			],

			'focus' => [
				'selector' => blocksy_assemble_selector($root_selector),
				'variable' => 'form-field-focus-background'
			],
		],
		'responsive' => true
	]);
}

// transparent state
if (isset($has_transparent_header) && $has_transparent_header) {
	blocksy_output_colors([
		'value' => blocksy_akg('transparent_sb_font_color', $atts),
		'default' => [
			'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			'focus' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		],
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,

		'variables' => [
			'default' => [
				'selector' => blocksy_assemble_selector(
					blocksy_mutate_selector([
						'selector' => $root_selector,
						'operation' => 'between',
						'to_add' => '[data-transparent-row="yes"]'
					])
				),
				'variable' => 'form-text-initial-color'
			],

			'focus' => [
				'selector' => blocksy_assemble_selector(
					blocksy_mutate_selector([
						'selector' => $root_selector,
						'operation' => 'between',
						'to_add' => '[data-transparent-row="yes"]'
					])
				),
				'variable' => 'form-text-focus-color'
			],
		],
		'responsive' => true
	]);

	blocksy_output_colors([
		'value' => blocksy_akg('transparent_sb_icon_color', $atts),
		'default' => [
			'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			'focus' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		],
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,

		'variables' => [
			'default' => [
				'selector' => blocksy_assemble_selector(
					blocksy_mutate_selector([
						'selector' => $root_selector,
						'operation' => 'between',
						'to_add' => '[data-transparent-row="yes"]'
					])
				),
				'variable' => 'icon-color'
			],

			'focus' => [
				'selector' => blocksy_assemble_selector(
					blocksy_mutate_selector([
						'selector' => $root_selector,
						'operation' => 'between',
						'to_add' => '[data-transparent-row="yes"]'
					])
				),
				'variable' => 'icon-focus-color'
			],
		],
		'responsive' => true
	]);

	blocksy_output_colors([
		'value' => blocksy_akg('transparent_sb_border_color', $atts),
		'default' => [
			'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			'focus' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
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
				'variable' => 'form-field-border-initial-color'
			],

			'focus' => [
				'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'between',
					'to_add' => '[data-transparent-row="yes"]'
				])),
				'variable' => 'form-field-border-focus-color'
			],
		],
		'responsive' => true
	]);

	if ($forms_type !== 'classic-forms' || is_customize_preview()) {
		blocksy_output_colors([
			'value' => blocksy_akg('transparent_sb_background', $atts),
			'default' => [
				'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
				'focus' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
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
					'variable' => 'form-field-initial-background'
				],

				'focus' => [
					'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
						'selector' => $root_selector,
						'operation' => 'between',
						'to_add' => '[data-transparent-row="yes"]'
					])),
					'variable' => 'form-field-focus-background'
				],
			],
			'responsive' => true
		]);
	}
}

// sticky state
if (isset($has_sticky_header) && $has_sticky_header) {
	blocksy_output_colors([
		'value' => blocksy_akg('sticky_sb_font_color', $atts),
		'default' => [
			'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			'focus' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		],
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,

		'variables' => [
			'default' => [
				'selector' => blocksy_assemble_selector(
					blocksy_mutate_selector([
						'selector' => $root_selector,
						'operation' => 'between',
						'to_add' => '[data-sticky*="yes"]'
					])
				),
				'variable' => 'form-text-initial-color'
			],

			'focus' => [
				'selector' => blocksy_assemble_selector(
					blocksy_mutate_selector([
						'selector' => $root_selector,
						'operation' => 'between',
						'to_add' => '[data-sticky*="yes"]'
					])
				),
				'variable' => 'form-text-focus-color'
			],
		],
		'responsive' => true
	]);

	blocksy_output_colors([
		'value' => blocksy_akg('sticky_sb_icon_color', $atts),
		'default' => [
			'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			'focus' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		],
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,

		'variables' => [
			'default' => [
				'selector' => blocksy_assemble_selector(
					blocksy_mutate_selector([
						'selector' => $root_selector,
						'operation' => 'between',
						'to_add' => '[data-sticky*="yes"]'
					])
				),
				'variable' => 'icon-color'
			],

			'focus' => [
				'selector' => blocksy_assemble_selector(
					blocksy_mutate_selector([
						'selector' => $root_selector,
						'operation' => 'between',
						'to_add' => '[data-sticky*="yes"]'
					])
				),
				'variable' => 'icon-focus-color'
			],
		],
		'responsive' => true
	]);

	blocksy_output_colors([
		'value' => blocksy_akg('sticky_sb_border_color', $atts),
		'default' => [
			'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			'focus' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
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
				'variable' => 'form-field-border-initial-color'
			],

			'focus' => [
				'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'between',
					'to_add' => '[data-sticky*="yes"]'
				])),
				'variable' => 'form-field-border-focus-color'
			],
		],
		'responsive' => true
	]);

	if ($forms_type !== 'classic-forms' || is_customize_preview()) {
		blocksy_output_colors([
			'value' => blocksy_akg('sticky_sb_background', $atts),
			'default' => [
				'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
				'focus' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
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
					'variable' => 'form-field-initial-background'
				],

				'focus' => [
					'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
						'selector' => $root_selector,
						'operation' => 'between',
						'to_add' => '[data-sticky*="yes"]'
					])),
					'variable' => 'form-field-focus-background'
				],
			],
			'responsive' => true
		]);
	}
}


if ($forms_type === 'classic-forms' || is_customize_preview()) {
	blocksy_output_spacing([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => blocksy_assemble_selector($root_selector),
		'property' => 'form-field-border-radius',
		'value' => blocksy_default_akg( 'sb_radius', $atts,
			blocksy_spacing_value([
				'linked' => true,
			])
		)
	]);
}

blocksy_output_spacing([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector($root_selector),
	'important' => true,
	'value' => blocksy_default_akg(
		'sb_margin', $atts,
		blocksy_spacing_value([
			'linked' => true,
		])
	)
]);


// Live results
$has_live_results = blocksy_akg( 'enable_live_results', $atts, 'no' );

if ($has_live_results === 'yes') {
	blocksy_output_colors([
		'value' => blocksy_akg('sb_dropdown_text', $atts),
		'default' => [
			'default' => [ 'color' => 'var(--color)' ],
			'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
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
						'to_add' => '.ct-search-results'
					])
				),
				'variable' => 'linkInitialColor'
			],

			'hover' => [
				'selector' => blocksy_assemble_selector(
					blocksy_mutate_selector([
						'selector' => $root_selector,
						'operation' => 'suffix',
						'to_add' => '.ct-search-results'
					])
				),
				'variable' => 'linkHoverColor'
			],
		],

		'responsive' => true
	]);

	blocksy_output_colors([
		'value' => blocksy_akg('sb_dropdown_background', $atts),
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
						'to_add' => '.ct-search-results'
					])
				),
				'variable' => 'search-dropdown-background'
			],
		],

		'responsive' => true
	]);

	blocksy_output_border([
		'css' => $css,
		'selector' => blocksy_assemble_selector(
			blocksy_mutate_selector([
				'selector' => $root_selector,
				'operation' => 'suffix',
				'to_add' => '.ct-search-results'
			])
		),
		'variableName' => 'items-divider',
		'value' => blocksy_akg('sb_dropdown_divider', $atts),
		'default' => [
			'width' => 1,
			'style' => 'dashed',
			'color' => [
				'color' => 'rgba(0, 0, 0, 0.05)',
			],
		]
	]);

	blocksy_output_box_shadow([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => blocksy_assemble_selector(
			blocksy_mutate_selector([
				'selector' => $root_selector,
				'operation' => 'suffix',
				'to_add' => '.ct-search-results'
			])
		),
		'value' => blocksy_akg('sb_dropdown_shadow', $atts, blocksy_box_shadow_value([
			'enable' => true,
			'h_offset' => 0,
			'v_offset' => 50,
			'blur' => 70,
			'spread' => 0,
			'inset' => false,
			'color' => [
				'color' => 'rgba(210, 213, 218, 0.4)',
			],
		])),
		'variableName' => 'search-dropdown-box-shadow',
		'responsive' => true
	]);
}

// footer search box
blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
		'selector' => $root_selector,
		'operation' => 'replace-last',
		'to_add' => '[data-column="search-input"]'
	])),
	'variableName' => 'horizontal-alignment',
	'value' => blocksy_akg( 'footer_search_box_horizontal_alignment', $atts, 'CT_CSS_SKIP_RULE' ),
	'unit' => '',
]);


blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
		'selector' => $root_selector,
		'operation' => 'replace-last',
		'to_add' => '[data-column="search-input"]'
	])),
	'variableName' => 'vertical-alignment',
	'value' => blocksy_akg( 'footer_search_box_vertical_alignment', $atts, 'CT_CSS_SKIP_RULE' ),
	'unit' => '',
]);
