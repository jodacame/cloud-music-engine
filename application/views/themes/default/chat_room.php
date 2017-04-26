<div class="col-md-12 padding-top-20">
 

 <div class="col-md-9">
 	<div  id="chat-room" >
 		<ul>
 			<li>
 				<div class="msg">
 				<span class="time">Hace 1 minuto</span>
 				<img src="<?php echo avatar($this->session->userdata['user']['avatar']); ?>" class="avatar">
 				<strong><?php echo $this->session->userdata['user']['username']; ?>:</strong> 
 				<span>Hola!</span>
 				</div>
 			</li>

 			<li>
 				<div class="msg">
 				<span class="time">Hace 1 minuto</span>
 				<img src="<?php echo avatar($this->session->userdata['user']['avatar']); ?>" class="avatar">
 				<strong><?php echo $this->session->userdata['user']['username']; ?>:</strong> 
 				<span>Hay alguien?</span>
 				</div>
 			</li>

 			<li>
 				<div class="msg">
 				<span class="time">Hace 1 minuto</span>
 				<img src="<?php echo avatar($this->session->userdata['user']['avatar']); ?>" class="avatar">
 				<strong>Lorem:</strong> 
 				<span>Hola... :)</span>
 				</div>
 			</li>


 			<li>
 				<div class="msg">
 				<span class="time">Hace 1 minuto</span>
 				<img src="<?php echo avatar($this->session->userdata['user']['avatar']); ?>" class="avatar">
 				<strong>Lorem:</strong> 
 				<span>Sipi!</span>
 				</div>
 			</li>

 			<li>
 				<div class="msg">
 				<span class="time">Hace 1 minuto</span>
 				<img src="<?php echo avatar($this->session->userdata['user']['avatar']); ?>" class="avatar">
 				<strong><?php echo $this->session->userdata['user']['username']; ?>:</strong> 
 				<span>Como estas?</span>
 				</div>
 			</li>

 			<li>
 				<div class="msg">
 				<span class="time">Hace 1 minuto</span>
 				<img src="<?php echo avatar($this->session->userdata['user']['avatar']); ?>" class="avatar">
 				<strong>Lorem:</strong> 
 				<span>Bien y tu!</span>
 				</div>
 			</li>
 	
 	</div>
 	<br>
 	<hr>
 	<br>
 	<div class="input-group form-group">
      <input type="text" class="form-control" placeholder="">
      <span class="input-group-btn">
        <button class="btn btn-default" type="button">Send!</button>
      </span>
    </div><!-- /input-group -->
 </div>

  <div class="col-md-3">
 	<div class="list-group   truncate">
 	<?php for($x=0;$x<=8;$x++){ ?>
		 <a href="#" class="list-group-item style2 d">
		     <div class="thumb">
                <div class="thumb-overlay"> 
                  <i class="zmdi zmdi-comments"></i>
                </div>
                <img class="lazy"  src="<?php echo base_url(); ?>assets/images/no-picture.png" >                
              </div>
               <div class="name  truncate title">
		                  	Nombre Sala
		                  	<div class="text-muted">Descripcion</div>
		                  </div>
  		</a>
  	<?php  } ?>

		</div>
 </div>
</div>

