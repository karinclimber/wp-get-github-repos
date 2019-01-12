<?php 
/*
* Plugin Name: WP Get Github Repos
* Descripton: Pulls my Github Repos to display in sidebar widget
* Version: 1.0
* Author: Adam John Lea
*/

// Exit if accesed directly
if(!defined('ABSPATH')) {
    exit;
}

require_once(plugin_dir_path( __FILE__ ) . '/includes/wp-get-github-repos-scripts.php');
require_once(plugin_dir_path( __FILE__ ) . '/includes/wp-get-github-repos-class.php');

// Register Widget
function wpggr_register_widget() {
	register_widget('wp_get_github_repos');
}

add_action('widgets_init', 'wpggr_register_widget');

