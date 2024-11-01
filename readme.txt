=== WC Product Custom Tab ===
Contributors: raviraiya
Donate link: http://bigfoottechnorati.co.in
Tags: WC Product Custom Tab, woocommerce product tabs, woocommerce product custom tabs, woo product custom tabs, woo product tabs
Requires at least: 3.3
Tested up to: 3.6.1
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin extends the WooCommerce plugin by adding custom product tab.

== Description ==

This plugin allows you to create single custom tab on Woocommerce product page. this tab can contain text,html or shortcodes.




== Installation ==

1. Upload the entire 'woocommerce-product-custom-tabs-lite' folder to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Edit a product, then click on 'Custom Tab' within the 'Product Data' panel

== Screenshots ==

1. Adding a custom tab to a product in the admin
2. The custom tab displayed on the frontend

== Frequently Asked Questions ==

= Can I have default tab content ? =

This free version dont have this but in pro version your can get this. 


= How i can use shortcode in custom product tab? =

This free version dont have this but in pro version your can get this. 


= How i can add more tabs or change the order of the tabs? =

This free version dont have this but in pro version your can get this. 

= How do I hide the tab heading? =

The tab heading is shown before the tab content and is the same string as the tab title.  An easy way to hide this is to add the following to the bottom of your theme's functions.php:

`
add_filter( 'woocommerce_custom_product_tabs_lite_heading', 'hide_custom_product_tabs_lite_tab_heading' );
function hide_custom_product_tabs_lite_tab_heading( $heading ) { return ''; }
`


= 1.0.0 - 2013.09.25 =
 * Initial release