<?php
global $viral_coming_soon;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="<?php echo bloginfo('description'); ?>">
  <title><?php echo bloginfo('name'); ?></title>
  <?php wp_head(); ?>
  <?php
    include plugin_dir_path( __FILE__ ) . 'header-css.php';
  ?>
</head>
<body>
  <?php if ( current_user_can( 'manage_options' ) && ! is_admin() && $viral_coming_soon['preview'] && ! $viral_coming_soon['activated'] ) { ?>
  <a class="preview" href="<?php echo get_admin_url() ?>admin.php?page=viral_coming_soon_options&tab=1">Preview mode enabled</a>
  <?php } ?>
  <?php if ( ! empty($viral_coming_soon['background']['background-image']) ) { ?><div class="background"></div><?php } ?>
  <div class="page row">
    <div class="box columns medium-10">
      <a href="<?php echo bloginfo('url'); ?>" title="<?php echo bloginfo('description'); ?>" class="logo"><?php echo bloginfo('name'); ?></a>
      <hr />
      <?php
        if ( ! empty($viral_coming_soon['page-headline']) ) {
          echo '<h1>' . $viral_coming_soon['page-headline'] . '</h1>';
        }
        if ( $viral_coming_soon['countdown'] && ! empty($viral_coming_soon['countdown-time']) ) {
          echo '<div class="clock"></div>';
        }
        if ( ! empty($viral_coming_soon['page-text']) ) {
          echo wpautop($viral_coming_soon['page-text']);
        }
        if ( ! empty($viral_coming_soon['page-cta-text']) ) {
          echo '<p><a href="#" data-reveal-id="myModal" class="button large">' . $viral_coming_soon['page-cta-text'] . '</a></p>';
        }
        if ( ! empty($viral_coming_soon['page-small-link']) ) {
          echo '<p><small><a href="#" data-reveal-id="myModal">' . $viral_coming_soon['page-small-link'] . '</a></small></p>';
        }
      ?>
    </div>
    <?php if ( $viral_coming_soon['powered'] ) { ?>
      <div class="columns medium-10 end medium-centered powered"><a href="https://www.wordpress.org/plugins/viral-coming-soon">Not using Viral Coming Soon yet?</a></div>
    <?php  } ?>
  </div>
  <div id="myModal" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
    <?php
      if ( ! empty($viral_coming_soon['page-popup-headline']) ) {
        echo '<h2 id="modalTitle">' . $viral_coming_soon['page-popup-headline'] . '</h2>';
      }
      echo '<hr />';
      echo viral_coming_soon_optin_form($viral_coming_soon['page-popup-cta']);
      if ( ! empty($viral_coming_soon['page-popup-small']) ) {
        echo '<small>' . $viral_coming_soon['page-popup-small'] . '</small>';
      }
    ?>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
  </div>
  <?php if ( $viral_coming_soon['exit-intent'] ) { ?>
  <div id="exit-popup">
    <div class="underlay"></div>
      <div class="modal">
        <div class="layer-one">
          <?php 
            if ( ! empty($viral_coming_soon['exit-intent-headline']) ) {
              echo '<h2>' . $viral_coming_soon['exit-intent-headline'] . '</h2>';
            }
          ?>
          <?php 
            if ( ! empty($viral_coming_soon['exit-intent-text']) ) {
              echo wpautop($viral_coming_soon['exit-intent-text']);
            }
          ?>
          <a class="button primary"><span><?php _e('Yes', 'viral_coming_soon'); ?></span> <small><?php if ( ! empty($viral_coming_soon['exit-intent-yes-text']) ) { echo $viral_coming_soon['exit-intent-yes-text']; } ?></small></a>
          <a class="button secondary"><span><?php _e('No', 'viral_coming_soon'); ?></span> <small><?php if ( ! empty($viral_coming_soon['exit-intent-no-text']) ) { echo $viral_coming_soon['exit-intent-no-text']; } ?></small></a>
        </div>
        <div class="layer-two">
          <?php 
          if ( ! empty($viral_coming_soon['exit-intent-form-headline']) ) {
            echo '<h2>' . $viral_coming_soon['exit-intent-form-headline'] . '</h2>';
          }
          ?>
          <?php echo viral_coming_soon_optin_form($viral_coming_soon['exit-intent-cta']); ?>
        <?php if ( ! empty($viral_coming_soon['exit-intent-small']) ) { echo '<small>' . $viral_coming_soon['exit-intent-small'] . '</small>'; } ?>
      </div>
    </div>
  </div>
  <?php } ?>
  <?php
  // Convert Countdown Time to Javascript readable format
  $date = strtotime($viral_coming_soon['countdown-time']);
  $year = date('Y', $date);
  $month = date('m', $date) - 1;
  $day = date('d', $date);
  ?>
  <script type="text/javascript">
  jQuery(function($) {

    var $csQuery = $.noConflict();

    // Foundation Init
    $csQuery(document).foundation();

    // Make FlipClock translatable
    (function($) {
        FlipClock.Lang.Custom = {

            'years'   : '<?php _e( 'Years', 'viral_coming_soon' ); ?>',
            'months'  : '<?php _e( 'Months', 'viral_coming_soon' ); ?>',
            'days'    : '<?php _e( 'Days', 'viral_coming_soon' ); ?>',
            'hours'   : '<?php _e( 'Hours', 'viral_coming_soon' ); ?>',
            'minutes' : '<?php _e( 'Minutes', 'viral_coming_soon' ); ?>',
            'seconds' : '<?php _e( 'Seconds', 'viral_coming_soon' ); ?>'

        };

        FlipClock.Lang['cs']      = FlipClock.Lang.Custom;
    }(jQuery));

    <?php if ( $viral_coming_soon['countdown'] && ! empty($viral_coming_soon['countdown-time']) ) { ?>
    $csQuery(document).ready(function() {

      var date = new Date(Date.UTC(<?php echo $year . ',' . $month . ',' . $day; ?>,0,0,0));
      var now = new Date();
      var diff = (date.getTime()/1000) - (now.getTime()/1000);

      var clock1;
        
      clock1 = $csQuery('.clock').FlipClock(diff, {
        clockFace: 'DailyCounter',
        language: 'cs',
        countdown: true
      });


    });
    <?php } ?>
    <?php if ( $viral_coming_soon['exit-intent'] && ! empty($viral_coming_soon['leadbribe']) ) { ?>
    // Exit Intent Popup

    var _ouibounce = ouibounce(document.getElementById('exit-popup'), {
      aggressive: true,
      timer: 0,
      callback: function() { console.log('ouibounce fired!'); }
    });

    $csQuery('body').on('click', function() {
      $csQuery('#exit-popup').hide();
    });
      
    $csQuery('#exit-popup .primary').on('click', function() {
      $csQuery('.layer-two').show();
      $csQuery('.layer-one').hide();
    });

    $csQuery('#exit-popup .secondary').on('click', function() {
      $csQuery('#exit-popup').hide();
    });

    $csQuery('#exit-popup .modal').on('click', function(e) {
      e.stopPropagation();
    });

    <?php } ?>

    $csQuery(document).ready(function() {

      // Powered By Text Color
      var background_color = $csQuery('.background').css('background-color');


      if ( background_color != undefined ) {
        // Check if Background Color is RGBA or just RGB
        if ( background_color.includes('rgba') ) {
          var rgba = background_color.replace('rgba(', '').replace(')','' ).split(',').map(Number);
        } else {
          var rgb = background_color.replace('rgb(', '').replace(')','' ).split(',').map(Number);
        }
      } else {
        // var background_color = $csQuery('body').css('background-color');
        var rgb = $csQuery('body').css('background-color').replace('rgb(', '').replace(')','' ).split(',').map(Number);
      }

      if ( typeof rgba !== 'undefined' ) {
        // If Background Color is RGBA check the alpha
        if ( rgba[3] > 0.4 ) {
          // Use the background color as indicator
          changeTextColor(rgba[0], rgba[1], rgba[2]);
        } else {
          // Use the background image as indicator
          BackgroundCheck.init({
            targets: '.powered a',
            minOverlap: 0,
            images: 'body'
          });
        }
      } else {
        // Use the background color as indicator
        changeTextColor(rgb[0], rgb[1], rgb[2]);
      }

      function changeTextColor(r, g, b) {
        var treshold = Math.round(((r * 299) + (g * 587) + (b * 114)) /1000);
        if ( treshold > 125 ) {
          $csQuery('.powered a').css('color', 'black');
        } else {
          $csQuery('.powered a').css('color', 'white');
        }
      }

    });

  });
  </script>
  <?php wp_footer(); ?>
</body>
</html>