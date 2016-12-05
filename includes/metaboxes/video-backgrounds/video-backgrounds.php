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
function mp_stacks_video_backgrounds_additional_items_array( $items_array ) {

	$new_items = array(

		'mp_stacks_video_backgrounds_showhider_option' => array(
			'field_id'			=> 'brick_bg_video_showhider',
			'field_title' 	=> __( 'Background Video', 'mp_stacks'),
			'field_description' 	=> 'Where is this video hosted',
			'field_type' 	=> 'showhider',
			'field_value' => '',
		),

		'mp_stacks_video_backgrounds_src_option' => array(
			'field_id'			=> 'brick_bg_video_source',
			'field_title' 	=> __( 'Background Video Source', 'mp_stacks'),
			'field_description' 	=> 'Where is this video hosted',
			'field_type' 	=> 'select',
			'field_value' => '',
			'field_select_values' => array( 'youtube' => 'YouTube', 'vimeo' => 'Vimeo', 'custom' => 'Custom Video File' ),
			'field_showhider' => 'brick_bg_video_showhider'
		),

		'mp_stacks_video_backgrounds_url_option' =>  array(
			'field_id'			=> 'brick_bg_video',
			'field_title' 	=> __( 'Background Video', 'mp_stacks'),
			'field_description' 	=> 'Enter the URL to the video page',
			'field_type' 	=> 'textarea',
			'field_value' => '',
			'field_conditional_id' => 'brick_bg_video_source',
			'field_conditional_values' => array( 'youtube', 'vimeo' ),
			'field_showhider' => 'brick_bg_video_showhider'
		),
		'mp_stacks_video_backgrounds_custom_url' =>  array(
			'field_id'			=> 'brick_bg_video_custom_url',
			'field_title' 	=> __( 'Background Video URL', 'mp_stacks'),
			'field_description' 	=> 'Upload/Enter the URL to the video',
			'field_type' 	=> 'mediaupload',
			'field_value' => '',
			'field_conditional_id' => 'brick_bg_video_source',
			'field_conditional_values' => array( 'custom' ),
			'field_showhider' => 'brick_bg_video_showhider'
		),
		'mp_stacks_video_backgrounds_custom_mobile_option' => array(
			'field_id'			=> 'brick_bg_video_custom_mobile_option',
			'field_title' 	=> __( 'Custom URL for Mobile?', 'mp_stacks'),
			'field_description' 	=> 'Do you want to set a separate custom URL for mobile?' ,
			'field_type' 	=> 'checkbox',
			'field_value' 	=> '',
                        'field_showhider' => 'brick_bg_video_showhider'
		),
		'mp_stacks_video_backgrounds_custom_mobile_url' =>  array(
			'field_id'			=> 'brick_bg_video_custom_mobile_url',
			'field_title' 	=> __( 'Background Video URL for Mobile', 'mp_stacks'),
			'field_description' 	=> 'Upload/Enter the URL to the video',
			'field_type' 	=> 'mediaupload',
			'field_value' => '',
			'field_conditional_id' => 'brick_bg_video_custom_mobile_option',
                        'field_conditional_values' => array( 'true' ),  
			'field_showhider' => 'brick_bg_video_showhider'
		),
		'mp_stacks_video_backgrounds_color_overlay' =>  array(
			'field_id'			=> 'brick_bg_video_color_overlay',
			'field_title' 	=> __( 'Color Overlay', 'mp_stacks'),
			'field_description' 	=> 'Pick a color to overlay on top of the video. This can help text content to "pop".',
			'field_type' 	=> 'colorpicker',
			'field_value' => '',
			'field_showhider' => 'brick_bg_video_showhider'
		),
		'mp_stacks_video_backgrounds_color_opacity' =>  array(
			'field_id'			=> 'brick_bg_video_color_opacity',
			'field_title' 	=> __( 'Color Opacity', 'mp_stacks'),
			'field_description' 	=> 'Select how transparent the color overlay should be.',
			'field_type' 	=> 'input_range',
			'field_value' => '50',
			'field_showhider' => 'brick_bg_video_showhider'
		),
	);

	return mp_core_insert_meta_fields( $items_array, $new_items, 'brick_bg_hook_anchor_0' );

}
add_filter('mp_stacks_bg_items_array','mp_stacks_video_backgrounds_additional_items_array');
