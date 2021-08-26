<?php

add_action('wp_ajax_blocsky_get_woo_quick_view', 'blocksy_get_woocommerce_quickview');
add_action('wp_ajax_nopriv_blocsky_get_woo_quick_view', 'blocksy_get_woocommerce_quickview');

function blocksy_get_woocommerce_quickview() {
	global $product;
	global $post;

	global $blocksy_is_quick_view;

	do_action('blocksy:content-blocks:display-hooks');

	$blocksy_is_quick_view = true;

	$product = wc_get_product(sanitize_text_field( $_GET['product_id'] ));

	$variation = null;

	if (get_class($product) === 'WC_Product_Variation') {
		global $blocksy_current_variation;


		$variation = $product;
		$product = wc_get_product($variation->get_parent_id());

		$blocksy_current_variation = $variation;

		$permalink = $variation->get_permalink();

		parse_str(parse_url($permalink, PHP_URL_QUERY), $res);

		foreach ($res as $key => $val) {
			$_REQUEST[$key] = $val;
			$_GET[$key] = $val;
		}
	}

	$GLOBALS['product'] = $product;

	$id = $product->get_id();

	$post = get_post($id);

	if (! $product) {
		wp_send_json_error();
	}

	$is_in_stock = true;

	if (! $product->managing_stock() && ! $product->is_in_stock()) {
		$is_in_stock = false;
	}

	$content = ob_start();

	remove_filter(
		'woocommerce_post_class',
		'blocksy_woo_single_post_class',
		999,
		2
	);

	remove_action(
		'woocommerce_product_thumbnails',
		'woocommerce_show_product_thumbnails',
		20
	);

	?>

	<div id="quick-view-<?php echo esc_attr($id) ?>" data-behaviour="modal" class="ct-panel quick-view-modal">
		<div class="ct-panel-content">
			<div <?php wc_product_class('ct-container ct-quick-view-card single-product', $product->get_id()) ?>>

				<span class="ct-close-button">
					<svg class="ct-icon" width="12" height="12" viewBox="0 0 15 15">
						<path d="M1 15a1 1 0 01-.71-.29 1 1 0 010-1.41l5.8-5.8-5.8-5.8A1 1 0 011.7.29l5.8 5.8 5.8-5.8a1 1 0 011.41 1.41l-5.8 5.8 5.8 5.8a1 1 0 01-1.41 1.41l-5.8-5.8-5.8 5.8A1 1 0 011 15z"/>
					</svg>
				</span>

				<section>
					<?php woocommerce_show_product_images() ?>

					<div class="entry-summary">
						<?php
							do_action('blocksy:woocommerce:quick-view:title:before');
							woocommerce_template_single_title();
							do_action('blocksy:woocommerce:quick-view:title:after');

							do_action('blocksy:woocommerce:quick-view:price:before');
							woocommerce_template_single_price();
							do_action('blocksy:woocommerce:quick-view:price:after');

							do_action('blocksy:woocommerce:quick-view:summary:before');
							woocommerce_template_single_excerpt();
							do_action('blocksy:woocommerce:quick-view:summary:after');
							woocommerce_template_single_add_to_cart();
						?>

						<a href="<?php echo get_permalink($variation ? $variation->get_id() : $product->get_id()) ?>" class="ct-button ct-quick-more">
							<?php echo __('Go to product page', 'blc') ?>
						</a>
					</div>
				</section>
			</div>
		</div>
	</div>

	<?php

	ob_start();
	if (function_exists('wc_get_template')) {
		wc_get_template( 'single-product/add-to-cart/variation.php' );
	}
	$body_html = ob_get_clean();

	wp_send_json_success([
		'quickview' => ob_get_clean(),
		'body_html' => $body_html
	]);
}

function blocksy_quick_view_attr() {
	if (get_theme_mod('woocommerce_quickview_enabled', 'yes') !== 'yes') {
		return [];
	}

	if (get_theme_mod('woocommerce_quick_view_trigger', 'button') === 'button') {
		return [];
	}

	return [
		'data-quick-view' => get_theme_mod('woocommerce_quick_view_trigger', 'button')
	];
}

