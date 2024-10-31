<?php
/**
 * Plugin Name: Post Slider by 10Web
 * Plugin URI: https://10web.io/plugins/wordpress-post-slider/
 * Description: Post Slider by 10Web is designed to show off your selected posts of your website using in a slider.
 * Version: 1.0.60
 * Author: 10Web
 * Author URI: https://10web.io/pricing/
 * License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

define('WD_PS_DIR', WP_PLUGIN_DIR . "/" . plugin_basename(dirname(__FILE__)));
define('WD_PS_URL', plugins_url(plugin_basename(dirname(__FILE__))));
define('WD_WDPS_NAME', plugin_basename(dirname(__FILE__)));
define('WD_PS_PREFIX', 'wdps');
define('WD_PS_NICENAME', __( 'Post Slider', WD_PS_PREFIX ));
define('WD_PS_IS_FREE', 1);
define('WD_PS_VERSION', '1.0.60');


$upload_dir = wp_upload_dir();

$WD_PS_UPLOAD_DIR = str_replace(ABSPATH, '', $upload_dir['basedir']) . '/' . WD_WDPS_NAME;

// Plugin menu.
function wdps_options_panel() {
  $parent_slug = null;
  if( get_option( "wdps_subscribe_done" ) == 1 ) {
    add_menu_page('Post Slider', 'Post Slider', 'manage_options', 'sliders_wdps', 'wdps_sliders', WD_PS_URL . '/images/wd_slider.png');
    $parent_slug = "sliders_wdps";
  }
  $sliders_page = add_submenu_page($parent_slug, __('Sliders','wdps_back'), __('Sliders','wdps_back'), 'manage_options', 'sliders_wdps', 'wdps_sliders');
  add_action('admin_print_styles-' . $sliders_page, 'wdps_styles');
  add_action('admin_print_scripts-' . $sliders_page, 'wdps_scripts');
  $global_options_page = add_submenu_page($parent_slug, __('Global Options', 'wdps_back'), __('Global Options', 'wdps_back'), 'manage_options', 'goptions_wdps', 'wdps_sliders');
  add_action('admin_print_styles-' . $global_options_page, 'wdps_styles');
  add_action('admin_print_scripts-' . $global_options_page, 'wdps_scripts');
  add_submenu_page($parent_slug, __('Get Pro', 'wdps_back'), __('Get Pro', 'wdps_back'), 'manage_options', 'licensing_wdps', 'wdps_licensing');
  $uninstall_page = add_submenu_page($parent_slug, __('Uninstall','wdps_back'), __('Uninstall','wdps_back'), 'manage_options', 'uninstall_wdps', 'wdps_sliders');
  add_action('admin_print_styles-' . $uninstall_page, 'wdps_styles');
  add_action('admin_print_scripts-' . $uninstall_page, 'wdps_scripts');
}
add_action('admin_menu', 'wdps_options_panel');

function wdps_sliders() {
   if (function_exists('current_user_can')) {
    if (!current_user_can('manage_options')) {
      die('Access Denied');
    }
  }
  else {
    die('Access Denied');
  }
  require_once(WD_PS_DIR . '/framework/WDW_PS_Library.php');
  $page = WDW_PS_Library::get('page');

  if (($page != '') && (($page == 'sliders_wdps') || ($page == 'uninstall_wdps') || ($page == 'WDPSShortcode') || ($page == 'goptions_wdps'))) {
    require_once(WD_PS_DIR . '/admin/controllers/WDPSController' . (($page == 'WDPSShortcode') ? $page : ucfirst(strtolower($page))) . '.php');
    $controller_class = 'WDPSController' . ucfirst(strtolower($page));
    $controller = new $controller_class();
    $controller->execute();
  }
}

function wdps_licensing() {
  if (function_exists('current_user_can')) {
    if (!current_user_can('manage_options')) {
      die('Access Denied');
    }
  }
  else {
    die('Access Denied');
  }
  wp_register_style('wdps_licensing', WD_PS_URL . '/licensing/style.css', array(), WD_PS_VERSION);
  wp_print_styles('wdps_licensing');
  wp_register_style('wdps_tables', WD_PS_URL . '/css/wdps_tables.css', array(), WD_PS_VERSION);
  wp_print_styles('wdps_tables');
  require_once(WD_PS_DIR . '/licensing/licensing.php');
}

function wdps_frontend() {
  require_once(WD_PS_DIR . '/framework/WDW_PS_Library.php');
  $page = WDW_PS_Library::get('action');
  if (($page != '') && ($page == 'WDPSShare')) {
    require_once(WD_PS_DIR . '/frontend/controllers/WDPSController' . ucfirst($page) . '.php');
    $controller_class = 'WDPSController' . ucfirst($page);
    $controller = new $controller_class();
    $controller->execute();
  }
}

function wdps_ajax() {
  if (function_exists('current_user_can')) {
    if (!current_user_can('manage_options')) {
      die('Access Denied');
    }
  }
  else {
    die('Access Denied');
  }
  require_once(WD_PS_DIR . '/framework/WDW_PS_Library.php');
  $page = WDW_PS_Library::get('action');
  if ($page != '' && (($page == 'WDPSShortcode') || ($page == 'WDPSPosts') )) {
    require_once(WD_PS_DIR . '/admin/controllers/WDPSController' . ucfirst($page) . '.php');
    $controller_class = 'WDPSController' . ucfirst($page);
    $controller = new $controller_class();
    $controller->execute();
  }
}

function wdps_shortcode($params) {
  $params = shortcode_atts(array('id' => 0), $params);
  ob_start();
  wdps_front_end($params['id']);
  if ( is_admin() ) {
    return ob_get_clean();
  }
  else {
    return str_replace(array("\r\n", "\n", "\r"), '', ob_get_clean());
  }
}
add_shortcode('wdps', 'wdps_shortcode');

function wdp_slider($id) {
  echo wdps_front_end($id);
}

$wdps = 0;
function wdps_front_end($id) {
  require_once(WD_PS_DIR . '/frontend/controllers/WDPSControllerSlider.php');
  $controller = new WDPSControllerSlider();
  global $wdps;
  $controller->execute($id, 1, $wdps);
  $wdps++;
  return;
}

function wdps_media_button($context) {
  global $pagenow;
  if (in_array($pagenow, array('post.php', 'page.php', 'post-new.php', 'post-edit.php'))) {
    $context .= '
      <a onclick="tb_click.call(this); wdps_thickDims(); return false;" href="' . add_query_arg(array('action' => 'WDPSShortcode', 'TB_iframe' => '1'), admin_url('admin-ajax.php')) . '" class="wdps_thickbox button" style="padding-left: 0.4em;" title="Select post slider">
        <span class="wp-media-buttons-icon wdps_media_button_icon" style="vertical-align: text-bottom; background: url(' . WD_PS_URL . '/images/wd_slider.png) no-repeat scroll left top rgba(0, 0, 0, 0);"></span>
        Add Post Slider by 10Web
      </a>';
  }
  return $context;
}
add_filter('media_buttons_context', 'wdps_media_button');
// Add the Slider button to editor.
add_action('wp_ajax_WDPSShortcode', 'wdps_ajax');
add_action('wp_ajax_WDPSPosts', 'wdps_ajax');

function wdps_admin_ajax() {
  ?>
  <script>
    var wdps_thickDims, wdps_tbWidth, wdps_tbHeight;
    wdps_tbWidth = 400;
    wdps_tbHeight = 200;
    wdps_thickDims = function() {
      var tbWindow = jQuery('#TB_window'), H = jQuery(window).height(), W = jQuery(window).width(), w, h;
      w = (wdps_tbWidth && wdps_tbWidth < W - 90) ? wdps_tbWidth : W - 40;
      h = (wdps_tbHeight && wdps_tbHeight < H - 60) ? wdps_tbHeight : H - 40;
      if (tbWindow.size()) {
        tbWindow.width(w).height(h);
        jQuery('#TB_iframeContent').width(w).height(h - 27);
        tbWindow.css({'margin-left': '-' + parseInt((w / 2),10) + 'px'});
        if (typeof document.body.style.maxWidth != 'undefined') {
          tbWindow.css({'top':(H-h)/2,'margin-top':'0'});
        }
      }
    };
  </script>
  <?php
}
add_action('admin_head', 'wdps_admin_ajax');

// Add images to Slider.
add_action('wp_ajax_wdps_UploadHandler', 'wdps_UploadHandler');
add_action('wp_ajax_postaddImage', 'wdps_filemanager_ajax');

// Upload.
function wdps_UploadHandler() {
  require_once(WD_PS_DIR . '/filemanager/UploadHandler.php');
}

function wdps_filemanager_ajax() { 
  if (function_exists('current_user_can')) {
    if (!current_user_can('manage_options')) {
      die('Access Denied');
    }
  }
  else {
    die('Access Denied');
  }
  global $wpdb;
  require_once(WD_PS_DIR . '/framework/WDW_PS_Library.php');
  $page = WDW_PS_Library::get('action');
  if (($page != '') && (($page == 'postaddImage') || ($page == 'addMusic'))) {
    require_once(WD_PS_DIR . '/filemanager/controller.php');
    $controller_class = 'FilemanagerController';
    $controller = new $controller_class();
    $controller->execute();
  }
}
// Slider Widget.
if (class_exists('WP_Widget')) {

  add_action('widgets_init', 'wdps_register_widget');
}

function wdps_register_widget() {
  require_once(WD_PS_DIR . '/admin/controllers/WDPSControllerWidgetSlideshow.php');
  return register_widget("WDPSControllerWidgetSlideshow");
}

// Activate plugin.
function wdps_activate() {
  wdps_install();
}
register_activation_hook(__FILE__, 'wdps_activate');

function wdps_install() {
  $version = get_option("wdps_version");
  $new_version = WD_PS_VERSION;
  if ($version && version_compare($version, $new_version, '<')) {
    require_once WD_PS_DIR . "/sliders-update.php";
    wdps_update($version);
    update_option("wdps_version", $new_version);
  }
  elseif (!$version) {
    require_once WD_PS_DIR . "/sliders-insert.php";
    wdps_insert();
    add_option("wdps_fv022", 1, '', 'no');
    add_option("wdps_version", $new_version, '', 'no');
  }
}
if ((!isset($_GET['action']) || $_GET['action'] != 'deactivate')
  && (!isset($_GET['page']) || $_GET['page'] != 'uninstall_wdps')) {
  add_action('admin_init', 'wdps_install');
}

// Plugin styles.
function wdps_styles() {
  wp_admin_css('thickbox');
  wp_enqueue_style('wdps_tables', WD_PS_URL . '/css/wdps_tables.css', array(), WD_PS_VERSION);
  wp_enqueue_style('wdps_tables_640', WD_PS_URL . '/css/wdps_tables_640.css', array(), WD_PS_VERSION);
  wp_enqueue_style('wdps_tables_320', WD_PS_URL . '/css/wdps_tables_320.css', array(), WD_PS_VERSION);
  require_once(WD_PS_DIR . '/framework/WDW_PS_Library.php');
  $google_fonts = WDW_PS_Library::get_google_fonts();
  for ($i = 0; $i < count($google_fonts); $i = $i + 150) {
    $fonts = array_slice($google_fonts, $i, 150);
    $query = implode("|", str_replace(' ', '+', $fonts));
    $url = 'https://fonts.googleapis.com/css?family=' . $query . '&subset=greek,latin,greek-ext,vietnamese,cyrillic-ext,latin-ext,cyrillic';
    wp_enqueue_style('wdps_googlefonts' . $i, $url, null, null);
  }
  wp_enqueue_style('wdps_deactivate-css',  WD_PS_URL . '/wd/assets/css/deactivate_popup.css', array(), WD_PS_VERSION);
}
// Plugin scripts.
function wdps_scripts() {
  wp_enqueue_media();
  wp_enqueue_script('thickbox');
  wp_enqueue_script('jquery');
  wp_enqueue_script('jquery-ui-tooltip');
  wp_enqueue_script('jquery-ui-sortable');
  wp_enqueue_script('jquery-ui-draggable');
  wp_enqueue_script('wdps_admin', WD_PS_URL . '/js/wdps.js', array(), WD_PS_VERSION);
  wp_localize_script('wdps_admin', 'wdps_objectL10B', array(
    'saved'  => __('Items Succesfully Saved.', 'wdps_back'),
    'wdps_changes_mode_saved'  => __('Changes made in this table should be saved.', 'wdps_back'),
    'show_order'  => __('Show order column', 'wdps_back'),
    'wdps_select_image'  => __('You must select an image file.', 'wdps_back'),
    'wdps_select_audio'  => __('You must select an audio file.', 'wdps_back'),
    'text_layer'  => __('Add Text Layer', 'wdps_back'),
    'wdps_redirection_link'  => __('You can set a redirection link, so that the user will get to the mentioned location upon hitting the slide. Use http:// and https:// for external links.', 'wdps_back'),
    'link_slide'  => __('Link the slide to:', 'wdps_back'),
    'published'  => __('Published:', 'wdps_back'),
    'add_post'  => __('Add Post', 'wdps_back'),
    'edit_post'  => __('Edit Post', 'wdps_back'),
    'add_hotspot'  => __('Add Hotspot Layer', 'wdps_back'),
    'add_social_buttons'  => __('Add Social Button Layer', 'wdps_back'),
    'none'  => __('None', 'wdps_back'),
    'bounce'  => __('Bounce', 'wdps_back'),
    'flash'  => __('Flash', 'wdps_back'),
    'pulse'  => __('Pulse', 'wdps_back'),
    'rubberBand'  => __('RubberBand', 'wdps_back'),
    'shake'  => __('Shake', 'wdps_back'),
    'swing'  => __('Swing', 'wdps_back'),
    'tada'  => __('Tada', 'wdps_back'),
    'wobble'  => __('Wobble', 'wdps_back'),
    'hinge'  => __('Hinge', 'wdps_back'),
    'lightSpeedIn'  => __('LightSpeedIn', 'wdps_back'),
    'rollIn'  => __('RollIn', 'wdps_back'),
    'bounceIn'  => __('BounceIn', 'wdps_back'),
    'bounceInDown'  => __('BounceInDown', 'wdps_back'),
    'bounceInLeft'  => __('BounceInLeft', 'wdps_back'),
    'bounceInRight'  => __('BounceInRight', 'wdps_back'),
    'bounceInUp'  => __('BounceInUp', 'wdps_back'),
    'fadeIn'  => __('FadeIn', 'wdps_back'),
    'fadeInDown'  => __('FadeInDown', 'wdps_back'),
    'fadeInDownBig'  => __('FadeInDownBig', 'wdps_back'),
    'fadeInLeft'  => __('FadeInLeft', 'wdps_back'),
    'fadeInLeftBig'  => __('FadeInLeftBig', 'wdps_back'),
    'fadeInRight'  => __('FadeInRight', 'wdps_back'),
    'fadeInRightBig'  => __('FadeInRightBig', 'wdps_back'),
    'fadeInUp'  => __('FadeInUp', 'wdps_back'),
    'fadeInUpBig'  => __('FadeInUpBig', 'wdps_back'),
    'flip'  => __('Flip', 'wdps_back'),
    'flipInX'  => __('FlipInX', 'wdps_back'),
    'flipInY'  => __('FlipInY', 'wdps_back'),
    'rotateIn'  => __('RotateIn', 'wdps_back'),
    'rotateInDownLeft'  => __('RotateInDownLeft', 'wdps_back'),
    'rotateInDownRight'  => __('RotateInDownRight', 'wdps_back'),
    'rotateInUpLeft'  => __('RotateInUpLeft', 'wdps_back'),
    'rotateInUpRight'  => __('RotateInUpRight', 'wdps_back'),
    'zoomIn'  => __('ZoomIn', 'wdps_back'),
    'zoomInDown'  => __('ZoomInDown', 'wdps_back'),
    'zoomInLeft'  => __('ZoomInLeft', 'wdps_back'),
    'zoomInRight'  => __('ZoomInRight', 'wdps_back'),
    'zoomInUp'  => __('ZoomInUp', 'wdps_back'),
    'lighter'  => __('Lighter', 'wdps_back'),
    'normal'  => __('Normal', 'wdps_back'),
    'bold'  => __('Bold', 'wdps_back'),
    'solid'  => __('Solid', 'wdps_back'),
    'dotted'  => __('Dotted', 'wdps_back'),
    'dashed'  => __('Dashed', 'wdps_back'),
    'wdps_double'  => __('Double', 'wdps_back'),
    'groove'  => __('Groove', 'wdps_back'),
    'ridge'  => __('Ridge', 'wdps_back'),
    'inset'  => __('Inset', 'wdps_back'),
    'outset'  => __('Outset', 'wdps_back'),
    'facebook'  => __('Facebook', 'wdps_back'),
    'google_plus'  => __('Google+', 'wdps_back'),
    'twitter'  => __('Twitter', 'wdps_back'),
    'pinterest'  => __('Pinterest', 'wdps_back'),
    'tumblr'  => __('Tumblr', 'wdps_back'),
    'top'  => __('Top', 'wdps_back'),
    'bottom'  => __('Bottom', 'wdps_back'),
    'left'  => __('Left', 'wdps_back'),
    'right'  => __('Right', 'wdps_back'),
    'wdps_drag_re_order'  => __('Drag to re-order', 'wdps_back'),
    'wdps_layer_title'  => __('Layer title', 'wdps_back'),
    'wdps_delete_layer'  => __('Are you sure you want to delete this layer ?', 'wdps_back'),
    'wdps_duplicate_layer'  => __('Duplicate layer', 'wdps_back'),
    'z_index'  => __('z-index', 'wdps_back'),
    'text'  => __('Text:', 'wdps_back'),
    'sample_text'  => __('Sample text', 'wdps_back'),
    'dimensions'  => __('Dimensions:', 'wdps_back'),
    'wdps_leave_blank'  => __('Leave blank to keep the initial width and height.', 'wdps_back'),
    'wdps_edit_image'  => __('Edit Image', 'wdps_back'),
    'wdps_alt'  => __('Alt:', 'wdps_back'),
    'wdps_set_HTML_attribute_specified'  => __('Set the HTML attribute specified in the IMG tag.', 'wdps_back'),
    'wdps_link'  => __('Link:', 'wdps_back'),
    'wdps_open_new_window'  => __('Open in a new window', 'wdps_back'),
    'wdps_use_links'  => __('Use http:// and https:// for external links.', 'wdps_back'),
    'position'  => __('Position:', 'wdps_back'),
    'wdps_in_addition'  => __('In addition you can drag and drop the layer to a desired position.', 'wdps_back'),
    'published'  => __('Published:', 'wdps_back'),
    'yes'  => __('Yes', 'wdps_back'),
    'no'  => __('No', 'wdps_back'),
    'color'  => __('Color:', 'wdps_back'),
    'size'  => __('Size:', 'wdps_back'),
    'font_family'  => __('Font family:', 'wdps_back'),
    'font_weight'  => __('Font weight:', 'wdps_back'),
    'padding'  => __('Padding:', 'wdps_back'),
    'use_css_type_value'  => __('Use CSS type values.', 'wdps_back'),
    'layer_characters_div' => __('This will limit the number of characters for post content displayed as a text layer.', 'wdps_back'),
    'background_color'  => __('Background Color:', 'wdps_back'),
    'transparent'  => __('Transparent:', 'wdps_back'),
    'wdps_value_must'  => __('Value must be between 0 to 100.', 'wdps_back'),
    'radius'  => __('Radius:', 'wdps_back'),
    'shadow'  => __('Shadow:', 'wdps_back'),
    'text_layer_character_limit'  => __('Text layer character limit:', 'wdps_back'),
    'scale'  => __('Scale:', 'wdps_back'),
    'wdps_set_width_height'  => __('Set width and height of the image.', 'wdps_back'),
    'social_button'  => __('Social button:', 'wdps_back'),
    'effect_in'  => __('Effect in:', 'wdps_back'),
    'start'  => __('Start', 'wdps_back'),
    'effect'  => __('Effect', 'wdps_back'),
    'duration'  => __('Duration', 'wdps_back'),
    'some_effects'  => __('Some effects are disabled in free version.', 'wdps_back'),
    'effect_out'  => __('Effect out:', 'wdps_back'),
    'hotspot_text_position'  => __('Hotspot text position:', 'wdps_back'),
    'hotspot_width'  => __('Hotspot Width:', 'wdps_back'),
    'hotspot_background_color'  => __('Hotspot Background Color:', 'wdps_back'),
    'hotspot_border'  => __('Hotspot Border:', 'wdps_back'),
    'hotspot_radius'  => __('Hotspot Radius:', 'wdps_back'),
    'add_image_layer'  => __('Add Image Layer', 'wdps_back'),
    'duplicate_slide'  => __('Duplicate slide', 'wdps_back'),
    'delete_slide'  => __('Delete slide', 'wdps_back'),
    'remove'  => __('Delete', 'wdps_back'),
    'border'  => __('Border:', 'wdps_back'),
    'break_word'  => __('Break-word:', 'wdps_back'),
    'hover_color'  => __('Hover color:', 'wdps_back'),
    'wdps_default'  => __('Default', 'wdps_back'),
    'google_fonts'  => __('Google fonts', 'wdps_back'),
    'duplicate_message' => __('Do you want to duplicate selected items?', 'wdps_back'),
    'delete_message' => __('Do you want to delete selected items?', 'wdps_back'),
    'disabled_free_version' => __('This functionality is disabled in free version.', 'wdps_back'),
    'choose_file' => __('Choose file.', 'wdps_back'),
    'message_upload' => __('Sorry, you are not allowed to upload this type of file.', 'wdps_back'),
    'message_thumbnail' => __('The thumbnail size must be between 0 to 1.', 'wdps_back'),
    'message_select ' => __('You must select at least one item.', 'wdps_back'),
    'remove_slide' => __('Do you want to delete slide?', 'wdps_back'),
    'wdps_alignment' => __('Fixed step (left, center, right)', 'wdps_back'),
    'text_align' => __('Text alignment:', 'wdps_back'),
    'wdps_center' => __('Center', 'wdps_back'),
    'wdps_left' => __('Left', 'wdps_back'),
    'wdps_right' => __('Right', 'wdps_back'),
    'wdps_remove_shortcode' => __('Remove shortcode:', 'wdps_back'),
    'reset_confirm' => __('Are you sure you want to reset the slider?', 'wdps_back'),
    'name' => __('Name', 'wdps_back'),
    'wdps_iteration' => __('Iteration', 'wdps_back'),
    'iteration_title' => __('0 for play infinte times','wdps_back'), 
    'lightSpeedOut'  => __('LightSpeedOut', 'wdps_back'),
    'rollOut'  => __('RollOut', 'wdps_back'),
    'bounceOut'  => __('BounceOut', 'wdps_back'),
    'bounceOutDown'  => __('BounceOutDown', 'wdps_back'),
    'bounceOutLeft'  => __('BounceOutLeft', 'wdps_back'),
    'bounceOutRight'  => __('BounceOutRight', 'wdps_back'),
    'bounceOutUp'  => __('BounceOutUp', 'wdps_back'),
    'fadeOut'  => __('FadeOut', 'wdps_back'),
    'fadeOutDown'  => __('FadeOutDown', 'wdps_back'),
    'fadeOutDownBig'  => __('FadeOutDownBig', 'wdps_back'),
    'fadeOutLeft'  => __('FadeOutLeft', 'wdps_back'),
    'fadeOutLeftBig'  => __('FadeOutLeftBig', 'wdps_back'),
    'fadeOutRight'  => __('FadeOutRight', 'wdps_back'),
    'fadeOutRightBig'  => __('FadeOutRightBig', 'wdps_back'),
    'fadeOutUp'  => __('FadeOutUp', 'wdps_back'),
    'fadeOutUpBig'  => __('FadeOutUpBig', 'wdps_back'),
    'flipOutX'  => __('FlipOutX', 'wdps_back'),
    'flipOutY'  => __('FlipOutY', 'wdps_back'),
    'rotateOut'  => __('RotateOut', 'wdps_back'),
    'rotateOutDownLeft'  => __('RotateOutDownLeft', 'wdps_back'),
    'rotateOutDownRight'  => __('RotateOutDownRight', 'wdps_back'),
    'rotateOutUpLeft'  => __('RotateOutUpLeft', 'wdps_back'),
    'rotateOutUpRight'  => __('RotateOutUpRight', 'wdps_back'),
    'zoomOut'  => __('ZoomOut', 'wdps_back'),
    'zoomOutDown'  => __('ZoomOutDown', 'wdps_back'),
    'zoomOutLeft'  => __('ZoomOutLeft', 'wdps_back'),
    'zoomOutRight'  => __('ZoomOutRight', 'wdps_back'),
    'zoomOutUp'  => __('ZoomOutUp', 'wdps_back'),
    'tada'  => __('Tada', 'wdps_back'),
    'bounceOutDown'  => __('BounceOutDown', 'wdps_back'),
    'fadeOutLeft'  => __('FadeOutLeft', 'wdps_back'),
    'wdps_min_size'  => __('Minimal size must be less than the actual size.', 'wdps_back'),
    'please_selcet_valid_audio_file'  => __('Please selcet valid audio file.', 'wdps_back'),
  ));
  wp_enqueue_script('jscolor', WD_PS_URL . '/js/jscolor/jscolor.js', array(), '1.3.9');
  wp_enqueue_style('wdps_font-awesome', WD_PS_URL . '/css/font-awesome/font-awesome.css', array(), '4.6.3');
  wp_enqueue_style('wdps_effects', WD_PS_URL . '/css/wdps_effects.css', array(), WD_PS_VERSION);
  wp_enqueue_style('wdps_tooltip', WD_PS_URL . '/css/jquery-ui-1.10.3.custom.css', array(), WD_PS_VERSION);
  require_once(WD_PS_DIR . '/framework/WDW_PS_Library.php');
  wp_localize_script('wdps_admin', 'wdps_objectGGF', WDW_PS_Library::get_google_fonts());
  wp_localize_script('wdps_admin', 'wdps_objectFGF', WDW_PS_Library::get_font_families());

  wp_enqueue_script('wdps-deactivate-popup', WD_PS_URL.'/wd/assets/js/deactivate_popup.js', array(), WD_PS_VERSION, true );
  $admin_data = wp_get_current_user();

  wp_localize_script( 'wdps-deactivate-popup', 'wdpsWDDeactivateVars', array(
    "prefix" => 'wdps',
    "deactivate_class" =>  'wdps_deactivate_link',
    "email" => $admin_data->data->user_email,
    "plugin_wd_url" => "https://10web.io/plugins/wordpress-post-slider/",
  ));
}

function wdps_front_end_scripts() {
  global $wpdb;
  /*wp_enqueue_script('jquery');*/
  $rows = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "wdpslayer ORDER BY `depth` ASC");
  $font_array = array();
  foreach ($rows as $row) {
    if (isset($row->google_fonts) && ($row->google_fonts == 1) && ($row->ffamily != "") && !in_array($row->ffamily, $font_array)) {
      $font_array[] = $row->ffamily;
	  }
  }
  $query = implode("|", $font_array);
  if ($query != '') {
    $url = 'https://fonts.googleapis.com/css?family=' . $query . '&subset=greek,latin,greek-ext,vietnamese,cyrillic-ext,latin-ext,cyrillic';
  }
  $wdps_array_glogal_options = json_decode(get_option("wdps_array_glogal_options"));
  $wdps_register_scripts = (isset($wdps_array_glogal_options)) ? $wdps_array_glogal_options->wdps_register_scripts : 0;
  if (!$wdps_register_scripts) {
    wp_enqueue_script('wdps_jquery_mobile', WD_PS_URL . '/js/jquery.mobile.js', array('jquery'), WD_PS_VERSION);
    wp_enqueue_style('wdps_frontend', WD_PS_URL . '/css/wdps_frontend.css', array(), WD_PS_VERSION);
    wp_enqueue_script('wdps_frontend', WD_PS_URL . '/js/wdps_frontend.js', array('jquery'), WD_PS_VERSION);
    wp_enqueue_style('wdps_effects', WD_PS_URL . '/css/wdps_effects.css', array(), WD_PS_VERSION);

    wp_enqueue_style('wdps_font-awesome', WD_PS_URL . '/css/font-awesome/font-awesome.css', array(), '4.6.3');
    if ($query != '') {
      wp_enqueue_style('wdps_googlefonts', $url, null, null);
    }
  }
  else {
    wp_register_script('wdps_jquery_mobile', WD_PS_URL . '/js/jquery.mobile.js', array('jquery'), WD_PS_VERSION);
    wp_register_style('wdps_frontend', WD_PS_URL . '/css/wdps_frontend.css', array(), WD_PS_VERSION);
    wp_register_script('wdps_frontend', WD_PS_URL . '/js/wdps_frontend.js', array('jquery'), WD_PS_VERSION);
    wp_register_style('wdps_effects', WD_PS_URL . '/css/wdps_effects.css', array(), WD_PS_VERSION);

    wp_register_style('wdps_font-awesome', WD_PS_URL . '/css/font-awesome/font-awesome.css', array(), '4.6.3');
    if ($query != '') {
      wp_register_style('wdps_googlefonts', $url, null, null);
    }
  }
}
add_action('wp_enqueue_scripts', 'wdps_front_end_scripts');

