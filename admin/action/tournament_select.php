<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 15:32
 */

$new_t_id = 1;
$new_t_name = 'BVG Turnier 2027';

if( empty( $_POST['turnier_name'] ) && is_numeric( $_POST['turnier_select'] ) ){
    // SELECT EXISTING TOURNAMENT
    $new_t_id = $_POST['turnier_select'];

    $query = "SELECT
*

FROM
".$wpdb->prefix."bvg_tournaments

WHERE
id=".$new_t_id."

LIMIT
0,1";
    $tournaments = $wpdb->get_results( $query  );
    $new_t_name = $tournaments[0]->name;
    $new_t_system = $tournaments[0]->system;
    $_SESSION['round'] = $tournaments[0]->round;
}else{
    // CREATE NEW TOURNAMENT
    $parent_id = 0;
    if( $_POST['turnier_select_id'] > 0 ){
        $parent_id = $_POST['turnier_select_id'];
    }

    $data = array(
        'parent_id' => $parent_id,
        'name' => $_POST['turnier_name'],
        'round' => 1,
        'system' => 1,
        'nb_sets' => 3,
        'points_set' => 21,
        'max_points_set' => 30
    );
    //$wpdb->show_errors();
    $wpdb->insert( $wpdb->prefix . 'bvg_tournaments', $data );

    $new_t_id = $wpdb->insert_id;
    $new_t_name = $_POST['turnier_name'];
    $new_t_system = $_POST['turnier_system'];
    $_SESSION['round'] = 1;
}

/*
$wpdb->show_errors();
$wpdb->print_error();
*/
$_SESSION['t_id'] = $new_t_id;
$_SESSION['t_name'] = $new_t_name;
$_SESSION['t_system'] = $new_t_system;
$bvg_admin_msg .= 'Aktives Turnier: '.$_SESSION['t_name'].' !!!';