<?php

class Theme_Base extends Snap_Wordpress_Plugin
{
  
  public function __construct()
  {
    parent::__construct();
		
		$this->init_wp_less();
    
    $this->register_post_types();
    $this->register_taxonomies();
    $this->register_navs();
    $this->register_sidebars();
    $this->add_theme_support();
    $this->add_image_sizes();
    
    Snap::inst('Theme_Customize');
    Snap::inst('Theme_Shortcodes');
		
		// initialize our views
    Snap_Wordpress_Template::registerPath('theme.front', Theme_DIR.'/tmpl/front');
    Snap_Wordpress_Template::registerPath('theme.admin', Theme_DIR.'/tmpl/admin');
    
    if( is_admin() ){
      Snap::inst('Theme_Admin');
    }
    else {
      Snap::inst('Theme_Front');
    }
  }
  
  /**
   * Init the wp-less plugin
   */
  protected function init_wp_less()
  {
    add_action('admin_enqueue_scripts', array( $lessPlugin, 'processStylesheets') );
  }
  
  /**
   * Register variables
   * @wp.action       wp_enqueue_scripts
   * @wp.priority     10
   */
  public function wp_enqueue_scripts()
  {
    if( class_exists('WPLessPlugin') ){
      $less = WPLessPlugin::getInstance();
      Snap::inst('Theme_Customize')->register_less_vars( $less );
    }
  }
  
  /**
	 * @wp.filter
	 */
	public function mce_css($css)
	{
		$handle = 'theme-editor';
		$less = WPLessPlugin::getInstance();  
		wp_enqueue_style($handle, get_template_directory_uri().'/assets/stylesheets/editor.less');
    Snap::inst('Theme_Customize')->register_less_vars( $less );
    
		$less->processStylesheets();
		global $wp_styles;
		$src = $wp_styles->registered[$handle]->src;
		wp_dequeue_style($handle);
		return $src;
	}
  
  /**
   * Register the WSE post types
   */
  protected function register_post_types()
  {
    
  }
  
  /**
   * Register the WSE taxonomies
   */
  protected function register_taxonomies()
  {
    
  }
  
  /**
   * Register Navigation Menus
   */
  protected function register_navs()
  {
		register_nav_menu('utlity', 'Utility Menu');
    register_nav_menu('primary', 'Primary Menu');
  }
  
  /**
   * Register Theme Sidebars
   */
  protected function register_sidebars()
  {
    $this->_register_sidebar('right', 'Right');
  }
  
  protected function _register_sidebar($id, $name, $heading='h3')
  {
    register_sidebar(array(
      'name'          => __( $name, 'theme' ),
      'id'            => $id,
      'description'   => '',
      'class'         => '',
      'before_widget' => '<div id="%1$s" class="widget %2$s">',
      'after_widget'  => '</div>',
      'before_title'  => "<$heading class=\"widget-title\">",
      'after_title'   => "</$heading>" )
    );
  }
  
  /**
   * Register our own widgets
   *
   * @wp.action           widgets_init
   * @wp.priority         20
   */
  public function register_widgets()
  {
    // register_widget('Theme_Widget_Twitter');
  }
  
  /**
   * Add our Wordpress core support
   */
  protected function add_theme_support()
  {
    add_theme_support('post-thumbnails');
  }
  
  /**
   * Add Image Sizes
   */
  protected function add_image_sizes()
  {
    // add_image_size('slide', 628, 345, true );
  }
  
}
