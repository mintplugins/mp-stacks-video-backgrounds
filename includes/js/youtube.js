//This code loads the IFrame Player API code asynchronously.
var mp_stacks_video_bgs_tag = document.createElement('script');
mp_stacks_video_bgs_tag.src = "https://www.youtube.com/iframe_api";
var mp_stacks_video_bgs_script_tag = document.getElementsByTagName('script')[0];
mp_stacks_video_bgs_script_tag.parentNode.insertBefore(mp_stacks_video_bgs_tag, mp_stacks_video_bgs_script_tag);


//Fires when the API is ready
function onYouTubeIframeAPIReady() {
	
	//Find all the youtube video backgrounds on this page	
	var els = document.getElementsByClassName('mp-stacks-video-bg-youtube');
	
	//Loop through them
	Array.prototype.forEach.call(els, function(el) {
		mp_stacks_video_bgs_var = new YT.Player(el.id, {
			videoId: 'doesnotmatter',
			width: '100%',
			height: '100%',
			playerVars: { 'controls': 0, 'modestbranding': 1, 'showinfo':0, 'wmode':'transparent', 'enablejsapi':1 , 'origin':'', 'rel':0, 'autoplay':1, 'html':1 },
			events: {
				'onReady': mp_stacks_video_bgs_on_ready,
				'onStateChange': mp_stacks_video_bgs_on_state_change
			}
		});
		
	});
		
}

//Fires when the video player is ready.
function mp_stacks_video_bgs_on_ready(event) {
	
	//trigger set up event
	jQuery(window).trigger("mp_stacks_video_bgs_set_up_player", event);
	
	//Mute the video background by default
	event.target.mute();

}

//Fires when the players state changes
function mp_stacks_video_bgs_on_state_change(event) {
	
	//trigger state change event
	jQuery(window).trigger("mp_stacks_video_bgs_state_change", event);
	
	//If the video is done playing
	if ( event.data == YT.PlayerState.ENDED ){
	
		//Loop it by starting it over
		event.target.seekTo(1, true);
		event.target.playVideo();
		
	
	}
	
}

//Fullscreen Function - looks for the right function for the right browser
function mp_stacks_video_bgs_launchFullscreen(element) {
  if(element.requestFullscreen) {
	element.requestFullscreen();
  } else if(element.mozRequestFullScreen) {
	element.mozRequestFullScreen();
  } else if(element.webkitRequestFullscreen) {
	element.webkitRequestFullscreen();
  } else if(element.msRequestFullscreen) {
	element.msRequestFullscreen();
  }
}