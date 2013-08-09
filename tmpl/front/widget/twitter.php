<div class="twitter-feed">
  
  <h3 class="twitter-logo">
    <a
      href="http://twitter.com/<?= @$instance['username'] ?>"
      rel="publisher"
      target="_blank"
      title="Follow us on Twitter"
    >
      <i class="icon-twitter"></i>
    </a>
  </h3>
  
  <div class="twitter-follow">
    <a
      href="http://twitter.com/<?= @$instance['username'] ?>"
      rel="publisher"
      target="_blank"
      title="Follow us on Twitter">
      Follow Us
    </a>
  </div>
  
  <nav class="twitter-nav">
    <ul>
      <li><a href="#" class="prev"><i class="icon-angle-left"></i></a></li>
      <li><a href="#" class="next"><i class="icon-angle-right"></i></a></li>
    </ul>
  </nav>
  
  <ul class="tweets">
    <? foreach( $tweets as $i => $tweet ) if( $tweet['html'] ) {
      $cls = $i ? 'tweet' : 'active tweet';
      ?>
    <li class="<?= $cls ?>">
      
      <div class="message">
        <?= $tweet['html'] ?>
        
        <span class="time">
          <a href="<?= $tweet['link'] ?>" target="_blank">
            <?= $tweet['posted_time'] ?>
          </a>
        </span>
        
      </div>
      
      
    </li>
    <? } ?>
  </ul>
  
</div>