<?php

class WDPSControllerSliders_wdps {
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
  public function execute() {
    $task = WDW_PS_Library::get('task');
    $id = WDW_PS_Library::get('current_id', 0);
    $message = WDW_PS_Library::get('message');
    echo WDW_PS_Library::message_id($message);
    if (method_exists($this, $task)) {
      check_admin_referer('nonce_wd', 'nonce_wd');
      $this->$task($id);
    }
    else {
      $this->display();
    }
  }

  public function display() {
    require_once WD_PS_DIR . "/admin/models/WDPSModelSliders_wdps.php";
    $model = new WDPSModelSliders_wdps();

    require_once WD_PS_DIR . "/admin/views/WDPSViewSliders_wdps.php";
    $view = new WDPSViewSliders_wdps($model);
    $view->display();
  }
  
  public function get_taxonoimis() {
    $args = array(
      'object_type' => array(isset($_POST['choose_post']) ?  esc_html(stripslashes($_POST['choose_post'])) : 'post')
    );
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
    $post_type = (isset($_POST['choose_post'])) ?  esc_html(stripslashes($_POST['choose_post'])) : 'post';
    $argss = array(
        'posts_per_page' => 1,
        'post_type'=> $post_type,
        'post_status' => 'publish',
    );
    $posts = get_posts($argss);
    foreach ($posts as $post) {
      $post_id = $post->ID; 
    }
    $custom_fields_name = get_post_custom_keys($post_id);
    for ($k = 0; $k < count($custom_fields_name); ++$k) {
      array_push($post_fildes_names,$custom_fields_name[$k]);
    }
    $output = 'names'; // or objects
    $operator = 'and'; // 'and' or 'or'
    $taxonomies = get_taxonomies($args, $output, $operator);
    $argss = array(
      'orderby'           => 'id', 
      'order'             => 'ASC',
      'hide_empty'        => false,
    );
    $content = '<div class="taxonomies_id">';
    $terms = get_terms($taxonomies, $argss);
    foreach ($taxonomies as $taxonomie) {
      if (get_terms($taxonomie, $argss)) {
        $content .= '<select class="dynamic_select_multiple"  name="taxonomies_' . $taxonomie . '" id="taxonomies_' . $taxonomie . '" multiple="multiple">';
        $content .= '<option value=""><p>'.__('All', 'wdps_back').' "' . $taxonomie . '"s</p></option>';
        foreach ($terms as $term) {
          if ($taxonomie == $term->taxonomy) {
            $content .= '<option value="' . $term->slug . '"><p>' . $term->name . ' </p></option>';
          }
        }
        $content .= '</select>';
      } 
    }
    $content .= '</div>';
    $content .= '<div id="post_fildes_name">' . json_encode($post_fildes_names) . '</div>';
    echo $content;
  }

  public function add() {
    require_once WD_PS_DIR . "/admin/models/WDPSModelSliders_wdps.php";
    $model = new WDPSModelSliders_wdps();

    require_once WD_PS_DIR . "/admin/views/WDPSViewSliders_wdps.php";
    $view = new WDPSViewSliders_wdps($model);
    $view->edit(0);
  }

  public function edit() {
    require_once WD_PS_DIR . "/admin/models/WDPSModelSliders_wdps.php";
    $model = new WDPSModelSliders_wdps();

    require_once WD_PS_DIR . "/admin/views/WDPSViewSliders_wdps.php";
    $view = new WDPSViewSliders_wdps($model);
    $id = ((isset($_POST['current_id']) && esc_html(stripslashes($_POST['current_id'])) != '') ? esc_html(stripslashes($_POST['current_id'])) : 0);
    $view->edit($id);
  }

  public function save() {
    $page = WDW_PS_Library::get('page');
    WDW_PS_Library::spider_redirect(add_query_arg(array('page' => $page, 'task' => 'display', 'message' => 1), admin_url('admin.php')));
  }

  public function apply() {
    $this->save_slider_db();
    $this->save_slide_db();
    $this->edit();
  }

