( function( window, document, $, undefined ) {
	'use strict';

	const fmq = {

		// initialize custom filter behavior
		init : function () {
			fmq.enableSelect2();
			fmq.updateFavoriteButtons();
			fmq.updateFavoriteFilter();
			fmq.bind();
		},

		// bind event actions
		bind : function () {
			$( 'body' ).on( 'click', '.fmq-favorite', fmq.toggleFavorite );
		},

		// enable the select2 input on all filters
		enableSelect2 : function () {
			$('.fmq-filter').select2({
				'allowClear': true,
				'multiple': true,
				'width': '100%'
			});
		},

		// update the state of all favorite buttons
		updateFavoriteButtons : function () {
			$( '.fmq-favorite' ).each( fmq.updateFavoriteButton ).show();
		},

		// update the state of a single favorite button
		updateFavoriteButton : function ( index, button ) {
			let $button = $( button );
			let postID = $button.data( 'postid' );
			let postType = $button.data( 'posttype' );
			let isFavorited = fmq.isInFavorites( postType, postID );
			let text = isFavorited ? $button.data( 'removetext' ) : $button.data( 'addtext' );

			$button.text( text );
		},

		// set favorites checkbox value to match favorited posts
		updateFavoriteFilter : function () {
			let $filter = $( '.fmq-filter-favorites' );
			let postType = $filter.data( 'posttype' );
			$filter.val( JSON.stringify( fmq.getFavorites( postType ) ) );
		},

		// toggle favorite status
		toggleFavorite: function () {
			let $button = $( this );
			let postID = $button.data( 'postid' );
			let postType = $button.data( 'posttype' );
			let isFavorited = fmq.isInFavorites( postType, postID );

			if ( isFavorited ) {
				fmq.removeFavorite( postType, postID );
			} else {
				fmq.addFavorite( postType, postID );
			}

			fmq.updateFavoriteButton( null, this );
			fmq.updateFavoriteFilter();
		},

		// get all favorites
		getFavorites : function ( postType ) {
			let favorites = window.localStorage.getItem( 'favorites-' + postType );
			let parsed = JSON.parse( favorites );
			return parsed || [];
		},

		// update favorites
		setFavorites : function ( postType, favorites ) {
			window.localStorage.setItem( 'favorites-' + postType, JSON.stringify( favorites ) );
		},

		// check if specific post is in favorites
		isInFavorites : function ( postType, postID ) {
			let favorites = fmq.getFavorites( postType );
			return ( -1 !== favorites.indexOf( postID ) );
		},

		// add post to favorites
		addFavorite : function ( postType, postID ) {
			let favorites = fmq.getFavorites( postType );

			if ( fmq.isInFavorites( postType, postID ) ) {
				return;
			}

			favorites.push( postID );
			fmq.setFavorites( postType, favorites );
		},

		// remove post from favorites
		removeFavorite : function ( postType, postID ) {
			let favorites = fmq.getFavorites( postType );

			if ( ! fmq.isInFavorites( postType, postID ) ) {
				return;
			}

			favorites.splice( favorites.indexOf( postID ), 1 );
			fmq.setFavorites( postType, favorites );
		},

		// remove all favorites
		removeFavorites : function ( postType ) {
			window.localStorage.removeItem( 'favorites-' + postType );
		}

	};

	$(document).on( 'ready', fmq.init );

})( window, document, jQuery );
