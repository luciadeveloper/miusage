=== Miusage Plugin ===

Contributors: luciadeveloper
Tags: API, shortcode, wp-cli command, wP admin page
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
 
This plugin retrives data from an API endpoint and displays it on an admin page, in the front-end with a shortcode and on the console, with a wp-cli command.

== Description ==
 
This plugin retrives data from an API endpoint and displays it on an admin page, in the front-end with a shortcode and on the console, 
with a wp-cli command. The data can be retreived once per hour. If the API endpoint was called less than an hour ago, the data is storaged with a transient. 

Using the wp-cli command, the restriction of on hour is overwritten. 
 
== Installation ==
 

 
1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. To use the wp-cli, you need to have it installed in your environment. Instruccions here -> https://wp-cli.org/es/ 

Shortcode -> [show_miusage_data]

== Screenshots ==
 
######  Admin page
 
![Screenshot](https://luciadeveloper.com/wp-content/uploads/sites/8/2021/02/admin-page.png)

###### Shortcode output in the front-end

![Screenshot](https://luciadeveloper.com/wp-content/uploads/sites/8/2021/02/front-end.png)
 
== Changelog ==
 
= 1.0 =
first launch
