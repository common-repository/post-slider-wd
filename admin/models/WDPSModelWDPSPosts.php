<?php

class WDPSModelWDPSPosts {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function __construct() {}
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function get_slider_row_data($id) {
    global $wpdb;
    $post_row = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'wdpsslider WHERE id="%d"', $id));
    return $post_row;
  }

  public function get_rows_data() {
    global $wpdb;
    $slider_id = WDW_PS_Library::get('slider_id', 0);
    $featured_image = $wpdb->get_row($wpdb->prepare('SELECT featured_image FROM ' . $wpdb->prefix . 'wdpsslider WHERE id="%d"', $slider_id));
    $feactred_img = ($featured_image != null) ? $featured_image->featured_image : 1;
    $search_value = ((isset($_POST['search_value'])) ? esc_html(stripslashes($_POST['search_value'])) : '');
    $category_id = ((isset($_POST['category_id']) && esc_html(stripslashes($_POST['category_id'])) != -1) ? esc_html(stripslashes($_POST['category_id'])) : '');
    $category_name = $category_id ? get_the_category_by_ID($category_id) : '';
    $post_type = ((isset($_POST['archive-dropdown']) && esc_html(stripslashes($_POST['archive-dropdown'])) != -1) ? esc_html(stripslashes($_POST['archive-dropdown'])) : 'post');
    $asc_or_desc = ((isset($_POST['asc_or_desc'])) ? esc_html(stripslashes($_POST['asc_or_desc'])) : 'ASC');
    $order_by = (isset($_POST['order_by']) ? esc_html(stripslashes($_POST['order_by'])) : 'date');
    if (isset($_POST['page_number']) && $_POST['page_number']) {
      $limit = ((int) $_POST['page_number'] - 1) * 20;
    }
    else {
      $limit = 0;
    }
    $page_limit = (int) ($limit / 20 + 1);
    $args = array(
      'object_type' => array($post_type) 
    );
    $output = 'names'; // or objects
    $operator = 'and'; // 'and' or 'or'
    $taxonomies = get_taxonomies($args,$output,$operator); 
    $argss = array(
      'orderby' => 'id', 
      'order' => 'ASC',
      'hide_empty' => false,
    ); 
    $terms = get_terms($taxonomies, $argss);
      $args = array(
        'posts_per_page' => -1,
        'category_name' => $category_name,
        'orderby' => $order_by,
        'order' => $asc_or_desc,
        'post_type'=> $post_type,
        'post_status' => 'publish',
      );
    $tax_query = array();
    foreach ($taxonomies as $taxonomie) {
      $term = ((isset($_POST['taxonomies_'.$taxonomie]) && esc_html(stripslashes($_POST['taxonomies_'.$taxonomie])) != -1) ? esc_html(stripslashes($_POST['taxonomies_'.$taxonomie])) : '');
      if ($term != '') {
        $tax_query[] = array(
          'taxonomy' => $taxonomie,
          'field' => 'slug',
          'terms' =>  $term
        );
      }
    }
    $args['tax_query'] = $tax_query;
    $posts = get_posts($args);
    $row = array();
    $posts_fildes_names = array();
    $json = array();
    $my_custom_field = array();
    $custom_fields = array();
    $custom_fields_name = array();
    $counter = 0;
    for ($i = 0; $i < count($posts); $i++) {
      $post_fildes_names = array(
        '0' => 'ID',
        '1' => 'post_author',
        '2' => 'post_date',
        '3' => 'post_content',
        '4' => 'post_title',
        '5' => 'post_excerpt',
        '6' => 'post_status',
        '7' => 'post_name',
        '8' => 'to_ping',
        '9' => 'post_modified',
        '10' => 'post_type',
        '11' => 'comment_count',
        '12' => 'filter',
      );
      $post = $posts[$i];
      $jsonik = array();
      if (!post_password_required($post->ID) && ((has_post_thumbnail($post->ID) && $feactred_img) || (!$feactred_img)) && (!$search_value || (stristr($post->post_title, $search_value) !== FALSE))) {
        $counter++;
        if ($counter > $limit && $counter <= $limit + 20) {
          $row[$post->ID] = new stdClass();
          $row[$post->ID]->id = $post->ID;;
          $image_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
          $row[$post->ID]->image_url = $image_url[0];
          $thumb_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail');
          $row[$post->ID]->thumb_url = $thumb_url[0] ? $thumb_url[0] : $image_url[0];
          $row[$post->ID]->title = $post->post_title;
          $row[$post->ID]->date = $post->post_date;
          $row[$post->ID]->modified = $post->post_modified;
          $row[$post->ID]->type = $post->post_type;
          $row[$post->ID]->author = get_the_author_meta('display_name', $post->post_author);
          $row[$post->ID]->link = get_permalink($post->ID);
          $row[$post->ID]->content = strip_tags($post->post_content);
          $custom_fields = get_post_custom($post->ID);
          $custom_fields_name = get_post_custom_keys($post->ID);
          for($k = 0; $k < count($custom_fields_name);++$k) {
            array_push($post_fildes_names,$custom_fields_name[$k]);
          }
          for($j = 0; $j < count($post_fildes_names); ++$j) {
            if($post_fildes_names[$j] == 'post_author') {
              $post_fildes_json[$j] =  $row[$post->ID]->author;
            }
            else {
            if($post_fildes_names[$j] == 'post_content') {
              $post_fildes_json[$j] = $row[$post->ID]->content; 
            }
            else {
              $post_fildes_json[$j] = get_post_field($post_fildes_names[$j],$row[$post->ID]->id);
            }
            }
          }
          $json[$i] = $post_fildes_json;
          $posts_fildes_names[$i] = $post_fildes_names;
        }
     }
    }
    return array($row, $counter, $page_limit, $json, $posts_fildes_names, $feactred_img);
  }

  public function add_more_link($content, $link, $charlength) {
    if (mb_strlen($content) > $charlength) {
      $charlength = mb_strpos($content, ' ', $charlength);
      $subex = mb_substr($content, 0, $charlength);
      return $subex . '<a target=\'_blank\' class=\'wdps_more\'> ...</a>';
    }
    else {
      return $content;
     
    }
  }
  ////////////////////////////////////////////////////////////////////////////////////////
  // Getters & Setters                                                                  //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Private Methods                                                                    //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}