<?php

class Theme_Front extends Snap_Wordpress_Plugin
{
  
  protected $displayed = array();
  
  public function __construct()
  {
    parent::__construct();
    // Snap::inst('Theme_Util_MenuIcons');
    $this->register_scripts();
  }
  
  public function register_scripts()
  {
    wp_register_script('theme-cookie', THEME_URI.'/assets/javascripts/jquery.cookie.js', array('jquery'));
    wp_register_script('theme-modernizr', THEME_URI.'/assets/javascripts/modernizr.js');
    wp_register_script('theme-bootstrap', THEME_URI.'/vendor/twbs/bootstrap/dist/js/bootstrap.min.js', array('jquery'));
    wp_register_script('theme-rotator', THEME_URI.'/assets/javascripts/rotator.js', array('jquery'));
    wp_register_script('theme-scrollto', THEME_URI.'/assets/javascripts/jquery.scrollto.min.js', array('jquery'));
  }
  
  /**
   * @wp.action       wp_enqueue_scripts
   */
  public function enqueue_styles()
  {
    wp_enqueue_style('theme-frontend', THEME_URI.'/assets/stylesheets/front.less');
  }
  
  /**
   * @wp.action       wp_enqueue_scripts
   */
  public function enqueue_scripts()
  {
    wp_enqueue_script('theme-modernizr');
    wp_enqueue_script('theme-cookie');
    wp_enqueue_script('theme-bootstrap');
    wp_enqueue_script('theme-rotator');
    wp_enqueue_script('theme-scrollto');
    wp_enqueue_script('theme-site');
    
    wp_localize_script('theme-site', 'theme_vars', array(
      'ajaxurl' => admin_url('admin-ajax.php')
    ));
  }
  
  /**
   * @wp.filter
   */
  public function embed_oembed_html($html)
  {
    // get the height and width
    if( !preg_match('#height="(.+?)"#', $html, $height ) || !preg_match('#width="(.+?)"#', $html, $width) ){
      return $html;
    }
    $p = (int)$height[1] / (int)$width[1] * 100;
    return '<div class="media video"><div class="responsive-media" style="padding-bottom:'.$p.'%">'.$html.'</div></div>';
  }
  
}