<?php
/*
Plugin Name: Add People
Plugin URI: https://github.com/rollingryan/add-people
Description: Add workplace people to your WordPress site
Author: Ryan Donald
Version: 1.0
Author URI: https://github.com/rollingryan
License: GPLv2 or later
Text Domain: add-people
*/

// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define('ADD_PEOPLE__PLUGIN_DIR', plugin_dir_path(__FILE__));

register_activation_hook(__FILE__, ['Add_People', 'ap_plugin_activation']);
register_deactivation_hook(__FILE__, ['Add_People', 'ap_plugin_deactivation']);

require_once(ADD_PEOPLE__PLUGIN_DIR . 'class.add-people.php');
// require_once(ADD_PEOPLE__PLUGIN_DIR . 'class.add-people-rest-api.php');

if (is_admin()) {
	add_action('init', ['Add_People', 'ap_person_post_type']);
	add_action('add_meta_boxes', ['Add_People', 'ap_add_custom_boxes']);
	add_action('save_post', ['Add_People', 'ap_save_person_details_fields']);
	add_action('publish_post', ['Add_People', 'ap_save_person_details_fields']);
}