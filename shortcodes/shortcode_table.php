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
        'view' => 'full',
    ),
    $atts
);

include_once plugin_dir_path(__FILE__). '../admin/db_get_content.php';
$tournament = db_get_tournaments( $atts['t_id'] );
$players = db_get_players( $atts['t_id'] );


$html_shortcode .= '<h3>'.$tournament[0]->name.' / ' .'Round: '.$tournament[0]->round.'</h3>';
$html_shortcode .= '<h4>Gewinnsätze: '.$tournament[0]->nb_sets.' Punkte pro Satz: '.$tournament[0]->points_set.' Max. Punkte pro Satz: '.$tournament[0]->max_points_set.'</h4>';



$html = '';
$table_view = $atts['view'];
include plugin_dir_path(__FILE__). 'sc_html/tournament_table.php';

$html_shortcode .= $html;