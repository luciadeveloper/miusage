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
    class Miusage{
         /**
         * @var string
         *
         * Set post type params
         */
        private $type = 'note';
        
        public function __construct() {
            //add_action('init', array($this, 'registerCPT'));
        }
    }
 
    Miusage::init();
    Miusage::get_foo();
}