  public function save_slider_db() {
    global $wpdb;
    $slider_id = (isset($_POST['current_id']) ? (int) $_POST['current_id'] : 0);
    $del_slide_ids_string = (isset($_POST['del_slide_ids_string']) ? substr(esc_html(stripslashes($_POST['del_slide_ids_string'])), 0, -1) : '');
    if ($del_slide_ids_string) {
      $wpdb->query('DELETE FROM ' . $wpdb->prefix . 'wdpsslide WHERE slider_id=' . $slider_id . ' AND id IN (' . $del_slide_ids_string . ')');
    }
    $name = ((isset($_POST['name'])) ? esc_html(stripslashes($_POST['name'])) : '');
    $published = ((isset($_POST['published'])) ? (int) esc_html(stripslashes($_POST['published'])) : 1);
    $full_width = ((isset($_POST['full_width'])) ? (int) esc_html(stripslashes($_POST['full_width'])) : 0);
    $width = ((isset($_POST['width'])) ? (int) esc_html(stripslashes($_POST['width'])) : 800);
    $height = ((isset($_POST['height'])) ? (int) esc_html((stripslashes($_POST['height']))) : 300);
    $bg_fit = ((isset($_POST['bg_fit'])) ? esc_html(stripslashes($_POST['bg_fit'])) : 'cover');
    $align = ((isset($_POST['align'])) ? esc_html(stripslashes($_POST['align'])) : 'center');
    $effect = ((isset($_POST['effect'])) ? esc_html(stripslashes($_POST['effect'])) : 'fade');
    $time_intervval = ((isset($_POST['time_intervval'])) ? (int) esc_html(stripslashes($_POST['time_intervval'])) : 5);
    $autoplay = ((isset($_POST['autoplay'])) ? (int) esc_html(stripslashes($_POST['autoplay'])) : 0);
    $shuffle = ((isset($_POST['shuffle'])) ? (int) esc_html(stripslashes($_POST['shuffle'])) : 0);
    $music = ((isset($_POST['music'])) ? (int) esc_html(stripslashes($_POST['music'])) : 0);	
    $music_url = ((isset($_POST['music_url'])) ? esc_html(stripslashes($_POST['music_url'])) : '');
    if ( !WDW_PS_Library::check_file_is_audio($music_url) ) {
      $music = 0;
      $music_url = '';
    }
    $preload_images = ((isset($_POST['preload_images'])) ? (int) esc_html(stripslashes($_POST['preload_images'])) : 1);
    $background_color = ((isset($_POST['background_color'])) ? esc_html(stripslashes($_POST['background_color'])) : '000000');
    $background_transparent = ((isset($_POST['background_transparent'])) ? esc_html(stripslashes($_POST['background_transparent'])) : 100);
    $glb_border_width = ((isset($_POST['glb_border_width'])) ? (int) esc_html(stripslashes($_POST['glb_border_width'])) : 0);
    $glb_border_style = ((isset($_POST['glb_border_style'])) ? esc_html(stripslashes($_POST['glb_border_style'])) : 'none');	
    $glb_border_color = ((isset($_POST['glb_border_color'])) ? esc_html(stripslashes($_POST['glb_border_color'])) : '000000');
    $glb_border_radius = ((isset($_POST['glb_border_radius'])) ? esc_html(stripslashes($_POST['glb_border_radius'])) : '');
    $glb_margin = ((isset($_POST['glb_margin'])) ? (int) esc_html(stripslashes($_POST['glb_margin'])) : 0);
    $glb_box_shadow = ((isset($_POST['glb_box_shadow'])) ? esc_html(stripslashes($_POST['glb_box_shadow'])) : '');
    $image_right_click = ((isset($_POST['image_right_click'])) ? (int) esc_html(stripslashes($_POST['image_right_click'])) : 0);
    $layer_out_next = ((isset($_POST['layer_out_next'])) ? (int) esc_html(stripslashes($_POST['layer_out_next'])) : 0);
    $layer_word_count = ((isset($_POST['layer_word_count'])) ? (int) esc_html(stripslashes($_POST['layer_word_count'])) : 250);
    $prev_next_butt = ((isset($_POST['prev_next_butt'])) ? (int) esc_html(stripslashes($_POST['prev_next_butt'])) : 1);	
    $play_paus_post_butt = ((isset($_POST['play_paus_post_butt'])) ? (int) esc_html(stripslashes($_POST['play_paus_post_butt'])) : 0);
    $navigation = ((isset($_POST['navigation'])) ? esc_html(stripslashes($_POST['navigation'])) : 'hover');
    $bull_position = ((isset($_POST['bull_position'])) ? esc_html(stripslashes($_POST['bull_position'])) : 'bottom');
    $rl_butt_style = 'fa-angle';
    $rl_butt_size = 40;
    $pp_butt_size = 40;	
    $butts_color = '000000';
    $butts_transparent = 100;
    $hover_color = '000000';
    $nav_border_width = 0;
    $nav_border_style = 'none';
    $nav_border_color = 'FFFFFF';	
    $nav_border_radius = '20px';
    $nav_bg_color = 'FFFFFF';
    if (isset($_POST['enable_bullets']) && (esc_html(stripslashes($_POST['enable_bullets'])) == 0)) {
      $bull_position = 'none';
    }
    $bull_style = 'fa-square-o';
    $bull_size = 20;
    $bull_color = 'FFFFFF';	
    $bull_act_color = 'FFFFFF';
    $bull_margin = 3;
    $film_pos = ((isset($_POST['film_pos'])) ? esc_html(stripslashes($_POST['film_pos'])) : 'none');
    if (isset($_POST['enable_filmstrip']) && (esc_html(stripslashes($_POST['enable_filmstrip'])) == 0)) {
      $film_pos = 'none';
    }
    $film_thumb_width = ((isset($_POST['film_thumb_width'])) ? (int) esc_html(stripslashes($_POST['film_thumb_width'])) : 100);
    $film_thumb_height = ((isset($_POST['film_thumb_height'])) ? (int) esc_html(stripslashes($_POST['film_thumb_height'])) : 50);
    $film_bg_color = ((isset($_POST['film_bg_color'])) ? esc_html(stripslashes($_POST['film_bg_color'])) : '000000');	
    $film_tmb_margin = ((isset($_POST['film_tmb_margin'])) ? (int) esc_html(stripslashes($_POST['film_tmb_margin'])) : 0);
    $film_act_border_width = ((isset($_POST['film_act_border_width'])) ? (int) esc_html(stripslashes($_POST['film_act_border_width'])) : 0);
    $film_act_border_style = ((isset($_POST['film_act_border_style'])) ? esc_html(stripslashes($_POST['film_act_border_style'])) : 'none');
    $film_act_border_color = ((isset($_POST['film_act_border_color'])) ? esc_html(stripslashes($_POST['film_act_border_color'])) : 'FFFFFF');
    $film_dac_transparent = ((isset($_POST['film_dac_transparent'])) ? (int) esc_html(stripslashes($_POST['film_dac_transparent'])) : 50);	
    $css = (isset($_POST['css']) ? esc_html(stripslashes($_POST['css'])) : '');
    $timer_bar_type = (isset($_POST['timer_bar_type']) ? esc_html(stripslashes($_POST['timer_bar_type'])) : 'top');
    if (isset($_POST['enable_time_bar']) && (esc_html(stripslashes($_POST['enable_time_bar'])) == 0)) {
      $timer_bar_type = 'none';
    }
    $timer_bar_size = (isset($_POST['timer_bar_size']) ? esc_html(stripslashes($_POST['timer_bar_size'])) : 5);
    $timer_bar_color = (isset($_POST['timer_bar_color']) ? esc_html(stripslashes($_POST['timer_bar_color'])) : 'BBBBBB');
    $timer_bar_transparent = (isset($_POST['timer_bar_transparent']) ? esc_html(stripslashes($_POST['timer_bar_transparent'])) : 50);
    $stop_animation = ((isset($_POST['stop_animation'])) ? (int) esc_html(stripslashes($_POST['stop_animation'])) : 0);
    $right_butt_url = (isset($_POST['right_butt_url']) ? esc_html(stripslashes($_POST['right_butt_url'])) : '');
    $left_butt_url = (isset($_POST['left_butt_url']) ? esc_html(stripslashes($_POST['left_butt_url'])) : '');
    $right_butt_hov_url = (isset($_POST['right_butt_hov_url']) ? esc_html(stripslashes($_POST['right_butt_hov_url'])) : '');
    $left_butt_hov_url = (isset($_POST['left_butt_hov_url']) ? esc_html(stripslashes($_POST['left_butt_hov_url'])) : '');
    $rl_butt_img_or_not = (isset($_POST['rl_butt_img_or_not']) ? esc_html(stripslashes($_POST['rl_butt_img_or_not'])) : 'style');
    $bullets_img_main_url = (isset($_POST['bullets_img_main_url']) ? esc_html(stripslashes($_POST['bullets_img_main_url'])) : '');
    $bullets_img_hov_url = (isset($_POST['bullets_img_hov_url']) ? esc_html(stripslashes($_POST['bullets_img_hov_url'])) : '');
    $bull_butt_img_or_not = (isset($_POST['bull_butt_img_or_not']) ? esc_html(stripslashes($_POST['bull_butt_img_or_not'])) : 'style');
    $play_paus_butt_img_or_not = (isset($_POST['play_paus_butt_img_or_not']) ? esc_html(stripslashes($_POST['play_paus_butt_img_or_not'])) : 'style');
    $play_butt_url = (isset($_POST['play_butt_url']) ? esc_html(stripslashes($_POST['play_butt_url'])) : '');
    $play_butt_hov_url = (isset($_POST['play_butt_hov_url']) ? esc_html(stripslashes($_POST['play_butt_hov_url'])) : '');
    $paus_butt_url = (isset($_POST['paus_butt_url']) ? esc_html(stripslashes($_POST['paus_butt_url'])) : '');
    $paus_butt_hov_url = (isset($_POST['paus_butt_hov_url']) ? esc_html(stripslashes($_POST['paus_butt_hov_url'])) : '');
    $start_slide_num = ((isset($_POST['start_slide_num'])) ? (int) stripslashes($_POST['start_slide_num']) : 1);
    $effect_duration = ((isset($_POST['effect_duration'])) ? (int) stripslashes($_POST['effect_duration']) : 800);
    $carousel = 0;
    $carousel_image_counts = 7;
    $carousel_image_parameters = 0.85;
    $carousel_fit_containerWidth = 0;
    $carousel_width = 1000;
    $parallax_effect = 0;
    $dynamic = ((isset($_POST['dynamic'])) ? (int) esc_html(stripslashes($_POST['dynamic'])) : 0);
    $cache_expiration = ((isset($_POST['cache_expiration'])) ? esc_html(stripslashes($_POST['cache_expiration'])) : 'Select');
    $cache_expiration_count = ((isset($_POST['cache_expiration_count'])) ? esc_html(stripslashes($_POST['cache_expiration_count'])) : '');
    $posts_count = ((isset($_POST['posts_count'])) ? (int) esc_html(stripslashes($_POST['posts_count'])) : 7);
    $choose_post = ((isset($_POST['choose_post'])) ? esc_html(stripslashes($_POST['choose_post'])) : 'post');
    $post_sort = ((isset($_POST['post_sort'])) ? esc_html(stripslashes($_POST['post_sort'])) : 'publishing date');
    $order_by_posts = ((isset($_POST['order_by_posts'])) ? (int) esc_html(stripslashes($_POST['order_by_posts'])) : 0);
    $author_name = ((isset($_POST['author_name'])) ? esc_html(stripslashes($_POST['author_name'])) : '');
    $smart_crop = ((isset($_POST['smart_crop'])) ? (int) esc_html(stripslashes($_POST['smart_crop'])) : 0);
    $crop_image_position = ((isset($_POST['crop_image_position'])) ? esc_html(stripslashes($_POST['crop_image_position'])) : 'middle-center');
    $bull_back_act_color = ((isset($_POST['bull_back_act_color'])) ? esc_html(stripslashes($_POST['bull_back_act_color'])) : '000000');
    $bull_back_color = ((isset($_POST['bull_back_color'])) ? esc_html(stripslashes($_POST['bull_back_color'])) : 'CCCCCC');
    $bull_radius = ((isset($_POST['bull_radius'])) ? esc_html(stripslashes($_POST['bull_radius'])) : '20px');
    $carousel_degree = ((isset($_POST['carousel_degree'])) ? (int) esc_html(stripslashes($_POST['carousel_degree'])) : 0);
    $carousel_grayscale = ((isset($_POST['carousel_grayscale'])) ? (int) esc_html(stripslashes($_POST['carousel_grayscale'])) : 0);
    $carousel_transparency = ((isset($_POST['carousel_transparency'])) ? (int) esc_html(stripslashes($_POST['carousel_transparency'])) : 0);
    $featured_image = ((isset($_POST['featured_image'])) ? (int) esc_html(stripslashes($_POST['featured_image'])) : 1);
    $bull_hover = ((isset($_POST['bull_hover'])) ? (int) esc_html(stripslashes($_POST['bull_hover'])) : 1);
    $show_thumbnail = ((isset($_POST['show_thumbnail'])) ? (int) esc_html(stripslashes($_POST['show_thumbnail'])) : 0);
    $thumb_size = ((isset($_POST['thumb_size'])) ? esc_html(stripslashes($_POST['thumb_size'])) : '0.3');
    $mouse_swipe_nav = ((isset($_POST['mouse_swipe_nav'])) ? (int) esc_html(stripslashes($_POST['mouse_swipe_nav'])) : 0);
    $touch_swipe_nav = ((isset($_POST['touch_swipe_nav'])) ? (int) esc_html(stripslashes($_POST['touch_swipe_nav'])) : 1);
    $mouse_wheel_nav = ((isset($_POST['mouse_wheel_nav'])) ? (int) esc_html(stripslashes($_POST['mouse_wheel_nav'])) : 0);
    $keyboard_nav = ((isset($_POST['keyboard_nav'])) ? (int) esc_html(stripslashes($_POST['keyboard_nav'])) : 0);
    $twoway_slideshow = ((isset($_POST['twoway_slideshow'])) ? (int) esc_html(stripslashes($_POST['twoway_slideshow'])) : 0);
    $hide_on_mobile = ((isset($_POST['hide_on_mobile'])) ? (int) esc_html(stripslashes($_POST['hide_on_mobile'])) : 0);
    $slider_loop = ((isset($_POST['slider_loop'])) ? (int) esc_html(stripslashes($_POST['slider_loop'])) : 1);
    $full_width_for_mobile = ((isset($_POST['full_width_for_mobile'])) ? (int) esc_html(stripslashes($_POST['full_width_for_mobile'])) : 0);
    $order_dir = ((isset($_POST['order_dir'])) ? esc_html(stripslashes($_POST['order_dir'])) : 'ASC');
    if ($dynamic == 1) {
      $args = array(
        'object_type' => array($choose_post) 
      ); 
      $output = 'names'; // or objects
      $operator = 'and'; // 'and' or 'or'
      $taxonomies = get_taxonomies($args,$output,$operator);
      $terms = array();
      foreach($taxonomies as $taxonomie) {
        $terms[$taxonomie] = ((isset($_POST['taxonomies_'.$taxonomie]) && $_POST['taxonomies_'.$taxonomie] != '') ? esc_html(stripslashes(implode(',',$_POST['taxonomies_'.$taxonomie]))) : '');
      }
    }
    $cache_expiration = ($cache_expiration_count != '') ? $cache_expiration : '';
    $cache_expiration_count = ($cache_expiration != '' ) ? $cache_expiration_count : '';
    $data = array(
      'name' => $name,
      'published' => $published,
      'full_width' => $full_width,
      'width' => $width,
      'height' => $height,
      'bg_fit' => $bg_fit,
      'align' => $align,
      'effect' => $effect,
      'time_intervval' => $time_intervval,
      'autoplay' => $autoplay,
      'shuffle' => $shuffle,
      'music' => $music,
      'music_url' => $music_url,
      'preload_images' => $preload_images,
      'background_color' => $background_color,
      'background_transparent' => $background_transparent,
      'glb_border_width' => $glb_border_width,
      'glb_border_style' => $glb_border_style,
      'glb_border_color' => $glb_border_color,
      'glb_border_radius' => $glb_border_radius,
      'glb_margin' => $glb_margin,
      'glb_box_shadow' => $glb_box_shadow,
      'image_right_click' => $image_right_click,
      'prev_next_butt' => $prev_next_butt,	
      'play_paus_post_butt' => $play_paus_post_butt,
      'navigation' => $navigation,
      'rl_butt_style' => $rl_butt_style,
      'rl_butt_size' => $rl_butt_size,
      'pp_butt_size' => $pp_butt_size,	
      'butts_color' => $butts_color,
      'butts_transparent' => $butts_transparent,
      'hover_color' => $hover_color,
      'nav_border_width' => $nav_border_width,
      'nav_border_style' => $nav_border_style,
      'nav_border_color' => $nav_border_color,
      'nav_border_radius' => $nav_border_radius,
      'nav_bg_color' => $nav_bg_color,
      'bull_position' => $bull_position,
      'bull_style' => $bull_style,
      'bull_size' => $bull_size,
      'bull_color' => $bull_color,
      'bull_act_color' => $bull_act_color,
      'bull_margin' => $bull_margin,
      'film_pos' => $film_pos,
      'film_thumb_width' => $film_thumb_width,
      'film_thumb_height' => $film_thumb_height,
      'film_bg_color' => $film_bg_color,
      'film_tmb_margin' => $film_tmb_margin,
      'film_act_border_width' => $film_act_border_width,
      'film_act_border_style' => $film_act_border_style,
      'film_act_border_color' => $film_act_border_color,
      'film_dac_transparent' => $film_dac_transparent,
      'css' => $css,
      'timer_bar_type' => $timer_bar_type,
      'timer_bar_size' => $timer_bar_size,
      'timer_bar_color' => $timer_bar_color,
      'timer_bar_transparent' => $timer_bar_transparent,
      'layer_out_next' => $layer_out_next,
      'layer_word_count' => $layer_word_count,
      'stop_animation' => $stop_animation,
      'right_butt_url' => $right_butt_url,
      'left_butt_url' => $left_butt_url,
      'right_butt_hov_url' => $right_butt_hov_url,
      'left_butt_hov_url' => $left_butt_hov_url,
      'rl_butt_img_or_not' => $rl_butt_img_or_not,
      'bullets_img_main_url' => $bullets_img_main_url,
      'bullets_img_hov_url' => $bullets_img_hov_url,
      'bull_butt_img_or_not' => $bull_butt_img_or_not,
      'play_paus_butt_img_or_not' => $play_paus_butt_img_or_not,
      'play_butt_url' => $play_butt_url,
      'play_butt_hov_url' => $play_butt_hov_url,
      'paus_butt_url' => $paus_butt_url,
      'paus_butt_hov_url' => $paus_butt_hov_url,
      'start_slide_num' => $start_slide_num,
      'effect_duration' => $effect_duration,
      'carousel' => $carousel,
      'carousel_image_counts' => $carousel_image_counts,
      'carousel_image_parameters' => $carousel_image_parameters,
      'carousel_fit_containerWidth' => $carousel_fit_containerWidth,
      'carousel_width' => $carousel_width,
      'parallax_effect' => $parallax_effect,
      'dynamic'=> $dynamic,
      'cache_expiration'=> $cache_expiration_count . ',' . $cache_expiration,
      'posts_count'=>$posts_count,
      'choose_post' => $choose_post,
      'post_sort' => $post_sort,
      'order_by_posts'=> $order_by_posts,
      'author_name' => $author_name,
      'smart_crop' => $smart_crop,
      'crop_image_position' => $crop_image_position,
      'bull_back_act_color' => $bull_back_act_color,
      'bull_back_color' => $bull_back_color,
      'bull_radius' => $bull_radius,
      'carousel_degree' => $carousel_degree,
      'carousel_grayscale' => $carousel_grayscale,
      'carousel_transparency' => $carousel_transparency,
      'featured_image' => $featured_image,
      'bull_hover' => $bull_hover,
      'show_thumbnail' => $show_thumbnail,
      'thumb_size' => $thumb_size,
      'mouse_swipe_nav' => $mouse_swipe_nav,
      'touch_swipe_nav' => $touch_swipe_nav,
      'mouse_wheel_nav' => $mouse_wheel_nav,
      'keyboard_nav' => $keyboard_nav,
      'twoway_slideshow' => $twoway_slideshow,
      'hide_on_mobile' => $hide_on_mobile,
      'slider_loop' => $slider_loop,
      'full_width_for_mobile' => $full_width_for_mobile,
      'order_dir' => $order_dir,
    );
    if (!$slider_id) {
      $data['taxonomies'] = json_encode($terms);
    } 
    elseif ($dynamic == 1) {
      $data['taxonomies'] = json_encode($terms);
    }
    if (!$slider_id) {
      $save = $wpdb->insert($wpdb->prefix . 'wdpsslider',$data);
      $_POST['current_id'] = (int) $wpdb->get_var('SELECT MAX(`id`) FROM ' . $wpdb->prefix . 'wdpsslider');
    }
    else {
      $save = $wpdb->update($wpdb->prefix . 'wdpsslider',$data, array('id' => $slider_id));
    }
    if ($save !== FALSE) {
      return 1;
    }
    else {
      return 2;
    }
  }

