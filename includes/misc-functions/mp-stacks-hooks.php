<?php 
/**
 * MP Stacks + Video Backgrounds Scripts and Functions
 *
 * @link http://mintplugins.com/doc/
 * @since 1.0.0
 *
 * @package    Mp Stacks + Video Backgrounds
 * @subpackage Functions
 *
 * @copyright   Copyright (c) 2014, Mint Plugins
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author      Philip Johnston
 */
 
/**
 * Short Description
 *
 * @since    1.0.0
 * @link     http://mintplugins.com/doc/
 * @see      function_name()
 * @param    string $html_output See link for description.
 * @param    string $post_id See link for description.
 * @return   void
 */
function mp_stacks_video_background( $html_output, $post_id ){ 

	$brick_bg_video_source = get_post_meta( $post_id, 'brick_bg_video_source', true );
	
	$brick_bg_video = get_post_meta( $post_id, 'brick_bg_video', true );
	
	//If this is an iphone or ipad, we don't want to show any video background cause it can't handle it
	if ( mp_core_is_iphone() || mp_core_is_ipad() ){
		return false;	
	}
	
	//If a background video has been entered
	if ( !empty( $brick_bg_video ) ){
		
		//Video Container div
		$html_output .= '<div class="mp-stacks-video-backgrounds-container" style="position:relative;">';
		
		//Image which sizes the video correctly to 16x9
		$html_output .= '<img class="mp-stacks-video-bg-placeholder-img" style="position:relative; display:block; padding:0px; margin-bottom:0px; min-width:100%; min-height:100%;" src="' . plugins_url( 'assets/images/16x9.gif', dirname( dirname(__FILE__) ) ) . '"/>';
			
		//If this video is coming from YouTube
		if ( $brick_bg_video_source == 'youtube' ){
			
			//Find the youtube video id by checking all the types of urls we could be given
			if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $brick_bg_video, $match)) {
				$video_id = $match[1];
			}
			
			//Create iframe with settings for youtube
			$html_output .= '<iframe id="mp-stacks-video-bg-youtube-' . $post_id . '" class="mp-stacks-video-bg-youtube" type="text/html" src="https://www.youtube.com/embed/' . $video_id . '?enablejsapi=1&controls=0&modestbranding=1&showinfo=0&wmode=transparent&rel=0&autoplay=1&muted=1&html5=1" frameborder="0" style="position:absolute; width:100%; height:100%; top:0; left:0px; z-index:1;" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
		}
		//If video is coming from Vimeo
		else if( $brick_bg_video_source == 'vimeo' ){
						
			//Get json from vimeo about this video using Curl 
			$curl = curl_init('http://vimeo.com/api/oembed.json?url=' . $brick_bg_video );
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_TIMEOUT, 30);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
			$vimeo_info_array = curl_exec($curl);
			curl_close($curl);
				
			
			//Json decode Vimeo info array
			$vimeo_info_array = json_decode($vimeo_info_array, true);
			
			$video_id = $vimeo_info_array['video_id'];
			
			//Create iframe with settings for vimeo
			$html_output .= '<iframe id="mp-stacks-video-bg-vimeo-' . $post_id . '" class="mp-stacks-video-bg-vimeo"  type="text/html" src="//player.vimeo.com/video/' . $video_id . '?portrait=0&badge=0&color=ff9933&autoplay=1&loop=1" frameborder="0" style="position:absolute; width:100%; height:100%; top:0; left:0px;" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
			
		}
		//If video is coming from an uploaded mp4
		else if( $brick_bg_video_source == 'mp4' ){
			$html_output .= '
			<video id="mp-stacks-video-bg-local-' . $post_id . '" class="mp-stacks-video-bg-local"  style="position:absolute; width:100%; height:100%; top:0; left:0px;" mp_stacks_video_url="' . $brick_bg_video . '" autoplay loop></video>';
		}
		
		//Close Video Container div
		$html_output .= '</div>';
			
		return $html_output;
		
	}
	
	return $html_output;
	
}
add_filter( 'mp_brick_background_content', 'mp_stacks_video_background', 10, 2 );
