<?php

$options = [
	'woocommerce_quickview_enabled' => [
		'label' => __( 'Quick View Button', 'blc' ),
		'type' => 'ct-switch',
		'switch' => true,
		'value' => 'yes',
		'divider' => 'top',
		'setting' => [ 'transport' => 'postMessage' ],
		'sync' => blocksy_sync_whole_page([
			'loader_selector' => '[data-products]'
		]),
	],

	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => ['woocommerce_quickview_enabled' => 'yes'],
		'options' => [
			'woocommerce_quick_view_trigger' => [
				'label' => __( 'Trigger On', 'blc' ),
				'type' => 'ct-select',
				'value' => 'button',
				'view' => 'text',
				'design' => 'inline',
				'setting' => [ 'transport' => 'postMessage' ],
				'choices' => blocksy_ordered_keys(
					[
						'button' => __( 'Button click', 'blc' ),
						'image' => __( 'Image click', 'blc' ),
						'card' => __( 'Card click', 'blc' ),
					]
				),

				'sync' => blc_call_fn([
					'fn' => 'blocksy_sync_whole_page',
					'default' => []
				], [
					'loader_selector' => '.site-main .ct-open-quick-view'
				]),
			],
		]
	]
];