  public function save_slide_db() {
    global $wpdb;
    $slider_id = (isset($_POST['current_id']) ? (int) $_POST['current_id'] : 0);
    $save_as_copy = (isset($_POST['save_as_copy']) ? (int) $_POST['save_as_copy'] : 0);
    if (!$slider_id) {
      $slider_id = $wpdb->get_var('SELECT MAX(id) FROM ' . $wpdb->prefix . 'wdpsslider');
    }
    $slide_ids_string = (isset($_POST['slide_ids_string']) ? esc_html(stripslashes($_POST['slide_ids_string'])) : '');
    $slide_id_array = explode(',', $slide_ids_string);
    foreach ($slide_id_array as $slide_id) {
      if ($slide_id) {
        $del_layer_ids_string = ((isset($_POST['slide' . $slide_id . '_del_layer_ids_string']) && !$save_as_copy) ? substr(esc_html(stripslashes($_POST['slide' . $slide_id . '_del_layer_ids_string'])), 0, -1) : '');
        if ($del_layer_ids_string) {
          $wpdb->query('DELETE FROM ' . $wpdb->prefix . 'wdpslayer WHERE id IN (' . $del_layer_ids_string . ')');
        }
        $title = ((isset($_POST['title' . $slide_id])) ? esc_html(stripslashes($_POST['title' . $slide_id])) : '');
        $type = ((isset($_POST['type' . $slide_id])) ? esc_html(stripslashes($_POST['type' . $slide_id])) : '');
        $order = ((isset($_POST['order' . $slide_id])) ? esc_html(stripslashes($_POST['order' . $slide_id])) : '');
        $published = ((isset($_POST['published' . $slide_id])) ? esc_html(stripslashes($_POST['published' . $slide_id])) : 1);
        $target_attr_slide = ((isset($_POST['target_attr_slide' . $slide_id])) ? esc_html(stripslashes($_POST['target_attr_slide' . $slide_id])) : 0);
        $link = ((isset($_POST['link' . $slide_id])) ? esc_html(stripslashes($_POST['link' . $slide_id])) : '');
        $post_id = ((isset($_POST['post_id' . $slide_id])) ? esc_html(stripslashes($_POST['post_id' . $slide_id])) : '');
        $image_url = ((isset($_POST['image_url' . $slide_id])) ? esc_html(stripslashes($_POST['image_url' . $slide_id])) : '');
        $thumb_url = ((isset($_POST['thumb_url' . $slide_id])) ? esc_html(stripslashes($_POST['thumb_url' . $slide_id])) : '');
        $slide_array = array(
          'slider_id' => $slider_id,
          'title' => $title,
          'type' => $type,
          'order' => $order,
          'published' => $published,
          'link' => $link,
          'post_id'=> $post_id,
          'image_url' => $image_url,
          'thumb_url' => $thumb_url,
          'target_attr_slide' => $target_attr_slide,
        );
        if (strpos($slide_id, 'pr') !== FALSE || $save_as_copy) {
          $save = $wpdb->insert($wpdb->prefix . 'wdpsslide', $slide_array);
          $slide_id_pr = $wpdb->get_var('SELECT MAX(id) FROM ' . $wpdb->prefix . 'wdpsslide');
        }
        else {
          $save = $wpdb->update($wpdb->prefix . 'wdpsslide', $slide_array, array('id' => $slide_id));
          $slide_id_pr = $slide_id;
        }
        $this->save_layer_db($slide_id, $slide_id_pr);
      }
    }
    $image_url = WD_PS_URL . '/images/watermark_preview.jpg' ;
    $thumb_url = WD_PS_URL . '/images/watermark_preview.jpg' ;
    $slide_id = $wpdb->get_var('SELECT id FROM ' . $wpdb->prefix . 'wdpsslide WHERE title="prototype" AND slider_id =' . $slider_id);
    if ($slide_id) {
      $del_layer_ids_string = ((isset($_POST['slide' . $slide_id . '_del_layer_ids_string']) && !$save_as_copy) ? substr(esc_html(stripslashes($_POST['slide' . $slide_id . '_del_layer_ids_string'])), 0, -1) : '');
      if ($del_layer_ids_string) {
        $wpdb->query('DELETE FROM ' . $wpdb->prefix . 'wdpslayer WHERE id IN (' . $del_layer_ids_string . ')');
      }
      $save = $wpdb->update($wpdb->prefix . 'wdpsslide', $slide_array = array(
       'image_url' => $image_url,
       'thumb_url' => $thumb_url,
       'target_attr_slide' => $target_attr_slide,
       'link' => $link,
      ), array(
        'id' => $slide_id
      ));
    }
    else {
      $save = $wpdb->insert($wpdb->prefix . 'wdpsslide', $slide_array = array(
        'slider_id' => $slider_id,
        'title' => 'prototype',
        'image_url' => $image_url,
        'thumb_url' => $thumb_url,
        'target_attr_slide' => $target_attr_slide,
        'link' => $link,
      ));
    }
  }

