<?PHP

class WDPSViewWDPSPosts {
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
  public function display() {
    $slide_id = WDW_PS_Library::get('slide_id', 0);
    if ($slide_id) {
      $single = 1;
    }
    else {
      $single = 0;
    }
    $slider_id = WDW_PS_Library::get('slider_id', 0);
    $slider_row = $this->model->get_slider_row_data($slider_id);
    $search_value = ((isset($_POST['search_value'])) ? esc_html(stripslashes($_POST['search_value'])) : '');
    $category_id = ((isset($_POST['category_id'])) ? esc_html(stripslashes($_POST['category_id'])) : '');
    $post_t = ((isset($_POST['archive-dropdown'])) ? esc_html(stripslashes($_POST['archive-dropdown'])) : 'post');
    $asc_or_desc = ((isset($_POST['asc_or_desc'])) ? esc_html(stripslashes($_POST['asc_or_desc'])) : 'ASC');
    $order_by = (isset($_POST['order_by']) ? esc_html(stripslashes($_POST['order_by'])) : 'date');
    $count = (isset($_GET['count']) ? esc_html(stripslashes($_GET['count'])) : 0);
    $order_class = 'manage-column column-title sorted ' . $asc_or_desc;
    $datas = $this->model->get_rows_data();
    $featured_image = $datas[5];
    $rows_data = $datas[0];
    $json = $datas[3];
    $k = array();
    foreach ($json as $keys => $jsonik) {
      array_push($k, $keys);
    }
    $post_feilds_name = $datas[4];
    $page_limit = $datas[2];
    $args = array(
      'public'=> true,
      'publicly_queryable' => true,
      'show_ui' => true,
      '_builtin' => false,
    );
    $post_types = get_post_types($args, 'names', 'or');
    $header_title = __('Posts', 'wdps_back');

    wp_print_scripts('jquery');

    // wp_print_styles('admin-bar');
    wp_print_styles('wp-admin');
    wp_print_styles('dashicons');
    wp_print_styles('buttons');
    wp_print_styles('wp-auth-check');
    if (get_option("wdps_fv022")) {
      $fv = TRUE;
      $fv_class = 'spider_free_version_label';
      $fv_disabled = 'disabled="disabled"';
    }
    else {
      $fv = FALSE;
      $fv_class = '';
      $fv_disabled = '';
    }
    ?>
    <link media="all" type="text/css" href="<?php echo WD_PS_URL . '/css/wdps_tables.css?ver=' . WD_PS_VERSION; ?>" rel="stylesheet" />
    <link media="all" type="text/css" href="<?php echo WD_PS_URL . '/css/wdps_tables_640.css?ver=' . WD_PS_VERSION; ?>" rel="stylesheet" />
    <link media="all" type="text/css" href="<?php echo WD_PS_URL . '/css/wdps_tables_320.css?ver=' . WD_PS_VERSION; ?>" rel="stylesheet" />
    <script src="<?php echo WD_PS_URL . '/js/wdps.js?ver=' . WD_PS_VERSION; ?>" type="text/javascript"></script>
    <form class="wrap wp-core-ui wdps_form" id="posts_form" method="post" action="<?php echo add_query_arg(array('action' => 'WDPSPosts', 'width' => '700', 'height' => '550', 'TB_iframe' => '1'), admin_url('admin-ajax.php')); ?>" style="width: 99%; margin: 0 auto;">
      <h2 style="float: left;"><?php echo $header_title; ?></h2>
      <input type="button" class="action_buttons add_images" title="<?php _e('Add Post', 'wdps_back'); ?>" onclick="wdps_add_post(jQuery('#ids_string').val(), <?php echo $count; ?>);
                                                                            window.parent.tb_remove();" style="float: right; margin: 9px 0;" value="<?php _e('Add to slider', 'wdps_back'); ?>" />
      <div style="float: left;">
        <?php
        if ($featured_image) {
          $featured_image_message = __('You can include only published posts with featured image. If you want to include posts without featured image into the list, disable Featured image option in Settings->Global Options.', 'wdps_back');
          echo WDW_PS_Library::message($featured_image_message, 'wd_updated featured_image_message');
        }
        ?>
      </div>
      <div class="tablenav top wdps_select_search">
        <label><?php _e('Type:', 'wdps_back'); ?> </label> 
        <select name="archive-dropdown" id="archive-dropdown">
          <?php
          foreach ($post_types as $post_type) {
            if ($post_type != 'page' && $post_type != 'attachment' && $post_type != 'nav_menu_item' && $post_type != 'revision') {
              ?>
          <option <?php echo (($post_type == $post_t) ? 'selected="selected"' : ''); ?>>
            <p><?php echo $post_type; ?></p>
          </option> 
              <?php            
            }
          }
          ?>
        </select>
      </div>
      <?php
      $args = array(
        'object_type' => array($post_t)
      );
      $taxonomies = get_taxonomies($args, 'names', 'and');
      if ($taxonomies) {
        $argss = array(
          'orderby' => 'id', 
          'order' => 'ASC',
          'hide_empty' => false,
        );
        $terms = get_terms($taxonomies, $argss);
        ?>
      <fieldset class="wdps_taxonomies">
        <legend><?php _e('Taxonomies', 'wdps_back'); ?></legend>
        <?php
        foreach ($taxonomies as $taxonomie) {
          if (get_terms($taxonomie, $argss)) {
            $termsss = ((isset($_POST['taxonomies_'.$taxonomie]) && esc_html(stripslashes($_POST['taxonomies_'.$taxonomie])) != -1) ? esc_html(stripslashes($_POST['taxonomies_'.$taxonomie])) : __('-all-', 'wdps_back'));
            ?>
        <select name="taxonomies_<?php echo $taxonomie; ?>" id="taxonomies_<?php echo $taxonomie; ?>">
          <option value=""><p><?php echo __('Select', 'wdps_back') . ' ' . $taxonomie; ?></p></option>
          <?php
          foreach ($terms as $term) {
            if ($taxonomie == $term->taxonomy) {
             ?>
          <option <?php echo (($termsss == $term->slug ) ? 'selected="selected"' : ''); ?> value="<?php echo $term->slug; ?>">
            <?php echo $term->name; ?>
          </option>
            <?php 
            }
          }
          ?>
        </select>
          <?php
          }
        }
        ?>
      </fieldset>
        <?php
      }
      ?>
      <div class="tablenav top">
        <?php
        WDW_PS_Library::search(__('Title', 'wdps_back'), $search_value, 'posts_form');
        WDW_PS_Library::html_page_nav($datas[1], $page_limit, 'posts_form');
        ?>
      </div>
      <table class="wp-list-table widefat fixed pages">
        <thead>
          <th class="manage-column column-cb check-column table_small_col"><input id="check_all" type="checkbox" style="margin:0;" /></th>
          <th class="table_big_col mobile_width"><?php _e('Image', 'wdps_back'); ?></th>
          <th class="sortable <?php if ($order_by == 'title') {echo $order_class;} ?>">
            <a onclick="spider_set_input_value('order_by', 'title');
                        spider_set_input_value('asc_or_desc', '<?php echo ((isset($_POST['asc_or_desc']) && isset($_POST['order_by']) && (esc_html(stripslashes($_POST['order_by'])) == 'title') && esc_html(stripslashes($_POST['asc_or_desc'])) == 'asc') ? 'desc' : 'asc'); ?>');
                        spider_form_submit(event, 'posts_form')" href="">
              <span><?php _e('Title', 'wdps_back'); ?></span><span class="sorting-indicator"></span>
            </a>
          </th>
          <th class="table_big_col sortable <?php if ($order_by == 'author') {echo $order_class;} ?>">
            <a onclick="spider_set_input_value('order_by', 'author');
                        spider_set_input_value('asc_or_desc', '<?php echo ((isset($_POST['asc_or_desc']) && isset($_POST['order_by']) && (esc_html(stripslashes($_POST['order_by'])) == 'author') && esc_html(stripslashes($_POST['asc_or_desc'])) == 'asc') ? 'desc' : 'asc'); ?>');
                        spider_form_submit(event, 'posts_form')" href="">
              <span><?php _e('Author', 'wdps_back'); ?></span><span class="sorting-indicator"></span>
            </a>
          </th>
          <th class="table_biggest_col mobile_hide"><?php _e('Type', 'wdps_back'); ?></th>
          <th class="sortable mobile_hide <?php if ($order_by == 'date') {echo $order_class;} ?> table_biggest_col">
            <a onclick="spider_set_input_value('order_by', 'date');
                        spider_set_input_value('asc_or_desc', '<?php echo ((isset($_POST['asc_or_desc']) && isset($_POST['order_by']) && (esc_html(stripslashes($_POST['order_by'])) == 'date') && esc_html(stripslashes($_POST['asc_or_desc'])) == 'asc') ? 'desc' : 'asc'); ?>');
                        spider_form_submit(event, 'posts_form')" href="">
              <span><?php _e('Date created', 'wdps_back'); ?></span><span class="sorting-indicator"></span>
            </a>
          </th>
          <th class="sortable mobile_hide <?php if ($order_by == 'modified') {echo $order_class;} ?> table_biggest_col">
            <a onclick="spider_set_input_value('order_by', 'modified');
                        spider_set_input_value('asc_or_desc', '<?php echo ((isset($_POST['asc_or_desc']) && isset($_POST['order_by']) && (esc_html(stripslashes($_POST['order_by'])) == 'modified') && esc_html(stripslashes($_POST['asc_or_desc'])) == 'asc') ? 'desc' : 'asc'); ?>');
                        spider_form_submit(event, 'posts_form')" href="">
              <span><?php _e('Date modified', 'wdps_back'); ?></span><span class="sorting-indicator"></span>
            </a>
          </th>
        </thead>
        <tbody id="tbody_arr">
          <?php
          $ids_string = '';
          if ($rows_data) {
            $l = 0;
            foreach ($rows_data as  $key => $row_data) {
              $alternate = (!isset($alternate) || $alternate == 'class="alternate"') ? '' : 'class="alternate"';
              ?>
              <tr id="tr_<?php echo $row_data->id; ?>" <?php echo $alternate; ?>>
                <td class="table_small_col check-column"><input id="check_<?php echo $row_data->id; ?>" name="check_<?php echo $row_data->id; ?>" type="checkbox" /></td>
                <td class="table_big_col">
                  <img class="featured_image" title="<?php echo $row_data->title; ?>" src="<?php echo ($row_data->thumb_url == null) ? WD_PS_URL . '/images/no-image.png' : $row_data->thumb_url; ?>" />
                </td>
                <td><a onclick="jQuery('#check_<?php echo $row_data->id; ?>').attr('checked', 'checked'); wdps_add_post('<?php echo $row_data->id; ?>,', <?php echo $single ?>); window.parent.tb_remove();" id="a_<?php echo $row_data->id; ?>" style="cursor: pointer;"><?php echo $row_data->title; ?></a></td> 
                <td class="table_big_col"><?php echo $row_data->author; ?></td>
                <td class="mobile_hide table_biggest_col"><?php echo $row_data->type; ?></td>
                <td class="mobile_hide table_biggest_col"><?php echo $row_data->date; ?></td>
                <td class="mobile_hide table_biggest_col"><?php echo $row_data->modified; ?></td>
                <input type="hidden" name="wdps_title_<?php echo $row_data->id; ?>" id="wdps_title_<?php echo $row_data->id; ?>" value="<?php echo $row_data->title; ?>" />
                <input type="hidden" name="wdps_image_url_<?php echo $row_data->id; ?>" id="wdps_image_url_<?php echo $row_data->id; ?>" value="<?php echo ($row_data->image_url != '') ? $row_data->image_url : WD_PS_URL . '/images/no-image.png'; ?>" />
                <input type="hidden" name="wdps_thumb_url_<?php echo $row_data->id; ?>" id="wdps_thumb_url_<?php echo $row_data->id; ?>" value="<?php echo ($row_data->thumb_url != '') ? $row_data->thumb_url : WD_PS_URL . '/images/no-image.png'; ?>" />
                <input type="hidden" name="wdps_link_<?php echo $row_data->id; ?>" id="wdps_link_<?php echo $row_data->id; ?>" value="<?php echo $row_data->link; ?>" />
                <input type="hidden" name="wdps_content_<?php echo $row_data->id; ?>" id="wdps_content_<?php echo $row_data->id; ?>" value="<?php echo $fv ? "<b style='font-size:inherit;'>{post_title}</b>\n{post_content}" : "{post_content}"; ?>" />
                <input type="hidden" name="post_feild_val<?php echo $row_data->id; ?>" id="post_feild_val<?php echo $row_data->id; ?>" value='<?php echo json_encode($post_feilds_name[$k[$l++]],JSON_HEX_APOS); ?>' />
              </tr>
              <?php
              $ids_string .= $row_data->id . ',';
            }
          }
          else {
            echo WDW_PS_Library::no_items($header_title);
          }
          ?>
        </tbody>
      </table>
      <input id="asc_or_desc" name="asc_or_desc" type="hidden" value="<?php echo $asc_or_desc; ?>" />
      <input id="order_by" name="order_by" type="hidden" value="<?php echo $order_by; ?>" />
      <input id="slide_id" name="slide_id" type="hidden" value="<?php echo $slide_id; ?>" />
      <input id="ids_string" name="ids_string" type="hidden" value="<?php echo $ids_string; ?>" />
      <input type="hidden" id="slider_id" name="slider_id" value="<?php echo WDW_PS_Library::get( 'slider_id' ); ?>" />
      <input id="task" name="task" type="hidden" value="" />
    </form>
    <script>
      jQuery(window).load(function () {
        jQuery(".wdps_category_name").change(function () {
          jQuery("#page_number").val(1);
          jQuery("#search_or_not").val("search");
          jQuery("#posts_form").submit();
        });
        jQuery("#archive-dropdown").change(function () {
           jQuery("#page_number").val(1);
           jQuery("#posts_form").submit();
        });
        jQuery("#archive").change(function () {
           jQuery("#page_number").val(1);
           jQuery("#posts_form").submit();
        });
        <?php
        if ($count) {
          ?>
          jQuery("input[type='checkbox']").on("click", function() {
            jQuery("input[type='checkbox']").attr('checked', false);
            jQuery(this).attr('checked', true);
          });
          <?php
        }
        ?>
      });
      var fv_disabled = '<?php echo $fv_disabled; ?>';
      var fv_class = '<?php echo $fv_class; ?>';
      var fv = '<?php echo $fv; ?>';
    </script>
    <?php
    wp_print_scripts('common');
    die();
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