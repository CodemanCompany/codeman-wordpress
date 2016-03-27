<div class="container">
	<div class="row">
		<article class="col-xs-9">
			<?php if( is_preview() ):?>
			<div class="alert alert-info">
				<span class="label label-info">Info</span> This is a draft.
			</div>
			<?php endif;?>
			
			<?php if( have_posts() ): while( have_posts() ): the_post();?>

			<div class="fb-like" data-href='<?php get_location();?>' data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
			
			<a href="https://twitter.com/share" class="twitter-share-button" data-via="graziamx">Tweet</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

			<?php echo get_custom( 'video' );?>
			<p><strong><?php the_category( ' ' );?></strong></p>
			<img class="img-responsive" src="<?php get_image();?>" alt="" />
			<h2><?php the_title();?></h2>
			<p><span class="text-muted"><?php the_date();?></span></p>
			<p><?php the_content();?></p>
			<a href="/">back</a>

			<?php
				$gallery = get_gallery();
				var_dump( $gallery -> data )
			?>
			<br />

			<div class="fb-comments" data-href='<?php get_location();?>' data-numposts="5" data-width="100%"></div>

			<?php endwhile; endif;?>
		</article>	

		<aside class="col-xs-3">
			<?php
				try {
					foreach( get_publications_for( 'publication', TRUE ) -> data as $article ) {
						echo $article;
					}	// end foreach
					unset( $article );
				}	// end try
				catch( Exception $error ) {
					echo $error -> getMessage();
				}	// end catch
			?>
		</aside>
	</div>
</div>