<?php


function blocksy_output_add_to_wish_list($place) {
	$option_ids = [
		'archive' => 'has_archive_wishlist',
		'single' => 'has_single_wishlist',
		'quick-view' => 'has_quick_view_wishlist'
	];

	if ($place && isset($option_ids[$place])) {
		if (get_theme_mod($option_ids[$place], 'no') === 'no') {
			return '';
		}
	} else {
		return '';
	}

    global $product;

	$id = $product->get_id();

	$class = 'ct-wishlist-button-archive';

	if ($place !== 'archive') {
		$class = 'ct-wishlist-button-single';
	}

	if (in_array($id, blc_get_ext('woocommerce-extra')->get_wish_list()->get_current_wish_list())) {
		$class .= ' active';
	}

	$content = '';

	$content .= '<svg class="ct-icon" width="14" height="14" viewBox="0 0 15 15">
					<path class="ct-heart-fill" d="M12.9,3.8c-0.6-0.5-1.6-0.7-2.5-0.5C9.4,3.5,8.7,4,8.2,4.8L7.5,6.1L6.8,4.8C6.3,4,5.6,3.5,4.6,3.3C4.4,3.2,4.2,3.2,4,3.2c-0.7,0-1.4,0.2-1.9,0.6C1.5,4.3,1.1,5.1,1,5.9c-0.1,1,0.3,1.9,1,2.8c1,1.1,4.2,3.7,5.5,4.6c1.3-1,4.5-3.5,5.5-4.6c0.7-0.8,1.1-1.8,1-2.8C13.9,5.1,13.5,4.3,12.9,3.8z"/>

					<path d="M13.4,3.2c-0.9-0.8-2.3-1-3.5-0.8C8.9,2.6,8.1,3,7.5,3.7C6.9,3,6.1,2.6,5.2,2.4c-1.3-0.2-2.6,0-3.6,0.8C0.7,3.9,0.1,5,0,6.1c-0.1,1.3,0.3,2.6,1.3,3.7c1.2,1.4,5.6,4.7,5.8,4.8L7.5,15L8,14.6c0.2-0.1,4.5-3.5,5.7-4.8c1-1.1,1.4-2.4,1.3-3.7C14.9,5,14.3,3.9,13.4,3.2z M12.6,8.8c-0.9,1-3.9,3.4-5.1,4.3c-1.2-0.9-4.2-3.3-5.1-4.3c-0.7-0.8-1-1.7-0.9-2.6c0.1-0.8,0.4-1.4,1-1.9C3,4,3.6,3.8,4.2,3.8c0.2,0,0.4,0,0.6,0.1c0.9,0.2,1.6,0.7,2,1.4l0.7,1.2l0.7-1.2c0.4-0.8,1.1-1.3,2-1.4c0.8-0.2,1.7,0,2.3,0.5c0.6,0.5,1,1.2,1,1.9C13.6,7.2,13.2,8.1,12.6,8.8z"/>
				</svg>';
	
	if ($place === 'single') {
		$content .= '<span class="ct-hidden-md ct-hidden-lg">' . __('Add to wishlist', 'blc') . '</span>';
	}

	return blocksy_html_tag(
		'a',
		[
			'href' => '#wishlist-add-' . $id,
			'class' => $class,
			'aria-label' => __('Add to wishlist', 'blc')
		],
		$content
	);
}

