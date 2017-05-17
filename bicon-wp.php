<?php
/*
Plugin Name: Bicon WP
Plugin URI: http://bicon.lab.themebucket.net/
Description: Bicon is a package of well crafted line icons build from scratch. <strong>Bicon WP</strong> is the easiest way to use those line icons in your WordPress site.
Version: 0.1.0
Author: obiPlabon (ThemeBucket)
Author URI: http://themebucket.net/
License: GPLv2 or later
Text Domain: bicon-wp
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2013-2017 ThemeBucket.
*/


class BiconWP {

    public function __construct() {
        add_action( 'init', array( $this, 'init' ) );
    }

    public function init() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );

        if ( $this->has_LiveComposer() ) {
            add_filter( 'dslc_available_icons', array( $this, 'add_to_LiveComposer' ) );
        }
    }

    private function has_LiveComposer() {
        return defined( 'DS_LIVE_COMPOSER_VER' );
    }

    private function get_dir() {
        return plugin_dir_path( __FILE__ );
    }

    public function add_to_LiveComposer( $icons ) {
        $icons['Bicon'] = include_once( $this->get_dir() . 'inc/lc-map.php' );
        return $icons;
    }

    public function enqueue() {
        wp_enqueue_style( 'bicon', plugin_dir_url( __FILE__ ) . 'assets/css/bicon.css' );

        if ( $this->has_LiveComposer() ) {
            $bicon_style = <<<BICON
            .dslc-icon-bi {
                font-family: 'bicon' !important;
                font-weight: normal;
                font-style: normal;
                font-variant: normal;
                line-height: 1;
                text-transform: none;
                speak: none;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
BICON;
            wp_add_inline_style( 'bicon', $bicon_style );
        }
    }

}

new BiconWP;
