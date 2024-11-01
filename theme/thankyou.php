<?php
global $viral_coming_soon;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="<?php echo bloginfo('description'); ?>">
  <title><?php echo bloginfo('name'); ?> Thank you for joining</title>
  <?php wp_head(); ?>
  <?php
    include plugin_dir_path( __FILE__ ) . 'header-css.php';
  ?>
</head>
<body>
  <?php if ( ! empty($viral_coming_soon['background']['background-image']) ) { ?><div class="background"></div><?php } ?>
  <div class="page thankyou row">
    <div class="box columns medium-9">
      <?php
        if ( ! empty($viral_coming_soon['thank-you-headline']) ) {
          echo '<h1>' . $viral_coming_soon['thank-you-headline'] . '</h1>';
        }
        if ( ! empty($viral_coming_soon['thank-you-text']) ) {
          echo wpautop( do_shortcode($viral_coming_soon['thank-you-text']) );
        }
      ?>
    </div>
  </div>
  <script>
  !function ($) {
    // Foundation Init
    $(document).foundation();

  }(window.jQuery);
  </script>
    <div id="fb-root"></div>
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '1685312758391615',
          xfbml      : true,
          version    : 'v2.8'
        });
        FB.AppEvents.logPageView();
      };

      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/<?php echo get_locale(); ?>/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));
    </script>
</body>
</html>