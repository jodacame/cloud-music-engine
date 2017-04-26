
	var tag = document.createElement('script');
	tag.src = "//www.youtube.com/iframe_api";
	var firstScriptTag = document.getElementsByTagName('script')[0];
	firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
	
	var yt_player_1 = false;
	var yt_playing = false;
	is_youtube = true;
	var first_load =true;
	$(function () {

		initializeJplayerControls();
	});
	function onYouTubeIframeAPIReady(id){
	
		yt_player_1 = new YT.Player('jquery_jplayer_1',{
			height		: '200',
			width		: '200',
			videoId		: '',			
			playerVars:{
				'autohide':			1,				
				'controls': 		1,
				'fs':				1,
				'disablekb':		1,
				'modestbranding':	1,
				// 'cc_load_policy': 1, // forces closed captions on
				'iv_load_policy':	3, // annotations, 1=on, 3=off
				// 'playlist': videoID, videoID, videoID, etc,
				'rel':				0,
				'showinfo':			0,
				'theme':			'dark',	// dark, light
				'color':			'red',	// red, white
				'webkit-playsinline': '1',
				'allowfullscreen'	: 0,
				'html5'	: 1
				
				},
			events:{
				'onReady': onPlayerReady,
				'onPlaybackQualityChange': onPlayerPlaybackQualityChange,
				'onPlaybackRateChange' : onPlaybackRateChange,
				'onStateChange': onPlayerStateChange,
				'onError': onPlayerError
				}
			});
		}
	function loadVideo(id)
	{
		

		$('#jp_container_1 .jp-progress .jp-play-bar').width('0%' );
		$('#jp_container_1 .jp-progress .jp-play-handle').css({left: '0%'} );

		
		if(yt_player_1)
		{			
			player.player.jPlayer( "clearMedia" );			
			yt_player_1.loadVideoById(id,0,'default');
			
			
		}
		else
		{
			onYouTubeIframeAPIReady(id);
		}
		$("#jquery_jplayer_overlay").removeClass('hide');
		

	}
	function onPlayerReady(data){
		
		yt_player_1.setVolume(80);
		$( document ).trigger( "youtube-ready");
		 console.log("YT READY!");
		$('#jp_container_1 .jp-volume-bar .jp-volume-bar-value').width( '80%' );
	} // END FUNCTION
	
	function onPlayerPlaybackQualityChange(quality){
	} // END FUNCTION
		
	function onPlaybackRateChange(rate){
	} // END FUNCTION
	
	function onPlayerStateChange(state){
		switch(state.data){
			case -1: //unstarted
				/* do something */
				break;
			case 0: // ended
				$('#jp_container_1 .jp-pause').show();
				$('#jp_container_1 .jp-play').hide();
				yt_playing = false;
				player.playNext();
				$(".loading-streaming").removeClass('hide');
				$("#jquery_jplayer_overlay .loading").addClass('show');
				break;
			case 1: // playing
				$('#jp_container_1 .jp-pause').show();
				$('#jp_container_1 .jp-play').hide();
				yt_playing = true;
				startYoutubeTime();
				player._play();
				$(".loading-streaming").addClass('hide');
				$("#jquery_jplayer_overlay .loading").removeClass('show');
				$('#jp_container_1 .jp-duration').text(hhmmss(yt_player_1.getDuration()));
				break;
			case 2: // paused
				$('#jp_container_1 .jp-pause').hide();
				$('#jp_container_1 .jp-play').show();
				player._paused();
				yt_playing = false;
				break;
			case 3: // buffering
				/* do something */
				yt_playing = true;
				$(".loading-streaming").removeClass('hide');
				$("#jquery_jplayer_overlay .loading").addClass('show');
				break;
			case 5: // video cued
				/* do something */
				console.log("cued!!");
				/*yt_playing = false;
				player.playNext();*/
				break;
			default:
				// do nothing
			}
	} // END FUNCTION
	
	function onPlayerError(error){
		console.log("Error Youtube");
		console.log(error);
	} // END FUNCTION
	
	function youtubeFeedCallback(data){
		jQuery(document).ready(function(){
			$('.jp-track-title').text( data.entry['title'].$t /* +' - from: '+data.entry["author"][0].name.$t */ );
			$('#jp_container_1 .jp-duration').text(hhmmss(yt_player_1.getDuration()));
		});
	} // END FUNCTION
	
	var youTubeFrequency = 100;
	var youTubeInterval = 0;
	function startYoutubeTime(){
		if(youTubeInterval > 0) clearInterval(youTubeInterval);  // stop
		youTubeInterval = setInterval( "updateYoutubeTime()", youTubeFrequency );  // run
	} // END FUNCTION
	function stopYoutube(){
		if(yt_player_1)
		{
			clearInterval(youTubeInterval);  // stop
			try{
			 yt_player_1.stopVideo();	
			}catch(e){}

		}
		 yt_playing =false;	
	} // END FUNCTION
	function updateYoutubeTime(){
		if(!yt_playing)
			return false;
		
		if( yt_player_1.getCurrentTime()>=60 ){
			$('#jp_container_1 .jp-current-time').text( Math.floor(yt_player_1.getCurrentTime()/60)+':'+FormatNumberLength(Math.round(yt_player_1.getCurrentTime()%60),2) );
		}else{
			$('#jp_container_1 .jp-current-time').text( '0:'+FormatNumberLength(Math.round(yt_player_1.getCurrentTime()),2) );
			
		
		}
			$('#jp_container_1 .jp-progress .jp-play-bar').width( ((yt_player_1.getCurrentTime()/yt_player_1.getDuration())*100)+'%' );
			$('#jp_container_1 .jp-progress .jp-play-handle').css({left: ((yt_player_1.getCurrentTime()/yt_player_1.getDuration())*100)+'%'} );

	} // END FUNCTION
	function FormatNumberLength(num,length){var r=""+num;while(r.length<length){r="0"+r;}return r;} // END FUNCTION
		
	function initializeJplayerControls(){
		$('#jp_container_1 .jp-pause').hide();
		$('#jp_container_1 .jp-unmute').hide();
		$('#jp_container_1 .jp-restore-screen').hide();
		
		$('#jp_container_1 .jp-play').on('click',function(){
			console.log(player.current);
			
			if(player.current.source == 'youtube')
			{
				$(this).hide();
				$('#jp_container_1 .jp-pause').show();
				if(first_load)
				{
					player.play(player.current.artist,player.current.track,player.current.image,player.current.album,false,player.current.type,player.current.stationID,player.current.id);  
				}
				else
				{
					yt_player_1.playVideo();	
				}
				
				first_load =false;

			}

		});
		$('#jp_container_1 .jp-pause').on('click',function(){
			//console.log(player.current);
			if(player.current.source == 'youtube')
			{
				$(this).hide();
				$('#jp_container_1 .jp-play').show();
				yt_player_1.pauseVideo();
			}
		});
		
		
		$('#jp_container_1 .jp-mute').on('click',function(){
			//console.log(player.current);
			if(player.current.source == 'youtube' || 1==1)
			{
				$(this).hide();
				$('#jp_container_1 .jp-unmute').show();
				$('#jp_container_1 .jp-volume-bar .jp-volume-bar-value').hide();
				yt_player_1.mute();
			}
		});
		$('#jp_container_1 .jp-unmute').on('click',function(){
			//console.log(player.current);
			if(player.current.source == 'youtube' || 1==1)
			{
				$(this).hide();
				$('#jp_container_1 .jp-mute').show();
				$('#jp_container_1 .jp-volume-bar .jp-volume-bar-value').show();
				yt_player_1.unMute();
			}
		});
		$('#jp_container_1 .jp-volume-bar').click(function(e){
			//console.log(player.current);
			if(player.current.source == 'youtube' || 1==1)
			{
				var posX = $(this).offset().left, posWidth = $(this).width();
				posX = (e.pageX-posX)/posWidth;
				$('#jp_container_1 .jp-volume-bar .jp-volume-bar-value').width( (posX*100)+'%' ).show();
				yt_player_1.setVolume(posX*100);
				
				$('#jp_container_1 .jp-unmute').hide();
				$('#jp_container_1 .jp-mute').show();
			}
		});
		$('#jp_container_1 .jp-seek-bar').click(function(e){
			//console.log(player.current);
			if(player.current.source == 'youtube')
			{
				var posX = $(this).offset().left, posWidth = $(this).width();
				posX = (e.pageX-posX)/posWidth;
				$('#jp_container_1 .jp-progress .jp-play-bar').width( (posX*100)+'%' );
				posX = Math.round((posX)*yt_player_1.getDuration());
				yt_player_1.seekTo(posX, true);
			}
		});
		$("#jp_container_1.jp-video-full .jp-gui").on('click',function(e){
			if(e.target != this) return;
			if( $('#jp_container_1 .jp-play').is(':visible') ){
				$('#jp_container_1 .jp-play').click();
			}else{
			   $('#jp_container_1 .jp-pause').click();
			}
		});
		
		var fullScreenHoverTime;
		$("#jp_container_1.jp-video-full").on('mouseover',function(){
			$('.jp-gui', this).show();
			clearTimeout(fullScreenHoverTime);
			fullScreenTimeout();
		});
		function fullScreenTimeout(){
			fullScreenHoverTime = setTimeout(function(){
				$('#jp_container_1 .jp-gui').hide();
			},5000);
		}

		$( "#jquery_jplayer_overlay" )
			  .mouseover(function() {
			    $(this).addClass('hide');
			  });
			  

		$("#jquery_jplayer_overlay").on('dblclick', function(event) {
        	event.preventDefault();
         	
			
					/*var i = document.getElementById("jquery_jplayer_1");

					// go full-screen
					if (i.requestFullscreen) {
					  i.requestFullscreen();
					} else if (i.webkitRequestFullscreen) {
					  i.webkitRequestFullscreen();
					} else if (i.mozRequestFullScreen) {
					  i.mozRequestFullScreen();
					} else if (i.msRequestFullscreen) {
					  i.msRequestFullscreen();
					}*/
			console.log("fullscreen");	
		});
	}

	function getPlayerState() {	
			try{
		    	return yt_player_1.getPlayerState();  
			}catch(e)
			{		
				return -1;
			}

		    
		}