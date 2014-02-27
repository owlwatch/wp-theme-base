<?php
the_post();
get_header();
?>
<div class="bd">
  
  <div class="container">
    <h1 class="page-title">
      <?php the_title() ?>
    </h1>
      
    <div clas="the-content">
      <?php the_content() ?>
    </div>
      
  </div>
</div>
<?php get_footer() ?>