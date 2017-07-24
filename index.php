<?php
define( 'IS_CATEGORY', is_category() );
define( 'IS_DRAFT', is_draft() );
define( 'IS_HOME', is_home() );
define( 'IS_MOBILE', wp_is_mobile() );
define( 'IS_PAGE', is_page() );
define( 'IS_SEARCH', is_search() );
define( 'IS_SINGLE', is_single() );
?>
<!DOCTYPE html>
<html data-ng-app="app" data-ng-controller="MainController" <?php language_attributes();?>>
	<head>
		<title><?php wp_title( '|', true, 'right' );?></title>

		<?php get_template_part( 'structure/head' );?>
	</head>

	<body>
		<nav><?php get_template_part( 'structure/navigation' );?></nav>
		<header><?php get_template_part( 'structure/header' );?></header>
		<main><?php get_template_part( 'structure/main' );?></main>
		<footer><?php get_template_part( 'structure/footer' );?></footer>

		<?php get_template_part( 'structure/scripts' );?>
	</body>
</html>