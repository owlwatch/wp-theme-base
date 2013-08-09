<a class="image-block video-block" href="<?= add_query_arg('autoplay','1',get_permalink()) ?>" data-embed="<?= $embed ?>">
  <?php the_post_thumbnail('featured') ?>
  <span class="play-button">
    <i class="icon-play"></i>
  </span>
  <div class="teaser">
    <h2><?php the_title() ?></h2>
  </div>
</a>