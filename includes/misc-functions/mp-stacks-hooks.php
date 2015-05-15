<?php 
/**
 * MP Stacks + Video Backgrounds Scripts and Functions
 *
 * @link http://mintplugins.com/doc/
 * @since 1.0.0
 *
 * @package    MP Stacks + Video Backgrounds
 * @subpackage Functions
 *
 * @copyright   Copyright (c) 2015, Mint Plugins
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

	$brick_bg_video_source = mp_core_get_post_meta( $post_id, 'brick_bg_video_source' );
	
	$foreign_video_url = mp_core_get_post_meta( $post_id, 'brick_bg_video' );
	$custom_video_url = mp_core_get_post_meta( $post_id, 'brick_bg_video_custom_url' );
	
	//If this is an iphone or ipad, we don't want to show any video background cause it can't handle it
	if ( $brick_bg_video_source != 'custom' && ( mp_core_is_iphone() || mp_core_is_ipad() ) ){
		return false;	
	}
	
	//If a background video has been entered
	if ( !empty( $foreign_video_url ) || !empty( $custom_video_url ) ){
		
		//Video Container div
		$html_output .= '<div class="mp-stacks-video-backgrounds-container" style="position:relative;">';
		
		//Image which sizes the video correctly to 16x9
		$html_output .= '<img class="mp-stacks-video-bg-placeholder-img" style="position:relative; display:block; padding:0px; margin-bottom:0px; min-width:100%; min-height: 100%; max-width:999%; z-index:2;" src="' . MP_CORE_PLUGIN_URL . 'includes/images/16x9.png' . '" parent_brick_id="mp-brick-' . $post_id . '"/>';
			
		//If this video is coming from YouTube
		if ( $brick_bg_video_source == 'youtube' ){
			
			//Find the youtube video id by checking all the types of urls we could be given
			if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $foreign_video_url, $match)) {
				$video_id = $match[1];
			}
			
			//Create iframe with settings for youtube
			$html_output .= '<iframe id="mp-stacks-video-bg-youtube-' . $post_id . '" class="mp-stacks-video-bg-youtube mp-stacks-video-bg-video" type="text/html" src="https://www.youtube.com/embed/' . $video_id . '?enablejsapi=1&controls=0&modestbranding=1&showinfo=0&wmode=transparent&rel=0&autoplay=1&muted=1&html5=1" frameborder="0" style="position:absolute; width:100%; height:100%; max-width:999%; top:0; left:0px; z-index:1;" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
		}
		//If video is coming from Vimeo
		else if( $brick_bg_video_source == 'vimeo' ){
						
			//Get json from vimeo about this video using Curl 
			$curl = curl_init('http://vimeo.com/api/oembed.json?url=' . $foreign_video_url );
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_TIMEOUT, 30);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
			$vimeo_info_array = curl_exec($curl);
			curl_close($curl);
				
			
			//Json decode Vimeo info array
			$vimeo_info_array = json_decode($vimeo_info_array, true);
			
			$video_id = $vimeo_info_array['video_id'];
			
			//Create iframe with settings for vimeo
			$html_output .= '<iframe id="mp-stacks-video-bg-vimeo-' . $post_id . '" class="mp-stacks-video-bg-vimeo mp-stacks-video-bg-video"  type="text/html" src="//player.vimeo.com/video/' . $video_id . '?portrait=0&badge=0&color=ff9933&autoplay=1&loop=1" frameborder="0" style="position:absolute; width:100%; height:100%; max-width:999%; top:0; left:0px; z-index:1;" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
			
		}
		//If video is coming from an uploaded mp4
		else if( $brick_bg_video_source == 'custom' ){
			$html_output .= '
			<video id="mp-stacks-video-bg-local-' . $post_id . '" class="mp-stacks-video-bg-custom mp-stacks-video-bg-video"  style="position:absolute; width:100%; height:100%; max-width:999%; top:0; left:0px; z-index:1;" mp_stacks_video_url="' . $custom_video_url . '" autoplay loop></video>';
		}
		
		//Close Video Container div
		$html_output .= '</div>';
			
		return $html_output;
		
	}
	
	return $html_output;
	
}
add_filter( 'mp_brick_background_content', 'mp_stacks_video_background', 10, 2 );
