<?php

class BlocksyExtensionCustomFonts {
	private $option_name = 'blocksy_ext_custom_fonts_settings';

	public function __construct() {
		add_action('wp_ajax_blocksy_get_custom_fonts_settings', function () {
			if (! current_user_can('manage_options')) {
				wp_send_json_error();
			}

			wp_send_json_success([
				'settings' => [
					'fonts' => $this->get_normalized_fonts_list()
				]
			]);
		});

		add_action('wp_ajax_blocksy_update_custom_fonts_settings', function () {
			if (! current_user_can('manage_options')) {
				wp_send_json_error();
			}

			$data = json_decode(
				file_get_contents('php://input'),
				true
			);

			if (! $data) {
				wp_send_json_error();
			}

			$this->set_settings($data);

			wp_send_json_success([
				'settings' => [
					'fonts' => $this->get_normalized_fonts_list()
				]
			]);
		});

		add_filter('blocksy_typography_font_sources', function ($sources) {
			$font_families = [];
			$fonts = $this->get_normalized_fonts_list();

			if (! isset($fonts)) {
				return $sources;
			}

			foreach ($fonts as $single_family) {
				if (! is_array($single_family['variations'])) {
					continue;
				}

				if (count($single_family['variations']) === 0) {
					continue;
				}

				$all_variations= array_map(function ($variation) {
					return $variation['variation'];
				}, $single_family['variations']);

				if (
					isset($single_family['fontType'])
					&&
					$single_family['fontType'] === 'variable'
				) {
					$all_variations = $this->get_all_variations(
						!! $single_family['variations'][1]['url']
					);
				}

				$font_families[] = [
					'family' => $this->get_family_for_name($single_family['name']),
					'display' => $single_family['name'],
					'source' => 'file',
					'variations' => [],
					'all_variations' => $all_variations
				];
			}

			$sources['file'] = [
				'type' => 'file',
				'families' => $font_families
			];

			return $sources;
		});

		add_filter('wp_check_filetype_and_ext', function ($types, $file, $filename, $mimes) {
			if (false !== strpos($filename, '.woff2')) {
				$types['ext'] = 'woff2';
				$types['type'] = 'font/woff2|application/octet-stream|font/x-woff2';
			}

			if (false !== strpos($filename, '.ttf')) {
				$types['ext'] = 'ttf';
				$types['type'] = 'application/x-font-ttf';
			}

			return $types;
		}, 10, 4);

		add_filter('upload_mimes', function ($mimes) {
			$mimes['woff2'] = 'font/woff2|application/octet-stream|font/x-woff2';
			$mimes['ttf'] = 'application/x-font-ttf';

			return $mimes;
		});

		add_action('blocksy:global-dynamic-css:enqueue', function ($args) {
			$typography = new \Blocksy_Fonts_Manager();

			if (blocksy_dynamic_styles_should_call(
				array_merge([
					'chunk' => 'global'
				], $args)
			)) {
				$font_faces = $this->get_font_faces_for();

				if (! empty($font_faces)) {
					$args['css']->put(
						\Blocksy_Css_Injector::get_inline_keyword(),
						$font_faces
					);
				}
			}
		});

		add_action('blocksy:admin-dynamic-css:enqueue', function ($args) {
			$font_faces = $this->get_all_primary_font_faces_for();

			if (! empty($font_faces)) {
				$args['css']->put(
					\Blocksy_Css_Injector::get_inline_keyword(),
					$font_faces
				);
			}
		});

		add_filter('elementor/fonts/groups', function ($font_groups) {
			$font_groups['blocksy-custom-fonts'] = __('Custom Fonts', 'blc');
			return $font_groups;
		});

		add_filter('elementor/fonts/additional_fonts', function ($fonts) {
			$settings = $this->get_settings();

			foreach ($settings['fonts'] as $family) {
				if (empty($family['variations'])) {
					continue;
				}

				$fonts[$this->get_family_for_name($family['name'])] = 'blocksy-custom-fonts';
			}

			return $fonts;
		});
	}

