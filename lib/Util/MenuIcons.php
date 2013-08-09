<?php

class Theme_Util_MenuIcons extends Snap_Wordpress_Plugin
{
  /**
   * @wp.filter         wp_nav_menu
   * 
   */
  function fontawesome_menu( $nav ) {
    $nav = preg_replace_callback(
                        '/<li((?:[^>]+)(icon-[^ ]+ )(?:[^>]+))><a[^>]+>(.*?)<\/a>/',
                        array( $this, '_replace' ),
                        $nav
                    );
    return $nav;
  }
  
  protected function _replace( $a )
  {
    $listitem = $a[0];
    $icon = $a[2];
    $link_text = $a[3];
    $str_noicon = str_replace( $icon, ' has-icon ', $listitem );
    if( strpos($str_noicon, 'append-icon' ) !== false ){
      $str_noicon = str_replace('append-icon', '', $str_noicon);
      $replacement = '><span class="fontawesome-text">' . $link_text . '</span> <i class="' . trim( $icon ) . '"> </i>';
    }
    else{
      $replacement = '><i class="' . trim( $icon ) . '"> </i> <span class="fontawesome-text">' . $link_text . '</span>';
    }
    $str = str_replace( '>'.$link_text, $replacement, $str_noicon );
    return $str;
  }
  
  /**
   * @wp.filter         nav_menu_css_class
   */
  public function external_links( $classes, $item )
  {
    // check for external links
    if( strpos( $item->url, home_url() ) !== 0 ){
      foreach( $classes as $class ) if( strpos($class, 'icon-')===0 ) return $classes;
      
      $classes[] = 'icon-external';
      $classes[] = 'append-icon';
    }
    return $classes;
  }
}
