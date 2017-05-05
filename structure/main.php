<?php

define( 'IS_CATEGORY', is_category() );
define( 'IS_DRAFT', is_draft() );
define( 'IS_HOME', is_home() );
define( 'IS_MOBILE', wp_is_mobile() );
define( 'IS_PAGE', is_page() );
define( 'IS_SEARCH', is_search() );
define( 'IS_SINGLE', is_single() );

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