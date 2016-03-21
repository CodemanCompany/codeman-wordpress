'use strict'

var app = angular.module( 'app', [] )

.config( function() {
	$( document ).ready( function() {
		$( 'input:not( [ type = "checkbox" ], [ type = "radio" ], [ type = "submit" ] ), select, textarea' ).addClass( 'form-control' );
		// $( 'a[ href ^= "http" ], a[ href ^= "https" ] , a[ href *="files" ]' ).attr( 'target', '_blank' );
		// write

		// Gallery
		var gallery = {
			"object":	$( '#gallery-generic .gallery-content' ),
			"left":		$( '#gallery-generic .left' ),
			"right":	$( '#gallery-generic .right' ),
			"displacement":	0,
			"total":	function() {
				return document.querySelectorAll( '#gallery-generic .gallery-content picture' ).length * 300 - this.object.width();
			},
			"time":		300,
			"back":	function() {
				this.right.prop( 'disabled', false );

				if( this.displacement >= this.jump ) {
					this.displacement -= this.jump;

					if( this.displacement - this.jump < this.jump ) {
						this.left.prop( 'disabled', true );
						return '0px';
					}	// end if

					return ( this.displacement ) + 'px';
				}	// end if

				else
					this.left.prop( 'disabled', true );

			},
			"next":	function() {
				this.left.prop( 'disabled', false );

				if( this.displacement <= this.total() ) {
					this.displacement += this.jump;

					if( this.displacement + this.jump > this.total() ) {
						this.right.prop( 'disabled', true );
						return ( this.total() + 100 ) + 'px';
					}	// end if

					return ( this.displacement ) + 'px';
				}	// end if

				else
					this.right.prop( 'disabled', true );


			},
			"start":	function() {
				this.left.prop( 'disabled', true );

				if( this.total() < 0 )
					this.right.prop( 'disabled', true );

				this.left.click( function( event ) {
					event.preventDefault();

					gallery.object.animate( {
						"scrollLeft": gallery.back()
					}, gallery.time )

				} );

				this.right.click( function( event ) {
					event.preventDefault();

					gallery.object.animate( {
						"scrollLeft": gallery.next()
					}, gallery.time )

				} );
			},
			"jump":	200
		};

		$( '.fancybox' ).fancybox( {
			"padding":	0,
			helpers	: {
			title	: {
				type: 'outside'
			},
			thumbs	: {
				width	: 50,
				height	: 50
			}
		}
		} );

		// console.log( gallery.total() );

		gallery.start();
	} );
} );