// Languages localization.
function wdps_language_load() {
  load_plugin_textdomain('wdps', FALSE, basename(dirname(__FILE__)) . '/languages');
  load_plugin_textdomain('wdps_back', FALSE, basename(dirname(__FILE__)) . '/languages/backend');
}
add_action('init', 'wdps_language_load');

function wdps_overview() {
  if (is_admin() && !isset($_REQUEST['ajax'])) {
    if (!class_exists("TenWebLib")) {
      $plugin_dir = apply_filters('tenweb_free_users_lib_path', array('version' => '1.1.1', 'path' => WD_PS_DIR));
      require_once($plugin_dir['path'] . '/wd/start.php');
    }
    global $wdps_options;
    $wdps_options = array(
      "prefix" => "wdps",
      "wd_plugin_id" => 135,
      "plugin_id" => 99,
      "plugin_title" => "Post Slider by 10Web",
      "plugin_wordpress_slug" => "post-slider-wd",
      "plugin_dir" => WD_PS_DIR,
      "plugin_main_file" => __FILE__,
      "description" => __('Post Slider by 10Web is designed to show off your selected posts of your website using in a slider.', 'wdps'),
      "plugin_features" => array(
        0 => array(
          "title" => __("Responsive", "wdps"),
          "description" => __("Post Slider by 10Web is a stunning responsive plugin, bringing the best experience on all mobile devices. Post slides look crisp and sharp on any screen variations.", "wdps"),
        ),
        1 => array(
          "title" => __("Touch Swipe Navigation", "wdps"),
          "description" => __("Stay cool with your finger as you swipe your slides across any device and view the stunning color pallet of your slides.", "wdps"),
        ),
        2 => array(
          "title" => __("Layers with Animations and Transition Effects", "wdps"),
          "description" => __("The plugin includes more than 30 animations and transition effects for post-slides, bringing energetic mood to your posts.", "wdps"),
        ),
        3 => array(
          "title" => __("Fully Customizable Slider", "wdps"),
          "description" => __("Set slider settings, choose colors and fonts, add custom CSS, choose navigation buttons, transaction effects and much more.", "wdps"),
        ),
        4 => array(
          "title" => __("Navigation Button and Bullets Variety", "wdps"),
          "description" => __("Chose navigation button, bullets and color. If looking for something different upload your own option.", "wdps"),
        )
      ),
      "user_guide" => array(
        0 => array(
          "main_title" => __("Installing the Post Slider by 10Web", "wdps"),
          "url" => "https://help.10web.io/hc/en-us/articles/360018235711-Creating-Posts-Sliders",
          "titles" => array()
        ),
        1 => array(
          "main_title" => __("Creating Posts Sliders", "wdps"),
          "url" => "https://help.10web.io/hc/en-us/articles/360018235711-Creating-Posts-Sliders",
          "titles" => array(
            array(
              "title" => __("Creating Static Posts Slider", "wdps"),
              "url" => "https://help.10web.io/hc/en-us/articles/360018235711-Creating-Posts-Sliders",
            ),
            array(
              "title" => __("Creating Dynamic Posts Slider", "wdps"),
              "url" => "https://help.10web.io/hc/en-us/articles/360018235711-Creating-Posts-Sliders",
            ),
          )
        ),
        2 => array(
          "main_title" => __("Adding Layers to Sliders", "wdps"),
          "url" => "https://help.10web.io/hc/en-us/articles/360018235771-Adding-Layers-to-Post-Sliders",
          "titles" => array(
            array(
              "title" => __("Text Layer", "wdps"),
              "url" => "https://help.10web.io/hc/en-us/articles/360018235771-Adding-Layers-to-Post-Sliders",
            ),
            array(
              "title" => __("Image Layer", "wdps"),
              "url" => "https://help.10web.io/hc/en-us/articles/360018235771-Adding-Layers-to-Post-Sliders",
            ),
            array(
              "title" => __("Social Button Layer", "wdps"),
              "url" => "https://help.10web.io/hc/en-us/articles/360018235771-Adding-Layers-to-Post-Sliders",
            ),
            array(
              "title" => __("HotSpot Layer", "wdps"),
              "url" => "https://help.10web.io/hc/en-us/articles/360018235771-Adding-Layers-to-Post-Sliders",
            ),
          )
        ),
        3 => array(
          "main_title" => __("Post Slider Settings", "wdps"),
          "url" => "https://help.10web.io/hc/en-us/articles/360017961552-Post-Slider-WD-Settings",
          "titles" => array(
            array(
              "title" => __("Global Settings", "wdps"),
              "url" => "https://help.10web.io/hc/en-us/articles/360017961552-Post-Slider-WD-Settings",
            ),
            array(
              "title" => __("Carousel", "wdps"),
              "url" => "https://help.10web.io/hc/en-us/articles/360017961552-Post-Slider-WD-Settings",
            ),
            array(
              "title" => __("Navigation", "wdps"),
              "url" => "https://help.10web.io/hc/en-us/articles/360017961552-Post-Slider-WD-Settings",
            ),
            array(
              "title" => __("Bullets", "wdps"),
              "url" => "https://help.10web.io/hc/en-us/articles/360017961552-Post-Slider-WD-Settings",
            ),
            array(
              "title" => __("Filmstrip", "wdps"),
              "url" => "https://help.10web.io/hc/en-us/articles/360017961552-Post-Slider-WD-Settings",
            ),
            array(
              "title" => __("Timer Bar", "wdps"),
              "url" => "https://help.10web.io/hc/en-us/articles/360017961552-Post-Slider-WD-Settings",
            ),
            array(
              "title" => __("CSS", "wdps"),
              "url" => "https://help.10web.io/hc/en-us/articles/360017961552-Post-Slider-WD-Settings",
            ),
          )
        ),
        4 => array(
          "main_title" => __("Inserting Post Slider", "wdps"),
          "url" => "https://help.10web.io/hc/en-us/articles/360017961652-Publishing-Post-Slider-WD",
          "titles" => array()
        ),
      ),
      "video_youtube_id" => "",
      "plugin_wd_url" => "https://10web.io/plugins/wordpress-post-slider/",
      "plugin_wd_demo_link" => "https://demo.10web.io/post-slider/",
      "plugin_wd_addons_link" => "",
      "after_subscribe" => admin_url('admin.php?page=sliders_wdps'),
      "plugin_wizard_link" => '',
      "plugin_menu_title" => "Post Slider by 10Web",
      "plugin_menu_icon" => WD_PS_URL . '/images/wd_slider.png',
      "deactivate" => true,
      "subscribe" => true,
      "custom_post" => 'sliders_wdps',
      "menu_position" => null,
      "display_overview" => false,
    );

    ten_web_lib_init($wdps_options);
  }
}
add_action('init', 'wdps_overview');

