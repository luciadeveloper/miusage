<?php 

if( ! defined( 'ABSPATH' ) ) exit;


if ( !class_exists( 'Miusage_admin_page' ) ) {
    class Miusage_admin_page {

        public function __construct() {
            add_action( 'admin_menu', array( $this,'miusage_admin_page' )); 
            add_action( 'wp_ajax_miusage_data_print_refresh', array( $this,'miusage_data_print_refresh' ));
            add_action( 'admin_head', array( $this, 'wp_enqueue_scripts' ) );
        }

        public function wp_enqueue_scripts() {
            wp_register_style( 'miusage_admin_page', plugins_url( '../src/admin_page.css', __FILE__ ), array(),  _S_VERSION );
            wp_enqueue_style( 'miusage_admin_page' ); 
            //JS with the ajax call to refresh data 
            wp_enqueue_script( 'admin_refresh', plugins_url( '../src/admin_refresh.js', __FILE__ ), array(), _S_VERSION, true );
        }
    
        //adding admin page
        public function miusage_admin_page() {
            add_menu_page(__( 
                'Miusage data', 'textdomain' ),
                __( 'Miusage data','textdomain' ),
                'manage_options',
                'miusage_data',
                array($this,'miusage_data_admin'),
                'dashicons-format-aside', 
            );
        }

        //for the ajax call to refresh data, with the limitaion of 1 request per hour to the API 
        public function miusage_data_print_refresh() {
            global $Miusage;
            $data = $Miusage->print_miusage_table();
            
            print_r( $data );
        }

        public function miusage_data_admin() {
            global $Miusage;
            $data = $Miusage->print_miusage_table();
            $button = '<button id="button-refresh">Refresh</button>';  //translations!
            $loader = '<span id="loaderDiv" ></span>';
            $html = '<div id="data-section"><div id="data">' . $data . '</div>' . $loader. $button. '</div>';
            
            echo ( $html );
            
        }
    }
}