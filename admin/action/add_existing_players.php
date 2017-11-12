<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 15:32
 */

if( is_numeric( $_POST['spieler_select'] ) ){
    $data = array(
        'tournament_id' => $_SESSION['t_id'],
        'players_id' => $_POST['spieler_select'],
        'player_level_init' => $_POST['schweizer_system_punkte']
    );
    $wpdb->insert( $wpdb->prefix . 'bvg_players_tournament', $data );


    $bvg_admin_msg .= 'Spieler für das Turnier gespeichert...';
}

