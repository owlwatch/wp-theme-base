<?php

class Theme_Flash
{
  
  public static $prefix = '_theme_flash_';
  
  public static function set_prefix( $prefix )
  {
    self::$prefix = $prefix;
  }
  
  public static function get( $key )
  {
    $val = get_transient( self::key( $key ) );
    delete_transient( self::key( $key ) );
    return $val;
  }
  
  public static function set( $key, $message )
  {
    set_transient( self::key( $key ), $message );
  }
  
  protected static function key( $key )
  {
    $id = get_current_user_id();
    return self::$prefix.$id.$key;
  }
}
