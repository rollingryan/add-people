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
add_image_size('ap_person_thumb', 50, 50);
add_image_size('ap_person_full', 200, 200);

// Styles
function admin_register_head() {
  $siteurl = get_option('siteurl');
  $url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/add-people-cpt-styles.css';
  echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
}

// Gutenberg block editor assets
function ap_gutenberg_block_admin() {
  wp_enqueue_script(
    'gutenberg-add-people-block-editor',
    plugins_url('add-people-block.js', __FILE__),
    ['wp-blocks', 'wp-element']
  );

  wp_enqueue_style(
    'gutenberg-add-people-block-editor',
    plugins_url('add-people-block-styles.css', __FILE__),
    []
  );
}

// Frontend Assets
function ap_gutenberg_block_frontend() {
  wp_enqueue_style(
    'gutenberg-add-people-block-editor',
    plugins_url('add-people-block-styles.css', __FILE__),
    []
  );
}

register_activation_hook(__FILE__, ['Add-People', 'ap_plugin_activation']);
register_deactivation_hook(__FILE__, ['Add-People', 'ap_plugin_deactivation']);

require_once(ADD_PEOPLE__PLUGIN_DIR . 'class.add-people.php');
// require_once(ADD_PEOPLE__PLUGIN_DIR . 'class.add-people-rest-api.php');

// Action hooks for plugin
if (is_admin()) {
  add_action('init', ['Add_People', 'ap_person_post_type']); // Initialise the class
  add_action('add_meta_boxes', ['Add_People', 'ap_add_custom_meta_boxes']); // Add custom meta fields
  add_action('save_post', ['Add_People', 'ap_save_person_fields']); // Save/Update fields
  add_action('admin_head', 'admin_register_head'); // Admin styles
  add_action('enqueue_block_editor_assets', 'ap_gutenberg_block_admin'); // Load assets when editor is active
  add_action('wp_enqueue_scripts', 'ap_gutenberg_block_frontend'); // Load assets for frontend
}