if(is_mobile)
   var first_load = true;
$(document).ready(function() {

   player.player =  $("#jquery_jplayer_1").jPlayer({
       
        swfPath: "http://jplayer.org/latest/dist/jplayer",
        supplied: "webm,mp3,m4a",
        cssSelectorAncestor:"",
		wmode: "window",
    preload:"auto",       
		useStateClassSkin: true,		
		smoothPlayBar: true,
		keyEnabled: true,
		remainingDuration: false,
		toggleDuration: true,
        warningAlerts:false,
        errorAlerts:false,
          mute: '.jp-mute',
          unmute: '.jp-unmute',
          volumeBar: '.jp-volume-bar',
          volumeBarValue: '.jp-volume-bar-value',
          volumeMax: '.jp-volume-max',
		ended : function(){
            console.log("ended");
            player.playNext();
        },
        pause: function()
        {
            player._paused();
        },
        play: function()
        {
            player._play();
            $(".loading-streaming").addClass('hide');
            $("#jquery_jplayer_overlay .loading").removeClass('show');
        },
         error: function (event) {
            
            console.info(player.current.source);
           if(player.current.source != 'youtube' && !first_load)
            {
                gui.noty(event.jPlayer.error.message,lang.error500,player.current.image);
                console.log(event.jPlayer.error);
                console.log(event.jPlayer.error.type);
                console.log("Jodacame: Error Song!");
                player.playNext();
            }
         }
    });   
   
});                                      
