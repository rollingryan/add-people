<?php
if (!class_exists('Add_People_Shortcode')) {
  class Add_People_Shortcode {
    /**
      * Add People shortcode callback funtion
      * @param string $attributes an array of the user supplied attributes.
      * @return html $markup Output of the HTML to display people
    */
    public static function ap_shortcode($attributes) {
      if (is_admin()) return;
      // normalize attribute keys, lowercase
      $attributes = array_change_key_case((array)$attributes, CASE_LOWER);
      // override default attributes with user attributes
      $ap_attributes = shortcode_atts([
        'people' => '',
      ], $attributes);

      // Create HTML markup
      $markup = '';

      // Check if people has a value before we continue
      if ( !$attributes['people'] ) {
        return $markup;
      }

      // Sanitize the data and remove white spaces
      $sanitised_people = preg_replace('/\s*,\s*/', ',', filter_var($attributes['people'], FILTER_SANITIZE_STRING));
      // Create our array of values
      $people_array = explode(',', $sanitised_people);

      // Get people args
      $people_args = [
        'post_type'=> 'ap_person',
        'post__in' => $people_array,
      ];

      // Get people posts
      // Do not run the query if there are no post ids provided
      if (count($people_array) > 0) {
        $people_query = new WP_Query($people_args);
        $people = $people_query->get_posts();
      }

      $markup .= '<div class="ap">';

      if ($people && count($people) > 0) :
        foreach ($people as $person) :
          // Setup postmeta variable
          $person_first_name = get_post_meta($person->ID, '_ap_first_name', true);
          $person_last_name = get_post_meta($person->ID, '_ap_last_name', true);
          $person_position = get_post_meta($person->ID, '_ap_position', true);
          $person_description = get_post_meta($person->ID, '_ap_description', true);
          
          $person_img_thumb = get_the_post_thumbnail($person->ID, 'ap_person_thumb');
          $person_img_full = get_the_post_thumbnail($person->ID, 'ap_person_full');
          $person_default_thumb_src = get_option('siteurl') . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/assets/pp.png';
          $person_default_thumb = '<img width="150" height="150" src="' . $person_default_thumb_src . '" class="attachment-ap_person_thumb size-ap_person_thumb wp-post-image" alt="Default profile thumbnail"/>';

          $person_github = get_post_meta($person->ID, '_ap_github', true);
          $person_github = get_post_meta($person->ID, '_ap_linkedin', true);
          $person_github = get_post_meta($person->ID, '_ap_xing', true);
          $person_github = get_post_meta($person->ID, '_ap_facebook', true);

          $markup .= '<div class="ap__item ap__item--' . $person->ID . '">';
          $markup .=   '<div class="ap__thumb">';
          $markup .=      $person_img_thumb ? $person_img_thumb : $person_default_thumb;
          $markup .=    '</div>';
          $markup .=    '<div class="ap__info">';
          $markup .=      '<h4 class="ap__name">';
          $markup .=        $person_first_name . ' ' . $person_last_name;
          $markup .=      '</h4>';
          $markup .=      '<p class="ap__position">';
          $markup .=        $person_position;
          $markup .=      '</p>';
          $markup .=      '<button class="button small ap__trigger">Read more</button>';
          $markup .=    '</div>';
          $markup .=    '<div class="ap__popup">';
          $markup .=      '<span class="ap__popup__overlay ap__trigger"></span>';
          $markup .=      '<div class="ap__popup__window">';
          $markup .=        '<button class="ap__close ap__trigger">&#10005;</button>';
          $markup .=      '</div>';
          $markup .=    '</div>';
          $markup .= '</div>';
        endforeach;
        wp_reset_postdata();
      else:
        $markup .= '<div class="ap__no-posts">';
        $markup .=   '<h3>' . esc_html_e('No people have been added yet.') . '</h3>';
        $markup .= '</div>';
      endif;

      $markup .=  '</div>';
      
      return $markup;
    }
  }
}