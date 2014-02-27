<?php

class Theme_Customize extends Snap_Wordpress_Plugin
{
  
  protected $settings_var = 'radiac_settings';
  
  protected $setting_defaults = array(
    'transport'     => 'refresh'
  );
  
  protected $control_defaults = array(
    'priority'      => 10
  );
  
  protected $customizing = false;
  
  /**
   * This function combines settings and controls
   * to reduce redundancy
   */
  protected function get_config()
  {
    
    if( !isset($this->_config) ){
      $this->_config = array(
        'color-base'    => array(
          'less_var'      => true,
          'setting'       => array(
            'default'       => '#147BB8'
          ),
          'control'       => array(
            'type'          => 'WP_Customize_Color_Control',
            'args'          => array(
              'label'         => 'Theme Base',
              'section'       => 'colors'
            )
          )
        )
      );
    }
    return $this->_config;
  }
  
  /**
   * @wp.action
   */
  public function customize_register( $wp_customize )
  {
    $this->wp_customize =& $wp_customize;
    $this->add_settings();
    $this->add_sections();
    $this->add_controls();
  }
  
  public function add_sections()
  {
    $this->wp_customize->add_section('wse', array(
      'title' => 'WSE Settings'
    ));
    $this->wp_customize->add_section('social', array(
      'title' => 'Social Links'
    ));
  }
  
  public function add_settings()
  {
    
    foreach( $this->get_config() as $name => $config ){
      $this->wp_customize->add_setting(
        $name,
        array_merge( $this->setting_defaults, $config['setting'] )
      );
    }
    
  }
  
  public function add_controls()
  {
    foreach( $this->get_config() as $name => $config ){
      $type = $config['control']['type'];
      $this->wp_customize->add_control( new $type(
        $this->wp_customize,
        $name,
        array_merge( $this->control_defaults, array(
          'settings' => $name
        ), $config['control']['args'] )
      ));
    }
  }
  
  public function val( $name )
  {
    $config = $this->get_config();
    return get_theme_mod( $name, $config[$name]['setting']['default'] );
  }
  
  public function register_less_vars( &$less )
  {
    foreach( $this->get_config() as $name => $config ){
      if( @$config['less_var'] ){
        $less->addVariable( $name, $this->val( $name ) );
      }
    }
    
    if( !$this->customizing ){
      // check the theme_mods against the previous
      $key = md5( serialize( get_theme_mods() ) );
      $last = get_option( $this->settings_var.'_hash' );
      if( !$last || $last != $key ){
        $less->getConfiguration()->setCompilationStrategy('always');
        update_option( $this->settings_var.'_hash', $key );
      }
    }
    
  }
  
  /**
   * @wp.action
   */
  public function customize_preview_init()
  {
    $this->customizing = true;
    
    // force wp-less to recompile
    if (class_exists('WPLessPlugin')){
      
      $lessConfig =& WPLessPlugin::getInstance()->getConfiguration();
      $lessConfig->setCompilationStrategy('always');
    
      $upload_dir = wp_upload_dir(null);
      $dir = '/customize-css/'.get_current_user_id();
      $lessConfig->setUploadDir($upload_dir['basedir'] . $dir);
      $lessConfig->setUploadUrl($upload_dir['baseurl'] . $dir);
      
    }
  }
  
  /**
   * @wp.action
   * @wp.priority           1000
   */
  public function wp_enqueue_scripts()
  {
    global $wp_styles;
    if( $this->customizing ){
      
      foreach( $wp_styles->registered as $handle => $style ){
        if( preg_match('/customize\-css/', $style->src) ) $wp_styles->registered[$handle]->src .= '?'.microtime();
      }
    }
  }
}
