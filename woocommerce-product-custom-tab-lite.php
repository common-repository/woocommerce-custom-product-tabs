<?php
/**
 * Plugin Name: WC Product Custom Tab
 * Plugin URI: http://www.bigfoottechnorati.co.in
 * Description: This plugin allow your to create custom product tabs to be added to product view pages in Woo-Commerce which may contain text, html or shortcodes.
 * Tags: WC Product Custom Tab, woocommerce product tabs, woocommerce product custom tabs, woo product custom tabs, woo product tabs
 * Author: Ravi Raiya
 * Author URI: http://www.bigfoottechnorati.co.in
 * Version: 1.0.0
 * Tested up to: 3.6.1
 *
 * Copyright: (c) 2012-2013 Bigfoot Technorati, (sales@bigfootechnorato.co.in)
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package     Woocustomtabs
 * @author      Ravi Raiya
 * @category    Plugin
 * @copyright   Copyright (c) 2012-2013,  Bigfoot Technorati, Inc.
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( "ABSPATH" ) ) { exit; }


if ( ! Woocustomtabs::is_woocommerce_active() )
{ return; }


$GLOBALS["woo_custom_tabs"] = new Woocustomtabs();

class Woocustomtabs {

	const PLUGINVERSION = "1.0.1";


	public function __construct() {
		
	
		add_action( "woocommerce_init", array( $this, "init" ) );
	}

	public function init() {

		add_action('woocommerce_product_write_panel_tabs',  array( $this, 'woo_custom_tab_options_tab' )); 
		
		add_action('woocommerce_product_write_panels', array( $this, 'woo_custom_tab_options' ));

		add_action('woocommerce_process_product_meta', array( $this, 'process_product_meta_custom_tab' ));

		add_action( 'woocommerce_product_tabs',  array( $this, 'add_woo_custom_product_tabs' ), 11 );

		add_action( 'woocommerce_product_tab_panels', 'woo_custom_product_tabs_panel', 11 );

		add_filter( "woo_custom_product_tabs_content", "do_shortcode" );
		
		
	}
public function woo_custom_tab_options_tab() {
?>
	<li class="custom_tab"><a href="#custom_tab_data"><?php _e('Custom Tab', 'woothemes'); ?></a></li>
<?php
}

public function woo_custom_tab_options() {
	global $post;
	
	$custom_tab_options = array(
		'title' => get_post_meta($post->ID, 'custom_tab_title', true),
		'content' => get_post_meta($post->ID, 'custom_tab_content', true),
	);
	
?>
	<div id="custom_tab_data" class="panel woocommerce_options_panel">
	
		<div class="options_group">
			<p class="form-field">
				<?php woocommerce_wp_checkbox( array( 'id' => 'custom_tab_enabled', 'label' => __('Enable Custom Tab?', 'woothemes'), 'description' => __('Enable this option to enable the custom tab on the frontend.', 'woothemes') ) ); ?>
			</p>
		</div>
		
		<div class="options_group custom_tab_options">                								
			<p class="form-field">
				<label><?php _e('Custom Tab Title:', 'woothemes'); ?></label>
				<input type="text" size="5" name="custom_tab_title" value="<?php echo @$custom_tab_options['title']; ?>" placeholder="<?php _e('Enter your custom tab title', 'woothemes'); ?>" />
			</p>
			
			<p class="form-field">
				<?php _e('Custom Tab Content:', 'woothemes'); ?>
           	</p>
			
			<table class="form-table">
				<tr>
					<td>
						<textarea class="theEditor" rows="10" cols="40" name="custom_tab_content" placeholder="<?php _e('Enter your custom tab content', 'woothemes'); ?>"><?php echo @$custom_tab_options['content']; ?></textarea>
					</td>
				</tr>   
			</table>
        </div>	
	</div>
<?php
}
public function process_product_meta_custom_tab( $post_id ) {
	update_post_meta( $post_id, 'custom_tab_enabled', ( isset($_POST['custom_tab_enabled']) && $_POST['custom_tab_enabled'] ) ? 'yes' : 'no' );
	update_post_meta( $post_id, 'custom_tab_title', $_POST['custom_tab_title']);
	update_post_meta( $post_id, 'custom_tab_content', $_POST['custom_tab_content']);
}

public function add_woo_custom_product_tabs( $tabs ) {
		global $post;
		
		$custom_tab_options = array(
			'enabled' => get_post_meta($post->ID, 'custom_tab_enabled', true),
			'title' => get_post_meta($post->ID, 'custom_tab_title', true),
			'content' => get_post_meta($post->ID, 'custom_tab_content', true),
		);
		
		if ($custom_tab_options['enabled'] != 'no') {
					$para=array($custom_tab_options['custom_tab_title'],$custom_tab_options['custom_tab_content']);
					$pname="woo-tab-lite";
					$tid="tab-".$pname;
					$tabs[ $tid ] = array(
						"title"    => $custom_tab_options["title"],
						"priority" => 25,
						"callback" => array( $this, "woo_custom_product_tabs_panel_content" ),
						"content"  => $custom_tab_options["content"],  
							);
					
		}
		

		return $tabs;
}
 public function woo_custom_product_tabs_panel_content( $key, $tab ) {
	  
	
		echo apply_filters( "woo_custom_product_tabs_head", "<h2>" .$tab['title'] . "</h2>" , $tab);
		echo apply_filters( "woo_custom_product_tabs_content", $tab['content'], $tab );

	}

public function custom_product_tabs_panel() {
		global $post;
		
		$custom_tab_options = array(
			'enabled' => get_post_meta($post->ID, 'custom_tab_enabled', true),
			
		);
		
		if ( $custom_tab_options['enabled'] != 'no' ) {

		 $para=array($custom_tab_options['custom_tab_title'],$custom_tab_options['custom_tab_content']);
			$pname="woo-tab-lite";
			$tid="tab-".$pname;
			echo "<div class=\"panel\" id=\"" . $tid. "\">";
			$this->custom_product_tabs_panel_content($post->ID);
				echo "</div>";
			
			
			
			
		}
	}
public static function is_woocommerce_active() {

		$active_plugins = (array) get_option( "active_plugins", array() );

		if ( is_multisite() )
		{	$active_plugins = array_merge( $active_plugins, get_site_option( "active_sitewide_plugins", array() ) ); }

		return in_array( "woocommerce/woocommerce.php", $active_plugins ) || array_key_exists( "woocommerce/woocommerce.php", $active_plugins );
	}

	

} 

?>