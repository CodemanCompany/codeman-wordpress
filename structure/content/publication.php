<article>
	<div class="container">
		<?php if( have_posts() ): while( have_posts() ): the_post();?>

		<h5><?php the_category( ' ' );?></h5>
		<img class="img-responsive" src="<?php get_image( $post -> ID );?>" alt="" />
		<h2><?php the_title();?></h2>
		<p><span class="text-muted"><?php the_date();?></span></p>
		<p><?php the_content();?></p>
		<a href="/">back</a>
		
		<?php endwhile; endif;?>
	</div>
</article>