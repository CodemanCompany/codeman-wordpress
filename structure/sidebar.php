<?php
	try {
		foreach( get_publications_for( [ 'section' => 'sidebar' ] ) -> data as $article ):?>
			<pre><?php var_dump( $article );?></pre>
		<?php endforeach;
		unset( $article );
	}	// end try
	catch( Exception $error ) {
		echo $error -> getMessage();
	}	// end catch
?>