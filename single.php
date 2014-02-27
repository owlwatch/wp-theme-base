<?php

if( has_post_format('quote') )
  return get_template_part('single', 'quote');

if( has_term(array('student-profile','alumni-story'), 'category') )
  return get_template_part('single', 'student-profile');

the_post();
get_header();
?>
<div class="bd">
  <div class="container">
    <h1 class="page-title">
      <?php the_title() ?>
    </h1>
    <div class="date">
      <?php the_date() ?>
    </div>
      
    <div class="the-content">
      <? the_content() ?>
    </div>
      
    <div class="taxonomy-lists">
      <?php get_template_part('taxonomy-list', 'category'); ?>
      <?php get_template_part('taxonomy-list', 'post_tag'); ?>
    </div>
  </div>
</div>
<?php
get_footer();
?>