function wdps_add_plugin_meta_links($meta_fields, $file) {
  if ( plugin_basename(__FILE__) == $file ) {
    $plugin_url = "https://wordpress.org/support/plugin/post-slider-wd";
    $prefix = WD_PS_PREFIX;
    $meta_fields[] = "<a href='" . $plugin_url . "' target='_blank'>" . __('Support Forum', $prefix) . "</a>";
    $meta_fields[] = "<a href='" . $plugin_url . "/reviews#new-post' target='_blank' title='" . __('Rate', $prefix) . "'>
            <i class='wdi-rate-stars'>"
      . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
      . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
      . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
      . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
      . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
      . "</i></a>";

    $stars_color = "#ffb900";

    echo "<style>"
      . ".wdi-rate-stars{display:inline-block;color:" . $stars_color . ";position:relative;top:3px;}"
      . ".wdi-rate-stars svg{fill:" . $stars_color . ";}"
      . ".wdi-rate-stars svg:hover{fill:" . $stars_color . "}"
      . ".wdi-rate-stars svg:hover ~ svg{fill:none;}"
      . "</style>";
  }

  return $meta_fields;
}
add_filter("plugin_row_meta", 'wdps_add_plugin_meta_links', 10, 2);

add_filter('tw_get_plugin_blocks', 'wdps_register_plugin_block');
function wdps_register_plugin_block($blocks) {
  require_once(WD_PS_DIR . '/framework/WDW_PS_Library.php');
  $plugin_name = 'Post-Slider-WD';
  $data = WDW_PS_Library::get_shortcode_data();
  $blocks['tw/post-slider-wd'] = array(
    'title' => "Post-Slider-WD",
    'titleSelect' => sprintf(__('Select %s', WD_PS_PREFIX), $plugin_name),
    'iconUrl' => WD_PS_URL . '/images/wt-gb/icon.svg',
    'iconSvg' => array('width' => 20, 'height' => 20, 'src' => WD_PS_URL . '/images/wt-gb/icon_grey.svg'),
    'isPopup' => false,
    'data' => $data,
  );
  return $blocks;
}