  public function save_layer_db($slide_id, $slide_id_pr) {
    global $wpdb;
    $fv = get_option("wdps_fv022") ? 1 : 0;
    $save_as_copy = (isset($_POST['save_as_copy']) ? (int) $_POST['save_as_copy'] : 0);
    $layer_ids_string = (isset($_POST['slide' . $slide_id . '_layer_ids_string']) ? esc_html(stripslashes($_POST['slide' . $slide_id . '_layer_ids_string'])) : '');
    $layer_id_array = explode(',', $layer_ids_string);
    foreach ($layer_id_array as $layer_id) { 
      if ($layer_id) {
        $prefix = 'slide' . $slide_id . '_layer' . $layer_id;
        $json_string = (isset($_POST[$prefix . '_json']) ? stripslashes($_POST[$prefix . '_json']) : '');
        $params_array = json_decode($json_string, TRUE);
        $title = ((isset($params_array['title'])) ? esc_html(stripslashes($params_array['title'])) : '');
        $type = ((isset($params_array['type'])) ? esc_html(stripslashes($params_array['type'])) : '');
        $depth = ((isset($params_array['depth'])) ? esc_html(stripslashes($params_array['depth'])) : '');
        $text = ((isset($params_array['text'])) ? stripslashes($params_array['text']) : '');
        $link = ((isset($params_array['link'])) ? esc_html(stripslashes($params_array['link'])) : '');
        $target_attr_layer = ((isset($params_array['target_attr_layer'])) ? esc_html(stripslashes($params_array['target_attr_layer'])) : 0);
        $left = ((isset($params_array['left'])) ? esc_html(stripslashes($params_array['left'])) : '');
        $top = ((isset($params_array['top'])) ? esc_html(stripslashes($params_array['top'])) : '');
        $start = ((isset($params_array['start'])) ? esc_html(stripslashes($params_array['start'])) : '');
        $end = ((isset($params_array['end'])) ? esc_html(stripslashes($params_array['end'])) : '');
        $published = ((isset($params_array['published'])) ? esc_html(stripslashes($params_array['published'])) : '1');
        $color = ((isset($params_array['color'])) ? esc_html(stripslashes($params_array['color'])) : '');
        $size = ((isset($params_array['size'])) ? esc_html(stripslashes($params_array['size'])) : '');
        $ffamily = ((isset($params_array['ffamily'])) ? esc_html(stripslashes($params_array['ffamily'])) : '');
        $fweight = ((isset($params_array['fweight'])) ? esc_html(stripslashes($params_array['fweight'])) : '');
        $padding = ((isset($params_array['padding'])) ? esc_html(stripslashes($params_array['padding'])) : '');
        $fbgcolor = ((isset($params_array['fbgcolor'])) ? esc_html(stripslashes($params_array['fbgcolor'])) : '');
        $transparent = ((isset($params_array['transparent'])) ? esc_html(stripslashes($params_array['transparent'])) : '');
        $border_width = ((isset($params_array['border_width'])) ? esc_html(stripslashes($params_array['border_width'])) : '');
        $border_style = ((isset($params_array['border_style'])) ? esc_html(stripslashes($params_array['border_style'])) : '');
        $border_color = ((isset($params_array['border_color'])) ? esc_html(stripslashes($params_array['border_color'])) : '');
        $border_radius = ((isset($params_array['border_radius'])) ? esc_html(stripslashes($params_array['border_radius'])) : '');
        $shadow = ((isset($params_array['shadow'])) ? esc_html(stripslashes($params_array['shadow'])) : '');
        $image_url = ((isset($params_array['image_url'])) ? esc_html(stripslashes($params_array['image_url'])) : '');
        $image_width = ((isset($params_array['image_width'])) ? esc_html(stripslashes($params_array['image_width'])) : '');
        $image_height = ((isset($params_array['image_height'])) ? esc_html(stripslashes($params_array['image_height'])) : '');
        $image_scale = ((isset($params_array['image_scale'])) ? esc_html(stripslashes($params_array['image_scale'])) : '');
        $alt = ((isset($params_array['alt'])) ? esc_html(stripslashes($params_array['alt'])) : '');
        $imgtransparent = ((isset($params_array['imgtransparent'])) ? esc_html(stripslashes($params_array['imgtransparent'])) : '');
        $social_button = ((isset($params_array['social_button'])) ? esc_html(stripslashes($params_array['social_button'])) : '');
        $hover_color = ((isset($params_array['hover_color'])) ? esc_html(stripslashes($params_array['hover_color'])) : '');
        $layer_effect_in = ((isset($params_array['layer_effect_in'])) ? esc_html(stripslashes($params_array['layer_effect_in'])) : ''); 
        $layer_effect_out = ((isset($params_array['layer_effect_out'])) ? esc_html(stripslashes($params_array['layer_effect_out'])) : '');
        $duration_eff_in = ((isset($params_array['duration_eff_in'])) ? esc_html(stripslashes($params_array['duration_eff_in'])) : 3);
        $duration_eff_out = ((isset($params_array['duration_eff_out'])) ? esc_html(stripslashes($params_array['duration_eff_out'])) : 3);

        $hotp_width = ((isset($params_array['hotp_width'])) ? esc_html(stripslashes($params_array['hotp_width'])) : '');
        $hotp_fbgcolor = ((isset($params_array['hotp_fbgcolor'])) ? esc_html(stripslashes($params_array['hotp_fbgcolor'])) : '');
        $hotp_border_width = ((isset($params_array['hotp_border_width'])) ? esc_html(stripslashes($params_array['hotp_border_width'])) : '');
        $hotp_border_style = ((isset($params_array['hotp_border_style'])) ? esc_html(stripslashes($params_array['hotp_border_style'])) : '');
        $hotp_border_color = ((isset($params_array['hotp_border_color'])) ? esc_html(stripslashes($params_array['hotp_border_color'])) : '');
        $hotp_border_radius = ((isset($params_array['hotp_border_radius'])) ? esc_html(stripslashes($params_array['hotp_border_radius'])) : '');
        $hotp_text_position = ((isset($params_array['hotp_text_position'])) ? esc_html(stripslashes($params_array['hotp_text_position'])) : '');
        $google_fonts = ((isset($params_array['google_fonts'])) ? esc_html(stripslashes($params_array['google_fonts'])) : 0);
        $layer_characters_count = ((isset($params_array['layer_characters_count'])) ? esc_html(stripslashes($params_array['layer_characters_count'])) : 250);
        $align_layer = ((isset($params_array['align_layer'])) ? esc_html(stripslashes($params_array['align_layer'])) : 0);
        $text_alignment = ((isset($params_array['text_alignment'])) ? esc_html(stripslashes($params_array['text_alignment'])) : 'left');
        $remove_shortcode = ((isset($params_array['remove_shortcode'])) ? esc_html(stripslashes($params_array['remove_shortcode'])) : 1);
        $infinite_in = ((isset($params_array['infinite_in'])) ? (int) esc_html(stripslashes($params_array['infinite_in'])) : 1);
        $infinite_out = ((isset($params_array['infinite_out'])) ? (int) esc_html(stripslashes($params_array['infinite_out'])) : 1);
        $hover_color_text = ((isset($params_array['hover_color_text'])) ? esc_html(stripslashes($params_array['hover_color_text'])) : '');
        $min_size = ((isset($params_array['min_size'])) ? (int) esc_html(stripslashes($params_array['min_size'])) : 11);
        if ($title) {
          $data = array(
            'title' => $title,
            'type' => $type,
            'depth' => $depth,
            'text' => $text,
            'link' => $link,
            'left' => $left,
            'top' => $top,
            'start' => $start,
            'end' => $end,
            'published' => $published,
            'color' => $color,
            'size' => $size,
            'ffamily' => $ffamily,
            'fweight' => $fweight,
            'padding' => $padding,
            'fbgcolor' => $fbgcolor,
            'transparent' => $transparent,
            'border_width' => $border_width,
            'border_style' => $border_style,
            'border_color' => $border_color,
            'border_radius' => $border_radius,
            'shadow' => $shadow,
            'layer_characters_count' => $layer_characters_count,
            'image_url' => $image_url,
            'image_width' => $image_width,
            'image_height' => $image_height,
            'image_scale' => $image_scale,
            'alt' => $alt,
            'imgtransparent' => $imgtransparent,
            'social_button' => $social_button,
            'hover_color' => $hover_color,
            'layer_effect_in' => $layer_effect_in,
            'layer_effect_out' => $layer_effect_out,
            'duration_eff_in' => $duration_eff_in,
            'duration_eff_out' => $duration_eff_out,
            'target_attr_layer' => $target_attr_layer,
            'hotp_width' => $hotp_width,
            'hotp_fbgcolor' => $hotp_fbgcolor,
            'hotp_border_width' => $hotp_border_width,
            'hotp_border_style' => $hotp_border_style,
            'hotp_border_color' => $hotp_border_color,
            'hotp_border_radius' => $hotp_border_radius,
            'hotp_text_position' => $hotp_text_position,
            'google_fonts' => $google_fonts,
            'align_layer' => $align_layer,
            'text_alignment' => $text_alignment,
            'remove_shortcode' => $remove_shortcode,
            'infinite_in' => $infinite_in,
            'infinite_out' => $infinite_out,
            'hover_color_text' => $hover_color_text,
            'min_size' => $min_size,
          );
          if (strpos($layer_id, 'pr_') !== FALSE || $save_as_copy) {
            $data['slide_id'] = $slide_id_pr;
            $save = $wpdb->insert($wpdb->prefix . 'wdpslayer', $data);
          }
          else {
            if ($fv) {
              $data = array(
                'left' => $left,
                'top' => $top
              );
            }
            $save = $wpdb->update($wpdb->prefix . 'wdpslayer', $data, array('id' => $layer_id));
          }
        }
      }
    }
  }

