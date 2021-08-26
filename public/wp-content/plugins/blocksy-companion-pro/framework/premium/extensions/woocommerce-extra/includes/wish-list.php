<?php

class BlocksyWoocommerceExtraWishList {
	private $wish_list_slug = null;

	public function __construct() {
		add_filter(
			'blocksy_customizer_options:woocommerce:general:end',
			function ($opts) {
				$opts[] = blc_call_fn(
					['fn' => 'blocksy_get_options'],
					dirname(__FILE__) . '/wish-list-options.php',
					[], false
				);

				return $opts;
			}
		);

		if ($this->has_any_wish_list()) {
			$this->boot_wish_list();
		}

	}

	public function boot_wish_list() {
		add_filter('blocksy:general:ct-scripts-localizations', function ($data) {
			$data['blc_ext_wish_list'] = [
				'user_logged_in' => is_user_logged_in() ? 'yes' : 'no',
				'list' => $this->get_current_wish_list()
			];

			return $data;
		});

		add_action('init', function () {
			$this->wish_list_slug = apply_filters(
				'blocksy:pro:woocommerce-extra:wish-list:slug',
				'woo-wish-list'
			);

			add_rewrite_endpoint(
				$this->wish_list_slug,
				EP_ROOT | EP_PAGES
			);

			add_action(
				'woocommerce_account_' . $this->wish_list_slug . '_endpoint',
				function () {
					echo blc_call_fn(
						['fn' => 'blocksy_render_view'],
						dirname(__FILE__) . '/wish-list-table.php',
						[]
					);
				}
			);
		});

		add_filter('query_vars', function ($vars) {
			$vars[] = $this->wish_list_slug;
			return $vars;
		}, 0);

		add_filter('blocksy:woocommerce:cart-actions:attr', function ($attr) {
			global $blocksy_is_quick_view;

			if ($blocksy_is_quick_view) {
				$wish_list = blocksy_output_add_to_wish_list('quick-view');

				if (! empty($wish_list)) {
					$attr['data-wishlist-button'] = '';
				}
			} else {
				if (
					(is_product() || wp_doing_ajax())
					&&
					blocksy_manager()->screen->uses_woo_default_template()
				) {
					$wish_list = blocksy_output_add_to_wish_list('single');

					if (! empty($wish_list)) {
						$attr['data-wishlist-button'] = '';
					}
				}
			}

			return $attr;
		});

		add_action('woocommerce_after_add_to_cart_button', function () {
			global $blocksy_is_quick_view;

			if ($blocksy_is_quick_view) {
				echo blocksy_output_add_to_wish_list('quick-view');
			} else {
				if (
					(is_product() || wp_doing_ajax())
					&&
					blocksy_manager()->screen->uses_woo_default_template()
				) {
					echo blocksy_output_add_to_wish_list('single');
				}
			}
		}, 90);

		add_filter('the_content', function ($content) {
			if (get_theme_mod(
				'product_wishlist_display_for',
				'logged_users'
			) === 'logged_users') {
				return $content;
			}

			$maybe_page_id = get_theme_mod('woocommerce_wish_list_page');

			if (empty($maybe_page_id)) {
				return $content;
			}

			if (! is_page($maybe_page_id)) {
				return $content;
			}

			return $content . blc_call_fn(
				['fn' => 'blocksy_render_view'],
				dirname(__FILE__) . '/wish-list-table.php',
				[]
			);
		});

		add_action(
			'woocommerce_account_menu_items',
			function ($items) {
				$logout = $items['customer-logout'];
				unset($items['customer-logout']);

				$items[$this->wish_list_slug] = __('Wish List', 'blc');
				$items['customer-logout'] = $logout;

				return $items;
			}
		);

		add_filter(
			'woocommerce_account_menu_item_classes',
			function ($classes, $endpoint) {
				if ($endpoint === $this->wish_list_slug) {
					$classes[] = 'ct-wish-list';
				}

				return $classes;
			},
			10, 2
		);

		add_action(
			'wp_ajax_blc_ext_wish_list_sync_likes',
			[$this, 'sync_wish_list']
		);

		add_action(
			'wp_ajax_nopriv_blc_ext_wish_list_sync_likes',
			[$this, 'sync_wish_list']
		);

		add_action(
			'wp_login',
			function ($user_login, $user) {
				$cookie_value = $this->get_cookie_wish_list();
				$user_value = $this->get_user_wish_list($user->get('ID'));

				update_user_meta(
					$user->get('ID'),
					'blc_products_wish_list',
					array_values(array_unique(
						array_merge($user_value, $cookie_value)
					))
				);

				setcookie('blc_products_wish_list', false);
			},
			10,
			2
		);
	}

	public function has_any_wish_list() {
		return (
			get_theme_mod('has_archive_wishlist', 'no') === 'yes'
			||
			get_theme_mod('has_single_wishlist', 'no') === 'yes'
			||
			get_theme_mod('has_quick_view_wishlist', 'no') === 'yes'
		);
	}

	public function sync_wish_list() {
		if (! is_user_logged_in()) {
			wp_send_json_error();
		}

		$likes = json_decode(
			file_get_contents('php://input'),
			true
		);

		if (empty($likes)) {
			delete_user_meta(get_current_user_id(), 'blc_products_wish_list');
		} else {
			update_user_meta(get_current_user_id(), 'blc_products_wish_list', $likes);
		}

		wp_send_json_success([]);
	}

	public function get_current_wish_list() {
		if (is_user_logged_in() || isset($_GET['wish_list_id'])) {
			$user_id = get_current_user_id();

			if (isset($_GET['wish_list_id'])) {
				$user_id = $_GET['wish_list_id'];
			}

			return $this->get_user_wish_list($user_id);
		}

		return $this->get_cookie_wish_list();
	}

	private function get_user_wish_list($id) {
		$value = get_user_meta(
			$id,
			'blc_products_wish_list',
			true
		);

		if (! $value) {
			return [];
		}

		return $this->cleanup_wishlist(array_map(function ($id) {
			return intval($id);
		}, $value));
	}

	private function get_cookie_wish_list() {
		if (! isset($_COOKIE['blc_products_wish_list'])) {
			return [];
		}

		$maybe_decoded = json_decode($_COOKIE['blc_products_wish_list']);

		if (! $maybe_decoded) {
			return [];
		}

		if (! is_array($maybe_decoded)) {
			return $this->cleanup_wishlist([intval($maybe_decoded)]);
		}

		return $this->cleanup_wishlist(array_map(function ($id) {
			return intval($id);
		}, $maybe_decoded));
	}

	private function cleanup_wishlist($input) {
		return array_filter($input, function ($item) {
			if (! function_exists('wc_get_product')) {
				return false;
			}

			return !! wc_get_product($item);
		});
	}
}

