<?php
if (!class_exists('Add_People')) {
  class Add_People {

    // Register the "Person" custom post type
    public static function ap_person_post_type() {
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

    public static function ap_add_custom_boxes() {
      add_meta_box(
        'ap_person', // Unique ID
        'Person Details', // Field label
        [self::class, 'ap_person_fields'], // Field HTML markup function
        'ap_person', // Post type
      );
    }

    public static function ap_person_fields($post) {
      $ap_first_name_value = get_post_meta($post->ID, '_ap_first_name', true);
      $ap_last_name_value = get_post_meta($post->ID, '_ap_last_name', true);
      ?>
        <label for="first_name_field">First Name</label>
        <input type="text" name="first_name_field" id="first_name_field" value=<?php echo isset($ap_first_name_value) ? $ap_first_name_value : ''; ?>>

        <label for="last_name_field">Last Name</label>
        <input type="text" name="last_name_field" id="last_name_field" value=<?php echo isset($ap_last_name_value) ? $ap_last_name_value : ''; ?>>
      <?php
    }

    public static function ap_save_person_details_fields($post_id) {
      
      $ap_post_meta_1 = ( isset( $_POST['_custom_meta_key_1'] ) ? $_POST['_custom_meta_key_1'] : false );

      if (isset($_POST['_ap_first_name'])) {
        $person_meta_fields .= [
          "first_name_field",
          "_ap_first_name"
        ];
      }

      if (isset($_POST['_ap_last_name'])) {
        $person_meta_fields .= [
          "last_name_field",
          "_ap_last_name"
        ];
      }

      echo "<pre>";
      var_dump($person_meta_fields);
      echo "</pre>";
      die;

      foreach($person_meta_fields as $person_meta_field) {
        if (array_key_exists($person_meta_field[0], $_POST)) {
          update_post_meta(
            $post_id,
            $person_meta_field[1],
            $_POST[$person_meta_field[0]]
          );
        }
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