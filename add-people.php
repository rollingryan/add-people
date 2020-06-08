<?php
/*
Plugin Name: Add People
Plugin URI: https://github.com/rollingryan/add-people
Description: WordPress plugin to add workplace people to your website
Author: Ryan Donald
Version: 1.0
Author URI: https://github.com/rollingryan
License: GPLv2 or later
Text Domain: add-people
*/

// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
  echo 'Hi there! I\'m just a plugin, not much I can do when called directly.';
  exit;
}

define('ADD_PEOPLE__PLUGIN_DIR', plugin_dir_path(__FILE__));

// Add custom image sizes
add_image_size('ap_person_thumb', 150, 150, true);
add_image_size('ap_person_full', 500, 500, true);

// Styles
function admin_register_head() {
  $siteurl = get_option('siteurl');
  $url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/client/css/admin.css';
  echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
}

function ap_scripts() {
  $siteurl = get_option('siteurl');
  $cssURL = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/client/css/frontend.css';
  $scriptURL = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/client/js/prod/frontend.js';

  wp_enqueue_style('add-people-frontend-styles', $cssURL);
  wp_enqueue_script('add-people-frontend-script', $scriptURL);
}

register_activation_hook(__FILE__, ['Add-People', 'ap_plugin_activation']);
register_deactivation_hook(__FILE__, ['Add-People', 'ap_plugin_deactivation']);

require_once(ADD_PEOPLE__PLUGIN_DIR . 'class.add-people.php');
require_once(ADD_PEOPLE__PLUGIN_DIR . 'class.add-people-shortcode.php');


// Action hooks for plugin (Only display in admin)
if (is_admin()) {
  add_action('init', ['Add_People', 'ap_person_post_type_shortcode']); // Initialise the class and shortcode
  add_action('add_meta_boxes', ['Add_People', 'ap_add_custom_meta_boxes']); // Add custom meta fields
  add_action('save_post', ['Add_People', 'ap_save_person_fields']); // Save/Update fields
  add_action('admin_head', 'admin_register_head'); // Admin styles
}

// Add shortcode for plugin (Only display on frontend)
if (!is_admin()) {
  add_shortcode('add-people', ['Add_People_Shortcode', 'ap_shortcode']);
  add_action('wp_enqueue_scripts', 'ap_scripts');
}