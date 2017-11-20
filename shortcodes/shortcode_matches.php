<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 17.11.2017
 * Time: 13:04
 */

$html_shortcode = '';


// Attributes
$atts = shortcode_atts(
    array(
        't_id' => '1',
        'round' => false,
    ),
    $atts
);

include_once plugin_dir_path(__FILE__). '../admin/db_get_content.php';
$tournament = db_get_tournaments( $atts['t_id'] );
$players = db_get_players( $atts['t_id'] );
$round = $atts[ 'round' ];
if( $round == 0){
    $round = false;
}
$matches = db_get_matches( $atts['t_id'], $round );

$html_shortcode .= '<h3>Matches '.$tournament[0]->name.' / ' .'Round: '.( $round ? $round.' / ' : '' ).$tournament[0]->round.'</h3>';



$html = '';
define( 'ROUND', $round );
define( 'ROUND_MAX', $tournament[0]->round );
include plugin_dir_path(__FILE__). 'sc_html/matches_view.php';

$html_shortcode .= $html;