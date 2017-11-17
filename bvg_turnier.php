<?php

/*
Plugin Name: BVG Turnier
Plugin URI: http://etalkers.org
Description: BVG Turnier Verwaltung
Author: Laurent Dorier
Version: 1.0
Author URI: http://etalkers.org
*/
define( 'BVG_TURNIER_DEBUG', true );
if ( !defined( 'ABSPATH' ) ) die();

if( BVG_TURNIER_DEBUG ){
    $wpdb->show_errors();
}

add_action('init', 'myStartSession', 1);
function myStartSession() {
    if(!session_id()) {
        session_start();
    }
}

class Bvg_turnier
{
    function __construct(){
        add_action( 'admin_menu', array( $this, 'bvg_turnier_menu' ) );

        add_action( 'wp_ajax_change_players_match', array( $this, 'change_players_match' ) );

        add_shortcode( 'bvg_turnier_table', array( $this, 'bvg_turnier_table_shortcode' ) );
    }

    function bvg_turnier_menu(){
        add_menu_page(
            'BVG Turnier',
            'BVG Turnier',
            'edit_pages',
            'bvg_turnier',
            array( $this, 'bvg_turnier_admin' ),
            plugin_dir_url( __FILE__ ).'icons/bvg_turnier_icon.png',
            20
        );
    }

    function bvg_turnier_admin(){

        wp_enqueue_style( 'bvg_turnier_admin_style', plugin_dir_url(__FILE__).'admin/bvg_turnier_admin.css');
        wp_enqueue_script( 'bvg_turnier_admin', plugins_url( 'admin/bvg_turnier_admin.js', __FILE__ ) );

        if ( current_user_can('edit_pages') ) {

            if( get_option( 'bvg_turnier_installed' ) !== 'ok' ){
                /* Not yet installed ? */
                include plugin_dir_path(__FILE__).'admin/install.php';
                add_option('bvg_turnier_installed', 'ok'  );
            }

            include plugin_dir_path(__FILE__).'admin/index.php';
        }else{
            die( 'You are not allowed to access here...' );
        }


        return true;
    }

    function change_players_match(){
        include plugin_dir_path(__FILE__).'admin/action/change_player_match.php';
        //var_dump( $_POST );
        echo $html_ajax;
        wp_die();
    }

    // Add Shortcode
    function bvg_turnier_table_shortcode( $atts ) {

        wp_enqueue_style( 'bvg_turnier_admin_style', plugin_dir_url(__FILE__).'bvg_turnier.css');

        $html_shortcode = '';
        include plugin_dir_path( __FILE__ ).'shortcode_table.php';

        return $html_shortcode;
    }

}

new Bvg_turnier();