// Register block editor assets for Gutenberg.
function wdps_register_block_editor_assets($assets) {
  $version = '2.0.3';
  $js_path = WD_PS_URL . '/js/tw-gb/block.js';
  $css_path = WD_PS_URL . '/css/tw-gb/block.css';
  if (!isset($assets['version']) || version_compare($assets['version'], $version) === -1) {
    $assets['version'] = $version;
    $assets['js_path'] = $js_path;
    $assets['css_path'] = $css_path;
  }
  return $assets;
}
add_filter('tw_get_block_editor_assets', 'wdps_register_block_editor_assets');

//Enqueue block editor assets for Gutenberg.
function wdps_enqueue_block_editor_assets() {

  // Remove previously registered or enqueued versions
  $wp_scripts = wp_scripts();
  foreach ($wp_scripts->registered as $key => $value) {
    // Check for an older versions with prefix.
    if (strpos($key, 'tw-gb-block') > 0) {
      wp_deregister_script( $key );
      wp_deregister_style( $key );
    }
  }
  $blocks = apply_filters('tw_get_plugin_blocks', array());
  // Get the last version from all 10Web plugins.
  $assets = apply_filters('tw_get_block_editor_assets', array());
  // Not performing unregister or unenqueue as in old versions all are with prefixes.
  wp_enqueue_script('tw-gb-block', $assets['js_path'], array( 'wp-blocks', 'wp-element' ), $assets['version']);
  wp_localize_script('tw-gb-block', 'tw_obj_translate', array(
    'nothing_selected' => __('Nothing selected.', WD_PS_PREFIX),
    'empty_item' => __('- Select -', WD_PS_PREFIX),
    'blocks' => json_encode($blocks)
  ));
  wp_enqueue_style('tw-gb-block', $assets['css_path'], array( 'wp-edit-blocks' ), $assets['version']);
}
add_action('enqueue_block_editor_assets', 'wdps_enqueue_block_editor_assets');

