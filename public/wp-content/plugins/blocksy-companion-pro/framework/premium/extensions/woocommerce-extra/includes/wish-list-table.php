<?php

$wish_list = blc_get_ext('woocommerce-extra')->get_wish_list()->get_current_wish_list();

$has_custom_user = isset($_GET['wish_list_id']);

if (count($wish_list) > 0) {

?>
	<table class="shop_table wishlist-table">
		<thead>
			<tr>
				<th colspan="2"><?php esc_html_e( 'Product', 'blc' ); ?></th>
				<th class="wishlist-product-actions"><?php esc_html_e( 'Add to cart', 'blc' ); ?></th>
				<?php if (! $has_custom_user) { ?>
				<th class="wishlist-product-remove">&nbsp;</th>
				<?php } ?>
			</tr>
		</thead>

		<tbody>
			<?php

			foreach ($wish_list as $single_product_id) {
				$product = wc_get_product($single_product_id);
				$GLOBALS['product'] = $product;


				if ($product && $product->exists()) {
					$product_permalink = $product->is_visible() ? $product->get_permalink() : '';

					$ajax_add_to_cart_id = 'has_wishlist_ajax_add_to_cart';

					$class = '';

					if (
						! $product->is_type('grouped')
						&&
						! $product->is_type('external')
						&&
						get_theme_mod($ajax_add_to_cart_id, 'no') === 'yes'
					) {
						$class .= 'class="ct-ajax-add-to-cart"';
					}

					?>
						<tr <?php echo $class ?>>
							<td class="wishlist-product-thumbnail">
								<?php
									$thumbnail = $product->get_image();

									if (! $product_permalink) {
										echo $thumbnail;
									} else {
										printf('<a href="%s" class="product-thumb">%s</a>', esc_url($product_permalink), $thumbnail);
									}
								?>
							</td>

							<td class="wishlist-product-name">
								<?php
									if (! $product_permalink) {
										echo wp_kses_post($product->get_name());
									} else {
										echo wp_kses_post(sprintf(
											'<a href="%s" class="product-name">%s</a>',
											esc_url($product_permalink),
											$product->get_name()
										));
									}
								?>
								<?php woocommerce_template_single_price(); ?>

								<div class="product-mobile-actions ct-hidden-lg">
									<?php
										global $has_wish_list;
										$has_wish_list = true;

										if ($product->is_type('simple')) {
											woocommerce_template_single_add_to_cart();
										} else {
											woocommerce_template_loop_add_to_cart();
										}

										$has_wish_list = false;
									?>

									<?php if (! $has_custom_user) { ?>
										<a href="#wishlist-remove-<?php echo $single_product_id ?>" class="remove" data-id="<?php echo $single_product_id ?>" title="<?php echo __('Remove Product', 'blc') ?>">
											<svg class="ct-icon" width="10px" height="10px" viewBox="0 0 24 24"><path d="M9.6,0l0,1.2H1.2v2.4h21.6V1.2h-8.4l0-1.2H9.6z M2.8,6l1.8,15.9C4.8,23.1,5.9,24,7.1,24h9.9c1.2,0,2.2-0.9,2.4-2.1L21.2,6H2.8z"></path></svg>
										</a>
									<?php } ?>
								</div>
							</td>

							<td class="wishlist-product-actions">
								<?php
									global $has_wish_list;
									$has_wish_list = true;

									if ($product->is_type('simple')) {
										woocommerce_template_single_add_to_cart();
									} else {
										woocommerce_template_loop_add_to_cart();
									}

									$has_wish_list = false;
								?>
							</td>

							<?php if (! $has_custom_user) { ?>
							<td class="wishlist-product-remove">
								<a href="#wishlist-remove-<?php echo $single_product_id ?>" class="remove" data-id="<?php echo $single_product_id ?>" title="<?php echo __('Remove Product', 'blc') ?>">
									<svg class="ct-icon" width="10px" height="10px" viewBox="0 0 24 24"><path d="M9.6,0l0,1.2H1.2v2.4h21.6V1.2h-8.4l0-1.2H9.6z M2.8,6l1.8,15.9C4.8,23.1,5.9,24,7.1,24h9.9c1.2,0,2.2-0.9,2.4-2.1L21.2,6H2.8z"></path></svg>
								</a>
							</td>
							<?php } ?>
						</tr>
					<?php
				}
			}
			?>
		</tbody>
	</table>

<?php
	if (
		get_theme_mod('product_wishlist_display_for', 'logged_users') === 'all_users'
		&&
		get_theme_mod('woocommerce_wish_list_page')
		&&
		is_user_logged_in()
		&&
		get_theme_mod('single_page_has_share_box', 'no') === 'yes'
	) {
		echo blocksy_get_social_share_box([
			'html_atts' => [
				'data-type' => 'type-3'
			],
			'links_wrapper_attr' => [
				'data-icons-type' => 'simple'
			],
			'custom_share_url' => add_query_arg(
				'wish_list_id',
				get_current_user_id(),
				get_permalink(get_theme_mod('woocommerce_wish_list_page'))
			)
		]);
	}

} else {
	echo '<p>' . __("You don't have any products in your wish list yet.", 'blc') . '</p>';
}

