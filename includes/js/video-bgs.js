jQuery(document).ready(function($){
		
		/**
		 * Position all Video Backgrounds
		 *
		 * @since    1.0.0
		 * @link     http://mintplugins.com/doc/
		 * @see      function_name()
		 * @param    void
		 * @return   void
		 */
		function mp_stacks_video_bg_positions(){
			$('.mp-stacks-video-bg-placeholder-img').each(function(){
				
				var image_placeholder = $(this);
				var parent_brick_id = '#' + image_placeholder.attr('parent_brick_id');
				var brick_bg_inner = $( parent_brick_id + ' .mp-brick-bg-inner' );
				var video_bg = $( parent_brick_id + ' .mp-stacks-video-bg-video' );
				
				//Set the image height to match the background container size
				image_placeholder.css( 'min-height', brick_bg_inner.innerHeight() );
				video_bg.css( 'width', image_placeholder.innerWidth() );
				
				//Set height to center vertically
				var half_brick_height = $( parent_brick_id ).height()/2;
				var half_video_height = image_placeholder.height() / 2;
				//image_placeholder.css( 'margin-top', half_brick_height - half_video_height );
				video_bg.css( 'top', half_brick_height - half_video_height );
				
				//Set width to center horizontally
				var half_brick_width = $( parent_brick_id ).width()/2;
				var half_video_width = image_placeholder.width() / 2;
				//image_placeholder.css( 'margin-left', half_brick_width - half_video_width );
				video_bg.css( 'left', half_brick_width - half_video_width );
				
			});
		}
		
		mp_stacks_video_bg_positions();
		
		$( document ).on( 'mp_stacks_resize_complete', function(){
			mp_stacks_video_bg_positions();
		});
		
		$(window).load(function(){ 
			//Run the function to position the videos bgs on page load
			mp_stacks_video_bg_positions();
			
			//For any locally hosted videos, set the src now so it doesn't lag
			$('.mp-stacks-video-bg-custom').each(function(){
			$(this).attr('src', $(this).attr('mp_stacks_bg_video_url') );
		});
		});
		
});