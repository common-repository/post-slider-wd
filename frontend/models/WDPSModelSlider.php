<?php

class WDPSModelSlider {
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
  public function __construct() {
  }
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////

  public function get_post_slide_rows_data($id, $order_dir = 'ASC') {
    global $wpdb;
    $my_posts_array = $wpdb->get_row($wpdb->prepare('SELECT dynamic,layer_word_count,author_name,order_by_posts,post_sort,choose_post,posts_count,cache_expiration,taxonomies,featured_image FROM ' . $wpdb->prefix . 'wdpsslider WHERE id="%d"', $id));
    $dynamic = $my_posts_array->dynamic;
    $layer_word_count = $my_posts_array->layer_word_count;
    $post_fildes_name = array(
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
    if ($dynamic == 0) {
      $slide_rows = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'wdpsslide WHERE  published=1 AND title<>"prototype" AND slider_id="%d" ORDER BY `order` '. esc_sql($order_dir), $id));
      $row = array();
      $users = get_users();
      foreach($slide_rows as $key => $slide_row ) {
        $post_fildes_name_current =  $post_fildes_name;
        $custom_fields_name = get_post_custom_keys($slide_row->post_id);
        for ($k = 0; $k < count($custom_fields_name); ++$k) {
          array_push($post_fildes_name_current,$custom_fields_name[$k]);
        }
        $layers_row = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "wdpslayer WHERE slide_id='%d' ORDER BY `depth` ASC", $slide_row->id));
        $slide_row->layer = array(); 
        foreach ($layers_row as $layer) {
          $layer_characters_count = (isset($layer->layer_characters_count)) ? $layer->layer_characters_count : 0;
          if($layer_characters_count == 0) {
            $layer_characters_count = $layer_word_count;
          }
          $string = $layer->text;
          foreach ($post_fildes_name_current as $post_filde_name_curr) {
            if ($post_filde_name_curr == 'post_author') {
              $user_name = '';
              foreach ($users as $user) {
                if (get_post_field('post_author', $slide_row->post_id) == $user->ID) {
                  $user_name = $user->display_name;
                  break;
                }
              }
              $string = str_replace('{' . $post_filde_name_curr . '}', $user_name, $string);
            }
            elseif ($post_filde_name_curr == 'post_date') {
              $filde_val = get_post_field($post_filde_name_curr, $slide_row->post_id);
              $filde_val = (!is_string($filde_val)) ? '' : mysql2date( get_option( 'date_format' ), strip_tags($filde_val) );
              $string = str_replace('{' . $post_filde_name_curr . '}', $filde_val, $string);
            }
            else {
              $filde_val = get_post_field($post_filde_name_curr, $slide_row->post_id);
              $filde_val = (!is_string($filde_val)) ? '' : strip_tags($filde_val);
              $string = str_replace('{' . $post_filde_name_curr . '}', $filde_val, $string);
            }
          }
          if ($layer->remove_shortcode == 1) {
            $string = strip_shortcodes($string);
          }
          $string = $this->add_more_link($string, $layer_characters_count);
          if ($string == '' && $layer->type == 'text') {
            continue;
          }
          $original_value = $layer->text;
          $layer->text = $string;
          $slide_row->layer[] = clone $layer;
          $layer->text = $original_value;
        }
        array_push($row, $slide_row);
      }
    }
    else {
      $slide_rows = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'wdpsslide WHERE  title = "prototype" AND slider_id="%d" AND image_url<>"" ORDER BY `order` asc', $id));
      if ($slide_rows && count($slide_rows)) {
        $slide_id = $slide_rows[0]->id;
        $target_attr_slide = $slide_rows[0]->target_attr_slide;
        $link = $slide_rows[0]->link; 
      }
      $layers_row = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "wdpslayer WHERE slide_id='%d' ORDER BY `depth` ASC", $slide_id));
      $author_name = $my_posts_array->author_name;
      $asc_or_desc = $my_posts_array->order_by_posts;
      $asc_or_desc = ($asc_or_desc == 1)? 'asc' : 'desc';
      $order_by = $my_posts_array->post_sort;
      $post_type = $my_posts_array->choose_post;
      $posts_count = $my_posts_array->posts_count;
      $cache_expiration = $my_posts_array->cache_expiration; 
      $taxonom = $my_posts_array->taxonomies; 
      $featured_image = $my_posts_array->featured_image;
      $cache_expiration_array = preg_split("/[\s,]+/", $cache_expiration);
      $cache_expiration_count = $cache_expiration_array[0];
      $cache_expiration_name = $cache_expiration_array[1];
      if ($order_by =="author") {
        $order_by ='author';
      }
      else if($order_by == 'publishing date') {
        $order_by = 'post_date';
      }
      else if($order_by == 'modification date') {
        $order_by = 'post_modified';
      }
      else if($order_by == 'number of comments') {
        $order_by = 'comment_count';
      }
      else if($order_by == 'post title') {
        $order_by = 'post_title';
      }
      else if($order_by == 'menu order') {
        $order_by = 'menu_order';
      }
      else {
        $order_by ='rand';
      }
      $users = get_users();
      foreach($users as $user){
        if($user->display_name == $author_name) {
          $author_id = $user->ID; 
        }
      }
      if($author_name == ''){
        $author_id = ''; 
      }
      if($cache_expiration_name == 'hour') {
        $newdata_time = time() - ($cache_expiration_count * 60 * 60 );
      }
      else if($cache_expiration_name == 'day'){
        $newdata_day = time() - (1 * 60 * 60 );
        $newdate = new DateTime(date('Y-m-d', $newdata_day));
        $newdate->modify('-'.$cache_expiration_count.' day');
        $newdate->format('Y-m-d');
      }
      else if($cache_expiration_name == 'week') { 
        $newdata_day = time() - (1 * 60 * 60 );
        $newdate = new DateTime(date('Y-m-d', $newdata_day));
        $newdate->modify('-'.$cache_expiration_count.' week');
        $newdate->format('Y-m-d');
      }
      else if ($cache_expiration_name == 'month') {
        $newdata_day = time() - (1 * 60 * 60 );
        $newdate = new DateTime(date('Y-m-d', $newdata_day));
        $newdate->modify('-'.$cache_expiration_count.' month');
        $newdate->format('Y-m-d');
      }
      $argss = array(
       'posts_per_page' => -1,
       'orderby' => $order_by,
       'order' => $asc_or_desc,
       'post_type' => $post_type,
       'author' => $author_id,
       'post_status' => 'publish',
      );
      $args = array(
        'object_type' => array($post_type)
      );
      $output = 'names'; // or objects
      $operator = 'and'; // 'and' or 'or'
      $taxonomies = get_taxonomies($args,$output,$operator);
      $tax_query = array();
      $term = json_decode($taxonom);
      $post_term = array();   
      foreach($term as $terms) {
        $post_term[] = $terms;
      }
      $i = 0;
      foreach ($taxonomies as $taxonomie) {
        if (isset($post_term[$i]) && $post_term[$i] != '') {
          $tax_query[] = array(
            'taxonomy' => $taxonomie,
            'field' => 'slug',
            'terms' =>  explode(',', $post_term[$i])
          );
        }
        $i++;
      }
      $argss['tax_query'] = $tax_query;
      $posts = get_posts($argss);
      $row = array();
      $q = 0;
      foreach ($posts as $key => $post) {
        $post_fildes_name_current =  $post_fildes_name;
          $custom_fields_name = get_post_custom_keys($post->ID);
          for ($k = 0; $k < count($custom_fields_name); ++$k) {
            array_push($post_fildes_name_current, $custom_fields_name[$k]);
          }
		    break;
	    }
      foreach ($posts as $key => $post) {
        if((($featured_image == 1 && has_post_thumbnail($post->ID)) || (!$featured_image)) && !post_password_required($post->ID)) {
          $post_id = $post->ID;
          $posts_data = get_post_field('post_date', $post_id);
          $post->layer = array();
          foreach ($layers_row as $key => $layer) {
            $layer_characters_count = (isset($layer->layer_characters_count)) ? $layer->layer_characters_count : 0;
            if ($layer_characters_count == 0) {
              $layer_characters_count = $layer_word_count;
            }
            $string = $layer->text;
            foreach ($post_fildes_name_current as $post_filde_name) {
              if ($post_filde_name == 'post_author') {
                $string = str_replace('{' . $post_filde_name . '}', get_the_author_meta('display_name', $post->post_author), $string);
              }
              elseif ($post_filde_name == 'post_date') {
                $filde_val = get_post_field($post_filde_name, $post_id);
                $filde_val = (!is_string($filde_val)) ? '' : mysql2date( get_option( 'date_format' ), strip_tags($filde_val) );
                $string = str_replace('{' . $post_filde_name . '}', $filde_val, $string);
              }
              else {
                $filde_val = get_post_field($post_filde_name, $post_id);
                $filde_val = (!is_string($filde_val)) ? '' : strip_tags($filde_val);
                $string = str_replace('{' . $post_filde_name . '}', $filde_val, $string);
              }
            }
            if ($layer->remove_shortcode == 1) {
              $string = strip_shortcodes($string);
            }
            $string = $this->add_more_link($string, $layer_characters_count);
            if ($string == '' && $layer->type == 'text') { 
              continue;
            } 
            $original_value = $layer->text;
            $layer->text = $string;
            $post->layer[] = clone $layer;
            $layer->text = $original_value; 
          }
          if( $cache_expiration_count == 0 || $cache_expiration_name == '' ) {
            array_push($row, $post);
            if ($posts_count != 0) {
              $q++;
            }
          }
          else {
            if($cache_expiration_name != 'hour' && $newdate->format('Y-m-d') <= $posts_data) {
              array_push($row,$post);
              if ($posts_count != 0) {
                $q++;
              }
            }
            else if ($cache_expiration_name == 'hour' && date('Y-m-d H:i:s',$newdata_time) <= $posts_data ) {
              array_push($row,$post);
               if ($posts_count != 0) {
                $q++;
              }
            }
          }
          $post->link = $link;
          $post->target_attr_slide = $target_attr_slide;
        }
        if ($posts_count != 0 && $q >= $posts_count) {
          break;
        }
      }
    }
    return $row;
  }

  public function get_post_slider_row_data($id) {
    global $wpdb;
    $row = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'wdpsslider WHERE id="%d"', $id));
    return $row;
  }

  public function add_more_link($content, $charlength) {
    if (mb_strlen($content) > $charlength) {
      $a = $charlength;
      $charlength = mb_strpos($content, ' ', $charlength);
      if($charlength == false) {
        $charlength = $a;
      }
      $subex = mb_substr($content, 0, $charlength);
      $subex = $this->closetags($subex);
      return $subex . '<a target=\'_blank\' class=\'wdps_more\'>&hellip;</a>';
    }
    else {
      $content = $this->closetags($content);
      return $content;
    }
  }

  public function closetags($html) {
    preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
    $openedtags = $result[1];
    preg_match_all('#</([a-z]+)>#iU', $html, $result);
    $closedtags = $result[1];
    $len_opened = count($openedtags);
    if (count($closedtags) == $len_opened) {
      return $html;
    }
    $openedtags = array_reverse($openedtags);
    for ($i = 0; $i < $len_opened; $i++) {
      if (!in_array($openedtags[$i], $closedtags)){
        $html .= '</'.$openedtags[$i].'>';
      }
      else {
        unset($closedtags[array_search($openedtags[$i], $closedtags)]);
      }
    }
    return $html;
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