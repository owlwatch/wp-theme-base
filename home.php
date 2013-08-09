<?php
get_header();
get_sidebar('breadcrumbs');

$title = "News";
if( ($page_for_posts = get_option('page_for_posts', false) ) ){
  $title = get_the_title( $page_for_posts );
}

global $post;

// get the blog page...
$count = 0;
$total = 4;
?>
<h1 class="page-title"><?= $title ?></h1>

<?php
/* Slideshow (if enabled) */
if( get_field('enable_slideshow') )
  Snap::inst('Theme_View_Front_Slideshow')
    ->render(get_the_ID(), 'large');
?>
<div class="grid-with-gutters">
  <div class="row">
    <div class="span8">
      <?php
      while( have_posts() ){
        the_post();
        get_template_part('list-entry', get_post_format());
      }
      if( function_exists('wp_paginate') ){
        wp_paginate();
      }
      ?>
    </div>
    <div class="span4">
      <div class="sidebar right-sidebar">
        <?php
        dynamic_sidebar('blog');
        ?>
      </div>
    </div>
  </div>
</div>

<?php get_footer() ?>