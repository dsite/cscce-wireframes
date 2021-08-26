<?php

require_once dirname(__FILE__) . '/sidebars-manager.php';

class BlocksyExtensionSidebars {
	public function __construct() {
		add_action('admin_enqueue_scripts', function () {
			if (! function_exists('get_plugin_data')) {
				require_once(ABSPATH . 'wp-admin/includes/plugin.php');
			}

			$data = get_plugin_data(BLOCKSY__FILE__);

			$current_screen = get_current_screen();

			if (! isset($current_screen->base)) {
				return;
			}

			if ($current_screen->base !== 'widgets') {
				return;
			}

			wp_enqueue_script(
				'blocksy-ext-sidebars-admin-scripts',
				BLOCKSY_URL . 'framework/premium/extensions/sidebars/static/bundle/main.js',
				['ct-options-scripts'],
				$data['Version']
			);

			wp_enqueue_style(
				'blocksy-ext-sidebars-admin-styles',
				BLOCKSY_URL . 'framework/premium/extensions/sidebars/static/bundle/main.min.css',
				[],
				$data['Version']
			);

			wp_localize_script(
				'blocksy-ext-sidebars-admin-scripts',
				'blocksy_ext_sidebars_localization',
				[
					'public_url' => BLOCKSY_URL . 'framework/premium/extensions/sidebars/static/bundle/',
				]
			);
		});

		add_filter(
			'blocksy_sidebar_picker_option',
			function ($option, $actual_option, $args) {
				$actual_option[
					$args['id']
				]['desc'] = sprintf(
					__('Create and manage your custom sidebars %shere%s.'),
					'<a target="_blank" href="' . admin_url('widgets.php') . '">',
					'</a>'
				);

				return $actual_option;
			},
			10,
			3
		);

		add_action('widgets_admin_page', function () {
			echo blc_call_fn(
				['fn' => 'blocksy_render_view'],
				dirname(__FILE__) . '/form.php',
				[]
			);
		});

		add_action('wp_ajax_blocksy_sidebars_create', function () {
			if (! current_user_can('manage_options')) {
				wp_send_json_error();
			}

			if (! isset($_REQUEST['name'])) {
				wp_send_json_error();
			}

			$manager = new BlocksySidebarsManager();

			$manager->set([
				'name' => $_REQUEST['name'],
				'conditions' => []
			]);

			wp_send_json_success([
				'name' => $_REQUEST['name'],
				'conditions' => []
			]);
		});

		add_action('wp_ajax_blocksy_sidebars_remove', function () {
			if (! current_user_can('manage_options')) {
				wp_send_json_error();
			}

			if (! isset($_REQUEST['id'])) {
				wp_send_json_error();
			}

			$manager = new BlocksySidebarsManager();
			$manager->delete($_REQUEST['id']);

			wp_send_json_success();
		});

		add_action('wp_ajax_blocksy_sidebars_list', function () {
			if (! current_user_can('manage_options')) {
				wp_send_json_error();
			}

			$manager = new BlocksySidebarsManager();

			wp_send_json_success([
				'sidebars' => array_values($manager->get_all())
			]);
		});

		add_action('wp_ajax_blocksy_sidebars_update', function () {
			if (! current_user_can('manage_options')) {
				wp_send_json_error();
			}

			$data = json_decode(
				file_get_contents('php://input'),
				true
			);

			$manager = new BlocksySidebarsManager();

			$manager->set($data);

			wp_send_json_success();
		});

		add_action('widgets_init', function () {
			$m = new BlocksySidebarsManager();

			foreach ($m->get_all() as $sidebar_id => $sidebar) {
				$sidebar_title_tag = get_theme_mod('widgets_title_wrapper', 'h2');

				register_sidebar(
					[
						'name'          => $sidebar['name'],
						'id'            => 'ct-dynamic-sidebar-' . $sidebar_id,
						'description'   => esc_html__('Remove Widget Area', 'blocksy'),
						'before_widget' => '<div class="ct-widget %2$s" id="%1$s">',
						'after_widget'  => '</div>',
						'before_title'  => '<' . $sidebar_title_tag . ' class="widget-title">',
						'after_title'   => '</' . $sidebar_title_tag . '>',
					]
				);
			}
		});
	}
}
