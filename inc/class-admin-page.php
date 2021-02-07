<?php 

if( ! defined( 'ABSPATH' ) ) exit;


if ( !class_exists( 'Miusage_admin_page' ) ) {
    class Miusage_admin_page {

        public function __construct() {
            add_action( 'admin_menu', array( $this, 'miusage_admin_page' )); 
            add_action( 'wp_ajax_miusage_data_print_refresh', array( $this,'miusage_data_print_refresh' ));
            add_action( 'admin_head', array( $this, 'wp_enqueue_scripts' ) );
        }

        public function wp_enqueue_scripts() {
            wp_register_style( 'miusage_admin_page', plugins_url( '../src/admin_page.css', __FILE__ ), array(),  _MIUSAGE_VERSION );
            wp_enqueue_style( 'miusage_admin_page' );
            
            //JS with the ajax call to refresh data 
            wp_enqueue_script( 'admin_refresh', plugins_url( '../src/admin_refresh.js', __FILE__ ), array(), _MIUSAGE_VERSION, true );
            //sending the siteurl var to the JS file
            wp_localize_script( 'admin_refresh', 'WPDomain', array( 'siteurl' => get_option('siteurl')) );
        }
    
        //adding admin page
        public function miusage_admin_page() {
            add_menu_page(__( 
                'Miusage data', 'miusage' ),
                __( 'Miusage data','miusage' ),
                'manage_options',
                'miusage_data',
                array($this,'miusage_data_admin'),
                'dashicons-format-aside', 
            );
        }

        //for the ajax call to refresh data, with the limitaion of 1 request per hour to the API 
        public function miusage_data_print_refresh() {
            global $miusage;
            $data = $miusage->print_miusage_table();
            
            print_r( $data );
        }

        public function miusage_data_admin() {
            global $miusage;
            $data = $miusage->print_miusage_table();

            $html ='<h1>'.__( 'Miusage data','miusage' ).'</h1>';

            $button = '<button id="button-refresh">'. __('Refresh','miusage') .'</button>';  
            $loader = '<span id="loaderDiv" ></span>';
            $html .= '<div id="data-section"><div id="data">' . $data . '</div>' . $loader. $button. '</div>';
            
            echo ( $html );
            
        }
    }
}