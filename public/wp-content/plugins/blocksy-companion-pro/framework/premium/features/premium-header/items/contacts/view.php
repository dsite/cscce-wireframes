<?php

$class = 'ct-contact-info';

$class = trim($class . ' ' . blocksy_visibility_classes(blocksy_default_akg(
	'footer_contacts_visibility',
	$atts,
	[
		'desktop' => true,
		'tablet' => true,
		'mobile' => true,
	]
)));

$contact_items = blocksy_default_akg(
	'contact_items',
	$atts,
	[
		[
			'id' => 'address',
			'enabled' => true,
			'title' => __('Address:', 'blc'),
			'content' => 'Street Name, NY 38954',
		],

		[
			'id' => 'phone',
			'enabled' => true,
			'title' => __('Phone:', 'blc'),
			'content' => '578-393-4937',
			'link' => 'tel:578-393-4937',
		],

		[
			'id' => 'mobile',
			'enabled' => true,
			'title' => __('Mobile:', 'blc'),
			'content' => '578-393-4937',
			'link' => 'tel:578-393-4937',
		],
	]
);

$text = blocksy_translate_dynamic(
	blocksy_default_akg('header_button_text', $atts, __('Download', 'blocksy')),
	'header:' . $section_id . ':button:header_button_text'
);

foreach ($contact_items as $item_index => $single_item) {
	if (isset($single_item['title'])) {
		$contact_items[$item_index]['title'] = blocksy_translate_dynamic(
			$single_item['title'],
			'header:' . $section_id . ':contacts:contact_items:' . $single_item['id'] . ':title'
		);
	}

	if (isset($single_item['content'])) {
		$contact_items[$item_index]['content'] = blocksy_translate_dynamic(
			$single_item['content'],
			'header:' . $section_id . ':contacts:contact_items:' . $single_item['id'] . ':content'
		);
	}

	if (isset($single_item['link'])) {
		$contact_items[$item_index]['link'] = blocksy_translate_dynamic(
			$single_item['link'],
			'header:' . $section_id . ':contacts:contact_items:' . $single_item['id'] . ':link'
		);
	}
}

echo blocksy_html_tag(
	'div',
	array_merge([
		'class' => $class
	], $attr),
	blc_get_contacts_output([
		'direction' => blocksy_default_akg(
			'contacts_items_direction',
			$atts,
			$panel_type === 'header' ? 'horizontal' : 'vertical'
		),
		'data' => $contact_items,
		'link_target' => blocksy_default_akg('link_target', $atts, 'no'),
		'type' => blocksy_akg('contacts_icon_shape', $atts, 'rounded'),
		'fill' => blocksy_akg('contacts_icon_fill_type', $atts, 'outline')
	])
);

