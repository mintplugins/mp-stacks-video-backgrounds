<?php
/**
 * This page contains the functions to make a metabox for Video Backgrounds
 *
 * @link http://mintplugins.com/doc/metabox-class/
 * @since 1.0.0
 *
 * @package    MP Stacks Video Backgrounds
 * @subpackage Functions
 *
 * @copyright   Copyright (c) 2014, Mint Plugins
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author      Philip Johnston
 */
 
/**
 * Function which adds Video Background as an option the brick background metabox
 *
 * @since    1.0.0
 * @link     http://mintplugins.com/doc/metabox-class/
 * @see      MP_CORE_Metabox
 * @return   void
 */
function mp_stacks_video_backgrounds_additional_items_array($items_array) {
	
	$counter = 0;
	
	//Loop through passed-in metabox fields
	foreach ( $items_array as $item ){
		
		//If the current loop is for the brick_bg_image
		if ($item['field_id'] == 'brick_display_type'){
			
			//Split the array after the array with the field containing 'brick_bg_image'
			$options_prior = array_slice($items_array, 0, $counter+1, true);
			$options_after = array_slice($items_array, $counter+1);
			
			break;
						
		}
		
		//Increment Counter
		$counter = $counter + 1;
	
	}
	
	if ( !empty($options_prior) ){
		
		//Add the first options to the return array
		$return_items_array = $options_prior;
		
		$mp_stacks_video_backgrounds_src_option = array(
				'field_id'			=> 'brick_bg_video_source',
				'field_title' 	=> __( 'Background Video Source', 'mp_stacks'),
				'field_description' 	=> 'Where is this video hosted',
				'field_type' 	=> 'select',
				'field_value' => '',
				'field_select_values' => array( 'youtube' => 'YouTube', 'vimeo' => 'Vimeo', 'mp4' => 'I will upload an MP4 here' )
		);
		
		//Globalize the and populate the mp_stacks_googlefonts_items_array (do this before filter hooks are run)
		global $global_mp_stacks_video_backgrounds_src_option;
		$global_mp_stacks_video_backgrounds_src_option = $mp_stacks_video_backgrounds_src_option;
	
		//Add new option to array  for main image lightbox
		array_push($return_items_array, $mp_stacks_video_backgrounds_src_option );
		
		$mp_stacks_video_backgrounds_url_option =  array(
				'field_id'			=> 'brick_bg_video',
				'field_title' 	=> __( 'Background Video', 'mp_stacks'),
				'field_description' 	=> 'Upload/Enter the URL to the video',
				'field_type' 	=> 'textarea',
				'field_value' => '',
			);
		
		//Globalize the and populate the mp_stacks_googlefonts_items_array (do this before filter hooks are run)
		global $global_mp_stacks_video_backgrounds_url_option;
		$global_mp_stacks_video_backgrounds_url_option = $mp_stacks_video_backgrounds_url_option;
		
		//Add new option to array  for main image lightbox
		array_push($return_items_array, $mp_stacks_video_backgrounds_url_option	);
		
		foreach ($options_after as $option){
			//Add all fields that came after
			array_push($return_items_array, $option);
		}
		
	}
		
    return $return_items_array;
}
add_filter('mp_stacks_bg_items_array','mp_stacks_video_backgrounds_additional_items_array');