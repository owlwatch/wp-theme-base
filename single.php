<?php

if( has_post_format('quote') )
  return get_template_part('single', 'quote');

if( has_term(array('student-profile','alumni-story'), 'category') )
  return get_template_part('single', 'student-profile');

the_post();
get_header();
get_sidebar('breadcrumbs');
?>
<article class="primary full-article grid-with-gutters">
  <div class="row">
    <div class="span8">
      <h1 class="page-title">
        <?php the_title() ?>
      </h1>
      <div class="date">
        <?php the_date() ?>
      </div>
      
      <div class="share-bar">
        <?php get_template_part('element','share') ?>
      </div>
      
      <div class="the-content">
        <? the_content() ?>
      </div>
      
      <div class="taxonomy-lists">
        <?php get_template_part('taxonomy-list', 'category'); ?>
        <?php get_template_part('taxonomy-list', 'post_tag'); ?>
      </div>
      
      <?php get_template_part('element', 'postnav'); ?>
      
    </div>
    <div class="span4">
      <div class="sidebar right-sidebar">
        <?php
        dynamic_sidebar('blog');
        ?>
      </div>
    </div>
  </div>
</article>
<?php
get_footer();
?>