<?php

class Theme_Functions
{
  
  protected static $_terms;
  protected static $_excerpt_wordcount=false;
  protected static $_excerpt_append=false;
  
  public static function distribute( $ar, $num )
  {
    $ar = array_values( $ar );
    $count = count($ar);
    $cols = array();
    $i=0;
    for($col=0; $col<$num; $col++){
      $cols[$col] = array();
      $total = intval($count / $num) + ((($count % $num) >= ($col + 1)) ? 1 : 0) + $i;
      while($i<$total){
        $cols[$col][] = $ar[$i++];
      }
    }
    return $cols;
  }
  
  public static function get_url( $text )
  {
    if( !preg_match('/^http/i', $text) ){
      return 'http://'.$text;
    }
    return $text;
  }
  
  public static function page_link( $path, $default='#' )
  {
    $page = get_page_by_path( $path );
    if( $page ){
      return get_permalink( $page );
    }
    return $default;
  }
  
  public static function get_blog_url()
  {
    if( $posts_page_id = get_option('page_for_posts') ){
      return home_url(get_page_uri($posts_page_id));
    } else {
      return home_url();
    }
  }
  
  public static function get_custom_ordered_terms($taxonomy, $id=null, $args=array())
  {
    if( !$id ) $id = get_the_ID();
    self::$_terms = get_terms($taxonomy, array('fields'=>'ids'));
    $post_terms = wp_get_post_terms( $id, $taxonomy );
    usort($post_terms, array(self, '_sort_terms'));
    return $post_terms;
  }
  
  public static function _sort_terms($a, $b)
  {
    return array_search($a->term_id, self::$_terms) - array_search($b->term_id, self::$_terms);
  }
  
  public static function excerpt($append = '...', $words = 30)
  {
    self::$_excerpt_append=$append;
    self::$_excerpt_wordcount=$words;
    
    add_filter('excerpt_length', array(__CLASS__, 'excerpt_length_filter'));
    add_filter('excerpt_more', array(__CLASS__, 'excerpt_more_filter'));
    add_filter('the_excerpt', array(__CLASS__, 'excerpt_filter'));
    
    the_excerpt();
    
    remove_filter('excerpt_length', array(__CLASS__, 'excerpt_length_filter'));
    remove_filter('excerpt_more', array(__CLASS__, 'excerpt_more_filter'));
    remove_filter('the_excerpt', array(__CLASS__, 'excerpt_filter'));
    
    self::$_excerpt_wordcount=false;
    self::$_excerpt_append=false;
  }
  
  public static function excerpt_length_filter($length)
  {
    return self::$_excerpt_wordcount;
  }
  
  public static function excerpt_more_filter($more)
  {
    return '';
  }
  
  public static function excerpt_filter($excerpt)
  {
    return $excerpt.self::$_excerpt_append;
  }
  
  public static function is_external_link( $link )
  {
    return strpos($link, 'http') === 0 && strpos($link, home_url()) !== 0;
  }
}