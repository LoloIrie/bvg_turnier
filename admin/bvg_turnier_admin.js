console.log( 'bvg_turnier_admin.js included...' );

jQuery('.admin_block_label').on( 'click', function(){
    jQuery('.admin_block').hide();
    jQuery( this ).next().slideDown();
});

jQuery('.match_winner').on( 'click', function(){
    jMatchId = '#match_winner_' + jQuery( this ).attr('data_m_id');
    jFormId = '#form_match_' + jQuery().attr('data_m_id');
    jQuery( jMatchId ).val( jQuery( this ).attr( 'data' ) );
    jQuery( jFormId ).submit();
});

jQuery('#turnier_select_button').on( 'click', function(){
    jQuery( '#turnier_name').val( '' );
    jQuery( '#turnier_select_id' ).val( jQuery( '#turnier_select' ).val() );
});

jQuery('#spieler_select').on( 'change', function(){
    console.log( jQuery('#spieler_select option:selected').attr( 'data_level' ) );
    jQuery( '#schweizer_system_punkte').val( jQuery('#spieler_select option:selected').attr( 'data_level' ) );
});