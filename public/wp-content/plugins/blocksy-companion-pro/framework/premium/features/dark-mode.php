<?php

namespace Blocksy;

class DarkMode {
	public function __construct() {
		add_filter('blocksy:options:colors:palette:after', function ($options) {
			$options['darkColorPalette'] = [
				'label' => __( 'Dark Mode Color Palette', 'blocksy' ),
				'type'  => 'ct-color-palettes-picker',
				'divider' => 'top',
				'predefined' => true,
				'wrapperAttr' => [
					'data-type' => 'color-palette',
					'data-label' => 'heading-label'
				],

				'value' => [
					'color1' => [
						'color' => '#006466',
					],

					'color2' => [
						'color' => '#065A60',
					],

					'color3' => [
						'color' => '#7F8C9A',
					],

					'color4' => [
						'color' => '#ffffff',
					],

					'color5' => [
						'color' => '#0E141B',
					],

					'color6' => [
						'color' => '#141b22',
					],

					'color7' => [
						'color' => '#1B242C',
					],
				],

				'sync' => 'live'
			];

			return $options;
		});
	}
}
