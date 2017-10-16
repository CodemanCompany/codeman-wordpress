<div class="container">
	<div class="row">
		<article class="col-xs-9">
			<?php if( is_preview() ):?>
			<div class="alert alert-info">
				<span class="label label-info">Info</span> This is a draft.
			</div>
			<?php endif;?>
			
			<?php if( have_posts() ): while( have_posts() ): the_post();?>

			<!-- Clean Style in line -->
			<div class="fb-like" style="position:relative; top:-7px;" data-href='<?php get_location();?>' data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
			
			<a href="https://twitter.com/share" class="twitter-share-button" data-via="graziamx">Tweet</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

			<script src="https://apis.google.com/js/platform.js" async defer>
			{lang: 'es-419'}
			</script>
			<div class="g-plusone" data-size="medium" data-href="<?php get_location();?>"></div>

			<script type="text/javascript" async defer src="//assets.pinterest.com/js/pinit.js"></script>
			<a href="https://www.pinterest.com/pin/create/button/"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png" alt="Pinterest" /></a>

			<p><strong><?php the_category( ' ' );?></strong></p>
			<img class="img-responsive" src="<?php get_image();?>" alt="" />
			<h2><?php the_title();?></h2>
			<p><span class="text-muted"><?php the_date();?></span></p>
			<p><?php the_content();?></p>
			<a href="/category/<?php echo get_data( 'category', get_the_ID() )[ 0 ] -> slug;?>/">back</a>

			<pre>
			<?php
				$gallery = get_gallery();
				var_dump( $gallery );
				if( $gallery ):
					foreach( $gallery -> images as $image ):?>
						<aside></aside>
				<?php endforeach; unset( $image ); endif;?>
			</pre>

			<?php get_jwplayer( '7ZGeGJG7' );?>

			<div class="fb-comments" data-href='<?php get_location();?>' data-numposts="5" data-width="100%"></div>

			<?php endwhile; endif;?>
		</article>	

		<aside class="col-xs-3">
			<?php get_template_part( 'structure/sidebar' );?>
		</aside>
	</div>
</div>

<script>var gallery = document.querySelector( '.gallery' ); if( gallery ) gallery.hidden = true;</script>