<?php

require_once dirname(__FILE__) . '/helpers.php';
require_once dirname(__FILE__) . '/includes/wish-list.php';
require_once dirname(__FILE__) . '/includes/sku-search.php';
require_once dirname(__FILE__) . '/includes/woo-import-export.php';
require_once dirname(__FILE__) . '/includes/wish-list-helpers.php';

class BlocksyExtensionWoocommerceExtra {
	private $wish_list = null;

	public function __construct() {
		$this->wish_list = new BlocksyWoocommerceExtraWishList();

		new BlocksyWoocommerceExtraImportExport();

		add_filter('blocksy:header:items-paths', function ($paths) {
			$paths[] = dirname(__FILE__) . '/header-items';
			return $paths;
		});

		add_action('woocommerce_post_class', function ($classes) {
			if (! is_product()) {
				return $classes;
			}

			if (function_exists('blocksy_woocommerce_has_flexy_view')) {
				if (! blocksy_woocommerce_has_flexy_view()) {
					return $classes;
				}
			}

			global $blocksy_is_quick_view;

			$classes = array_diff($classes, [
				'ct-default-gallery',
				// 'thumbs-left',
				// 'thumbs-bottom'
			]);

			if (! $blocksy_is_quick_view) {
				$product_view_type = get_theme_mod(
					'product_view_type',
					'default-gallery'
				);

				if ($product_view_type !== 'default-gallery') {
					$classes = array_diff($classes, [
						'thumbs-left',
						'thumbs-bottom'
					]);

				}

				$classes[] = 'ct-' . $product_view_type;
			}

			return $classes;
		}, 1500);

		add_filter(
			'blocksy:options:single_product:product-general-tab:start',
			function ($options) {
				$options['product_view_type'] = [
					'label' => false,
					'type' => 'ct-image-picker',
					'value' => 'default-gallery',
					'divider' => 'bottom',
					'choices' => [
						'default-gallery' => [
							'src' => blocksy_image_picker_url( 'woo-gallery-type-1.svg' ),
							'title' => __( 'Type 1', 'blc' ),
						],

						'top-gallery' => [
							'src' => blocksy_image_picker_url( 'woo-gallery-type-2.svg' ),
							'title' => __( 'Type 2', 'blc' ),
						],

						'stacked-gallery' => [
							'src' => blocksy_image_picker_url( 'woo-gallery-type-3.svg' ),
							'title' => __( 'Type 3', 'blc' ),
						],

						'columns-top-gallery' => [
							'src' => blocksy_image_picker_url( 'woo-gallery-type-4.svg' ),
							'title' => __( 'Type 4', 'blc' ),
						],
					],

					'sync' => blocksy_sync_whole_page([
						'loader_selector' => '.woocommerce-product-gallery',
						'prefix' => 'product'
					])
				];

				return $options;
			}
		);

		add_filter(
			'blocksy:options:single_product:gallery-options:start',
			function ($options) {
				$options[blocksy_rand_md5()] = [
					'type' => 'ct-condition',
					'condition' => [ 'product_view_type' => 'stacked-gallery' ],
					'options' => [

						'product_view_stacked_columns' => [
							'label' => __('Number of Columns', 'blc'),
							'type' => 'ct-number',
							'value' => 2,
							'min' => 1,
							'max' => 4,
							'divider' => 'bottom',
							'responsive' => true,
							'sync' => 'live',
							'attr' => [ 'data-position' => 'right' ]
						],
					]
				];

				$options[blocksy_rand_md5()] = [
					'type' => 'ct-condition',
					'condition' => [ 'product_view_type' => 'columns-top-gallery' ],
					'options' => [

						'product_view_columns_top' => [
							'label' => __('Number of Columns', 'blc'),
							'type' => 'ct-number',
							'value' => 3,
							'min' => 1,
							'max' => 6,
							'divider' => 'bottom',
							'responsive' => true,
							'sync' => blocksy_sync_whole_page([
								'loader_selector' => '.woocommerce-product-gallery',
								'prefix' => 'product'
							]),
							'attr' => [ 'data-position' => 'right' ]
						],
					]
				];

				return $options;
			}
		);

		add_filter('blocksy:woocommerce:single_product:flexy-args', function ($args) {
			global $blocksy_is_quick_view;

			$product_view_type = get_theme_mod(
				'product_view_type',
				'default-gallery'
			);

			if (
				! $blocksy_is_quick_view
				&&
				(
					$product_view_type === 'default-gallery'
					||
					$product_view_type === 'top-gallery'
				)
			) {
				$args['pills_container_attr'] = [
					'data-flexy' => 'no'
				];

				if (count($args['images']) <= 4) {
					$args['pills_container_attr']['data-flexy'] .= ':paused';
				}

				$args['pills_have_arrows'] = true;
			}

			if ($product_view_type === 'columns-top-gallery') {
				unset($args['pills_images']);
				$maybe_zoom_icon = '';

				if (
					get_theme_mod('has_product_single_lightbox', 'no') === 'yes'
					&&
					get_theme_mod('has_product_single_zoom', 'yes') === 'yes'
				) {
					$maybe_zoom_icon = '<span class="woocommerce-product-gallery__trigger">🔍</span>';
				}

				$args['slide_inner_content'] = $maybe_zoom_icon;
			}

			return $args;
		});

		add_filter('blocksy:woocommerce:product-review:has-gallery-zoom-trigger', function ($value) {
			$product_view_type = get_theme_mod(
				'product_view_type',
				'default-gallery'
			);

			if ($product_view_type === 'columns-top-gallery') {
				return false;
			}

			return $value;
		});

		add_filter(
			'blocksy:woocommerce:product-view:content',
			function ($content, $product, $gallery_images, $is_single) {
				$product_view_type = get_theme_mod('product_view_type', 'default-gallery');

				if (
					$product_view_type === 'default-gallery'
					||
					$product_view_type === 'top-gallery'
					||
					$product_view_type === 'columns-top-gallery'
				) {
					return null;
				}

				if (! $product) {
					global $product;
				}

				$content = '';

				$single_ratio = get_theme_mod('product_gallery_ratio', '3/4');
				$default_ratio = apply_filters(
					'blocksy:woocommerce:default_product_ratio',
					'3/4'
				);

				$maybe_zoom_icon = '';

				if (
					get_theme_mod('has_product_single_lightbox', 'no') === 'yes'
					&&
					get_theme_mod('has_product_single_zoom', 'yes') === 'yes'
				) {
					$maybe_zoom_icon = '<span class="woocommerce-product-gallery__trigger">🔍</span>';
				}

				foreach ($gallery_images as $image) {
					$attachment_id = $image;

					$image_href = wp_get_attachment_image_src(
						$attachment_id,
						'full'
					);

					$width = null;
					$height = null;

					if ($image_href) {
						$width = $image_href[1];
						$height = $image_href[2];

						$image_href = $image_href[0];
					}

					$content .= blocksy_image([
						'no_image_type' => 'woo',
						'attachment_id' => $image,
						'size' => 'woocommerce_single',
						'ratio' => $is_single ? $single_ratio : $default_ratio,
						'tag_name' => 'a',
						'size' => 'woocommerce_single',
						'html_atts' => array_merge([
							'href' => $image_href
						], $width ? [
							'data-width' => $width,
							'data-height' => $height
						] : []),
						'inner_content' => $maybe_zoom_icon
					]);
				}

				return $content;
			},
			10, 4
		);

		add_filter('blocksy:header:cart:cart_drawer_type:option', function ($type) {
			return 'ct-image-picker';
		}, 10);

		add_filter(
			'blocksy:options:single_product:product-elements:end',
			function ($options) {
				$options[] = blocksy_get_options('single-elements/post-share-box', [
					'prefix' => 'product',
					'has_share_box_type' => false,
					'has_share_box_location1' => false,
					'has_bottom_share_box_spacing' => false,
					'has_share_items_border' => false,

					'general_tab_end' => [
						'product_share_box_icons_size' => [
							'label' => __( 'Icons Size', 'blocksy' ),
							'type' => 'ct-slider',
							'min' => 5,
							'max' => 50,
							'value' => 15,
							'responsive' => true,
							'divider' => 'top',
							'setting' => [ 'transport' => 'postMessage' ],
						],

						'product_share_box_icons_spacing' => [
							'label' => __( 'Icons Spacing', 'blocksy' ),
							'type' => 'ct-slider',
							'min' => 0,
							'max' => 50,
							'value' => 10,
							'responsive' => true,
							'divider' => 'top',
							'setting' => [ 'transport' => 'postMessage' ],
						],
					]
				]);

				return $options;
			}
		);

		add_action(
			'woocommerce_share',
			function () {
				if (! function_exists('blocksy_get_social_share_box')) {
					return;
				}

				if (get_theme_mod('product_has_share_box', 'no') === 'no') {
					return;
				}

				echo blocksy_get_social_share_box([
					'html_atts' => [
						'data-type' => 'type-3'
					],

					'links_wrapper_attr' => [
						'data-icons-type' => 'simple'
					]
				]);
			}
		);

		add_action(
			'blocksy:widgets_init',
			function ($sidebar_title_tag) {
				register_sidebar(
					[
						'name' => esc_html__('WooCommerce Offcanvas Filters', 'blocksy'),
						'id' => 'sidebar-woocommerce-offcanvas-filters',
						'description' => esc_html__('Add widgets here.', 'blocksy'),
						'before_widget' => '<div class="ct-widget %2$s" id="%1$s">',
						'after_widget' => '</div>',
						'before_title' => '<' . $sidebar_title_tag . ' class="widget-title">',
						'after_title' => '</' . $sidebar_title_tag . '>',
					]
				);
			}
		);

		add_action('blocksy:global-dynamic-css:enqueue', function ($args) {
			blocksy_theme_get_dynamic_styles(array_merge([
				'path' => dirname( __FILE__ ) . '/global.php',
				'chunk' => 'woocommerce'
			], $args));
		}, 10, 3);

		add_filter('blocksy-async-scripts-handles', function ($d) {
			$d[] = 'blocksy-ext-woocommerce-extra-scripts';
			return $d;
		});

		add_action('wp_enqueue_scripts', function () {
			if (! function_exists('get_plugin_data')){
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}

			$data = get_plugin_data(BLOCKSY__FILE__);

			if (is_admin()) return;

			wp_enqueue_style(
				'blocksy-ext-woocommerce-extra-styles',
				BLOCKSY_URL . 'framework/premium/extensions/woocommerce-extra/static/bundle/main.min.css',
				['ct-main-styles'],
				$data['Version']
			);

			/*
			wp_enqueue_script(
				'blocksy-ext-woocommerce-extra-scripts',
				BLOCKSY_URL . 'framework/premium/extensions/woocommerce-extra/static/bundle/main.js',
				[
					// 'wc-add-to-cart-variation',
					'ct-scripts',
				],
				$data['Version'],
				true
			);
			 */
		});

		add_filter('blocksy:frontend:dynamic-js-chunks', function ($chunks) {
			if (! class_exists('WC_AJAX')) {
				return $chunks;
			}

			$chunks[] = [
				'id' => 'blocksy_ext_woo_extra_quick_view',
				'selector' => '.ct-open-quick-view, [data-quick-view="image"] .ct-image-container, [data-quick-view="card"] > *',
				'url' => blc_call_fn(
					[
						'fn' => 'blocksy_cdn_url',
						'default' => BLOCKSY_URL . 'framework/premium/extensions/woocommerce-extra/static/bundle/quick-view.js',
					],
					BLOCKSY_URL . 'framework/premium/extensions/woocommerce-extra/static/bundle/quick-view.js'
				),
				'deps' => [
					'underscore',
					'wc-add-to-cart-variation',
					'wp-util'
				],
				'global_data' => [
					[
						'var' => 'wc_add_to_cart_variation_params',
						'data' => [
							'wc_ajax_url'                      => WC_AJAX::get_endpoint( '%%endpoint%%' ),
							'i18n_no_matching_variations_text' => esc_attr__( 'Sorry, no products matched your selection. Please choose a different combination.', 'woocommerce' ),
							'i18n_make_a_selection_text'       => esc_attr__( 'Please select some product options before adding this product to your cart.', 'woocommerce' ),
							'i18n_unavailable_text'            => esc_attr__( 'Sorry, this product is unavailable. Please choose a different combination.', 'woocommerce' ),
						]
					]
				],
				'trigger' => 'click',
				'ignore_click' => '[data-quick-view="card"] > * [data-product_id]'
			];

			$chunks[] = [
				'id' => 'blocksy_ext_woo_extra_wish_list',
				'selector' => '[class*="ct-wishlist-button"], .ct-wishlist-remove, .wishlist-product-remove > .remove, .product-mobile-actions > [href*="wishlist-remove"]',
				'url' => blc_call_fn(
					[
						'fn' => 'blocksy_cdn_url',
						'default' => BLOCKSY_URL . 'framework/premium/extensions/woocommerce-extra/static/bundle/wish-list.js',
					],
					BLOCKSY_URL . 'framework/premium/extensions/woocommerce-extra/static/bundle/wish-list.js'
				),
				'trigger' => 'click'
			];

			$chunks[] = [
				'id' => 'blocksy_ext_woo_extra_floating_cart',
				'selector' => '.ct-floating-bar',
				'url' => blc_call_fn(
					[
						'fn' => 'blocksy_cdn_url',
						'default' => BLOCKSY_URL . 'framework/premium/extensions/woocommerce-extra/static/bundle/wish-list.js',
					],
					BLOCKSY_URL . 'framework/premium/extensions/woocommerce-extra/static/bundle/floating-cart.js'
				),
				'trigger' => 'intersection-observer',
				'position' => 'bottom',
				'target' => '.single-product .single_add_to_cart_button'
			];

			return $chunks;
		});

		add_action(
			'customize_preview_init',
			function () {
				if (! function_exists('get_plugin_data')){
					require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				}

				$data = get_plugin_data(BLOCKSY__FILE__);

				wp_enqueue_script(
					'blocksy-woocommerce-extra-customizer-sync',
					BLOCKSY_URL . 'framework/premium/extensions/woocommerce-extra/static/bundle/sync.js',
					['customize-preview', 'ct-scripts'],
					$data['Version'],
					true
				);
			}
		);

		add_filter(
			'blocksy_woo_card_options_elements',
			function ($opts) {
				$opts[] = blc_call_fn(
					['fn' => 'blocksy_get_options'],
					dirname(__FILE__) . '/customizer.php',
					[], false
				);

				return $opts;
			}
		);

		add_filter(
			'blocksy_single_product_elements_end_customizer_options',
			function ($opts) {
				$opts['has_floating_bar'] = blc_call_fn(
					['fn' => 'blocksy_get_options'],
					dirname(__FILE__) . '/floating-cart.php',
					[], false
				);

				return $opts;
			}
		);

		add_filter(
			'blocksy:options:woocommerce:archive:page-elements-end',
			function ($opts) {
				$opts['has_woo_offcanvas_filter'] = blc_call_fn(
					['fn' => 'blocksy_get_options'],
					dirname( __FILE__ ) . '/offcanvas-filter.php',
					[], false
				);

				return $opts;
			}
		);

		add_action(
			'woocommerce_before_shop_loop',
			function () {
				global $has_woo_offcanvas_filter;
				$has_woo_offcanvas_filter = true;

				if (get_theme_mod('has_woo_offcanvas_filter', 'no') === 'no') {
					return;
				}

				echo blc_get_woo_offcanvas_trigger();
			},
			18
		);

		add_filter('blocksy:footer:offcanvas-drawer', function ($els) {
			if (! function_exists('is_product')) {
				return $els;
			}

			global $has_woo_offcanvas_filter;

			if (
				get_theme_mod('has_woo_offcanvas_filter', 'no') === 'no'
				&&
				! is_customize_preview()
			) {
				return $els;
			}

			if (
				! is_shop()
				&&
				! is_product_category()
				&&
				!is_product_tag()
				&&
				! is_woocommerce()
				&&
				! $has_woo_offcanvas_filter
			) {
				return $els;
			}

			$class = 'ct-panel';

			$behavior = get_theme_mod(
				'filter_panel_position', 'right'
			) . '-side';

			ob_start();
			dynamic_sidebar('sidebar-woocommerce-offcanvas-filters');
			$content = ob_get_clean();

			$without_container = blocksy_html_tag(
				'div',
				array_merge([
					'class' => 'ct-panel-content ct-sidebar',
				]),
				$content
			);

			$els[] = blocksy_html_tag(
				'div',

				[
					'id' => 'woo-filters-panel',
					'class' => $class,
					'data-behaviour' => $behavior
				],

				'<section>
					<div class="ct-panel-actions">
						<h6>' . __('Available Filters', 'blc') . '</h6>
						<span class="ct-close-button">
							<svg class="ct-icon" width="12" height="12" viewBox="0 0 15 15">
								<path d="M1 15a1 1 0 01-.71-.29 1 1 0 010-1.41l5.8-5.8-5.8-5.8A1 1 0 011.7.29l5.8 5.8 5.8-5.8a1 1 0 011.41 1.41l-5.8 5.8 5.8 5.8a1 1 0 01-1.41 1.41l-5.8-5.8-5.8 5.8A1 1 0 011 15z"/>
							</svg>
						</span>
					</div>
				'
				.  $without_container .

				'</section>'
			);

			return $els;
		});

		add_action('woocommerce_single_product_summary', function () {
			$product_view_type = get_theme_mod('product_view_type', 'default-gallery');

			if (
				$product_view_type !== 'top-gallery'
				&&
				$product_view_type !== 'columns-top-gallery'
			) {
				return;
			}

			echo '<section>';
		}, 1);

		add_action('woocommerce_single_product_summary', function () {
			$product_view_type = get_theme_mod('product_view_type', 'default-gallery');

			if (
				$product_view_type !== 'top-gallery'
				&&
				$product_view_type !== 'columns-top-gallery'
			) {
				return;
			}

			echo '</section>';
			echo '<section>';
		}, 25);

		add_action('woocommerce_single_product_summary', function () {
			$product_view_type = get_theme_mod('product_view_type', 'default-gallery');

			if (
				$product_view_type !== 'top-gallery'
				&&
				$product_view_type !== 'columns-top-gallery'
			) {
				return;
			}

			echo '</section>';
		}, 9999999);

		add_filter('blocksy:header:selective_refresh', function ($selective_refresh) {
			$selective_refresh[] = [
				'id' => 'header_placements_item:wish-list',
				'fallback_refresh' => false,
				'container_inclusive' => true,
				'selector' => 'header [data-id="wish-list"]',
				'settings' => ['header_placements'],
				'render_callback' => function () {
					$header = new \Blocksy_Header_Builder_Render();
					echo $header->render_single_item('wish-list');
				}
			];

			return $selective_refresh;
		});

		add_filter('blocksy:hooks-manager:woocommerce-archive-hooks', function ($hooks) {
			$hooks[] = [
				'hook' => 'blocksy:woocommerce:quick-view:title:before',
				'title' => __('Quick view title before', 'blc')
			];

			$hooks[] = [
				'hook' => 'blocksy:woocommerce:quick-view:title:after',
				'title' => __('Quick view title after', 'blc')
			];

			$hooks[] = [
				'hook' => 'blocksy:woocommerce:quick-view:price:before',
				'title' => __('Quick view price before', 'blc')
			];

			$hooks[] = [
				'hook' => 'blocksy:woocommerce:quick-view:price:after',
				'title' => __('Quick view price after', 'blc')
			];

			$hooks[] = [
				'hook' => 'blocksy:woocommerce:quick-view:summary:before',
				'title' => __('Quick view summary before', 'blc')
			];

			$hooks[] = [
				'hook' => 'blocksy:woocommerce:quick-view:summary:after',
				'title' => __('Quick view summary after', 'blc')
			];

			return $hooks;
		});


		add_action(
			'wp_ajax_blocksy_update_qty_cart',
			[$this, 'blocksy_update_qty_cart']
		);
		add_action(
			'wp_ajax_nopriv_blocksy_update_qty_cart',
			[$this, 'blocksy_update_qty_cart']
		);
	}

	public function get_wish_list() {
		return $this->wish_list;
	}

	public function blocksy_update_qty_cart() {
		$cart_item_key = $_POST['hash'];

		$threeball_product_values = WC()->cart->get_cart_item($cart_item_key);

		$threeball_product_quantity = apply_filters(
			'woocommerce_stock_amount_cart_item',
			apply_filters(
				'woocommerce_stock_amount',
				preg_replace(
					"/[^0-9\.]/",
					'',
					filter_var($_POST['quantity'], FILTER_SANITIZE_NUMBER_INT)
				)
			),
			$cart_item_key
		);

		$passed_validation  = apply_filters(
			'woocommerce_update_cart_validation',
			true,
			$cart_item_key,
			$threeball_product_values,
			$threeball_product_quantity
		);

		if ($passed_validation) {
			WC()->cart->set_quantity(
				$cart_item_key,
				$threeball_product_quantity,
				true
			);
		}

		die();
	}
}
