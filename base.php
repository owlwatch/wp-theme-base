<?php
get_template_part('templates/head');
$wrapper = Snap::inst('Snap_Wordpress_Theme_Wrapper');
?>
  <body <?php body_class(); ?>>
    <?php
    get_template_part('templates/header');
    ?>
    <div class="wrap container" role="document">
      <div class="content row">
        <main class="main" role="main">
          <?php
          $wrapper->content();
          ?>
        </main>
        <?php
        if( ($sidebar=apply_filters('theme/sidebar', 'primary')) ){
          ?>
        <aside class="sidebar" role="complementary">
          <?php
          get_template_part('templates/sidebar', $sidebar);
          ?>
        </aside>
          <?php
        }
        ?>
      </div>
    </div>
    <?php
    get_template_part('templates/footer');
    wp_footer();
    ?>
  </body>
</html>