  public function reset() {
    global $wpdb;
    $slider_id = WDW_PS_Library::get('current_id', 0);
    if (!$slider_id) {
      $slider_id = $wpdb->get_var('SELECT MAX(id) FROM ' . $wpdb->prefix . 'wdpsslider');
    }
    require_once WD_PS_DIR . "/admin/models/WDPSModelSliders_wdps.php";
    $model = new WDPSModelSliders_wdps();

    require_once WD_PS_DIR . "/admin/views/WDPSViewSliders_wdps.php";
    $view = new WDPSViewSliders_wdps($model);
    echo WDW_PS_Library::message(__('Changes must be saved.','wdps_back'), 'wd_error');
    $view->edit($slider_id, TRUE);
  }

  public function duplicate_all($id) {
    global $wpdb;
    $sliders_ids_col = $wpdb->get_col('SELECT id FROM ' . $wpdb->prefix . 'wdpsslider');
    $i = 0;
    foreach ($sliders_ids_col as $slider_ids) {
      if (isset($_POST['check_' . $slider_ids])) {
        $this->duplicate_tabels($slider_ids);
        $i++;  
      }
    }
    $where = ((isset($_POST['search_value'])) ? 'WHERE name LIKE "%' . esc_html(stripslashes($_POST['search_value'])) . '%"' : '');
    $query = "SELECT * FROM " . $wpdb->prefix . "wdpsslider " . $where ;
    $rows = $wpdb->get_results($query);
    if ($i == 0) {
      if ($rows) {
        echo WDW_PS_Library::message(__('You must select at least one item.','wdps_back'), 'wd_error');  
      }      
    } 
    else {
      echo WDW_PS_Library::message(__('Items Succesfully Duplicated.', 'wdps_back'), 'wd_updated');
    }
    $this->display();
  }

