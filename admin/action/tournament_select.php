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
}else{
    // CREATE NEW TOURNAMENT
    $parent_id = 0;
    if( $_POST['turnier_select_id'] > 0 ){
        $parent_id = $_POST['turnier_select_id'];
    }

    $data = array(
        'parent_id' => $parent_id,
        'name' => $_POST['turnier_name'],
        'round' => 1
    );
    $wpdb->insert( $wpdb->prefix . 'bvg_tournaments', $data );

    $new_t_id = $wpdb->insert_id;
    $new_t_name = $_POST['turnier_name'];
}

$wpdb->show_errors();
$wpdb->print_error();

$_SESSION['t_id'] = $new_t_id;
$_SESSION['t_name'] = $new_t_name;
$bvg_admin_msg .= 'Aktives Turnier: '.$_SESSION['t_name'].' !!!';