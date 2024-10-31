<?php

class WDPSModelSliders_wdps {
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

  public function get_slides_count($slider_id, $dynamic = 0) {
    global $wpdb;
    if ($dynamic == 0) {
      $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM " . $wpdb->prefix . "wdpsslide WHERE slider_id='%d' AND title<>'prototype'", $slider_id));
    }
    else {
      $my_post_row = $wpdb->get_row($wpdb->prepare('SELECT choose_post,post_sort,author_name,cache_expiration,taxonomies,posts_count,featured_image FROM ' . $wpdb->prefix . 'wdpsslider WHERE id="%d"', $slider_id));
      $post_type = $my_post_row->choose_post;
      $author_name = $my_post_row->author_name;
      $cache_expiration_array = preg_split("/[\s,]+/", $my_post_row->cache_expiration);
      $cache_expiration_count = $cache_expiration_array[0];
      $cache_expiration_name = $cache_expiration_array[1];
      $order_by = $my_post_row->post_sort;
      $posts_count = $my_post_row->posts_count;
      $taxonom = $my_post_row->taxonomies; 
      $users = get_users();
      foreach ($users as $user) {
        if ($user->display_name == $author_name) {
          $author_id = $user->ID; 
        }
      }
      if ($author_name == '') {
        $author_id = ''; 
      }
      if ($order_by =="author") {
        $order_by = 'author';
      }
      if ($cache_expiration_name == 'hour') {
        $newdata_time = time() - ($cache_expiration_count * 60 * 60 );
      }
      else if ($cache_expiration_name == 'day') {
        $newdata_day = time() - (1 * 60 * 60 );
        $newdate = new DateTime(date('Y-m-d', $newdata_day));
        $newdate->modify('-'.$cache_expiration_count.' day');
        $newdate->format('Y-m-d');
      }
      else if ($cache_expiration_name == 'week') { 
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
      $post_term =array();   
      foreach($term as $terms) {
        $post_term[] = $terms;
      }
      $i = 0;
      foreach($taxonomies as $taxonomie) {
        if (isset($post_term[$i]) && $post_term[$i] !='') {
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
      $q = 0;
      foreach($posts as $post) {
        if($post && ((has_post_thumbnail($post->ID) && $my_post_row->featured_image == 1) || (!$my_post_row->featured_image)) && !post_password_required($post->ID)) {
          $posts_data = get_post_field('post_date',$post->ID);
          if( $cache_expiration_count == 0 || $cache_expiration_name == '' ) {
            $q++;
          }
          else {      
            if($cache_expiration_name != 'hour' && $newdate->format('Y-m-d') <= $posts_data) {
              $q++;
            }
            else if ($cache_expiration_name == 'hour' && date('Y-m-d H:i:s',$newdata_time) <= $posts_data ) {
              $q++;
            }
          }
          if($posts_count != 0 && $q >= $posts_count) {
            break;
          }
        }
      }
      $count = $q;
    }
    return $count;
  }

  public function get_slides_row_data($slider_id) {
    global $wpdb;
    $rows = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "wdpsslide WHERE slider_id='%d' ORDER BY `order` ASC", $slider_id));
    if (!$rows) {
      $rows = array();
      $rows[0] = new stdClass();
      $rows[0]->id = 'pr1';
      $rows[0]->title = 'prototype';
      $rows[0]->post_id = 0;
      $rows[0]->type = 'image';
      $rows[0]->image_url = WD_PS_URL . '/images/watermark_preview.jpg';
      $rows[0]->thumb_url = WD_PS_URL . '/images/watermark_preview.jpg';
      $rows[0]->published = 1;
      $rows[0]->link = '';
      $rows[0]->order = 1;
      $rows[0]->target_attr_slide = 0;
    }
    else {
      foreach ($rows as $row) {
        if ($row->type == 'image') {
          $row->image_url = $row->image_url ? $row->image_url : '';
          $row->thumb_url = $row->thumb_url ? $row->thumb_url : '';
        }
      }
    }
    return $rows;
  }

  public function get_layers_row_data($slide_id, $post_id) {
    global $wpdb;
    $rows = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "wdpslayer WHERE slide_id='%d' ORDER BY `depth` ASC", $slide_id));
    if (!$rows && $post_id == 0 && $slide_id == 0) {
      $rows = array();
      $rows[0] = new stdClass();
      $rows[0]->id = 'pr_';
      $rows[0]->type = 'text';
      $rows[0]->title = 'Layer 1';
      $rows[0]->depth = 1;
      $rows[0]->text = get_option("wdps_fv022") ? "<b style='font-size:inherit;'>{post_title}</b>\n{post_content}" : "{post_content}";
      $rows[0]->image_width = 0;
      $rows[0]->image_height= 0;
      $rows[0]->image_scale = 'on';
      $rows[0]->left = 0;
      $rows[0]->top = 0;
      $rows[0]->start = 1000;
      $rows[0]->end = 3000;
      $rows[0]->color = 'FFFFFF';
      $rows[0]->size = 18;
      $rows[0]->ffamily = 'arial';
      $rows[0]->fweight = 'lighter';
      $rows[0]->transparent = 50;
      $rows[0]->layer_effect_in ='none';
      $rows[0]->duration_eff_in = 1000;
      $rows[0]->layer_effect_out='none';
      $rows[0]->duration_eff_out = 3000;
      $rows[0]->padding = '5px';
      $rows[0]->fbgcolor = '000000';
      $rows[0]->imgtransparent = 0;
      $rows[0]->border_width = 2;
      $rows[0]->border_style = 'none';
      $rows[0]->border_color = 'FFFFFF';
      $rows[0]->border_radius ='2px';
      $rows[0]->position = '';
      $rows[0]->radius = '';
      $rows[0]->social_buttum = '';
      $rows[0]->hover_color = '';
      $rows[0]->shadow = '';
      $rows[0]->published = 1;
      $rows[0]->alt = '';
      $rows[0]->link = '';
      $rows[0]->google_fonts = '';
      $rows[0]->target_attr_layer = 0;
      $rows[0]->layer_characters_count = 250;
      $rows[0]->align_layer = 0;
      $rows[0]->text_alignment = 'left';
      $rows[0]->remove_shortcode = 1;
      $rows[0]->infinite_in = 1;
      $rows[0]->infinite_out = 1;
      $rows[0]->hover_color_text = '';
      $rows[0]->min_size = 11;
    }
    else {
      foreach ($rows as $row) {
        if ($row->type == 'image') {
          $row->image_url = $row->image_url ? $row->image_url : WD_PS_URL . '/images/no-image.png';
        }
      }
    }
    return $rows;
  }

  public function get_slider_prev_img($slider_id) { 
    global $wpdb;
    $my_post_row = $wpdb->get_row($wpdb->prepare('SELECT dynamic,choose_post,post_sort,author_name,order_by_posts,cache_expiration,taxonomies,posts_count,featured_image FROM ' . $wpdb->prefix . 'wdpsslider WHERE id="%d"', $slider_id));
    if ($my_post_row->dynamic == 0) {
      $prev_img_url = $wpdb->get_var($wpdb->prepare("SELECT `image_url` FROM " . $wpdb->prefix . "wdpsslide WHERE title<>'prototype' AND slider_id='%d' ORDER BY `order` ASC", $slider_id));
    }
    else {
      $prev_img_url = $wpdb->get_var($wpdb->prepare("SELECT `image_url` FROM " . $wpdb->prefix . "wdpsslide WHERE title='prototype' AND slider_id='%d' ORDER BY `order` ASC", $slider_id));
      $post_type = $my_post_row->choose_post;
      $asc_or_desc = ($my_post_row->order_by_posts == 1)? 'asc' : 'desc';
      $author_name = $my_post_row->author_name;
      $cache_expiration_array = preg_split("/[\s,]+/", $my_post_row->cache_expiration);
      $cache_expiration_count = $cache_expiration_array[0];
      $cache_expiration_name = $cache_expiration_array[1];
      $order_by = $my_post_row->post_sort;
      $posts_count = $my_post_row->posts_count;
      $taxonom = $my_post_row->taxonomies; 
      $users = get_users();
      foreach ($users as $user) {
        if ($user->display_name == $author_name) {
          $author_id = $user->ID; 
        }
      }
      if ($author_name == '') {
        $author_id = ''; 
      }
      if ($order_by =="author") {
        $order_by = 'author';
      }
      else if ($order_by == 'publishing date') {
        $order_by = 'post_date';
      }
      else if ($order_by == 'modification date') {
        $order_by = 'post_modified';
      }
      else if ($order_by == 'number of comments') {
        $order_by = 'comment_count';
      }
      else if ($order_by == 'post title') {
        $order_by = 'post_title';
      }
      else if ($order_by == 'menu order') {
        $order_by = 'menu_order';
      }
      else {
        $order_by ='rand';
      }
      if ($cache_expiration_name == 'hour') {
        $newdata_time = time() - ($cache_expiration_count * 60 * 60 );
      }
      else if ($cache_expiration_name == 'day') {
        $newdata_day = time() - (1 * 60 * 60 );
        $newdate = new DateTime(date('Y-m-d', $newdata_day));
        $newdate->modify('-'.$cache_expiration_count.' day');
        $newdate->format('Y-m-d');
      }
      else if ($cache_expiration_name == 'week') { 
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
      $q = 0;
      foreach ($posts as $post) {
        if ($post && ((has_post_thumbnail($post->ID) && $my_post_row->featured_image == 1) || (!$my_post_row->featured_image)) && !post_password_required($post->ID)) {
          $posts_data = get_post_field('post_date',$post->ID);
          if ($cache_expiration_count == 0 || $cache_expiration_name == '') {
            $thumb_id = get_post_thumbnail_id($post->ID);
            $prev_img_url = wp_get_attachment_url($thumb_id);
              if ($posts_count != 0) {
                $q++;
              }
            break;
          }
          else {      
            if ($cache_expiration_name != 'hour' && $newdate->format('Y-m-d') <= $posts_data) {
              $thumb_id = get_post_thumbnail_id($post->ID);
              $prev_img_url = wp_get_attachment_url($thumb_id);
                if($posts_count != 0) {
                  $q++;
                }
              break;
            }
            else if ($cache_expiration_name == 'hour' && date('Y-m-d H:i:s',$newdata_time) <= $posts_data ) {
              $thumb_id = get_post_thumbnail_id($post->ID);
              $prev_img_url = wp_get_attachment_url($thumb_id);
              if($posts_count != 0) {
                $q++;
              }
              break;
            }
          }
          if ($posts_count != 0 && $q >= $posts_count) {
            break;
          }     
        }
      }
      if (!$prev_img_url) {
        $prev_img_url = WD_PS_URL . '/images/watermark_preview.jpg';
      }
    }
    $prev_img_url = ($prev_img_url)? $prev_img_url : WD_PS_URL . '/images/no-image.png';
    return $prev_img_url;
  }

  public function get_rows_data() {
    global $wpdb;
    $post_type = ((isset($_POST['archive-dropdown']) && esc_html(stripslashes($_POST['archive-dropdown'])) != -1) ? esc_html(stripslashes($_POST['archive-dropdown'])) : '');
    $args = array(
      'object_type' => array($post_type) 
    ); 
    $output = 'names'; // or objects
    $operator = 'and'; // 'and' or 'or'
    $taxonomies = get_taxonomies($args, $output, $operator); 
    foreach ($taxonomies as $taxonomie) {
      $termsss = ((isset($_POST['taxonomies_'.$taxonomie]) && esc_html(stripslashes($_POST['taxonomies_'.$taxonomie])) != -1) ? esc_html(stripslashes($_POST['taxonomies_'.$taxonomie])) : '');
    }
    $where = ((isset($_POST['search_value'])) ? 'WHERE name LIKE "%' . esc_html(stripslashes($_POST['search_value'])) . '%"' : '');
    $asc_or_desc = ((isset($_POST['asc_or_desc']) && esc_html($_POST['asc_or_desc']) == 'desc') ? 'desc' : 'asc');
    $order_by_arr = array('id', 'name', 'published');
    $order_by = ((isset($_POST['order_by']) && in_array(esc_html($_POST['order_by']), $order_by_arr)) ? esc_html($_POST['order_by']) : 'id');
    $order_by = ' ORDER BY `' . $order_by . '` ' . $asc_or_desc;
    if (isset($_POST['page_number']) && $_POST['page_number']) {
      $limit = ((int) $_POST['page_number'] - 1) * 20;
    }
    else {
      $limit = 0;
    }
    $query = "SELECT * FROM " . $wpdb->prefix . "wdpsslider " . $where . $order_by . " LIMIT " . $limit . ",20";
    $rows = $wpdb->get_results($query);
    return $rows;
  }

  public function get_row_data($id, $reset) {
    global $wpdb;
    if ($id != 0 && !$reset) {
      $row = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'wdpsslider WHERE id="%d"', $id));
      if ($row) {
        $row->enable_bullets = $row->bull_position == 'none' ? 0 : 1;
        $row->enable_filmstrip = $row->film_pos == 'none' ? 0 : 1;
        $row->enable_time_bar = $row->timer_bar_type == 'none' ? 0 : 1;
      }
    }
    else {
      $row = new stdClass();
      if ($reset && $id) {
        $row = $wpdb->get_row($wpdb->prepare('SELECT name FROM ' . $wpdb->prefix . 'wdpsslider WHERE id="%d"', $id));
      }
      else {
        $row->name = '';
      }
      $row->id = $id;
      $row->width = 800;
      $row->height = 300;
      $row->full_width = 0; 
      $row->bg_fit = 'cover';
      $row->align = 'center';
      $row->effect = 'fade';
      $row->published = 1;
      $row->time_intervval = 5;
      $row->autoplay = 0;
      $row->shuffle = 0;
      $row->music = 0;
      $row->music_url = '';
      $row->preload_images = 1;
      $row->background_color = '000000';
      $row->background_transparent = 100;
      $row->glb_border_width = 0;
      $row->glb_border_style = 'none';
      $row->glb_border_color = '000000';
      $row->glb_border_radius = '';
      $row->glb_margin = 0;
      $row->glb_box_shadow = '';
      $row->image_right_click = 0;
      $row->layer_out_next = 0;
      $row->layer_word_count = 250;
      $row->prev_next_butt = 1;
      $row->play_paus_post_butt = 0;
      $row->navigation = 'hover';
      $row->rl_butt_style = 'fa-angle';
      $row->rl_butt_size = 40;
      $row->pp_butt_size = 40;
      $row->butts_color = '000000';
      $row->hover_color = '000000';
      $row->nav_border_width = 0;
      $row->nav_border_style = 'none';
      $row->nav_border_color = 'FFFFFF';
      $row->nav_border_radius = '20px';
      $row->nav_bg_color = 'FFFFFF';
      $row->butts_transparent = 100;
      $row->enable_bullets = 1;
      $row->bull_position = 'bottom';
      $row->bull_style = 'fa-square-o';
      $row->bull_size = 20;
      $row->bull_color = 'FFFFFF';
      $row->bull_act_color = 'FFFFFF';
      $row->bull_margin = 3;
      $row->enable_filmstrip = 0;
      $row->film_pos = 'none';
      $row->film_thumb_width = 100;
      $row->film_thumb_height = 50;
      $row->film_bg_color = '000000';
      $row->film_tmb_margin = 0;
      $row->film_act_border_width = 0;
      $row->film_act_border_style = 'none';
      $row->film_act_border_color = 'FFFFFF';
      $row->film_dac_transparent = 50;
      $row->enable_time_bar = 1;
      $row->timer_bar_type = 'top';
      $row->timer_bar_size = 5;
      $row->timer_bar_color = 'BBBBBB';
      $row->timer_bar_transparent = 50;
      $row->stop_animation = 0;
      $row->css = '';
      $row->right_butt_url = WD_PS_URL . '/images/arrow/arrow11/1/2.png';
      $row->left_butt_url = WD_PS_URL . '/images/arrow/arrow11/1/1.png';
      $row->right_butt_hov_url = WD_PS_URL . '/images/arrow/arrow11/1/4.png';
      $row->left_butt_hov_url = WD_PS_URL . '/images/arrow/arrow11/1/3.png';
      $row->rl_butt_img_or_not = 'style';
      $row->bullets_img_main_url = WD_PS_URL . '/images/bullet/bullet1/1/1.png';
      $row->bullets_img_hov_url = WD_PS_URL . '/images/bullet/bullet1/1/2.png';
      $row->bull_butt_img_or_not = 'style';
      $row->play_paus_butt_img_or_not = 'style';
      $row->play_butt_url = WD_PS_URL . '/images/button/button4/1/1.png';
      $row->play_butt_hov_url = WD_PS_URL . '/images/button/button4/1/2.png';
      $row->paus_butt_url = WD_PS_URL . '/images/button/button4/1/3.png';
      $row->paus_butt_hov_url = WD_PS_URL . '/images/button/button4/1/4.png';
      $row->start_slide_num = 1;
      $row->effect_duration = 800;
      $row->carousel = 0;
      $row->carousel_image_counts = 7;
      $row->carousel_image_parameters = 0.85;
      $row->carousel_fit_containerWidth = 0;
      $row->carousel_width = 1000;
      $row->parallax_effect = 0;
      $row->dynamic = 0;
      $row->cache_expiration = '';
      $row->posts_count = 7;
      $row->choose_post = 'post';
      $row->post_sort = 'publishing date';
      $row->order_by_posts = 0;
      $row->taxonomies = '';
      $row->author_name = '';
      $row->smart_crop = 0;
      $row->crop_image_position = 'center center';
      $row->bull_back_act_color = '000000';
      $row->bull_back_color = 'CCCCCC';
      $row->bull_radius = '20px';
      $row->carousel_degree = 0;
      $row->carousel_grayscale = 0;
      $row->carousel_transparency = 0;
      $row->featured_image = 1;
      $row->bull_hover = 1;
      $row->show_thumbnail = 0;
      $row->thumb_size = '0.3';
      $row->mouse_swipe_nav = 0;
      $row->touch_swipe_nav = 1;
      $row->mouse_wheel_nav = 0;
      $row->keyboard_nav = 0;
      $row->twoway_slideshow = 0;
      $row->hide_on_mobile = 0;
      $row->slider_loop = 1;
      $row->full_width_for_mobile = 0;
      $row->order_dir='ASC';
    }
    return $row;
  }

  public function page_nav() {
    global $wpdb;
    $where = ((isset($_POST['search_value']) && (esc_html(stripslashes($_POST['search_value'])) != '')) ? 'WHERE name LIKE "%' . esc_html(stripslashes($_POST['search_value'])) . '%"'  : '');
    $total = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->prefix . "wdpsslider " . $where);
    $page_nav['total'] = $total;
    if (isset($_POST['page_number']) && $_POST['page_number']) {
      $limit = ((int) $_POST['page_number'] - 1) * 20;
    }
    else {
      $limit = 0;
    }
    $page_nav['limit'] = (int) ($limit / 20 + 1);
    return $page_nav;
  }

  public function get_post_data() {
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
    return $post_fildes_names;
  }

  public function add_more_link($content, $link, $charlength) {
    if (mb_strlen($content) > $charlength) {
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