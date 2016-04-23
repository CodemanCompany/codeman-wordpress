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