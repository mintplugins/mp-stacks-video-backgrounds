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
				
				var half_brick_height = $(this).parent().parent().parent().height()/2;
				var half_video_height = $(this).height() / 2;
								
				$(this).css( 'margin-top', half_brick_height - half_video_height );
			});
		}
		
		$(window).load(function(){ 
			//Run the function to position the videos bgs on page load
			mp_stacks_video_bg_positions();
			
			//For any locally hosted videos, set the src now so it doesn't lag
			$('.mp-stacks-video-bg-local').each(function(){
			$(this).attr('src', $(this).attr('mp_stacks_video_url') );
		});
		});
		
});