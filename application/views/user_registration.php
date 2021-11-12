<!doctype html>
<html>
   <head>
      <!-- Meta -->
      <meta charset="utf-8">
      <META name="robots" content="index,follow">
      <META name="author" content="<?php echo AUTHOR;?>">
      <META name="copyright" content="<?php echo COPYRIGHT_COMPANY;?>">
      <META name="description" content="<?php echo META_DESC; ?>">
      <META name="keywords" content="">
      <meta name="revisit-after" content="7 days" />
      <title><?php echo $meta_title; ?></title>
      <meta name="viewport" content="width=device-width, initial-scale=1" user-scalable="no">
      <!-- Favicons -->
      <link rel="shortcut icon" href="<?php echo base_url().FAV_ICON?>">
      <link rel="apple-touch-icon" href="<?php echo base_url();?>img/apple-touch-icon.png">
      <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url();?>img/apple-touch-icon-72x72.png">
      <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url();?>img/apple-touch-icon-114x114.png">
      <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url();?>img/apple-touch-icon-144x144.png">
      <!-- Web Fonts  -->
      <!--[if lt IE 9]>
      <script src="js/respond.min.js"></script>
      <![endif]-->
      <!-- CSS -->
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap.css"/>
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap.min.css"/>
      <link href="<?php echo base_url(); ?>css/font-awesome.min.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet" type="text/css">
      <!--for ie lower version of -->
      <!--[if lt IE 9]>
      <script src="js/html5.js"></script>
      <![endif]-->
   </head>
   <body>
      <div id="wrapper">
         <div class="outer">
            <div class="middle">
               <div class="inner">
                  <div class="login-container">
                     <div class="login-form">
                        <p>User Registration  </p>
                        <form action="" method=post>

                           <?php if($this->session->flashdata('error')!='') { ?>
                              <div class="alert alert-danger"> <?php echo $this->session->flashdata('error');?> </div>
                           <?php } ?>
                           <?php if($this->session->flashdata('success')!='') { ?>
                              <div class="alert alert-success"> <?php echo $this->session->flashdata('success');?> </div>
                           <?php } ?>

                           <?php
                              $csrf = array(
                                'name' => $this->security->get_csrf_token_name(),
                                'hash' => $this->security->get_csrf_hash()
                              );
                           ?>
                           <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>" />
						   
						   <div class="form-group">
                              <div class="input-icon">
                                 <i class="fa fa-user" aria-hidden="true"></i>
                                 <input type="text" name="f_name" class="form-control" placeholder="First Name" data-validation="required" autocomplete="off" value="<?php echo set_value('f_name');?>">
                                 <?php echo form_error('f_name', '<div class="text-danger">', '</div>'); ?>
                              </div>
                           </div>
						   
						   <div class="form-group">
                              <div class="input-icon">
                                 <i class="fa fa-user" aria-hidden="true"></i>
                                 <input type="text" name="l_name" class="form-control" placeholder="Last Name" data-validation="required" autocomplete="off" value="<?php echo set_value('l_name');?>">
                                 <?php echo form_error('l_name', '<div class="text-danger">', '</div>'); ?>
                              </div>
                           </div>

                           <div class="form-group">
                              <div class="input-icon">
                                 <i class="fa fa-user" aria-hidden="true"></i>
                                 <input type="text" name="email" class="form-control" placeholder="Email" data-validation="required email" autocomplete="off" value="<?php echo set_value('email');?>">
                                 <?php echo form_error('email', '<div class="text-danger">', '</div>'); ?>
                              </div>
                           </div>

                           <div class="form-group">
                              <div class="input-icon">
                                 <i class="fa fa-lock" aria-hidden="true"></i>
                                 <input type="Password" name="password" class="form-control" placeholder="Password" data-validation="required" autocomplete="off" value="<?php echo set_value('password');?>">
                                 <?php echo form_error('password', '<div class="text-danger">', '</div>'); ?>
                              </div>
                           </div>
						   
						   <div class="form-group">
                              <div class="input-icon">
                                 <i class="fa fa-lock" aria-hidden="true"></i>
                                 <input type="Password" name="cnf_password" class="form-control" placeholder="Confirm Password" data-validation="required" autocomplete="off" value="<?php echo set_value('cnf_password');?>">
                                 <?php echo form_error('cnf_password', '<div class="text-danger">', '</div>'); ?>
                              </div>
                           </div>

                           <div class="form-group btn-login">
                              <input name="" type="submit" value="Registration" class="btn yellow btn-radius full-btn">
                              <div class="clearfix"></div>
                           </div>
						   
						   <div class="text-center mt-4 font-weight-light">
							  Already have an account? <a href="<?php echo base_url('login');?>" class="text-primary">Login</a>
							</div>

                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

   <script src="<?php echo base_url();?>js/jquery-3.4.1.min.js"></script>
   <script src="<?php echo base_url();?>js/jquery.form-validator.min.js"></script>
   <script>
      $.validate({ lang: 'en' });
	  $(document).ready(function () {
		$(".alert").delay(2000).fadeOut(2000);
	});
   </script>

   </body>
</html>