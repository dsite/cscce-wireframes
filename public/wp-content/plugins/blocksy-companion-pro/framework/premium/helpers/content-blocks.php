<?php

if (! function_exists('blc_render_content_block')) {
	function blc_render_content_block($id) {
		return \Blocksy\Plugin::instance()
			->premium
			->content_blocks
			->output_hook($id);
	}
}

if (! function_exists('blc_get_content_block_that_matches')) {
	function blc_get_content_block_that_matches($args = []) {
		if (! function_exists('blocksy_get_post_options')) {
			return null;
		}

		$args = wp_parse_args($args, [
			'template_type' => 'hook',
			'match_conditions' => true
		]);

		$all_blocks = array_keys(blc_get_content_blocks([
			'template_type' => $args['template_type']
		]));

		if (! empty($all_blocks) && ! $args['match_conditions']) {
			return $all_blocks[0];
		}

		foreach ($all_blocks as $block_id) {
			$values = blocksy_get_post_options($block_id);

			$conditions = blocksy_default_akg('conditions', $values, []);

			$conditions_manager = new \Blocksy\ConditionsManager();

			if (blocksy_default_akg('is_hook_enabled', $values, 'yes') !== 'yes') {
				continue;
			}

			if (! $conditions_manager->condition_matches($conditions)) {
				continue;
			}

			return $block_id;
		}

		return null;
	}
}

if (! function_exists('blc_get_content_blocks')) {
	function blc_get_content_blocks($args = []) {
		$args = wp_parse_args($args, [
			'template_type' => 'hook'
		]);

		$blocks = [];

		$all_items = get_posts([
			'post_type' => 'ct_content_block',
			'meta_key' => 'template_type',
			'meta_value' => $args['template_type'],
			'numberposts' => -1,
			'suppress_filters' => false
		]);

		if (is_array($all_items) && count($all_items)) {
			foreach($all_items as $row) {
				$blocks[$row->ID] = get_the_title($row->ID);
			}
		}

		return $blocks;
	}
}

if (! function_exists('blocksy_get_default_content_block')) {
	function blocksy_get_default_content_block($preferred = null, $args = []) {
		if (count(array_keys(blc_get_content_blocks($args))) === 0) {
			return null;
		}

		if ($preferred) {
			foreach (blc_get_content_blocks($args) as $id => $label) {
				if (strpos(
					strtolower($label),
					strtolower($preferred)
				) !== false) {
					return $id;
				}
			}
		}

		return array_keys(blc_get_content_blocks($args))[0];
	}
}
