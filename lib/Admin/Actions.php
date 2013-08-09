<?php

class Theme_Admin_Actions extends Snap_Wordpress_Plugin
{
  /**
   * @wp.action             init
   */
  public function update_folio_info()
  {
    if( !@$_REQUEST['update_folio_info'] ) return;
    
    // we are going to assume this is done in the context of a page load
    $faculty = Snap::inst('Theme_Model_Faculty')->load($_REQUEST['post']);
    
    try {
      $faculty->update_folio_data();
      Theme_Flash::set('admin_info', "<p>Folio information successfully synced</p>");
    }
    catch( Exception $e ){
      $msg = $e->getMessage();
      Theme_Flash::set('admin_info', "<p>Error syncing Folio information</p><p><strong>{$msg}</strong></p>");
    }
  }
}
