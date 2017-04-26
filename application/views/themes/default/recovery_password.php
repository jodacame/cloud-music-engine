<div class="bg-login">
    <div class="dark">
          <!-- Top content -->
        <div class="top-content">
            
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                       
                        <div class="col-md-12 col-lg-12 form-box">
                            <div class="form-top">
                                <div class="form-top-left">
                                    <h3><?php echo __("label_recovery_password"); ?></h3>                                    
                                </div>
                               
                            </div>
                            <div class="form-bottom">
                                <?php if($this->session->error){ ?>
                                    <div class="alert alert-danger">
                                    <?php echo $this->session->error; ?>
                                    </div>
                                <?php } ?>
                                <form role="form" action="" method="post" class="registration-form">
                                            <div class="form-group">
                                        <label class="sr-only" for="form-password"><?php echo __("label_password"); ?></label>
                                        <input type="password" pattern=".{5,}"  required name="password" placeholder="<?php echo __("label_password"); ?>" class="form-password form-control" id="form-last-name">
                                    </div>

                                    <div class="form-group">
                                        <label class="sr-only" for="form-password-r"><?php echo __("label_repeat_password"); ?></label>
                                        <input type="password" pattern=".{5,}"  required name="password-r" placeholder="<?php echo __("label_repeat_password"); ?>" class="form-password-r form-control" id="form-password-r">
                                    </div>
                                   
                                   
                                  

                                    <div>
                                  
                                    </div>
                                    <button type="submit" class="btn btn-success"><?php echo __("label_update"); ?></button>
                                 
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<div class="clearfix"></div>
