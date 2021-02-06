<?php

/**
 * Class Miusage_admin_page
 *
 */

if ( !class_exists( 'Miusage_admin_page' ) ) {
    class Miusage_admin_page {

       
        public function __construct() {
            // Enqueue styles for the admin
            add_action( 'admin_enqueue_scripts', array( $this, 'wp_enqueue_styles' ), 20 );
            add_action( 'admin_menu', array($this,'wpdocs_unsub_add_pages') );
        }

        public function wpdocs_unsub_add_pages() {
            add_menu_page(
               __( 'miusage_data', 'textdomain' ),
               __( 'miusage_data','textdomain' ),
               'manage_options',
               'miusage_data',
               'print_miusage_data_admin',
               ''
           );
        }

    }
}

/**
 * Instantiate class, creating admin page
* global $Miusage_admin_page;
* $Miusage_admin_page = new Miusage_admin_page();
 */