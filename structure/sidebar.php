<?php
	try {
		foreach( get_publications_for( [ 'section' => 'sidebar' ] ) -> data as $post ):?>
			<pre><?php var_dump( $post );?></pre>
		<?php endforeach;
		unset( $post );
	}	// end try
	catch( Exception $error ) {
		echo $error -> getMessage();
	}	// end catch
?>