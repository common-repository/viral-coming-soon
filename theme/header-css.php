<?php
global $viral_coming_soon;
if (
! empty($viral_coming_soon['logo-color']) ||
! empty($viral_coming_soon['text-color']) ||
! empty($viral_coming_soon['small-text-color']) ||
! empty($viral_coming_soon['cta-color']) ||
! empty($viral_coming_soon['logo']) ||
! empty($viral_coming_soon['background']) ||
! empty($viral_coming_soon['box-background'])
) { ?>
    <style type="text/css">
    <?php if ( ! empty($viral_coming_soon['small-text-color']) ) { ?>
        .box p small a {
            color: <?php echo $viral_coming_soon['small-text-color']; ?>
        }
    <?php } ?>
    <?php if ( ! empty($viral_coming_soon['text-color']) ) { ?>
        .box h1, .box p {
            color: <?php echo $viral_coming_soon['text-color']; ?>
        }
    <?php } ?>
    <?php if ( ! empty($viral_coming_soon['logo-color']) ) { ?>
        .box .logo {
            color: <?php echo $viral_coming_soon['logo-color']; ?>
        }
    <?php } ?>
    <?php if ( ! empty($viral_coming_soon['box-background']['rgba']) ) { ?>
        .box {
            background-color: <?php echo $viral_coming_soon['box-background']['rgba']; ?>
        }
    <?php } ?>
    <?php if ( ! empty($viral_coming_soon['logo']['url']) ) { ?>
        .logo {
            text-indent: -10000px;
            background: url("<?php echo $viral_coming_soon['logo']['url']; ?>") top center no-repeat;
            background-size: contain;
        }
    <?php } ?>
    <?php if ( ! empty($viral_coming_soon['background']['background-image']) ) { ?>
        body, html {
            background:<?php echo 'url("' . $viral_coming_soon['background']['background-image'] . '") center center no-repeat ' . $viral_coming_soon['background']['background-color']; ?>;
            background-size: cover;
            background-position: fixed;
        }
    <?php if ( ! empty( $viral_coming_soon['background-overlay-color']['rgba'] ) ) {?>
        .background {
            background-color: <?php echo $viral_coming_soon['background-overlay-color']['rgba']; ?>
        }
    <?php } ?>
    <?php } elseif ( empty($viral_coming_soon['background']['background-image']) && ! empty($viral_coming_soon['background']['background-color']) ) { ?>
        body, html {
            background-color:<?php echo $viral_coming_soon['background']['background-color']; ?>;
        }
    <?php } ?>
    <?php if ( ! empty($viral_coming_soon['cta-color']) ) { ?>
        button, input[type="button"], input[type="reset"], input[type="submit"], button[type="submit"], a.button.cta, .entry-content .bonus, #exit-popup .layer-one .button.primary {
            background-color: <?php echo $viral_coming_soon['cta-color']; ?>;
        }
        button, input[type="button"], input[type="reset"], input[type="submit"], button[type="submit"], a.button.cta, input.error[type="text"]:focus, input.error[type="email"]:focus, input.error[type="url"]:focus, input.error[type="password"]:focus, input.error[type="search"]:focus, textarea.error:focus, #exit-popup .layer-one .button.primary {
            border-color: <?php echo $viral_coming_soon['cta-color']; ?>;
        }
        a:hover, button:hover, input[type="button"]:hover, input[type="submit"]:hover, input[type="reset"]:hover, a.button.cta:hover, .error, .form-submit input[type="submit"]:hover, #exit-popup .layer-one .button.primary:hover {
            color: <?php echo $viral_coming_soon['cta-color']; ?>;
        }
        .button.large, button {
            background: <?php echo $viral_coming_soon['cta-color']; ?>;
            border-color: <?php echo $viral_coming_soon['cta-color']; ?>;
        }
        p small a:hover, .button:hover, .button:active, .button:focus, button:hover, button:active, button:focus {
            color:<?php echo $viral_coming_soon['cta-color']; ?>;
        }
        .button:hover {
            background:#FFF;
        }
    <?php } ?>
    <?php if ( ! empty($viral_coming_soon['custom_styles']) ) { ?>
        <?php echo $viral_coming_soon['custom_styles']; ?>;
    <?php } ?>
</style>
<?php }
if ( ! empty ($viral_coming_soon['custom_analytics']) ) {
    echo $viral_coming_soon['custom_analytics'];
} ?>