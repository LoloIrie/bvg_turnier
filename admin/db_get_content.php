<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 10.11.2017
 * Time: 11:42
 */

/* Get all tournaments */
$query = "SELECT
*

FROM
".$wpdb->prefix."bvg_tournaments
";
$tournaments = $wpdb->get_results( $query  );

/* Get all players not registred yet for this tournament */
$query = "SELECT
pl.id as player_id,
pl.firstname as player_firstname,
pl.lastname as player_lastname

FROM
".$wpdb->prefix."bvg_players as pl

ORDER BY
pl.lastname ASC, pl.firstname ASC
";
$all_players = $wpdb->get_results( $query, OBJECT_K  );


/* Get all players for the current tournament */
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
pl_t.tournament_id = ".$_SESSION['t_id']."

ORDER BY
pl_t.points_major DESC, pl_t.sets DESC, pl_t.sets_against ASC, pl_t.points DESC, pl_t.points_against ASC, pl_t.player_level_init DESC
";
$players = $wpdb->get_results( $query, OBJECT_K  );

/* Get matches */
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