<?php

class Theme_Admin extends Snap_Wordpress_Plugin
{
  
  public function __construct()
  {
    parent::__construct();
  }
  
  /**
   * @wp.action         admin_enqueue_scripts
   */
  public function enqueue_styles()
  {
    wp_enqueue_style('theme-admin', THEME_URI.'/assets/stylesheets/admin.less');
  }
  
  /**
   * @wp.action         admin_notices
   */
  public function flash_notices()
  {
    if( ($msg = Theme_Flash::get('admin_info')) ){
      ?>
      <div class="updated"><?= $msg ?></div>
      <?
    }
    if( ($msg = Theme_Flash::get('admin_error')) ){
      ?>
      <div class="error"><?= $msg ?></div>
      <?
    }
  }
  
}
