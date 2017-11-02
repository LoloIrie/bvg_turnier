<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 14:14
 */

if ( !defined( 'ABSPATH' ) ) die();
global $wpdb;

/* Actions */
if( isset($_POST['form_action']) ){
    include plugin_dir_path(__FILE__). 'action/'.$_POST['form_action'].'.php';
}


/* Msg */
if( $bvg_admin_msg){
    echo '<div id="bvg_admin_msg">'.$bvg_admin_msg.'</div>';

    echo '<div><pre>';
    var_dump( $_POST );
    echo '</pre></div>';
}

/* Forms */
echo '<h1>Administration !!!</h1>';


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
*

FROM
".$wpdb->prefix."bvg_players

ORDER BY
points_major, 
DESC
";
$players = $wpdb->get_results( $query );

echo '<div class="admin_block_label">Tabelle</div>';
echo '<div class="admin_block" id="block_table">';
echo '<form method="post">';
echo '<input type="hidden" name="form_action" value="table_view" />';

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

foreach( $players as $player ){
    echo '<li class="table_row">';
    echo '<span class="pl_name">';
    echo $player->firstname.' '.$player->lastname;
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
    echo "</span>";

    echo '<span class="pl_points">';
    echo $player->points;
    echo "</span>";
    echo '</li>';
}
echo '</ul>';



echo '</form>';
echo '</div>';

?>
<script>
    jQuery('.admin_block_label').on( 'click', function(){
        jQuery('.admin_block').hide();
        jQuery( this ).next().slideDown();
    });

</script>
<?php