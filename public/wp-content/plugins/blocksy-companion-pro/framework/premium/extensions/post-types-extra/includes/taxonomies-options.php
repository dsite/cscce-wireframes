<?php

class BlocksyAdvancedPostTypesTaxonomies {
	public function __construct() {
		add_action('init', [$this, 'init_taxonomies'], 999);

		add_filter(
			'blocksy:options:page-title:archives-have-hero',
			'__return_true'
		);

		add_action('blocksy:global-dynamic-css:enqueue', function ($args) {
			$custom_post_types = blocksy_manager()
				->post_types
				->get_supported_post_types();

			$custom_post_types[] = 'post';

			foreach ($custom_post_types as $post_type) {
				$taxonomies = array_values(array_diff(
					get_object_taxonomies($post_type),
					['post_format']
				));

				foreach ($taxonomies as $taxonomy) {
					$all_terms = get_terms($taxonomy, [
						'meta_query' => [
							[
								'key' => 'blocksy_taxonomy_meta_options',
								'value' => "accent_color",
								'compare' => 'LIKE'
							]
						]
					]);

					foreach ($all_terms as $term) {
						$values = get_term_meta(
							$term->term_id,
							'blocksy_taxonomy_meta_options'
						);

						if (empty($values)) {
							$values = [[]];
						}

						blocksy_theme_get_dynamic_styles(array_merge([
							'path' => dirname(__FILE__) . '/taxonomies/global.php',
							'chunk' => 'global',
							'atts' => $values[0],
							'root_selector' => ['.ct-term-' . $term->term_id]
						], $args));
					}
				}
			}
		});

		if (empty($_POST)) {
			return;
		}

		add_action('edited_term', function ($term_id, $tt_id, $taxonomy) {
			if (
				!(
					isset($_POST['action'])
					&&
					'editedtag' === $_POST['action']
					&&
					isset($_POST['taxonomy'])
					&&
					($taxonomy = get_taxonomy(sanitize_text_field(wp_unslash($_POST['taxonomy']))))
					&&
					current_user_can($taxonomy->cap->edit_terms)
				)
			) {
				return;
			}

			if (
				isset($_POST['tag_ID'])
				&&
				intval(
					sanitize_text_field(wp_unslash($_POST['tag_ID']))
				) !== $term_id
			) {
				return;
			}

			$values = [];

			if (isset($_POST['blocksy_taxonomy_meta_options'][blocksy_post_name()])) {
				$values = json_decode(
					sanitize_text_field(
						wp_unslash(
							$_POST['blocksy_taxonomy_meta_options'][
								blocksy_post_name()
							]
						)
					),
					true
				);
			}

			update_term_meta(
				$term_id,
				'blocksy_taxonomy_meta_options',
				$values
			);

			do_action('blocksy:dynamic-css:refresh-caches');
		}, 10, 3 );

	}

	public function init_taxonomies() {
		$current_edit_taxonomy = $this->get_current_edit_taxonomy();

		if (
			$current_edit_taxonomy['taxonomy'] === 'product_tag'
			||
			$current_edit_taxonomy['taxonomy'] === 'product_cat'
		) {
			return;
		}

		add_action(
			$current_edit_taxonomy['taxonomy'] . '_edit_form_fields',
			function ($term) {
				echo '<tr class="form-field term-blocksy-image-wrap ct-control">
					<th scope="row"><label>' . __('Featured Image', 'blc') . '</label></th>
					<td></td>
				</tr>';

				echo '<tr class="form-field term-blocksy-accent-color-wrap ct-control">
					<th scope="row"><label>' . __('Accent Color', 'blc') . '</label></th>
					<td></td>
				</tr>';
			}
		);

		add_action(
			$current_edit_taxonomy['taxonomy'] . '_edit_form',
			function ($term) {
				$values = get_term_meta(
					$term->term_id,
					'blocksy_taxonomy_meta_options'
				);

				if (empty($values)) {
					$values = [[]];
				}

				echo '<div>';
				echo blocksy_html_tag(
					'input',
					[
						'type' => 'hidden',
						'value' => wp_json_encode($values[0]),
						'name' => 'blocksy_taxonomy_meta_options[' . blocksy_post_name() . ']',
					]
				);
				echo '</div>';
			}
		);
	}

	private function get_current_edit_taxonomy() {
		static $cache_current_taxonomy_data = null;

		if ($cache_current_taxonomy_data !== null) {
			return $cache_current_taxonomy_data;
		}

		$result = array(
			'taxonomy' => null,
			'term_id'  => 0,
		);

		do {
			if (! is_admin()) {
				break;
			}

			// code from /wp-admin/admin.php line 110
			{
				if (
					isset($_REQUEST['taxonomy'])
					&&
					taxonomy_exists(
						sanitize_text_field(wp_unslash($_REQUEST['taxonomy']))
					)
				) {
					$taxnow = sanitize_text_field(wp_unslash($_REQUEST['taxonomy']));
				} else {
					$taxnow = '';
				}
			}

			if (empty($taxnow)) {
				break;
			}

			$result['taxonomy'] = $taxnow;

			if (empty($_REQUEST['tag_ID'])) {
				return $result;
			}

			// code from /wp-admin/edit-tags.php
			{
				$tag_ID = (int) $_REQUEST['tag_ID'];
			}

			$result['term_id'] = $tag_ID;
		} while ( false );

		$cache_current_taxonomy_data = $result;
		return $cache_current_taxonomy_data;
	}
}

