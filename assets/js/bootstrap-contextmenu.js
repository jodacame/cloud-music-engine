var mouse_x;
var mouse_y;
$(function () {
	 /*$(".btn-menu-music").on('click', function(event) {            	
           mouse_x =  $(this).offset().left - $(window).scrollLeft();;
           mouse_y = $(this).offset().top+$(this).height()+10- $(window).scrollTop();
           console.log(mouse_x);
       });*/
});
(function ($, window) {

    $.fn.contextMenu = function (settings) {

        return this.each(function () {

            // Open context menu
            $(this).on("contextmenu", function (e,a) {


                // return native menu if pressing control
              //  if (e.ctrlKey) return;
                var _this = $(this);

                if(!$(this).attr("data-title") || !$(this).attr("data-subtitle"))
                    return;      

                	$("#menu-music h2").text($(this).attr("data-title"));
			        $("#menu-music h3").text($(this).attr("data-subtitle"));
                    $("#menu-music .btn-play,#menu-music a").attr("data-title",$(this).attr("data-title"));
                    $("#menu-music .btn-play,#menu-music a").attr("data-subtitle",$(this).attr("data-subtitle"));
			        $("#menu-music .btn-play,#menu-music a").attr("data-track",$(this).attr("data-track"));
			        $("#menu-music .btn-play,#menu-music a").attr("data-artist",$(this).attr("data-artist"));
                    $("#menu-music .btn-play,#menu-music a").attr("data-image",$(this).attr("data-image"));
                    $("#menu-music .btn-play,#menu-music a").attr("data-album",$(this).attr("data-album"));
                    $("#menu-music .btn-play,#menu-music a").attr("data-type",$(this).attr("data-type"));
                    $("#menu-music .btn-play,#menu-music a").attr("data-id",$(this).attr("data-id"));
			        $("#menu-music .btn-play,#menu-music a").attr("data-stationid",$(this).attr("data-stationid"));
			        $("#menu-music .list-group a").addClass("hide");
                    console.log($(this).attr("data-type"));
                    $("#menu-music .only-"+$(this).attr("data-type")).removeClass("hide");
                    $("#menu-music .only-all").removeClass("hide");                    
			        $("#menu-music .image").css('background-image', 'url(' + $(this).attr("data-image") + ')');
			        
                    app.save2pl.artist        = $(this).attr("data-artist");
                    app.save2pl.track         = $(this).attr("data-track");
                    app.save2pl.album         = $(this).attr("data-album");
                    app.save2pl.image         = $(this).attr("data-image");
                    app.save2pl.id         = $(this).attr("data-id");

                //open menu
             console.log(a);
                var _x =e.clientX;
                var _y =e.clientY;
                if(!_x)
                {
                	_x = a.clientX;
                	_y = a.clientY;
                }
                var $menu = $(settings.menuSelector)
                    .data("invokedOn", $(e.target))
                    .addClass("show")
                    .css({
                        position: "absolute",
                        left: getMenuPosition(_x, 'width', 'scrollLeft'),
                        top: getMenuPosition(_y, 'height', 'scrollTop')
                    })
                    .off('click')
                    .on('click', 'a', function (e) {
                        if(!$(this).hasClass('no-close'))
                        {
                         

                           $("#playlist-menu").removeClass("show");                     
                            $menu.removeClass("show");                    
                            var $invokedOn = $menu.data("invokedOn");
                            var $selectedMenu = $(e.target);                            
                            settings.menuSelected.call(this, _this,$invokedOn, $selectedMenu);
                        }
                    });
                
                return false;
            });

            //make sure menu closes on any click
          /*  $(document).on('click contextmenu', function(event) {              	
            	if(!$(event.target).hasClass('btn-menu-music') && !$(event.target).hasClass('no-close'))
                {
                    $("#playlist-menu").removeClass("show");                     
            		$(settings.menuSelector).removeClass("show");
                }
            });*/
        $(document).on('mousedown', function(event) {                   
                    switch (event.which) {
                        case 1:

                            //alert('Left Mouse button pressed.');
                            if(!$(event.target).hasClass('btn-menu-music') && !$(event.target).hasClass('no-close'))
                            {

                                setTimeout(function() {
                                    $("#playlist-menu").removeClass("show");                     
                                    $(settings.menuSelector).removeClass("show");
                                }, 400);
                            }
                            break;
                        case 2:
                            //alert('Middle Mouse button pressed.');
                            break;
                        case 3:
                            //alert('Right Mouse button pressed.');
                            break;
                        default:
                            //alert('You have a strange Mouse!');
                    }
                });

        });
        
        function getMenuPosition(mouse, direction, scrollDir) {
            var win = $(window)[direction](),
                scroll = $(window)[scrollDir](),
                menu = $(settings.menuSelector)[direction](),
                position = mouse + scroll;

                        
            // opening menu would pass the side of the page
            if (mouse + menu > win && menu < mouse) 
                position -= menu;
           
            return position;
        }    

    };
})(jQuery, window);

contextMenu_init();
$(document).on('page-loaded', function(event) {        
	contextMenu_init();
});


function contextMenu_init()
{
	$(".contextMenu").contextMenu({
	    menuSelector: "#menu-music",
	    menuSelected: function (elm,invokedOn, selectedMenu) {
	        var msg = "You selected the menu item '" + selectedMenu.text() +
	            "' on the value '" + invokedOn.text() + "'";
	        
	        console.log($(elm).attr("data-track"));
	    }
	});
}