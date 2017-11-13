<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 15:32
 */

/*
echo '<pre>';
var_dump( $all_players );
echo '</pre>';
*/
//$wpdb->show_errors();
if( isset( $_POST['alle_spieler'] ) ){

    $query = "SELECT
    pl.id as player_id,
    pl.player_level as player_level_init
    
    FROM
    ".$wpdb->prefix."bvg_players as pl";
    $all_players = $wpdb->get_results( $query, OBJECT_K  );

    foreach( $all_players as $pl ){
        $data = array(
            'tournament_id' => $_SESSION['t_id'],
            'players_id' => $pl->player_id,
            'player_level_init' => $pl->player_level_init
        );
        $wpdb->insert( $wpdb->prefix . 'bvg_players_tournament', $data );
    }
    unset( $all_players );


    $bvg_admin_msg .= 'Alle Spieler für das Turnier gespeichert...';

}else if( is_numeric( $_POST['spieler_select'] ) ){
    $data = array(
        'tournament_id' => $_SESSION['t_id'],
        'players_id' => $_POST['spieler_select'],
        'player_level_init' => $_POST['schweizer_system_punkte']
    );
    $wpdb->insert( $wpdb->prefix . 'bvg_players_tournament', $data );


    $bvg_admin_msg .= 'Spieler für das Turnier gespeichert...';
}

