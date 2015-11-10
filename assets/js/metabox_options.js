jQuery( function ( $ ) {
    $( '.yith-wccos-color-picker' ).wpColorPicker();

    // hide preview button and View order status button
    $( '#view-post-btn' ).hide();
    $( '#preview-action' ).hide();

    var slug       = function ( str ) {
            str = str.replace( /^\s+|\s+$/g, '' ); // trim
            str = str.toLowerCase();

            var cod = 0;
            for ( var i = 0, l = str.length; i < l; i++ ) {
                cod += str.charCodeAt( i );
            }
            cod = cod % 1000;

            // remove accents, swap ñ for n, etc
            var from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;";
            var to   = "aaaaaeeeeeiiiiooooouuuunc------";
            for ( var i = 0, l = from.length; i < l; i++ ) {
                str = str.replace( new RegExp( from.charAt( i ), 'g' ), to.charAt( i ) );
            }

            str = str.replace( /[^a-z0-9 -]/g, '' ) // remove invalid chars
                .replace( /\s+/g, '' ) // collapse whitespace and replace by -
                .replace( /-+/g, '' ); // collapse dashes

            var delta = 0;

            if ( str.length >= 1 ) {
                if ( cod < 1 ) {
                    delta = 3;
                    cod   = '';
                } else if ( cod < 10 ) {
                    delta = 2;
                } else if ( cod < 100 ) {
                    delta = 1;
                }
                return str.substr( 0, (14 + delta) ) + cod;
            }
            return str;
        },
        slug_field = $( '#slug' ),
        title      = $( '#title' );

    slug_field.prop( 'readonly', true );

    if ( slug_field.val().length < 1 ) {
        // Fix for drafted statuses
        if ( title.val().length > 0 ) {
            slug_field.val( slug( title.val() ) );
        }

        title.on( 'keyup', function () {
            slug_field.val( slug( title.val() ) );
        } );
    }
} );