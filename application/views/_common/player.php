
<div id="player">
    <div id="skin-wrapper">         
 
        <div id="jp_container_1" class="jp-audio">
            <div class="jp-type-playlist">
                <div class="jp-gui jp-interface">
                    <div class="player">
                        <div class="info">
                            <div class="cover jp-poster">
                                <img id="jp_poster" src="<?php echo base_url(); ?>assets/images/no-picture.png">
                            </div>
                            <div class="data">
                                <div class="current-info jp-details truncate jp-details-current contextMenu" data-type="track">
                                    <i class="fa fa-circle-o-notch fa-spin loading-streaming hide"></i>
                                    <span class="info-source text-muted"><i class=""></i></span>     
                                    <span class="cursor-pointer btn-track track jp-title" ></span>                                    
                                    -
                                    <span class="cursor-pointer  btn-artist artist jp-artist"></span>     
                                    

                                </div>
                                <div class="actions visible-lg visible-md">                                    
                                    
                                    <span class="btn-radio text-success">
                                    <div id="radio" class="">
                                        <i class="zmdi zmdi-portable-wifi"></i>
                                        <div class="loading">
                                          <div class="s">
                                                <div class="floatingCirclesG">
                                                    <div class="f_circleG" id="frotateG_01">
                                                    </div>
                                                    <div class="f_circleG" id="frotateG_02">
                                                    </div>
                                                    <div class="f_circleG" id="frotateG_03">
                                                    </div>
                                                    <div class="f_circleG" id="frotateG_04">
                                                    </div>
                                                    <div class="f_circleG" id="frotateG_05">
                                                    </div>
                                                    <div class="f_circleG" id="frotateG_06">
                                                    </div>
                                                    <div class="f_circleG" id="frotateG_07">
                                                    </div>
                                                    <div class="f_circleG" id="frotateG_08">
                                                    </div>
                                                </div> 
                                              </div>
                                       
                                      </div>
                                    <?php echo __("label_discover_mode"); ?>
                                    </div>
                                </span>
                                    <span class=" target-like"></span>
                                    <span class=" btn-shuffle"><i class="zmdi zmdi-shuffle"></i></span>
                                    <!--<span class=" btn-show-video active text-success"><i class="zmdi zmdi-youtube-play"></i></span>-->
                                    <span class=" btn-now-playing2"><i class="zmdi zmdi-playlist-audio"></i></span>
                                  
                                        <span class="jp-mute"><i class="zmdi zmdi-volume-up"></i></span>
                                        <span class="jp-unmute"><i class="zmdi zmdi-volume-off"></i></span>
                                        <span class="btn-volume">
                                            <div class="jp-volume-controls">
                                                <!--<button class="jp-mute" role="button" tabindex="0">mute</button>
                                                <button class="jp-volume-max" role="button" tabindex="0">max volume</button>
                                                -->
                                                <div class="jp-volume-bar">
                                                  <div class="jp-volume-bar-value"></div>
                                                </div>
                                              </div>
                                        </span>
                                        
                                   

                                    <span class="btn-lyric"><?php echo __("label_lyric"); ?></span>
                                    <span class="btn-langs" title="<?php echo __("label_language"); ?>">
                                        <span  class="flag flag-<?php echo mb_strtolower($this->session->lang); ?>"></span>
                                        <?php echo $this->session->lang; ?>
                                    </span>
                                   
                                    
                                </div>
                                <div class="current-time jp-current-time">00:00</div>
                                <div class="jp-progress jp-details-current contextMenu" data-type="track">
                                    <div class="progress-seek jp-seek-bar">
                                        <div class="progress-current jp-play-bar"></div>
                                        <div class="progress-handle jp-play-handle"></div>
                                    </div>
                                </div>
                                <div class="duration jp-duration">00:00</div>
                            </div>
                        </div>
                    </div>
                    <ul class="controls jp-controls">
                        <li class="jp-previous" tabindex="1" ><i class="zmdi zmdi-skip-previous"></i></li>
                        <li class="jp-play" tabindex="1" ><i class="zmdi zmdi-play"></i></li>
                        <li class="jp-pause" tabindex="1" ><i class="zmdi zmdi-pause"></i></li>
                        <li class="jp-next" tabindex="1" ><i class="zmdi zmdi-skip-next"></i></li>
                    </ul>

                  

              

                </div> <!-- /jp-interface -->
            </div> <!-- /jp-type-playlist -->
        </div><!-- /jp_container_1 -->
    </div><!-- /skin-wrapper -->
</div> <!-- /player -->


<div class="player-c">
    <div class="move">
        <i class="fa fa-arrows" aria-hidden="true"></i>
    </div>

    <div id="jquery_jplayer_1" class="jp-jplayer"></div> 

</div>

<div class="btn-toggle-youtube visible-xs visible-sm" style="cursor:pointer;text-align:center;z-index:9999;position: fixed;bottom:60px;right: 10px;width:40px;height: 40px;line-height: 40px;vertical-align: middle;font-size:16px;background-color: #C30000;border-radius: 3px;">
    <i class="zmdi zmdi-youtube-play"></i>
</div>