<?php

class WDPSViewSlider {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  private $model;


  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function __construct($model) {
    $this->model = $model;
  }
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function display($id, $from_shortcode = 0, $wdps = 0) {
    require_once(WD_PS_DIR . '/framework/WDW_PS_Library.php');
    $wdps_array_glogal_options = json_decode(get_option("wdps_array_glogal_options"));
    $wdps_register_scripts = (isset($wdps_array_glogal_options)) ? $wdps_array_glogal_options->wdps_register_scripts : 0;
    if ($wdps_register_scripts) {
      wp_enqueue_style('wdps_frontend');
      wp_enqueue_style('wdps_effects');
      wp_enqueue_style('wdps_font-awesome');
      wp_enqueue_style('wdps_googlefonts');
      if ($wdps === 0) {
        wp_print_scripts('wdps_jquery_mobile');
        wp_print_scripts('wdps_hotspot');
        wp_print_scripts('wdps_frontend');
      }
    }
    $slider_row = $this->model->get_post_slider_row_data($id);
     if (!$slider_row) {
      echo WDW_PS_Library::message(__('There is no slider selected or the slider was deleted.', 'wdps'), 'wd_error');
      return;
    }
    if (!$slider_row->published) {
      return;
    }
    $resolutions = array(320, 480, 640, 768, 800, 1024, 1366, 1824, 3000);
    $image_right_click = $slider_row->image_right_click;

    $bull_position = $slider_row->bull_position;
    $bull_style_active = str_replace('-o', '', $slider_row->bull_style);
    $bull_style_deactive = $slider_row->bull_style;
    $bull_size_cont = $slider_row->bull_size + $slider_row->bull_margin * ($slider_row->bull_butt_img_or_not == 'text' ? 4 : 2);
    $bull_hover = isset($slider_row->bull_hover) ? $slider_row->bull_hover : 1;
    $show_thumbnail = isset($slider_row->show_thumbnail) ? $slider_row->show_thumbnail : 0;
    $thumb_size = isset($slider_row->thumb_size) ? $slider_row->thumb_size : '0.3';
    $order_dir = isset($slider_row->order_dir) ? $slider_row->order_dir : 'ASC';
    $slide_rows = $this->model->get_post_slide_rows_data($id, $order_dir);
    
    if (!$slide_rows) {
      echo WDW_PS_Library::message(__('There are no posts in this slider.', 'wdps'), 'wd_error');
      return;
    }

    $image_width = $slider_row->width;
    $image_height = $slider_row->height;

    $slides_count = count($slide_rows);
    $slideshow_effect = $slider_row->effect == 'zoomFade' ? 'fade' : $slider_row->effect;
    $slideshow_interval = $slider_row->time_intervval;
    $circle_timer_size = (2 * $slider_row->timer_bar_size - 2) * 2;
    
    $enable_slideshow_shuffle = $slider_row->shuffle;
    $enable_prev_next_butt = $slider_row->prev_next_butt;
    $enable_play_paus_butt = $slider_row->play_paus_post_butt;
    if (!$enable_prev_next_butt && !$enable_play_paus_butt) {
      $enable_slideshow_autoplay = 1;
    }
    else {
      $enable_slideshow_autoplay = $slider_row->autoplay;
    }
    if ($enable_slideshow_autoplay && !$enable_play_paus_butt && ($slides_count > 1)) {
      $autoplay = TRUE;
    }
    else {
      $autoplay = FALSE;
    }
    if ($slider_row->navigation == 'always') {
      $navigation = 0;
      $pp_btn_opacity = 1;
    }
    else {
      $navigation = 4000;
      $pp_btn_opacity = 0;
    }
    $enable_slideshow_music = $slider_row->music;
    $slideshow_music_url = (empty($slider_row->music_url)) ? '' : $slider_row->music_url;
	
    $left_or_top = 'left';
    $width_or_height = 'width';
    $outerWidth_or_outerHeight = 'outerWidth';
    if ($enable_slideshow_shuffle || ($slider_row->start_slide_num == 0)) {
      $slide_ids = array();
      foreach ($slide_rows as $slide_row) {
        if ($slider_row->dynamic == 1) {
          $slide_row->id = $slide_row->ID;
        }
        $slide_ids[] += $slide_row->id;
      }
      $current_image_id = $slide_ids[array_rand($slide_ids)];
      $start_slide_num = array_search($current_image_id, $slide_ids);
    }
    else {
      if ($slider_row->start_slide_num > 0 && $slider_row->start_slide_num <= $slides_count) {
        $start_slide_num = $slider_row->start_slide_num - 1;
      }
      else {
        $start_slide_num = 0;
      }
      if ($slider_row->dynamic == 1) {
        $current_image_id = ($slide_rows ? $slide_rows[$start_slide_num]->ID : 0);
      }
      else {
        $current_image_id = ($slide_rows ? $slide_rows[$start_slide_num]->id : 0);
      }
    }
    $mouse_swipe_nav = isset($slider_row->mouse_swipe_nav) ? $slider_row->mouse_swipe_nav : 0;
    $touch_swipe_nav = isset($slider_row->touch_swipe_nav) ? $slider_row->touch_swipe_nav : 1;
    $mouse_wheel_nav = isset($slider_row->mouse_wheel_nav) ? $slider_row->mouse_wheel_nav : 0;
    $keyboard_nav = isset($slider_row->keyboard_nav) ? $slider_row->keyboard_nav : 0;
    $twoway_slideshow = isset($slider_row->twoway_slideshow) ? $slider_row->twoway_slideshow : 0;
    $hide_on_mobile = (isset($slider_row->hide_on_mobile) ? $slider_row->hide_on_mobile : 0);
    $slider_loop = isset($slider_row->slider_loop) ? $slider_row->slider_loop : 1;
    $full_width_for_mobile = isset($slider_row->full_width_for_mobile) ? (int) $slider_row->full_width_for_mobile : 0;
    global $wp;
    $current_url = add_query_arg($wp->query_string, '', home_url($wp->request));
    $smart_crop = isset($slider_row->smart_crop) ? $slider_row->smart_crop : 0;
    $crop_image_position = isset($slider_row->crop_image_position) ? $slider_row->crop_image_position : 'center center';
    $current_image_url = '';
    ?>
    <style>
      .wdps_bulframe_<?php echo $wdps; ?>{
        display: none; 
        background-image: url(''); 
        margin: 0px;  
        position: absolute;
        z-index: 3;
        -webkit-transition: left 1s, right 1s;
        transition: left 1s, right 1s;
        width: <?php echo 100 * $thumb_size ?>%;
        height: <?php echo 100 * $thumb_size ?>%;
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> {
        text-align: <?php echo $slider_row->align; ?>;
        margin: <?php echo $slider_row->glb_margin; ?>px <?php echo $slider_row->full_width ? 0 : ''; ?>;
        visibility: hidden;
        <?php echo $slider_row->full_width ? 'position: relative;' : ''; ?>
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_slideshow_image_wrap_<?php echo $wdps; ?> * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        border-bottom:none;
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_slideshow_image_wrap_<?php echo $wdps; ?> {
        background-color: <?php echo WDW_PS_Library::spider_hex2rgba($slider_row->background_color, (100 - $slider_row->background_transparent) / 100); ?>;
        border-width: <?php echo $slider_row->glb_border_width; ?>px;
        border-style: <?php echo $slider_row->glb_border_style; ?>;
        border-color: #<?php echo $slider_row->glb_border_color; ?>;
        border-radius: <?php echo $slider_row->glb_border_radius; ?>;
        border-collapse: collapse;
        display: inline-block;
        position: <?php echo $slider_row->full_width ? 'absolute' : 'relative'; ?>;
        text-align: center;
        width: 100%;
        max-width: <?php echo $image_width; ?>px;
        box-shadow: <?php echo $slider_row->glb_box_shadow; ?>;
        overflow: hidden;
        z-index: 0;
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_slideshow_image_<?php echo $wdps; ?> {
        padding: 0 !important;
        margin: 0 !important;
        float: none !important;
        vertical-align: middle;
        background-position: <?php echo ($smart_crop == '1' && ($slider_row->bg_fit == 'cover' || $slider_row->bg_fit == 'contain')) ? $crop_image_position : 'center center'; ?>;
        background-repeat: no-repeat;
        background-size: <?php echo $slider_row->bg_fit; ?>;
        width: 100%;
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_slideshow_image_container_<?php echo $wdps; ?> {
        display: /*table*/block;
        position: absolute;
        text-align: center;
        vertical-align: middle;
        width:  100%;
        height: /*inherit*/100%;
      }
      <?php
      foreach ($resolutions as $key => $resolution) {
        if ($key) {
          $prev_resolution = $resolutions[$key - 1] + 1;
        }
        else {
          $prev_resolution = 0;
        }
        $media_slide_height = ($image_width > $resolution) ? ($image_height * $resolution) / $image_width : $image_height;
        $media_bull_size = ((int) ($resolution / 26) > $slider_row->bull_size) ? $slider_row->bull_size : (int) ($resolution / 26);
        $media_bull_margin = ($slider_row->bull_margin > 2 && $resolution < 481) ? 2 : $slider_row->bull_margin;
        $media_bull_size_cont = $media_bull_size + $media_bull_margin * ($slider_row->bull_butt_img_or_not == 'text' ? 4 : 2);
        $media_pp_butt_size = ((int) ($resolution / 16) > $slider_row->pp_butt_size) ? $slider_row->pp_butt_size : (int) ($resolution / 16);
        $media_rl_butt_size = ((int) ($resolution / 16) > $slider_row->rl_butt_size) ? $slider_row->rl_butt_size : (int) ($resolution / 16);
        ?>
      @media only screen and (min-width: <?php echo $prev_resolution; ?>px) and (max-width: <?php echo $resolution; ?>px) {
        #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_slideshow_dots_thumbnails_<?php echo $wdps; ?> {
          height: <?php echo $media_bull_size_cont; ?>px;
          width: <?php echo $media_bull_size_cont * $slides_count; ?>px;
        }
        #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_slideshow_dots_<?php echo $wdps; ?> {
          font-size: <?php echo $media_bull_size; ?>px;
          margin: <?php echo $media_bull_margin; ?>px;
          <?php
          if ($slider_row->bull_butt_img_or_not != 'text') {
            ?>
          width: <?php echo $media_bull_size; ?>px;
          height: <?php echo $media_bull_size; ?>px;
            <?php
          }
          else {
            ?>
          padding: <?php echo $media_bull_margin; ?>px;
          height: <?php echo $media_bull_size + 2 * $media_bull_margin; ?>px;
            <?php
          }
          ?>
        }
        #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_pp_btn_cont {  
          font-size: <?php echo $media_pp_butt_size; ?>px;
          height: <?php echo $media_pp_butt_size; ?>px;
          width: <?php echo $media_pp_butt_size; ?>px;
        }
        #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_left_btn_cont,
        #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_right_btn_cont {
          height: <?php echo $media_rl_butt_size; ?>px;
          font-size: <?php echo $media_rl_butt_size; ?>px;
          width: <?php echo $media_rl_butt_size; ?>px;
        }
      }
        <?php
      }
      ?>
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_slideshow_video_<?php echo $wdps; ?> {
        padding: 0 !important;
        margin: 0 !important;
        float: none !important;
        width: 100%;
        vertical-align: middle;
        display: inline-block;
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> #wdps_post_slideshow_play_pause_<?php echo $wdps; ?> {  
        color: #<?php echo $slider_row->butts_color; ?>;
        cursor: pointer;
        position: relative;
        z-index: 13;
        width: inherit;
        height: inherit;
        font-size: inherit;
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> #wdps_post_slideshow_play_pause_<?php echo $wdps; ?>:hover {  
        color: #<?php echo $slider_row->hover_color; ?>;
        cursor: pointer;
      }
      <?php
      if ($slider_row->play_paus_butt_img_or_not != 'style') {
        ?>
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_post_slideshow_play_pause_<?php echo $wdps; ?>.fa-pause:before,
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_post_slideshow_play_pause_<?php echo $wdps; ?>.fa-play:before {
        content: "";
      }
	    #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> #wdps_post_slideshow_play_pause_<?php echo $wdps; ?>.fa-play {
        background-image: url('<?php echo addslashes(htmlspecialchars_decode ($slider_row->play_butt_url, ENT_QUOTES)); ?>');
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        transition: background-image 0.2s ease-out;
        -ms-transition: background-image 0.2s ease-out;
        -moz-transition: background-image 0.2s ease-out;
        -webkit-transition: background-image 0.2s ease-out;
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> #wdps_post_slideshow_play_pause_<?php echo $wdps; ?>.fa-play:before {
        content: url('<?php echo addslashes(htmlspecialchars_decode($slider_row->play_butt_hov_url, ENT_QUOTES)); ?>');
        width: 0;
        height: 0;
        visibility: hidden;
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> #wdps_post_slideshow_play_pause_<?php echo $wdps; ?>.fa-play:hover {
        background-image: url('<?php echo addslashes(htmlspecialchars_decode ($slider_row->play_butt_hov_url, ENT_QUOTES)); ?>');
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover; 
        transition: background-image 0.2s ease-in;
        -ms-transition: background-image 0.2s ease-in;
        -moz-transition: background-image 0.2s ease-in;
        -webkit-transition: background-image 0.2s ease-in;
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> #wdps_post_slideshow_play_pause_<?php echo $wdps; ?>.fa-pause{
        background-image: url('<?php echo addslashes(htmlspecialchars_decode ($slider_row->paus_butt_url, ENT_QUOTES)); ?>');
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        transition: background-image 0.2s ease-out;
        -ms-transition: background-image 0.2s ease-out;
        -moz-transition: background-image 0.2s ease-out;
        -webkit-transition: background-image 0.2s ease-out;
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> #wdps_post_slideshow_play_pause_<?php echo $wdps; ?>.fa-pause:before {
        content: url('<?php echo addslashes(htmlspecialchars_decode($slider_row->paus_butt_hov_url, ENT_QUOTES)); ?>');
        width: 0;
        height: 0;
        visibility: hidden;
      }
	    #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> #wdps_post_slideshow_play_pause_<?php echo $wdps; ?>.fa-pause:hover {
        background-image: url('<?php echo addslashes(htmlspecialchars_decode ($slider_row->paus_butt_hov_url, ENT_QUOTES)); ?>');
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        transition: background-image 0.2s ease-in;
        -ms-transition: background-image 0.2s ease-in;
        -moz-transition: background-image 0.2s ease-in;
        -webkit-transition: background-image 0.2s ease-in;
      }
        <?php
      }
      ?>
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_left-ico_<?php echo $wdps; ?>,
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_right-ico_<?php echo $wdps; ?> {
        background-color: <?php echo WDW_PS_Library::spider_hex2rgba($slider_row->nav_bg_color, (100 - $slider_row->butts_transparent) / 100); ?>;
        border-radius: <?php echo $slider_row->nav_border_radius; ?>;
        border: <?php echo $slider_row->nav_border_width; ?>px <?php echo $slider_row->nav_border_style; ?> #<?php echo $slider_row->nav_border_color; ?>;
        border-collapse: separate;
        color: #<?php echo $slider_row->butts_color; ?>;
        left: 0;
        top: 0;
        -moz-box-sizing: content-box;
        box-sizing: content-box;
        cursor: pointer;
        line-height: 0;
        width: inherit;
        height: inherit;
        font-size: inherit;
        position: absolute;
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_left-ico_<?php echo $wdps; ?> {
        left: -<?php echo $navigation; ?>px;
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_right-ico_<?php echo $wdps; ?> {
        left: <?php echo $navigation; ?>px;
      }
      <?php
      if ($slider_row->rl_butt_img_or_not != 'style') {
        ?>
	    #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_left-ico_<?php echo $wdps; ?> {
        left: -<?php echo $navigation; ?>px;
        background-image: url('<?php echo addslashes(htmlspecialchars_decode($slider_row->left_butt_url, ENT_QUOTES)); ?>');
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        transition: background-image 0.2s ease-out;
        -ms-transition: background-image 0.2s ease-out;
        -moz-transition: background-image 0.2s ease-out;
        -webkit-transition: background-image 0.2s ease-out;
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_left-ico_<?php echo $wdps; ?>:before {
        content: url('<?php echo addslashes(htmlspecialchars_decode($slider_row->left_butt_hov_url, ENT_QUOTES)); ?>');
        width: 0;
        height: 0;
        visibility: hidden;
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_left-ico_<?php echo $wdps; ?>:hover {
        left: -<?php echo $navigation; ?>px;
        background-image: url('<?php echo addslashes(htmlspecialchars_decode($slider_row->left_butt_hov_url, ENT_QUOTES)); ?>');
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover; 
        transition: background-image 0.2s ease-in;
        -ms-transition: background-image 0.2s ease-in;
        -moz-transition: background-image 0.2s ease-in;
        -webkit-transition: background-image 0.2s ease-in;
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_right-ico_<?php echo $wdps; ?> {
        left: <?php echo $navigation; ?>px;
        background-image: url('<?php echo addslashes(htmlspecialchars_decode($slider_row->right_butt_url, ENT_QUOTES)); ?>');
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        transition: background-image 0.2s ease-out;
        -ms-transition: background-image 0.2s ease-out;
        -moz-transition: background-image 0.2s ease-out;
        -webkit-transition: background-image 0.2s ease-out;
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_right-ico_<?php echo $wdps; ?>:before {
        content: url('<?php echo addslashes(htmlspecialchars_decode($slider_row->right_butt_hov_url, ENT_QUOTES)); ?>');
        width: 0;
        height: 0;
        visibility: hidden;
      }
	    #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_right-ico_<?php echo $wdps; ?>:hover {
        left: <?php echo $navigation; ?>px;
        background-image: url('<?php echo addslashes(htmlspecialchars_decode($slider_row->right_butt_hov_url, ENT_QUOTES)); ?>');
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        transition: background-image 0.2s ease-in;
        -ms-transition: background-image 0.2s ease-in;
        -moz-transition: background-image 0.2s ease-in;
        -webkit-transition: background-image 0.2s ease-in;
      }
        <?php
      }
      ?>
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> #wdps_post_slideshow_play_pause_<?php echo $wdps; ?> {
        opacity: <?php echo $pp_btn_opacity; ?>;
        filter: "Alpha(opacity=<?php echo $pp_btn_opacity * 100; ?>)";
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_left-ico_<?php echo $wdps; ?>:hover,
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_right-ico_<?php echo $wdps; ?>:hover {
        color: #<?php echo $slider_row->hover_color; ?>;
        cursor: pointer;
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_none_selectable_<?php echo $wdps; ?> {
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_slide_container_<?php echo $wdps; ?> {
        display: table-cell;
        margin: 0 auto;
        position: absolute;
        vertical-align: middle;
        width: 100%;
        height: 100%;
        overflow: hidden;
        cursor: <?php echo $mouse_swipe_nav ? '-moz-grab' : 'inherit'; ?>;
        cursor: <?php echo $mouse_swipe_nav ? '-webkit-grab' : 'inherit'; ?>;
        cursor: <?php echo $mouse_swipe_nav ? 'grab' : 'inherit'; ?>;
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_slide_container_<?php echo $wdps; ?>:active {
        cursor: <?php echo $mouse_swipe_nav ? '-moz-grabbing' : 'inherit'; ?>;
        cursor: <?php echo $mouse_swipe_nav ? '-webkit-grabbing' : 'inherit'; ?>;
        cursor: <?php echo $mouse_swipe_nav ? 'grabbing' : 'inherit'; ?>;
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_slide_bg_<?php echo $wdps; ?> {
        margin: 0 auto;
        width: /*inherit*/100%;
        height: /*inherit*/100%;
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_slider_<?php echo $wdps; ?> {
        height: /*inherit*/100%;
        width: /*inherit*/100%;
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_slideshow_image_spun_<?php echo $wdps; ?> {
        width: /*inherit*/100%;
        height: /*inherit*/100%;
        display: table-cell;
        filter: Alpha(opacity=100);
        opacity: 1;
        position: absolute;
        vertical-align: middle;
        z-index: 2;
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_slideshow_image_second_spun_<?php echo $wdps; ?> {
        width: /*inherit*/100%;
        height: /*inherit*/100%;
        display: table-cell;
        filter: Alpha(opacity=0);
        opacity:0;
        position: absolute;
        vertical-align: middle;
        z-index: 1;
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_grid_<?php echo $wdps; ?> {
        display: none;
        height: 100%;
        overflow: hidden;
        position: absolute;
        width: 100%;
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_gridlet_<?php echo $wdps; ?> {
        opacity: 1;
        filter: Alpha(opacity=100);
        position: absolute;
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_slideshow_dots_container_<?php echo $wdps; ?> {
        opacity: <?php echo $bull_hover; ?>;
        filter: "Alpha(opacity=<?php echo $bull_hover * 100; ?>)";
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_slideshow_dots_container_<?php echo $wdps; ?> {
        display: block;
        overflow: hidden;
        position: absolute;
        width: 100%;
        <?php echo $bull_position; ?>: 0;
        /*z-index: 17;*/
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_slideshow_dots_thumbnails_<?php echo $wdps; ?> {
        left: 0px;
        font-size: 0;
        margin: 0 auto;
        position: relative;
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_slideshow_dots_<?php echo $wdps; ?> {
        display: inline-block;
        position: relative;
        color: #<?php echo $slider_row->bull_color; ?>;
        cursor: pointer;
        z-index: 17;
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_slideshow_dots_active_<?php echo $wdps; ?> {
        opacity: 1;
        filter: Alpha(opacity=100);
        <?php
        if ($slider_row->bull_butt_img_or_not != 'style' && $slider_row->bull_butt_img_or_not != 'text') {
          ?>
        display: inline-block;
        background-image: url('<?php echo addslashes(htmlspecialchars_decode($slider_row->bullets_img_main_url, ENT_QUOTES)); ?>');
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        transition: background-image 0.2s ease-in;
        -ms-transition: background-image 0.2s ease-in;
        -moz-transition: background-image 0.2s ease-in;
        -webkit-transition: background-image 0.2s ease-in;
          <?php
        }
        else if ($slider_row->bull_butt_img_or_not == 'text') {
          ?>
        background-color: #<?php echo $slider_row->bull_back_act_color; ?>;
        border-radius: <?php echo $slider_row->bull_radius; ?>;
          <?php
        }
        else if ($slider_row->bull_butt_img_or_not == 'style') {
          ?>
        color: #<?php echo $slider_row->bull_act_color; ?>;
          <?php
        }
        ?>  
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_slideshow_dots_deactive_<?php echo $wdps; ?> {
        <?php
        if ($slider_row->bull_butt_img_or_not != 'style' && $slider_row->bull_butt_img_or_not != 'text') {
          ?>
        display: inline-block;
        background-image: url('<?php echo addslashes(htmlspecialchars_decode($slider_row->bullets_img_hov_url, ENT_QUOTES)); ?>');
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        transition: background-image 0.2s ease-in;
        -ms-transition: background-image 0.2s ease-in;
        -moz-transition: background-image 0.2s ease-in;
        -webkit-transition: background-image 0.2s ease-in;
          <?php
        }
        else if ($slider_row->bull_butt_img_or_not == 'text') {
          ?>
        background-color: #<?php echo $slider_row->bull_back_color; ?>;
        border-radius: <?php echo $slider_row->bull_radius; ?>;
          <?php
        }
        ?>
      }
      <?php
      if ($slider_row->timer_bar_type == 'top' || $slider_row->timer_bar_type == 'bottom') {
        ?>
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_line_timer_container_<?php echo $wdps; ?> {
        display: block;
        position: absolute;
        overflow: hidden;
        <?php echo $slider_row->timer_bar_type; ?>: 0;
        z-index: 16;
        width: 100%;
        height: <?php echo $slider_row->timer_bar_size; ?>px;
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_line_timer_<?php echo $wdps; ?> {
        z-index: 17;
        width: 0;
        height: <?php echo $slider_row->timer_bar_size; ?>px;
        background: #<?php echo $slider_row->timer_bar_color; ?>;
        opacity: <?php echo number_format((100 - $slider_row->timer_bar_transparent) / 100, 2, ".", ""); ?>;
        filter: alpha(opacity=<?php echo 100 - $slider_row->timer_bar_transparent; ?>);
      }
        <?php
      }
      elseif ($slider_row->timer_bar_type != 'none') {
        ?>
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_line_timer_container_<?php echo $wdps; ?> {
        display: block;
        position: absolute;
        overflow: hidden;
        <?php echo $slider_row->timer_bar_type; ?>: 0;
        z-index: 16;
        width: 100%;
        height: <?php echo $circle_timer_size; ?>px;
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_circle_timer_container_<?php echo $wdps; ?> {
        display: block;
        position: absolute;
        overflow: hidden;
        z-index: 16;
        width: 100%;
        <?php switch ($slider_row->timer_bar_type) { 
        case 'circle_top_right': echo 'top: 0px; text-align:right;'; break;
        case 'circle_top_left': echo 'top: 0px; text-align:left;'; break;
        case 'circle_bot_right': echo 'bottom: 0px; text-align:right;'; break;
        case 'circle_bot_left': echo 'bottom: 0px; text-align:left;'; break;
        default: 'top: 0px; text-align:right;';
         } ?>
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_circle_timer_container_<?php echo $wdps; ?> .wdps_circle_timer_<?php echo $wdps; ?> {
        display: inline-block;
        width: <?php echo $circle_timer_size; ?>px;
        height: <?php echo $circle_timer_size; ?>px;
        position: relative;
        opacity: <?php echo number_format((100 - $slider_row->timer_bar_transparent) / 100, 2, ".", ""); ?>;
        filter: alpha(opacity=<?php echo 100 - $slider_row->timer_bar_transparent; ?>);
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_circle_timer_container_<?php echo $wdps; ?> .wdps_circle_timer_<?php echo $wdps; ?> .wdps_circle_timer_parts_<?php echo $wdps; ?> {
        display: table;
        width: 100%;
        height: 100%;
        border-radius: 100%;
        position: relative;
      }
      .wdps_circle_timer_part_<?php echo $wdps; ?> {
        display: table-cell;
        width: 50%;
        height: 100%;
        overflow: hidden !important;
      }
      .wdps_circle_timer_small_parts_<?php echo $wdps; ?> {
        display: block;
        width: 100%;
        height: 50%;
        background: #<?php echo $slider_row->timer_bar_color; ?>;
        position: relative;
      }
      .wdps_circle_timer_center_cont_<?php echo $wdps; ?> {
        display: table;
        width: <?php echo $circle_timer_size; ?>px;
        height: <?php echo $circle_timer_size; ?>px;
        position: absolute;
        text-align: center;
        top:0px;
        vertical-align:middle;
      }
      .wdps_circle_timer_center_<?php echo $wdps; ?> {
        display: table-cell;
        width: 100%; 
        height: 100%;
        text-align: center;
        line-height: 0px !important;
        vertical-align: middle;
      }
      .wdps_circle_timer_center_<?php echo $wdps; ?> div {
        display: inline-block;
        width: <?php echo $circle_timer_size / 2 - 2; ?>px;
        height: <?php echo $circle_timer_size / 2 - 2; ?>px;		
        background-color: #FFFFFF;
        border-radius: 100%;
        z-index: 300;
        position: relative;
      }
        <?php
      }
      ?>
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_slideshow_image_spun1_<?php echo $wdps; ?> {
        display: table; 
        width: /*inherit*/100%; 
        height: /*inherit*/100%;
      }
      #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_slideshow_image_spun2_<?php echo $wdps; ?> {
        display: table-cell; 
        vertical-align: middle; 
        text-align: center;
        overflow: hidden;
      }
      <?php 
      if ($hide_on_mobile) {
        ?>
      @media screen and (max-width: <?php echo $hide_on_mobile; ?>px){
        #wdps_container1_<?php echo $wdps; ?> {
           display: none; 
         }
       }
        <?php
      }
      if ($full_width_for_mobile) {
        ?>
      @media screen and (max-width: <?php echo $full_width_for_mobile; ?>px) {
        #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> {
          margin: <?php echo $slider_row->glb_margin; ?>px 0;
          position: relative;
        }
        #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_slideshow_image_wrap_<?php echo $wdps; ?> {
          position: absolute;
        }
      }
       <?php
      }
      echo $slider_row->css;
      foreach ($slide_rows as $key => $slide_row) {
        if ($slider_row->dynamic == 1) {
          $slide_row->id = $slide_row->ID;
        }
        $layers_row = $slide_row->layer;
        if ($layers_row) {	
          foreach ($layers_row as $key => $layer) {
            if ($layer->published) {			
              $prefix = 'wdps_' . $wdps . '_slide_' . $slide_row->id . '_layer_'. $layer->id;
              switch ($layer->type) {
                case 'text': {
                  ?>
                    #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> #<?php echo $prefix; ?> {
                      font-size: <?php echo $layer->size; ?>px;
                      line-height: 1.25em;
                      padding: <?php echo $layer->padding; ?>;
                    }
                    #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_layer_<?php echo $layer->id; ?>{
                      opacity: <?php echo ($layer->layer_effect_in != 'none') ? '0 !important' : '1'; ?>;
                      filter: "Alpha(opacity=<?php echo ($layer->layer_effect_in != 'none') ? '0' : '100'; ?>)" !important;
                    }
                    #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> #<?php echo $prefix; ?>:hover {
                      color: #<?php echo $layer->hover_color_text; ?> !important;
                    }
                  <?php
                  break;
                }
                case 'image': {
                  ?>
                    #wdps_container1_<?php echo $wdps; ?> #wdps_container2_<?php echo $wdps; ?> .wdps_layer_<?php echo $layer->id; ?>{
                      opacity: <?php echo ($layer->layer_effect_in != 'none') ? '0 !important' : '1'; ?>;
                      filter: "Alpha(opacity=<?php echo ($layer->layer_effect_in != 'none') ? '0' : '100'; ?>)" !important;
                    }
                  <?php
                  break;
                }
                default:
                  break;
              }
            }
          }
        }
      }
      ?>
    </style>
    <script>
      var wdps_glb_margin_<?php echo $wdps; ?> = parseInt('<?php echo $slider_row->glb_margin; ?>');
      var wdps_data_<?php echo $wdps; ?> = [];
      var wdps_event_stack_<?php echo $wdps; ?> = [];
      var wdps_clear_layers_effects_in_<?php echo $wdps; ?> = [];
      var wdps_clear_layers_effects_out_<?php echo $wdps; ?> = [];
      var wdps_clear_layers_effects_out_before_change_<?php echo $wdps; ?> = [];
      if (<?php echo $slider_row->layer_out_next; ?>) {
        var wdps_duration_for_change_<?php echo $wdps; ?> = 500;
        var wdps_duration_for_clear_effects_<?php echo $wdps; ?> = 530;
      }
      else {
        var wdps_duration_for_change_<?php echo $wdps; ?> = 0;
        var wdps_duration_for_clear_effects_<?php echo $wdps; ?> = 0;
      }
      <?php
        foreach ($slide_rows as $key => $slide_row) {
          if ($slider_row->dynamic == 1) {
            $post_id = $slide_row->ID;
            $thumb_id = get_post_thumbnail_id($post_id);
            $slide_row->id = $slide_row->ID;
            $slide_row->image_url = wp_get_attachment_url($thumb_id);
            $slide_row->thumb_url = wp_get_attachment_url($thumb_id);
          }
        ?>
        wdps_clear_layers_effects_in_<?php echo $wdps; ?>["<?php echo $key; ?>"] = [];
        wdps_clear_layers_effects_out_<?php echo $wdps; ?>["<?php echo $key; ?>"] = [];
        wdps_clear_layers_effects_out_before_change_<?php echo $wdps; ?>["<?php echo $key; ?>"] = [];
        wdps_data_<?php echo $wdps; ?>["<?php echo $key; ?>"] = [];
        wdps_data_<?php echo $wdps; ?>["<?php echo $key; ?>"]["id"] = "<?php echo $slide_row->id; ?>";
        wdps_data_<?php echo $wdps; ?>["<?php echo $key; ?>"]["image_url"] = "<?php echo addslashes(htmlspecialchars_decode ($slide_row->image_url,ENT_QUOTES)); ?>";
        wdps_data_<?php echo $wdps; ?>["<?php echo $key; ?>"]["thumb_url"] = "<?php echo addslashes(htmlspecialchars_decode ($slide_row->thumb_url,ENT_QUOTES)); ?>";
        wdps_data_<?php echo $wdps; ?>["<?php echo $key; ?>"]["bull_position"] = "<?php echo $bull_position; ?>";          
        wdps_data_<?php echo $wdps; ?>["<?php echo $key; ?>"]["is_video"] = "image";
        wdps_data_<?php echo $wdps; ?>["<?php echo $key; ?>"]["slide_layers_count"] = 0;
        <?php
        $layers_row = $slide_row->layer;
        if ($layers_row) {
          foreach ($layers_row as $layer_key => $layer) {
            if (!isset($layer->align_layer)) {
              $layer->align_layer = 0;
            }
            if (!isset($layer->infinite_in)) {
              $layer->infinite_in = 1;
            }
            if (!isset($layer->infinite_out)) {
              $layer->infinite_out = 1;
            }
            if (!isset($layer->min_size)) {
              $layer->min_size = 11;
            }
            ?>
            wdps_data_<?php echo $wdps; ?>["<?php echo $key; ?>"]["layer_<?php echo $layer_key; ?>_id"] = "<?php echo $layer->id; ?>";
            wdps_data_<?php echo $wdps; ?>["<?php echo $key; ?>"]["layer_<?php echo $layer_key; ?>_layer_effect_in"] = "<?php echo $layer->layer_effect_in; ?>";
            wdps_data_<?php echo $wdps; ?>["<?php echo $key; ?>"]["layer_<?php echo $layer_key; ?>_duration_eff_in"] = "<?php echo $layer->duration_eff_in; ?>";
            wdps_data_<?php echo $wdps; ?>["<?php echo $key; ?>"]["layer_<?php echo $layer_key; ?>_layer_effect_out"] = "<?php echo $layer->layer_effect_out; ?>";
            wdps_data_<?php echo $wdps; ?>["<?php echo $key; ?>"]["layer_<?php echo $layer_key; ?>_duration_eff_out"] = "<?php echo $layer->duration_eff_out; ?>";
            wdps_data_<?php echo $wdps; ?>["<?php echo $key; ?>"]["layer_<?php echo $layer_key; ?>_social_button"] = "<?php echo $layer->social_button; ?>";
            wdps_data_<?php echo $wdps; ?>["<?php echo $key; ?>"]["layer_<?php echo $layer_key; ?>_start"] = "<?php echo $layer->start; ?>";
            wdps_data_<?php echo $wdps; ?>["<?php echo $key; ?>"]["layer_<?php echo $layer_key; ?>_end"] = "<?php echo $layer->end; ?>";
            wdps_data_<?php echo $wdps; ?>["<?php echo $key; ?>"]["layer_<?php echo $layer_key; ?>_type"] = "<?php echo $layer->type; ?>";
            wdps_data_<?php echo $wdps; ?>["<?php echo $key; ?>"]["layer_<?php echo $layer_key; ?>_align_layer"] = "<?php echo $layer->align_layer; ?>";
            wdps_data_<?php echo $wdps; ?>["<?php echo $key; ?>"]["layer_<?php echo $layer_key; ?>_video_autoplay"] = "<?php echo $layer->image_scale; ?>";
            wdps_data_<?php echo $wdps; ?>["<?php echo $key; ?>"]["slide_layers_count"] ++;
            wdps_data_<?php echo $wdps; ?>["<?php echo $key; ?>"]["layer_<?php echo $layer_key; ?>_infinite_in"] = "<?php echo $layer->infinite_in; ?>";
            wdps_data_<?php echo $wdps; ?>["<?php echo $key; ?>"]["layer_<?php echo $layer_key; ?>_infinite_out"] = "<?php echo $layer->infinite_out; ?>";
            <?php
          }
        }		
      }
      ?>    
    </script>
    <div id="wdps_container1_<?php echo $wdps; ?>">
      <div class="wdps_loading">
        <div class="wdps_loading_img"></div>
      </div>
      <div id="wdps_container2_<?php echo $wdps; ?>">
        <div class="wdps_slideshow_image_wrap_<?php echo $wdps; ?>">
          <?php
          $current_pos = 0;
            ?>
          <div id="wdps_slideshow_image_container_<?php echo $wdps; ?>" class="wdps_slideshow_image_container_<?php echo $wdps; ?>">
            <?php
              if ($bull_position != 'none' && $slides_count > 1) {
                ?>
              <div class="wdps_slideshow_dots_container_<?php echo $wdps; ?>" onmouseleave="wdps_hide_thumb(<?php echo $wdps; ?>)">
                <div class="wdps_slideshow_dots_thumbnails_<?php echo $wdps; ?>">
                  <?php
                   foreach ($slide_rows as $key => $slide_row) {
                    if ($slider_row->bull_butt_img_or_not == 'style') {
                       if($slider_row->dynamic == 1) {
                        $slide_row->id = $slide_row->ID;  
                       }    
                      ?>
                  <i id="wdps_dots_<?php echo $key; ?>_<?php echo $wdps; ?>"
                     class="wdps_slideshow_dots_<?php echo $wdps; ?> fa <?php echo (($slide_row->id == $current_image_id) ? $bull_style_active . ' wdps_slideshow_dots_active_' . $wdps : $bull_style_deactive . ' wdps_slideshow_dots_deactive_' . $wdps); ?>"
                     <?php echo  $show_thumbnail == 1 ? 'onmouseover="wdps_show_thumb(' . $key . ', ' . $wdps . ')"' : ''; ?>
                     onclick="wdps_change_image_<?php echo $wdps; ?>(parseInt(jQuery('#wdps_current_image_key_<?php echo $wdps; ?>').val()), '<?php echo $key; ?>', wdps_data_<?php echo $wdps; ?>)">
                            
                  </i>
                      <?php
                    }
                    else {
                      if($slider_row->dynamic == 1) {
                        $slide_row->id = $slide_row->ID; 
                        $slide_title = $slide_row->post_title;
                      }
                      else {
                        $slide_title = $slide_row->title;
                      }
                      ?>
                  <span id="wdps_dots_<?php echo $key; ?>_<?php echo $wdps; ?>"
                        class="wdps_slideshow_dots_<?php echo $wdps; ?> <?php echo (($slide_row->id == $current_image_id) ? ' wdps_slideshow_dots_active_' . $wdps : ' wdps_slideshow_dots_deactive_' . $wdps); ?>"
                     <?php echo  $show_thumbnail == 1 ? 'onmouseover="wdps_show_thumb(' . $key . ', ' . $wdps . ')"' : ''; ?>
                        onclick="wdps_change_image_<?php echo $wdps; ?>(parseInt(jQuery('#wdps_current_image_key_<?php echo $wdps; ?>').val()), '<?php echo $key; ?>', wdps_data_<?php echo $wdps; ?>)">
                        <?php echo ($slider_row->bull_butt_img_or_not == 'text') ? '&nbsp;' . $slide_title . '&nbsp;' : ''; ?>     
                  </span>
                      <?php
                    }
                  }             
               
                  ?>
                </div>
              </div>
                <?php
              if ($show_thumbnail == 1) {
                ?>
              <div class="wdps_bulframe_<?php echo $wdps; ?>"></div>
                <?php 
              }
              }
              if ($slider_row->timer_bar_type == 'top' ||  $slider_row->timer_bar_type == 'bottom') { 
                ?>
                <div class="wdps_line_timer_container_<?php echo $wdps; ?>"><div class="wdps_line_timer_<?php echo $wdps; ?>"></div></div>			
                <?php
              }
              elseif ($slider_row->timer_bar_type != 'none') {
                ?>
                <div class="wdps_circle_timer_container_<?php echo $wdps; ?>">
                  <div class="wdps_circle_timer_<?php echo $wdps; ?>">
                    <div class="wdps_circle_timer_parts_<?php echo $wdps; ?>">
                      <div class="wdps_circle_timer_part_<?php echo $wdps; ?>">
                        <div class="wdps_circle_timer_small_parts_<?php echo $wdps; ?> wdps_animated" style="border-radius:100% 0% 0% 0%;" id="wdps_top_left_<?php echo $wdps; ?>"></div>
                        <div class="wdps_circle_timer_small_parts_<?php echo $wdps; ?> wdps_animated" style="border-radius:0% 0% 0% 100%;z-index:150;" id="wdps_bottom_left_<?php echo $wdps; ?>"></div>
                      </div>
                      <div class="wdps_circle_timer_part_<?php echo $wdps; ?>">
                        <div class="wdps_circle_timer_small_parts_<?php echo $wdps; ?> wdps_animated" style="border-radius:0% 100% 0% 0%;" id="wdps_top_right_<?php echo $wdps; ?>"></div>
                        <div class="wdps_circle_timer_small_parts_<?php echo $wdps; ?> wdps_animated" style="border-radius:0% 0% 100% 0%;" id="wdps_bottom_right_<?php echo $wdps; ?>"></div>
                      </div>
                    </div>
                    <div class="wdps_circle_timer_center_cont_<?php echo $wdps; ?>">
                       <div class="wdps_circle_timer_center_<?php echo $wdps; ?>">
                        <div></div>
                       </div> 
                    </div>					
                  </div>
                </div>
                <?php
              }
            ?>			
            <div class="wdps_slide_container_<?php echo $wdps; ?>" id="wdps_slide_container_<?php echo $wdps; ?>">
              <div class="wdps_slide_bg_<?php echo $wdps; ?>">
                <div class="wdps_slider_<?php echo $wdps; ?>">
                <?php 
               foreach ($slide_rows as $key => $slide_row) {
                  if ($slider_row->dynamic == 1) {
                    $slide_row->id = $slide_row->ID;
                    $thumb_id = get_post_thumbnail_id($slide_row->id);
                    $slide_row->thumb_url = wp_get_attachment_url($thumb_id);
                    $slide_row->image_url = wp_get_attachment_url($thumb_id); 
                    if ($slide_row->link == 1) {
                      $slide_row->link = get_permalink($slide_row->id);
                    }
                    else {
                      $slide_row->link = '';
                    }
                    $link = get_permalink($slide_row->id);
                  }
                  else {
                    $link = '';
                  }
                  $is_video = "image";
                  $play_pause_button_display = '';
                  $current_image_url = $slide_row->image_url;
                  $current_image_url = addslashes(htmlspecialchars_decode($current_image_url, ENT_QUOTES));
                  if ($slide_row->id == $current_image_id) {
                    $current_key = $key;
                    $image_div_num = '';
                  }
                  else {
                    $image_div_num = '_second';
                  }
                  ?>
                    <div class="wdps_slideshow_image<?php echo $image_div_num; ?>_spun_<?php echo $wdps; ?>" id="wdps_image_id_<?php echo $wdps; ?>_<?php echo $slide_row->id; ?>">
                    <div class="wdps_slideshow_image_spun1_<?php echo $wdps; ?>">
                      <div class="wdps_slideshow_image_spun2_<?php echo $wdps; ?>">
                        <?php 
                        if ($is_video == 'image') {
                          ?>
                        <div data-img-id="wdps_slideshow_image<?php echo $image_div_num; ?>_<?php echo $wdps; ?>"
                             class="wdps_slideshow_image_<?php echo $wdps; ?> wdps_slideshow_image"
                             onclick="<?php echo $slide_row->link ? 'window.open(\'' . $slide_row->link . '\', \'' . ($slide_row->target_attr_slide ? '_blank' : '_self') . '\')' : ''; ?>"
                             style="<?php echo $slide_row->link ? 'cursor: pointer;' : ''; ?><?php echo ((!$slider_row->preload_images || $image_div_num == '') ? "background-image: url('" . addslashes(htmlspecialchars_decode ($slide_row->image_url,ENT_QUOTES)) . "');" : ""); ?>"
                             data-image-id="<?php echo $slide_row->id; ?>">
                          <?php
                        }
                        $layers_row = $slide_row->layer;
                        if ($layers_row) {						 
                          foreach ($layers_row as $layer_key => $layer) {							
                            if ($layer->published) {
                              $prefix = 'wdps_' . $wdps . '_slide_' . $slide_row->id . '_layer_'. $layer->id;
                              $left_percent = $slider_row->width ? 100 * $layer->left / $slider_row->width : 0;
                              $top_percent = $slider_row->height ? 100 * $layer->top / $slider_row->height : 0;
                              $video_width_percent = $slider_row->width ? 100 * $layer->image_width / $slider_row->width : 0;
                              $video_height_percent = $slider_row->height ? 100 * $layer->image_height / $slider_row->height : 0;
                              $layer_text_alignment = isset($layer->text_alignment) ? $layer->text_alignment : 'left';
                              if ($slider_row->dynamic == 0) {
                                $link = $layer->link;
                              }
                              switch ($layer->type) {
                                case 'text': {
                                  if ($slider_row->dynamic == 1) {
                                    $target_attr_layer = $slide_row->target_attr_slide;
                                  }
                                  else {
                                    $target_attr_layer = $layer->target_attr_layer;
                                  }
                                  ?>
                                  <span class="wdps_layer_<?php echo $layer->id; ?>" id="<?php echo $prefix; ?>" data-type="wdps_text_parent" data-row-key="<?php echo $key;?>" data-layer-key="<?php echo $layer_key;?>" data-id="<?php echo $prefix; ?>" data-wdps-fsize="<?php echo $layer->size; ?>" data-wdps-fmin-size="<?php echo $layer->min_size; ?>"
                                      style="<?php echo $layer->image_width ? 'width: ' . $layer->image_width . '%; ' : ''; ?>
                                             <?php echo $layer->image_height ? 'height: ' . $layer->image_height . '%; ' : ''; ?>
                                             word-break: <?php echo ($layer->image_scale ? 'normal' : 'break-all'); ?>;
                                             text-align: initial; <?php echo ($layer->link || $link )? 'cursor: pointer; ' : ''; ?>
                                             opacity: 1; 
                                             filter: 'Alpha(opacity=100)';
                                             display: inline-block;
                                             position: absolute;
                                             left: <?php echo $left_percent; ?>%;
                                             top: <?php echo $top_percent; ?>%;
                                             z-index: <?php echo $layer->depth; ?>;
                                             color: #<?php echo $layer->color; ?>;
                                             font-family: <?php echo $layer->ffamily; ?>;
                                             font-weight: <?php echo $layer->fweight; ?>;
                                             background-color: <?php echo WDW_PS_Library::spider_hex2rgba($layer->fbgcolor, (100 - $layer->transparent) / 100); ?>;
                                             border: <?php echo $layer->border_width; ?>px <?php echo $layer->border_style; ?> #<?php echo $layer->border_color; ?>;
                                             border-radius: <?php echo $layer->border_radius; ?>;
                                             box-shadow: <?php echo $layer->shadow; ?>;
                                             text-align: <?php echo $layer_text_alignment; ?>;"
                                      onclick="<?php echo $link ? 'window.open(\'' . $link . '\', \'' . ($target_attr_layer ? '_blank' : '_self') . '\');' : ''; ?>event.stopPropagation();"><?php echo str_replace(array("\r\n", "\r", "\n"), "<br>", trim($from_shortcode ? do_shortcode($layer->text) : $layer->text)); ?>
                                  </span>
                                        <?php                                           
                                  break;
                                }
                                case 'image': {
                                  ?>
                                  <img class="wdps_layer_<?php echo $layer->id; ?>" id="<?php echo $prefix; ?>" src="<?php echo $layer->image_url; ?>"
                                     style="<?php echo $layer->link ? 'cursor: pointer; ' : ''; ?>
                                            opacity: <?php echo number_format((100 - $layer->imgtransparent) / 100, 2, ".", ""); ?>;
                                            filter: Alpha(opacity=<?php echo 100 - $layer->imgtransparent; ?>);
                                            position: absolute;
                                            left: <?php echo $left_percent; ?>%;
                                            top: <?php echo $top_percent; ?>%;
                                            z-index: <?php echo $layer->depth; ?>;
                                            border: <?php echo $layer->border_width; ?>px <?php echo $layer->border_style; ?> #<?php echo $layer->border_color; ?>;
                                            border-radius: <?php echo $layer->border_radius; ?>;
                                            box-shadow: <?php echo $layer->shadow; ?>"
                                     onclick="<?php echo $layer->link ? 'window.open(\'' . $layer->link . '\', \'' . ($layer->target_attr_layer ? '_blank' : '_self') . '\');' : ''; ?>event.stopPropagation();"
                                     data-wdps-scale="<?php echo $layer->image_scale; ?>"
                                     data-wdps-image-width="<?php echo $layer->image_width; ?>"
                                     data-wdps-image-height="<?php echo $layer->image_height; ?>"
                                     alt="<?php echo $layer->alt; ?>" 
                                     title="<?php echo $layer->alt; ?>" />
                                  <?php
                                  break;
                                }
                                default:
                                  break;
                              }
                            }
                          }
                        }
                        ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php
               }
                ?>
               <input type="hidden" id="wdps_current_image_key_<?php echo $wdps; ?>" value="<?php echo $current_key; ?>" />
                </div>
              </div>
            </div>
            <?php
              if ($enable_prev_next_butt && $slides_count > 1) {
                ?>
              <div class="wdps_btn_cont wdps_contTableCell">
                <div class="wdps_btn_cont wdps_contTable">
                  <span class="wdps_btn_cont wdps_contTableCell" style="position: relative; text-align: left;">
                    <span class="wdps_left_btn_cont">
                      <span class="wdps_left-ico_<?php echo $wdps; ?>" onclick="wdps_change_image_<?php echo $wdps; ?>(parseInt(jQuery('#wdps_current_image_key_<?php echo $wdps; ?>').val()), (parseInt(jQuery('#wdps_current_image_key_<?php echo $wdps; ?>').val()) - wdps_iterator_<?php echo $wdps; ?>()) >= 0 ? (parseInt(jQuery('#wdps_current_image_key_<?php echo $wdps; ?>').val()) - wdps_iterator_<?php echo $wdps; ?>()) % wdps_data_<?php echo $wdps; ?>.length : wdps_data_<?php echo $wdps; ?>.length - 1, wdps_data_<?php echo $wdps; ?>, false, 'left'); return false;">
                        <?php
                        if ($slider_row->rl_butt_img_or_not == 'style') {
                          ?>
                          <i class="fa <?php echo $slider_row->rl_butt_style; ?>-left"></i>
                          <?php
                        }
                        ?>
                      </span>
                    </span>
                   </span>
                </div>
              </div>
              <div class="wdps_btn_cont wdps_contTableCell">
                <div class="wdps_btn_cont wdps_contTable">
                  <span class="wdps_btn_cont wdps_contTableCell" style="position: relative; text-align: right;">
                    <span class="wdps_right_btn_cont">
                      <span class="wdps_right-ico_<?php echo $wdps; ?>" onclick="wdps_change_image_<?php echo $wdps; ?>(parseInt(jQuery('#wdps_current_image_key_<?php echo $wdps; ?>').val()), (parseInt(jQuery('#wdps_current_image_key_<?php echo $wdps; ?>').val()) + wdps_iterator_<?php echo $wdps; ?>()) % wdps_data_<?php echo $wdps; ?>.length, wdps_data_<?php echo $wdps; ?>, false, 'right'); return false;">
                        <?php
                        if ($slider_row->rl_butt_img_or_not == 'style') {
                          ?>
                          <i class="fa <?php echo $slider_row->rl_butt_style; ?>-right"></i>
                          <?php
                        }
                        ?>
                      </span>
                    </span>
                  </span>
                </div>
              </div>
              <?php
              }
              if ($enable_play_paus_butt && $slides_count > 1) {
                ?>
              <div class="wdps_btn_cont wdps_contTableCell">
                <div class="wdps_btn_cont wdps_contTable">
                  <span class="wdps_btn_cont wdps_contTableCell" style="position: relative; text-align: center;">
                    <span class="wdps_pp_btn_cont">
                      <span id="wdps_post_slideshow_play_pause_<?php echo $wdps; ?>" style="display: <?php echo $play_pause_button_display; ?>;" <?php echo ($slider_row->play_paus_butt_img_or_not != 'style') ? 'class="wdps_post_ctrl_btn_' . $wdps . ' wdps_post_slideshow_play_pause_' . $wdps . ' fa fa-play"' : ''; ?>>
                        <?php
                        if ($slider_row->play_paus_butt_img_or_not == 'style') {
                          ?>
                        <i class="wdps_post_ctrl_btn_<?php echo $wdps; ?> wdps_post_slideshow_play_pause_<?php echo $wdps; ?> fa fa-play"></i>
                          <?php
                        }
                        ?>
                      </span>
                    </span>
                  </span>
                </div>
              </div>
              <?php
              }
            ?>
          </div>
          <?php
          if ($enable_slideshow_music && !empty($slideshow_music_url)) {
            ?>
            <audio id="wdps_audio_<?php echo $wdps; ?>" src="<?php echo $slideshow_music_url; ?>" loop></audio>
            <?php 
          }
          ?>
        </div>
      </div>
    </div>
    <script>
      var wdps_global_btn_<?php echo $wdps; ?> = "right";
      var wdps_trans_in_progress_<?php echo $wdps; ?> = false;
      var wdps_transition_duration_<?php echo $wdps; ?> = <?php echo $slider_row->effect_duration; ?>;
      if (<?php echo $slideshow_interval; ?> < 4) {
        if (<?php echo $slideshow_interval; ?> != 0) {
          wdps_transition_duration_<?php echo $wdps; ?> = (<?php echo $slideshow_interval; ?> * 1000) / 4;
        }
      }
      var wdps_playInterval_<?php echo $wdps; ?>;
      var progress = 0;
      var bottom_right_deggree_<?php echo $wdps; ?>;
      var bottom_left_deggree_<?php echo $wdps; ?>;
      var top_left_deggree_<?php echo $wdps; ?>;
      var wdps_curent_time_deggree_<?php echo $wdps; ?> = 0;
      var wdps_circle_timer_animate_<?php echo $wdps; ?>;
      function post_circle_timer_<?php echo $wdps; ?>(angle) {
        wdps_circle_timer_animate_<?php echo $wdps; ?> = jQuery({deg: angle}).animate({deg: 360}, {
          duration: <?php echo $slideshow_interval * 1000; ?>,
          step: function(now) {
            wdps_curent_time_deggree_<?php echo $wdps; ?> = now;
            if (now >= 0) {
              if (now < 271) {
                jQuery('#wdps_top_right_<?php echo $wdps; ?>').css({
                  '-moz-transform':'rotate('+now+'deg)',
                  '-webkit-transform':'rotate('+now+'deg)',
                  '-o-transform':'rotate('+now+'deg)',
                  '-ms-transform':'rotate('+now+'deg)',
                  'transform':'rotate('+now+'deg)',
                  '-webkit-transform-origin': 'left bottom',
                  '-ms-transform-origin': 'left bottom',
                  '-moz-transform-origin': 'left bottom',
                  'transform-origin': 'left bottom'
                });
              }
            }
            if (now >= 90) {
              if (now < 271) {
                bottom_right_deggree_<?php echo $wdps; ?> = now - 90;
                jQuery('#wdps_bottom_right_<?php echo $wdps; ?>').css({
                  '-moz-transform':'rotate('+bottom_right_deggree_<?php echo $wdps; ?> +'deg)',
                '-webkit-transform':'rotate('+bottom_right_deggree_<?php echo $wdps; ?> +'deg)',
                '-o-transform':'rotate('+bottom_right_deggree_<?php echo $wdps; ?> +'deg)',
                '-ms-transform':'rotate('+bottom_right_deggree_<?php echo $wdps; ?> +'deg)',
                'transform':'rotate('+bottom_right_deggree_<?php echo $wdps; ?> +'deg)',
                '-webkit-transform-origin': 'left top',
                '-ms-transform-origin': 'left top',
                '-moz-transform-origin': 'left top',
                'transform-origin': 'left top'
                });
              }
            }
            if (now >= 180) {
              if (now < 361) {
                bottom_left_deggree_<?php echo $wdps; ?> = now - 180;
                jQuery('#wdps_bottom_left_<?php echo $wdps; ?>').css({
                  '-moz-transform':'rotate('+bottom_left_deggree_<?php echo $wdps; ?> +'deg)',
                  '-webkit-transform':'rotate('+bottom_left_deggree_<?php echo $wdps; ?> +'deg)',
                  '-o-transform':'rotate('+bottom_left_deggree_<?php echo $wdps; ?> +'deg)',
                  '-ms-transform':'rotate('+bottom_left_deggree_<?php echo $wdps; ?> +'deg)',
                  'transform':'rotate('+bottom_left_deggree_<?php echo $wdps; ?> +'deg)',
                  '-webkit-transform-origin': 'right top',
                  '-ms-transform-origin': 'right top',
                  '-moz-transform-origin': 'right top',
                  'transform-origin': 'right top'
                });
              }
            }
            if (now >= 270) {
              if (now < 361) {
                top_left_deggree_<?php echo $wdps; ?>  = now - 270;
                jQuery('#wdps_top_left_<?php echo $wdps; ?>').css({
                  '-moz-transform':'rotate('+top_left_deggree_<?php echo $wdps; ?> +'deg)',
                  '-webkit-transform':'rotate('+top_left_deggree_<?php echo $wdps; ?> +'deg)',
                  '-o-transform':'rotate('+top_left_deggree_<?php echo $wdps; ?> +'deg)',
                  '-ms-transform':'rotate('+top_left_deggree_<?php echo $wdps; ?> +'deg)',
                  'transform':'rotate('+top_left_deggree_<?php echo $wdps; ?> +'deg)',
                  '-webkit-transform-origin': 'right bottom',
                  '-ms-transform-origin': 'right bottom',
                  '-moz-transform-origin': 'right bottom',
                  'transform-origin': 'right bottom'
                });
              }
            }
          }
        });
      }
      /* Stop autoplay.*/
      window.clearInterval(wdps_playInterval_<?php echo $wdps; ?>);
      var wdps_current_key_<?php echo $wdps; ?> = '<?php echo (isset($current_key) ? $current_key : ''); ?>';      
      function wdps_move_dots_<?php echo $wdps; ?>() {
        var image_left = jQuery(".wdps_slideshow_dots_active_<?php echo $wdps; ?>").position().left;
        var image_right = jQuery(".wdps_slideshow_dots_active_<?php echo $wdps; ?>").position().left + jQuery(".wdps_slideshow_dots_active_<?php echo $wdps; ?>").outerWidth(true);
        var wdps_dots_width = jQuery(".wdps_slideshow_dots_container_<?php echo $wdps; ?>").outerWidth(true);
        var wdps_dots_thumbnails_width = jQuery(".wdps_slideshow_dots_thumbnails_<?php echo $wdps; ?>").outerWidth(true);
        var long_filmstrip_cont_left = jQuery(".wdps_slideshow_dots_thumbnails_<?php echo $wdps; ?>").position().left;
        var long_filmstrip_cont_right = Math.abs(jQuery(".wdps_slideshow_dots_thumbnails_<?php echo $wdps; ?>").position().left) + wdps_dots_width;
        if (wdps_dots_width > wdps_dots_thumbnails_width + 100) {
          return;
        }
        if (image_left < Math.abs(long_filmstrip_cont_left)) {
          jQuery(".wdps_slideshow_dots_thumbnails_<?php echo $wdps; ?>").animate({
            left: -image_left
          }, {
            duration: 500
          });
        }
        else if (image_right > long_filmstrip_cont_right) {
          jQuery(".wdps_slideshow_dots_thumbnails_<?php echo $wdps; ?>").animate({
            left: -(image_right - wdps_dots_width)
          }, {
            duration: 500
          });
        }
      }
      function wdps_testBrowser_cssTransitions_<?php echo $wdps; ?>() {
        return wdps_testDom_<?php echo $wdps; ?>('Transition');
      }
      function wdps_testBrowser_cssTransforms3d_<?php echo $wdps; ?>() {
        return wdps_testDom_<?php echo $wdps; ?>('Perspective');
      }
      function wdps_testDom_<?php echo $wdps; ?>(prop) {
        /* Browser vendor CSS prefixes.*/
        var browserVendors = ['', '-webkit-', '-moz-', '-ms-', '-o-', '-khtml-'];
        /* Browser vendor DOM prefixes.*/
        var domPrefixes = ['', 'Webkit', 'Moz', 'ms', 'O', 'Khtml'];
        var i = domPrefixes.length;
        while (i--) {
          if (typeof document.body.style[domPrefixes[i] + prop] !== 'undefined') {
            return true;
          }
        }
        return false;
      }
      function wdps_set_dots_class_<?php echo $wdps; ?>() {
        jQuery(".wdps_slideshow_dots_<?php echo $wdps; ?>").removeClass("wdps_slideshow_dots_active_<?php echo $wdps; ?>").addClass("wdps_slideshow_dots_deactive_<?php echo $wdps; ?>");
        jQuery("#wdps_dots_" + wdps_current_key_<?php echo $wdps; ?> + "_<?php echo $wdps; ?>").removeClass("wdps_slideshow_dots_deactive_<?php echo $wdps; ?>").addClass("wdps_slideshow_dots_active_<?php echo $wdps; ?>");
        <?php if ($slider_row->bull_butt_img_or_not == 'style') { ?>
        jQuery(".wdps_slideshow_dots_<?php echo $wdps; ?>").removeClass("<?php echo $bull_style_active; ?>").addClass("<?php echo $bull_style_deactive; ?>");
        jQuery("#wdps_dots_" + wdps_current_key_<?php echo $wdps; ?> + "_<?php echo $wdps; ?>").removeClass("<?php echo $bull_style_deactive; ?>").addClass("<?php echo $bull_style_active; ?>");
        <?php } ?>
      }
      function wdps_grid_<?php echo $wdps; ?>(cols, rows, ro, tx, ty, sc, op, current_image_class, next_image_class, direction, random, roy, easing) {
        /* If browser does not support CSS transitions.*/
        if (!wdps_testBrowser_cssTransitions_<?php echo $wdps; ?>()) {
          return wdps_fallback_<?php echo $wdps; ?>(current_image_class, next_image_class, direction);
        }
        wdps_trans_in_progress_<?php echo $wdps; ?> = true;
        /* Set active thumbnail.*/
        wdps_set_dots_class_<?php echo $wdps; ?>();
        /* The time (in ms) added to/subtracted from the delay total for each new gridlet.*/
        var count = (wdps_transition_duration_<?php echo $wdps; ?>) / (cols + rows);
        /* Gridlet creator (divisions of the image grid, positioned with background-images to replicate the look of an entire slide image when assembled)*/
        function wdps_gridlet(width, height, top, img_top, left, img_left, src, imgWidth, imgHeight, c, r) {
          var delay = random ? Math.floor((cols + rows) * count * Math.random()) : (c + r) * count;
          /* Return a gridlet elem with styles for specific transition.*/
          var grid_div = jQuery('<span class="wdps_gridlet_<?php echo $wdps; ?>" />').css({
            display: "block",
            width : imgWidth,/*"100%"*/
            height : jQuery(".wdps_slideshow_image_spun_<?php echo $wdps; ?>").height() + "px",
            top : -top,
            left : -left,
            backgroundImage : src,
            backgroundSize: jQuery(".wdps_slideshow_image_<?php echo $wdps; ?>").css("background-size"),
            backgroundPosition: jQuery(".wdps_slideshow_image_<?php echo $wdps; ?>").css("background-position"),
            /*backgroundColor: jQuery(".wdps_slideshow_image_wrap_<?php echo $wdps; ?>").css("background-color"),*/
            backgroundRepeat: 'no-repeat'
          });
          return jQuery('<span class="wdps_gridlet_<?php echo $wdps; ?>" />').css({
            display: "block",
            width : width,/*"100%"*/
            height : height,
            top : top,
            left : left,
            backgroundSize : imgWidth + 'px ' + imgHeight + 'px',
            backgroundPosition : img_left + 'px ' + img_top + 'px',
            backgroundRepeat: 'no-repeat',
            overflow: "hidden",
            transition : 'all ' + wdps_transition_duration_<?php echo $wdps; ?> + 'ms ' + easing + ' ' + delay + 'ms',
            transform : 'none'
          }).append(grid_div);
        }
        /* Get the current slide's image.*/
        var cur_img = jQuery(current_image_class + " .wdps_slideshow_image");
        /* Create a grid to hold the gridlets.*/
        var grid = jQuery('<span style="display: block;" />').addClass('wdps_grid_<?php echo $wdps; ?>');
        /* Prepend the grid to the next slide (i.e. so it's above the slide image).*/
        jQuery(current_image_class).prepend(grid);
        /* vars to calculate positioning/size of gridlets*/
        var cont = jQuery(".wdps_slide_bg_<?php echo $wdps; ?>");
        var imgWidth = cur_img.width();
        var imgHeight = cur_img.height();
        var contWidth = cont.width(),
            contHeight = cont.height(),
            imgSrc = cur_img.css('background-image'),/*.replace('/thumb', ''),*/
            colWidth = Math.floor(contWidth / cols),
            rowHeight = Math.floor(contHeight / rows),
            colRemainder = contWidth - (cols * colWidth),
            colAdd = Math.ceil(colRemainder / cols),
            rowRemainder = contHeight - (rows * rowHeight),
            rowAdd = Math.ceil(rowRemainder / rows),
            leftDist = 0,
            img_leftDist = (jQuery(".wdps_slide_bg_<?php echo $wdps; ?>").width() - cur_img.width()) / 2;
        /* tx/ty args can be passed as 'auto'/'min-auto' (meaning use slide width/height or negative slide width/height).*/
        tx = tx === 'auto' ? contWidth : tx;
        tx = tx === 'min-auto' ? - contWidth : tx;
        ty = ty === 'auto' ? contHeight : ty;
        ty = ty === 'min-auto' ? - contHeight : ty;
        /* Loop through cols*/
        for (var i = 0; i < cols; i++) {
          var topDist = 0,
              img_topDst = (jQuery(".wdps_slide_bg_<?php echo $wdps; ?>").height() - cur_img.height()) / 2,
              newColWidth = colWidth;
          /* If imgWidth (px) does not divide cleanly into the specified number of cols, adjust individual col widths to create correct total.*/
          if (colRemainder > 0) {
            var add = colRemainder >= colAdd ? colAdd : colRemainder;
            newColWidth += add;
            colRemainder -= add;
          }
          /* Nested loop to create row gridlets for each col.*/
          for (var j = 0; j < rows; j++)  {
            var newRowHeight = rowHeight,
                newRowRemainder = rowRemainder;
            /* If contHeight (px) does not divide cleanly into the specified number of rows, adjust individual row heights to create correct total.*/
            if (newRowRemainder > 0) {
              add = newRowRemainder >= rowAdd ? rowAdd : rowRemainder;
              newRowHeight += add;
              newRowRemainder -= add;
            }
            /* Create & append gridlet to grid.*/
            grid.append(wdps_gridlet(newColWidth, newRowHeight, topDist, img_topDst, leftDist, img_leftDist, imgSrc, imgWidth, imgHeight, i, j));
            topDist += newRowHeight;
            img_topDst -= newRowHeight;
          }
          img_leftDist -= newColWidth;
          leftDist += newColWidth;
        }
        /* Show grid & hide the image it replaces.*/
        grid.show();
        cur_img.css('opacity', 0);
        /* Add identifying classes to corner gridlets (useful if applying border radius).*/
        grid.children().first().addClass('rs-top-left');
        grid.children().last().addClass('rs-bottom-right');
        grid.children().eq(rows - 1).addClass('rs-bottom-left');
        grid.children().eq(- rows).addClass('rs-top-right');
        /* Execution steps.*/
        setTimeout(function () {
          grid.children().css({
            opacity: op,
            transform: 'rotate('+ ro +'deg) rotateY('+ roy +'deg) translateX('+ tx +'px) translateY('+ ty +'px) scale('+ sc +')'
          });
        }, 1);
        jQuery(next_image_class).css('opacity', 1);
        /* After transition.*/
        var cccount = 0;
        var obshicccount = cols * rows;
        grid.children().one('webkitTransitionEnd transitionend otransitionend oTransitionEnd mstransitionend', jQuery.proxy(wdps_after_trans_each));
        function wdps_after_trans_each() {
         if (++cccount == obshicccount) {
           wdps_after_trans();
         }
        }
        function wdps_after_trans() {
          jQuery(current_image_class).css({'opacity' : 0, 'z-index': 1});
          jQuery(".wdps_slider_car_image<?php echo $wdps; ?>").css({'opacity' : 0, 'z-index': 1});
          jQuery(next_image_class).css({'opacity' : 1, 'z-index' : 2});
          cur_img.css('opacity', 1);
          grid.remove();
          wdps_trans_in_progress_<?php echo $wdps; ?> = false;
          if (typeof wdps_event_stack_<?php echo $wdps; ?> !== 'undefined') {
            if (wdps_event_stack_<?php echo $wdps; ?>.length > 0) {
              key = wdps_event_stack_<?php echo $wdps; ?>[0].split("-");
              wdps_event_stack_<?php echo $wdps; ?>.shift();
              wdps_change_image_<?php echo $wdps; ?>(key[0], key[1], wdps_data_<?php echo $wdps; ?>, true);
            }
          }
        }
      }

      function wdps_none_<?php echo $wdps; ?>(current_image_class, next_image_class, direction) {
        jQuery(current_image_class).css({'opacity' : 0, 'z-index': 1});
        jQuery(next_image_class).css({'opacity' : 1, 'z-index' : 2});
        /* Set active thumbnail.*/
        wdps_set_dots_class_<?php echo $wdps; ?>();
      }

      function wdps_fade_<?php echo $wdps; ?>(current_image_class, next_image_class, direction) {
        /* Set active thumbnail.*/
        wdps_set_dots_class_<?php echo $wdps; ?>();
        if (wdps_testBrowser_cssTransitions_<?php echo $wdps; ?>()) {
          jQuery(next_image_class).css('transition', 'opacity ' + wdps_transition_duration_<?php echo $wdps; ?> + 'ms linear');
          jQuery(current_image_class).css({'opacity' : 0, 'z-index': 1});
          jQuery(next_image_class).css({'opacity' : 1, 'z-index' : 2});
        }
        else {
          jQuery(current_image_class).animate({'opacity' : 0, 'z-index' : 1}, wdps_transition_duration_<?php echo $wdps; ?>);
          jQuery(next_image_class).animate({
              'opacity' : 1,
              'z-index': 2
            }, {
              duration: wdps_transition_duration_<?php echo $wdps; ?>,
              complete: function () {  }
            });
          /* For IE.*/
          jQuery(current_image_class).fadeTo(wdps_transition_duration_<?php echo $wdps; ?>, 0);
          jQuery(next_image_class).fadeTo(wdps_transition_duration_<?php echo $wdps; ?>, 1);
        }
      } 
      function wdps_sliceH_<?php echo $wdps; ?>(current_image_class, next_image_class, direction) {
        if (direction == 'right') {
          var translateX = 'min-auto';
        }
        else if (direction == 'left') {
          var translateX = 'auto';
        }
        wdps_grid_<?php echo $wdps; ?>(1, 8, 0, translateX, 0, 1, 0, current_image_class, next_image_class, direction, 0, 0, 'ease-in-out');
      }
     function wdps_fan_<?php echo $wdps; ?>(current_image_class, next_image_class, direction) {
        if (direction == 'right') {
          var rotate = 45;
          var translateX = 100;
        }
        else if (direction == 'left') {
          var rotate = -45;
          var translateX = -100;
        }
        wdps_grid_<?php echo $wdps; ?>(1, 10, rotate, translateX, 0, 1, 0, current_image_class, next_image_class, direction, 0, 0, 'ease-in-out');
      }
      function wdps_scaleIn_<?php echo $wdps; ?>(current_image_class, next_image_class, direction) {
        wdps_grid_<?php echo $wdps; ?>(1, 1, 0, 0, 0, 0.5, 0, current_image_class, next_image_class, direction, 0, 0, 'ease-in-out');
      }
      function wdps_iterator_<?php echo $wdps; ?>() {
        var iterator = 1;
        if (<?php echo $enable_slideshow_shuffle; ?>) {
          iterator = Math.floor((wdps_data_<?php echo $wdps; ?>.length - 1) * Math.random() + 1);
        }
        else if (<?php echo $twoway_slideshow; ?>) {
          if (jQuery(".wdps_post_slideshow_play_pause_<?php echo $wdps; ?>").attr('title') == 'Pause' || jQuery(".wdps_post_slideshow_play_pause_<?php echo $wdps; ?>").attr('title') == undefined) {
            if (wdps_global_btn_<?php echo $wdps; ?> == "left") {
              iterator = -1;
            }
          }
          if ('<?php echo $slider_loop; ?>' == 0) {
            if (parseInt(jQuery('#wdps_current_image_key_<?php echo $wdps; ?>').val()) == 0) {
              iterator = 1;
            }
          }
        }
        return iterator;
      }
      function wdps_change_image_<?php echo $wdps; ?>(current_key, key, wdps_data_<?php echo $wdps; ?>, from_effect, btn) {
        if (typeof btn == "undefined") {
          var btn = "";
        }
        if (wdps_data_<?php echo $wdps; ?>[key]["is_video"] == 'image') {
          jQuery('<img />').attr("src", wdps_data_<?php echo $wdps; ?>[key]["image_url"])
          .load(function() {
            jQuery(this).remove();
            wdps_change_image_when_loaded_<?php echo $wdps; ?>(current_key, key, wdps_data_<?php echo $wdps; ?>, from_effect, btn);
          })
          .error(function() {
            jQuery(this).remove();
            wdps_change_image_when_loaded_<?php echo $wdps; ?>(current_key, key, wdps_data_<?php echo $wdps; ?>, from_effect, btn);
          });
        }
        else {
          wdps_change_image_when_loaded_<?php echo $wdps; ?>(current_key, key, wdps_data_<?php echo $wdps; ?>, from_effect, btn);
        }
      }
      function wdps_change_image_when_loaded_<?php echo $wdps; ?>(current_key, key, wdps_data_<?php echo $wdps; ?>, from_effect, btn) {
        <?php
        if ($slider_row->effect == 'zoomFade') {
          ?>
          wdps_genBgPos_<?php echo $wdps; ?>();
          <?php
        }
        ?>
        /* Pause videos.*/
        jQuery("#wdps_slideshow_image_container_<?php echo $wdps; ?>").find("iframe").each(function () {
          if (typeof jQuery(this)[0].contentWindow != "undefined") {
            jQuery(this)[0].contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
            jQuery(this)[0].contentWindow.postMessage('{ "method": "pause" }', "*");
            jQuery(this)[0].contentWindow.postMessage('pause', '*');
          }
        });
        /* Pause layer videos.*/
        jQuery(".wdps_video_layer_frame_<?php echo $wdps; ?>").each(function () {
          if (typeof jQuery(this)[0].contentWindow != "undefined") {
            jQuery(this)[0].contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
            jQuery(this)[0].contentWindow.postMessage('{ "method": "pause" }', "*");
            jQuery(this)[0].contentWindow.postMessage('pause', '*');
          }
        });
        if (wdps_data_<?php echo $wdps; ?>[key]) {
          if (jQuery('.wdps_post_ctrl_btn_<?php echo $wdps; ?>').hasClass('fa-pause') || ('<?php echo $autoplay; ?>')) {
           wdps_play_<?php echo $wdps; ?>();
          }
          if (!from_effect) {
            /* Change image key.*/
            jQuery("#wdps_current_image_key_<?php echo $wdps; ?>").val(key);
            if (current_key == '-1') { /* Filmstrip.*/
              current_key = jQuery(".wdps_slideshow_thumb_active_<?php echo $wdps; ?>").children("img").attr("image_key");
            }
            else if (current_key == '-2') { /* Dots.*/
              current_key = jQuery(".wdps_slideshow_dots_active_<?php echo $wdps; ?>").attr("image_key");
            }
          }
          if (wdps_trans_in_progress_<?php echo $wdps; ?>) {
            wdps_event_stack_<?php echo $wdps; ?>.push(current_key + '-' + key);
            return;
          }
          if (btn == "") {
            var direction = 'right';
            var int_curr_key = parseInt(wdps_current_key_<?php echo $wdps; ?>);
            var int_key = parseInt(key);
            var last_pos = wdps_data_<?php echo $wdps; ?>.length - 1;
            if (int_curr_key > int_key) {
              direction = 'left';
            }
            else if (int_curr_key == int_key) {
              return;
            }
            /* From last slide to first.*/
            if (int_key == 0) {
              if (int_curr_key == last_pos) {
                direction = 'right';
              }
            }
            /* From first slide to last if there are more than two slides in the slider.*/
            if (int_key == last_pos) {
              if (int_curr_key == 0) {
                if (last_pos > 1) {
                  direction = 'left';
                }
              }
            }
          }
          else {
            direction = btn;
          }
          if (<?php echo $enable_slideshow_autoplay; ?>) {
            if (jQuery(".wdps_post_slideshow_play_pause_<?php echo $wdps; ?>").attr('title') == 'Pause' || jQuery(".wdps_post_slideshow_play_pause_<?php echo $wdps; ?>").attr('title') == undefined) {
              if (<?php echo $twoway_slideshow; ?>) {
                wdps_global_btn_<?php echo $wdps; ?> = direction;
              }
            }
          }
          /* Set active thumbnail position.*/
          wdps_current_key_<?php echo $wdps; ?> = key;
          /* Change image id.*/
          jQuery("div[data-img-id=wdps_slideshow_image_<?php echo $wdps; ?>]").attr('data-image-id', wdps_data_<?php echo $wdps; ?>[key]["id"]);
          var current_image_class = "#wdps_image_id_<?php echo $wdps; ?>_" + wdps_data_<?php echo $wdps; ?>[current_key]["id"];
          var next_image_class = "#wdps_image_id_<?php echo $wdps; ?>_" + wdps_data_<?php echo $wdps; ?>[key]["id"];
           <?php if ($slider_row->preload_images) { ?>
          if (wdps_data_<?php echo $wdps; ?>[key]["is_video"] == 'image') {
            jQuery(next_image_class).find(".wdps_slideshow_image_<?php echo $wdps; ?>").css("background-image", 'url("' + wdps_data_<?php echo $wdps; ?>[key]["image_url"] + '")');
          }
          <?php } ?>
          var current_slide_layers_count = wdps_data_<?php echo $wdps; ?>[current_key]["slide_layers_count"];
          var next_slide_layers_count = wdps_data_<?php echo $wdps; ?>[key]["slide_layers_count"];

          /* Clear layers before image change.*/
          function set_layer_effect_out_before_change(m) {
            wdps_clear_layers_effects_out_before_change_<?php echo $wdps; ?>[current_key][m] = setTimeout(function() {
              if (wdps_data_<?php echo $wdps; ?>[current_key]["layer_" + m + "_type"] != 'social') {
                jQuery('#wdps_<?php echo $wdps; ?>_slide' + wdps_data_<?php echo $wdps; ?>[current_key]["id"] + '_layer' + wdps_data_<?php echo $wdps; ?>[current_key]["layer_" + m + "_id"]).css('-webkit-animation-duration' , 0.6 + 's').css('animation-duration' , 0.6 + 's');
                jQuery('#wdps_<?php echo $wdps; ?>_slide' + wdps_data_<?php echo $wdps; ?>[current_key]["id"] + '_layer' + wdps_data_<?php echo $wdps; ?>[current_key]["layer_" + m + "_id"]).removeClass().addClass( wdps_data_<?php echo $wdps; ?>[current_key]["layer_" + m + "_layer_effect_out"] + ' wdps_animated');
              }
              else {
                jQuery('#wdps_<?php echo $wdps; ?>_slide' + wdps_data_<?php echo $wdps; ?>[current_key]["id"] + '_layer' + wdps_data_<?php echo $wdps; ?>[current_key]["layer_" + m + "_id"]).css('-webkit-animation-duration' , 0.6 + 's').css('animation-duration' , 0.6 + 's');
                jQuery('#wdps_<?php echo $wdps; ?>_slide' + wdps_data_<?php echo $wdps; ?>[current_key]["id"] + '_layer' + wdps_data_<?php echo $wdps; ?>[current_key]["layer_" + m + "_id"]).removeClass().addClass( wdps_data_<?php echo $wdps; ?>[current_key]["layer_" + m + "_layer_effect_out"] + ' fa fa-' + wdps_data_<?php echo $wdps; ?>[current_key]["layer_" + m + "_social_button"] + ' wdps_animated');
              }
            }, 10);
          }
          if (<?php echo $slider_row->layer_out_next; ?>) {
            for (var m = 0; m < current_slide_layers_count; m++) {
              if (jQuery('#wdps_<?php echo $wdps; ?>_slide' + wdps_data_<?php echo $wdps; ?>[current_key]["id"] + '_layer' + wdps_data_<?php echo $wdps; ?>[current_key]["layer_" + m + "_id"]).css('opacity') != 0) {
                set_layer_effect_out_before_change(m);
              }
            }
          }
          /* Loop through current slide layers for clear effects.*/
          setTimeout(function() {
            for (var k = 0; k < current_slide_layers_count; k++) {
              clearTimeout(wdps_clear_layers_effects_in_<?php echo $wdps; ?>[current_key][k]);
              clearTimeout(wdps_clear_layers_effects_out_<?php echo $wdps; ?>[current_key][k]);
              if (wdps_data_<?php echo $wdps; ?>[current_key]["layer_" + k + "_type"] != 'social') {
                jQuery('#wdps_<?php echo $wdps; ?>_slide' + wdps_data_<?php echo $wdps; ?>[current_key]["id"] + '_layer' + wdps_data_<?php echo $wdps; ?>[current_key]["layer_" + k + "_id"]).removeClass().addClass('wdps_layer_'+ wdps_data_<?php echo $wdps; ?>[current_key]["layer_" + k + "_id"]);
              }
              else {
                jQuery('#wdps_<?php echo $wdps; ?>_slide' + wdps_data_<?php echo $wdps; ?>[current_key]["id"] + '_layer' + wdps_data_<?php echo $wdps; ?>[current_key]["layer_" + k + "_id"]).removeClass().addClass('fa fa-' + wdps_data_<?php echo $wdps; ?>[current_key]["layer_" + k + "_social_button"] + ' wdps_layer_' + wdps_data_<?php echo $wdps; ?>[current_key]["layer_" + k + "_id"]);
              }
            }
          }, wdps_duration_for_clear_effects_<?php echo $wdps; ?>);
          /* Loop through layers in.*/
          for (var j = 0; j < next_slide_layers_count; j++) {
            wdps_set_layer_effect_in_<?php echo $wdps; ?>(j, key);
          }
          /* Loop through layers out if pause button not pressed.*/
          for (var i = 0; i < next_slide_layers_count; i++) {
            wdps_set_layer_effect_out_<?php echo $wdps; ?>(i, key);
          }
          setTimeout(function() {
            if (typeof jQuery().finish !== 'undefined') {
              if (jQuery.isFunction(jQuery().finish)) {
                jQuery(".wdps_line_timer_<?php echo $wdps; ?>").finish();
              }
            }
            jQuery(".wdps_line_timer_<?php echo $wdps; ?>").css({width: 0});
            wdps_<?php echo $slideshow_effect; ?>_<?php echo $wdps; ?>(current_image_class, next_image_class, direction);
            if ('<?php echo $slider_row->timer_bar_type; ?>' != 'none') {
              if (<?php echo $enable_slideshow_autoplay; ?> || jQuery('.wdps_post_ctrl_btn_<?php echo $wdps; ?>').hasClass('fa-pause')) {
                if ('<?php echo $slider_row->timer_bar_type; ?>' == 'top' || '<?php echo $slider_row->timer_bar_type; ?>' == 'bottom') {
                  if (!jQuery(".wdps_post_ctrl_btn_<?php echo $wdps; ?>").hasClass("fa-play")) {
                    jQuery(".wdps_line_timer_<?php echo $wdps; ?>").animate({
                      width: "100%"
                    }, {
                      duration: <?php echo $slideshow_interval * 1000; ?>,
                      specialEasing: {width: "linear"}
                    });
                  }
                }
                else if ('<?php echo $slider_row->timer_bar_type; ?>' != 'none') {
                  if (typeof wdps_circle_timer_animate_<?php echo $wdps; ?> !== 'undefined') {
                    wdps_circle_timer_animate_<?php echo $wdps; ?>.stop();
                  }
                  jQuery('#wdps_top_right_<?php echo $wdps; ?>').css({
                    '-moz-transform':'rotate(0deg)',
                    '-webkit-transform':'rotate(0deg)',
                    '-o-transform':'rotate(0deg)',
                    '-ms-transform':'rotate(0deg)',
                    'transform':'rotate(0deg)',
                    '-webkit-transform-origin': 'left bottom',
                    '-ms-transform-origin': 'left bottom',
                    '-moz-transform-origin': 'left bottom',
                    'transform-origin': 'left bottom'
                  });
                  jQuery('#wdps_bottom_right_<?php echo $wdps; ?>').css({
                    '-moz-transform':'rotate(0deg)',
                    '-webkit-transform':'rotate(0deg)',
                    '-o-transform':'rotate(0deg)',
                    '-ms-transform':'rotate(0deg)',
                    'transform':'rotate(0deg)',
                    '-webkit-transform-origin': 'left top',
                    '-ms-transform-origin': 'left top',
                    '-moz-transform-origin': 'left top',
                    'transform-origin': 'left top'
                  });
                  jQuery('#wdps_bottom_left_<?php echo $wdps; ?>').css({
                    '-moz-transform':'rotate(0deg)',
                    '-webkit-transform':'rotate(0deg)',
                    '-o-transform':'rotate(0deg)',
                    '-ms-transform':'rotate(0deg)',
                    'transform':'rotate(0deg)',
                    '-webkit-transform-origin': 'right top',
                    '-ms-transform-origin': 'right top',
                    '-moz-transform-origin': 'right top',
                    'transform-origin': 'right top'
                  });
                  jQuery('#wdps_top_left_<?php echo $wdps; ?>').css({
                    '-moz-transform':'rotate(0deg)',
                    '-webkit-transform':'rotate(0deg)',
                    '-o-transform':'rotate(0deg)',
                    '-ms-transform':'rotate(0deg)',
                    'transform':'rotate(0deg)',
                    '-webkit-transform-origin': 'right bottom',
                    '-ms-transform-origin': 'right bottom',
                    '-moz-transform-origin': 'right bottom',
                    'transform-origin': 'right bottom'
                  });	
                  if (!jQuery(".wdps_post_ctrl_btn_<?php echo $wdps; ?>").hasClass("fa-play")) {
                    /* Begin circle timer on next.*/				  		
                    post_circle_timer_<?php echo $wdps; ?>(0);
                  }
                  else {
                    wdps_curent_time_deggree_<?php echo $wdps; ?> = 0;
                  }
                }
              }
            }
            <?php
            if ($bull_position != 'none' && $slides_count > 1) {
              ?>
              wdps_move_dots_<?php echo $wdps; ?>();
              <?php
            }
            ?>
            if (wdps_data_<?php echo $wdps; ?>[key]["is_video"] != 'image') {
              jQuery("#wdps_post_slideshow_play_pause_<?php echo $wdps; ?>").css({display: 'none'});
            }
            else {
              jQuery("#wdps_post_slideshow_play_pause_<?php echo $wdps; ?>").css({display: ''});
            }
          }, wdps_duration_for_change_<?php echo $wdps; ?>);
        }
      }
      function wdps_resize_slider_<?php echo $wdps; ?>() {
        if ('<?php echo $slider_row->bull_butt_img_or_not; ?>' == 'text') {
          wdps_set_text_dots_cont(<?php echo $wdps; ?>);
        }
        var full_width = (jQuery(window).width() <= parseInt(<?php echo $slider_row->full_width_for_mobile ?>) || <?php echo $slider_row->full_width; ?>) ? 1 : 0;
        var slide_orig_width = <?php echo $image_width; ?>;
        var slide_orig_height = <?php echo $image_height; ?>;
        var slide_width = jQuery("#wdps_container1_<?php echo $wdps; ?>").parent().width();
        if (slide_width > slide_orig_width) {
          slide_width = slide_orig_width;
        }
        var ratio = slide_width / slide_orig_width;
        if (full_width) {
          ratio = jQuery(window).width() / slide_orig_width;
          slide_orig_width = jQuery(window).width(); /*- <?php echo 2 * $slider_row->glb_margin; ?>;*/
          slide_orig_height = <?php echo $image_height; ?> * slide_orig_width / <?php echo $image_width; ?>;
          slide_width = jQuery(window).width(); /*- <?php echo 2 * $slider_row->glb_margin; ?>;*/
          wdps_full_width_<?php echo $wdps; ?>();
        }
        else if (parseInt(<?php echo $slider_row->full_width_for_mobile ?>)) {
          jQuery(".wdps_slideshow_image_wrap_<?php echo $wdps; ?>").removeAttr("style");
        }
        wdps_glb_margin_<?php echo $wdps; ?> *= ratio;
        if (!full_width) {
          slide_orig_height -= wdps_glb_margin_<?php echo $wdps; ?>;
        }
        jQuery("#wdps_container2_<?php echo $wdps; ?>").css("margin", wdps_glb_margin_<?php echo $wdps; ?> + "px " + (full_width ? 0 : '') + "");
        var slide_height = slide_orig_height;
        if (slide_orig_width > slide_width) {
          slide_height = Math.floor(slide_width * slide_orig_height / slide_orig_width);
        }
        jQuery(".wdps_slideshow_image_wrap_<?php echo $wdps; ?>, #wdps_container2_<?php echo $wdps; ?>").height(slide_height);
        jQuery(".wdps_slideshow_image_container_<?php echo $wdps; ?>").height(slide_height);
        jQuery(".wdps_slideshow_image_<?php echo $wdps; ?>").height(slide_height);
        jQuery(".wdps_slideshow_video_<?php echo $wdps; ?>").height(slide_height);
        jQuery(".wdps_slideshow_image_<?php echo $wdps; ?> img").each(function () {
          var wdps_theImage = new Image();
          wdps_theImage.src = jQuery(this).attr("src");
          var wdps_origWidth = wdps_theImage.width;
          var wdps_origHeight = wdps_theImage.height;
          var wdps_imageWidth = jQuery(this).attr("data-wdps-image-width");
          var wdps_imageHeight = jQuery(this).attr("data-wdps-image-height");
          var wdps_width = wdps_imageWidth;
          if (wdps_imageWidth > wdps_origWidth) {
            wdps_width = wdps_origWidth;
          }
          var wdps_height = wdps_imageHeight;
          if (wdps_imageHeight > wdps_origHeight) {
            wdps_height = wdps_origHeight;
          }
          jQuery(this).css({
            maxWidth: (parseFloat(wdps_imageWidth) * ratio) + "px",
            maxHeight: (parseFloat(wdps_imageHeight) * ratio) + "px",
          });
          if (jQuery(this).attr("data-wdps-scale") != "on") {
            jQuery(this).css({
              width: (parseFloat(wdps_imageWidth) * ratio) + "px",
              height: (parseFloat(wdps_imageHeight) * ratio) + "px"
            });
          }
          else if (wdps_imageWidth > wdps_origWidth || wdps_imageHeight > wdps_origHeight) {
            if (wdps_origWidth / wdps_imageWidth > wdps_origHeight / wdps_imageHeight) {
              jQuery(this).css({
                width: (parseFloat(wdps_imageWidth) * ratio) + "px"
              });
            }
            else {
              jQuery(this).css({
                height: (parseFloat(wdps_imageHeight) * ratio) + "px"
              });
            }
          }
        });
       jQuery(".wdps_slideshow_image_<?php echo $wdps; ?> span, .wdps_slideshow_image_<?php echo $wdps; ?> i").each(function () {
          var font_size;
          var ratio_new;
          var font_size_new;
          var min_font_size;
          font_size = parseFloat(jQuery(this).attr("data-wdps-fsize")) * ratio;
          font_size_new = font_size;
          ratio_new = ratio;
          if (jQuery(this).attr('data-type') == 'wdps_text_parent') {
            min_font_size = jQuery(this).attr("data-wdps-fmin-size");
            if (min_font_size > font_size) {
              font_size_new = min_font_size;
              ratio_new = ratio * font_size_new / font_size;
            }
          }
          jQuery(this).css({
            fontSize: (font_size_new) + "px",
            lineHeight: "1.25em",
            paddingLeft: (parseFloat(jQuery(this).attr("data-wdps-fpaddingl")) * ratio_new) + "px",
            paddingRight: (parseFloat(jQuery(this).attr("data-wdps-fpaddingr")) * ratio_new) + "px",
            paddingTop: (parseFloat(jQuery(this).attr("data-wdps-fpaddingt")) * ratio_new) + "px",
            paddingBottom: (parseFloat(jQuery(this).attr("data-wdps-fpaddingb")) * ratio_new) + "px",
          });
        });
        jQuery(".wdps_slideshow_image_<?php echo $wdps; ?> [data-type='wdps_text_parent']").each(function () {
          var id = jQuery(this).attr("id");
            if (wdps_data_<?php echo $wdps; ?>[jQuery("#" +  id).data("row-key")]["layer_"+ jQuery("#" +  id).data("layer-key") +"_align_layer"] == 1) {
              var slider_width = jQuery(".wdps_slider_" + <?php echo $wdps; ?>).outerWidth(); 
              var left;
              if ((jQuery("#" +  id).offset().left - jQuery(".wdps_slideshow_image_<?php echo $wdps; ?>").offset().left) > (slider_width / 2 + jQuery(this).outerWidth() / 2)) {
                left = slider_width - jQuery(this).outerWidth();
              }
              else if ((jQuery("#" +  id).offset().left - jQuery(".wdps_slideshow_image_<?php echo $wdps; ?>").offset().left) < (slider_width / 2 - jQuery(this).outerWidth() / 2)) {
                left = 0;
              }
              else {
                left = slider_width / 2 - jQuery(this).outerWidth() / 2;
              }
              var left_percent = (slider_width != 0) ? 100 * left / slider_width : 0;
              jQuery("#" +  id).css({left:left_percent +"%" });
            }
        });
      }
      /* Generate background position for Zoom Fade effect.*/
      function wdps_genBgPos_<?php echo $wdps; ?>() {
        var bgSizeArray = [0, 70];
        var bgSize = bgSizeArray[Math.floor(Math.random() * bgSizeArray.length)];
        var bgPosXArray = ['left', 'right'];
        var bgPosYArray = ['top', 'bottom'];
        var bgPosX = bgPosXArray[Math.floor(Math.random() * bgPosXArray.length)];
        var bgPosY = bgPosYArray[Math.floor(Math.random() * bgPosYArray.length)];
        jQuery(".wdps_slideshow_image_<?php echo $wdps; ?>").css({
          backgroundPosition: bgPosX + " " + bgPosY,
          backgroundSize : (100 + bgSize) + "%",
          webkitAnimation: '<?php echo $slideshow_interval; ?>s linear 0s alternate infinite wdpszoom' + bgSize,
          mozAnimation: '<?php echo $slideshow_interval; ?>s linear 0s alternate infinite wdpszoom' + bgSize,
          animation: '<?php echo $slideshow_interval; ?>s linear 0s alternate infinite wdpszoom' + bgSize
        });
      }
      jQuery(window).resize(function () {
        wdps_resize_slider_<?php echo $wdps; ?>();
      });
      function wdps_full_width_<?php echo $wdps; ?>() {
        var left = jQuery("#wdps_container1_<?php echo $wdps; ?>").offset().left;
        jQuery(".wdps_slideshow_image_wrap_<?php echo $wdps; ?>").css({
          left: (-left) + "px",
          width: (jQuery(window).width()) + "px",
          maxWidth: "none"
        });
      }
      if ("<?php echo $current_image_url; ?>" != '') {
        jQuery('<img />').attr("src", "<?php echo $current_image_url; ?>").load(function() {
          jQuery(this).remove();
          wdps_ready_<?php echo $wdps; ?>();
        });
      }
      else {
        jQuery(document).ready(function () {
          wdps_ready_<?php echo $wdps; ?>();
        });
      }
      function wdps_ready_<?php echo $wdps; ?>() {
        <?php
        if ($enable_slideshow_autoplay && $slider_row->stop_animation) {
          ?>
        jQuery("#wdps_container1_<?php echo $wdps; ?>").mouseover(function(e) {
          wdps_stop_animation_<?php echo $wdps; ?>();
        });
        jQuery("#wdps_container1_<?php echo $wdps; ?>").mouseout(function(e) {
          if (!e) {
            var e = window.event;
          }
          var reltg = (e.relatedTarget) ? e.relatedTarget : e.toElement;
          while (reltg.tagName != 'BODY') {
            if (reltg.id == this.id){
              return;
            }
            reltg = reltg.parentNode;
          }
          wdps_play_animation_<?php echo $wdps; ?>();
        });
          <?php
        }
        ?>
        if ('<?php echo $slider_row->bull_butt_img_or_not; ?>' == 'text') {
          wdps_set_text_dots_cont(<?php echo $wdps; ?>);
        }
        jQuery(".wdps_slideshow_image_<?php echo $wdps; ?> span, .wdps_slideshow_image_<?php echo $wdps; ?> i").each(function () {
          jQuery(this).attr("data-wdps-fpaddingl", jQuery(this).css("paddingLeft"));
          jQuery(this).attr("data-wdps-fpaddingr", jQuery(this).css("paddingRight"));
          jQuery(this).attr("data-wdps-fpaddingt", jQuery(this).css("paddingTop"));
          jQuery(this).attr("data-wdps-fpaddingb", jQuery(this).css("paddingBottom"));
        });
        if (<?php echo $navigation; ?>) {
          jQuery("#wdps_container2_<?php echo $wdps; ?>").hover(function () {
            jQuery(".wdps_right-ico_<?php echo $wdps; ?>").animate({left: 0}, 700, "swing");
            jQuery(".wdps_left-ico_<?php echo $wdps; ?>").animate({left: 0}, 700, "swing");
            jQuery("#wdps_post_slideshow_play_pause_<?php echo $wdps; ?>").animate({opacity: 1, filter: "Alpha(opacity=100)"}, 700, "swing");
          }, function () {
            jQuery(".wdps_right-ico_<?php echo $wdps; ?>").css({left: 4000});
            jQuery(".wdps_left-ico_<?php echo $wdps; ?>").css({left: -4000});
            jQuery("#wdps_post_slideshow_play_pause_<?php echo $wdps; ?>").css({opacity: 0, filter: "Alpha(opacity=0)"});
          });
        }
        if (!<?php echo $bull_hover; ?>) {
          jQuery("#wdps_container2_<?php echo $wdps; ?>").hover(function () {
            jQuery(".wdps_slideshow_dots_container_<?php echo $wdps; ?>").animate({opacity: 1, filter: "Alpha(opacity=100)"}, 700, "swing");
          }, function () {
            jQuery(".wdps_slideshow_dots_container_<?php echo $wdps; ?>").css({opacity: 0, filter: "Alpha(opacity=0)"});
          });
        }
        wdps_resize_slider_<?php echo $wdps; ?>();
        jQuery("#wdps_container2_<?php echo $wdps; ?>").css({visibility: 'visible'});
        jQuery(".wdps_loading").hide();
      	<?php
        if ($slider_row->effect == 'zoomFade') {
          ?>
          wdps_genBgPos_<?php echo $wdps; ?>();
          <?php
        }
        if ($image_right_click) {
          ?>
          /* Disable right click.*/
          jQuery('div[id^="wdps_container"]').bind("contextmenu", function () {
            return false;
          });
          <?php
        }
        ?>
        var isMobile = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
        if (isMobile) {
          if (<?php echo $touch_swipe_nav; ?>) {
            wdps_swipe();
          }
        }
        else {
          if (<?php echo $mouse_swipe_nav; ?>) {
            wdps_swipe();
          }
        }
        function wdps_swipe() {
          if (typeof jQuery().swiperight !== 'undefined') {
            if (jQuery.isFunction(jQuery().swiperight)) {
              jQuery('#wdps_container1_<?php echo $wdps; ?>').swiperight(function () {
                wdps_change_image_<?php echo $wdps; ?>(parseInt(jQuery('#wdps_current_image_key_<?php echo $wdps; ?>').val()), (parseInt(jQuery('#wdps_current_image_key_<?php echo $wdps; ?>').val()) - wdps_iterator_<?php echo $wdps; ?>()) >= 0 ? (parseInt(jQuery('#wdps_current_image_key_<?php echo $wdps; ?>').val()) - wdps_iterator_<?php echo $wdps; ?>()) % wdps_data_<?php echo $wdps; ?>.length : wdps_data_<?php echo $wdps; ?>.length - 1, wdps_data_<?php echo $wdps; ?>, false, "left");
              });
            }
          }
          if (typeof jQuery().swipeleft !== 'undefined') {
            if (jQuery.isFunction(jQuery().swipeleft)) {
              jQuery('#wdps_container1_<?php echo $wdps; ?>').swipeleft(function () {
                wdps_change_image_<?php echo $wdps; ?>(parseInt(jQuery('#wdps_current_image_key_<?php echo $wdps; ?>').val()), (parseInt(jQuery('#wdps_current_image_key_<?php echo $wdps; ?>').val()) + wdps_iterator_<?php echo $wdps; ?>()) % wdps_data_<?php echo $wdps; ?>.length, wdps_data_<?php echo $wdps; ?>, false, "right");
              });
            }
          }
        }
        var wdps_click = isMobile ? 'touchend' : 'click';
        var mousewheelevt = (/Firefox/i.test(navigator.userAgent)) ? "DOMMouseScroll" : "mousewheel"; /* FF doesn't recognize mousewheel as of FF3.x */
         /* Mouswheel navigation.*/
        if (<?php echo $mouse_wheel_nav; ?>) {
          jQuery('.wdps_slide_container_<?php echo $wdps; ?>').bind(mousewheelevt, function(e) {
            var evt = window.event || e; /* Equalize event object.*/
            evt = evt.originalEvent ? evt.originalEvent : evt; /* Convert to originalEvent if possible.*/
            var delta = evt.detail ? evt.detail*(-40) : evt.wheelDelta; /* Check for detail first, because it is used by Opera and FF.*/
            if (delta > 0) {
              /* Scroll up.*/
              wdps_change_image_<?php echo $wdps; ?>(parseInt(jQuery('#wdps_current_image_key_<?php echo $wdps; ?>').val()), (parseInt(jQuery('#wdps_current_image_key_<?php echo $wdps; ?>').val()) - wdps_iterator_<?php echo $wdps; ?>()) >= 0 ? (parseInt(jQuery('#wdps_current_image_key_<?php echo $wdps; ?>').val()) - wdps_iterator_<?php echo $wdps; ?>()) % wdps_data_<?php echo $wdps; ?>.length : wdps_data_<?php echo $wdps; ?>.length - 1, wdps_data_<?php echo $wdps; ?>, false, "left");
            }
            else {
              /* Scroll down.*/
              wdps_change_image_<?php echo $wdps; ?>(parseInt(jQuery('#wdps_current_image_key_<?php echo $wdps; ?>').val()), (parseInt(jQuery('#wdps_current_image_key_<?php echo $wdps; ?>').val()) + wdps_iterator_<?php echo $wdps; ?>()) % wdps_data_<?php echo $wdps; ?>.length, wdps_data_<?php echo $wdps; ?>, false, "right");
            }
            return false;
          });
        }
        /* Keyboard navigation.*/
        if (<?php echo $keyboard_nav; ?>) {
          jQuery(document).on('keydown', function (e) {
            if (e.keyCode === 39 || e.keyCode === 38) { /* Right arrow.*/
              wdps_change_image_<?php echo $wdps; ?>(parseInt(jQuery('#wdps_current_image_key_<?php echo $wdps; ?>').val()), (parseInt(jQuery('#wdps_current_image_key_<?php echo $wdps; ?>').val()) + wdps_iterator_<?php echo $wdps; ?>()) % wdps_data_<?php echo $wdps; ?>.length, wdps_data_<?php echo $wdps; ?>, false, "right");
            }
            else if (e.keyCode === 37 || e.keyCode === 40) { /* Left arrow.*/
              wdps_change_image_<?php echo $wdps; ?>(parseInt(jQuery('#wdps_current_image_key_<?php echo $wdps; ?>').val()), (parseInt(jQuery('#wdps_current_image_key_<?php echo $wdps; ?>').val()) - wdps_iterator_<?php echo $wdps; ?>()) >= 0 ? (parseInt(jQuery('#wdps_current_image_key_<?php echo $wdps; ?>').val()) - wdps_iterator_<?php echo $wdps; ?>()) % wdps_data_<?php echo $wdps; ?>.length : wdps_data_<?php echo $wdps; ?>.length - 1, wdps_data_<?php echo $wdps; ?>, false, "left");
            }
            else if (e.keyCode === 32) { /* Space.*/
              wdps_play_pause_<?php echo $wdps; ?>();
            } 
          });
        }
           /* Play/pause.*/
        jQuery("#wdps_post_slideshow_play_pause_<?php echo $wdps; ?>").on(wdps_click, function () {
          wdps_play_pause_<?php echo $wdps; ?>();
        });
        if (<?php echo $enable_slideshow_autoplay; ?>) {
          wdps_play_<?php echo $wdps; ?>();
          jQuery(".wdps_post_slideshow_play_pause_<?php echo $wdps; ?>").attr("title", "<?php echo __('Pause', 'wdps'); ?>");
          jQuery(".wdps_post_slideshow_play_pause_<?php echo $wdps; ?>").attr("class", "wdps_post_ctrl_btn_<?php echo $wdps; ?> wdps_post_slideshow_play_pause_<?php echo $wdps; ?> fa fa-pause");
		  <?php if($enable_slideshow_music && !empty($slideshow_music_url)){ ?>
            document.getElementById("wdps_audio_<?php echo $wdps; ?>").play();
          <?php } ?>
          if ('<?php echo $slider_row->timer_bar_type; ?>' != 'none') {
            if ('<?php echo $slider_row->timer_bar_type; ?>' != 'top') {
              if ('<?php echo $slider_row->timer_bar_type; ?>' != 'bottom') {
                post_circle_timer_<?php echo $wdps; ?>(0);
              }
            }
          }
        }
         <?php if ($slider_row->preload_images) { ?>
        function wdps_preload_<?php echo $wdps; ?>(preload_key) {
          jQuery("<img/>")
            .load(function() { if (preload_key < wdps_data_<?php echo $wdps; ?>.length - 1) wdps_preload_<?php echo $wdps; ?>(preload_key + 1); })
            .error(function() { if (preload_key < wdps_data_<?php echo $wdps; ?>.length - 1) wdps_preload_<?php echo $wdps; ?>(preload_key + 1); })
            .attr("src", (!wdps_data_<?php echo $wdps; ?>[preload_key]["is_video"] ? wdps_data_<?php echo $wdps; ?>[preload_key]["image_url"] : ""));
        }
        wdps_preload_<?php echo $wdps; ?>(0);
        <?php } ?>
        var first_slide_layers_count_<?php echo $wdps; ?> = wdps_data_<?php echo $wdps; ?>[<?php echo $start_slide_num; ?>]["slide_layers_count"];
        if (first_slide_layers_count_<?php echo $wdps; ?>) {
          /* Loop through layers in.*/
          for (var j = 0; j < first_slide_layers_count_<?php echo $wdps; ?>; j++) {
            wdps_set_layer_effect_in_<?php echo $wdps; ?>(j, <?php echo $start_slide_num; ?>);
          }
          /* Loop through layers out.*/
          for (var i = 0; i < first_slide_layers_count_<?php echo $wdps; ?>; i++) {
            wdps_set_layer_effect_out_<?php echo $wdps; ?>(i, <?php echo $start_slide_num; ?>);
          }
        }
      }
      var wdps_play_pause_state_<?php echo $wdps; ?> = 0;
      function wdps_post_slider_play_<?php echo $wdps; ?>() {
        wdps_play_pause_state_<?php echo $wdps; ?> = 0;
        /* Play.*/
        jQuery(".wdps_post_slideshow_play_pause_<?php echo $wdps; ?>").attr("title", "<?php echo __('Pause', 'wdps'); ?>");
        jQuery(".wdps_post_slideshow_play_pause_<?php echo $wdps; ?>").attr("class", "wdps_post_ctrl_btn_<?php echo $wdps; ?> wdps_post_slideshow_play_pause_<?php echo $wdps; ?> fa fa-pause");
        /* Finish current animation and begin the other.*/
        if (<?php echo $enable_slideshow_autoplay; ?>) {
          if ('<?php echo $slider_row->timer_bar_type; ?>' != 'top') {
            if ('<?php echo $slider_row->timer_bar_type; ?>' != 'bottom') {
              if (typeof wdps_circle_timer_animate_<?php echo $wdps; ?> !== 'undefined') {
                wdps_circle_timer_animate_<?php echo $wdps; ?>.stop();
              }
              post_circle_timer_<?php echo $wdps; ?>(wdps_curent_time_deggree_<?php echo $wdps; ?>);
            }
          }
        }
        wdps_play_<?php echo $wdps; ?>();
        <?php if($enable_slideshow_music && !empty($slideshow_music_url)){ ?>
          document.getElementById("wdps_audio_<?php echo $wdps; ?>").play();
        <?php } ?>
      }
      function wdps_pause_<?php echo $wdps; ?>() {
        /* Pause.*/
        /* Pause layers out effect.*/
        wdps_play_pause_state_<?php echo $wdps; ?> = 1;
        var current_key = jQuery('#wdps_current_image_key_<?php echo $wdps; ?>').val();
        var current_slide_layers_count = wdps_data_<?php echo $wdps; ?>[current_key]["slide_layers_count"];
        setTimeout(function() {
          for (var k = 0; k < current_slide_layers_count; k++) {
            clearTimeout(wdps_clear_layers_effects_out_<?php echo $wdps; ?>[current_key][k]);
          }
        }, wdps_duration_for_clear_effects_<?php echo $wdps; ?>);
        window.clearInterval(wdps_playInterval_<?php echo $wdps; ?>);
        jQuery(".wdps_post_slideshow_play_pause_<?php echo $wdps; ?>").attr("title", "<?php echo __('Play', 'wdps'); ?>");
        jQuery(".wdps_post_slideshow_play_pause_<?php echo $wdps; ?>").attr("class", "wdps_post_ctrl_btn_<?php echo $wdps; ?> wdps_post_slideshow_play_pause_<?php echo $wdps; ?> fa fa-play");
        <?php if($enable_slideshow_music && !empty($slideshow_music_url)){ ?>
          document.getElementById("wdps_audio_<?php echo $wdps; ?>").pause();
        <?php } ?>
        if (typeof jQuery().stop !== 'undefined') {
          if (jQuery.isFunction(jQuery().stop)) {
            <?php
            if ($slider_row->timer_bar_type == 'top' ||  $slider_row->timer_bar_type == 'bottom') {
              ?>
              jQuery(".wdps_line_timer_<?php echo $wdps; ?>").stop();
              <?php
            }
            elseif ($slider_row->timer_bar_type != 'none') {
              ?>
              /* Pause circle timer.*/
              if (typeof wdps_circle_timer_animate_<?php echo $wdps; ?>.stop !== 'undefined') {
                wdps_circle_timer_animate_<?php echo $wdps; ?>.stop();
              }
              <?php
            }
            ?>
          }
        }
      }
      function wdps_play_pause_<?php echo $wdps; ?>(play_pause) {
        if (typeof play_pause == "undefined") {
          var play_pause = "";
        }
        if (play_pause == "") {
          if (jQuery(".wdps_post_ctrl_btn_<?php echo $wdps; ?>").hasClass("fa-play") || wdps_play_pause_state_<?php echo $wdps; ?>) {
            wdps_post_slider_play_<?php echo $wdps; ?>();
          }
          else {
            wdps_pause_<?php echo $wdps; ?>();
          }
        }
        else if (play_pause == "play") {
          wdps_post_slider_play_<?php echo $wdps; ?>();
        }
        else if (play_pause == "pause") {
          wdps_pause_<?php echo $wdps; ?>();
        }
      }
	    function wdps_stop_animation_<?php echo $wdps; ?>() {
        window.clearInterval(wdps_playInterval_<?php echo $wdps; ?>);
        /* Pause layers out effect.*/
        var current_key = jQuery('#wdps_current_image_key_<?php echo $wdps; ?>').val();
        var current_slide_layers_count = wdps_data_<?php echo $wdps; ?>[current_key]["slide_layers_count"];			
        setTimeout(function() {
          for (var k = 0; k < current_slide_layers_count; k++) {
            clearTimeout(wdps_clear_layers_effects_out_<?php echo $wdps; ?>[current_key][k]);
          }
        }, wdps_duration_for_clear_effects_<?php echo $wdps; ?>);
        <?php if($enable_slideshow_music && !empty($slideshow_music_url)){ ?>
          document.getElementById("wdps_audio_<?php echo $wdps; ?>").pause();
        <?php } ?>
        if (typeof jQuery().stop !== 'undefined') {
          if (jQuery.isFunction(jQuery().stop)) {
            if ('<?php echo $slider_row->timer_bar_type; ?>' == 'top' || '<?php echo $slider_row->timer_bar_type; ?>' == 'bottom') {
              jQuery(".wdps_line_timer_<?php echo $wdps; ?>").stop();
            }
            else if ('<?php echo $slider_row->timer_bar_type; ?>' != 'none') {
              wdps_circle_timer_animate_<?php echo $wdps; ?>.stop();
            }
          }
        }
      }
      function wdps_play_animation_<?php echo $wdps; ?>() {
        if (jQuery(".wdps_post_ctrl_btn_<?php echo $wdps; ?>").hasClass("fa-play")) {
          return;
        }
        wdps_play_<?php echo $wdps; ?>();
        if ('<?php echo $slider_row->timer_bar_type; ?>' != 'none') {
          if ('<?php echo $slider_row->timer_bar_type; ?>' != 'bottom') {
            if ('<?php echo $slider_row->timer_bar_type; ?>' != 'top') {
              if (typeof wdps_circle_timer_animate_<?php echo $wdps; ?> !== 'undefined') {
                wdps_circle_timer_animate_<?php echo $wdps; ?>.stop();
              }
              post_circle_timer_<?php echo $wdps; ?>(wdps_curent_time_deggree_<?php echo $wdps; ?>);
            }
          }
        }
        <?php if($enable_slideshow_music && !empty($slideshow_music_url)){ ?>
          document.getElementById("wdps_audio_<?php echo $wdps; ?>").play();
        <?php } ?>
        var slide_layers_count = wdps_data_<?php echo $wdps; ?>[wdps_current_key_<?php echo $wdps; ?>]["slide_layers_count"];
        for (var i = 0; i < slide_layers_count; i++) {
          wdps_set_layer_effect_out_<?php echo $wdps; ?>(i, wdps_current_key_<?php echo $wdps; ?>);
        }          
      }
      /* Effects in part.*/		
		  function wdps_set_layer_effect_in_<?php echo $wdps; ?>(j, key) {
        var cout;
		    wdps_clear_layers_effects_in_<?php echo $wdps; ?>[key][j] = setTimeout(function() {
          cout = jQuery('#wdps_<?php echo $wdps; ?>_slide' + wdps_data_<?php echo $wdps; ?>[key]["id"] + '_layer' + wdps_data_<?php echo $wdps; ?>[key]["layer_" + j + "_id"]);
          if (wdps_data_<?php echo $wdps; ?>[key]["layer_" + j + "_layer_effect_in"] != 'none') {
            if (wdps_data_<?php echo $wdps; ?>[key]["layer_" + j + "_type"] != 'social') {
              cout.css('-webkit-animation-duration' , wdps_data_<?php echo $wdps; ?>[key]["layer_" + j + "_duration_eff_in"] / 1000 + 's').css('animation-duration' , wdps_data_<?php echo $wdps; ?>[key]["layer_" + j + "_duration_eff_in"] / 1000 + 's');
              cout.removeClass().addClass( wdps_data_<?php echo $wdps; ?>[key]["layer_" + j + "_layer_effect_in"] + ' wdps_animated');
            }
            else {
              cout.css('-webkit-animation-duration' , wdps_data_<?php echo $wdps; ?>[key]["layer_" + j + "_duration_eff_in"] / 1000 + 's').css('animation-duration' , wdps_data_<?php echo $wdps; ?>[key]["layer_" + j + "_duration_eff_in"] / 1000 + 's');
              cout.removeClass().addClass( wdps_data_<?php echo $wdps; ?>[key]["layer_" + j + "_layer_effect_in"] + ' fa fa-' + wdps_data_<?php echo $wdps; ?>[key]["layer_" + j + "_social_button"] + ' wdps_animated');
            }
            var iteration_count = wdps_data_<?php echo $wdps; ?>[key]["layer_" + j + "_infinite_in"] == 0 ? 'infinite' : wdps_data_<?php echo $wdps; ?>[key]["layer_" + j + "_infinite_in"];
            cout.css(
              '-webkit-animation-iteration-count', iteration_count
            ).css(
              'animation-iteration-count', iteration_count
            );
          }
		    }, wdps_data_<?php echo $wdps; ?>[key]["layer_" + j + "_start"]);
		  }
      /* Effects out part.*/
		  function wdps_set_layer_effect_out_<?php echo $wdps; ?>(i, key) {
        var cout;
			  wdps_clear_layers_effects_out_<?php echo $wdps; ?>[key][i] = setTimeout(function() {
          cout = jQuery('#wdps_<?php echo $wdps; ?>_slide' + wdps_data_<?php echo $wdps; ?>[key]["id"] + '_layer' + wdps_data_<?php echo $wdps; ?>[key]["layer_" + i + "_id"]);
          if (wdps_data_<?php echo $wdps; ?>[key]["layer_" + i + "_layer_effect_out"] != 'none') {
            if (wdps_data_<?php echo $wdps; ?>[key]["layer_" + i + "_type"] != 'social') {
              cout.css('-webkit-animation-duration' , wdps_data_<?php echo $wdps; ?>[key]["layer_" + i + "_duration_eff_out"] / 1000 + 's').css('animation-duration' , wdps_data_<?php echo $wdps; ?>[key]["layer_" + i + "_duration_eff_out"] / 1000 + 's');
              cout.removeClass().addClass( wdps_data_<?php echo $wdps; ?>[key]["layer_" + i + "_layer_effect_out"] + ' wdps_animated');
            }
            else {
              cout.css('-webkit-animation-duration' , wdps_data_<?php echo $wdps; ?>[key]["layer_" + i + "_duration_eff_out"] / 1000 + 's').css('animation-duration' , wdps_data_<?php echo $wdps; ?>[key]["layer_" + i + "_duration_eff_out"] / 1000 + 's');
              cout.removeClass().addClass( wdps_data_<?php echo $wdps; ?>[key]["layer_" + i + "_layer_effect_out"] + ' fa fa-' + wdps_data_<?php echo $wdps; ?>[key]["layer_" + i + "_social_button"] + ' wdps_animated');
            }
            var iteration_count = wdps_data_<?php echo $wdps; ?>[key]["layer_" + i + "_infinite_out"] == 0 ? 'infinite' : wdps_data_<?php echo $wdps; ?>[key]["layer_" + i + "_infinite_out"];
            cout.css(
              '-webkit-animation-iteration-count', iteration_count
            ).css(
              'animation-iteration-count', iteration_count
            );
          }
		    }, wdps_data_<?php echo $wdps; ?>[key]["layer_" + i + "_end"]);
		  }
      function wdps_play_<?php echo $wdps; ?>() {
        if ('<?php echo $slider_row->timer_bar_type; ?>' != 'none') {
          if (<?php echo $enable_slideshow_autoplay; ?> || jQuery('.wdps_post_ctrl_btn_<?php echo $wdps; ?>').hasClass('fa-pause')) {
            jQuery(".wdps_line_timer_<?php echo $wdps; ?>").animate({
              width: "100%"
            }, {
              duration: <?php echo $slideshow_interval * 1000; ?>,
              specialEasing: {width: "linear"}
            });
          }
        }
        window.clearInterval(wdps_playInterval_<?php echo $wdps; ?>);
        /* Play.*/
        wdps_playInterval_<?php echo $wdps; ?> = setInterval(function () {
          var curr_img_index = parseInt(jQuery('#wdps_current_image_key_<?php echo $wdps; ?>').val());
          if ('<?php echo $slider_loop; ?>' == 0) {
            if (<?php echo $twoway_slideshow; ?>) {
              if(wdps_global_btn_<?php echo $wdps; ?> == "left") {
                if (curr_img_index == 0) {
                  return false;
                }
              }
              else {              
                if (curr_img_index == <?php echo $slides_count - 1; ?>) {
                  return false;
                }             
              }
            }
            else {
              if (curr_img_index == <?php echo $slides_count - 1; ?>) {
                return false;
              }
            }
          }
          function wdps_call_change() {
              var iterator = 1;
              var img_index = (parseInt(jQuery('#wdps_current_image_key_<?php echo $wdps; ?>').val()) + iterator) % wdps_data_<?php echo $wdps; ?>.length;
              if (<?php echo $enable_slideshow_shuffle; ?>) {
                 iterator = Math.floor((wdps_data_<?php echo $wdps; ?>.length - 1) * Math.random() + 1);
              }
              else if (<?php echo $twoway_slideshow; ?>) {
                if (wdps_global_btn_<?php echo $wdps; ?> == "left") {
                  iterator = -1;
                  img_index = (parseInt(jQuery('#wdps_current_image_key_<?php echo $wdps; ?>').val()) + iterator) >= 0 ? (parseInt(jQuery('#wdps_current_image_key_<?php echo $wdps; ?>').val()) + iterator) % wdps_data_<?php echo $wdps; ?>.length : wdps_data_<?php echo $wdps; ?>.length - 1;
                }
              }
              wdps_change_image_<?php echo $wdps; ?>(parseInt(jQuery('#wdps_current_image_key_<?php echo $wdps; ?>').val()), img_index, wdps_data_<?php echo $wdps; ?>);
           }
          wdps_call_change();
        }, parseInt('<?php echo ($slideshow_interval * 1000); ?>') + wdps_duration_for_change_<?php echo $wdps; ?>);
      }
      jQuery(window).focus(function() {
        if (!jQuery(".wdps_post_ctrl_btn_<?php echo $wdps; ?>").hasClass("fa-play")) {
          if (<?php echo $enable_slideshow_autoplay; ?>) {
            wdps_play_<?php echo $wdps; ?>();
            if ('<?php echo $slider_row->timer_bar_type; ?>' != 'none') {
              if ('<?php echo $slider_row->timer_bar_type; ?>' != 'top') {
                if ('<?php echo $slider_row->timer_bar_type; ?>' != 'bottom') {
                  if (typeof wdps_circle_timer_animate_<?php echo $wdps; ?> !== 'undefined') {
                    wdps_circle_timer_animate_<?php echo $wdps; ?>.stop();
                  }
                  post_circle_timer_<?php echo $wdps; ?>(wdps_curent_time_deggree_<?php echo $wdps; ?>);
                }
              }
            }
          }
        }
      });
      jQuery(window).blur(function() {
        wdps_event_stack_<?php echo $wdps; ?> = [];
        window.clearInterval(wdps_playInterval_<?php echo $wdps; ?>);
        if (typeof jQuery().stop !== 'undefined') {
          if (jQuery.isFunction(jQuery().stop)) {
            if ('<?php echo $slider_row->timer_bar_type; ?>' == 'top' || '<?php echo $slider_row->timer_bar_type; ?>' == 'bottom') {
              jQuery(".wdps_line_timer_<?php echo $wdps; ?>").stop();
            }
            else if ('<?php echo $slider_row->timer_bar_type; ?>' != 'none') {
              wdps_circle_timer_animate_<?php echo $wdps; ?>.stop();
            }
          }
        }
      });
    </script>
    <?php
    if ($from_shortcode) {
      return;
    }
    else {
      die();
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