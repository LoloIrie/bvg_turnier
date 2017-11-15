<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 13.11.2017
 * Time: 09:12
 */

//var_dump( $all_players );

/* Players */
$html .= '<div class="admin_block_label">Spieler</div>';
$html .= '<div class="admin_block" id="block_add_players">';

$html .= '<form method="post">';
$html .= '<input type="hidden" name="form_action" value="add_existing_players" />';
$html .= '<input type="hidden" id="schweizer_system_punkte" name="schweizer_system_punkte" value="0" />';

$html .= '<label>Spieler: </label>';
$html .= '<select type="text" value="" name="spieler_select" id="spieler_select">';
$html .= '<option value="0">Auswählen</option>';
foreach( $all_players as $k => $all_player ){
    foreach( $players as $player ){
        if( $player->players_id == $k ){
            continue 2;
        }
    }

    $html .= '<option value="'.$all_player->player_id.'" data_level="'.$all_player->player_level.'">'.$all_player->player_firstname.' '.$all_player->player_lastname.'</option>';
}
$html .= '</select>';

$html .= '<input type="submit" value="Spieler für das Turnier anlegen" />';
$html .= '<input type="submit" value="ALLE Spieler für das Turnier anlegen" id="alle_spieler" name="alle_spieler" />';
$html .= '<input type="submit" value="Alle Spieler für das Turnier löschen" id="sieler_turnier_remove" name="sieler_turnier_remove" />';
$html .= '<input type="submit" value="Spieler inaktiv setzen" id="sieler_löschen" name="sieler_inaktiv" />';

$html .= '</form>';

$html .= '<form method="post">';
$html .= '<input type="hidden" name="form_action" value="add_players" />';



$html .= '<label>Vorname: </label>';
$html .= '<input type="text" value="" placeholder="Vorname" name="firstname" />';
$html .= '<label>Nachname: </label>';
$html .= '<input type="text" value="" placeholder="Nachname" name="lastname" />';
$html .= '<label>Werte (Schweizer System): </label>';
$html .= '<input type="text" value="" placeholder="Punkte" name="schweizer_system_punkte" />';

$html .= '<input type="submit" value="Neuer Spieler anlegen" />';


$html .= '</form>';


$html .= '</div>';
