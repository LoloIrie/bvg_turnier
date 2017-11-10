<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 15:32
 */



$nb_players = count( $players );
$players_match = $players;
if( $nb_players%2 == 1 ){
    shuffle( $players );
    $players_match = array_slice( $players, 1);
    $nb_players--;
}

usort($players_match, function($a, $b) {
    return $b->player_level_init - $a->player_level_init;
});

$nb_matches = ( $nb_players / 2 );

for( $i=0; $i<$nb_matches; $i++ ){
    $k_pl1 = $i;
    $k_pl2 = $i + $nb_matches;
    $matches[] = array(
        'player1_id' => $players_match[ $k_pl1 ]->id,
        'player2_id' => $players_match[ $k_pl2 ]->id,
        'player1_name' => $players_match[ $k_pl1 ]->player_firstname.' '.$players_match[ $k_pl1 ]->player_lastname,
        'player2_name' => $players_match[ $k_pl2 ]->player_firstname.' '.$players_match[ $k_pl2 ]->player_lastname,
        'tournament_id' => 1,
        'round' => $_SESSION['round'],
        'pl1_set1' => 0,
        'pl2_set1' => 0,
        'pl1_set2' => 0,
        'pl2_set2' => 0,
        'pl1_set3' => 0,
        'pl2_set3' => 0,
        'pl1_set4' => 0,
        'pl2_set4' => 0,
        'pl1_set5' => 0,
        'pl2_set5' => 0,
        'parent_id' => 0
    );

    $data = array(
        'player1_id' => $players_match[ $k_pl1 ]->id,
        'player2_id' => $players_match[ $k_pl2 ]->id,
        'tournament_id' => 1,
        'round' => $_SESSION['round']
    );
    $wpdb->insert( $wpdb->prefix . 'bvg_matches', $data );
    //echo '<pre>';
    //print_r( $data );
}


//echo '<pre>';
//print_r( $players_match );




$bvg_admin_msg .= '<br />Neue Matches angelegt...';