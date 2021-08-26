<?php

namespace Blocksy;

class HooksManager {
	public function get_all_hooks() {
		return array_merge([
			[
				'type' => 'action',
				'hook' => 'wp_head',
				'title' => __('WP head', 'blc'),
				// 'visual' => false,
				'group' => __('Head', 'blc'),
				'attr' => ['data-type' => 'full']
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:head:start',
				'title' => __('WP head start', 'blc'),
				// 'visual' => false,
				'group' => __('Head', 'blc'),
				'attr' => ['data-type' => 'full:top-margin'],
				'priority' => 15
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:head:end',
				'title' => __('WP head end', 'blc'),
				// 'visual' => false,
				'group' => __('Head', 'blc'),
				'attr' => ['data-type' => 'full']
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:header:before',
				'title' => __('Header before', 'blc'),
				// 'visual' => false,
				'group' => __('Header', 'blc'),
				'attr' => ['data-type' => 'full']
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:header:after',
				'title' => __('Header after', 'blc'),
				// 'visual' => false,
				'group' => __('Header', 'blc'),
				'attr' => ['data-type' => 'full']
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:header:offcanvas:desktop:top',
				'title' => __('Desktop top', 'blc'),
				// 'visual' => false,
				'group' => __('Header offcanvas', 'blc'),
				'attr' => ['data-type' => 'full']
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:header:offcanvas:desktop:bottom',
				'title' => __('Desktop bottom', 'blc'),
				// 'visual' => false,
				'group' => __('Header offcanvas', 'blc'),
				'attr' => ['data-type' => 'full']
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:header:offcanvas:mobile:top',
				'title' => __('Mobile top', 'blc'),
				// 'visual' => false,
				'group' => __('Header offcanvas', 'blc'),
				'attr' => ['data-type' => 'full']
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:header:offcanvas:mobile:bottom',
				'title' => __('Mobile bottom', 'blc'),
				// 'visual' => false,
				'group' => __('Header offcanvas', 'blc'),
				'attr' => ['data-type' => 'full']
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:sidebar:before',
				'title' => __('Sidebar before', 'blc'),
				'group' => __('Left/Right sidebar', 'blc')
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:sidebar:start',
				'title' => __('Sidebar start', 'blc'),
				'group' => __('Left/Right sidebar', 'blc')
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:sidebar:end',
				'title' => __('Sidebar end', 'blc'),
				'group' => __('Left/Right sidebar', 'blc')
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:sidebar:after',
				'title' => __('Sidebar after', 'blc'),
				'group' => __('Left/Right sidebar', 'blc')
			],

			[
				'type' => 'action',
				'hook' => 'dynamic_sidebar_before',
				'title' => __('Dynamic sidebar before', 'blc'),
				'group' => __('All widget areas', 'blc')
			],

			[
				'type' => 'action',
				'hook' => 'dynamic_sidebar',
				'title' => __('Dynamic sidebar', 'blc'),
				'group' => __('All widget areas', 'blc')
			],


			[
				'type' => 'action',
				'hook' => 'dynamic_sidebar_after',
				'title' => __('Dynamic sidebar after', 'blc'),
				'group' => __('All widget areas', 'blc')
			],


			// page post title
			[
				'type' => 'action',
				'hook' => 'blocksy:hero:before',
				'title' => __('Before section', 'blc'),
				'group' => __('Page/post title', 'blc'),
				'attr' => ['data-type' => 'full']
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:hero:title:before',
				'title' => __('Before title', 'blc'),
				'group' => __('Page/post title', 'blc'),
				'attr' => ['data-type' => 'full']
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:hero:title:after',
				'title' => __('After title', 'blc'),
				'group' => __('Page/post title', 'blc'),
				'attr' => ['data-type' => 'full']
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:hero:after',
				'title' => __('After section', 'blc'),
				'group' => __('Page/post title', 'blc'),
				'attr' => ['data-type' => 'full']
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:content:before',
				'title' => __('Before content', 'blc'),
				'group' => __('Content', 'blc'),
				'attr' => ['data-type' => 'full']
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:content:top',
				'title' => __('Top content', 'blc'),
				'group' => __('Content', 'blc'),
				'attr' => ['data-type' => 'full']
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:content:bottom',
				'title' => __('Bottom content', 'blc'),
				'group' => __('Content', 'blc'),
				'attr' => ['data-type' => 'full']
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:content:after',
				'title' => __('After content', 'blc'),
				'group' => __('Content', 'blc'),
				'attr' => ['data-type' => 'full']
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:comments:before',
				'title' => __('Before comments', 'blc'),
				'group' => __('Comments', 'blc')
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:comments:top',
				'title' => __('Top comments', 'blc'),
				'group' => __('Comments', 'blc')
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:comments:title:before',
				'title' => __('Before title', 'blc'),
				'group' => __('Comments', 'blc')
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:comments:title:after',
				'title' => __('After title', 'blc'),
				'group' => __('Comments', 'blc')
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:comments:bottom',
				'title' => __('Bottom comments', 'blc'),
				'group' => __('Comments', 'blc')
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:comments:after',
				'title' => __('After comments', 'blc'),
				'group' => __('Comments', 'blc')
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:loop:before',
				'title' => __('Before', 'blc'),
				'group' => __('Loop', 'blc')
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:loop:after',
				'title' => __('After', 'blc'),
				'group' => __('Loop', 'blc')
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:loop:card:start',
				'title' => __('Start', 'blc'),
				'group' => __('Loop card', 'blc')
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:loop:card:end',
				'title' => __('End', 'blc'),
				'group' => __('Loop card', 'blc')
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:single:top',
				'title' => __('Top', 'blc'),
				'group' => __('Single Post', 'blc'),
				'attr' => ['data-type' => 'full']
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:single:content:top',
				'title' => __('Top content', 'blc'),
				'group' => __('Single Post', 'blc'),
				'attr' => ['data-type' => 'full']
			],

			[
				'type' => 'dynamic',
				'hook' => 'blocksy:single:content:paragraphs-number',
				'title' => __('After certain number of blocks', 'blc'),
				'group' => __('Single Post', 'blc')
			],

			[
				'type' => 'dynamic',
				'hook' => 'blocksy:single:content:headings-number',
				'title' => __('Before certain number of headings', 'blc'),
				'group' => __('Single Post', 'blc')
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:single:content:bottom',
				'title' => __('Bottom content', 'blc'),
				'group' => __('Single Post', 'blc'),
				'attr' => ['data-type' => 'full']
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:single:bottom',
				'title' => __('Bottom', 'blc'),
				'group' => __('Single Post', 'blc'),
				'attr' => ['data-type' => 'full']
			],

			[
				'type' => 'action',
				'hook' => 'woocommerce_login_form_start',
				'title' => __('Login form start', 'blc'),
				'group' => __('Auth forms', 'blc')
			],

			[
				'type' => 'action',
				'hook' => 'woocommerce_login_form_end',
				'title' => __('Login form end', 'blc'),
				'group' => __('Auth forms', 'blc')
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:account:modal:login:start',
				'title' => __('Login form modal start', 'blc'),
				'group' => __('Auth forms', 'blc')
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:account:modal:login:end',
				'title' => __('Login form modal end', 'blc'),
				'group' => __('Auth forms', 'blc')
			],

			[
				'type' => 'action',
				'hook' => 'woocommerce_register_form_start',
				'title' => __('Register form start', 'blc'),
				'group' => __('Auth forms', 'blc')
			],

			[
				'type' => 'action',
				'hook' => 'woocommerce_register_form_end',
				'title' => __('Register form end', 'blc'),
				'group' => __('Auth forms', 'blc')
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:account:modal:register:start',
				'title' => __('Register form modal start', 'blc'),
				'group' => __('Auth forms', 'blc')
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:account:modal:register:end',
				'title' => __('Register form modal end', 'blc'),
				'group' => __('Auth forms', 'blc')
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:account:modal:lostpassword:start',
				'title' => __('Lost password form modal start', 'blc'),
				'group' => __('Auth forms', 'blc')
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:account:modal:lostpassword:end',
				'title' => __('Lost password form modal end', 'blc'),
				'group' => __('Auth forms', 'blc')
			],
		],

		$this->get_grouped([
			[
				'hook' => 'woocommerce_before_main_content',
				'title' => __('Before main content', 'blc'),
				'attr' => ['data-type' => 'full']
			],

			[
				'hook' => 'woocommerce_after_main_content',
				'title' => __('After main content', 'blc'),
				'attr' => ['data-type' => 'full']
			]
		], __('WooCommerce Global', 'blc')),

		$this->get_grouped(apply_filters('blocksy:hooks-manager:woocommerce-archive-hooks', [
			[
				'hook' => 'woocommerce_archive_description',
				'title' => __('Archive description', 'blc')
			],

			[
				'hook' => 'woocommerce_before_shop_loop',
				'title' => __('Before shop loop', 'blc')
			],

			/*
			[
				'hook' => 'woocommerce_before_shop_loop_item_title',
				'title' => __('Before shop loop item title', 'blc')
			],

			[
				'hook' => 'woocommerce_after_shop_loop_item_title',
				'title' => __('After shop loop item title', 'blc')
			],
			 */

			[
				'hook' => 'blocksy:woocommerce:product-card:title:before',
				'title' => __('Before shop loop item title', 'blc')
			],

			[
				'hook' => 'blocksy:woocommerce:product-card:title:after',
				'title' => __('After shop loop item title', 'blc')
			],

			[
				'hook' => 'blocksy:woocommerce:product-card:price:before',
				'title' => __('Before shop loop item price', 'blc')
			],

			[
				'hook' => 'blocksy:woocommerce:product-card:price:after',
				'title' => __('After shop loop item price', 'blc')
			],

			[
				'hook' => 'woocommerce_after_shop_loop',
				'title' => __('After shop loop', 'blc')
			],
		]), __('WooCommerce Archive', 'blc')),

		$this->get_grouped([
			[
				'hook' => 'woocommerce_before_single_product',
				'title' => __('Before single product', 'blc'),
				'attr' => ['data-type' => 'full']
			],

			/*
			[
				'hook' => 'woocommerce_before_single_product_summary',
				'title' => __('Before single product summary', 'blc')
			],

			[
				'hook' => 'woocommerce_single_product_summary',
				'title' => __('Single product summary', 'blc')
			],
			 */

			[
				'hook' => 'woocommerce_product_meta_start',
				'title' => __('Product meta start', 'blc')
			],
			[
				'hook' => 'woocommerce_product_meta_end',
				'title' => __('Product meta end', 'blc')
			],
			[
				'hook' => 'woocommerce_share',
				'title' => __('Share', 'blc')
			],
			[
				'hook' => 'woocommerce_after_single_product',
				'title' => __('After single product', 'blc'),
				'attr' => ['data-type' => 'full']
			],

			[
				'hook' => 'blocksy:woocommerce:product-single:excerpt:before',
				'title' => __('Before single product excerpt', 'blc')
			],

			[
				'hook' => 'blocksy:woocommerce:product-single:excerpt:after',
				'title' => __('After single product excerpt', 'blc')
			],

			[
				'hook' => 'blocksy:woocommerce:product-single:tabs:before',
				'title' => __('Before single product tabs', 'blc'),
				'attr' => ['data-type' => 'full']
			],

			[
				'hook' => 'blocksy:woocommerce:product-single:tabs:after',
				'title' => __('After single product tabs', 'blc'),
				'attr' => ['data-type' => 'full']
			],

		], __('WooCommerce Product', 'blc')),

		$this->get_grouped([
			[
				'hook' => 'woocommerce_cart_is_empty',
				'title' => __('Cart is empty', 'blc')
			],
			[
				'hook' => 'woocommerce_before_cart',
				'title' => __('Before cart', 'blc')
			],
			[
				'hook' => 'woocommerce_before_cart_table',
				'title' => __('Before cart table', 'blc')
			],
			[
				'hook' => 'woocommerce_before_cart_contents',
				'title' => __('Before cart contents', 'blc')
			],
			[
				'hook' => 'woocommerce_cart_contents',
				'title' => __('Cart contents', 'blc')
			],
			[
				'hook' => 'woocommerce_after_cart_contents',
				'title' => __('After cart contents', 'blc')
			],
			[
				'hook' => 'woocommerce_cart_coupon',
				'title' => __('Cart coupon', 'blc')
			],
			[
				'hook' => 'woocommerce_cart_actions',
				'title' => __('Cart actions', 'blc')
			],
			[
				'hook' => 'woocommerce_after_cart_table',
				'title' => __('After cart table', 'blc')
			],
			[
				'hook' => 'woocommerce_cart_collaterals',
				'title' => __('Cart collaterals', 'blc')
			],
			[
				'hook' => 'woocommerce_before_cart_totals',
				'title' => __('Before cart totals', 'blc')
			],
			[
				'hook' => 'woocommerce_cart_totals_before_order_total',
				'title' => __('Cart totals before order total', 'blc')
			],
			[
				'hook' => 'woocommerce_cart_totals_after_order_total',
				'title' => __('Cart totals after order total', 'blc')
			],
			[
				'hook' => 'woocommerce_proceed_to_checkout',
				'title' => __('Proceed to checkout', 'blc')
			],
			[
				'hook' => 'woocommerce_after_cart_totals',
				'title' => __('After cart totals', 'blc')
			],
			[
				'hook' => 'woocommerce_after_cart',
				'title' => __('After cart', 'blc')
			],

			[
				'hook' => 'woocommerce_before_mini_cart',
				'title' => __('Before Mini Cart', 'blc')
			],

			[
				'hook' => 'woocommerce_before_mini_cart_contents',
				'title' => __('Before Mini Cart Contents', 'blc')
			],

			[
				'hook' => 'woocommerce_mini_cart_contents',
				'title' => __('Mini Cart Contents', 'blc')
			],

			[
				'hook' => 'woocommerce_widget_shopping_cart_before_buttons',
				'title' => __('Widget Shopping Cart Before Buttons', 'blc')
			],

			[
				'hook' => 'woocommerce_widget_shopping_cart_after_buttons',
				'title' => __('Widget Shopping Cart After Buttons', 'blc')
			],

			[
				'hook' => 'woocommerce_after_mini_cart',
				'title' => __('After Mini Cart', 'blc')
			],
		], __('WooCommerce Cart', 'blc')),


		$this->get_grouped([
			[
				'hook' => 'woocommerce_before_checkout_form',
				'title' => __('Before checkout form', 'blc')
			],
			[
				'hook' => 'woocommerce_checkout_before_customer_details',
				'title' => __('Before customer details', 'blc')
			],
			[
				'hook' => 'woocommerce_checkout_after_customer_details',
				'title' => __('After customer details', 'blc')
			],
			[
				'hook' => 'woocommerce_checkout_billing',
				'title' => __('Checkout billing', 'blc')
			],
			[
				'hook' => 'woocommerce_before_checkout_billing_form',
				'title' => __('Before checkout billing form', 'blc')
			],
			[
				'hook' => 'woocommerce_after_checkout_billing_form',
				'title' => __('After checkout billing form', 'blc')
			],
			[
				'hook' => 'woocommerce_before_order_notes',
				'title' => __('Before order notes', 'blc')
			],
			[
				'hook' => 'woocommerce_after_order_notes',
				'title' => __('After order notes', 'blc')
			],
			[
				'hook' => 'woocommerce_checkout_shipping',
				'title' => __('Checkout shipping', 'blc')
			],
			[
				'hook' => 'woocommerce_checkout_before_order_review',
				'title' => __('Checkout before order review', 'blc')
			],
			[
				'hook' => 'woocommerce_checkout_order_review',
				'title' => __('Checkout order review', 'blc')
			],
			[
				'hook' => 'woocommerce_review_order_before_cart_contents',
				'title' => __('Review order before cart contents', 'blc')
			],
			[
				'hook' => 'woocommerce_review_order_after_cart_contents',
				'title' => __('Review order after cart contents', 'blc')
			],
			[
				'hook' => 'woocommerce_review_order_before_order_total',
				'title' => __('Review order before order total', 'blc')
			],
			[
				'hook' => 'woocommerce_review_order_after_order_total',
				'title' => __('Review order after order total', 'blc')
			],
			[
				'hook' => 'woocommerce_review_order_before_payment',
				'title' => __('Review order before payment', 'blc')
			],
			[
				'hook' => 'woocommerce_review_order_before_submit',
				'title' => __('Review order before submit', 'blc')
			],
			[
				'hook' => 'woocommerce_review_order_after_submit',
				'title' => __('Review order after submit', 'blc')
			],
			[
				'hook' => 'woocommerce_review_order_after_payment',
				'title' => __('Review order after payment', 'blc')
			],
			[
				'hook' => 'woocommerce_checkout_after_order_review',
				'title' => __('Checkout after order review', 'blc')
			],
			[
				'hook' => 'woocommerce_after_checkout_form',
				'title' => __('After checkout form', 'blc')
			],

		], __('WooCommerce Checkout', 'blc')),


		$this->get_grouped([
			[
				'hook' => 'woocommerce_before_my_account',
				'title' => __('Before my account', 'blc')
			],
			[
				'hook' => 'woocommerce_before_account_navigation',
				'title' => __('Before account navigation', 'blc')
			],
			[
				'hook' => 'woocommerce_account_navigation',
				'title' => __('Account navigation', 'blc')
			],
			[
				'hook' => 'woocommerce_after_account_navigation',
				'title' => __('After account navigation', 'blc')
			],
			[
				'hook' => 'woocommerce_account_content',
				'title' => __('Account content', 'blc')
			],
			[
				'hook' => 'woocommerce_account_dashboard',
				'title' => __('Account dashboard', 'blc')
			],
			[
				'hook' => 'woocommerce_after_my_account',
				'title' => __('After my account', 'blc')
			],
		], __('WooCommerce Account', 'blc')),

		[
			[
				'type' => 'action',
				'hook' => 'wp_footer',
				'title' => __('WP footer', 'blc'),
				'group' => __('Footer', 'blc'),
				'attr' => ['data-type' => 'full:bottom-margin']
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:footer:before',
				'title' => __('Footer before', 'blc'),
				'group' => __('Footer', 'blc'),
				'attr' => ['data-type' => 'full']
			],

			[
				'type' => 'action',
				'hook' => 'blocksy:footer:after',
				'title' => __('Footer after', 'blc'),
				'group' => __('Footer', 'blc'),
				'attr' => ['data-type' => 'full']
			]
		]);
	}

