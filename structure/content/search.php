<?php $results = get_publications_for( [ 's' => get_search( FALSE ), 'post_type' => [ 'post' ] ] ) -> data;?>
<section>
	<div class="container">
		<h2>Resultados de búsqueda por: <span class="text-muted"><?php get_search();?></span></h2>

		<?php
			try {
				foreach( $results as $post ):?>
					<article><a href="#"><pre><?php var_dump( $post );?></pre></a></article>
				<?php endforeach;
				unset( $post );
			}	// end try
			catch( Exception $error ) {
				echo $error -> getMessage();
			}	// end catch
		?>
		<?php if( count( $results ) === 0 ):?>
			<p>No se encontraron resultados para la búsqueda.</p>
		<?php endif;?>

		<article data-ng-repeat="post in posts" data-ng-click="go( post.url )">
			<a href="#">{{post|json}}</a>
		</article>
	</div>
</section>

<aside>
	<div class="container text-center">
		<button type="button" data-ng-click="loadMore( { 's': '<?php echo get_search( FALSE );?>' } )" data-ng-hide="loading">Ver más</button>
		<span class="fa fa-circle-o-notch fa-spin loading" data-ng-show="loading"></span>
	</div>
</aside>