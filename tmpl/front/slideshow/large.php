<div class="slideshow slideshow-large">
  <div class="row">
    <div class="span4">
      <? foreach( $slides as $i => $slide ) { ?>
      <div class="slide-content <?= !$i ? 'active' : '' ?>">
        <?php if( $slide['label'] ){ ?>
        <div class="post-display-label"><?= $slide['label'] ?></div>
        <?php } ?>
        <h2 class="slide-title">
          <?= esc_html( $slide['title'] ) ?>
        </h2>
        <?php if( $slide['caption'] ){ ?>
        <p class="slide-caption"><?= $slide['caption'] ?></p>
        <?php } ?>
        <a class="slide-link" href="<?= $slide['link_type'] == 'internal' ? get_permalink($slide['internal_link'][0]->ID) : $slide['external_link'] ?>">
          <?= $slide['link_text'] ?> <i class="icon-chevron-right"></i>
        </a>
      </div>
      <? } ?>
    </div>
    <div class="span8">
      <div class="slide-images">
      <? foreach( $slides as $i => $slide ) { ?>
      <a href="<?= $slide['link_type'] == 'internal' ? get_permalink($slide['internal_link'][0]->ID) : $slide['external_link'] ?>">
        <img
          class="<?= !$i ? 'active' : '' ?>"
          src="<?= $slide['image']['sizes']['slide'] ?>"
          alt="<?= esc_attr( $slide['title'] ) ?>"
          height="<?= $slide['image']['sizes']['slide-height'] ?>"
          width="<?= $slide['image']['sizes']['slide-width'] ?>"
        />
      </a>
      <? } ?>
      </div>
    </div>
  </div>
</div>