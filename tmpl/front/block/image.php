<a class="image-block reveal-teaser" href="<?= get_permalink() ?>">
  <?php the_post_thumbnail('featured') ?>
  <div class="teaser">
    <h2><?php the_title() ?></h2>
    <div class="excerpt">
      <?php the_excerpt() ?>
      <!-- <a href="<?= get_permalink() ?>">More</a>-->
      <span class="more"><span>More</span> <i class="icon-chevron-right"></i></span>
    </div>
  </div>
</a>