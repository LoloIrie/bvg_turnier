<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 13.11.2017
 * Time: 09:12
 */


/* Matches */


$html .= '<div class="admin_block_label">Spiele</div>';
$html .= '<div class="admin_block" id="block_spiele">';
$html .= '<form method="post">';

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
    $html .= '<form method="post" id="match_form_'.$m_id.'">';
    $html .= '<input type="hidden" name="form_action" value="game_result" />';
    $html .= '<input type="hidden" name="match_id" value="'.$m_id.'" />';
    $html .= '<input type="hidden" name="pl1_id" value="'.$pl1_id.'" />';
    $html .= '<input type="hidden" name="pl2_id" value="'.$pl2_id.'" />';
    $html .= '<input type="hidden" id="match_winner_'.$m_id.'" name="match_winner_'.$m_id.'" value="" />';

    $html .= '<div>';
    $html .= '<input type="text" value="'.$player1_name.'" name="pl1_m'.$m_id.'_name" class="player_name '.( $winner == $pl1_id ? 'winner' : '' ).' '.( $winner == $pl2_id ? 'loser' : '' ).'" />';
    $html .= '<input type="text" value="'.$pl1_set1.'" name="pl1_m'.$m_id.'_set1" class="set_score" />';
    $html .= '<input type="text" value="'.$pl1_set2.'" name="pl1_m'.$m_id.'_set2" class="set_score" />';
    $html .= '<input type="text" value="'.$pl1_set3.'" name="pl1_m'.$m_id.'_set3" class="set_score" />';
    $html .= '<input type="text" value="'.$pl1_set4.'" name="pl1_m'.$m_id.'_set4" class="set_score" />';
    $html .= '<input type="text" value="'.$pl1_set5.'" name="pl1_m'.$m_id.'_set5" class="set_score" />';
    $html .= '<input type="submit" value="Sieger" class="match_winner" data="'.$pl1_id.'" data_m_id="'.$m_id.'" />';
    $html .= '</div>';

    $html .= '<div>';
    $html .= '<input type="text" value="'.$player2_name.'" name="pl2_m'.$m_id.'_name" class="player_name '.( $winner == $pl2_id ? 'winner' : '' ).' '.( $winner == $pl1_id ? 'loser' : '' ).'" />';
    $html .= '<input type="text" value="'.$pl2_set1.'" name="pl2_m'.$m_id.'_set1" class="set_score" />';
    $html .= '<input type="text" value="'.$pl2_set2.'" name="pl2_m'.$m_id.'_set2" class="set_score" />';
    $html .= '<input type="text" value="'.$pl2_set3.'" name="pl2_m'.$m_id.'_set3" class="set_score" />';
    $html .= '<input type="text" value="'.$pl2_set4.'" name="pl2_m'.$m_id.'_set4" class="set_score" />';
    $html .= '<input type="text" value="'.$pl2_set5.'" name="pl2_m'.$m_id.'_set5" class="set_score" />';
    $html .= '<input type="submit" value="Sieger" class="match_winner" data="'.$pl2_id.'" data_m_id="'.$m_id.'" />';
    $html .= '</div>';


    $html .= '<br />';

    $html .= '<input type="submit" value="Match aktualisieren" />';

    $html .= '<br /><br /><hr />';

    $html .= '</form>';
}


$html .= '<input name="generate_matchs_now" type="submit" value="Matches anlegen" />';

$html .= '</form>';
$html .= '</div>';

