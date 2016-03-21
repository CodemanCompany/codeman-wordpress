<?php

if( is_home() )
	get_template_part( 'structure/content/home' );
elseif( is_single() )
	get_template_part( 'structure/content/publication' );
elseif( is_category() )
	get_template_part( 'structure/content/category' );
elseif( is_search() )
	get_template_part( 'structure/content/search' );
else
	get_template_part( 'structure/content/page' );