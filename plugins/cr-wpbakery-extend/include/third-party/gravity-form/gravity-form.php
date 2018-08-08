<?php
if (!defined('ABSPATH')) die('-1');

add_action( 'gform_loaded', array( 'GF_CR_Bootstrap', 'load' ), 5 );

class GF_CR_Bootstrap {

    public static function load() {

        if ( ! method_exists( 'GFForms', 'include_addon_framework' ) ) {
            return;
        }

        require_once( 'class-gf-cheval-res.php' );

        GFAddOn::register( 'GFChevalRes' );
    }
}

function gf_chevres() {
    return GFChevalRes::get_instance();
}