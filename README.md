=== Miusage Plugin ===

Contributors: luciadeveloper (Lucia Sanchez Fraile)

Tags: API, shortcode, wp-cli command, wP admin page
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
 
This plugin retrieves data from an API endpoint and displays it on an admin page, in the front-end with a shortcode and on the console, with a wp-cli command.

== Description ==
 
This plugin retrieves data from an API endpoint and displays it on an admin page, in the front-end with a shortcode and on the console, 
with a wp-cli command. The data can be retrieved once per hour. If the API endpoint was called less than an hour ago, the data is stored with a transient. 

Using the wp-cli command, the restriction of one hour is overwritten. 
 
== Installation ==
 

1. Upload `plugin-miusage.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. To use the wp-cli, you need to have it installed in your environment. Instructions here -> https://wp-cli.org/es/ 

Shortcode -> [show_miusage_data]

WP-CLI command -> wp miusage_data

== Screenshots ==
 
######  Admin page
 
![Screenshot](https://luciadeveloper.com/wp-content/uploads/sites/8/2021/02/admin-page.png)

###### Shortcode output in the front-end

![Screenshot](https://luciadeveloper.com/wp-content/uploads/sites/8/2021/02/front-end.png)
 
== Changelog ==
 
= 1.0 =
first launch


== Next ==

1. Template to print table - views/table.php 
