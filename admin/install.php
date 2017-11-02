<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 14:40
 */

if ( !defined( 'ABSPATH' ) ) die();

global $wpdb;
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );


$nom_table = $wpdb->prefix . 'bvg_players';
$sql = "CREATE TABLE $nom_table (
  id bigint(20) unsigned NOT NULL auto_increment,
  firstname varchar(150) NOT NULL,
  lastname varchar(150) NOT NULL,
  PRIMARY KEY (id)
);";
dbDelta( $sql );

$nom_table = $wpdb->prefix . 'bvg_players_tournament';
$sql = "CREATE TABLE $nom_table (
  id bigint(20) unsigned NOT NULL auto_increment,
  tournament_id bigint(20) unsigned NOT NULL,
  players_id bigint(20) unsigned NOT NULL,
  played int(3) unsigned NOT NULL,
  victory int(3) unsigned NOT NULL,
  draw int(3) unsigned NOT NULL,
  loss int(3) unsigned NOT NULL,
  points_major int(3) unsigned NOT NULL,
  sets int(3) unsigned NOT NULL,
  points int(6) unsigned NOT NULL,
  PRIMARY KEY (id)
);";
dbDelta( $sql );

$bvg_admin_msg = 'Plugin BVG Turnier installiert !';



