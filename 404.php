<?php
the_post();
get_header();
?>
<article class="primary full-article grid-with-gutters">
  <h1 class="page-title">
    <?= get_field('404_title', 'option') ?>
  </h1>
  <div class="row">
    <div class="span8">
      <?= get_field('404_page', 'option') ?>
    </div>
    <div class="span4">
      <div class="sidebar right-sidebar">
        <?php
        dynamic_sidebar('404');
        ?>
      </div>
    </div>
  </div>
</article>
<?php
get_footer();
?>