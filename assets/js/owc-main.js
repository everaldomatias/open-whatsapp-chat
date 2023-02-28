
jQuery(document).ready(function ($) {

    $('#owc-button').click(function() {

        var data = {
            'action': 'update_position_number'
        };

        $.post( ajax_object.ajax_url, data, function ( response ) {
            return;
        });

    });

});