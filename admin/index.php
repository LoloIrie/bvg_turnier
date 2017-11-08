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
if( !isset( $_SESSION['round'] ) ){
    $_SESSION['round'] = 1;
    //echo 'Hmmmmm';
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

$query = "SELECT
*

FROM
".$wpdb->prefix."bvg_tournaments

WHERE
id = 1
";
$tournaments = $wpdb->get_results( $query  );
$tournament_name = $tournaments[0]-> name;
echo '<h3>'.$tournament_name .' ( Round: '.$_SESSION['round'].')</h3>';


/* Add player */
echo '<div class="admin_block_label">Neuer Spieler hinfügen</div>';
echo '<div class="admin_block" id="block_add_players">';
    echo '<form method="post">';
    echo '<input type="hidden" name="form_action" value="add_players" />';



    echo '<label>Vorname: </label>';
    echo '<input type="text" value="" placeholder="Vorname" name="firstname" />';
    echo '<label>Nachname: </label>';
    echo '<input type="text" value="" placeholder="Nachname" name="lastname" />';

    echo '<input type="submit" value="Add players" />';


    echo '</form>';
echo '</div>';





/* Table */
$query = "SELECT
pl_t.id as id,
pl.id as player_id,
pl.firstname as player_firstname,
pl.lastname as player_lastname,
pl_t.*

FROM
".$wpdb->prefix."bvg_players as pl
JOIN
".$wpdb->prefix."bvg_players_tournament as pl_t
ON
pl.id = pl_t.players_id

WHERE
pl_t.tournament_id = 1

ORDER BY
pl_t.points_major DESC, pl_t.sets DESC, pl_t.sets_against ASC, pl_t.points DESC, pl_t.points_against ASC, pl_t.player_level_init DESC
";
$players = $wpdb->get_results( $query, OBJECT_K  );
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


$query = "SELECT
*

FROM
".$wpdb->prefix."bvg_matches

WHERE
tournament_id = 1
AND
round = ".$_SESSION['round']."

ORDER BY
id ASC
";
$matches = $wpdb->get_results( $query );

/* Generate matches if required */
if( empty($matches) ){
    //echo $query;
    include plugin_dir_path(__FILE__). 'action/generate_matches.php';
}



echo '<div class="admin_block_label">Spiele</div>';
echo '<div class="admin_block" id="block_spiele">';

//var_dump( $players );
foreach( $matches as $match ){
    if( !is_array( $match ) ){
        //var_dump($players[ $match->player1_id ]);
        $player1_name = $players[ $match->player1_id ]->player_firstname.' '.$players[ $match->player1_id ]->player_lastname;
        $player2_name = $players[ $match->player2_id ]->player_firstname.' '.$players[ $match->player2_id ]->player_lastname;
        $pl1_id = $match->player1_id;
        $pl2_id = $match->player2_id;
        $winner = $match->winner;
    }else{
        $player1_name = $match['player1_name'];
        $player2_name = $match['player2_name'];
        $pl1_id = $match['player1_id'];
        $pl2_id = $match['player2_id'];
        $winner = $match['winner'];
    }

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

    //var_dump( $match );
    echo '<form method="post" id="match_form_'.$match->id.'">';
    echo '<input type="hidden" name="form_action" value="game_result" />';
    echo '<input type="hidden" name="match_id" value="'.$match->id.'" />';
    echo '<input type="hidden" name="pl1_id" value="'.$pl1_id.'" />';
    echo '<input type="hidden" name="pl2_id" value="'.$pl2_id.'" />';
    echo '<input type="hidden" id="match_winner_'.$match->id.'" name="match_winner_'.$match->id.'" value="" />';

    echo '<div>';
    echo '<input type="text" value="'.$player1_name.'" name="pl1_m'.$match->id.'_name" class="player_name '.( $winner == $pl1_id ? 'winner' : '' ).' '.( $winner == $pl2_id ? 'loser' : '' ).'" />';
    echo '<input type="text" value="'.$pl1_set1.'" name="pl1_m'.$match->id.'_set1" class="set_score" />';
    echo '<input type="text" value="'.$pl1_set2.'" name="pl1_m'.$match->id.'_set2" class="set_score" />';
    echo '<input type="text" value="'.$pl1_set3.'" name="pl1_m'.$match->id.'_set3" class="set_score" />';
    echo '<input type="text" value="'.$pl1_set4.'" name="pl1_m'.$match->id.'_set4" class="set_score" />';
    echo '<input type="text" value="'.$pl1_set5.'" name="pl1_m'.$match->id.'_set5" class="set_score" />';
    echo '<input type="submit" value="Sieger" class="match_winner" data="'.$pl1_id.'" data_m_id="'.$match->id.'" />';
    echo '</div>';

    echo '<div>';
    echo '<input type="text" value="'.$player2_name.'" name="pl2_m'.$match->id.'_name" class="player_name '.( $winner == $pl2_id ? 'winner' : '' ).' '.( $winner == $pl1_id ? 'loser' : '' ).'" />';
    echo '<input type="text" value="'.$pl2_set1.'" name="pl2_m'.$match->id.'_set1" class="set_score" />';
    echo '<input type="text" value="'.$pl2_set2.'" name="pl2_m'.$match->id.'_set2" class="set_score" />';
    echo '<input type="text" value="'.$pl2_set3.'" name="pl2_m'.$match->id.'_set3" class="set_score" />';
    echo '<input type="text" value="'.$pl2_set4.'" name="pl2_m'.$match->id.'_set4" class="set_score" />';
    echo '<input type="text" value="'.$pl2_set5.'" name="pl2_m'.$match->id.'_set5" class="set_score" />';
    echo '<input type="submit" value="Sieger" class="match_winner" data="'.$pl2_id.'" data_m_id="'.$match->id.'" />';
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

</script>
<?php