  public function duplicate_tabels($slider_id) {
    global $wpdb;
    if ($slider_id) {
      $slider_row = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'wdpsslider where id="%d"', $slider_id));
    }
    if ($slider_row) {
      $save = $wpdb->insert($wpdb->prefix . 'wdpsslider', array(
        'name' => $slider_row->name,
        'published' => $slider_row->published,
        'full_width' => $slider_row->full_width,
        'width' => $slider_row->width,
        'height' => $slider_row->height,
        'bg_fit' => $slider_row->bg_fit,
        'align' => $slider_row->align,
        'effect' => $slider_row->effect,
        'time_intervval' => $slider_row->time_intervval,
        'autoplay' => $slider_row->autoplay,
        'shuffle' => $slider_row->shuffle,
        'music' => $slider_row->music,
        'music_url' => $slider_row->music_url,
        'preload_images' => $slider_row->preload_images,
        'background_color' => $slider_row->background_color,
        'background_transparent' =>$slider_row-> background_transparent,
        'glb_border_width' => $slider_row->glb_border_width,
        'glb_border_style' => $slider_row->glb_border_style,
        'glb_border_color' => $slider_row->glb_border_color,
        'glb_border_radius' => $slider_row->glb_border_radius,
        'glb_margin' => $slider_row->glb_margin,
        'glb_box_shadow' => $slider_row->glb_box_shadow,
        'image_right_click' => $slider_row->image_right_click,
        'prev_next_butt' => $slider_row->prev_next_butt,	
        'play_paus_post_butt' => $slider_row->play_paus_post_butt,
        'navigation' => $slider_row->navigation,
        'rl_butt_style' => $slider_row->rl_butt_style,
        'rl_butt_size' => $slider_row->rl_butt_size,
        'pp_butt_size' => $slider_row->pp_butt_size,	
        'butts_color' => $slider_row->butts_color,
        'butts_transparent' => $slider_row->butts_transparent,
        'hover_color' => $slider_row->hover_color,
        'nav_border_width' => $slider_row->nav_border_width,
        'nav_border_style' => $slider_row->nav_border_style,
        'nav_border_color' => $slider_row->nav_border_color,
        'nav_border_radius' => $slider_row->nav_border_radius,
        'nav_bg_color' => $slider_row->nav_bg_color,
        'bull_position' => $slider_row->bull_position,
        'bull_style' => $slider_row->bull_style,
        'bull_size' => $slider_row->bull_size,
        'bull_color' => $slider_row->bull_color,
        'bull_act_color' => $slider_row->bull_act_color,
        'bull_margin' => $slider_row->bull_margin,
        'film_pos' => $slider_row->film_pos,
        'film_thumb_width' => $slider_row->film_thumb_width,
        'film_thumb_height' => $slider_row->film_thumb_height,
        'film_bg_color' => $slider_row->film_bg_color,
        'film_tmb_margin' => $slider_row->film_tmb_margin,
        'film_act_border_width' => $slider_row->film_act_border_width,
        'film_act_border_style' => $slider_row->film_act_border_style,
        'film_act_border_color' => $slider_row->film_act_border_color,
        'film_dac_transparent' => $slider_row->film_dac_transparent,
        'css' => $slider_row->css,
        'timer_bar_type' => $slider_row->timer_bar_type,
        'timer_bar_size' => $slider_row->timer_bar_size,
        'timer_bar_color' => $slider_row->timer_bar_color,
        'timer_bar_transparent' => $slider_row->timer_bar_transparent,
        'layer_out_next' => $slider_row->layer_out_next,
        'layer_word_count' => $slider_row->layer_word_count,
        'stop_animation' => $slider_row->stop_animation,
        'right_butt_url' => $slider_row->right_butt_url,
        'left_butt_url' => $slider_row->left_butt_url,
        'right_butt_hov_url' => $slider_row->right_butt_hov_url,
        'left_butt_hov_url' => $slider_row->left_butt_hov_url,
        'rl_butt_img_or_not' => $slider_row->rl_butt_img_or_not,
        'bullets_img_main_url' => $slider_row->bullets_img_main_url,
        'bullets_img_hov_url' => $slider_row->bullets_img_hov_url,
        'bull_butt_img_or_not' => $slider_row->bull_butt_img_or_not,
        'play_paus_butt_img_or_not' => $slider_row->play_paus_butt_img_or_not,
        'play_butt_url' => $slider_row->play_butt_url,
        'play_butt_hov_url' => $slider_row->play_butt_hov_url,
        'paus_butt_url' => $slider_row->paus_butt_url,
        'paus_butt_hov_url' => $slider_row->paus_butt_hov_url,
        'start_slide_num' => $slider_row->start_slide_num,
        'effect_duration' => $slider_row->effect_duration,
        'carousel' => $slider_row->carousel,
        'carousel_image_counts' => $slider_row->carousel_image_counts,
        'carousel_image_parameters' => $slider_row->carousel_image_parameters,
        'carousel_fit_containerWidth' => $slider_row->carousel_fit_containerWidth,
        'carousel_width' => $slider_row->carousel_width,
        'parallax_effect' => $slider_row->parallax_effect,
        'dynamic' => $slider_row->dynamic,
        'cache_expiration' => $slider_row->cache_expiration,
        'posts_count' => $slider_row->posts_count,
        'choose_post' => $slider_row->choose_post,
        'post_sort' => $slider_row->post_sort,
        'taxonomies'=>$slider_row->taxonomies,
        'order_by_posts' => $slider_row->order_by_posts,
        'smart_crop' => $slider_row->smart_crop,
        'crop_image_position' => $slider_row->crop_image_position,
        'bull_back_act_color' => $slider_row->bull_back_act_color,
        'bull_back_color' => $slider_row->bull_back_color,
        'bull_radius' => $slider_row->bull_radius,
        'carousel_degree' => $slider_row->carousel_degree,
        'carousel_grayscale' => $slider_row->carousel_grayscale,
        'carousel_transparency' => $slider_row->carousel_transparency,
        'featured_image' => $slider_row->featured_image,
        'bull_hover' => $slider_row->bull_hover,
        'show_thumbnail' => $slider_row->show_thumbnail,
        'thumb_size' => $slider_row->thumb_size,
        'mouse_swipe_nav' => $slider_row->mouse_swipe_nav,
        'touch_swipe_nav' => $slider_row->touch_swipe_nav,
        'mouse_wheel_nav' => $slider_row->mouse_wheel_nav,
        'keyboard_nav' => $slider_row->keyboard_nav,
        'twoway_slideshow' => $slider_row->twoway_slideshow,
        'hide_on_mobile' => $slider_row->hide_on_mobile,
        'slider_loop' => $slider_row->slider_loop,
        'full_width_for_mobile' => $slider_row->full_width_for_mobile,
        'order_dir' => $slider_row->order_dir,
      ));
      $new_slider_id = $wpdb->get_var('SELECT MAX(id) FROM ' . $wpdb->prefix . 'wdpsslider');

      $slider_slides = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'wdpsslide where slider_id="%d"', $slider_id));
      if ($slider_slides) {
        foreach ($slider_slides as $single_slide) {
          $save = $wpdb->insert($wpdb->prefix . 'wdpsslide', array(
            'slider_id' => $new_slider_id,
            'title' => $single_slide->title,
            'type' => $single_slide->type,
            'order' => $single_slide->order,
            'published' => $single_slide->published,
            'link' => $single_slide->link,
            'post_id' => $single_slide->post_id,
            'image_url' => $single_slide->image_url,
            'thumb_url' => $single_slide->thumb_url,
            'target_attr_slide' => $single_slide->target_attr_slide,
          ));
          $new_slide_id = $wpdb->get_var('SELECT MAX(id) FROM ' . $wpdb->prefix . 'wdpsslide');
          $slider_layer = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'wdpslayer where slide_id="%d"', $single_slide->id));
          if ($slider_layer) {
            foreach ($slider_layer as $layer_id) {
              if ($layer_id) {            
                $save = $wpdb->insert($wpdb->prefix . 'wdpslayer', array(
                  'slide_id' => $new_slide_id,
                  'title' => $layer_id->title,
                  'type' => $layer_id->type,
                  'depth' => $layer_id->depth,
                  'text' => $layer_id->text,
                  'link' => $layer_id->link,
                  'left' => $layer_id->left,
                  'top' => $layer_id->top,
                  'start' => $layer_id->start,
                  'end' => $layer_id->end,
                  'published' => $layer_id->published,
                  'color' => $layer_id->color,
                  'size' => $layer_id->size,
                  'ffamily' => $layer_id->ffamily,
                  'fweight' => $layer_id->fweight,
                  'padding' => $layer_id->padding,
                  'fbgcolor' => $layer_id->fbgcolor,
                  'transparent' => $layer_id->transparent,
                  'border_width' => $layer_id->border_width,
                  'border_style' => $layer_id->border_style,
                  'border_color' => $layer_id->border_color,
                  'border_radius' => $layer_id->border_radius,
                  'shadow' => $layer_id->shadow,
                  'image_url' => $layer_id->image_url,
                  'image_width' => $layer_id->image_width,
                  'image_height' => $layer_id->image_height,
                  'image_scale' => $layer_id->image_scale,
                  'alt' => $layer_id->alt,
                  'imgtransparent' => $layer_id->imgtransparent,
                  'social_button' => $layer_id->social_button,
                  'hover_color' => $layer_id->hover_color,
                  'layer_effect_in' => $layer_id->layer_effect_in,
                  'layer_effect_out' => $layer_id->layer_effect_out,
                  'duration_eff_in' => $layer_id->duration_eff_in,
                  'duration_eff_out' => $layer_id->duration_eff_out,
                  'target_attr_layer' => $layer_id->target_attr_layer,
                  'hotp_width' => $layer_id->hotp_width,
                  'hotp_fbgcolor' => $layer_id->hotp_fbgcolor,
                  'hotp_border_width' => $layer_id->hotp_border_width,
                  'hotp_border_style' => $layer_id->hotp_border_style,
                  'hotp_border_color' => $layer_id->hotp_border_color,
                  'hotp_border_radius' => $layer_id->hotp_border_radius,
                  'hotp_text_position' => $layer_id->hotp_text_position,
                  'google_fonts' => $layer_id->google_fonts,
                  'layer_characters_count' => $layer_id->layer_characters_count,
                  'align_layer' => $layer_id->align_layer,
                  'text_alignment' => $layer_id->text_alignment,
                  'remove_shortcode' => $layer_id->remove_shortcode,
                  'infinite_in' => $layer_id->infinite_in,
                  'infinite_out' => $layer_id->infinite_out,
                  'hover_color_text' => $layer_id->hover_color_text,
                  'min_size' => $layer_id->min_size,
                ));
              }
            }
          }
        }
      }
    }
    return $new_slider_id;
  }

  function wdps_hex2rgb($hex) {
    $hex = str_replace("#", "", $hex);
    if (strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
    }
    else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
    }
    $rgb = array($r, $g, $b);
    return $rgb;
  }

  function wdps_imagettfbboxdimensions($font_size, $font_angle, $font, $text) {
    $box = @ImageTTFBBox($font_size, $font_angle, $font, $text) or die;
    $max_x = max(array($box[0], $box[2], $box[4], $box[6]));
    $max_y = max(array($box[1], $box[3], $box[5], $box[7]));
    $min_x = min(array($box[0], $box[2], $box[4], $box[6]));
    $min_y = min(array($box[1], $box[3], $box[5], $box[7]));
    return array(
      "width"  => ($max_x - $min_x),
      "height" => ($max_y - $min_y)
    );
  }

  public function delete($id) {
    global $wpdb;
    $query = $wpdb->prepare('DELETE FROM ' . $wpdb->prefix . 'wdpsslider WHERE id="%d"', $id);
    if ($wpdb->query($query)) {
      $query_image = $wpdb->prepare('DELETE t1.*, t2.* FROM ' . $wpdb->prefix . 'wdpsslide as t1 LEFT JOIN ' . $wpdb->prefix . 'wdpslayer as t2 ON t1.id=t2.slide_id WHERE t1.slider_id="%d"', $id);
      $wpdb->query($query_image);
      echo WDW_PS_Library::message(__('Item Succesfully Deleted.','wdps_back'), 'wd_updated');
    }
    else {
      echo WDW_PS_Library::message(__('Error. Please install plugin again.','wdps_back'), 'wd_error');
    }
    $this->display();
  }

  public function delete_all() {
    global $wpdb;
    $flag = FALSE;
    $sliders_ids_col = $wpdb->get_col('SELECT id FROM ' . $wpdb->prefix . 'wdpsslider');
    foreach ($sliders_ids_col as $slider_id) {
      if (isset($_POST['check_' . $slider_id]) || isset($_POST['check_all_items'])) {
        $flag = TRUE;
        $query = $wpdb->prepare('DELETE FROM ' . $wpdb->prefix . 'wdpsslider WHERE id="%d"', $slider_id);
        $wpdb->query($query);
        $query_image = $wpdb->prepare('DELETE t1.*, t2.* FROM ' . $wpdb->prefix . 'wdpsslide as t1 LEFT JOIN ' . $wpdb->prefix . 'wdpslayer as t2 ON t1.id=t2.slide_id WHERE t1.slider_id="%d"', $slider_id);
        $wpdb->query($query_image);
      }
    }
    $where = ((isset($_POST['search_value'])) ? 'WHERE name LIKE "%' . esc_html(stripslashes($_POST['search_value'])) . '%"' : '');
    $query = "SELECT * FROM " . $wpdb->prefix . "wdpsslider " . $where ;
    $rows = $wpdb->get_results($query);
    if ($flag) {
      echo WDW_PS_Library::message(__('Items Succesfully Deleted.','wdps_back'), 'wd_updated');
    }
    else {
      if($rows) {
        echo WDW_PS_Library::message(__('You must select at least one item.','wdps_back'), 'wd_error');
      }
    }
    $this->display();
  }

  public function publish($id) {
    global $wpdb;
    $save = $wpdb->update($wpdb->prefix . 'wdpsslider', array('published' => 1), array('id' => $id));
    if ($save !== FALSE) {
      echo WDW_PS_Library::message(__('Item Succesfully Published.','wdps_back'), 'wd_updated');
    }
    else {
      echo WDW_PS_Library::message(__('Error. Please install plugin again.','wdps_back'), 'wd_error');
    }
    $this->display();
  }

  public function publish_all() {
    global $wpdb;
    $flag = FALSE;
    if (isset($_POST['check_all_items'])) {
      $wpdb->query('UPDATE ' .  $wpdb->prefix . 'wdpsslider SET published=1');
      $flag = TRUE;
    }
    else {
      $sliders_ids_col = $wpdb->get_col('SELECT id FROM ' . $wpdb->prefix . 'wdpsslider');
      foreach ($sliders_ids_col as $slider_id) {
        if (isset($_POST['check_' . $slider_id])) {
          $flag = TRUE;
          $wpdb->update($wpdb->prefix . 'wdpsslider', array('published' => 1), array('id' => $slider_id));
        }
      }
    }
    $where = ((isset($_POST['search_value'])) ? 'WHERE name LIKE "%' . esc_html(stripslashes($_POST['search_value'])) . '%"' : '');
    $query = "SELECT * FROM " . $wpdb->prefix . "wdpsslider " . $where ;
    $rows = $wpdb->get_results($query);
    if ($flag) {
      echo WDW_PS_Library::message(__('Items Succesfully Published.','wdps_back'), 'wd_updated');
    }
    else {
      if($rows) {
        echo WDW_PS_Library::message(__('You must select at least one item.','wdps_back'), 'wd_error');
      }
    }
    $this->display();
  }

  public function unpublish($id) {
    global $wpdb;
    $save = $wpdb->update($wpdb->prefix . 'wdpsslider', array('published' => 0), array('id' => $id));
    if ($save !== FALSE) {
      echo WDW_PS_Library::message(__('Item Succesfully Unpublished.','wdps_back'), 'wd_updated');
    }
    else {
      echo WDW_PS_Library::message(__('Error. Please install plugin again.','wdps_back'), 'wd_error');
    }
    $this->display();
  }

  public function unpublish_all() {
    global $wpdb;
    $flag = FALSE;
    if (isset($_POST['check_all_items'])) {
      $wpdb->query('UPDATE ' .  $wpdb->prefix . 'wdpsslider SET published=0');
      $flag = TRUE;
    }
    else {
      $sliders_ids_col = $wpdb->get_col('SELECT id FROM ' . $wpdb->prefix . 'wdpsslider');
      foreach ($sliders_ids_col as $slider_id) {
        if (isset($_POST['check_' . $slider_id])) {
          $flag = TRUE;
          $wpdb->update($wpdb->prefix . 'wdpsslider', array('published' => 0), array('id' => $slider_id));
        }
      }
    }
    $where = ((isset($_POST['search_value'])) ? 'WHERE name LIKE "%' . esc_html(stripslashes($_POST['search_value'])) . '%"' : '');
    $query = "SELECT * FROM " . $wpdb->prefix . "wdpsslider " . $where ;
    $rows = $wpdb->get_results($query);
    if ($flag) {
      echo WDW_PS_Library::message(__('Items Succesfully Unpublished.','wdps_back'), 'wd_updated');
    }
    else {
      if($rows) {
        echo WDW_PS_Library::message(__('You must select at least one item.','wdps_back'), 'wd_error');
      }
    }
    $this->display();
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