<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 15:32
 */
//$wpdb->show_errors();

if( isset( $_POST['generate_matchs_now'] ) ){

    $nb_players = count( $players );
    $players_match = $players;

    if( $nb_players%2 == 1 ){
        shuffle( $players );
        $player_notplaying = reset( $players );
        //var_dump( $player_notplaying );

        if( $_SESSION['t_system'] == 1 ){
            /* Schweizer system: Wer nicht spielt bekommt ein Punkt */
            $pl_id = $players_match[0]->players_id;
            $wpdb->query(
                "UPDATE
            ".$wpdb->prefix . 'bvg_players_tournament'."

            SET
            player_level_current=player_level_current+1

            WHERE
            id=".$player_notplaying->id
            );
        }
        $players_match = array_slice( $players, 1);
        $nb_players--;
    }


    $nb_matches = ( $nb_players / 2 );
    if( $_SESSION['t_system'] == 1 ){

        /* Schweizer system */

        if( $_SESSION['round'] < 1 ){

            /* First round */

            usort($players_match, function($a, $b) {
                return $b->player_level_init - $a->player_level_init;
            });

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

                /* Create matches in DB */
                $data = array(
                    'player1_id' => $players_match[ $k_pl1 ]->id,
                    'player2_id' => $players_match[ $k_pl2 ]->id,
                    'tournament_id' => $_SESSION['t_id'],
                    'round' => $_SESSION['round']
                );
                $wpdb->insert( $wpdb->prefix . 'bvg_matches', $data );


                /* Add players opponents in DB */
                $wpdb->query( "UPDATE
                    ".$wpdb->prefix . 'bvg_players_tournament'."

                    SET
                    opponents = concat( opponents, '".$players_match[ $k_pl2 ]->id."', '-' )

                    WHERE
                    id=".$players_match[ $k_pl1 ]->id
                );

                $wpdb->query( "UPDATE
                    ".$wpdb->prefix . 'bvg_players_tournament'."

                    SET
                    opponents = concat( opponents, '".$players_match[ $k_pl1 ]->id."', '-' )

                    WHERE
                    id=".$players_match[ $k_pl2 ]->id
                );

                //echo '<pre>';
                //print_r( $data );
            }
        }else {
            usort($players_match, function($a, $b) {
                return $b->player_level_current - $a->player_level_current;
            });

            for ($i = 0; $i < $nb_matches; $i++) {
                $k_pl1 = $i;
                $k_pl2 = $i + $nb_matches;
                $matches[] = array(
                    'player1_id' => $players_match[$k_pl1]->id,
                    'player2_id' => $players_match[$k_pl2]->id,
                    'player1_name' => $players_match[$k_pl1]->player_firstname . ' ' . $players_match[$k_pl1]->player_lastname,
                    'player2_name' => $players_match[$k_pl2]->player_firstname . ' ' . $players_match[$k_pl2]->player_lastname,
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
                    'player1_id' => $players_match[$k_pl1]->id,
                    'player2_id' => $players_match[$k_pl2]->id,
                    'tournament_id' => $_SESSION['t_id'],
                    'round' => $_SESSION['round']
                );
                $wpdb->insert($wpdb->prefix . 'bvg_matches', $data);

                /* Add players opponents in DB */
                $wpdb->query( "UPDATE
                    ".$wpdb->prefix . 'bvg_players_tournament'."

                    SET
                    opponents = concat( opponents, '".$players_match[ $k_pl2 ]->id."', '-' )

                    WHERE
                    id=".$players_match[ $k_pl1 ]->id
                );

                $wpdb->query( "UPDATE
                    ".$wpdb->prefix . 'bvg_players_tournament'."

                    SET
                    opponents = concat( opponents, '".$players_match[ $k_pl1 ]->id."', '-' )

                    WHERE
                    id=".$players_match[ $k_pl2 ]->id
                );
            }
        }
    }





//echo '<pre>';
//print_r( $players_match );




    $bvg_admin_msg .= '<br />Neue Matches angelegt...';
}


