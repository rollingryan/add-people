<?php
if (!class_exists('Add_People')) {
  class Add_People {
    // Register the 'Person' custom post type
    public static function ap_person_post_type_shortcode() {
      // Add post type
      register_post_type('ap_person',
        [
          'labels' => [
            'name' => __('People', 'add-people'),
            'singular_name' => __('Person', 'add-people'),
            'add_new' => __('Add New Person', 'add-people'),
            'add_new_item' => __('Add New Person', 'add-people'),
            'edit_item' => __('Edit Person', 'add-people'),
            'new_item' => __('New Person', 'add-people'),
            'all_items' => __('All People', 'add-people'),
            'view_item' => __('View People', 'add-people'),
            'search_items' => __('Search People', 'add-people'),
            'not_found' => __('No people found', 'add-people'),
            'not_found_in_trash' => __('No people found in Trash', 'add-people'),
            'parent_item_colon' => __('', 'add-people'),
            'menu_name' => __('People', 'add-people'),
          ],
          'description' => __('Add people that belong to your organisation.', 'add-people'),
          'public' => true,
          'publicly_queryable' => true,
          'exclude_from_search' => true,
          'show_ui' => true,
          'show_in_menu' => true,
          'show_in_nav_menus' => false,
          'show_in_rest' => true,
          'menu_icon' => 'dashicons-businessperson',
          'query_var' => true,
          'rewrite' => ['slug' => 'ap_person'],
          'capability_type' => 'post',
          'has_archive' => false,
          'hierarchical' => false,
          'supports' => ['title', 'thumbnail']
        ]
      );
    }

    public static function ap_add_custom_meta_boxes() {
      add_meta_box(
        'ap_person_details', // Unique ID
        'Details', // Box label
        [self::class, 'ap_person_custom_fields'], // Field HTML markup function
        'ap_person', // Post type
      );
    }

    public static function ap_person_custom_fields($post) {
      $ap_first_name_value = get_post_meta($post->ID, '_ap_first_name', true);
      $ap_last_name_value = get_post_meta($post->ID, '_ap_last_name', true);
      $ap_position_value = get_post_meta($post->ID, '_ap_position', true);
      $ap_description_value = get_post_meta($post->ID, '_ap_description', true);
      $ap_github_value = get_post_meta($post->ID, '_ap_github', true);
      $ap_linkedin_value = get_post_meta($post->ID, '_ap_linkedin', true);
      $ap_xing_value = get_post_meta($post->ID, '_ap_xing', true);
      $ap_facebook_value = get_post_meta($post->ID, '_ap_facebook', true);
      ?>
        <ul class='ap-custom-fields'>
          <li class='ap-custom-fields__field'>
            <label class='ap-custom-fields__field--label' for='first_name_field'>First Name: </label>
            <input class='ap-custom-fields__field--element' type='text' name='first_name_field' id='first_name_field' value="<?php echo isset($ap_first_name_value) ? esc_attr($ap_first_name_value) : ''; ?>">
          </li>

          <li class='ap-custom-fields__field'>
            <label class='ap-custom-fields__field--label' for='last_name_field'>Last Name: </label>
            <input class='ap-custom-fields__field--element' type='text' name='last_name_field' id='last_name_field' value="<?php echo isset($ap_last_name_value) ? esc_attr($ap_last_name_value) : ''; ?>">
          </li>

          <li class='ap-custom-fields__field'>
            <label class='ap-custom-fields__field--label' for='position_field'>Position: </label>
            <input class='ap-custom-fields__field--element' type='text' name='position_field' id='position_field' value="<?php echo isset($ap_position_value) ? esc_attr($ap_position_value) : ''; ?>">
          </li>

          <li class='ap-custom-fields__field'>
            <label class='ap-custom-fields__field--label' for='description_field'>Description: </label>
            <!-- php tags broken over different lines to avoid extra whitespace and keep code readable -->
            <textarea class='ap-custom-fields__field--element' name='description_field' id='description_field' rows='3' cols='50' maxlength='255' placeholder='Enter a description for this person... (max characters: 255)'><?php
              if (isset($ap_description_value)) {
                echo esc_html($ap_description_value);
              }
            ?></textarea>
          </li>

          <li class='ap-custom-fields__field'>
            <label class='ap-custom-fields__field--label' for='github_field'>Github Link: </label>
            <input class='ap-custom-fields__field--element' type='url' name='github_field' id='github_field' value="<?php echo isset($ap_github_value) ? esc_url($ap_github_value) : ''; ?>">
          </li>

          <li class='ap-custom-fields__field'>
            <label class='ap-custom-fields__field--label' for='linkedin_field'>LinkedIn Link: </label>
            <input class='ap-custom-fields__field--element' type='url' name='linkedin_field' id='linkedin_field' value="<?php echo isset($ap_linkedin_value) ? esc_url($ap_linkedin_value) : ''; ?>">
          </li>

          <li class='ap-custom-fields__field'>
            <label class='ap-custom-fields__field--label' for='xing_field'>Xing Link: </label>
            <input class='ap-custom-fields__field--element' type='url' name='xing_field' id='xing_field' value="<?php echo isset($ap_xing_value) ? esc_url($ap_xing_value) : ''; ?>">
          </li>

          <li class='ap-custom-fields__field'>
            <label class='ap-custom-fields__field--label' for='facebook_field'>Facebook Link: </label>
            <input class='ap-custom-fields__field--element' type='url' name='facebook_field' id='facebook_field' value="<?php echo isset($ap_facebook_value) ? esc_url($ap_facebook_value) : ''; ?>">
          </li>
        </ul>
      <?php
    }

    public static function ap_save_person_fields($post_id) {
      // Personal Details
      if (array_key_exists('first_name_field', $_POST)) {
        update_post_meta(
          $post_id,
          '_ap_first_name',
          $_POST['first_name_field']
        );
      }

      if (array_key_exists('last_name_field', $_POST)) {
        update_post_meta(
          $post_id,
          '_ap_last_name',
          $_POST['last_name_field']
        );
      }

      if (array_key_exists('position_field', $_POST)) {
        update_post_meta(
          $post_id,
          '_ap_position',
          $_POST['position_field']
        );
      }

      if (array_key_exists('description_field', $_POST)) {
        update_post_meta(
          $post_id,
          '_ap_description',
          $_POST['description_field']
        );
      }

      // Social Media Links
      if (array_key_exists('github_field', $_POST)) {
        update_post_meta(
          $post_id,
          '_ap_github',
          $_POST['github_field']
        );
      }

      if (array_key_exists('linkedin_field', $_POST)) {
        update_post_meta(
          $post_id,
          '_ap_linkedin',
          $_POST['linkedin_field']
        );
      }

      if (array_key_exists('xing_field', $_POST)) {
        update_post_meta(
          $post_id,
          '_ap_xing',
          $_POST['xing_field']
        );
      }

      if (array_key_exists('facebook_field', $_POST)) {
        update_post_meta(
          $post_id,
          '_ap_facebook',
          $_POST['facebook_field']
        );
      }
    }

    public static function ap_plugin_activation() {
      // Trigger our function that registers the custom post type plugin.
      self::ap_person_post_type(); 
      // Clear the permalinks after the post type has been registered.
      flush_rewrite_rules();
    }
    
    public static function ap_plugin_deactivation() {
      // Trigger our function that registers the custom post type plugin.
      unregister_post_type('ap_person'); 
      // Clear the permalinks after the post type has been registered.
      flush_rewrite_rules();
    }
  }
}