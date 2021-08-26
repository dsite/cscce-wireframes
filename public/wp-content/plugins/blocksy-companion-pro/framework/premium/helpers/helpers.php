<?php

function blc_get_icon($args = []) {
	$args = wp_parse_args($args, [
		'icon_descriptor' => [
			'source' => 'default',

			'icon' => '',
			'class' => '',

			'attachment_id' => ''
		],

		'layout' => true
	]);

	$class = 'ct-icon-container';

	if (! empty($args['class'])) {
		$class .= ' ' . $args['class'];
	}

	if (
		isset($args['icon_descriptor']['source'])
		&&
		$args['icon_descriptor']['source'] === 'attachment'
		&&
		isset($args['icon_descriptor']['attachment_id'])
	) {
		$attachment_id = $args['icon_descriptor']['attachment_id'];

		$svg_file = file_get_contents(
			get_attached_file($attachment_id)
		);

		if ($svg_file && ! empty($svg_file)) {
			return '<span class="' . $class . '">' . $svg_file . '</span>';
		}
	}

	if (
		! $args['icon_descriptor']
		||
		! isset($args['icon_descriptor']['icon'])
		||
		! $args['icon_descriptor']['icon']
	) {
		return '';
	}

	static $packs = [
		[
			'prefix' => 'blc blc-',
			'path' => BLOCKSY_PATH . '/framework/premium/static/icons/blc.json',
			'icons' => null
		],

		[
			'prefix' => 'fab fa-',
			'path' => BLOCKSY_PATH . '/framework/premium/static/icons/fab.json',
			'icons' => null
		],

		[
			'prefix' => 'fas fa-',
			'path' => BLOCKSY_PATH . '/framework/premium/static/icons/fas.json',
			'icons' => null
		],

		[
			'prefix' => 'far fa-',
			'path' => BLOCKSY_PATH . '/framework/premium/static/icons/far.json',
			'icons' => null
		]
	];

	$choosen_pack = null;

	foreach ($packs as $index => $pack) {
		if (strpos($args['icon_descriptor']['icon'], $pack['prefix']) === false) {
			continue;
		}

		if (! $packs[$index]['icons']) {
			$packs[$index]['icons'] = json_decode(
				file_get_contents($pack['path']),
				true
			);
		}

		$choosen_pack = $packs[$index];
	}

	if (! $choosen_pack) {
		return '';
	}


	foreach ($choosen_pack['icons'] as $icon) {
		if ($icon['icon'] !== str_replace(
			$choosen_pack['prefix'],
			'',
			$args['icon_descriptor']['icon']
		)) {
			continue;
		}

		if (strpos($args['icon_descriptor']['icon'], $icon['icon']) === false) {
			continue;
		}

		if (! $args['layout']) {
			return $icon['svg'];
		}

		return '<span class="' . $class . '">' . $icon['svg'] . '</span>';
	}

	return '';
}
