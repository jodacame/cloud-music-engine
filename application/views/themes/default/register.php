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
                                <a class="btn btn-success" href="<?php echo base_url(); ?><?php echo $this->config->item('slug_login'); ?>"><?php echo __("label_login"); ?></a>                                
                            </div>
                            <br>
                        </div>
                        <div class="col-md-12 col-lg-5 form-box">
                            <div class="form-top">
                                <div class="form-top-left">
                                    <h3><?php echo __("label_register_title"); ?></h3>
                                    <p><?php echo __("label_register_description"); ?></p>
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
                                <form role="form" action="" method="post" class="registration-form">
                                    <div class="form-group">
                                        <label class="sr-only" for="form-email"><?php echo __("label_email"); ?></label>
                                        <input type="email" value="<?php echo trim($this->input->post("email")); ?>" required name="email" placeholder="<?php echo __("label_email"); ?>" class="form-email form-control" id="form-email">
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="form-username"><?php echo __("label_username"); ?></label>
                                        <input type="text" pattern="[A-Za-z0-9]{5,}" value="<?php echo trim($this->input->post("username")); ?>"  required name="username" placeholder="<?php echo __("label_username"); ?>" class="form-username form-control" id="form-username">
                                    </div>

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
                                    <button type="submit" class="btn btn-success"><?php echo __("label_sign_me"); ?></button>
                                     <hr>
                                    <div class="text-center">
                                        <?php echo get_social_login(); ?>
                                    </div>
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
