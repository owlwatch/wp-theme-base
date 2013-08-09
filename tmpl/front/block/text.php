<?php
$show_image = $show_image && has_post_thumbnail();
$classes = array('text-block');
if( $show_image ){
  $classes[] = 'text-block-with-image';
  if( $image_position ){
    $classes[] = 'text-block-with-image-'.$image_position;
  }
}
?>
<article class="<?= implode(' ', $classes ) ?>">

  <?php if( !$show_image || ($show_image && (!$image_position || $image_position == 'left')) ){ ?>
  <?php if( $show_image && has_post_thumbnail() ){ ?>
  <a class="article-image" href="<?= get_permalink() ?>"><?php the_post_thumbnail('sidebar-small') ?></a>
  <?php } ?>
  <div class="article-content">
  <? } ?>

  <?php if( ($label = get_field('display_label')) ){ ?>
    <div class="post-display-label"><?= $label ?></div>
  <?php } ?>
  <h4><a href="<?= get_permalink() ?>"><?php the_title() ?></a></h4>
  <?php if( $show_image && $image_position && $image_position == 'right' ){ ?>
  <a class="article-image" href="<?= get_permalink() ?>"><?php the_post_thumbnail('sidebar-small') ?></a>
  <div class="article-content">
  <? } ?>


    <div class="excerpt">
      <?php the_excerpt() ?>
      <a class="more" href="<?= get_permalink() ?>">More <i class="icon-angle-right"></i></a>
    </div>
  </div>
</article>