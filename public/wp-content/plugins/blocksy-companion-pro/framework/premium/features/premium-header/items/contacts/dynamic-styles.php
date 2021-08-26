<?php

// Margin
blocksy_output_spacing([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector($root_selector),
	'important' => true,
	'value' => blocksy_default_akg(
		'contacts_margin', $atts,
		blocksy_spacing_value([
			'linked' => true,
		])
	)
]);

$contacts_icon_size = blocksy_akg( 'contacts_icon_size', $atts, 15 );

if ($contacts_icon_size !== 15) {
	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => blocksy_assemble_selector($root_selector),
		'variableName' => 'icon-size',
		'value' => $contacts_icon_size,
		'responsive' => true
	]);
}

$contacts_spacing = blocksy_akg( 'contacts_spacing', $atts, 15 );

if ($contacts_spacing !== 15) {
	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => blocksy_assemble_selector($root_selector),
		'variableName' => 'items-spacing',
		'value' => $contacts_spacing,
		'responsive' => true
	]);
}

blocksy_output_font_css([
	'font_value' => blocksy_akg( 'contacts_font', $atts,
		blocksy_typography_default_values([
			'size' => '13px',
			'line-height' => '1.3',
		])
	),
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blocksy_assemble_selector(
		blocksy_mutate_selector([
			'selector' => $root_selector,
			'operation' => 'suffix',
			'to_add' => '.contact-info'
		])
	),
]);


// default state
blocksy_output_colors([
	'value' => blocksy_akg('contacts_font_color', $atts),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'link_initial' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'link_hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
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
					'to_add' => '.contact-info'
				])
			),
			'variable' => 'color'
		],

		'link_initial' => [
			'selector' => blocksy_assemble_selector(
				blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'suffix',
					'to_add' => '.contact-info'
				])
			),
			'variable' => 'linkInitialColor'
		],

		'link_hover' => [
			'selector' => blocksy_assemble_selector(
				blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'suffix',
					'to_add' => '.contact-info'
				])
			),
			'variable' => 'linkHoverColor'
		],
	],
	'responsive' => true
]);

blocksy_output_colors([
	'value' => blocksy_akg('contacts_icon_color', $atts),
	'default' => [
		'default' => [ 'color' => 'var(--color)' ],
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
		]
	],

	'responsive' => true
]);

blocksy_output_colors([
	'value' => blocksy_akg('contacts_icon_background', $atts),
	'default' => [
		'default' => [ 'color' => 'rgba(218, 222, 228, 0.5)' ],
		'hover' => [ 'color' => 'rgba(218, 222, 228, 0.7)' ],
	],
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,

	'variables' => [
		'default' => [
			'selector' => blocksy_assemble_selector($root_selector),
			'variable' => 'background-color'
		],

		'hover' => [
			'selector' => blocksy_assemble_selector($root_selector),
			'variable' => 'background-hover-color'
		]
	],
	'responsive' => true
]);


// transparent state
if (isset($has_transparent_header) && $has_transparent_header) {
	blocksy_output_colors([
		'value' => blocksy_akg('transparent_contacts_font_color', $atts),
		'default' => [
			'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			'link_initial' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			'link_hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		],
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,

		'variables' => [
			'default' => [
				'selector' => blocksy_assemble_selector(
					blocksy_mutate_selector([
						'selector' => blocksy_mutate_selector([
							'selector' => $root_selector,
							'operation' => 'suffix',
							'to_add' => '.contact-info'
						]),
						'operation' => 'between',
						'to_add' => '[data-transparent-row="yes"]'
					])
				),
				'variable' => 'color'
			],

			'link_initial' => [
				'selector' => blocksy_assemble_selector(
					blocksy_mutate_selector([
						'selector' => blocksy_mutate_selector([
							'selector' => $root_selector,
							'operation' => 'suffix',
							'to_add' => '.contact-info'
						]),
						'operation' => 'between',
						'to_add' => '[data-transparent-row="yes"]'
					])
				),
				'variable' => 'linkInitialColor'
			],

			'link_hover' => [
				'selector' => blocksy_assemble_selector(
					blocksy_mutate_selector([
						'selector' => blocksy_mutate_selector([
							'selector' => $root_selector,
							'operation' => 'suffix',
							'to_add' => '.contact-info'
						]),
						'operation' => 'between',
						'to_add' => '[data-transparent-row="yes"]'
					])
				),
				'variable' => 'linkHoverColor'
			],
		],
		'responsive' => true
	]);

	blocksy_output_colors([
		'value' => blocksy_akg('transparent_contacts_icon_color', $atts),
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
		'value' => blocksy_akg('transparent_contacts_icon_background', $atts),
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
				'variable' => 'background-color'
			],

			'hover' => [
				'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'between',
					'to_add' => '[data-transparent-row="yes"]'
				])),
				'variable' => 'background-hover-color'
			],
		],
		'responsive' => true
	]);
}


// sticky state
if (isset($has_sticky_header) && $has_sticky_header) {
	blocksy_output_colors([
		'value' => blocksy_akg('sticky_contacts_font_color', $atts),
		'default' => [
			'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			'link_initial' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			'link_hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		],
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,

		'variables' => [
			'default' => [
				'selector' => blocksy_assemble_selector(
					blocksy_mutate_selector([
						'selector' => blocksy_mutate_selector([
							'selector' => $root_selector,
							'operation' => 'suffix',
							'to_add' => '.contact-info'
						]),
						'operation' => 'between',
						'to_add' => '[data-sticky*="yes"]'
					])
				),
				'variable' => 'color'
			],

			'link_initial' => [
				'selector' => blocksy_assemble_selector(
					blocksy_mutate_selector([
						'selector' => blocksy_mutate_selector([
							'selector' => $root_selector,
							'operation' => 'suffix',
							'to_add' => '.contact-info'
						]),
						'operation' => 'between',
						'to_add' => '[data-sticky*="yes"]'
					])
				),
				'variable' => 'linkInitialColor'
			],

			'link_hover' => [
				'selector' => blocksy_assemble_selector(
					blocksy_mutate_selector([
						'selector' => blocksy_mutate_selector([
							'selector' => $root_selector,
							'operation' => 'suffix',
							'to_add' => '.contact-info'
						]),
						'operation' => 'between',
						'to_add' => '[data-sticky*="yes"]'
					])
				),
				'variable' => 'linkHoverColor'
			],
		],
		'responsive' => true
	]);

	blocksy_output_colors([
		'value' => blocksy_akg('sticky_contacts_icon_color', $atts),
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
		'value' => blocksy_akg('sticky_contacts_icon_background', $atts),
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
				'variable' => 'background-color'
			],

			'hover' => [
				'selector' => blocksy_assemble_selector(blocksy_mutate_selector([
					'selector' => $root_selector,
					'operation' => 'between',
					'to_add' => '[data-sticky*="yes"]'
				])),
				'variable' => 'background-hover-color'
			],
		],
		'responsive' => true
	]);
}
