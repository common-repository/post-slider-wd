<?php

class WDPSViewUninstall_wdps {
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
    global $wpdb;
    $prefix = $wpdb->prefix;
    ?>
    <form class="wdps_form" method="post" action="admin.php?page=uninstall_wdps" style="width:99%;">
      <?php wp_nonce_field('nonce_wd', 'nonce_wd'); ?>
      <div class="wrap">
        <span class="uninstall_icon"></span>
        <h2><?php echo __('Uninstall Post Slider by 10Web','wdps_back'); ?></h2>
        <div class="goodbye-text">
          <?php
          $support_team = '<a href="https://10web.io/contact-us/?source=post-slider-wd" target="_blank">' . __('support team', 'wdps_back') . '</a>';
          $contact_us = '<a href="https://10web.io/contact-us/?source=post-slider-wd" target="_blank">' . __('Contact us', 'wdps_back') . '</a>';
          echo sprintf(__("Before uninstalling the plugin, please Contact our %s. We'll do our best to help you out with your issue. We value each and every user and value what's right for our users in everything we do.<br />
          However, if anyway you have made a decision to uninstall the plugin, please take a minute to %s and tell what you didn't like for our plugins further improvement and development. Thank you !!!", "wdps_back"), $support_team, $contact_us); ?>
        </div>
        <p>
          <?php echo __('Deactivating Post Slider by 10Web plugin does not remove any data that may have been created. To completely remove this plugin, you can uninstall it here.','wdps_back'); ?>
        </p>
        <p style="color: red;">
          <strong><?php echo __('WARNING:','wdps_back'); ?></strong>
          <?php echo __("Once uninstalled, this can't be undone. You should use a Database Backup plugin of WordPress to back up all the data first.",'wdps_back'); ?>
        </p>
        <p style="color: red">
          <strong><?php echo __('The following Database Tables will be deleted:','wdps_back'); ?></strong>
        </p>
        <table class="widefat">
          <thead>
            <tr>
              <th><?php echo __('Database Tables','wdps_back'); ?></th>
            </tr>
          </thead>
          <tr>
            <td valign="top">
              <ol>
                  <li><?php echo $prefix; ?>wdpsslider</li>
                  <li><?php echo $prefix; ?>wdpsslide</li>
                  <li><?php echo $prefix; ?>wdpslayer</li>              
              </ol>
            </td>
          </tr>
        </table>
        <p style="text-align: center;">
         <?php echo __('Do you really want to uninstall Post Slider by 10Web plugin?','wdps_back'); ?>
        </p>
        <p style="text-align: center;">
          <input type="checkbox" name="Post Slider by 10Web" id="check_yes" value="yes" />&nbsp;<label for="check_yes"><?php echo __('Yes','wdps_back'); ?></label>
        </p>
        <p style="text-align: center;">
          <input type="submit" value="<?php echo __('UNINSTALL','wdps_back'); ?>" class="button-primary" onclick="if (check_yes.checked) { 
                                                                                    if (confirm('<?php echo addslashes(__('You are About to Uninstall Post Slider by 10Web plugin from WordPress.This Action Is Not Reversible.','wdps_back')); ?>')) {
                                                                                        spider_set_input_value('task', 'uninstall');
                                                                                    } else {
                                                                                        return false;
                                                                                    }
                                                                                  }
                                                                                  else {
                                                                                    return false;
                                                                                  }" />
        </p>
      </div>
      <input id="task" name="task" type="hidden" value="" />
    </form>
  <?php
  }

  public function uninstall() {
    $flag = TRUE;
    global $wpdb;
    $this->model->delete_db_tables();
    $prefix = $wpdb->prefix;
    $deactivate_url = add_query_arg(array('action' => 'deactivate', 'plugin' => WD_WDPS_NAME .'/post-slider-wd.php'), admin_url('plugins.php'));
    $deactivate_url = wp_nonce_url($deactivate_url, 'deactivate-plugin_' . WD_WDPS_NAME . '/post-slider-wd.php');
    ?>
    <div id="message" class="wd_updated fade">
      <p><?php echo __('The following Database Tables successfully deleted:','wdps_back'); ?></p>
      <p><?php echo $prefix; ?>wdpsslider,</p>
      <p><?php echo $prefix; ?>wdpsslide,</p>
      <p><?php echo $prefix; ?>wdpslayer.</p>
    </div>
    <div class="wrap">
      <h2><?php echo __('Uninstall Post Slider by 10Web','wdps_back'); ?></h2>
      <p><strong><a href="<?php echo $deactivate_url; ?>" class="wdps_deactivate_link" data-uninstall="1"><?php echo __('Click Here','wdps_back'); ?></a> <?php echo __('To Finish the Uninstallation and Post Slider by 10Web will be Deactivated Automatically.','wdps_back'); ?></strong></p>
      <input id="task" name="task" type="hidden" value="" />
    </div>
  <?php
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