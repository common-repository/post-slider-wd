<?php

class WDPSControllerUninstall_wdps {
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
    global $wdps_options;
    if ( !class_exists("TenWebLibConfig") ) {
      $plugin_dir = apply_filters('tenweb_free_users_lib_path', array('version' => '1.1.1', 'path' => WD_PS_DIR));
      include_once($plugin_dir['path'] . "/wd/config.php");
    }
    $config = new TenWebLibConfig();
    $config->set_options($wdps_options);
    $deactivate_reasons = new TenWebLibDeactivate($config);
    $deactivate_reasons->submit_and_deactivate();
  }
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function execute() {
    $task = ((isset($_POST['task'])) ? esc_html(stripslashes($_POST['task'])) : '');
    if (method_exists($this, $task)) {
      check_admin_referer('nonce_wd', 'nonce_wd');
      $this->$task();
    }
    else {
      $this->display();
    }
  }

  public function display() { 
    require_once WD_PS_DIR . "/admin/models/WDPSModelUninstall_wdps.php";
    $model = new WDPSModelUninstall_wdps();

    require_once WD_PS_DIR . "/admin/views/WDPSViewUninstall_wdps.php";
    $view = new WDPSViewUninstall_wdps($model);
    $view->display();
  }

  public function uninstall() { 
    require_once WD_PS_DIR . "/admin/models/WDPSModelUninstall_wdps.php";
    $model = new WDPSModelUninstall_wdps();

    require_once WD_PS_DIR . "/admin/views/WDPSViewUninstall_wdps.php";
    $view = new WDPSViewUninstall_wdps($model);
    $view->uninstall();
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