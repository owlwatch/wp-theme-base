<?php

class Theme_Base extends Snap_Wordpress_Plugin
{
  /**
   * @wp.filter         snap/theme/navs
   */
  public function navs( $navs )
  {
    return array_merge( $navs, [
      /*
      'nav-area-name'       => 'Navigation Area Label',
      */
    ]);
  }
  
  /**
   * @wp.filter         snap/theme/sidebars
   */
  public function sidebars( $sidebars )
  {
    return array_merge( $sidebars, [
      /*
      'overlay-reservation' => [
        'name'                => 'Sidebar Name',
        'description'         => 'Sidebar Description'
      ],
      */
    ]);
  }
  
  /**
   * @wp.filter         snap/theme/plugins
   */
  public function plugins( $plugins )
  {
    return array_merge($plugins, [
      /*
      List of plugin class names
      */
    ]);
  }
  
  /**
   * @wp.filter         snap/theme/post_types
   */
  public function post_types( $post_types )
  {
    return array_merge($post_types, [
      /*
      List of post type class names
      */
    ]);
  }
  
  /**
   * @wp.filter         snap/theme/add_theme_support
   */
  public function add_theme_support( $supports )
  {
    return array_merge( $supports, [
      'post-thumbnails'         => null,
      'soil-clean-up'           => true,
      'soil-relative-urls'      => true,
      'soil-disable-trackbacks' => true
    ]);
  }
  
  /**
   * @wp.action         after_setup_theme
   */
  public function add_editor_style()
  {
    $assets = new Snap_Wordpress_Theme_Assets( get_template_directory() );
    add_editor_style( $assets->get_path('styles/editor-style.css') );
  }
  
  /**
   * Add a Theme Settings menu item to the admin bar. Typically used
   * in conjunction with ACF Options Page.
   *
   * @wp.-action
   * @wp.priority       99
   */
  public function admin_bar_menu( $admin_bar )
  {
    /*
    $admin_bar->add_node([
      'id'          => 'theme-settings',
      'title'       => 'Theme Settings',
      'href'        => admin_url('admin.php?page=theme-settings'),
      'parent'      => 'appearance'
    ]);
    */
  }
  
}
