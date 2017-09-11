<article>
	<div class="container">
		<h2>Resultados de búsqueda por: <span class="text-muted"><?php get_search();?></span></h2>

		<?php if( have_posts() ): while( have_posts() ): the_post(); if( 'post' == get_post_type() ):?>
			<article>
				<img class="img-responsive" src="<?php get_image();?>" alt="" />
				<h2><?php the_title();?></h2>
				<p><strong><?php the_category( ' ' );?></strong></p>
				<p><span class="text-muted"><?php the_date();?></span></p>
				<p><?php the_content( '', FALSE, '' );?></p>
				<a href="<?php get_url();?>">link</a>
			</article>
		<?php endif; endwhile;
		else: echo '<p>No se encontraron resultados para la búsqueda.</p>'; endif;?>
		<hr />
		<div class="nav-previous text-left"><?php next_posts_link( 'Entradas anteriores' ); ?></div>
		<div class="nav-next text-right"><?php previous_posts_link( 'Entradas recientes' ); ?></div>
	</div>
</article>