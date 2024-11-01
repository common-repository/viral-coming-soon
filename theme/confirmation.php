<?php
global $viral_coming_soon;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="<?php echo bloginfo('description'); ?>">
  <title><?php echo bloginfo('name'); ?> Almost finished…</title>
  <?php wp_head(); ?>
  <?php
    include plugin_dir_path( __FILE__ ) . 'header-css.php';
  ?>
</head>
<body>
  <?php if ( ! empty($viral_coming_soon['background']['background-image']) ) { ?><div class="background"></div><?php } ?>
  <div class="page confirmation row">
    <div class="box columns medium-9">
      <?php
        if ( ! empty($viral_coming_soon['confirmation-headline']) ) {
          echo '<h1>' . $viral_coming_soon['confirmation-headline'] . '</h1>';
        }
        if ( ! empty($viral_coming_soon['confirmation-text']) ) {
          echo wpautop( do_shortcode($viral_coming_soon['confirmation-text']) );
        }
      ?>
    </div>
  </div>
  <script>
  !function ($) {

    // Foundation Init
    $(document).foundation();

    $(document).ready(function() {

      var clock;
        
      clock = $('.clock').FlipClock(299, {
        clockFace: 'MinuteCounter',
        countdown: true,
      });

    });
    
  }(window.jQuery);
  </script>
</body>
</html>