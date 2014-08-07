<?php 
/**
 * MP Stacks + Video Backgrounds Enqueue Scripts
 *
 * @link http://mintplugins.com/doc/
 * @since 1.0.0
 *
 * @package    MP Stacks + Video Backgrounds
 * @subpackage Functions
 *
 * @copyright   Copyright (c) 2014, Mint Plugins
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author      Philip Johnston
 */
 

function mp_stacks_video_backgrounds_enqueue_scripts(){ 
	
	//YouTube API JS
	wp_enqueue_script( 'mp_stacks_video_youtube_js', plugins_url('js/youtube.js', dirname(__FILE__)), array('jquery'), false, true );	
	
	//Video Backgrounds JS
	wp_enqueue_script( 'mp_stacks_video_bg_js', plugins_url('js/video-bgs.js', dirname(__FILE__)), array('jquery'), false, true );	
	
	
}
add_filter( 'wp_enqueue_scripts', 'mp_stacks_video_backgrounds_enqueue_scripts' );