	private function get_all_primary_font_faces_for() {
		$fonts = $this->get_normalized_fonts_list();

		$font_faces = '';

		foreach ($fonts as $family) {
			if (empty($family['variations'])) {
				continue;
			}

			$variation = $family['variations'][0];

			foreach ($family['variations'] as $single_variation) {
				if ($single_variation['variation'] === 'n4') {
					$variation = $single_variation;
				}
			}

			if (empty($variation['url'])) {
				continue;
			}

			$format = $this->get_format_for_url($variation['url']);

			$font_faces .= '@font-face {';
			$font_faces .= 'font-family: ' . $this->get_family_for_name($family['name']) . ';';
			$font_faces .= 'font-display: swap;';
			$font_faces .= "src: url('" . $variation['url'] . "') format('" . $format . "');";
			$font_faces .= '}';
		}

		return $font_faces;
	}

	private function get_format_for_url($s) {
		$map = [
			'woff2' => 'woff2',
			'ttf' => 'truetype'
		];

		$n = strrpos($s,".");
		$ext = ($n===false) ? "" : substr($s,$n+1);

		if (! isset($map[$ext])) {
			return $ext;
		}

		return $map[$ext];
	}

	private function get_font_faces_for() {
		$to_enqueue = [];

		$fonts = $this->get_normalized_fonts_list();

		foreach ($fonts as $single_font) {
			$single_family = $this->get_family_for_name($single_font['name']);

			foreach ($single_font['variations'] as $single_variation) {
				if (! isset($to_enqueue[$single_family])) {
					$to_enqueue[$single_family] = [$single_variation['variation']];
				} else {
					$to_enqueue[$single_family][] = $single_variation['variation'];
				}
			}
		}

		if (empty($to_enqueue)) {
			return '';
		}

		$font_faces = '';

		foreach ($to_enqueue as $family => $variations) {
			$family_descriptor = $this->get_family_descriptor($family);

			if (
				isset($family_descriptor['fontType'])
				&&
				$family_descriptor['fontType'] === 'variable'
			) {
				$font_faces .= $this->get_variable_font_face($family_descriptor);
				continue;
			}

			foreach ($variations as $variation) {
				$variation_descriptor = $this->get_variation_descriptor(
					$family, $variation
				);

				if (! $variation_descriptor) {
					continue;
				}

				$url = $variation_descriptor['url'];

				if (empty($url)) {
					continue;
				}

				$variation_css = blocksy_get_css_for_variation($variation);
				$format = $this->get_format_for_url($url);

				$font_faces .= '@font-face {';
				$font_faces .= 'font-family: ' . $family . ';';
				$font_faces .= "font-style: " . $variation_css['style'] . ";";
				$font_faces .= "font-weight: " . $variation_css['weight'] . ";";
				$font_faces .= "font-display: swap;";
				$font_faces .= "src: url('" . $url . "') format('" . $format . "');";
				$font_faces .= '}';
			}
		}

		return $font_faces;
	}

	public function get_variable_font_face($family_descriptor) {
		$regular_url = $family_descriptor['variations'][0]['url'];
		$italic_url = $family_descriptor['variations'][1]['url'];

		if (empty($regular_url)) {
			return '';
		}

		$font_face = '';

		$format = $this->get_format_for_url($regular_url);

		$font_face .= '@font-face {';
		$font_face .= 'font-family: ' . $this->get_family_for_name($family_descriptor['name']) . ';';
		$font_face .= "font-style: normal;";
		$font_face .= "font-weight: 100 900;";
		$font_face .= "font-display: swap;";
		$font_face .= "src: url('" . $regular_url . "') format('" . $format . "');";
		$font_face .= '}';

		if (! empty($italic_url)) {
			$format = $this->get_format_for_url($italic_url);
			$font_face .= '@font-face {';
			$font_face .= 'font-family: ' . $this->get_family_for_name($family_descriptor['name']) . ';';
			$font_face .= "font-style: italic;";
			$font_face .= "font-weight: 100 900;";
			$font_face .= "font-display: swap;";
			$font_face .= "src: url('" . $italic_url . "') format('" . $format . "');";
			$font_face .= '}';
		}

		return $font_face;
	}

