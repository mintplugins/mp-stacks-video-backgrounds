<?php
/**
 * This file contains the function keeps the MP Stacks Video Backgrounds plugin up to date.
 *
 * @since 1.0.0
 *
 * @package    MP Stacks Video Backgrounds
 * @subpackage Functions
 *
 * @copyright  Copyright (c) 2014, Mint Plugins
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author     Philip Johnston
 */
 
/**
 * Check for updates for the MP Stacks Video Backgrounds Plugin by creating a new instance of the MP_CORE_Plugin_Updater class.
 *
 * @access   public
 * @since    1.0.0
 * @return   void
 */
 if (!function_exists('mp_stacks_video_backgrounds_update')){
	function mp_stacks_video_backgrounds_update() {
		$args = array(
			'software_name' => 'MP Stacks + Video Backgrounds', //<- The exact name of this Plugin. Make sure it matches the title in your mp_stacks-video_backgrounds, video_backgrounds, and the WP.org stacks-video_backgrounds
			'software_api_url' => 'http://mintplugins.com',//The URL where Video Backgrounds and mp_stacks-video_backgrounds are installed and checked
			'software_filename' => 'mp-stacks-video-backgrounds.php',
			'software_licensed' => true, //<-Boolean
		);
		
		//Since this is a plugin, call the Plugin Updater class
		$mp_stacks_video_backgrounds_plugin_updater = new MP_CORE_Plugin_Updater($args);
	}
 }
add_action( 'admin_init', 'mp_stacks_video_backgrounds_update' );
