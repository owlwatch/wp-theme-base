<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>
    <?php /*
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    */ ?>
    <? wp_head() ?>
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>
  <body <? body_class() ?> itemscope itemtype="http://schema.org/WebPage">
    
    <header id="page-header">
      <div class="container" id="top">
        <div>
          <h1><?= bloginfo('name') ?></h1>
        </div>
        <nav id="main-nav">
          
        </nav>
      </div>
    </header>
    
    <div class="bd">
      <div class="container">
      