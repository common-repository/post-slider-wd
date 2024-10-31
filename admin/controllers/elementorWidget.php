<?php

class WDPSElementor extends \Elementor\Widget_Base {

  /**
   * Get widget name.
   *
   * @return string Widget name.
   */
  public function get_name() {
    return 'wdps-elementor';
  }

  /**
   * Get widget title.
   *
   * @return string Widget title.
   */
  public function get_title() {
    return __('Post Slider', WD_PS_PREFIX);
  }

  /**
   * Get widget icon.
   *
   * @return string Widget icon.
   */
  public function get_icon() {
    return 'twbb-post-slider twbb-widget-icon';
  }

  /**
   * Get widget categories.
   *
   * @return array Widget categories.
   */
  public function get_categories() {
    return [ 'tenweb-plugins-widgets' ];
  }

  /**
   * Register widget controls.
   */
  protected function _register_controls() {
    $this->start_controls_section(
      'general',
      [
        'label' => __('Post Slider', WD_PS_PREFIX),
      ]
    );
    if ( $this->get_id() !== null ) {
      $settings = $this->get_init_settings();
    }
    $href = add_query_arg(array( 'page' => 'sliders_wdps' ), admin_url('admin.php'));
    // @TODO should be fix in the next version!
	// if ( isset($settings) && isset($settings["wdps_slider_id"]) && intval($settings["wdps_slider_id"]) > 0 ) {
      // $id = intval($settings["wdps_slider_id"]);
      // $href = add_query_arg(array( 'page' => 'sliders_wdps', 'task'=>'edit', 'current_id'=> $id ), admin_url('admin.php'));
    // }
    $this->add_control(
      'wdps_slider_id',
      [
        'label_block' => TRUE,
        'show_label' => FALSE,
        'description' => __('Select the slider to display.', WD_PS_PREFIX) . ' <a target="_blank" href="' . $href . '">' . __('Edit slider', WD_PS_PREFIX) . '</a>',
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 0,
        'options' => WDW_PS_Library::get_sliders(),
      ]
    );

    $this->end_controls_section();
  }

  /**
   * Render widget output on the frontend.
   */
  protected function render() {
    $settings = $this->get_settings_for_display();
    echo wdps_shortcode( array('id' => $settings['wdps_slider_id']) );
  }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new WDPSElementor() );
