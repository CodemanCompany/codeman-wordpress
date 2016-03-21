<h1><?php single_cat_title( '', true );?></h1>

<article>
	<div class="container">
		<?php if( have_posts() ): while( have_posts() ): the_post();?>

		<img class="img-responsive" src="<?php get_image( $post -> ID );?>" alt="" />
		<h2><?php the_title();?></h2>
		<p><span class="text-muted"><?php the_date();?></span></p>
		<p><?php the_content( '', FALSE, '' );?></p>
		<a href="<?php get_url();?>">link</a>
		
		<?php endwhile; endif;?>
		<hr />
		<div class="nav-previous text-left"><?php next_posts_link( 'Entradas anteriores' ); ?></div>
		<div class="nav-next text-right"><?php previous_posts_link( 'Entradas recientes' ); ?></div>
	</div>
</article>