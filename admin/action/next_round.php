<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 15:32
 */


$data = array(
    'firstname' => $_POST['firstname'],
    'lastname' => $_POST['lastname']
);
$wpdb->insert( $wpdb->prefix . 'bvg_players', $data );


$data = array(
    'tournament_id' => 1,
    'players_id' => $wpdb->insert_id
);
$wpdb->insert( $wpdb->prefix . 'bvg_players_tournament', $data );


$bvg_admin_msg .= 'Neuer Spieler gespeichert...';