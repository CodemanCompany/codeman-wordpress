<section class="container">
	<div class="row">
		<?php
			try {
				foreach( get_publications_for( [ 'section' => 'home' ] ) -> data as $post ):?>
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
	</div>
</section>

<aside>
	<div class="container text-center">
		<button type="button" data-ng-click="loadMore()" data-ng-hide="loading">Ver más</button>
		<span class="fa fa-circle-o-notch fa-spin loading" data-ng-show="loading"></span>
	</div>
</aside>

<article>
	<div class="container">
		<contact></contact>
	</div>
</article>