<?php

$search_through = blocksy_akg('search_through', $atts, [
	'post' => true,
	'page' => true,
	'product' => true
]);

$all_cpts = blocksy_manager()->post_types->get_supported_post_types();

if (function_exists('is_bbpress')) {
	$all_cpts[] = 'forum';
	$all_cpts[] = 'topic';
	$all_cpts[] = 'reply';
}

foreach ($all_cpts as $single_cpt) {
	if (! isset($search_through[$single_cpt])) {
		$search_through[$single_cpt] = true;
	}
}

$post_type = [];

foreach ($search_through as $single_post_type => $enabled) {
	if (! $enabled) {
		continue;
	}

	$post_type[] = $single_post_type;
}

$class = 'ct-search-box';

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

?>

<div
	class="<?php echo esc_attr($class) ?>"
	<?php echo blocksy_attr_to_html($attr) ?>>
	<?php get_search_form([
		'ct_post_type' => $post_type,
		'search_live_results' => blocksy_akg('enable_live_results', $atts, 'no'),
		'live_results_attr' => blocksy_akg(
			'live_results_images',
			$atts,
			'yes'
		) === 'yes' ? 'thumbs' : '',
		'search_placeholder' => blocksy_akg(
			'search_box_placeholder',
			$atts,
			__('Search', 'blc')
		)
	]); ?>
</div>