	public function humanize_locations($locations) {
		$result = [];

		foreach ($locations as $location) {
			$name = null;

			if ($location['location'] === 'custom_hook') {
				$name = sprintf(
					__('Custom Hook (%s)', 'blc'),
					$location['custom_location']
				);
			}

			if ($location['location'] === 'blocksy:single:content:paragraphs-number') {
				$name = __('After Block Number', 'blc') . ' ' . $location[
					'paragraphs_count'
				];
			}

			if ($location['location'] === 'blocksy:single:content:headings-number') {
				$name = __('Before Heading Number', 'blc') . ' ' . $location[
					'headings_count'
				];
			}

			if (! $name) {
				$maybe_descriptor = $this->find_location_descriptor(
					$location['location']
				);

				if ($maybe_descriptor) {
					$name = $maybe_descriptor['title'];
				}
			}

			if (! $name) {
				$name = $location['location'];
			}

			$result[] = $name;
		}

		return $result;
	}

	private function find_location_descriptor($hook) {
		$all = $this->get_all_hooks();

		foreach ($all as $single_hook) {
			if ($single_hook['hook'] === $hook) {
				return $single_hook;
			}
		}

		return null;
	}

	private function get_grouped($items, $group = null) {
		$result = [];

		foreach ($items as $item) {
			$attr = [];

			if (isset($item['attr'])) {
				$attr = $item['attr'];
			}

			if (is_array($item)) {
				$result[] = array_merge([
					'type' => 'action',
					'attr' => $attr,
					'hook' => $item['hook'],
					'title' => $item['title'],
				], $group ? ['group' => $group] : []);
			} else {
				$result[] = array_merge([
					'type' => 'action',
					'attr' => $attr,
					'hook' => $item,
					'title' => $item,
				], $group ? ['group' => $group] : []);
			}
		}

		return $result;
	}
}

