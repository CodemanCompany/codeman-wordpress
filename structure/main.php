<?php

if( is_home() )
	get_template_part( 'structure/content/home' );
elseif( is_draft() ) {
	if( is_single() )
		get_template_part( 'structure/content/publication' );
	elseif(is_page())
		get_template_part( 'structure/content/page' );
}	// end elseif
elseif( is_single() )
	get_template_part( 'structure/content/publication' );
elseif( is_category() )
	get_template_part( 'structure/content/category' );
elseif( is_search() )
	get_template_part( 'structure/content/search' );
elseif( is_page() ) {
	if( is_page( 'contact' ) )
		get_template_part( 'structure/content/contact' );
	elseif( is_page( 'privacy' ) )
		get_template_part( 'structure/content/privacy' );
	else
		get_template_part( 'structure/content/page' );
}	// end elseif
else
	get_template_part( 'structure/content/404' );