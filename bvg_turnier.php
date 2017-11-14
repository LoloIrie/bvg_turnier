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

}

new Bvg_turnier();