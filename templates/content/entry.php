<article <?php post_class(); ?>>
  <?php
  get_template_part('templates/content/entry/header', get_post_type());
  get_template_part('templates/content/entry/meta', get_post_type());
  get_template_part('templates/content/entry/body', get_post_type());
  get_template_part('templates/content/entry/footer', get_post_type());
  ?>
</article>