<?php

class WDPSControllerGoptions_wdps {
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
    require_once WD_PS_DIR . "/admin/models/WDPSModelGoptions_wdps.php";
    $model = new WDPSModelGoptions_wdps();

    require_once WD_PS_DIR . "/admin/views/WDPSViewGoptions_wdps.php";
    $view = new WDPSViewGoptions_wdps($model);
    $view->display();
  }
  public function apply() {
    $wdps_array_glogal_options = json_decode(get_option("wdps_array_glogal_options"));
    $wdps_register_scripts = (isset($wdps_array_glogal_options)) ? $wdps_array_glogal_options->wdps_register_scripts : 0;
    $possib_add_ffamily = (isset($_REQUEST['possib_add_ffamily']) ? esc_html($_REQUEST['possib_add_ffamily']) : '');
    $possib_add_ffamily_google = (isset($_REQUEST['possib_add_ffamily_google']) ? esc_html($_REQUEST['possib_add_ffamily_google']) : '');
    $wdps_array_glogal_options = json_encode(array("wdps_register_scripts" => $wdps_register_scripts, "possib_add_ffamily" =>$possib_add_ffamily, 'possib_add_ffamily_google' => $possib_add_ffamily_google));
    update_option("wdps_array_glogal_options", $wdps_array_glogal_options);
    $page = WDW_PS_Library::get('page');
    WDW_PS_Library::spider_redirect(add_query_arg(array('page' => $page, 'task' => 'display', 'message' => 1), admin_url('admin.php')));
  }
  public function save() {
    $wdps_array_glogal_options = json_decode(get_option("wdps_array_glogal_options"));
    $wdps_register_scripts = (isset($_REQUEST['wdps_register_scripts']) ? (int) $_REQUEST['wdps_register_scripts'] : 0);
    $possib_add_ffamily = (isset($wdps_array_glogal_options->possib_add_ffamily) && $wdps_array_glogal_options->possib_add_ffamily) ? $wdps_array_glogal_options->possib_add_ffamily : "";
    $possib_add_ffamily_google = (isset($wdps_array_glogal_options->possib_add_ffamily_google) && $wdps_array_glogal_options->possib_add_ffamily_google) ? $wdps_array_glogal_options->possib_add_ffamily_google : "";
    $wdps_array_glogal_options = json_encode(array("wdps_register_scripts" => $wdps_register_scripts, "possib_add_ffamily" =>$possib_add_ffamily, 'possib_add_ffamily_google' => $possib_add_ffamily_google));
    update_option("wdps_array_glogal_options", $wdps_array_glogal_options);
    $page = WDW_PS_Library::get('page');
    WDW_PS_Library::spider_redirect(add_query_arg(array('page' => $page, 'task' => 'display', 'message' => 1), admin_url('admin.php')));
  }
}