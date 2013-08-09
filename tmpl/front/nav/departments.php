<?
foreach( $cols as $col ){
  ?>
  <ul>
    <? foreach( $col as $dept ){
      $cls = is_single($dept->ID) ?
        'class="active"' : '';
      
      $link = get_field('department_site', $dept->ID );
      $target="_blank";
      if( !$link ){
        $link = get_permalink( $dept->ID );
        $target="_self";
      }
      ?>
    <li>
      <a <?= $cls ?> href="<?= $link ?>" target="<?= $target ?>">
        <?= esc_html($dept->post_title) ?>
      </a>
    </li>
    <? } ?>
  </ul>
  <?
}
?>
<div class="view-all-link-container">
  <a href="<?= get_post_type_archive_link('department') ?>">Explore All Fields of Study ›</a>
</div>