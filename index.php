<?php
get_header();
?>
<div class="row">
  
  <?php if( is_search() ){ ?>
  <h1 class="page-title">Search Results</h1>
  <?php } ?>
  
  <div class="span8">
    <?php
    while( have_posts() ){
      the_post();
      ?>
      <h3><?php the_title(); ?></h3>
      <div class="excerpt"><?php the_excerpt(); ?></div>
      <?php
    }
    ?>
    
    <?php
    if( function_exists('wp_paginate') ){
      wp_paginate();
    }
    ?>
  </div>
  <div class="span4">
    <div class="sidebar right-sidebar">
      <?php
      dynamic_sidebar('right');
      ?>
    </div>
  </div>
</div>
<?php
get_footer();
?>