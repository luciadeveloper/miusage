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

if ( !class_exists( 'Miusage' ) ) {
    class Miusage {
         /**
         * @var string
         *
         */
        private $api_endpoint = 'https://miusage.com/v1/challenge/1/';
        
        public function __construct() {

            add_action("wp_ajax_miusage_data", array($this,"miusage_data"));
            add_action("wp_ajax_nopriv_miusage_data", array($this,"miusage_data"));
        }

        public function miusage_data() {
   
            $transitien_test = get_site_transient('transitien_test');
            
            if ($transitien_test) {
                $data = $transitien_test;
            }
        
            else {
                $data = ajax_call_miusage_data();
            }
        
            return($data);
        }
        
        public function ajax_call_miusage_data(){
            
            $request = wp_remote_get($api_endpoint);
        
            if (is_wp_error($request)) {
                $error_message = $response->get_error_message();
                echo $error_message;
            }
        
            if( ! empty( $request ) ) {
                $body = wp_remote_retrieve_body($request); // as an array
                //$data = json_decode( $body );  	// as an objet
            }
            
            set_site_transient('transitien_test', $body, 3600); //3600 is 1 hour 
        
            return($body);
        }


    }
 
    global $Miusage;
    $Miusage = new Miusage();
}