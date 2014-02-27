<?php
get_header();
get_sidebar('breadcrumbs');

global $post;

// get the blog page...
$count = 0;
$total = 4;

if( is_category() ){
  $title = 'News: '.get_queried_object()->name;
}
else if( is_tag() ){
  $title = 'Tag: '.get_queried_object()->name;
}
else if( is_day() ){
  $title = sprintf( __( 'Daily Archives: %s', 'wse' ), get_the_date() );
}
else if( is_month() ){
	$title = sprintf( __( 'Monthly Archives: %s', 'wse' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'wse' ) ) );
}
else if( is_year() ){
	$title = sprintf( __( 'Yearly Archives: %s', 'wse' ), get_the_date( _x( 'Y', 'yearly archives date format', 'wse' ) ) );
}
else {
  $title = 'Archives';
}

?>
<div class="bd">
  <div class="container">
		<h1 class="page-title"><?= $title ?></h1>
		<?php
		if( have_posts() ) while( have_posts() ){
			the_post();
			get_template_part('list-entry', get_post_format());
		}
		else {
			?>
		<p>No articles found.</p> 
			<?php
		}
		
		if( function_exists('wp_paginate') ){
			wp_paginate();
		}
		?>
  </div>
</div>

<?php get_footer() ?>