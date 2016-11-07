<meta charset="<?php bloginfo( 'charset' );?>" />
<meta name="description" content="<?php is_single() ? single_post_title( '', true ) : bloginfo( 'description' );?>" />
<meta content="width=device-width, initial-scale=1" name="viewport" />
<meta name="theme-color" content="#ffffff" />

<!-- The Open Graph protocol -->
<?php if( $og = get_open_graph() ):?>
	<meta property="fb:app_id" content="" />
	<meta property="og:description" content="<?php echo $og -> content;?>" />
	<meta property="og:image" content="<?php echo $og -> image;?>" />
	<meta property="og:title" content="<?php echo $og -> title;?>" />
	<meta property="og:url" content="<?php echo $og -> url;?>" />
<?php elseif( is_category() ):?>
	<meta property="fb:app_id" content="" />
	<meta property="og:description" content="<?php bloginfo( 'description' );?>" />
	<meta property="og:image" content="" />
	<meta property="og:title" content="<?php single_cat_title( '', true );?>" />
	<meta property="og:url" content="<?php get_location();?>" />
<?php else:?>
	<meta property="fb:app_id" content="" />
	<meta property="og:description" content="<?php bloginfo( 'description' );?>" />
	<meta property="og:image" content="" />
	<meta property="og:title" content="<?php bloginfo( 'name' );?>" />
	<meta property="og:url" content="<?php get_location();?>" />
<?php endif; unset( $og );?>

<link href="<?php bloginfo( 'stylesheet_url' );?>" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" rel="stylesheet" />

<link rel="shortcut icon" href="<?php image_dir();?>/favicon.png" />