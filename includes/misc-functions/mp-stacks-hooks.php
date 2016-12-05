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
	$brick_bg_video_custom_mobile_option = mp_core_get_post_meta( $post_id, 'brick_bg_video_custom_mobile_option' );

	$foreign_video_url = mp_core_get_post_meta( $post_id, 'brick_bg_video' );
	$custom_video_url = mp_core_get_post_meta( $post_id, 'brick_bg_video_custom_url' );

	//Color Overlay Settings
	$color_overlay = mp_core_get_post_meta( $post_id, 'brick_bg_video_color_overlay', 'none' );
	$color_opacity = mp_core_get_post_meta( $post_id, 'brick_bg_video_color_opacity', 50 );
	$color_opacity = $color_opacity / 100;
	$custom_mobile_video_url = mp_core_get_post_meta( $post_id, 'brick_bg_video_custom_mobile_url' );


	//Convert to rgb from hex
	$color_overlay_rgb_array = $color_overlay != 'none' ? mp_core_hex2rgb($color_overlay) : NULL;


	//If this is an iPhone or iPad and $brick_bg_video_custom_mobile_option is true and $custom_mobile_video_url is set
	if ( $brick_bg_video_custom_mobile_option && !empty( $custom_mobile_video_url ) && ( mp_core_is_iphone() || mp_core_is_ipad() ) ){
		//Use the same functions for the normal circumstance, just change the variables
		$custom_video_url = $custom_mobile_video_url;
		$foreign_video_url = '';
		$brick_bg_video_source = '';
		$brick_bg_video_source == 'custom'
	}


	//If a background video has been entered
	if ( !empty( $foreign_video_url ) || !empty( $custom_video_url ) ){

		//Video Backgrounds JS
		wp_enqueue_script( 'mp_stacks_video_bg_js', plugins_url('js/video-bgs.js', dirname(__FILE__)), array('jquery', 'mp_stacks_front_end_js'), MP_STACKS_VIDEO_BACKGROUNDS_VERSION, true );

		//Video Container div
		$html_output .= '<div class="mp-stacks-video-backgrounds-container" style="position:relative;">';
		//If a color overlay has been set
		if ( !empty( $color_overlay_rgb_array ) ){

			//Add style lines to css output
			$color_overlay_css_output = 'background-color:rgba(' . $color_overlay_rgb_array[0] . ', ' . $color_overlay_rgb_array[1] . ' , ' . $color_overlay_rgb_array[2] . ', ' . $color_opacity . ')';

			$html_output .= '<div class="mp-stacks-video-backgrounds-overlay" style="z-index:2; position:absolute; width:100%; height:100%; ' . esc_attr(  $color_overlay_css_output ) . ';"></div>';
		}

		//Image which sizes the video correctly to 16x9
		$html_output .= '<img class="mp-stacks-video-bg-placeholder-img" style="position:relative; display:block; padding:0px; margin-bottom:0px; min-width:100%; min-height: 100%; max-width:999%; z-index:2;" src="' . MP_CORE_PLUGIN_URL . 'includes/images/16x9.png' . '" parent_brick_id="mp-brick-' . esc_attr( $post_id ) . '"/>';

		//If this video is coming from YouTube
		if ( $brick_bg_video_source == 'youtube' ){

			//YouTube API JS
			wp_enqueue_script( 'mp_stacks_video_youtube_js', plugins_url('js/youtube.js', dirname(__FILE__)), array('jquery', 'mp_stacks_front_end_js'), MP_STACKS_VIDEO_BACKGROUNDS_VERSION, true );

			//Find the youtube video id by checking all the types of urls we could be given
			if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $foreign_video_url, $match)) {
				$video_id = $match[1];
			}

			//Create iframe with settings for youtube
			$html_output .= '<iframe id="mp-stacks-video-bg-youtube-' . esc_attr( $post_id ) . '" class="mp-stacks-video-bg-youtube mp-stacks-video-bg-video" type="text/html" src="https://www.youtube.com/embed/' . esc_attr( $video_id ) . '?enablejsapi=1&controls=0&modestbranding=1&showinfo=0&wmode=transparent&rel=0&autoplay=1&muted=1&html5=1&?VQ=HD720" frameborder="0" style="position:absolute; width:100%; height:100%; max-width:999%; top:0; left:0px; z-index:1;" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
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
			<video id="mp-stacks-video-bg-local-' . esc_attr( $post_id ) . '" class="mp-stacks-video-bg-custom mp-stacks-video-bg-video"  style="position:absolute; width:100%; height:100%; max-width:999%; top:0; left:0px; z-index:1;" mp_stacks_bg_video_url="' . esc_attr( $custom_video_url ) . '" muted autoplay loop playsinline></video>';
		}


		//Close Video Container div
		$html_output .= '</div>';

		return $html_output;

	}

	return $html_output;

}
add_filter( 'mp_brick_background_content', 'mp_stacks_video_background', 10, 2 );
