<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 14:14
 */

if ( !defined( 'ABSPATH' ) ) die();
global $wpdb;
$bvg_admin_msg = '';


/* Actions */
if( isset($_POST['form_action']) ){
    include plugin_dir_path(__FILE__). 'action/'.$_POST['form_action'].'.php';
}
//echo 'XXX'.$_SESSION['round'];
if( !isset( $_SESSION['t_id'] ) ){
    $_SESSION['t_id'] = 1;
    $_SESSION['t_name'] = 'BVG Turnier';
}
if( !isset( $_SESSION['round'] ) ){
    $round = $wpdb->get_results( "SELECT round FROM ".$wpdb->prefix."bvg_tournaments WHERE id=".$_SESSION['t_id']." LIMIT 0,1" );
    $_SESSION['round'] = $round[0]->round;
}

/* Get DB content */
include plugin_dir_path(__FILE__). 'db_get_content.php';



/* Generate matches if required */
if( empty($matches) ){
    //echo $query;
    include plugin_dir_path(__FILE__). 'action/generate_matches.php';
}

/* Msg */
if( !empty( trim( $bvg_admin_msg ) ) ){
    echo '<div id="bvg_admin_msg">'.$bvg_admin_msg.'</div>';
/*
    echo '<div><pre>';
    var_dump( $_POST );
    echo '</pre></div>';
*/
}







/* Forms */
echo '<h1>Administration !!!</h1>';



/*
echo '<pre>';
var_dump( $players );
echo '<hr />';
var_dump( $all_players );
echo '</pre>';
*/
echo '<h3>'.$_SESSION['t_name'] .' ( Round: '.$_SESSION['round'].')</h3>';



/* Tournament */
echo '<div class="admin_block_label">Turnier Verwaltung</div>';
echo '<div class="admin_block" id="block_tournament_select">';
echo '<form method="post">';
echo '<input type="hidden" name="form_action" value="tournament_select" />';
echo '<input type="hidden" name="turnier_select_id" value="'.$_SESSION['t_id'].'" />';



echo '<label>Turnier auswählen: </label>';
echo '<select type="text" value="" name="turnier_select">';
echo '<option value="0">Auswählen</option>';
foreach( $tournaments as $tournament ){
    echo '<option value="'.$tournament->id.'" '.( $tournament->id == $_SESSION['t_id'] ? 'selected="selected"' : '' ).'>'.$tournament->name.'</option>';
    if( $tournament->id == $_SESSION['t_id'] ){
        $_SESSION['t_name'] = $tournament->name;
        $_SESSION['t_round'] = $tournament->round;
        $_SESSION['t_system'] = $tournament->system;
        $_SESSION['t_nb_sets'] = $tournament->nb_sets;
        $_SESSION['t_points_set'] = $tournament->points_set;
        $_SESSION['t_max_points_set'] = $tournament->max_points_set;
    }
}
echo '</select>';
echo '<input type="submit" value="Turnier auswählen" id="turnier_select_button" />';
echo '<br />';
echo '<br />';
echo '<label>Neuer Turnier: </label>';
echo '<input type="text" value="" placeholder="Turnier Name" name="turnier_name" />';
echo '<br />';

echo '<input type="submit" value="Turnier anlegen" />';


echo '</form>';


echo '<hr />';
echo '<form method="post">';
echo '<input type="hidden" name="form_action" value="tournament_config" />';

echo '<label>Turnier System: </label>';
echo '<div class="radio_block">';
echo '<span><input type="radio" id="turnier_system1" name="turnier_system" value="1" checked="checked" disabled="disabled" /> <label for="turnier_system1" class="radio">Schweizer System</label></span><br />';
echo '<span><input type="radio" id="turnier_system2" name="turnier_system" value="2" disabled="disabled" /> <label for="turnier_system1" class="radio">Meisterschaft</label></span><br />';
echo '<span><input type="radio" id="turnier_system3" name="turnier_system" value="3" disabled="disabled" /> <label for="turnier_system1" class="radio">KO System</label></span>';
echo '</div>';

echo '<input type="submit" value="Turnier anpassen" disabled="disabled" />';

