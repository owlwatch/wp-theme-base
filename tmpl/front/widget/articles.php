<?= $before_widget ?>
<?php
if( $title ){
  echo $before_title.$title.$after_title;
}
?>
<ul class="wse-sidebar-articles">
<?php
foreach( $articles as $article ){
  ?>
  <li>
    <?php
    $style = get_field('sidebar_display_style', $article->ID);
    switch($style){
      case 'featured':
        Snap::inst('Theme_View_Front_PostBlock')->render_image( $article );
        break;
      
      case 'no_image':
      case 'normal':
      default:
        if( 'video' == get_post_type( $article->ID ) ){
          Snap::inst('Theme_View_Front_PostBlock')->render_video( $article );
        }
        else {
          Snap::inst('Theme_View_Front_PostBlock')->render_text( $article, $style!=='no_image', 'right' );
        }
        break;
    }
    ?>
  </li>
  <?php
}
?>
</ul>
<?= $after_widget ?>