<ul class="degrees-at-a-glance">

<?php
while( $query->have_posts() ){
  $query->the_post();
  $site = get_field('department_site');
  $email = get_field('department_email');
  $phone = get_field('department_phone');
  ?>
  <li class="department">
    <div class="row">
      <div class="span3">
        <a class="image-block" href="<?= get_permalink() ?>">
          <?php the_post_thumbnail('featured') ?>
          <div class="teaser">
            <h2><?php the_title() ?></h2>
          </div>
        </a>
        
        <ul class="department-info">
          
          <li>
            <i class="label-icon icon-info"></i>
            <div class="value">
              <a href="<?= get_permalink() ?>">Get more info <i class="icon-angle-right"></i></a>
            </div>
          </li>
          
          <?php if( 0 && $site ){ ?>
          <li>
            <i class="label-icon icon-world"></i>
            <div class="value">
              <a target="_blank" href="<?= $site ?>">Visit our website <i class="icon-angle-right"></i></a>
            </div>
          </li>
          <?php } ?>
          <?php if( 0 && $phone ){ ?>
          <li>
            <i class="label-icon icon-iphone"></i>
            <div class="value">
              <a href="tel:<?= preg_replace('/[^\d]/','',$phone) ?>"><?= $phone ?> <i class="icon-angle-right"></i></a>
            </div>
          </li>
          <?php } ?>
          
        </ul>
        
      </div>
      <div class="span5">
        
        <?php
        $contact_blocks = array_filter(array(
          get_field('contact_block_1'),
          get_field('contact_block_2')
        ));
        if( 0 && count( $contact_blocks ) ){
          ?>
        <div class="contact-box">
          <?php foreach( $contact_blocks as $block ){
            ?>
          <div class="content">
            <?= $block ?>
          </div>
            <?php
            }
          ?>
        </div>
          <?php
        }
        if( ($degrees = get_field('degree_offerings')) && count( $degrees ) ){
          ?>
          <div class="degree-offerings">
            <h3 class="uppercase-heading">Degree Offerings</h3>
            <ul>
            <?php
            
            foreach( $degrees as $degree ) if( $degree['term'] ){
              if( 'bachelors-masters' == $degree['term']->slug ) continue;
              ?>
              <li>
                <i class="icon-angle-right"></i>
                <?php
                if( $degree['link'] ){
                  $target =  Theme_Functions::is_external_link( $degree['link'] ) ?
                    '_blank' : '_self';
                  ?>
                  <a href="<?= $degree['link'] ?>" target="<?= $target ?>" >
                  <?php
                }
                ?>
                <?= $degree['term']->name ?>
                <?php
                if( $degree['link'] ){
                    ?>
                  </a>
                  <?php
                }
                ?>
              </li>
              <?php
            }
            ?>
            </ul>
          </div>
          <?php
        }
        
        if( ($focus_areas = get_field('focus_areas')) && count( $focus_areas) ){
          ?>
          <div class="focus-areas">
            <h3 class="uppercase-heading">Focus Areas</h3>
            <?php
            $areas = array();
            foreach( $focus_areas as $focus_area ){
              $areas[] = $focus_area['focus_area'];
            }
            echo implode(", ", $areas);
            ?>
          </div>
          <?php
        }
        ?>
      </div>
    </div>
  </li>

  <?php
}
?>
</ul>