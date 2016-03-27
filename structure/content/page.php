<article>
	<div class="container">
		<?php if( is_preview() ):?>
		<div class="alert alert-info">
			<span class="label label-info">Info</span> This is a draft.
		</div>
		<?php endif;?>
	
		<?php echo get_post_field( 'post_content', $post -> ID );?>
	</div>
</article>