	public function get_family_descriptor($family) {
		$fonts = $this->get_normalized_fonts_list();

		foreach ($fonts as $font_descriptor) {
			if (
				strtolower(
					str_replace(
						' ',
						'',
						$font_descriptor['name']
					)
				) !== strtolower(
					str_replace(
						' ',
						'',
						str_replace(
							'_', '',
							str_replace(
								'ct_font_',
								'',
								$family
							)
						)
					)
				)
			) {
				continue;
			}

			return $font_descriptor;
		}

		return null;
	}

	public function get_variation_descriptor($family, $variation) {
		$fonts = $this->get_normalized_fonts_list();

		foreach ($fonts as $font_descriptor) {
			if (
				strtolower(
					str_replace(
						' ',
						'',
						$font_descriptor['name']
					)
				) !== strtolower(
					str_replace(
						' ',
						'',
						str_replace(
							'_', '',
							str_replace(
								'ct_font_',
								'',
								$family
							)
						)
					)
				)
			) {
				continue;
			}

			foreach ($font_descriptor['variations'] as $variation_descriptor) {
				if ($variation !== $variation_descriptor['variation']) {
					continue;
				}

				return $variation_descriptor;
			}
		}

		return null;
	}

	public function get_settings() {
		$custom_fonts = apply_filters('blocksy_ext_custom_fonts:dynamic_fonts', []);

		$result = get_option($this->option_name, [
			'fonts' => [
                /*
				[
					'name' => 'ProximaNova',
					'variations' => [
						[
							'variation' => 'n4',
							'attachment_id' => 2828,
						],

						[
							'variation' => 'n7',
							'attachment_id' => 2829,
						]
					]
				]
                 */
			]
		]);

		foreach ($custom_fonts as $index => $custom_font) {
			$custom_fonts[$index]['__custom'] = true;
			$result['fonts'][] = $custom_fonts[$index];
		}

		return $result;
	}

	private function get_all_variations($has_italic = true) {
		if ($has_italic) {
			return [
				'n1', 'i1', 'n2',
				'i2', 'n3', 'i3',
				'n4', 'i4', 'n5',
				'i5', 'n6', 'i6',
				'n7', 'i7', 'n8',
				'i8', 'n9', 'i9',
			];
		}

		return [
			'n1', 'n2', 'n3',
			'n4', 'n5', 'n6',
			'n7', 'n8', 'n9'
		];
	}

	public function set_settings($value) {
		$fonts = [];

		foreach ($value['fonts'] as $font) {
			if (! isset($font['__custom'])) {
				$fonts[] = $font;
			}
		}

		update_option($this->option_name, [
			'fonts' => $fonts
		]);
	}

	public function get_normalized_fonts_list() {
		$settings = $this->get_settings();

		$fonts = [];

		foreach ($settings['fonts'] as $font) {
			foreach ($font['variations'] as $variation_index => $variation) {
				if (
					isset($variation['attachment_id'])
					&&
					! isset($variation['url'])
				) {
					$font['variations'][$variation_index]['url'] = wp_get_attachment_url(
						$variation['attachment_id']
					);
				} else {
					if (empty(
						$font['variations'][$variation_index]['url']
					)) {
						$font['variations'][$variation_index]['url'] = '';
					}
				}
			}

			$fonts[] = $font;
		}

		return $fonts;
	}

	private function get_family_for_name($name) {
		return str_replace(' ', '_', 'ct_font_' . strtolower(
			preg_replace('/(?<!^)[A-Z]/', '_$0', $name)
		));
	}
}

