<meta charset="<?php bloginfo( 'charset' );?>" />
<meta name="description" content="<?php get_description();?>" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="theme-color" content="#ffffff" />

<meta property="fb:app_id" content="" />
<meta property="og:type" content="website" />

<!-- The Open Graph protocol -->
<?php if( $og = get_open_graph() ):?>
	<meta property="og:description" content="<?php echo $og -> content;?>" />
	<meta property="og:image" content="<?php echo $og -> images -> medium_large;?>" />
	<meta property="og:title" content="<?php echo $og -> title;?>" />
	<meta property="og:url" content="<?php echo $og -> url;?>" />

	<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@type": "NewsArticle",
		"mainEntityOfPage": {
			"@type": "WebPage",
			"@id": "<?php echo $og -> url;?>"
		},
		"headline": "<?php echo $og -> title;?>",
		"image": <?php echo json_encode( array_values( ( array ) $og -> images ) );?>,
		"datePublished": "<?php echo $og -> modified;?>",
		"dateModified": "<?php echo $og -> modified;?>",
		"author": {
			"@type": "Person",
			"name": "<?php echo $og -> author;?>"
		},
		"publisher": {
			"@type": "Organization",
			"name": "Name Company",
			"logo": {
				"@type": "ImageObject",
				"url": "http://www.example.com/logo.png"
			}
		},
		"description": "<?php echo $og -> content;?>"
	}
	</script>
<?php elseif( IS_CATEGORY ): define( 'CATEGORY', ( array ) get_data( 'category', get_cat_ID( single_cat_title( '', false ) ) )[ 0 ] );?>
	<meta property="og:description" content="<?php echo CATEGORY[ 'description' ];?>" />
	<meta property="og:image" content="" />
	<meta property="og:title" content="<?php single_cat_title( '', true );?>" />
	<meta property="og:url" content="<?php get_location();?>" />
<?php else:?>
	<meta property="og:description" content="<?php bloginfo( 'description' );?>" />
	<meta property="og:image" content="" />
	<meta property="og:title" content="<?php bloginfo( 'name' );?>" />
	<meta property="og:url" content="<?php get_location();?>" />
<?php endif; unset( $og );?>

<link href="<?php bloginfo( 'stylesheet_url' );?>" rel="stylesheet" />
<link href="<?php bloginfo( 'template_url' );?>/node_modules/@fancyapps/fancybox/dist/jquery.fancybox.min.css" rel="stylesheet" />

<link rel="shortcut icon" href="<?php image_dir();?>/favicon.png" />

<script type="application/ld+json">
{
	"@context": "http://schema.org",
	"@type": "Organization",
	"name": "Name Company",
	"url": "http://www.example.com/",
	"logo": {
		"@type": "ImageObject",
		"url": "http://www.example.com/logo.png"
	},
	"sameAs": [
		"https://www.facebook.com/",
		"https://twitter.com/",
		"https://www.linkedin.com/"
	]
}
</script>