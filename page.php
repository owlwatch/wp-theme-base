<?php
/**
 * Template Name: Page with Full Sidebar
 */
the_post();
get_header();
get_sidebar('breadcrumbs');
$share_bar = get_field('share_bar');
?>
<div class="grid-with-gutters">
  
  <div class="row">
    <div class="span8">
      <h1 class="page-title">
        <?php the_title() ?>
      </h1>
      
      <?php
      if( $share_bar == 'top' ){
        ?>
      <div class="share-bar">
        <?php get_template_part('element','share') ?>
      </div>
        <?php
      }
      ?>
      
      <?php
      /* Slideshow (if enabled) */
      if( get_field('enable_slideshow') )
        Snap::inst('Theme_View_Front_Slideshow')
          ->render(get_the_ID());
      ?>
      <div clas="the-content">
        <?php the_content() ?>
      </div>
      
      <?php
      if( $share_bar == 'bottom' ){
        ?>
      <div class="share-bar">
        <?php get_template_part('element','share') ?>
      </div>
        <?php
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
</div>
<?php get_footer() ?>