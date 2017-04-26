<div class="bg-login">
    <div class="dark">
          <!-- Top content -->
        <div class="top-content">
            
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-lg-7 text">
                            <h1><strong><?php echo config_item("site_title"); ?></h1>
                            <div class="description">
                                <p>
                                    <?php echo config_item("site_description"); ?>
                                </p>
                            </div>
                            <div class="top-big-link">
                                <a class="btn btn-success" href="<?php echo base_url(); ?><?php echo $this->config->item('slug_register'); ?>"><?php echo __("label_register"); ?></a>                                
                                <a class="btn btn-success" href="<?php echo base_url(); ?><?php echo $this->config->item('slug_login'); ?>"><?php echo __("label_login"); ?></a>                                
                            </div>
                            <br>
                        </div>
                        <div class="col-md-12 col-lg-5 form-box">
                            <div class="form-top">
                                <div class="form-top-left">
                                    <h3><?php echo __("label_login_title"); ?></h3>
                                    <p><?php echo __("label_login_description"); ?></p>
                                </div>
                                <div class="form-top-right">
                                    <i class="fa fa-pencil"></i>
                                </div>
                            </div>
                            <div class="form-bottom">
                                <?php if($this->session->error){ ?>
                                    <div class="alert alert-danger">
                                    <?php echo $this->session->error; ?>
                                    </div>
                                <?php } ?>
                                 <?php if($this->session->success){ ?>
                                    <div class="alert alert-success">
                                    <?php echo $this->session->success; ?>
                                    </div>
                                <?php } ?>

                                <form role="form" action="" method="post" class="registration-form">
                                    <div class="form-group">
                                        <label class="sr-only" for="form-email"><?php echo __("label_email"); ?></label>
                                        <input type="email" value="<?php echo trim($this->input->post("email")); ?>" required name="email" placeholder="<?php echo __("label_email"); ?>" class="form-email form-control" id="form-email">
                                          <span class="inline-help"><br><?php echo __("label_recovery_password_text"); ?></span>
                                    </div>
                                   
                                    <div></div>
                                  
                                    <button type="submit" class="btn btn-success"><?php echo __("label_recovery"); ?></button>
                                    
                                    <div class="clearfix"></div>
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
