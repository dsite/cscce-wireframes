<?php

$class = 'ct-language-switcher';

if ($panel_type === 'header') {
	$visibility = blocksy_default_akg('visibility', $atts, [
		'tablet' => true,
		'mobile' => true,
	]);
} else {
	$visibility = blocksy_default_akg('footer_visibility', $atts, [
		'desktop' => true,
		'tablet' => true,
		'mobile' => true,
	]);
}

$class .= ' ' . blocksy_visibility_classes($visibility);

$language_type = blocksy_default_akg(
	'language_type',
	$atts,
	[
		'icon' => true,
		'label' => true,
	]
);

$language_label = blocksy_default_akg('language_label', $atts, 'long');
$ls_type = blocksy_default_akg('ls_type', $atts, 'inline');

$hide_current_language = blocksy_default_akg(
	'hide_current_language',
	$atts,
	'no'
) === 'yes';

?>

<div
	class="<?php echo esc_attr($class) ?>"
	data-type="<?php echo $ls_type ?>"
	<?php echo blocksy_attr_to_html($attr) ?>>

	<?php
		if (function_exists('icl_object_id') && function_exists('icl_disp_language')) {
			$languages =  apply_filters(
				'wpml_active_languages',
				null,
				'skip_missing=0&orderby=code&order=desc'
			);

			if (! empty($languages)) {
				$list_class = 'class="ct-language"';

				if ($ls_type === 'dropdown') {
					$list_class = '';

					foreach($languages as $l) {
						if ($l['active']) {
							echo '<div class="ct-language ct-active-language" tabindex="0">';

							if ($l['country_flag_url'] && $language_type['icon']) {
								echo '<img src="' . $l['country_flag_url'] . '" height="12" alt="' . $l['language_code'] . '" width="18" />';
							}

							if ($language_type['label']) {
								echo '<span>';

								if ($language_label === 'long') {
									echo $l['native_name'];
								} else {
									echo strtoupper($l['language_code']);
								}

								echo '</span>';
							}

							echo '</div>';
						}
					}
				}

				echo '<ul ' . $list_class . '>';

				foreach($languages as $l) {
					if ($l['active']) {
						if ($hide_current_language) {
							continue;
						}

						echo '<li class="current-lang">';
					} else {
						echo '<li>';
					}

					echo '<a href="' . $l['url'] . '">';
					if ($l['country_flag_url'] && $language_type['icon']) {
						echo '<img src="' . $l['country_flag_url'] . '" height="12" alt="' . $l['language_code'] . '" width="18" />';
					}

					if ($language_type['label']) {
						echo '<span>';
						if ($language_label === 'long') {
							echo $l['native_name'];
						} else {
							echo strtoupper($l['language_code']);
						}
						echo '</span>';
					}

					echo '</a>';

					echo '</li>';
				}

				echo '</ul>';
			}
		}

		if (function_exists('pll_the_languages')) {
			$list_class = 'class="ct-language"';

			if ($ls_type === 'dropdown') {
				$list_class = '';

				echo '<div class="ct-language ct-active-language" tabindex="0">';

				$current_language = PLL()->curlang;

				if ($language_type['icon']) {
					echo $current_language->flag;
				}

				if ($language_type['label']) {
					echo '<span>';
					echo pll_current_language($language_label === 'long' ? 'name' : 'slug');
					echo '</span>';
				}

				echo '</div>';
			}

			echo '<ul ' . $list_class . '>';

			pll_the_languages([
				'show_flags' => $language_type['icon'],
				'show_names' => $language_type['label'],
				'display_names_as' => $language_label === 'long' ? 'name' : 'slug',
				'hide_if_empty' => false,
				'hide_current' => $hide_current_language
			]);

			echo '</ul>';
		}

		if (class_exists('TRP_Translate_Press')) {
			global $TRP_LANGUAGE;

			$settings = new TRP_Settings();

			$settings_array = $settings->get_settings();

			$trp = TRP_Translate_Press::get_trp_instance();

			$trp_lang_switcher = new TRP_Language_Switcher(
				$settings->get_settings(),
				TRP_Translate_Press::get_trp_instance()
			);

			$trp_languages = $trp->get_component('languages');

			$url_converter = $trp->get_component('url_converter');

			if (current_user_can(apply_filters(
				'trp_translating_capability',
				'manage_options'
			))) {
				$languages_to_display = $settings_array['translation-languages'];
			} else {
				$languages_to_display = $settings_array['publish-languages'];
			}

			$published_languages = $trp_languages->get_language_names(
				$languages_to_display
			);

			$current_language = array();

			foreach ($published_languages as $code => $name) {
				if ($code == $TRP_LANGUAGE) {
					$current_language['code'] = $code;
					$current_language['name'] = $name;
				}
			}

			$current_language = apply_filters(
				'trp_ls_shortcode_current_language',
				$current_language,
				$published_languages,
				$TRP_LANGUAGE,
				$settings_array
			);

			$list_class = 'class="ct-language"';

			if ($ls_type === 'dropdown') {
				$list_class = '';

				echo '<div class="ct-language ct-active-language" tabindex="0">';

				if ($language_type['icon']) {
					echo $trp_lang_switcher->add_flag(
						$current_language['code'],
						$current_language['name']
					);
				}

				if ($language_type['label']) {
					echo '<span>';

					if ($language_label === 'long') {
						echo $current_language['name'];
					} else {
						echo strtoupper($url_converter->get_url_slug(
							$current_language['code'],
							false
						));
					}

					echo '</span>';
				}

				echo '</div>';
			}

			echo '<ul ' . $list_class . '>';

			foreach($published_languages as $code => $lang) {
				if ($current_language['code'] === $code) {
					if ($hide_current_language) {
						continue;
					}

					echo '<li class="current-lang">';
				} else {
					echo '<li>';
				}

				$url = $url_converter->get_url_for_language($code, false);

				echo '<a href="' . $url . '">';

				if ($language_type['icon']) {
					echo $trp_lang_switcher->add_flag($code, $lang);
				}

				if ($language_type['label']) {
					echo '<span>';

					if ($language_label === 'long') {
						echo $lang;
					} else {
						echo strtoupper($url_converter->get_url_slug($code, false));
					}

					echo '</span>';
				}

				echo '</a>';

				echo '</li>';
			}

			echo '</ul>';
		}
	?>

</div>
