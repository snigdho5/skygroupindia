<!doctype html>
<html>
<head>
<!-- Meta -->
<meta charset="utf-8">
<META name="robots" content="index,follow">
<META name="author" content="<?php echo AUTHOR;?>">
<META name="copyright" content="<?php echo COPYRIGHT_COMPANY.' '.date('Y');?>">
<META name="description" content="<?php echo $meta_desc; ?>">
<META name="keywords" content="">
<meta name="revisit-after" content="7 days" />
<title><?php echo $meta_title; ?></title>
<!-- Mobile Meta -->
<meta name="viewport" content="width=device-width, initial-scale=1" user-scalable="no">
<!-- Favicons -->
<link rel="shortcut icon" href="<?php echo base_url().FAV_ICON;?>">
<link rel="apple-touch-icon" href="<?php echo base_url(); ?>img/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url(); ?>img/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url(); ?>img/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url(); ?>img/apple-touch-icon-144x144.png">

<!-- Web Fonts  -->

<!--[if lt IE 9]>
    <script src="js/respond.min.js"></script>
    <![endif]-->

<!-- CSS -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.jqueryui.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/datepicker.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/font-awesome.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css" type="text/css" >

<link rel="stylesheet" href="<?php echo base_url(); ?>css/select2.min.css" type="text/css" >
<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery.accordion.css" type="text/css">

<!-- <link href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" /> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css" rel="stylesheet">

<!--for ie lower version of -->
<!--[if lt IE 9]>
        <script src="js/html5.js"></script>
    <![endif]-->
</head>

<body>
<!--////////////////////////header start here////////////////////////-->
<header>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6 col-sm-6">
        <div class="logo"><a href="<?php echo base_url('dashboard');?>"><img src="<?php echo base_url().ADMIN_HEADER_LOGO?>" width="75"  alt="Infosolz Project" ></a></div>
        <div class="menu-icon"> <a href="#menu-toggle"  id="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></a> </div>
        <div class="clearfix"></div>
      </div>

      <div class="col-md-6 col-sm-6">
        <ul class="setting_message">
          <li class="setting-menus"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
			<?php
				$userDetails = getRowData('_id',new MongoDB\BSON\ObjectId($this->session->userdata('user_db_id')),TBL_USERS);
				
				if(!empty($userDetails) && $userDetails[0]['user_image']!=''){
					$image = base_url().'uploads/users_pic/'.$userDetails[0]['user_image'];
				}else{
					$image = NO_IMAGE;
				}
			?>
            <div class="profile_img">
				<img src="<?php echo $image;?>" width="34" height="34">
            </div>
            <div class="user_name">
				<?php echo isset($userDetails[0]['name'])?$userDetails[0]['name']:'';?> <i class="fa fa-angle-down lnr"></i>
            </div>
            </a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo base_url('profile');?>"><i class="fa fa-user" aria-hidden="true"></i> Profile </a></li>
              <li><a href="<?php echo base_url('change-password');?>"><i class="fa fa-lock" aria-hidden="true"></i> Change Password</a></li>
              <li><a href="<?php echo base_url('logout');?>"><i class="fa fa-sign-out" aria-hidden="true" style="color: red;"></i> Logout</a></li>
            </ul>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</header>
<!--////////////////////////header end here////////////////////////-->
<div class="page-container">
  