/**
 * Show 10Web plugin's install/activate banner.
 */
if ( !class_exists ( 'TWBanner' ) ) {
  require_once( WD_PS_DIR . '/banner_class.php' );
}
if ( WD_PS_IS_FREE ) {
  $tw_banner_params = array(
    'menu_postfix' => '_' . WD_PS_PREFIX, // To display on only current plugin pages.
    'prefix' => WD_PS_PREFIX, // Current plugin prefix.
    'logo' => '/images/wt-gb/icon.svg', // Current plugin logo relative URL.
    'plugin_slug' => 'post-slider-wd', // Current plugin slug.
    'plugin_url' => WD_PS_URL, // Current plugin URL.
    'plugin_id' => 99, // Current plugin id.
    'text' => sprintf(__("%s Post Slider advises:%s %sUse Image Optimizer service to optimize your images quickly and easily.%s", WD_PS_PREFIX), '<span>','</span>', '<span>','</span>'), // Banner text.
    'slug' => '10web-manager', // Plugin slug to be installed.
    'mu_plugin_slug' => '10web-manager', // Must use plugin slug.
    'base_php' => '10web-manager.php', // Plugin base php filename to be installed.
    'page_url' => admin_url('admin.php?page=tenweb_menu'), // Redirect to URL after activating the plugin.
  );
  new TWBanner($tw_banner_params);
}