function blocksy_output_quick_view_link() {
    global $product;

	$id = $product->get_id();

	if (
		get_theme_mod('woocommerce_quickview_enabled', 'yes') === 'yes'
		&&
		get_theme_mod('woocommerce_quick_view_trigger', 'button') === 'button'
	) {
		return '<a href="#quick-view-' . $id . '" class="ct-open-quick-view" aria-label="' . __('Quick view', 'blocksy') . '"><svg class="ct-icon" width="14" height="14" viewBox="0 0 15 15"><path d="M7.5,5.5c-1.1,0-1.9,0.9-1.9,2s0.9,2,1.9,2s1.9-0.9,1.9-2S8.6,5.5,7.5,5.5z M14.7,6.9c-0.9-1.6-2.9-5.2-7.1-5.2S1.3,5.3,0.4,6.9L0,7.5l0.4,0.6c0.9,1.6,2.9,5.2,7.1,5.2s6.3-3.7,7.1-5.2L15,7.5L14.7,6.9z M7.5,11.8c-3.2,0-4.9-2.8-5.7-4.3C2.6,6,4.3,3.2,7.5,3.2s4.9,2.8,5.7,4.3C12.4,9,10.8,11.8,7.5,11.8z"/></svg></a>';
	}

	return '';
}

function blocksy_woo_floating_cart() {
	if (! function_exists('is_woocommerce')) {
		return '';
	}

	global $product;

	if (! is_product()) {
		return '';
	}

	if (get_theme_mod('has_floating_bar', 'yes') !== 'yes') {
		return '';
	}

	$image_output = '';

	if ($product->get_image_id()) {
		$image_output = blc_call_fn(['fn' => 'blocksy_image'], [
			'attachment_id' => $product->get_image_id(),
			'size' => 'woocommerce_gallery_thumbnail',
			'ratio' => '1/1',
			'lazyload' => false,
			'tag_name' => 'div',
		]);
	}

	$class = 'ct-floating-bar';

	$class .= ' ' . blocksy_visibility_classes(get_theme_mod('floatingBarVisibility',
		[
			'desktop' => true,
			'tablet' => true,
			'mobile' => false,
		]
	));

	$title_class = trim('ct-item-title ' . blocksy_visibility_classes(
		get_theme_mod(
			'floatingBarTitleVisibility',
			[
				'desktop' => true,
				'tablet' => true,
				'mobile' => true,
			]
		)
	));

	ob_start();

	?>
		<div class="<?php echo esc_attr($class) ?>">
			<div class="ct-container">
				<section class="floating-bar-content">
					<?php echo $image_output ?>
					<div>
						<?php the_title( '<div class="' . $title_class . '">', '</div>' ); ?>
						<?php woocommerce_template_single_price(); ?>
					</div>
				</section>

				<section class="floating-bar-actions">
					<?php
						woocommerce_template_single_price();

						if ($product->is_type('simple')) {
							global $wp_filter;
							global $blocksy_is_floating_cart;

							$blocksy_is_floating_cart = true;

							if (isset($wp_filter['woocommerce_before_add_to_cart_quantity'])) {
								$old_before = $wp_filter['woocommerce_before_add_to_cart_quantity'];
							}

							if (isset($wp_filter['woocommerce_after_add_to_cart_quantity'])) {
								$old = $wp_filter['woocommerce_after_add_to_cart_quantity'];
							}

							if (isset($wp_filter['woocommerce_before_add_to_cart_button'])) {
								$old_button = $wp_filter['woocommerce_before_add_to_cart_button'];
							}
							if (isset($wp_filter['woocommerce_before_add_to_cart_form'])) {
								$old_before_form = $wp_filter['woocommerce_before_add_to_cart_form'];
							}

							if (isset($wp_filter['woocommerce_after_add_to_cart_form'])) {
								$old_after_form = $wp_filter['woocommerce_after_add_to_cart_form'];
							}

							if (isset($wp_filter['woocommerce_after_add_to_cart_button'])) {
								$old_after_button = $wp_filter['woocommerce_after_add_to_cart_button'];
							}

							unset($wp_filter['woocommerce_before_add_to_cart_quantity']);
							unset($wp_filter['woocommerce_after_add_to_cart_quantity']);
							unset($wp_filter['woocommerce_before_add_to_cart_button']);
							unset($wp_filter['woocommerce_before_add_to_cart_form']);
							unset($wp_filter['woocommerce_after_add_to_cart_form']);
							unset($wp_filter['woocommerce_after_add_to_cart_button']);

							woocommerce_simple_add_to_cart();

							if (isset($old_before)) {
								$wp_filter['woocommerce_before_add_to_cart_quantity'] = $old_before;
							}

							if (isset($old)) {
								$wp_filter['woocommerce_after_add_to_cart_quantity'] = $old;
							}

							if (isset($old_button)) {
								$wp_filter['woocommerce_before_add_to_cart_button'] = $old_button;
							}

							if (isset($old_after_form)) {
								$wp_filter['woocommerce_after_add_to_cart_form'] = $old_after_form;
							}

							if (isset($old_before_form)) {
								$wp_filter['woocommerce_before_add_to_cart_form'] = $old_before_form;
							}

							if (isset($old_after_button)) {
								$wp_filter['woocommerce_after_add_to_cart_button'] = $old_after_button;
							}

							$blocksy_is_floating_cart = false;
						} else {
							woocommerce_template_loop_add_to_cart();
						}
					?>
				</section>
			</div>
		</div>
	<?php

	return ob_get_clean();
}

