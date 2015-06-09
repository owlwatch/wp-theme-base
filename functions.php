<?php
define( 'THEME_DIR', dirname(__FILE__) );
define( 'THEME_URI', get_template_directory_uri() );
if( class_exists('Snap') ){
  // register our library with the Snap autoloader
  Snap_Loader::register( 'Theme', THEME_DIR.'/lib' );
  
  // launch our theme
  Snap::inst('Snap_Wordpress_Theme')->init('Theme');
}
