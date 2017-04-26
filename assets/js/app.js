var listen_click = "click";
var listen_touch = 'click';  
var temp_title = '';
var is_youtube = false;
var player = {};
var gui = {};
player.playlist = [];
player.current = {};
player.status = {};
player.station = {};
player.station.current = {};
player.station.timemout = false;
player.type = 'track';
var app = {};
app.save2pl = {};
app.save2pl.artist = '';
app.save2pl.track = '';
app.save2pl.album = '';
app.save2pl.image = '';
app.save2pl.id = '';
app.last_search = '';
app.country_code = 'us';
app.lastest_searches = [];
var first_time_load = true;
if (is_mobile)
{
  listen_click = 'click';  
  listen_touch = 'touchstart';  
} 
$(window).load(function() {
    $(".play-1").trigger(listen_click);
});
$(document).ready(function() {
    if (!is_logged) {
        player.clearPlaylist();
    }
    $('#player').show();
    loading("hide");
    // app.render_search();
    //$("#main").niceScroll({mousescrollstep:70,scrollspeed:50,cursorborderradius:"0px",cursorborder:"1px solid rgba(0,0,0,.5)",cursorwidth:"8px", boxzoom:false});
    //$(".scroll").niceScroll({cursorborderradius:"0px",cursorborder:"1px solid rgba(0,0,0,.5)",cursorwidth:"8px", boxzoom:false});
    //$("#sidebar-wrapper").niceScroll({cursorborderradius:"0px",cursorborder:"1px solid rgba(0,0,0,.5)",cursorwidth:"8px", boxzoom:false});
    $(".lazy").lazyload({
        container: $("#main"),
        threshold: 20,
        effect: "fadeIn"
    });
    

   $('.player-c').drags();

     if(localStorage.getItem('showYoutube') == 0)
        $(".player-c").addClass('hidex');

    

    gui.refresh_playlist();
    $(document).on('page-loaded', function(event) {
        event.preventDefault();
        $(".lazy").lazyload({
            container: $("#main")
        });
        $(".play-1").trigger(listen_click);
        $(".btn-now-playing").removeClass("active");
        $(".btn-now-playing2").removeClass("active text-success");
    });
    var playing_now = localStorage.getItem('playing_now');
    if (playing_now) {
        var data = JSON.parse(playing_now);
        player.playlist = data;
        player.current = data[0];
        $("#count-now-playing").text(player.playlist.length);
    }
    $(document).on(listen_click, '.btn-add-to-playlist', function(event) {
        event.preventDefault();
        var artist = $(this).attr("data-artist");
        var track = $(this).attr("data-track");
        var album = $(this).attr("data-album");
        var image = $(this).attr("data-image");
        var type = $(this).attr("data-type");
        var id = $(this).attr("data-id");
        if (artist && track) {
            player.addtrack(artist, track, album, image, type, false, id);
            $("#menu-music").modal("hide");
        }
    });     
    $(document).on(listen_touch, '.btn-toggle-youtube', function(event) {
        event.preventDefault();
        $(".player-c").toggleClass('hidex');
        if(localStorage.getItem('showYoutube') == 1)
            localStorage.showYoutube = 0;
        else
            localStorage.showYoutube = 1;
        
        
    }); 
    $(document).on(listen_click, '.btn-langs', function(event) {
        event.preventDefault();        
        $("#modal-langs").modal("show");
        
    });
 

    $(document).on(listen_click, '.btn-buy', function(event) {
        event.preventDefault();
        var artist = $(this).attr("data-artist");
        var track = $(this).attr("data-track");
        var album = $(this).attr("data-album");
        var image = $(this).attr("data-image");
        var title = $(this).attr("data-title");
        var type = $(this).attr("data-type");
        var id = $(this).attr("data-id");
        var s = $(this).attr("data-s");
        $("#modal-buy .service").removeClass("hide");
        if (type == 'album') {
            track = '';
            $("#modal-buy .service-youtube").addClass("hide");
            $("#modal-buy .service-spotify").addClass("hide");
            $("#modal-buy .service-soundcloud").addClass("hide");
        }
        if (artist) {
            var f = '';
            if (!track && title) track = title;
            if (!track) track = '';
            if (track) {
                f = ' - ';
            }
            $("#modal-buy #d-title").text(artist + f + track);
            $("#modal-buy #d-image").attr("src", image);
            $.each($("#modal-buy a"), function(index, val) {
                $(this).attr("href", base_url + "d?artist=" + artist + "&track=" + track + "&s1=" + $(this).attr("data-s"));
            });
            $("#modal-buy").modal("show");
        }
    });
    $(document).on(listen_click, '.btn-share', function(event) {
        event.preventDefault();
        var artist = $(this).attr("data-artist");
        var track = $(this).attr("data-track");
        var album = $(this).attr("data-album");
        var image = $(this).attr("data-image");
        var type = $(this).attr("data-type");
        var title = $(this).attr("data-title");
        var name = $(this).attr("data-name");
        var subtitle = $(this).attr("data-subtitle");
        var stationID = $(this).attr("data-stationid");
        var idplaylist = $(this).attr("data-idplaylist");
        var id = $(this).attr("data-id");
        if (!type) {
            return false;
        }
        if (type == 'station') {
            url = base_url + slug.station + "/-/" + encodeURIComponent(title) + "-" + stationID;
        }
        if (type == 'track') {
            url = base_url + slug.main + "/" + encodeURIComponent(artist) + "/" + encodeURIComponent(album) + '/' + encodeURIComponent(track);
        }
        if (type == 'album') {
            url = base_url + slug.main + "/" + encodeURIComponent(artist) + "/" + encodeURIComponent(album);
        }
        if (type == 'artist') {
            url = base_url + slug.main + "/" + encodeURIComponent(artist);
        }
        if (type == 'playlist') {
            url = base_url + slug.playlist + "/" + encodeURIComponent(name) + "-" + idplaylist;
        }
        if (url) {
            $("#modal-share input").attr("data-url", url);
            $("#modal-share .modal-title span").text(title + " - " + subtitle);
            $("#modal-share").modal("show");
            if ($('#autoplay').is(":checked")) {
                url = url + "?play=1";
            }
            $("#modal-share input").val(url);
            setTimeout(function() {
                $("#modal-share input").select();
            }, 500);
        } else {
            alert("a");
        }
    });
    $('#autoplay').change(function() {
        var url = $("#modal-share input").attr("data-url");
        if ($(this).is(":checked")) {
            url = url + "?play=1";
        }
        $("#modal-share input").val(url);
    });
    $(document).on(listen_click, '.btn-search', function(event) {
        event.preventDefault();
        var artist = $(this).attr("data-artist");
        var track = $(this).attr("data-track");
        if (artist && track) {
            app.search(artist + " " + track);
        }
    });
    $(document).on(listen_click, '.btn-share-link', function(event) {
        event.preventDefault();
        var url = $(this).attr("href");
        var share = $("#modal-share input").val();
        url = url.replace("{url}", encodeURIComponent(share));
        PopupCenter(url, "share", 500, 350);
        return false;
    });
    /* $(document).on(listen_click, '.btn-play-all', function(event) {        
         event.preventDefault();   
         if(player.playlist.length  == 0)      
         {
             player.clearPlaylist();
             $(".btn-play:first").trigger(listen_click);;     
             var _els = $(".btn-add-to-playlist").trigger(listen_click);
           return false;
         }

         bootbox.dialog({
           message: lang.message_play_all,
           title: lang.title_play_all,
           buttons: {
             append: {
               label: lang.label_add_to_queue,
               className: "btn-default",
               callback: function() {
                 var _els = $(".btn-add-to-playlist").trigger(listen_click);
               }
             },            
             appendp: {
               label: lang.label_add_to_queue_and_play,
               className: "btn-success",
               callback: function() {                                
                 $(".btn-play:first").trigger(listen_click);;     
                 var _els = $(".btn-add-to-playlist").trigger(listen_click);
               }
             },
             main: {
               label: lang.label_clean_queue_and_play,
               className: "btn-danger",
               callback: function() {
                 player.clearPlaylist();
                 $(".btn-play:first").trigger(listen_click);;     
                 var _els = $(".btn-add-to-playlist").trigger(listen_click);
               }
             }

            
           }
         });       
         
     });  */
    $(document).on(listen_click, '.btn-play-all', function(event) {
        event.preventDefault();
        player.clearPlaylist();
        $(".btn-play:first").trigger(listen_click);;
        var _els = $(".btn-add-to-playlist").trigger(listen_click);
    });
    $(document).on(listen_click, '.btn-play-append', function(event) {
        event.preventDefault();
        //$(".btn-play:first").trigger(listen_click);;
        var _els = $(".btn-add-to-playlist").trigger(listen_click);
        $(".btn-play:first").trigger(listen_click);;
    });
    $(document).on(listen_click, '.btn-play-add', function(event) {
        event.preventDefault();
        var _els = $(".btn-add-to-playlist").trigger(listen_click);
    });
    $(document).on(listen_click, '#jp_poster', function(event) {
        event.preventDefault();
        //$("#c-album .btn-add-to-playlist")     
        console.log(player.current);
        if (player.current.type == 'station') {
            url_track = base_url + slug.station + "/-/" + encodeURIComponent(player.current.track) + "-" + player.current.stationID;
            set_page(url_track);
        }
    });
    $(document).on(listen_click, '.btn-clear-playlist', function(event) {
        event.preventDefault();
        bootbox.dialog({
            message: lang.label_message_clear_queue,
            title: lang.label_clear_playlist,
            buttons: {
                cancel: {
                    label: lang.label_no,
                    className: "btn-default",
                    callback: function() {
                        console.log("no");
                    }
                },
                success: {
                    label: lang.label_yes,
                    className: "btn-danger",
                    callback: function() {
                        player.clearPlaylist();
                    }
                }
            }
        });
    });
    $(document).on(listen_click, '.btn-show-video', function(event) {
        event.preventDefault();
        $("body").toggleClass('show-video');
        if ($(this).hasClass('active')) {
            localStorage.setItem('status_video', 0);
        } else {
            localStorage.setItem('status_video', 1);
        }
        $(this).toggleClass('active text-success');
    });
    if (localStorage.getItem('status_video') == '0') {
        console.log("Coultar video");
        $(".btn-show-video").trigger(listen_click);
    }
    $(document).on(listen_click, '.btn-shuffle', function(event) {
        event.preventDefault();
        $(this).toggleClass('active text-success');
    });
    $(document).on(listen_click, '.btn-open-menu,.btn-menu-music', function(event) {
        event.preventDefault();
        $(this).trigger("contextmenu", event);
    });
    $(document).on(listen_click, '.btn-like', function(event) {
        event.preventDefault();
        var _this = $(this);
        $(this).removeClass("btn-like");
        $("i", _this).removeClass("zmdi");
        $("i", _this).removeClass("zmdi-favorite");
        $("i", _this).addClass("fa");
        $("i", _this).addClass("fa-circle-o-notch");
        $("i", _this).addClass("fa-spin");
        var iduser = _this.attr("data-iduser");
        var idtarget = _this.attr("data-idtarget");
        var type = _this.attr("data-type");
        var unlike = _this.attr("data-unlike");
        if (!unlike) unlike = 0;
        var url = base_url + "backend/like";
        $.post(url, {
            iduser: iduser,
            idtarget: idtarget,
            type: type,
            unlike: unlike
        }, function(data, textStatus, xhr) {
            _this.parent().append(data.button);
            _this.remove();
            gui.get_like_button($(".target-like").attr("data-id"));
        }, "json");
    });
    $(document).on(listen_click, '.link', function(event) {
        event.preventDefault();
        location.href = $(this).attr("data-href");
    });
    $(document).on(listen_click, '.btn-link', function(event) {
        event.preventDefault();
        if (window.self !== window.top) {
            window.top.location.href = $(this).attr("data-href");
        } else {
            set_page($(this).attr("data-href"));
        }
    });
    $(document).on(listen_click, '.btn-add-to', function(event) {
        event.preventDefault();
        gui.refresh_playlist();
        $("#playlist-menu").addClass("show");
    });
    $(document).on(listen_click, '.btn-playlist-menu-hide', function(event) {
        event.preventDefault();
        $("#playlist-menu").removeClass("show");
    });
    $(document).on(listen_click, '.btn-to-favorite', function(event) {
        event.preventDefault();
        var id = $(this).attr("data-id");
        if (!id) {
            alert("NO hay ID en favoritos");
            return false;
        }
        var type = $(this).attr("data-type");
        var url = base_url + "backend/like2";
        $.post(url, {
            id: id,
            type: type
        }, function(data, textStatus, xhr) {
            gui.noty(data.title, data.subtitle, data.image);
            gui.get_like_button($(".target-like").attr("data-id"));
        }, "json");
    });
    $(document).on(listen_click, '.btn-save-playlist', function(event) {
        event.preventDefault();
        var name = $("#input-name-playlist").val();
        if (jQuery.trim(name) != '') {
            gui.save_playlist(name);
        }
    });
    $(document).on(listen_click, '.btn-new-playlist', function(event) {
        event.preventDefault();
        $("#modal-create-playlist").modal("show");
        setTimeout(function() {
            $("#modal-create-playlist input").focus();
        }, 500);
    });
    $(document).on(listen_click, '.btn-edit-playlist', function(event) {
        event.preventDefault();
        var image = $(this).attr("data-image");
        var name = $(this).attr("data-name");
        var idplaylist = $(this).attr("data-idplaylist");
        $("#modal-edit-playlist img").attr("src", image);
        $("#modal-edit-playlist input[name=name]").val(name);
        $("#modal-edit-playlist input[name=idplaylist]").val(idplaylist);
        $("#modal-edit-playlist").modal("show");
    });
    $(document).on(listen_click, '.btn-save-to-playlist', function(event) {
        event.preventDefault();
        var idplaylist = $(this).attr("data-idplaylist");
        var artist = $(this).attr("data-artist");
        var track = $(this).attr("data-track");
        var album = $(this).attr("data-album");
        var image = $(this).attr("data-image");
        var id = $(this).attr("data-id");
        gui.add2_playlist(idplaylist, artist, track, album, image, id);
    });
    $(document).on(listen_click, '.btn-remove-from-playlist', function(event) {
        event.preventDefault();
        var idplaylist = $(this).attr("data-idplaylist");
        var artist = $(this).attr("data-artist");
        var track = $(this).attr("data-track");
        var album = $(this).attr("data-album");
        var image = $(this).attr("data-image");
        var id = $(this).attr("data-id");
        gui.remove_from_playlist(idplaylist, artist, track, album, image, id);
    });
    $(document).on(listen_click, '.btn-remove-playlist', function(event) {
        event.preventDefault();
        var idplaylist = $(this).attr("data-idplaylist");
        gui.remove_playlist(idplaylist);
    });
    /*$('#modal-create-playlist').on('hidden.bs.modal', function () {
        app.save2pl.artist        = '';
        app.save2pl.track         = '';
        app.save2pl.album         = '';
        app.save2pl.image         = '';
    })*/
    $(document).on(listen_click, '.btn-upload-avatar', function(event) {
        event.preventDefault();
        $("#ImageBrowse").trigger('click');
    });
    $(document).on("change", '#ImageBrowse', function(event) {
        event.preventDefault();
        console.log("change");
        $("#imageUploadForm").submit();
    });
    $(document).on(listen_click, '.btn-start-discover', function(event) {
        var artist = $(this).attr("data-artist");
        app.play_radio(artist, 1);
    });
    $(document).on(listen_click, '#radio', function(event) {
        bootbox.dialog({
            message: lang.label_close_radio,
            title: lang.label_discover_mode,
            buttons: {
                yes: {
                    label: lang.label_yes,
                    className: "btn-danger",
                    callback: function() {
                        $("#radio").removeClass('show');
                    }
                }
            }
        });
    });
    $(document).on("submit", '#imageUploadForm', function(event) {
        event.preventDefault();
        loading();
        console.log("ssss");
        $.ajax({
            url: base_url + 'upload_avatar',
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            dataType: "json",
            processData: false,
            success: function(data) {
                if (!data.error) $(".me-avatar").attr("src", data.avatar);
                else alert(data.error);
                set_page(location.pathname);
                current_page = '';
            },
            error: function() {
                load_page(location.pathname);
                current_page = '';
            }
        });
        return false;
    });
    /*$(".input-search").on('click', function(event) {
      event.preventDefault();
      $(this).select();
    });*/
    $(".input-search").focus(function() {
        $("#last-search").addClass("show");
    });
    $(".input-search").focusout(function() {
        setTimeout(function() {
            $("#last-search").removeClass("show");
        }, 300);
    });
    $(".input-search").keyup(function(e) {
        var str = $(this).val();
        if (str.length <= 1) return false;
        delay(function() {
            app.search(str);
        }, 1000);
    });
    $(".input-search").keypress(function(e) {
        var _this = $(this);
        if (e.which == 13) {
            var str = $(this).val();
            if (str.length <= 2) return false;
            app.search(str);
            setTimeout(function() {
                _this.val("");
            }, 100);
        }
    });
    $("#modal-create-playlist input").keypress(function(e) {
        if (e.which == 13) {
            if ($(this).val() != '') $(".btn-save-playlist").trigger(listen_click);
        }
    });
    // Upload Cover
    $(document).on(listen_click, '.btn-upload-cover-playlist', function(event) {
        event.preventDefault();
        $("#ImageBrowseCover").trigger(listen_click);
    });
    $(document).on("submit", '#imageUploadFormCover', function(event) {
        event.preventDefault();
        loading();
        $("#modal-edit-playlist").modal("hide");
        console.log("ssss");
        $.ajax({
            url: base_url + 'backend/update_playlist',
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            dataType: "json",
            processData: false,
            success: function(data) {
                if (!data.error) {
                    current_page = '';
                    set_page(data.url);
                    current_page = '';
                } else alert(data.error);
                loading("hide");
            },
            error: function() {
                load_page(location.pathname);
                loading("hide");
            }
        });
        return false;
    });
    // End Upload Cover
    $(document).on(listen_touch, '.btn-play', function(event) {
        event.preventDefault();        
        var artist = $(this).attr("data-artist");
        var track = $(this).attr("data-track");
        var album = $(this).attr("data-album");
        var image = $(this).attr("data-image");
        var index = $(this).attr("data-index");
        var isPlaylist = $(this).attr("data-isPlaylist");
        var type = $(this).attr("data-type");
        var id = $(this).attr("data-id");
        if (!type) type = 'track';
        player.type = type;
        $('table tr.track-' + id).addClass("active");
        if (type == 'station') {
            var stationID = $(this).attr("data-stationid");
            track = $(this).attr("data-name");
            if (!track) track = $(this).attr("data-track");
            artist = '-';
            album = '-';
        }

        if (artist && track) {
            console.log("PLAYYYY1");

            if (player.status.paused) {

                console.log("PLAYYYY2");
                if (player.current.artist == artist && player.current.track == track) {
                    if (is_youtube) {
                        console.log("Play YT");
                        yt_player_1.playVideo();
                    } else {
                        console.log("PLAYYYY");
                        player.player.jPlayer("play");
                    }
                    return true;
                }
            }
            player.play(artist, track, image, album, isPlaylist, type, stationID, id);
            return false;
        }
    });
    $(document).on(listen_click, '.btn-pause', function(event) {
        event.preventDefault();
        if (!is_youtube) player.player.jPlayer("pause");
        else yt_player_1.pauseVideo();
    });
    $(document).on('keyup', '.filter input', function(event) {
        event.preventDefault();
        var filter = $(this).val();
        var list = $(".list-music");
        if (filter) {
            $("li.li", list).addClass("hide");
            $("li.li:Contains(" + filter + ")", $(list)).removeClass("hide");
        } else {
            $("li.li", list).removeClass("hide");
        }
    });
    $(document).on('keyup', '.filter-generic input', function(event) {
        event.preventDefault();
        var filter = $(this).val();
        var list = $(".container-fluid");
        if (filter) {
            $(".filter-me", list).addClass("hide");
            $(".filter-me:Contains(" + filter + ")", $(list)).removeClass("hide");
        } else {
            $(".filter-me", list).removeClass("hide");
        }
    });
    // Creamos la pseudo-funcion Contains
    jQuery.expr[":"].Contains = jQuery.expr.createPseudo(function(arg) {
        return function(elem) {
            return jQuery(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
        };
    });
    $(document).on(listen_touch, '.menu-toggle', function(event) {
        event.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    $(document).on(listen_click, '.btn-more-data', function(event) {
        event.preventDefault();
        $($(this).attr("data-target")).removeClass("more");
        $(this).remove();
        //$(this).parent().scroll(); // Fix bug lazy scroll
    });
    $(document).on(listen_click, '.tabs li', function(event) {
        event.preventDefault();
        var _target = $(this).attr("data-href");
        $(".tab.active").removeClass("active");
        $(".tabs li.active").removeClass("active");
        $(this).addClass("active");
        $(_target).addClass("active");
        $(_target).scroll(); // Fix bug lazy scroll
    });
    $(document).on(listen_click, '.tabs-ajax li', function(event) {
        event.preventDefault();
        var _target = $(this).attr("data-href");
        var _method = $(this).attr("data-method");
        if (!_method || !_target) return false;
        $(".tabs-ajax li.active").removeClass("active");
        $(this).addClass("active");
        url = base_url + "backend/" + _method;
        $(_target).empty();
        loading();
        $.get(url, function(data) {
            $(_target).html(data);
            loading("hide");
            $(document).trigger("page-loaded");
        });
    });
    $(document).on(listen_click, '.link-tab', function(event) {
        event.preventDefault();
        var _target = $(this).attr("data-href");
        $('.tabs li[data-href="' + _target + '"]').trigger(listen_click);
    });
    $(document).on(listen_click, '.btn-remove-item', function(event) {
        event.preventDefault();
        player.deltrack($(this).attr("data-index"));
    });
    $(document).on(listen_click, '.btn-now-playing2', function(event) {
        event.preventDefault();
        if ($(this).hasClass('active')) {
            load_page(location.pathname);
        } else {
            $(".btn-now-playing").trigger(listen_click);
        }
        $(this).toggleClass('active text-success');
    });
    $(document).on(listen_click, '.btn-lyric, .btn-track', function(event) {
        event.preventDefault();
        var url = base_url + slug.main + "/" + player.current.artist + "/" + player.current.album + "/" + player.current.track;
        if (player.current.type == 'station') {
            var url = base_url + "?s=" + $(".jp-artist").text() + " " + $(".jp-title").text();
        }
        set_page(url);
    });
    $(document).on(listen_click, '.btn-artist', function(event) {
        event.preventDefault();
        var url = base_url + slug.main + "/" + player.current.artist;
        if (player.current.type == 'station') return false;
        set_page(url);
    });
    $(document).on(listen_click, '.btn-now-playing', function(event) {
        event.preventDefault();
        app.last_search = '';
        current_page = '';
        $("#wrapper").removeClass("toggled");
        $("#wrapper").removeClass("player-active");
        $("#main .c-m").empty();
        if (player.playlist.length == 0) {
            $("#main .c-m").append("<div class='error'> \
                              <h1 style='font-size:90px'><i class='zmdi zmdi-collection-music'></i></h1> \
                              <h2>" + lang.label_library_empty + "</h2> \
                              <p>" + lang.label_library_empty_description + "</p> \
                          </div>")
            return false;
        }
        var _ul = $("<table class='table table-hover now-playing'></table>");
        _ul.append('<thead> \
                    <tr> \
                      <th class="control"></th>  \
                      <th class="track title">' + lang.label_track + '</th> \
                      <th class="artist title">' + lang.label_artist + '</th> \
                      <th class="album title">' + lang.label_album + '</th> \
                      </tr> \
                    </thead> \
                  <tbody>');
        $("#main .c-m").append("<div class='pd' style='padding:20px'></div>");
        $.each(player.playlist, function(index, val) {            
            if (val.track) {
                if ($('tr[data-id="' + val.id + '"]', _ul).length) {
                    player.deltrack(index);
                } else {
                    var url_track = base_url + slug.main + "/" + encodeURIComponent(val.artist) + "/" + encodeURIComponent(val.album) + '/' + encodeURIComponent(val.track);
                    var url_artist = base_url + slug.main + "/" + encodeURIComponent(val.artist);
                    var url_album = base_url + slug.main + "/" + encodeURIComponent(val.artist) + "/" + encodeURIComponent(val.album);
                    if (val.type == 'station') {
                        console.log(val);
                        val.id = val.stationID;
                        val.artist = lang.label_station;
                        url_artist = "#";
                        url_track = base_url + slug.station + "/-/" + encodeURIComponent(val.track) + "-" + val.stationID;
                    }
                    if (val.type == 'audio') {
                        val.type = 'track;'
                    }
                    if (val.artist == '-' || val.artist == '') {
                        url_artist = "#";
                    }
                    if (val.album == '-' || val.album == '') {
                        url_album = "#";
                    }
                    if (val.track == '-' || val.track == '') {
                        url_track = "#";
                    }
                    _ul.append('<tr  class="filter-me contextMenu track-' + val.id + '" data-index="' + index + '" data-track="' + val.track + '" data-id="' + val.id + '" data-subtitle="' + val.track + '" data-title="' + val.artist + '" data-artist="' + val.artist + '" data-album="' + val.album + '" data-image="' + val.image + '" data-type="' + val.type + '" data-stationid="' + val.stationID + '"> \
                          <td class="control title"> \
                              <i class="zmdi btn-play  zmdi-play-circle-outline" data-isPlaylist="true" data-id="' + val.id + '" data-index="' + index + '" data-track="' + val.track + '" data-album="' + val.album + '" data-artist="' + val.artist + '" data-image="' + val.image + '" data-type="' + val.type + '" data-stationid="' + val.stationID + '"></i> \
                              <i class="zmdi btn-pause  zmdi-pause-circle-outline" data-isPlaylist="true" data-id="' + val.id + '" data-index="' + index + '" data-track="' + val.track + '" data-album="' + val.album + '" data-artist="' + val.artist + '" data-image="' + val.image + '" data-type="' + val.type + '" data-stationid="' + val.stationID + '"></i> \
                              <i class="zmdi contextMenu no-close btn-open-menu zmdi-plus" data-isPlaylist="true" data-id="' + val.id + '" data-index="' + index + '" data-track="' + val.track + '" data-album="' + val.album + '" data-artist="' + val.artist + '" data-image="' + val.image + '" data-type="' + val.type + '" data-stationid="' + val.stationID + '"></i>\
                          </td> \
                          <td class="track title" data-id="' + val.id + '" data-index="' + index + '" data-track="' + val.track + '" data-artist="' + val.artist + '" data-album="' + val.album + '" data-image="' + val.image + '" data-type="' + val.type + '" data-stationid="' + val.stationID + '"><a href="' + url_track + '" data-type="' + val.type + '" data-stationid="' + val.stationID + '">' + val.track + '</a></td> \
                          <td class="artist title" data-id="' + val.id + '" data-index="' + index + '" data-track="' + val.track + '" data-artist="' + val.artist + '" data-album="' + val.album + '" data-image="' + val.image + '" data-type="' + val.type + '" data-stationid="' + val.stationID + '" ><a href="' + url_artist + '" data-type="' + val.type + '" data-stationid="' + val.stationID + '">' + val.artist + '</a></td> \
                          <td class="album title" data-id="' + val.id + '" data-index="' + index + '" data-track="' + val.track + '" data-artist="' + val.artist + '" data-album="' + val.album + '" data-image="' + val.image + '" data-type="' + val.type + '" data-stationid="' + val.stationID + '"> \
                            <a href="' + url_album + '" data-id="' + val.id + '" data-type="' + val.type + '" data-stationid="' + val.stationID + '">' + val.album + '</a> \
                             <div class="trg btn-group" > \
                              <i class="cursor-pointer zmdi btn-remove-item  zmdi-close" data-isPlaylist="true" data-id="' + val.id + '" data-index="' + index + '" data-track="' + val.track + '" data-album="' + val.album + '" data-artist="' + val.artist + '" data-image="' + val.image + '" data-type="' + val.type + '" data-stationid="' + val.stationID + '"></i> \
                            </div> \
                            </td> \
                      </tr>');
                    $("#main .c-m div.pd").append(_ul);
                }
            }
        });
        $("#main .c-m div.pd").prepend('<br><br><div class="col-md-8"> \
                                      <a class="btn btn-danger btn-clear-playlist"><i class="zmdi zmdi-delete"></i> ' + lang.label_clear_playlist + '</a> \
                                    </div> \
                                  <div class="col-md-4 filter-generic"> \
                                    <input type="search"  class="form-control" placeholder="' + lang.label_filter + '"> \
                                  </div><div class="clearfix"></div><br><br>');
        contextMenu_init();
    });
    $(document).on(listen_click, '.btn-current', function(event) {
        event.preventDefault();
        $("#jp-float").toggleClass("show");
    });
    $(document).on(listen_click, '.jp-next', function(event) {
        event.preventDefault();
        player.playNext();
    });
    $(document).on(listen_click, '.jp-previous', function(event) {
        event.preventDefault();
        player.playPrevious();
    });
    $(document).on(listen_click, '.btn-player', function(event) {
        event.preventDefault();
        $("#wrapper").toggleClass("player-active");
        $("#wrapper").removeClass("toggled");
    });
    $(document).on(listen_touch, '.overlay', function(event) {
        event.preventDefault();
        $("#wrapper").removeClass("toggled");
        $("#wrapper").removeClass("player-active");
    });
    $(document).on(listen_click, '.player .header', function(event) {
        event.preventDefault();
        $("#wrapper").removeClass("player-active");
    });
    $(document).on(listen_click, '.sidebar-nav li', function(event) {
        event.preventDefault();
        $(".sidebar-nav li").removeClass('active');
        $(this).addClass('active');
    });
    $(document).on(listen_touch, '.btn-menu-music', function(event) {
        //  event.preventDefault();
        if (!$(this).attr("data-title") || !$(this).attr("data-subtitle")) return;
        $("#menu-music h2").text($(this).attr("data-title"));
        $("#menu-music h3").text($(this).attr("data-subtitle"));
        $("#menu-music .btn-play,#menu-music a").attr("data-track", $(this).attr("data-track"));
        $("#menu-music .btn-play,#menu-music a").attr("data-artist", $(this).attr("data-artist"));
        $("#menu-music .btn-play,#menu-music a").attr("data-image", $(this).attr("data-image"));
        $("#menu-music .btn-play,#menu-music a").attr("data-album", $(this).attr("data-album"));
        $("#menu-music .btn-play,#menu-music a").attr("data-type", $(this).attr("data-type"));
        $("#menu-music .btn-play,#menu-music a").attr("data-id", $(this).attr("data-id"));
        $("#menu-music .list-group a").addClass("hide");
        $("#menu-music .only-" + $(this).attr("data-type")).removeClass("hide");
        $("#menu-music .only-all").removeClass("hide");
        $("#menu-music .image").css('background-image', 'url(' + $(this).attr("data-image") + ')');
        app.save2pl.artist = $(this).attr("data-artist");
        app.save2pl.track = $(this).attr("data-track");
        app.save2pl.album = $(this).attr("data-album");
        app.save2pl.image = $(this).attr("data-image");
        app.save2pl.id = $(this).attr("data-id");
        $("#menu-music").addClass("show center");
    });
    $(document).on(listen_click, "a", function(e) {
        var _target = $(this).attr("href");
        _log(_target);
        if (!_target) return false;
        if (!$(this).hasClass('exclude')) {
            if (_target.indexOf("#") < 0) {
                set_page(_target);
                e.preventDefault();
            } else {
                e.preventDefault();
            }
        } else {
            if (!$(this).hasClass('external')) {
                document.location = _target;
            }
        }
    });
    $(window).scroll(function() {
        var y = $(window).scrollTop();
        if (temp_title == '') {
            temp_title = $(".navbar-title").text();
            console.log(temp_title);
        }
        if (y > 200) {
            if ($(".float-title span.t").length) {
                $(".navbar-title").text($(".float-title span.t").text());
            }
        } else {
            $(".navbar-title").text(temp_title);
        }
    });
    window.addEventListener("popstate", function(e) {
        //if(!first_time_load)     
        load_page(location.href);
        //first_time_load = false;
    });
});

function updateUser(form, m) {
    loading();
    $("#error-div").empty();
    var url = base_url + "backend/updateUser?m=" + m;
    $.post(url, $(form).serialize(), function(data, textStatus, xhr) {
        if (data.error) $("#error-div").html("<div class='alert alert-warning'>" + data.error + "</div>");
        if (data.success) $("#error-div").html("<div class='alert alert-success'>" + data.success + "</div>");
        else {
            if (data.profile) {
                location.href = data.profile;
                current_page = '';
            }
        }
        loading("hide");
    }, "json");
    return false;
}

function hhmmss(secs) {
    var sec_num = parseInt(secs, 10); // don't forget the second parm
    var hours = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);
    if (hours < 10) {
        hours = "0" + hours;
    }
    if (minutes < 10) {
        minutes = "0" + minutes;
    }
    if (seconds < 10) {
        seconds = "0" + seconds;
    }
    //var time    = hours+':'+minutes+':'+seconds;
    var time = minutes + ':' + seconds;
    return time;
}

function set_page(page) {
    app.last_search = '';
    history.pushState(null, null, page);
    load_page(page);
}
var hxr_load = false;
var current_page = '';

function load_page(page, secondTry) {
    if (hxr_load) hxr_load.abort()
    if (current_page == page) return false;
    current_page = page;
    loading();
    _log("Loading Page => " + page);
    $("html, body").scrollTop(0);
    /*  hxr_load = $.get(page, function(data) {
          $("#main .c-m").empty();      
          $("#main .c-m").html(data);      
          loading("hide");
          $( document ).trigger( "page-loaded");
          $("#wrapper").removeClass("toggled");
          $("#main").scrollTop(0);
      }).fail(function() {
          _log("Error 404 => " + page);  
          loading("hide");
      });*/
    if (settings.ga) {
        console.log("ga");
        _gaq.push(['_trackPageview', page]);
    }
    ads_restart();
    hxr_load = $.ajax({
        url: page,
        success: function(data) {
            $("#main .c-m").empty();
            $("#main .c-m").html(data);
            loading("hide");
            $(document).trigger("page-loaded");
            $("#wrapper").removeClass("toggled");
            $("#main").scrollTop(0);
        },
        error: function() {
            _log("Error 404 => " + page);
            loading("hide");
            if (!secondTry) {
                current_page = '';
                load_page(page, true);
            }
        },
        timeout: 15000 //in milliseconds
    });
}

function ads_restart() {
    try {
        $(".adsbygoogle").html("");
        adsbygoogle = false;
        window.adsbygoogle = false;
        window.google_unique_id = false;
        window.google_ad_modifications = false;
        window.google_adk2_experiment = false;
        window.google_async_config = false;
        window.google_correlator = false;
        window.google_dre = false;
        window.google_exp_persistent = false;
        window.google_global_correlator = false;
        window.google_iframe_oncopy = false;
        window.google_jobrunner = false;
        window.google_mc2_survey_registry = false;
        window.google_num_0ad_slots = false;
        window.google_ad_modifications = false;
        window.google_num_ad_slots = false;
        window.google_num_reactive_ad_slots = false;
        window.google_num_sdo_slots = false;
        window.google_num_slot_to_show = false;
        window.google_num_slots_by_channel = false;
        window.google_onload_fired = false;
        window.google_persistent_state = false;
        window.google_persistent_state_async = false;
        window.google_reactive_ads_global_state = false;
        window.google_pubvars_reuse_experiment = false;
        window.google_prev_ad_slotnames_by_region = false;
        window.google_prev_ad_formats_by_region = false;
        window.google_predictive_sra_request_sent = false;
        $(".adsbygoogle").remove();
    } catch (e) {}
}

function _log(str) {
    console.log(str);
}

function loading(hide) {
    if (hide) {
        $("#loading-overlay").addClass("hide");
        $("#loading").addClass("hide");
    } else {
        $("#loading-overlay").removeClass("hide");
        $("#loading").removeClass("hide");
    }
}
/* APP */
errors_radio = 0;
app.play_radio = function(artist, start) {
    if (!artist || artist == '-') {
        $("#radio").removeClass('show');
        return false;
    }
    if (!start) start = 0;
    $("#radio .loading").addClass('show');
    var _radio = $("#radio");
    contextMenu_init();
    _radio.addClass("show");
    url = base_url + "backend/radio";
    $.post(url, {
        a: "get_track",
        artist: artist,
        start: start
    }, function(data, textStatus, xhr) {
        if (data == undefined || data.artist == null || data.artist == 'null' && errors_radio<=5) {
            console.log("Radio return NULL Tring again...");
            errors_radio++;
            app.play_radio(artist);
        } else {
            //_radio.css("background-image", "url('"+data.image+"')");  
            player.play(data.artist, data.track, data.image, data.album, false, 'track', false, data.id);
            $("#radio .loading").removeClass('show');
            _radio.attr("data-artist", data.artist);
            _radio.attr("data-image", data.image);
            _radio.attr("data-track", data.track);
            _radio.attr("data-id", data.id);
            _radio.attr("data-type", "track");
            errors_radio = 0;
        }
        if(errors_radio>=5)
        {
             $("#radio").removeClass('show');
        }
    }, "json");
}
app.search = function(str) {
    if (app.last_search != str) {
        set_page(base_url + "?s=" + str);
        app.last_search = str;
        app.save_search(str);
    }
}
app.save_search = function(str) {
    var item = str;
    if (!app.lastest_searches) {
        app.lastest_searches = [];
    }
    $.each(app.lastest_searches, function(index, val) {
        console.log(index);
        if (val) {
            if (val.str == str || index > 3) {
                app.lastest_searches.remove(index);
            }
        }
    });
    app.lastest_searches.unshift(item);
    localStorage.setItem('last_search', JSON.stringify(app.lastest_searches));
    app.render_search();
}
app.render_search = function() {
        var last_search = localStorage.getItem('last_search');
        if (last_search != '') {
            var data = JSON.parse(last_search);
            app.lastest_searches = data;
        }
        if (!app.lastest_searches) return false;
        $("#last-search span").html("");
        $.each(app.lastest_searches, function(index, val) {
            var elm = '<li class="main truncate"> \
                <a class="truncate" href="' + base_url + '?s=' + val.str + '"><i class="zmdi zmdi-search-for"></i> ' + val.str + '</a> \
              </li>';
            $("#last-search span").append(elm);
        });
    }
    /* Player */
Array.prototype.remove = function(index) {
    this.splice(index, 1);
}
player.addtrack = function(artist, track, album, image, type, stationID, id) {
    if (!type) {
        console.log("error jodacame type");
        return false;
    }
    // NO Duplicated
    var duplicated = false;
    $.each(player.playlist, function(index, val) {
        //console.log(val.track );
        if (val.id == id) {
            duplicated = true;
            return false;
        }
    });
    if (duplicated) return false;
    var item = {
        artist: artist,
        track: track,
        album: album,
        image: image,
        type: type,
        stationID: stationID,
        id: id
    };
    player.playlist.push(item);
    app.cache_playlist();
    if ($(".btn-now-playing").hasClass('active')) $(".btn-now-playing").trigger(listen_click);
    gui.noty(track, lang.label_added, image);
    $("#count-now-playing").addClass("animation").delay(300).queue(function() {
        $(this).removeClass("animation").dequeue();
    });
}
app.cache_playlist = function() {
    try {
        $("#count-now-playing").text(player.playlist.length);
        localStorage.setItem('playing_now', JSON.stringify(player.playlist));
    } catch (e) {}
}
player.deltrack = function(index) {
    console.log(index);
    console.log(player.playlist[index]);
    player.playlist.remove(index);
    app.cache_playlist();
    if ($(".btn-now-playing").hasClass('active')) $(".btn-now-playing").trigger(listen_click);
}
player.clearPlaylist = function() {
    player.playlist = [];
    if ($(".btn-now-playing").hasClass('active')) $(".btn-now-playing").trigger(listen_click);
    app.cache_playlist();
}
player.set_media = function(artist, track, image, album, isPlaylist, type, stationID, id) {
    $(".loading-streaming").removeClass('hide');
    player.type = type;
    /*$(".jp-title").text(track);
    $(".jp-artist").text(artist);
    $("#jp_poster").attr("src",image);*/


    var url = base_url + "streaming/index?artist=" + artist + "&track=" + track + "&type=" + type + "&stationID=" + stationID;

    
    var stream_yt = false;
    $.post(url, false,function(stream) {
        // POST
        
             

        $(".player-c").css("background-image","url("+image+")");

        if (stream.source == 'youtube' && player.type != 'station') {
            stream_yt = true;
            try {
                player.player.jPlayer("stop");
            } catch (e) {}
            $(".btn-show-video").removeClass('hide');
            $(".player-c").removeClass('hide');
            
            loadVideo(stream.id);
        } else {
            $(".player-c").addClass('hide');
            if (stream.stream) {
                $(".btn-show-video").addClass('hide');
                if ($(".btn-show-video").hasClass('text-success')) $(".btn-show-video").trigger(listen_click);
                if (is_youtube) stopYoutube();
                player.player.jPlayer("setMedia", {
                    title: track,
                    artist: artist,
                    mp3: stream.stream,
                    webm: stream.stream,
                    m4a: stream.stream,
                    poster: image
                }).jPlayer("play");
                $(".jp-title").text(track);
                $(".jp-artist").text(artist);
                $("#jp_poster").attr("src", image);
            }
        }
        if (player.type != 'station') {
            player.set_history(artist, album, track, image, id);
            $(".info-source").html('<i title="Powered by ' + stream.source + '" class="fa fa-' + stream.source + '"></i>');
        } else $(".info-source").html('<i class="zmdi zmdi-portable-wifi"></i>');
        player.current = {
            artist: artist,
            track: track,
            image: image,
            album: album,
            type: type,
            stationID: stationID,
            id: id,
            source: stream.source
        };
        if (player.type != 'track') $("#radio").removeClass('show');
        if (player.type == 'station') player.station.get_info();
        gui.get_like_button(id);
        $(".loading-streaming").addClass('hide');
        if (!stream.stream && stream.source != 'youtube' && player.type != 'station') {
            console.info("Stream no found!");
            setTimeout(function() {
                player.playNext();
            }, 2000);
        }
        // END POST
    }, "json");

    
    yt_player_1.playVideo();
}
player.play = function(artist, track, image, album, isPlaylist, type, stationID, id) {
    if (type == 'station') id = stationID;
    if (!type) type = 'track';
    if (!isPlaylist) player.addtrack(artist, track, album, image, type, stationID, id);

    player.set_media(artist, track, image, album, isPlaylist, type, stationID, id);
}
player.playNext = function() {
    if ($("#radio").hasClass('show')) {
        console.log("Radio - " + player.current.artist);
        app.play_radio(player.current.artist);
        return false;
    }
    var next = player.get_next();
    if (!next) {
        $(".loading-streaming").removeClass('hide');
        return false;
    }
    //player.current = next;
    //player.type = next.type;
    /*$(".jp-title").text(next.track);
    $(".jp-artist").text(next.artist);
    $("#jp_poster").attr("src",next.image);
    var mp3 = base_url+"streaming/index?artist="+next.artist+"&track="+next.track+"&type="+next.type+"&stationID="+next.stationID;

    if(is_youtube && player.type != 'station')
    {
      $("#jp_poster").attr("src",next.image);
      $.getJSON(mp3+"&y=1", false, function(data, textStatus, xhr) {
        loadVideo(data.id);
        player.set_history(next.artist,next.album,next.track,next.image,next.id);
      });   
      
    }
    else
    {

       if(is_youtube)
         stopYoutube();

      player.player.jPlayer("setMedia", {
        m4a: mp3,
        title:next.track,      
        artist:next.artist,      
        poster:next.image
      }).jPlayer("play");
    }
    if(player.type == 'station')
      player.station.get_info();

    gui.get_like_button(next.id);
    console.log("Play Next");*/
    console.log("Next");
    console.log(next);
    player.set_media(next.artist, next.track, next.image, next.album, false, next.type, next.stationID, next.id);
    // player.set_media(artist,track,image,album,isPlaylist,type,stationID,id);
}
player.playPrevious = function() {
    /* $(".loading-streaming").removeClass('hide');
     var previous = player.get_previous(); 
     if(!previous)
       return false;
     player.current = previous;
     player.type = previous.type;
     $(".jp-title").text(previous.track);
     $(".jp-artist").text(previous.artist);
     $("#jp_poster").attr("src",previous.image);
     var mp3 = base_url+"streaming/index?artist="+previous.artist+"&track="+previous.track+"&type="+previous.type+"&stationID="+previous.stationID;
     if(is_youtube &&  player.type != 'station')
     {
       $("#jp_poster").attr("src",previous.image);
       $.getJSON(mp3+"&y=1", false, function(data, textStatus, xhr) {
         loadVideo(data.id);
         player.set_history(previous.artist,previous.album,previous.track,previous.image,previous.id);
       });   
       
     }
     else
     {
       if(is_youtube)
          stopYoutube();
       player.player.jPlayer("setMedia", {
         m4a: mp3,
         title:previous.track,      
         artist:previous.artist,      
         poster:previous.image
       }).jPlayer("play");
     }
     if(player.type == 'station')
       player.station.get_info();

     gui.get_like_button(previous.id);*/
    var previous = player.get_previous();
    if (!previous) return false;
    player.set_media(previous.artist, previous.track, previous.image, previous.album, false, previous.type, previous.stationID, previous.id);
    console.log("Play previous");
}
player._paused = function() {
    player.status.paused = true;
    //$('table tr[data-artist="'+player.current.artist+'"][data-track="'+player.current.track+'"]').addClass("paused");    
    $('table tr.' + player.current.id).addClass("paused");
}
player._play = function() {
    player.status.paused = false;
    $('table tr').removeClass("paused");
}
player.get_next = function() {
    var next = false;
    var i = 0;
    
    
    $.each(player.playlist, function(index, val) {
        //console.log(val.track );
        if (val.id == player.current.id) {
            i = index;
            console.log("encontrado");      
            console.log(i);      
            return false;
        }
    });
    if ($(".btn-shuffle").hasClass('active')) {
        rand = Math.floor((Math.random() * player.playlist.length) + 1);
        if (rand == i) rand = Math.floor((Math.random() * player.playlist.length) + 1);
        i = rand;
    }
    i = i + 1;
    next = player.playlist[i];
    console.log(player.playlist);
    if (!next) {
        next = player.playlist[0];
    }
    //console.log("Next ");
    //console.log(next);
    return next;
}
player.get_previous = function() {
    var previous = false;
    var i = 0;
    $.each(player.playlist, function(index, val) {
        console.log(val.track);
        if (val.id == player.current.id) {
            i = index;
            return false;
        }
    });
    i = i - 1;
    if (i < 0) i = (player.playlist.length - 1);
    previous = player.playlist[i];
    if (!previous) {
        previous = player.playlist[0];
    }
    //console.log("previous ");
    //console.log(previous);
    return previous;
}
player.update = function() {
    try {
        if (player.current.artist) {
            $('table tr').removeClass("active");
            //$('table tr[data-artist="'+player.current.artist+'"][data-track="'+player.current.track+'"][data-album="'+player.current.album+'"]').addClass("active");  
            $('table tr.track-' + player.current.id).addClass("active");
        }
    } catch (e) {}
    if (player.type == 'station') {
        if (settings.show_video == '1' && 1 == 2) {
            $(".loading-streaming").addClass('hide');
            $("#jquery_jplayer_overlay .loading").removeClass('show');
            $("body").removeClass('show-video');
        }
        $(".progress-seek").addClass('hide');
        $(".jp-duration").text("LIVE");
    } else {
        $(".progress-seek").removeClass("hide");
        if (settings.show_video == '1' && 1 == 2) {
            $("body").addClass('show-video');
        }
        try {
            $(".jp-title").text(player.current.track);
            $(".jp-artist").text(player.current.artist);
            $("#jp_poster").attr("src", player.current.image);
            $(".jp-details-current").attr("data-id", player.current.id);
            $(".jp-details-current").attr("data-artist", player.current.artist);
            $(".jp-details-current").attr("data-album", player.current.album);
            $(".jp-details-current").attr("data-track", player.current.track);
            $(".jp-details-current").attr("data-title", player.current.artist);
            $(".jp-details-current").attr("data-subtitle", player.current.track);
            $(".jp-details-current").attr("data-image", player.current.image);
        } catch (e) {}
    }
    setTimeout(function() {
        player.update();
    }, 100);
}
player.update();
player.set_history = function(artist, album, track, image, id) {
    if (!is_logged) return false;
    var url = base_url + "backend/set_history";
    $.post(url, {
        artist: artist,
        track: track,
        album: album,
        image: image,
        id: id
    }, function(data, textStatus, xhr) {});
}
player.station.get_info = function() {
    //console.log(player.current);
    var url = base_url + "streaming/get_info?id=" + player.current.stationID;
    $.getJSON(url, false, function(data, textStatus, xhr) {
        player.station.current = data;
        player.station.get_current();
    });
}
player.station.get_current = function() {
    if (player.type == 'station') {
        if (player.station.current) {
            $(".loading-streaming").removeClass('hide');
            url = base_url + "streaming/get_current";
            $.post(url, player.station.current, function(data, textStatus, xhr) {
                //console.log(data);
                $(".loading-streaming").addClass('hide');
                if ($("#station-page").length > 0) {
                    load_page(location.pathname);
                    current_page = '';
                }
                if (data.callmeback > 0) {
                    $(".jp-title").text(data.track);
                    $(".jp-artist").text(data.artist);
                    clearTimeout(player.station.timemout);
                    player.station.timemout = setTimeout(function() {
                        player.station.get_current();
                    }, data.callmeback);
                }
            }, "json");
        }
    }
}
window.onbeforeunload = function() {
    if (getPlayerState() == 1) return lang.msg_exit_page;
}
gui.get_like_button = function(id) {
    console.log(player.current);
    if (!id || !is_logged || player.current.type == 'station') {
        $(".target-like").html("");
        return false;
    }
    var url = base_url + "backend/get_like_button";
    $(".target-like .btn").removeClass("btn-like");
    $(".target-like").removeAttr('data-id');
    $.post(url, {
        id: id
    }, function(data, textStatus, xhr) {
        $(".target-like").html(data);
        $(".target-like").attr("data-id", id);
    });
}
gui.refresh_playlist = function() {
    var url = base_url + "backend/get_playlists";
    var _pl = $(".playlist-target");
    var artist = $(".btn-playlist-menu-hide").attr("data-artist");
    var track = $(".btn-playlist-menu-hide").attr("data-track");
    var album = $(".btn-playlist-menu-hide").attr("data-album");
    var image = $(".btn-playlist-menu-hide").attr("data-image");
    var id = $(".btn-playlist-menu-hide").attr("data-id");
    _pl.empty();
    $.getJSON(url, false, function(json, textStatus) {
        $.each(json, function(index, val) {
            _pl.append('<a data-id="' + id + '" data-track="' + track + '" data-artist="' + artist + '" data-album="' + album + '" data-image="' + image + '" class="truncate list-group-item only-track  btn-save-to-playlist" data-idplaylist="' + val.idplaylist + '" href="#"><i class="zmdi zmdi-playlist-plus"></i>' + val.name + '</a>');
        });
    });
}
gui.save_playlist = function(name) {
    loading();
    $("#modal-create-playlist").modal("hide");
    var url = base_url + "backend/set_playlist";
    console.log(app.save2pl);
    $.post(url, {
        name: name
    }, function(data, textStatus, xhr) {
        if ($("#open-playlist-page").length > 0) {
            current_page = '';
            load_page(location.pathname);
        }
        gui.refresh_playlist();
        $("#modal-create-playlist input").val("");
        console.log(app.save2pl);
        if (app.save2pl.artist != '' && app.save2pl.track != '') {
            console.log(app.save2pl);
            gui.noty(app.save2pl.track, lang.label_added_to_playlist, app.save2pl.image);
            $.post(url, {
                idplaylist: data.id,
                artist: app.save2pl.artist,
                track: app.save2pl.track,
                album: app.save2pl.album,
                image: app.save2pl.image,
                id: app.save2pl.id
            }, function(data, textStatus, xhr) {
                app.save2pl.artist = '';
                app.save2pl.track = '';
                app.save2pl.album = '';
                app.save2pl.image = '';
                app.save2pl.id = '';
                loading('hide');
            }, "json");
        } else {
            $("#modal-create-playlist").modal("hide");
            loading('hide');
        }
    }, "json");
}
gui.add2_playlist = function(idplaylist, artist, track, album, image, id) {
    gui.noty(track, lang.label_added_to_playlist, image);
    var url = base_url + "backend/set_playlist";
    $.post(url, {
        idplaylist: idplaylist,
        artist: artist,
        track: track,
        album: album,
        image: image,
        id: id
    }, function(data, textStatus, xhr) {
        app.save2pl.artist = '';
        app.save2pl.track = '';
        app.save2pl.album = '';
        app.save2pl.image = '';
        app.save2pl.id = '';
    }, "json");
}
gui.remove_from_playlist = function(idplaylist, artist, track, album, image, id) {
    var url = base_url + "backend/set_playlist";
    $.post(url, {
        acc: "r",
        idplaylist: idplaylist,
        artist: artist,
        track: track,
        album: album,
        image: image,
        id: id
    }, function(data, textStatus, xhr) {
        app.save2pl.artist = '';
        app.save2pl.track = '';
        app.save2pl.album = '';
        app.save2pl.image = '';
        app.save2pl.id = '';
        load_page(location.pathname);
    }, "json");
}
gui.remove_playlist = function(idplaylist) {
    bootbox.dialog({
        message: lang.msg_remove_playlist,
        title: lang.label_remove_playlist,
        buttons: {
            success: {
                label: lang.label_yes,
                className: "btn-success",
                callback: function() {
                    var url = base_url + "backend/set_playlist";
                    $.post(url, {
                        acc: "r",
                        idplaylist: idplaylist
                    }, function(data, textStatus, xhr) {
                        set_page(base_url + slug.my_playlist);
                    }, "json");
                }
            },
            danger: {
                label: lang.label_no,
                className: "btn-danger",
                callback: function() {
                    console.log("No!");
                }
            }
        }
    });
}
gui.noty = function(title, subtitle, image) {
        $("#noty strong").text(title);
        $("#noty span").text(subtitle);
        $("#noty img").attr("src", image);
        $("#noty").addClass("show").delay(2000).queue(function() {
            $(this).removeClass("show").dequeue();
        });
    }
    /* Plugins */
    /**
     * Vertically center Bootstrap 3 modals so they aren't always stuck at the top
     */
$(function() {
    function reposition() {
        var modal = $(this),
            dialog = modal.find('.modal-dialog');
        modal.css('display', 'block');
        // Dividing by two centers the modal exactly, but dividing by three 
        // or four works better for larger screens.
        dialog.css("margin-top", Math.max(0, ($(window).height() - dialog.height()) / 2));
    }
    // Reposition when a modal is shown
    $('.modal').on('show.bs.modal', reposition);
    // Reposition when the window is resized
    $(window).on('resize', function() {
        $('.modal:visible').each(reposition);
    });
});;
(function() {
    'use strict';
    /**
     * @preserve FastClick: polyfill to remove click delays on browsers with touch UIs.
     *
     * @codingstandard ftlabs-jsv2
     * @copyright The Financial Times Limited [All Rights Reserved]
     * @license MIT License (see LICENSE.txt)
     */
    /*jslint browser:true, node:true*/
    /*global define, Event, Node*/
    /**
     * Instantiate fast-clicking listeners on the specified layer.
     *
     * @constructor
     * @param {Element} layer The layer to listen on
     * @param {Object} [options={}] The options to override the defaults
     */
    function FastClick(layer, options) {
        var oldOnClick;
        options = options || {};
        /**
         * Whether a click is currently being tracked.
         *
         * @type boolean
         */
        this.trackingClick = false;
        /**
         * Timestamp for when click tracking started.
         *
         * @type number
         */
        this.trackingClickStart = 0;
        /**
         * The element being tracked for a click.
         *
         * @type EventTarget
         */
        this.targetElement = null;
        /**
         * X-coordinate of touch start event.
         *
         * @type number
         */
        this.touchStartX = 0;
        /**
         * Y-coordinate of touch start event.
         *
         * @type number
         */
        this.touchStartY = 0;
        /**
         * ID of the last touch, retrieved from Touch.identifier.
         *
         * @type number
         */
        this.lastTouchIdentifier = 0;
        /**
         * Touchmove boundary, beyond which a click will be cancelled.
         *
         * @type number
         */
        this.touchBoundary = options.touchBoundary || 10;
        /**
         * The FastClick layer.
         *
         * @type Element
         */
        this.layer = layer;
        /**
         * The minimum time between tap(touchstart and touchend) events
         *
         * @type number
         */
        this.tapDelay = options.tapDelay || 200;
        /**
         * The maximum time for a tap
         *
         * @type number
         */
        this.tapTimeout = options.tapTimeout || 700;
        if (FastClick.notNeeded(layer)) {
            return;
        }
        // Some old versions of Android don't have Function.prototype.bind
        function bind(method, context) {
            return function() {
                return method.apply(context, arguments);
            };
        }
        var methods = ['onMouse', 'onClick', 'onTouchStart', 'onTouchMove', 'onTouchEnd', 'onTouchCancel'];
        var context = this;
        for (var i = 0, l = methods.length; i < l; i++) {
            context[methods[i]] = bind(context[methods[i]], context);
        }
        // Set up event handlers as required
        if (deviceIsAndroid) {
            layer.addEventListener('mouseover', this.onMouse, true);
            layer.addEventListener('mousedown', this.onMouse, true);
            layer.addEventListener('mouseup', this.onMouse, true);
        }
        layer.addEventListener('click', this.onClick, true);
        layer.addEventListener('touchstart', this.onTouchStart, false);
        layer.addEventListener('touchmove', this.onTouchMove, false);
        layer.addEventListener('touchend', this.onTouchEnd, false);
        layer.addEventListener('touchcancel', this.onTouchCancel, false);
        // Hack is required for browsers that don't support Event#stopImmediatePropagation (e.g. Android 2)
        // which is how FastClick normally stops click events bubbling to callbacks registered on the FastClick
        // layer when they are cancelled.
        if (!Event.prototype.stopImmediatePropagation) {
            layer.removeEventListener = function(type, callback, capture) {
                var rmv = Node.prototype.removeEventListener;
                if (type === 'click') {
                    rmv.call(layer, type, callback.hijacked || callback, capture);
                } else {
                    rmv.call(layer, type, callback, capture);
                }
            };
            layer.addEventListener = function(type, callback, capture) {
                var adv = Node.prototype.addEventListener;
                if (type === 'click') {
                    adv.call(layer, type, callback.hijacked || (callback.hijacked = function(event) {
                        if (!event.propagationStopped) {
                            callback(event);
                        }
                    }), capture);
                } else {
                    adv.call(layer, type, callback, capture);
                }
            };
        }
        // If a handler is already declared in the element's onclick attribute, it will be fired before
        // FastClick's onClick handler. Fix this by pulling out the user-defined handler function and
        // adding it as listener.
        if (typeof layer.onclick === 'function') {
            // Android browser on at least 3.2 requires a new reference to the function in layer.onclick
            // - the old one won't work if passed to addEventListener directly.
            oldOnClick = layer.onclick;
            layer.addEventListener('click', function(event) {
                oldOnClick(event);
            }, false);
            layer.onclick = null;
        }
    }
    /**
     * Windows Phone 8.1 fakes user agent string to look like Android and iPhone.
     *
     * @type boolean
     */
    var deviceIsWindowsPhone = navigator.userAgent.indexOf("Windows Phone") >= 0;
    /**
     * Android requires exceptions.
     *
     * @type boolean
     */
    var deviceIsAndroid = navigator.userAgent.indexOf('Android') > 0 && !deviceIsWindowsPhone;
    /**
     * iOS requires exceptions.
     *
     * @type boolean
     */
    var deviceIsIOS = /iP(ad|hone|od)/.test(navigator.userAgent) && !deviceIsWindowsPhone;
    /**
     * iOS 4 requires an exception for select elements.
     *
     * @type boolean
     */
    var deviceIsIOS4 = deviceIsIOS && (/OS 4_\d(_\d)?/).test(navigator.userAgent);
    /**
     * iOS 6.0(+?) requires the target element to be manually derived
     *
     * @type boolean
     */
    var deviceIsIOSWithBadTarget = deviceIsIOS && (/OS ([6-9]|\d{2})_\d/).test(navigator.userAgent);
    /**
     * BlackBerry requires exceptions.
     *
     * @type boolean
     */
    var deviceIsBlackBerry10 = navigator.userAgent.indexOf('BB10') > 0;
    /**
     * Determine whether a given element requires a native click.
     *
     * @param {EventTarget|Element} target Target DOM element
     * @returns {boolean} Returns true if the element needs a native click
     */
    FastClick.prototype.needsClick = function(target) {
        switch (target.nodeName.toLowerCase()) {
            // Don't send a synthetic click to disabled inputs (issue #62)
            case 'button':
            case 'select':
            case 'textarea':
                if (target.disabled) {
                    return true;
                }
                break;
            case 'input':
                // File inputs need real clicks on iOS 6 due to a browser bug (issue #68)
                if ((deviceIsIOS && target.type === 'file') || target.disabled) {
                    return true;
                }
                break;
            case 'label':
            case 'iframe': // iOS8 homescreen apps can prevent events bubbling into frames
            case 'video':
                return true;
        }
        return (/\bneedsclick\b/).test(target.className);
    };
    /**
     * Determine whether a given element requires a call to focus to simulate click into element.
     *
     * @param {EventTarget|Element} target Target DOM element
     * @returns {boolean} Returns true if the element requires a call to focus to simulate native click.
     */
    FastClick.prototype.needsFocus = function(target) {
        switch (target.nodeName.toLowerCase()) {
            case 'textarea':
                return true;
            case 'select':
                return !deviceIsAndroid;
            case 'input':
                switch (target.type) {
                    case 'button':
                    case 'checkbox':
                    case 'file':
                    case 'image':
                    case 'radio':
                    case 'submit':
                        return false;
                }
                // No point in attempting to focus disabled inputs
                return !target.disabled && !target.readOnly;
            default:
                return (/\bneedsfocus\b/).test(target.className);
        }
    };
    /**
     * Send a click event to the specified element.
     *
     * @param {EventTarget|Element} targetElement
     * @param {Event} event
     */
    FastClick.prototype.sendClick = function(targetElement, event) {
        var clickEvent, touch;
        // On some Android devices activeElement needs to be blurred otherwise the synthetic click will have no effect (#24)
        if (document.activeElement && document.activeElement !== targetElement) {
            document.activeElement.blur();
        }
        touch = event.changedTouches[0];
        // Synthesise a click event, with an extra attribute so it can be tracked
        clickEvent = document.createEvent('MouseEvents');
        clickEvent.initMouseEvent(this.determineEventType(targetElement), true, true, window, 1, touch.screenX, touch.screenY, touch.clientX, touch.clientY, false, false, false, false, 0, null);
        clickEvent.forwardedTouchEvent = true;
        targetElement.dispatchEvent(clickEvent);
    };
    FastClick.prototype.determineEventType = function(targetElement) {
        //Issue #159: Android Chrome Select Box does not open with a synthetic click event
        if (deviceIsAndroid && targetElement.tagName.toLowerCase() === 'select') {
            return 'mousedown';
        }
        return 'click';
    };
    /**
     * @param {EventTarget|Element} targetElement
     */
    FastClick.prototype.focus = function(targetElement) {
        var length;
        // Issue #160: on iOS 7, some input elements (e.g. date datetime month) throw a vague TypeError on setSelectionRange. These elements don't have an integer value for the selectionStart and selectionEnd properties, but unfortunately that can't be used for detection because accessing the properties also throws a TypeError. Just check the type instead. Filed as Apple bug #15122724.
        if (deviceIsIOS && targetElement.setSelectionRange && targetElement.type.indexOf('date') !== 0 && targetElement.type !== 'time' && targetElement.type !== 'month') {
            length = targetElement.value.length;
            targetElement.setSelectionRange(length, length);
        } else {
            targetElement.focus();
        }
    };
    /**
     * Check whether the given target element is a child of a scrollable layer and if so, set a flag on it.
     *
     * @param {EventTarget|Element} targetElement
     */
    FastClick.prototype.updateScrollParent = function(targetElement) {
        var scrollParent, parentElement;
        scrollParent = targetElement.fastClickScrollParent;
        // Attempt to discover whether the target element is contained within a scrollable layer. Re-check if the
        // target element was moved to another parent.
        if (!scrollParent || !scrollParent.contains(targetElement)) {
            parentElement = targetElement;
            do {
                if (parentElement.scrollHeight > parentElement.offsetHeight) {
                    scrollParent = parentElement;
                    targetElement.fastClickScrollParent = parentElement;
                    break;
                }
                parentElement = parentElement.parentElement;
            } while (parentElement);
        }
        // Always update the scroll top tracker if possible.
        if (scrollParent) {
            scrollParent.fastClickLastScrollTop = scrollParent.scrollTop;
        }
    };
    /**
     * @param {EventTarget} targetElement
     * @returns {Element|EventTarget}
     */
    FastClick.prototype.getTargetElementFromEventTarget = function(eventTarget) {
        // On some older browsers (notably Safari on iOS 4.1 - see issue #56) the event target may be a text node.
        if (eventTarget.nodeType === Node.TEXT_NODE) {
            return eventTarget.parentNode;
        }
        return eventTarget;
    };
    /**
     * On touch start, record the position and scroll offset.
     *
     * @param {Event} event
     * @returns {boolean}
     */
    FastClick.prototype.onTouchStart = function(event) {
        var targetElement, touch, selection;
        // Ignore multiple touches, otherwise pinch-to-zoom is prevented if both fingers are on the FastClick element (issue #111).
        if (event.targetTouches.length > 1) {
            return true;
        }
        targetElement = this.getTargetElementFromEventTarget(event.target);
        touch = event.targetTouches[0];
        if (deviceIsIOS) {
            // Only trusted events will deselect text on iOS (issue #49)
            selection = window.getSelection();
            if (selection.rangeCount && !selection.isCollapsed) {
                return true;
            }
            if (!deviceIsIOS4) {
                // Weird things happen on iOS when an alert or confirm dialog is opened from a click event callback (issue #23):
                // when the user next taps anywhere else on the page, new touchstart and touchend events are dispatched
                // with the same identifier as the touch event that previously triggered the click that triggered the alert.
                // Sadly, there is an issue on iOS 4 that causes some normal touch events to have the same identifier as an
                // immediately preceeding touch event (issue #52), so this fix is unavailable on that platform.
                // Issue 120: touch.identifier is 0 when Chrome dev tools 'Emulate touch events' is set with an iOS device UA string,
                // which causes all touch events to be ignored. As this block only applies to iOS, and iOS identifiers are always long,
                // random integers, it's safe to to continue if the identifier is 0 here.
                if (touch.identifier && touch.identifier === this.lastTouchIdentifier) {
                    event.preventDefault();
                    return false;
                }
                this.lastTouchIdentifier = touch.identifier;
                // If the target element is a child of a scrollable layer (using -webkit-overflow-scrolling: touch) and:
                // 1) the user does a fling scroll on the scrollable layer
                // 2) the user stops the fling scroll with another tap
                // then the event.target of the last 'touchend' event will be the element that was under the user's finger
                // when the fling scroll was started, causing FastClick to send a click event to that layer - unless a check
                // is made to ensure that a parent layer was not scrolled before sending a synthetic click (issue #42).
                this.updateScrollParent(targetElement);
            }
        }
        this.trackingClick = true;
        this.trackingClickStart = event.timeStamp;
        this.targetElement = targetElement;
        this.touchStartX = touch.pageX;
        this.touchStartY = touch.pageY;
        // Prevent phantom clicks on fast double-tap (issue #36)
        if ((event.timeStamp - this.lastClickTime) < this.tapDelay) {
            event.preventDefault();
        }
        return true;
    };
    /**
     * Based on a touchmove event object, check whether the touch has moved past a boundary since it started.
     *
     * @param {Event} event
     * @returns {boolean}
     */
    FastClick.prototype.touchHasMoved = function(event) {
        var touch = event.changedTouches[0],
            boundary = this.touchBoundary;
        if (Math.abs(touch.pageX - this.touchStartX) > boundary || Math.abs(touch.pageY - this.touchStartY) > boundary) {
            return true;
        }
        return false;
    };
    /**
     * Update the last position.
     *
     * @param {Event} event
     * @returns {boolean}
     */
    FastClick.prototype.onTouchMove = function(event) {
        if (!this.trackingClick) {
            return true;
        }
        // If the touch has moved, cancel the click tracking
        if (this.targetElement !== this.getTargetElementFromEventTarget(event.target) || this.touchHasMoved(event)) {
            this.trackingClick = false;
            this.targetElement = null;
        }
        return true;
    };
    /**
     * Attempt to find the labelled control for the given label element.
     *
     * @param {EventTarget|HTMLLabelElement} labelElement
     * @returns {Element|null}
     */
    FastClick.prototype.findControl = function(labelElement) {
        // Fast path for newer browsers supporting the HTML5 control attribute
        if (labelElement.control !== undefined) {
            return labelElement.control;
        }
        // All browsers under test that support touch events also support the HTML5 htmlFor attribute
        if (labelElement.htmlFor) {
            return document.getElementById(labelElement.htmlFor);
        }
        // If no for attribute exists, attempt to retrieve the first labellable descendant element
        // the list of which is defined here: http://www.w3.org/TR/html5/forms.html#category-label
        return labelElement.querySelector('button, input:not([type=hidden]), keygen, meter, output, progress, select, textarea');
    };
    /**
     * On touch end, determine whether to send a click event at once.
     *
     * @param {Event} event
     * @returns {boolean}
     */
    FastClick.prototype.onTouchEnd = function(event) {
        var forElement, trackingClickStart, targetTagName, scrollParent, touch, targetElement = this.targetElement;
        if (!this.trackingClick) {
            return true;
        }
        // Prevent phantom clicks on fast double-tap (issue #36)
        if ((event.timeStamp - this.lastClickTime) < this.tapDelay) {
            this.cancelNextClick = true;
            return true;
        }
        if ((event.timeStamp - this.trackingClickStart) > this.tapTimeout) {
            return true;
        }
        // Reset to prevent wrong click cancel on input (issue #156).
        this.cancelNextClick = false;
        this.lastClickTime = event.timeStamp;
        trackingClickStart = this.trackingClickStart;
        this.trackingClick = false;
        this.trackingClickStart = 0;
        // On some iOS devices, the targetElement supplied with the event is invalid if the layer
        // is performing a transition or scroll, and has to be re-detected manually. Note that
        // for this to function correctly, it must be called *after* the event target is checked!
        // See issue #57; also filed as rdar://13048589 .
        if (deviceIsIOSWithBadTarget) {
            touch = event.changedTouches[0];
            // In certain cases arguments of elementFromPoint can be negative, so prevent setting targetElement to null
            targetElement = document.elementFromPoint(touch.pageX - window.pageXOffset, touch.pageY - window.pageYOffset) || targetElement;
            targetElement.fastClickScrollParent = this.targetElement.fastClickScrollParent;
        }
        targetTagName = targetElement.tagName.toLowerCase();
        if (targetTagName === 'label') {
            forElement = this.findControl(targetElement);
            if (forElement) {
                this.focus(targetElement);
                if (deviceIsAndroid) {
                    return false;
                }
                targetElement = forElement;
            }
        } else if (this.needsFocus(targetElement)) {
            // Case 1: If the touch started a while ago (best guess is 100ms based on tests for issue #36) then focus will be triggered anyway. Return early and unset the target element reference so that the subsequent click will be allowed through.
            // Case 2: Without this exception for input elements tapped when the document is contained in an iframe, then any inputted text won't be visible even though the value attribute is updated as the user types (issue #37).
            if ((event.timeStamp - trackingClickStart) > 100 || (deviceIsIOS && window.top !== window && targetTagName === 'input')) {
                this.targetElement = null;
                return false;
            }
            this.focus(targetElement);
            this.sendClick(targetElement, event);
            // Select elements need the event to go through on iOS 4, otherwise the selector menu won't open.
            // Also this breaks opening selects when VoiceOver is active on iOS6, iOS7 (and possibly others)
            if (!deviceIsIOS || targetTagName !== 'select') {
                this.targetElement = null;
                event.preventDefault();
            }
            return false;
        }
        if (deviceIsIOS && !deviceIsIOS4) {
            // Don't send a synthetic click event if the target element is contained within a parent layer that was scrolled
            // and this tap is being used to stop the scrolling (usually initiated by a fling - issue #42).
            scrollParent = targetElement.fastClickScrollParent;
            if (scrollParent && scrollParent.fastClickLastScrollTop !== scrollParent.scrollTop) {
                return true;
            }
        }
        // Prevent the actual click from going though - unless the target node is marked as requiring
        // real clicks or if it is in the whitelist in which case only non-programmatic clicks are permitted.
        if (!this.needsClick(targetElement)) {
            event.preventDefault();
            this.sendClick(targetElement, event);
        }
        return false;
    };
    /**
     * On touch cancel, stop tracking the click.
     *
     * @returns {void}
     */
    FastClick.prototype.onTouchCancel = function() {
        this.trackingClick = false;
        this.targetElement = null;
    };
    /**
     * Determine mouse events which should be permitted.
     *
     * @param {Event} event
     * @returns {boolean}
     */
    FastClick.prototype.onMouse = function(event) {
        // If a target element was never set (because a touch event was never fired) allow the event
        if (!this.targetElement) {
            return true;
        }
        if (event.forwardedTouchEvent) {
            return true;
        }
        // Programmatically generated events targeting a specific element should be permitted
        if (!event.cancelable) {
            return true;
        }
        // Derive and check the target element to see whether the mouse event needs to be permitted;
        // unless explicitly enabled, prevent non-touch click events from triggering actions,
        // to prevent ghost/doubleclicks.
        if (!this.needsClick(this.targetElement) || this.cancelNextClick) {
            // Prevent any user-added listeners declared on FastClick element from being fired.
            if (event.stopImmediatePropagation) {
                event.stopImmediatePropagation();
            } else {
                // Part of the hack for browsers that don't support Event#stopImmediatePropagation (e.g. Android 2)
                event.propagationStopped = true;
            }
            // Cancel the event
            event.stopPropagation();
            event.preventDefault();
            return false;
        }
        // If the mouse event is permitted, return true for the action to go through.
        return true;
    };
    /**
     * On actual clicks, determine whether this is a touch-generated click, a click action occurring
     * naturally after a delay after a touch (which needs to be cancelled to avoid duplication), or
     * an actual click which should be permitted.
     *
     * @param {Event} event
     * @returns {boolean}
     */
    FastClick.prototype.onClick = function(event) {
        var permitted;
        // It's possible for another FastClick-like library delivered with third-party code to fire a click event before FastClick does (issue #44). In that case, set the click-tracking flag back to false and return early. This will cause onTouchEnd to return early.
        if (this.trackingClick) {
            this.targetElement = null;
            this.trackingClick = false;
            return true;
        }
        // Very odd behaviour on iOS (issue #18): if a submit element is present inside a form and the user hits enter in the iOS simulator or clicks the Go button on the pop-up OS keyboard the a kind of 'fake' click event will be triggered with the submit-type input element as the target.
        if (event.target.type === 'submit' && event.detail === 0) {
            return true;
        }
        permitted = this.onMouse(event);
        // Only unset targetElement if the click is not permitted. This will ensure that the check for !targetElement in onMouse fails and the browser's click doesn't go through.
        if (!permitted) {
            this.targetElement = null;
        }
        // If clicks are permitted, return true for the action to go through.
        return permitted;
    };
    /**
     * Remove all FastClick's event listeners.
     *
     * @returns {void}
     */
    FastClick.prototype.destroy = function() {
        var layer = this.layer;
        if (deviceIsAndroid) {
            layer.removeEventListener('mouseover', this.onMouse, true);
            layer.removeEventListener('mousedown', this.onMouse, true);
            layer.removeEventListener('mouseup', this.onMouse, true);
        }
        layer.removeEventListener('click', this.onClick, true);
        layer.removeEventListener('touchstart', this.onTouchStart, false);
        layer.removeEventListener('touchmove', this.onTouchMove, false);
        layer.removeEventListener('touchend', this.onTouchEnd, false);
        layer.removeEventListener('touchcancel', this.onTouchCancel, false);
    };
    /**
     * Check whether FastClick is needed.
     *
     * @param {Element} layer The layer to listen on
     */
    FastClick.notNeeded = function(layer) {
        var metaViewport;
        var chromeVersion;
        var blackberryVersion;
        // Devices that don't support touch don't need FastClick
        if (typeof window.ontouchstart === 'undefined') {
            return true;
        }
        // Chrome version - zero for other browsers
        chromeVersion = +(/Chrome\/([0-9]+)/.exec(navigator.userAgent) || [, 0])[1];
        if (chromeVersion) {
            if (deviceIsAndroid) {
                metaViewport = document.querySelector('meta[name=viewport]');
                if (metaViewport) {
                    // Chrome on Android with user-scalable="no" doesn't need FastClick (issue #89)
                    if (metaViewport.content.indexOf('user-scalable=no') !== -1) {
                        return true;
                    }
                    // Chrome 32 and above with width=device-width or less don't need FastClick
                    if (chromeVersion > 31 && document.documentElement.scrollWidth <= window.outerWidth) {
                        return true;
                    }
                }
                // Chrome desktop doesn't need FastClick (issue #15)
            } else {
                return true;
            }
        }
        if (deviceIsBlackBerry10) {
            blackberryVersion = navigator.userAgent.match(/Version\/([0-9]*)\.([0-9]*)/);
            // BlackBerry 10.3+ does not require Fastclick library.
            // https://github.com/ftlabs/fastclick/issues/251
            if (blackberryVersion[1] >= 10 && blackberryVersion[2] >= 3) {
                metaViewport = document.querySelector('meta[name=viewport]');
                if (metaViewport) {
                    // user-scalable=no eliminates click delay.
                    if (metaViewport.content.indexOf('user-scalable=no') !== -1) {
                        return true;
                    }
                    // width=device-width (or less than device-width) eliminates click delay.
                    if (document.documentElement.scrollWidth <= window.outerWidth) {
                        return true;
                    }
                }
            }
        }
        // IE10 with -ms-touch-action: none, which disables double-tap-to-zoom (issue #97)
        if (layer.style.msTouchAction === 'none') {
            return true;
        }
        // IE11: prefixed -ms-touch-action is no longer supported and it's recomended to use non-prefixed version
        // http://msdn.microsoft.com/en-us/library/windows/apps/Hh767313.aspx
        if (layer.style.touchAction === 'none') {
            return true;
        }
        return false;
    };
    /**
     * Factory method for creating a FastClick object
     *
     * @param {Element} layer The layer to listen on
     * @param {Object} [options={}] The options to override the defaults
     */
    FastClick.attach = function(layer, options) {
        return new FastClick(layer, options);
    };
    if (typeof define == 'function' && typeof define.amd == 'object' && define.amd) {
        // AMD. Register as an anonymous module.
        define(function() {
            return FastClick;
        });
    } else if (typeof module !== 'undefined' && module.exports) {
        module.exports = FastClick.attach;
        module.exports.FastClick = FastClick;
    } else {
        window.FastClick = FastClick;
    }
}());
window.addEventListener("load", function() {
    FastClick.attach(document.body);
}, false);
/*
window.onbeforeunload = function () {  
      return "Â¿Desea salir de la aplicacion?"; 
}*/
function PopupCenter(url, title, w, h) {
    // Fixes dual-screen position                         Most browsers      Firefox
    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
    var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;
    var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;
    var left = ((width / 2) - (w / 2)) + dualScreenLeft;
    var top = ((height / 2) - (h / 2)) + dualScreenTop;
    var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
    // Puts focus on the newWindow
    if (window.focus) {
        newWindow.focus();
    }
}
var delay = (function() {
    var timer = 0;
    return function(callback, ms) {
        clearTimeout(timer);
        timer = setTimeout(callback, ms);
    };
})();
// Asynchronously load non-critical css 
function loadCSS(e, t, n) {
    "use strict";
    var i = window.document.createElement("link");
    var o = t || window.document.getElementsByTagName("script")[0];
    i.rel = "stylesheet";
    i.href = e;
    i.media = "only x";
    o.parentNode.insertBefore(i, o);
    setTimeout(function() {
        i.media = n || "all"
    })
}
// load css file async
loadCSS("//fonts.googleapis.com/css?family=RobotoDraft:300,400,500,600,700");
loadCSS("//cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css");
loadCSS("//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css");
loadCSS(base_url + "assets/css/animations.css");
if(localStorage.playerTOP)
{
    $(".player-c").css("top",localStorage.playerTOP+"px");
    $(".player-c").css("left",localStorage.playerLEFT+"px");
}


(function($) {
    $.fn.drags = function(opt) {

        opt = $.extend({
            handle: "",
            cursor: "move",
            draggableClass: "draggable",
            activeHandleClass: "active-handle"
        }, opt);

        var $selected = null;
        var $elements = (opt.handle === "") ? this : this.find(opt.handle);

        $elements.css('cursor', opt.cursor).on("mousedown", function(e) {
            if(opt.handle === "") {
                $selected = $(this);
                $selected.addClass(opt.draggableClass);
            } else {
                $selected = $(this).parent();
                $selected.addClass(opt.draggableClass).find(opt.handle).addClass(opt.activeHandleClass);
            }
            var drg_h = $selected.outerHeight(),
                drg_w = $selected.outerWidth(),
                pos_y = $selected.offset().top + drg_h - e.pageY,
                pos_x = $selected.offset().left + drg_w - e.pageX;
            $(document).on("mousemove", function(e) {
                $selected.offset({
                    top: e.pageY + pos_y - drg_h,
                    left: e.pageX + pos_x - drg_w
                });
            }).on("mouseup", function() {
                $(this).off("mousemove"); // Unbind events from document
                if ($selected !== null) {
                    $selected.removeClass(opt.draggableClass);
                    $selected = null;
                }
            });
            e.preventDefault(); // disable selection
        }).on("mouseup", function() {
            if(opt.handle === "") {
                $selected.removeClass(opt.draggableClass);
            } else {
                $selected.removeClass(opt.draggableClass)
                    .find(opt.handle).removeClass(opt.activeHandleClass);
            }
            localStorage.playerTOP =$selected.position().top; 
            localStorage.playerLEFT =$selected.position().left; 
             
            $selected = null;
        });

        return this;

    };
})(jQuery);