<?php

class Theme_Front extends Snap_Wordpress_Plugin
{
  
  protected $displayed = array();
  
  public function __construct()
  {
    parent::__construct();
    $this->assets = new Snap_Wordpress_Theme_Assets( get_template_directory() );
  }
  
  
  /**
   * @wp.action       wp_enqueue_scripts
   */
  public function enqueue_styles()
  {
    $this->assets->script('scripts/main.js');
    $this->assets->style('styles/main.css');
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