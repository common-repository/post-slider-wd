<?php

class WDPSViewGoptions_wdps {
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
    $wdps_array_glogal_options = json_decode(get_option("wdps_array_glogal_options"));
    $register_scripts = (isset($wdps_array_glogal_options->wdps_register_scripts) && $wdps_array_glogal_options->wdps_register_scripts) ? $wdps_array_glogal_options->wdps_register_scripts : 0;
    $possib_add_ffamily = (isset($wdps_array_glogal_options->possib_add_ffamily) && $wdps_array_glogal_options->possib_add_ffamily) ? $wdps_array_glogal_options->possib_add_ffamily : '';
    $possib_add_ffamily_google = (isset($wdps_array_glogal_options->possib_add_ffamily_google) && $wdps_array_glogal_options->possib_add_ffamily_google) ? $wdps_array_glogal_options->possib_add_ffamily_google : '';
    ?>
    <div class="clear"></div>
    <form class="wrap wdps_form" id="sliders_form" method="post" action="admin.php?page=goptions_wdps" style="width: 98%;" enctype="multipart/form-data">
      <h1 class="hidden"></h1>
      <?php wp_nonce_field('nonce_wd', 'nonce_wd'); ?>
      <div class="wdps-options-page-banner">
        <div class="wdps-options-logo"></div>
				<div class="wdps-options-logo-title">
					<?php _e('Global Options', 'wdps_back'); ?>
				</div>
        <div class="wdps-page-actions">
			   <button class="wdps_button-secondary wdps_save_slider"  onclick="spider_set_input_value('task', 'save');">
          <span></span>
          <?php _e('Save', 'wdps_back'); ?>
				 </button>
		  	</div>	
      </div>
      <table>
			  <tbody>
          <tr>
            <td class="spider_label"><label><?php _e('Include scripts/styles only on necessary pages', 'wdps_back'); ?>:</label></td>
               <td>
                <input type="radio" id="wdps_register_scripts1" name="wdps_register_scripts" <?php echo (($register_scripts == 1)? "checked='checked'" : ""); ?> value="1" /><label <?php echo ($register_scripts ? 'class="selected_color"' : ''); ?> for="wdps_register_scripts1"><?php _e('Yes', 'wdps_back'); ?></label>
                <input type="radio" id="wdps_register_scripts0" name="wdps_register_scripts" <?php echo (($register_scripts == 0)? "checked='checked'" : ""); ?> value="0" /><label <?php echo ($register_scripts ? '' : 'class="selected_color"'); ?> for="wdps_register_scripts0"><?php _e('No', 'wdps_back'); ?></label>
                <div class="spider_description"><?php _e('Helps to decrease page load time. Might not function with some custom themes.', 'wdps_back'); ?></div>
             </td>
          </tr>
          <tr>
            <td class="spider_label"><label for="possib_add_ffamily_input"><?php _e('Add font-family:', 'wdps_back'); ?> </label></td>
            <td>
              <input type="text" id="possib_add_ffamily_input" value="" class="spider_box_input" />
              <input type="hidden" id="possib_add_ffamily" name="possib_add_ffamily" value="<?php echo $possib_add_ffamily; ?>" /> 
              <input type="hidden" id="possib_add_ffamily_google" name="possib_add_ffamily_google" value="<?php echo $possib_add_ffamily_google; ?>" /> 
              <input id="possib_add_google_fonts" type="checkbox"  name="possib_add_google_fonts" value="1" /><label for="possib_add_google_fonts"><?php echo __('Add to Google fonts', 'wdps_back'); ?></label>
              <input id="add_font_family" class="action_buttons add_images" type="button" onclick="set_ffamily_value();spider_set_input_value('task', 'apply');spider_form_submit(event, 'sliders_form')" value="<?php echo __('Add font-family','wdps_back'); ?>" />
              <div class="spider_description"><?php _e('The added font family will appear in the drop-down list of fonts.', 'wdps_back'); ?></div>
            </td>
          </tr>
        </tbody>
			</table>
      <input id="task" name="task" type="hidden" value="" />
    </form>
    <?php
  }
}
