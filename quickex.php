<?php
/**
 * Plugin Name:       Quickex plugin
 * Plugin URI:        https://quickex.io/en/wordpress
 * Description:       Create your own exchanger based on free CMS Wordpress with Quickex widget.
 * Version:           0.9.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Quickex
 * Author URI:        https://quickex.io/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Network: true
 */

require_once(plugin_dir_path(__FILE__) . 'class.quickex.php');

add_action('init', ['Quickex', 'init']);