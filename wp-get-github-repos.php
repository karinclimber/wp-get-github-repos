<?php 
/*
* Plugin Name: WP Get Github Repos
* Descripton: Pulls my GUthub Repos to display in sidebar widget
* Version: 1.0
* Author: Adam John Lea
*/

// Exit if accesed directly
if(!defined('ABSPATH')) {
    exit;
}

require_once(plugin_dir_path( __FILE__ ) . './includes/wp-get-github-repos-scripts.php');
require_once(plugin_dir_path( __FILE__ ) . '/includes/wp-get-github-repos-class.php');