/**
 * Register admin styles.
 */
function wdps_register_admin_scripts() {
  // Roboto font for top bar.
  wp_register_style('wdps-roboto', 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700');
  wp_register_style('wdps-pricing', WD_PS_URL . '/css/pricing.css', array(), WD_PS_VERSION);
}
add_action('admin_enqueue_scripts', 'wdps_register_admin_scripts');

require_once(WD_PS_DIR . '/framework/WDW_PS_Library.php');
add_action('admin_notices', array( 'WDW_PS_Library', 'topbar' ), 11);

// Register widget for Elementor builder.
add_action('elementor/widgets/widgets_registered', 'wdps_register_elementor_widget');
// Register 10Web category for Elementor widget if 10Web builder doesn't installed.
add_action('elementor/elements/categories_registered', 'wdps_register_widget_category', 1, 1);
//fires after elementor editor styles and scripts are enqueued.
add_action('elementor/editor/after_enqueue_styles', 'wdps_enqueue_editor_styles', 1);
add_action('elementor/editor/after_enqueue_scripts', 'wdps_enqueue_scripts');

/**
* Register widget for Elementor builder.
*/
function wdps_register_elementor_widget() {
	if ( defined('ELEMENTOR_PATH') && class_exists('Elementor\Widget_Base') ) {
	  require_once WD_PS_DIR . '/admin/controllers/elementorWidget.php';
	}
}

/**
* Register 10Web category for Elementor widget if 10Web builder doesn't installed.
*
* @param $elements_manager
*/
function wdps_register_widget_category( $elements_manager ) {
	$elements_manager->add_category('tenweb-plugins-widgets', array(
	  'title' => __('10WEB Plugins', 'tenweb-builder'),
	  'icon' => 'fa fa-plug',
	));
}
function wdps_enqueue_editor_styles() {
	if ( !defined('TWBB_VERSION') ) {
		wp_enqueue_style('twbb-fonts', WD_PS_URL . '/css/elementor/fonts.css', array(), '1.2.13');
	}
}
function wdps_enqueue_scripts(){
	wp_enqueue_script('wdps_widget_js', WD_PS_URL . '/js/elementor/script.js', array( 'jquery' ), '1.0.0');
}