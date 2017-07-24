<?php
if( IS_HOME )
	get_template_part( 'structure/content/home' );
elseif( IS_DRAFT ) {
	if( IS_SINGLE )
		get_template_part( 'structure/content/publication' );
	elseif( IS_PAGE )
		get_template_part( 'structure/content/page' );
}	// end elseif
elseif( IS_SINGLE )
	get_template_part( 'structure/content/publication' );
elseif( IS_CATEGORY )
	get_template_part( 'structure/content/category' );
elseif( IS_SEARCH )
	get_template_part( 'structure/content/search' );
elseif( IS_PAGE ) {
	if( is_page( 'contact' ) )
		get_template_part( 'structure/content/contact' );
	elseif( is_page( 'privacy' ) )
		get_template_part( 'structure/content/privacy' );
	else
		get_template_part( 'structure/content/page' );
}	// end elseif
else
	get_template_part( 'structure/content/404' );