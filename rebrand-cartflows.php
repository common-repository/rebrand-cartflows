<?php
/**
 * Plugin Name: 	Rebrand CartFlows 
 * Plugin URI: 	    https://rebrandpress.com/rebrand-cartflows/
 * Description: 	CartFlows is a sales funnel builder that allows you to transform your WordPress website into a sales platform. Avoid confusing third-party messaging with Rebrand CartFlows so your logo and colors are front and center. Rename the plugin and change the description, and also easily replace the developer’s name with your company’s
 * Version:     	1.0
 * Author:      	RebrandPress
 * Author URI:  	https://rebrandpress.com/
 * License:     	GPL2 etc
 * Network:         Active
*/

if (!defined('ABSPATH')) { exit; }

if ( !class_exists('Rebrand_Cartflows_Pro') ) {
	
	class Rebrand_Cartflows_Pro {
		
		public function bzflows_load()
		{
			global $bzflows_load;
			load_plugin_textdomain( 'bzflows', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

			if ( !isset($bzflows_load) )
			{
			  require_once(__DIR__ . '/cartflows-settings.php');
			  $PluginFlows = new BZ_FLOWS\BZRebrandCartflowsSettings;
			  $PluginFlows->init();
			}
			return $bzflows_load;
		}
		
	}
}
$PluginRebrandCartflows = new Rebrand_Cartflows_Pro;
$PluginRebrandCartflows->bzflows_load();
