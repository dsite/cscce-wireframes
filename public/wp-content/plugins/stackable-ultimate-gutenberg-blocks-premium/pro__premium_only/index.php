<?php

/**
 * Premium Block Features Initializer.
 */
require_once( plugin_dir_path( __FILE__ ) . 'src/init.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/init-deprecated.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/blog-posts/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/components/panel-design-user-library/ajax.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/welcome/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/icons.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/editor-mode.php' );

/**
 * Dynamic Content
 */
require_once( plugin_dir_path( __FILE__ ) . 'src/dynamic-content/sources/util.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/dynamic-content/sources/other-posts.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/dynamic-content/sources/current-page.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/dynamic-content/sources/acf.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/dynamic-content/sources/site.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/dynamic-content/sources/latest-post.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/dynamic-content/init.php' );
