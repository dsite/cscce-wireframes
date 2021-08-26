<?php

$config = [
	'enabled' => function_exists('icl_object_id') || function_exists('pll_the_languages') || class_exists('TRP_Translate_Press'),
	'typography_keys' => ['ls_font'],
	'name' => __('Languages', 'blc'),
];