echo '</form>';

echo '</div>';




/* Add player */
echo '<div class="admin_block_label">Neuer Spieler hinfügen</div>';
echo '<div class="admin_block" id="block_add_players">';

    echo '<form method="post">';
    echo '<input type="hidden" name="form_action" value="add_existing_players" />';

    echo '<label>Spieler: </label>';
    echo '<select type="text" value="" name="spieler_select">';
    echo '<option value="0">Auswählen</option>';
    foreach( $all_players as $k => $all_player ){
        foreach( $players as $player ){
            if( $player->players_id == $k ){
                continue 2;
            }
        }

        echo '<option value="'.$all_player->player_id.'" >'.$all_player->player_firstname.' '.$all_player->player_lastname.'</option>';
    }
    echo '</select>';

    echo '<input type="submit" value="Spieler für das Turnier anlegen" />';

    echo '</form>';

    echo '<form method="post">';
    echo '<input type="hidden" name="form_action" value="add_players" />';



    echo '<label>Vorname: </label>';
    echo '<input type="text" value="" placeholder="Vorname" name="firstname" />';
    echo '<label>Nachname: </label>';
    echo '<input type="text" value="" placeholder="Nachname" name="lastname" />';

    echo '<input type="submit" value="Neuer Spieler anlegen" />';


    echo '</form>';


echo '</div>';





/* Table */

//echo '<pre>';
//var_dump( $players );

echo '<div class="admin_block_label">Tabelle</div>';
echo '<div class="admin_block" id="block_table">';
echo '<form method="post">';
echo '<input type="hidden" name="form_action" value="next_round" />';

echo '<ul class="table">';
echo '<li class="table_header">';
echo '<span class="pl_name">';
echo "Spieler";
echo "</span>";
echo '<span class="pl_played">';
echo "Spiele";
echo "</span>";
echo '<span class="pl_victory">';
echo "S";
echo "</span>";
echo '<span class="pl_draw">';
echo "U";
echo "</span>";
echo '<span class="pl_loss">';
echo "N";
echo "</span>";
echo '<span class="pl_points_major">';
echo "Punkte";
echo "</span>";
echo '<span class="pl_sets">';
echo "Sätze";
echo "</span>";
echo '<span class="pl_points">';
echo "Spielpunkte";
echo "</span>";
echo '</li>';

foreach( $players as $k => $player ){


    echo '<li class="table_row">';
    echo '<span class="pl_name">';
    echo $player->player_firstname.' '.$player->player_lastname;
    echo "</span>";

    echo '<span class="pl_played">';
    echo $player->played;
    echo "</span>";

    echo '<span class="pl_victory">';
    echo $player->victory;
    echo "</span>";

    echo '<span class="pl_draw">';
    echo $player->draw;
    echo "</span>";

    echo '<span class="pl_loss">';
    echo $player->loss;
    echo "</span>";

    echo '<span class="pl_points_major">';
    echo $player->points_major;
    echo "</span>";

    echo '<span class="pl_sets">';
    echo $player->sets;
    echo ' - ';
    echo $player->sets_against;
    echo "</span>";

    echo '<span class="pl_points">';
    echo $player->points;
    echo ' - ';
    echo $player->points_against;
    echo "</span>";
    echo '</li>';
}
echo '</ul>';

echo '<input type="submit" value="Nächster Round" class="next_round" />';

echo '</form>';
echo '</div>';


/* Matches */






echo '<div class="admin_block_label">Spiele</div>';
echo '<div class="admin_block" id="block_spiele">';

