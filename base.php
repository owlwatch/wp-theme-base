<?php
get_template_part('templates/head');
?>
  <body <?php body_class(); ?>>
    <?php
    get_template_part('templates/layout/header');
    get_template_part('templates/layout/body');
    get_template_part('templates/layout/footer');
    wp_footer();
    ?>
  </body>
</html>