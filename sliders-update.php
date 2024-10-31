<?php

function wdps_update($version) {
  global $wpdb;
  if (version_compare($version, '1.0.3') == -1) {
    $wpdb->query("ALTER TABLE `" . $wpdb->prefix . "wdpsslider` ADD `smart_crop` tinyint(1) NOT NULL DEFAULT 0");
    $wpdb->query("ALTER TABLE `" . $wpdb->prefix . "wdpsslider` ADD `crop_image_position` varchar(16) NOT NULL DEFAULT 'center center'");
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdpsslider ADD `bull_back_act_color` varchar(8) NOT NULL DEFAULT '000000'");
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdpsslider ADD `bull_back_color` varchar(8) NOT NULL DEFAULT 'CCCCCC'");
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdpsslider ADD `bull_radius` varchar(32) NOT NULL DEFAULT '20px'");
  }
  if (version_compare($version, '1.0.5') == -1) {
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdpsslider ADD `carousel_degree` int(4) NOT NULL DEFAULT 0");
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdpsslider ADD `carousel_grayscale` int(4) NOT NULL DEFAULT 0");
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdpsslider ADD `carousel_transparency` int(4) NOT NULL DEFAULT 0");
  }
  if (version_compare($version, '1.0.6') == -1) {
    $wpdb->query("ALTER TABLE `" . $wpdb->prefix . "wdpslayer` ADD `layer_characters_count` int(4) NOT NULL DEFAULT 250");
  }
  if (version_compare($version, '1.0.9') == -1) {
    $wpdb->query("ALTER TABLE `" . $wpdb->prefix . "wdpsslider` CHANGE `taxonomies` `taxonomies` longtext NOT NULL DEFAULT ''");
  }
  if (version_compare($version, '1.0.11') == -1) {
    $wpdb->query("ALTER TABLE `" . $wpdb->prefix . "wdpsslider` ADD `featured_image` tinyint(1) NOT NULL DEFAULT 1");
  }
  if (version_compare($version, '1.0.12') == -1) {
    $wpdb->query("ALTER TABLE `" . $wpdb->prefix . "wdpsslider` CHANGE `choose_post` `choose_post` longtext NOT NULL DEFAULT ''");
  }
  if (version_compare($version, '1.0.14') == -1) {
    $wpdb->query("ALTER TABLE `" . $wpdb->prefix . "wdpsslider` ADD `possib_add_google_fonts` tinyint(1) NOT NULL DEFAULT 0");
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdpsslider ADD `possib_add_ffamily_google` varchar(255) NOT NULL DEFAULT ''");    
  }
  if (version_compare($version, '1.0.18') == -1) {
    $wpdb->query("ALTER TABLE `" . $wpdb->prefix . "wdpsslider` ADD `bull_hover` tinyint(1) NOT NULL DEFAULT 1");
    $wpdb->query("ALTER TABLE `" . $wpdb->prefix . "wdpsslider` ADD `show_thumbnail` tinyint(1) NOT NULL DEFAULT 0");
    $wpdb->query("ALTER TABLE `" . $wpdb->prefix . "wdpsslider` ADD `thumb_size` varchar(8) NOT NULL DEFAULT '0.3'");
  }
  if (version_compare($version, '1.0.19') == -1) {
    $wpdb->query("ALTER TABLE `" . $wpdb->prefix . "wdpslayer` ADD `align_layer` tinyint(1) NOT NULL DEFAULT 0");
    $wpdb->query("ALTER TABLE `" . $wpdb->prefix . "wdpslayer` CHANGE `layer_effect_in` `layer_effect_in` varchar(32)");
    $wpdb->query("ALTER TABLE `" . $wpdb->prefix . "wdpslayer` CHANGE `layer_effect_out` `layer_effect_out` varchar(32)");
  }
  if (version_compare($version, '1.0.20') == -1) {
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdpslayer ADD `text_alignment` varchar(8) NOT NULL DEFAULT 'left'");
  }
  if (version_compare($version, '1.0.21') == -1) {
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdpslayer ADD `remove_shortcode` tinyint(1) NOT NULL DEFAULT 1");
  }
  if (version_compare($version, '1.0.27') == -1) {
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdpsslider ADD `mouse_swipe_nav` tinyint(1) NOT NULL DEFAULT 0");
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdpsslider ADD `touch_swipe_nav` tinyint(1) NOT NULL DEFAULT 1");
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdpsslider ADD `mouse_wheel_nav` tinyint(1) NOT NULL DEFAULT 0");
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdpsslider ADD `keyboard_nav` tinyint(1) NOT NULL DEFAULT 0");   
  }
  if (version_compare($version, '1.0.28') == -1) {
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdpsslider ADD `twoway_slideshow` tinyint(1) NOT NULL DEFAULT 0");
  }
  if (version_compare($version, '1.0.29') == -1) { 
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdpsslider ADD `hide_on_mobile` int(4) NOT NULL DEFAULT 0");
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdpsslider ADD `slider_loop` tinyint(1) NOT NULL DEFAULT 1");
  }
  if (version_compare($version, '1.0.31') == -1) { 
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdpsslider ADD `full_width_for_mobile` int(4) NOT NULL DEFAULT 0");
  }
  if (version_compare($version, '1.0.32') == -1) {
    $wpdb->query("ALTER TABLE `" . $wpdb->prefix . "wdpslayer` ADD `infinite_in` int(4) NOT NULL DEFAULT 1");
    $wpdb->query("ALTER TABLE `" . $wpdb->prefix . "wdpslayer` ADD `infinite_out` int(4) NOT NULL DEFAULT 1");
  }
  if (version_compare($version, '1.0.33') == -1) { 
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdpsslider ADD `order_dir` varchar(4) NOT NULL DEFAULT 'ASC'");
  }
  if (version_compare($version, '1.0.35') == -1) {
    $array_fonts = $wpdb->get_results("SELECT possib_add_ffamily_google,possib_add_ffamily FROM " . $wpdb->prefix . "wdpsslider");
    if ($wpdb->last_error || is_null($array_fonts)) {
      return;
    }
    $array_possib_add_ffamily_google = array();
    $array_possib_add_ffamily = array();
    foreach ($array_fonts as $key => $array_font) {
      array_push($array_possib_add_ffamily, $array_font->possib_add_ffamily);
      array_push($array_possib_add_ffamily_google, $array_font->possib_add_ffamily_google);
    }
    $wdps_register_scripts = 0;
    $possib_add_ffamily_google = implode(array_unique(explode('*WD*', implode($array_possib_add_ffamily_google,'*WD*'))),'*WD*');
    $possib_add_ffamily = implode(array_unique(explode('*WD*', implode($array_possib_add_ffamily,'*WD*'))),'*WD*');
    $wdps_array_glogal_options = json_encode(array("wdps_register_scripts" => $wdps_register_scripts, "possib_add_ffamily" => $possib_add_ffamily, 'possib_add_ffamily_google' => $possib_add_ffamily_google));
    update_option("wdps_array_glogal_options", $wdps_array_glogal_options);
  }
  if (version_compare($version, '1.0.37') == -1) {
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdpslayer ADD `hover_color_text` varchar(8) NOT NULL DEFAULT 'FFFFFF'");
  }
  if (version_compare($version, '1.0.39') == -1) {
    $wpdb->query("ALTER TABLE `" . $wpdb->prefix . "wdpslayer` ADD `min_size` int(4) NOT NULL DEFAULT 0");
  }
  return;
}