function blc_get_woo_offcanvas_trigger() {
	$icons = [
		'type-1' => '<svg class="ct-icon" width="12" height="12" viewBox="0 0 10 10"><path d="M0 1.8c0-.4.3-.7.7-.7h8.6c.4 0 .7.3.7.7 0 .4-.3.7-.7.7H.7c-.4 0-.7-.3-.7-.7zm9.3 2.5H.7c-.4 0-.7.3-.7.7 0 .4.3.7.7.7h8.6c.4 0 .7-.3.7-.7 0-.4-.3-.7-.7-.7zm0 3.2H.7c-.4 0-.7.3-.7.7 0 .4.3.7.7.7h8.6c.4 0 .7-.3.7-.7 0-.4-.3-.7-.7-.7z"/></svg>',

		'type-2' => '<svg class="ct-icon" width="12" height="12" viewBox="0 0 10 10"><path d="M.7 1.1c-.4 0-.7.3-.7.7 0 .4.3.7.7.7h8.6c.4 0 .7-.3.7-.7 0-.4-.3-.7-.7-.7H.7zm.9 3.2c-.4 0-.7.3-.7.7 0 .4.3.7.7.7h6.8c.4 0 .7-.3.7-.7 0-.4-.3-.7-.7-.7H1.6zm.9 3.2c-.4 0-.7.3-.7.7 0 .4.3.7.7.7h5c.4 0 .7-.3.7-.7 0-.4-.3-.7-.7-.7h-5z"/></svg>',

		'type-3' => '<svg class="ct-icon" width="12" height="12" viewBox="0 0 10 10"><path d="M10 1v1H5.4c-.2.6-.7 1-1.4 1s-1.2-.4-1.4-1H0V1h2.6c.2-.6.7-1 1.4-1s1.2.4 1.4 1H10zM6.5 3.5c-.7 0-1.2.4-1.4 1H0v1h5.1c.2.6.8 1 1.4 1 .7 0 1.2-.4 1.4-1H10v-1H7.9c-.2-.6-.7-1-1.4-1zM2.5 7c-.7 0-1.2.4-1.4 1H0v1h1.1c.2.6.8 1 1.4 1 .7 0 1.2-.4 1.4-1H10V8H3.9c-.2-.6-.7-1-1.4-1z"/></svg>',

		'type-4' => '<svg class="ct-icon" width="12" height="12" viewBox="0 0 10 10"><path d="M5.9 9.5h-.2l-1.8-.9c-.2-.1-.3-.2-.3-.4V5.4L.1 1.2C0 1.1 0 .9 0 .7.1.5.2.4.4.4h9.1c.2 0 .3.1.4.3s0 .3-.1.5L6.4 5.4v3.7c0 .2-.1.3-.2.4h-.3z"/></svg>'
	];

	$type = get_theme_mod('woocommerce_filter_type', 'type-1');

	if (empty($type)) {
		$type = 'type-1';
	}

	$class = 'ct-offcanvas-trigger ct-filter-trigger';

	$class .= ' ' . blocksy_visibility_classes(get_theme_mod(
		'woocommerce_filter_visibility',
		[
			'desktop' => true,
			'tablet' => true,
			'mobile' => true,
		]
	));

	return '<a class="' . $class . '" href="#woo-filters-panel">' . $icons[$type] . __('Filter', 'blc') . '</a>';
}