//var_dump( $players );
foreach( $matches as $match ){
    $pl1_set1 = 0;
    $pl1_set2 = 0;
    $pl1_set3 = 0;
    $pl1_set4 = 0;
    $pl1_set5 = 0;
    $pl2_set1 = 0;
    $pl2_set2 = 0;
    $pl2_set3 = 0;
    $pl2_set4 = 0;
    $pl2_set5 = 0;
    if( !is_array( $match ) ){
        //var_dump($players[ $match->player1_id ]);
        $player1_name = $players[ $match->player1_id ]->player_firstname.' '.$players[ $match->player1_id ]->player_lastname;
        $player2_name = $players[ $match->player2_id ]->player_firstname.' '.$players[ $match->player2_id ]->player_lastname;
        $m_id = $match->id;
        $pl1_id = $match->player1_id;
        $pl2_id = $match->player2_id;
        $winner = $match->winner;

        $pl1_set1 = $match->pl1_set1;
        $pl1_set2 = $match->pl1_set2;
        $pl1_set3 = $match->pl1_set3;
        $pl1_set4 = $match->pl1_set4;
        $pl1_set5 = $match->pl1_set5;
        $pl2_set1 = $match->pl2_set1;
        $pl2_set2 = $match->pl2_set2;
        $pl2_set3 = $match->pl2_set3;
        $pl2_set4 = $match->pl2_set4;
        $pl2_set5 = $match->pl2_set5;
    }else{
        $player1_name = $match['player1_name'];
        $player2_name = $match['player2_name'];
        $pl1_id = $match['player1_id'];
        $pl2_id = $match['player2_id'];
        $winner = $match['winner'];
        $m_id = $match['id'];
    }



    //var_dump( $match );
    echo '<form method="post" id="match_form_'.$m_id.'">';
    echo '<input type="hidden" name="form_action" value="game_result" />';
    echo '<input type="hidden" name="match_id" value="'.$m_id.'" />';
    echo '<input type="hidden" name="pl1_id" value="'.$pl1_id.'" />';
    echo '<input type="hidden" name="pl2_id" value="'.$pl2_id.'" />';
    echo '<input type="hidden" id="match_winner_'.$m_id.'" name="match_winner_'.$m_id.'" value="" />';

    echo '<div>';
    echo '<input type="text" value="'.$player1_name.'" name="pl1_m'.$m_id.'_name" class="player_name '.( $winner == $pl1_id ? 'winner' : '' ).' '.( $winner == $pl2_id ? 'loser' : '' ).'" />';
    echo '<input type="text" value="'.$pl1_set1.'" name="pl1_m'.$m_id.'_set1" class="set_score" />';
    echo '<input type="text" value="'.$pl1_set2.'" name="pl1_m'.$m_id.'_set2" class="set_score" />';
    echo '<input type="text" value="'.$pl1_set3.'" name="pl1_m'.$m_id.'_set3" class="set_score" />';
    echo '<input type="text" value="'.$pl1_set4.'" name="pl1_m'.$m_id.'_set4" class="set_score" />';
    echo '<input type="text" value="'.$pl1_set5.'" name="pl1_m'.$m_id.'_set5" class="set_score" />';
    echo '<input type="submit" value="Sieger" class="match_winner" data="'.$pl1_id.'" data_m_id="'.$m_id.'" />';
    echo '</div>';

    echo '<div>';
    echo '<input type="text" value="'.$player2_name.'" name="pl2_m'.$m_id.'_name" class="player_name '.( $winner == $pl2_id ? 'winner' : '' ).' '.( $winner == $pl1_id ? 'loser' : '' ).'" />';
    echo '<input type="text" value="'.$pl2_set1.'" name="pl2_m'.$m_id.'_set1" class="set_score" />';
    echo '<input type="text" value="'.$pl2_set2.'" name="pl2_m'.$m_id.'_set2" class="set_score" />';
    echo '<input type="text" value="'.$pl2_set3.'" name="pl2_m'.$m_id.'_set3" class="set_score" />';
    echo '<input type="text" value="'.$pl2_set4.'" name="pl2_m'.$m_id.'_set4" class="set_score" />';
    echo '<input type="text" value="'.$pl2_set5.'" name="pl2_m'.$m_id.'_set5" class="set_score" />';
    echo '<input type="submit" value="Sieger" class="match_winner" data="'.$pl2_id.'" data_m_id="'.$m_id.'" />';
    echo '</div>';


    echo '<br />';

    echo '<input type="submit" value="Match aktualisieren" />';

    echo '<br /><br /><hr />';

    echo '</form>';
}


echo '</div>';




?>
<script>
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

</script>
<?php