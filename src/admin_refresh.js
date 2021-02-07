jQuery( '#loaderDiv' ).hide();
jQuery( document ).on('click', '#button-refresh', function( e ){
    jQuery.ajax({
        type: 'POST',
        url: '/wp-admin/admin-ajax.php?action=miusage_data_print_refresh',
        beforeSend: function() {
            jQuery( '#loaderDiv' ).show();
            jQuery( '#button-refresh' ).hide();
        },
        success: function( data ) {
            jQuery( '#loaderDiv' ).hide();
            jQuery( '#button-refresh' ).show();
            jQuery( '#data' ).html( data );
        }
    });
});