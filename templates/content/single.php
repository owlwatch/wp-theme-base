<article <?php post_class(); ?>>
  <?php
  get_template_part('templates/content/single/header', get_post_type());
  get_template_part('templates/content/single/meta', get_post_type());
  get_template_part('templates/content/single/body', get_post_type());
  get_template_part('templates/content/single/footer', get_post_type());
  ?>
</article>