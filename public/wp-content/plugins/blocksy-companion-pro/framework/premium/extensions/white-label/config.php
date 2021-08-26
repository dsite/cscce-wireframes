<?php

$config = [
	'description' => __('Change the theme and companion plugin branding to your own custom one.', 'blc'),
	'pro' => true,
	'hidden' => ! blc_fs()->is_plan('agency')
];

