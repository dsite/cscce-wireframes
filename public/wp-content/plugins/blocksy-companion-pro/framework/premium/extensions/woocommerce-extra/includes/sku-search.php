<?php

add_filter('posts_where', function ($where) {
	if (! function_exists('wc')) {
		return $where;
	}

	global $pagenow, $wpdb, $wp;

	$s = null;

	if (isset($wp->query_vars['s'])) {
		$s = $wp->query_vars['s'];
	}

	if (isset($_GET['search'])) {
		$s = $_GET['search'];
	}

	if (! $s) {
		return $where;
	}

	$search_ids = array();
	$terms = explode(',', $s);

	foreach ($terms as $term) {
		$term = trim($term);

		$sku_to_parent_id = $wpdb->get_col(
			$wpdb->prepare(
				"SELECT p.post_parent as post_id FROM {$wpdb->posts} as p join {$wpdb->postmeta} pm on p.ID = pm.post_id and pm.meta_key='_sku' and pm.meta_value LIKE '%%%s%%' where p.post_parent <> 0 group by p.post_parent",
				wc_clean($term)
			)
		);

		$sku_to_id = $wpdb->get_col(
			$wpdb->prepare(
				"SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='_sku' AND meta_value LIKE '%%%s%%';",
				wc_clean($term)
			)
		);

		$search_ids = array_merge($search_ids, $sku_to_id, $sku_to_parent_id);
	}

	$search_ids = array_unique(array_filter(array_map('absint', $search_ids)));

	if (sizeof($search_ids) > 0) {
		$where = str_replace(
			'))',
			") OR ({$wpdb->posts}.ID IN (" . implode(',', $search_ids) . ")))",
			$where
		);
	}

	return $where;
}, 9, 1);

