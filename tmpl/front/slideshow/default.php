<div class="slideshow slideshow-default">
  <div class="slide-images">
  <? foreach( $slides as $i => $slide ) { ?>
  <a href="<?= $slide['link_type'] == 'internal' ? get_permalink($slide['internal_link'][0]->ID) : $slide['external_link'] ?>">
    <img
      class="<?= !$i ? 'active' : '' ?>"
      src="<?= $slide['image']['sizes']['slide'] ?>"
      alt="<?= esc_attr( $slide['title'] ) ?>"
      width="<?= $slide['image']['sizes']['slide-width'] ?>"
      height="<?= $slide['image']['sizes']['slide-height'] ?>"
    />
  </a>
  <? } ?>
  </div>
  <? foreach( $slides as $i => $slide ) { ?>
  <div class="slide-content <?= !$i ? 'active' : '' ?>">
    <?php if( $slide['label'] ){ ?>
    <div class="post-display-label"><?= $slide['label'] ?></div>
    <?php } ?>
    <h2 class="slide-title">
      <a href="<?= $slide['link_type'] == 'internal' ? get_permalink($slide['internal_link'][0]->ID) : $slide['external_link'] ?>">
        <?= esc_html( $slide['title'] ) ?>
      </a>
    </h2>
    <?php if( $slide['caption'] ){ ?>
    <p class="slide-caption"><?= $slide['caption'] ?></p>
    <?php } ?>
  </div>
  <? } ?>
</div>