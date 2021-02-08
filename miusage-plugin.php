<?php 
 /*
   Plugin Name: Miusage Plugin
   Plugin URI: github.com/luciadeveloper
   description: Retrieves data from an API endpoint and displays it on an admin page, in the front-end with a shortcode and on the console, with a wp-cli command.
   Version: 1
   Author: Lucia Sanchez 
   Author URI: luciadeveloper.com
   License: GPL2
*/

if( ! defined( 'ABSPATH' ) ) exit;


if ( !class_exists( 'Miusage' ) ) {
    class Miusage {
         /**
         * @var string
         *
         */
        private $api_endpoint = 'https://miusage.com/v1/challenge/1/';
       
        public function init() {    
            if ( !defined('_MIUSAGE_VERSION') ) {
                define ( '_MIUSAGE_VERSION', '1.0' );
            }
           
            include_once( plugin_dir_path( __FILE__ ) . 'inc/class-admin-page.php');
            //admin page class instance, from the file included above
            $Miusage_admin_page = new Miusage_admin_page();

            
        }

        public function __construct() {
        
            //styles and JS
            add_action( 'admin_head', array( $this, 'wp_enqueue_scripts' ) );
            add_action( 'wp_enqueue_scripts', array( $this,'wp_enqueue_scripts' ) );
            
            //ajax endpoint 
            add_action( 'wp_ajax_miusage_data', array($this,'miusage_data' ) );
            add_action( 'wp_ajax_nopriv_miusage_data', array($this,'miusage_data' ) );
            
            //shortcode
            add_shortcode( 'show_miusage_data', array($this,'print_miusage_table' ) ); 
            
            //wp-cli command - wp miusage_data - retrives the data, overwritting the 1 hour restriction
            if ( class_exists( 'WP_CLI' ) ) {
                WP_CLI::add_command( 'miusage_data', 'ajax_call_miusage_data' );
            }
        }

        public function wp_enqueue_scripts() {
            wp_register_style( 'table_styles', plugins_url( '/src/table_styles.css', __FILE__ ), array(),  _MIUSAGE_VERSION );
            wp_enqueue_style( 'table_styles');
        }

        public function miusage_data() {
            //if the transitien didn't expire, the data is available to use
            $transitien = get_site_transient( 'transitien' ); 
            
            if ( $transitien ) {
                //transitien not expired
                $data = $transitien;
            } else {
                //transitien expired, request data to API again
                $data = $this->ajax_call_miusage_data();
            }
            
            return( $data );
        }
        
        public function ajax_call_miusage_data() {  
            $request = wp_remote_get( $this->api_endpoint );
        
            if (is_wp_error( $request )) {
                $error_message = $response->get_error_message();
                echo $error_message;
            }
        
            if(!empty( $request )) {
                $body = wp_remote_retrieve_body( $request ); 
                $data = json_decode( $body ); 
                //save last time data was retreived, to show to user
                $data->lastaccess = $request['headers']['date'];
                //storing data for the next hour
                set_site_transient( 'transitien', $data, 3600 );
              
                return( $data );
            }         
        }

        //used by the shortcode and by the function that prints the data on the admin page
        public function print_miusage_table() {
            $data =  $this->miusage_data();

            $html = '<section id="datatable">';
            $html .= '<h2>'. $data->title .'</h2>';
            $html .= '<table>';
            $html .= '<tr>';
                
                $datatable = $data->data;
                
                foreach( $datatable->headers as $header ) {
                    $html .= '<th>';
                    $html .= $header;
                    $html .= '</th>';
                }
                
            $html .= '</tr>';

            foreach( $datatable->rows as $row ) {
                $html .= '<tr>';
                $row->date = date( 'Y-m-d H:i:s', $row->date );
                
                foreach( $row as $value ) {
                    $html .= '<td>';    
                    $html .= $value;
                    $html .= '</td>';
                }
                $html .= '</tr>';
            }
            
            $html .= '</table>';   
            $html .= '<p>'.__('Data updated:','miusage').'<i> '.  $data->lastaccess .'</i></p>'; 
            $html .= '</section>';   
            
            return( $html );
        }
    }
}

function miusage() {
	global $miusage;
	
	if( !isset( $miusage ) ) {
		$miusage = new Miusage();
		$miusage->init();
    }
    
	return ( $miusage );
}

miusage();