<?php
get_header();

$title = "News";
if( ($page_for_posts = get_option('page_for_posts', false) ) ){
  $title = get_the_title( $page_for_posts );
}

global $post;

// get the blog page...
$count = 0;
$total = 4;
?>
<div class="bd">
  <div class="container">
    <h1 class="page-title"><?= $title ?></h1>
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
</div>

<?php get_footer() ?>