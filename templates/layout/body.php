<?php
$wrapper = Snap::inst('Snap_Wordpress_Theme_Wrapper');
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