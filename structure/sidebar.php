<?php
	try {
		foreach( get_publications_for( [ 'section' => 'sidebar' ] ) -> data as $post ):?>
			<article><a href="#"><pre><?php var_dump( $post );?></pre></a></article>
		<?php endforeach;
		unset( $post );
	}	// end try
	catch( Exception $error ) {
		echo $error -> getMessage();
	}	// end catch
?>