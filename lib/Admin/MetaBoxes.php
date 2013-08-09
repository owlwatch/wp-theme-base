<?php

class Theme_Admin_MetaBoxes extends Snap_Wordpress_Plugin
{
  /**
   * @wp.metabox
   * @wp.title              Folio Information
   * @wp.post_type          faculty
   * @wp.priority           low
   */
  public function folio_box( $post )
  {
    $faculty = Snap::inst('Theme_Model_Faculty')->load( $post );
    
    if( !$faculty->get('folio_url') ){
      ?>
      <p>You must enter the Folio URL in the Faculty Details section and save before
      you can view the imported folio information.</p>
      <?
      return;
    }
    
    if( !($keys = $faculty->get('_folio_keys')) ){
      ?>
      <p>No Folio information exists.
      <a href="<?= add_query_arg('update_folio_info', 1) ?>" class="button button-primary">
        Sync Now
      </a>
      </p>
      <?php
      return;
    }
    $folio_info = array();
    foreach( $keys as $key ) {
      
    }
    ?>
    
    <p><a href="<?= add_query_arg('update_folio_info', 1) ?>" class="button button-primary">
        Sync Now
    </a></p>
    <?
  }
}
