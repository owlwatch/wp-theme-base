<?php

define( 'THEME_DIR', dirname(__FILE__) );
define( 'THEME_URI', get_template_directory_uri() );
define( 'THEME_VENDOR_DIR', THEME_DIR.'/vendor' );

// register our library with the Snap autoloader
Snap_Loader::register( 'Theme', THEME_DIR.'/lib' );

// launch our theme
Snap::inst('Theme_Base');