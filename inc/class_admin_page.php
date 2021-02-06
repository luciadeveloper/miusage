<?php 

if( ! defined( 'ABSPATH' ) ) exit;

//require plugin_dir_path( __FILE__ ) . 'miusage_plugin.php';



if ( !class_exists( 'Miusage_admin_page' ) ) {
    class Miusage_admin_page {
        public function __construct() {
            add_action( 'admin_menu', array($this,'miusage_admin_page')); 
            add_action("wp_ajax_miusage_data_print", array($this,"miusage_data_print"));
        }

        public function miusage_admin_page() {
            add_menu_page(
               __( 'miusage_data', 'textdomain' ),
               __( 'miusage_data','textdomain' ),
               'manage_options',
               'miusage_data',
               array($this,'miusage_data_admin'),
               'dashicons-format-aside', 
           );
        }

        public function miusage_data_print(){
            global $Miusage;
            $data = $Miusage->print_miusage_data();
            print_r($data);
        }

        public function miusage_data_admin(){
            global $Miusage;
            $data = $Miusage->print_miusage_data();
            $button = '<div href="" id="button-refresh">Refresh</div>';  //translations!
          
            $html = '<div id="info">' . $data . '</div>' . $button;
            echo $html;
            ?>  
            <script>
                jQuery(document).on('click', '#button-refresh', function(e){
                    jQuery.ajax({url: "http://localhost:8000/wp-admin/admin-ajax.php?action=miusage_data_print", success: function(result){
                        jQuery("#info").html(result);
                        console.log(result);
                    }});
                });
            </script>
            <?php
        }
    }
}