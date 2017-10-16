<?php
var_dump( CATEGORY );
?>
<div class="container">
	<h1><?php echo CATEGORY[ 'name' ];?></h1>

	<div class="row">
		<section class="col-xs-9">
			<?php
				try {
					foreach( get_publications_for( [ 'category__and' => CATEGORY[ 'slug' ] ] ) -> data as $post ):?>
						<article><a href="#"><pre><?php var_dump( $post );?></pre></a></article>
					<?php endforeach;
					unset( $post );
				}	// end try
				catch( Exception $error ) {
					echo $error -> getMessage();
				}	// end catch
			?>

			<article data-ng-repeat="post in posts" data-ng-click="go( post.url )">
				<a href="#">{{post|json}}</a>
			</article>

			<aside>
				<div class="text-center">
					<button type="button" data-ng-click="loadMore( { 'categories': '<?php echo CATEGORY[ 'slug' ];?>' } )" data-ng-hide="loading">Ver más</button>
					<span class="fa fa-circle-o-notch fa-spin loading" data-ng-show="loading"></span>
				</div>
			</aside>
		</section>

		<aside class="col-xs-3">
			<?php get_template_part( 'structure/sidebar' );?>
		</aside>
	</div>
</div>