<section class="container">
	<div class="row">
		<?php
			try {
				foreach( get_publications_for( [ 'section' => 'home' ] ) -> data as $article ):?>
					<pre><?php var_dump( $article );?></pre>
					<div class="social-network">
						<a href="#" data-ng-click="share( $event, { content: '<?php echo $article -> content;?>' }, '<?php echo $article -> url;?>', 'facebook' )"><span class="fa fa-facebook"></span></a>
						<a href="#" data-ng-click="share( $event, { content: '<?php echo $article -> content;?>' }, '<?php echo $article -> url;?>', 'twitter' )"><span class="fa fa-twitter"></span></a>
						<a href="#" data-ng-click="share( $event, { media: '<?php echo $article -> image;?>', content: '<?php echo $article -> content;?>' }, '<?php echo $article -> url;?>', 'pinterest' )"><span class="fa fa-pinterest"></span></a>
						<a href="#" data-ng-click="share( $event, { content: '<?php echo $article -> content;?>' }, '<?php echo $article -> url;?>', 'google-plus' )"><span class="fa fa-google-plus"></span></a>
						<a class="hidden-lg hidden-md hidden-sm" href="#" data-action="share/whatsapp/share" data-ng-click="share( $event, { content: '<?php echo $article -> content;?>' }, '<?php echo $article -> url;?>', 'whatsapp' )"><span class="fa fa-whatsapp"></span></a>
					</div>
				<?php endforeach;
				unset( $article );
			}	// end try
			catch( Exception $error ) {
				echo $error -> getMessage();
			}	// end catch
		?>

		<!-- <article class="article" data-ng-repeat="post in posts" data-ng-click="go( post.url )">
			<div class="content">
				<div class="article-image">
					<img class="img-responsive" data-ng-src="{{post.images.medium_large}}" alt="" />
				</div>
				<span class="category"><a href="{{post.category[ 0 ].url}}">{{post.category[ 0 ].name}}</a></span>
				<div class="article-content">
					<h2><a href="{{post.url}}" data-ng-bind-html="post.title"></a></h2>
					<div data-ng-bind-html="post.content"></div>
					<br />
					<div class="social-networks">
						<a href="#" data-ng-click="share( $event, { media: post.images.medium_large, content: post.title }, post.url, 'facebook' )"><span class="fa fa-facebook"></span></a>
						<a href="#" data-ng-click="share( $event, { content: post.title }, post.url, 'twitter' )"><span class="fa fa-twitter"></span></a>
						<a href="#" data-ng-click="share( $event, { media: post.images.medium_large, content: post.title }, post.url, 'pinterest' )"><span class="fa fa-pinterest"></span></a>
						<a href="#" data-ng-click="share( $event, { content: post.title }, post.url, 'google-plus' )"><span class="fa fa-google-plus"></span></a>
						<a class="hidden-lg hidden-md hidden-sm" href="#" data-action="share/whatsapp/share" data-ng-click="share( $event, { content: post.title }, post.url, 'whatsapp' )"><span class="fa fa-whatsapp"></span></a>
					</div>
				</div>
			</div>
		</article> -->
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