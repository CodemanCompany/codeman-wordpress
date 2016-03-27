<section class="container">
	<div class="row">
		<?php
			try {
				foreach( get_publications_for( 'home', TRUE ) -> data as $article ) {
					echo $article;
				}	// end foreach
				unset( $article );
			}	// end try
			catch( Exception $error ) {
				echo $error -> getMessage();
			}	// end catch
		?>

		<div class="social-network">
			<a href="#" data-ng-click="share( $event, 'test', 'http://olsonindmx.artezia.mx/', 'facebook' )"><span class="fa fa-facebook"></span></a>
			<a href="#" data-ng-click="share( $event, 'test', 'http://olsonindmx.artezia.mx/', 'twitter' )"><span class="fa fa-twitter"></span></a>
		</div>

		<!-- <article class="col-xs-4 card" data-ng-repeat="post in posts" data-ng-click="go( post.url )">
			<div class="content">
				<div class="card-image">
					<img class="img-responsive" data-ng-src="{{post.image}}" alt="" />
				</div>
				<span class="category"><a href="{{post.category.url}}">{{post.category.name}}</a></span>
				<div class="card-content">
					<h2><a href="{{post.url}}">{{post.title}}</a></h2>
					<p>{{post.content}}</p>
					<br />
					<div><a class="shared" href="#">COMPARTIR</a></div>
				</div>
			</div>
		</article> -->
	</div>
</section>

<aside>
	<div class="container text-center">
		<button type="button" data-ng-click="loadMore( 'uncategorized' )" data-ng-hide="loading">Ver más</button>
		<span class="fa fa-circle-o-notch fa-spin loading" data-ng-show="loading"></span>
	</div>
</aside>

<!-- <article>
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<a class="twitter-timeline" href="https://twitter.com/tavo962" data-widget-id="699110421223968768">Tweets por el @tavo962.</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			</div>
			<div class="col-sm-6 text-center">
				<div class="fb-page" data-href="https://www.facebook.com/ITTLA/" data-tabs="timeline" data-height="500" data-small-header="false" data-adapt-container-width="false" data-hide-cover="false" data-show-facepile="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/ITTLA/"><a href="https://www.facebook.com/ITTLA/">ITTLA - Instituto Tecnológico de Tlalnepantla</a></blockquote></div></div>
			</div>
		</div>
	</div>
</article> -->

<!-- <article>
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<div class="embed-responsive embed-responsive-4by3">
					<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/zyKa0aSQwDI?list=PL6LPvqvHdclbrYqIdNLm5zOodZrebZaln&amp;showinfo=0" allowfullscreen="allowfullscreen"></iframe>
				</div>
			</div>

			<div class="col-sm-6">
				<div class="embed-responsive embed-responsive-4by3">
					<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/zyKa0aSQwDI?list=PL6LPvqvHdclbrYqIdNLm5zOodZrebZaln&amp;showinfo=0" allowfullscreen="allowfullscreen"></iframe>
				</div>
			</div>
		</div>
		<br /><br />
	</div>
</article> -->

<article>
	<div class="container">
		<form name="form" novalidate="novalidate">
			<div class="input-group">
				<input maxlength="100" name="search" type="search" data-ng-model="input.search" data-ng-required="true" />
				<span class="input-group-btn">
					<button class="btn btn-default" type="submit" data-ng-disabled="form.$invalid" data-ng-click="search( $event, input.search )">
						<span class="fa fa-search"></span>
					</button>
				</span>
			</div>
		</form>
	</div>
</article>

<article data-ng-controller="ContactController">
	<div class="container">
		<div class="alert alert-info text-center" data-ng-show="alert.code === 200">
			<strong><span class="fa fa-paper-plane"></span> Mensaje Enviado - Gracias por escribir.</strong>
		</div>

		<div class="alert alert-danger text-center" data-ng-show="alert.status === 'error'">
			<strong><span class="fa fa-times"></span> Lo sentimos el mensaje no fue enviado, por favor intentalo más tarde.</strong>
		</div>

		<form>
			<div class="row">
				<div class="col-sm-6">
					<input maxlength="100" placeholder="Nombre" type="text" data-ng-model="input.name" data-ng-change="validate.name( input.name )" />
					<span class="error" data-ng-show="status.name.status === false">Escribe tu nombre.</span>
					<br class="hidden-sm hidden-md hidden-lg" /><br class="hidden-sm hidden-md hidden-lg" />
				</div>
				<div class="col-sm-6">
					<input maxlength="60" placeholder="Correo Electrónico" type="email" data-ng-model="input.email" data-ng-change="validate.email( input.email )" />
					<span class="error" data-ng-show="status.email.status === false">Escribe tu correo electrónico.</span>
				</div>
			</div>
			<br />
			<input maxlength="100" placeholder="Asunto" type="text" data-ng-model="input.subject" data-ng-change="validate.subject( input.subject )" />
			<span class="error" data-ng-show="status.subject.status === false">Escribe el asunto.</span>
			<br /><br />
			<span class="error pull-left" data-ng-show="! status.message.status">10 caracteres mínimo</span>
			<p class="pull-right"><span class="fa fa-pencil"></span> {{( input.message.length ) ? input.message.length : 0}} de 500 caracteres.</p>
			<textarea maxlength="500" placeholder="Mensaje (Mínimo 10 caracteres)" rows="5" data-ng-model="input.message" data-ng-change="validate.message( input.message )"></textarea>

			<!-- <input placeholder="Teléfono" type="tel" data-ng-model="input.tel" /> -->
			<div class="checkbox">
				<label>
					<input type="checkbox" data-ng-model="privacy" /> <strong>Acepto las condiciones del servicio y la política de privacidad de Codeman.</strong>
				</label>
			</div>

			<br />

			<div class="g-recaptcha" data-sitekey="6LemrxcTAAAAADw2IaqCY0-arquCK1qcGNprv34E"></div>
			<span class="error" data-ng-show="status.recaptcha.status === false">Completa el reCAPTCHA por favor.</span>

			<div class="text-right">
				<button class="btn btn-primary" type="button" data-ng-disabled="! status.email.status || ! status.message.status || ! status.name.status || ! status.subject.status || ! privacy || loading" data-ng-click="contact()">
					<span data-ng-show="loading"><span class="fa fa-spinner fa-pulse"></span> Enviando</span>
					<span data-ng-hide="loading">Enviar Contacto</span>
				</button>
			</div>
		</form>
		{{input|json}}
	</div>
</article>