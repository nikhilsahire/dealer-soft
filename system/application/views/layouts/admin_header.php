<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Dealer Software | <?php echo $this->session->userdata('userrole') ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport"/>
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<!--<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>-->
<link href="<?php echo $this->config->item("global_url")?>plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item("global_url")?>plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item("global_url")?>plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item("global_url")?>plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item("global_url")?>plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->

<!--<link href="< ?php echo $this->config->item("global_url")?>plugins/bootstrap-colorpicker/css/colorpicker.css" rel="stylesheet" type="text/css" />
<link href="< ?php echo $this->config->item("global_url")?>plugins/jquery-minicolors/jquery.minicolors.css" rel="stylesheet" type="text/css" />-->

<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link href="<?php echo $this->config->item("global_url")?>plugins/gritter/css/jquery.gritter.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item("global_url")?>plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
<!--<link href="< ?php echo $this->config->item("global_url")?>plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css"/>
<link href="< ?php echo $this->config->item("global_url")?>plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>-->
<!-- END PAGE LEVEL PLUGIN STYLES -->
<!-- BEGIN PAGE STYLES -->
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item("global_url")?>plugins/bootstrap-select/bootstrap-select.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item("global_url")?>plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item("global_url")?>plugins/jquery-multi-select/css/multi-select.css"/>
<!-- END PAGE STYLES -->
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item("global_url")?>plugins/bootstrap-datepicker/css/datepicker.css"/>
<link rel="stylesheet" href="<?php echo $this->config->item("global_url")?>plugins/clockface/css/clockface.css"/>
<link rel="stylesheet" href="<?php echo $this->config->item("global_url")?>plugins/bootstrap-datepicker/css/datepicker3.css"/>
<link rel="stylesheet" href="<?php echo $this->config->item("global_url")?>plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
<link rel="stylesheet" href="<?php echo $this->config->item("global_url")?>plugins/bootstrap-colorpicker/css/colorpicker.css"/>
<link rel="stylesheet" href="<?php echo $this->config->item("global_url")?>plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
<link rel="stylesheet" href="<?php echo $this->config->item("global_url")?>plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>
<!-- BEGIN THEME STYLES -->
<link href="<?php echo $this->config->item("global_url")?>css/components.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item("global_url")?>css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item("base_url_asset")?>assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item("base_url_asset")?>assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="<?php echo $this->config->item("base_url_asset")?>assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo $this->config->item("global_url")?>plugins/jquery-1.11.0.min.js" type="text/javascript"></script>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
<script type="text/javascript">
  var base_url = '<?php echo base_url();?>';
  var global_url = '<?php echo $this->config->item("global_url")?>';
  SITE_URL = "<?php echo base_url(); ?>";

  document.oncontextmenu = function(){return false;};
  document.onselectstart= function() {return false;}; 

</script>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
<!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
<!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
<!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
<!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
<!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
<!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
<body class="page-header-fixed page-quick-sidebar-over-content">
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top"> 
  <!-- BEGIN HEADER INNER -->
  <div class="page-header-inner"> 
    <!-- BEGIN LOGO -->
    <div class="page-logo">
      <div style="font-size:20px; color:#FFF;" class="logo-default">Dealer <span style="color:#F00">Software</span></div>
      <div class="menu-toggler sidebar-toggler hide"> 
        <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header --> 
      </div>
    </div>
    <!-- END LOGO --> 
    <!-- BEGIN RESPONSIVE MENU TOGGLER --> 
    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a> 
    <!-- END RESPONSIVE MENU TOGGLER --> 
    <!-- BEGIN TOP NAVIGATION MENU -->
    <div class="top-menu">
      <ul class="nav navbar-nav pull-right"> 
        <!-- BEGIN USER LOGIN DROPDOWN -->
        <?php if($this->session->userdata('userid') != '') {?>
            <li class="dropdown dropdown-user"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">  <span class="username username-hide-on-mobile"><?php echo $this->session->userdata('username') ?></span> <i class="fa fa-angle-down"></i> </a>
              <ul class="dropdown-menu">
                <li> <a href="<?php echo base_url();?>login_con/change_password"> <i class="icon-user"></i>Change Password</a> </li>
                <li> <a href="<?php echo base_url();?>login_con/logout"> <i class="icon-key"></i> Log Out </a> </li>
              </ul>
            </li>
        <?php } ?>
        <!-- END USER LOGIN DROPDOWN --> 
      </ul>
    </div>
    <!-- END TOP NAVIGATION MENU --> 
  </div>
  <!-- END HEADER INNER --> 
</div>
<!-- END HEADER -->
<div class="clearfix"> </div>
