<meta charset="<?php bloginfo( 'charset' );?>" />
<meta name="description" content="<?php is_single() ? single_post_title( '', true ) : bloginfo( 'description' );?>" />
<meta content="width=device-width, initial-scale=1" name="viewport" />

<!-- The Open Graph protocol -->
<?php if( is_single() ):?>
<meta property="og:image" content="<?php get_image();?>" />
<meta property="og:title" content="<?php the_title();?>" />
<?php endif;?>

<!-- <link href="<?php bloginfo( 'stylesheet_url' );?>" rel="stylesheet" /> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" rel="stylesheet" />
<link href="<?php bloginfo( 'template_url' );?>/less/app.less" type="text/css" rel="stylesheet/less" />
<script src="<?php bloginfo( 'template_url' );?>/js/lib/less.min.js"></script>

<link rel="shortcut icon" href="<?php image_dir();?>/favicon.png" />