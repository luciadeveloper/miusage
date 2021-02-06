<?php 
 /*
   Plugin Name: Miusage Plugin
   Plugin URI: github.com/luciadeveloper
   description: 
   Version: 1
   Author: Lucia Sanchez 
   Author URI: luciadeveloper.com
   License: GPL2
*/

if( ! defined( 'ABSPATH' ) ) exit;


//require_once plugin_dir_path( __FILE__ ) . 'inc/class_admin_page.php';
// Plugin_Name_Activator::activate();
    

if ( !class_exists( 'Miusage' ) ) {
    class Miusage {
         /**
         * @var string
         *
         */
        private $api_endpoint = 'https://miusage.com/v1/challenge/1/';
        
        public function init() { 
           
            include_once(  plugin_dir_path( __FILE__ ) . 'inc/class_admin_page.php');
            
            $Miusage_admin_page = new Miusage_admin_page();
            
        }

        public function __construct() {
            //ajax endpoint 
            add_action("wp_ajax_miusage_data", array($this,"miusage_data"));
            add_action("wp_ajax_nopriv_miusage_data", array($this,"miusage_data"));
            
           

            //shortcode
            add_shortcode('show_miusage_data', array($this,'print_miusage_data')); 
            
            //wp-cli command 
            if ( class_exists( 'WP_CLI' ) ) {
                WP_CLI::add_command( 'miusage_data', 'ajax_call_miusage_data' );
            }
        }


        public function miusage_data() {
            //check if there is data from the last time, if it didn't expire
            $transitien_test = get_site_transient('transitien_test');
            
            if ($transitien_test) {
                $data = $transitien_test;
            }
        
            else {
                $data = $this->ajax_call_miusage_data();
            }
        
            return($data);
        }
        
        public function ajax_call_miusage_data(){
            
            $request = wp_remote_get($this->api_endpoint);
        
            if (is_wp_error($request)) {
                $error_message = $response->get_error_message();
                echo $error_message;
            }
        
            if( ! empty( $request ) ) {
                $body = wp_remote_retrieve_body($request); // as an array
                //$data = json_decode( $body );  	// as an objet
            }
            //saving the data for the next hour
            set_site_transient('transitien_test', $body, 3600); //3600 is 1 hour 
        
            return($body);
        }

       
        
        //used by the shortcode and by the function that prints the data on the admin page
        public function print_miusage_data(){
            //da formato a data que viene de la funcion principal
            $data =  $this->miusage_data();
            return($data);
        }

    }
 
   // global $Miusage;
    //$Miusage = new Miusage();

    
}

function miusage() {
	global $Miusage;
	
	if( !isset($Miusage) ) {
		$Miusage = new Miusage();
		$Miusage->init();
	}
	return $Miusage;
}

miusage();