<?php

require_once( ABSPATH.WPINC.'/class-oembed.php' );

class Theme_Util_OEmbed extends WP_oEmbed
{
  public function __construct()
  {
    parent::__construct();
    // grab any additional providers
    $this->providers = _wp_oembed_get_object()->providers;
  }
  
  public function get_data( $url, $args=array() )
  {
    // check cache first
    $post_id = get_the_ID();
    $cache_key = '_wse_em_'.md5( $url.serialize($args) );
    
    // grab the cache if it exists
    $data = get_post_meta( $post_id, $cache_key, true );
    if( $data === '{unknown}'){
      return false;
    }
    if( !$data ){
      $data = false;
      $provider = $this->discover($url);
      if( $provider )
        $data = $this->fetch( $provider, $url );
        
      update_post_meta( $post_id, $cache_key, $data ? $data : '{{unknown}}' );
    }
    
    
    if( @$data->html && preg_match('#src="(.*?)"#', $data->html, $matches ) )
      $data->html_autoplay = str_replace( $matches[1], add_query_arg('autoplay', 1, $matches[1]), $data->html );
    
    
    return $data;
  }
}
