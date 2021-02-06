<?php 

if( ! defined( 'ABSPATH' ) ) exit;

//require plugin_dir_path( __FILE__ ) . 'miusage_plugin.php';



if ( !class_exists( 'Miusage_admin_page' ) ) {
    class Miusage_admin_page {
        public function __construct() {
            add_action( 'admin_menu', array($this,'miusage_admin_page')); 
        }

        public function miusage_admin_page() {
            add_menu_page(
               __( 'miusage_data', 'textdomain' ),
               __( 'miusage_data','textdomain' ),
               'manage_options',
               'miusage_data',
               array($this,'print_miusage_data_admin'),
               'dashicons-format-aside', 
           );
        }

        public function print_miusage_data_admin(){
            global $Miusage;
            $data = $Miusage->print_miusage_data();
            print_r($data);
            $button = '<button>'._e('refresh','Miusage').'</button>';
            echo $button;
        }
    }
}