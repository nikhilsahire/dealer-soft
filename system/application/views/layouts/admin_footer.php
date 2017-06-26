<!-- BEGIN FOOTER -->
<div class="page-footer">
	<div class="page-footer-inner">
		 <?php echo date("Y")?> &copy; Admin Panel.
	</div> 
	<div class="page-footer-tools">
		<span class="go-top">
		<i class="fa fa-angle-up"></i>
		</span>
	</div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo $this->config->item("global_url")?>plugins/respond.min.js"></script>
<script src="<?php echo $this->config->item("global_url")?>plugins/excanvas.min.js"></script> 
<![endif]-->

<script src="<?php echo $this->config->item("global_url")?>plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo $this->config->item("global_url")?>plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item("global_url")?>plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item("global_url")?>plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item("global_url")?>plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item("global_url")?>plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item("global_url")?>plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item("global_url")?>plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item("global_url")?>plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<!--<script src="< ?php echo $this->config->item("global_url")?>plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js" type="text/javascript"></script>
<script src="< ?php echo $this->config->item("global_url")?>plugins/jquery-minicolors/jquery.minicolors.min.js" type="text/javascript"></script>
            
<script src="< ?php echo $this->config->item("global_url")?>plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
<script src="< ?php echo $this->config->item("global_url")?>plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
<script src="< ?php echo $this->config->item("global_url")?>plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
<script src="< ?php echo $this->config->item("global_url")?>plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
<script src="< ?php echo $this->config->item("global_url")?>plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
<script src="< ?php echo $this->config->item("global_url")?>plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
<script src="< ?php echo $this->config->item("global_url")?>plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
<script src="< ?php echo $this->config->item("global_url")?>plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="< ?php echo $this->config->item("global_url")?>plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="<  ?php echo $this->config->item("global_url")?>plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<script src="< ?php echo $this->config->item("global_url")?>plugins/jquery.pulsate.min.js" type="text/javascript"></script>-->
<script src="<?php echo $this->config->item("global_url")?>plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item("global_url")?>plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
<script src="<?php echo $this->config->item("global_url")?>plugins/fullcalendar/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item("global_url")?>plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item("global_url")?>plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item("global_url")?>plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script src="<?php echo $this->config->item("global_url")?>plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<!--<script type="text/javascript" src="<?php echo $this->config->item("global_url")?>plugins/jquery-validation/js/jquery.validate.min.js"></script>-->
<script type="text/javascript" src="<?php echo $this->config->item("global_url")?>plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item("global_url")?>plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item("global_url")?>plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item("global_url")?>plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item("global_url")?>plugins/jquery-multi-select/js/jquery.multi-select.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script src="<?php echo $this->config->item("base_url_asset")?>assets/admin/pages/scripts/components-color-pickers.min.js" type="text/javascript"></script>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo $this->config->item("global_url")?>scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item("base_url_asset")?>assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item("base_url_asset")?>assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item("base_url_asset")?>assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item("base_url_asset")?>assets/admin/pages/scripts/index.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item("base_url_asset")?>assets/admin/pages/scripts/table-managed.js"></script>
<script src="<?php echo $this->config->item("base_url_asset")?>assets/admin/pages/scripts/components-dropdowns.js"></script>
<script src="<?php echo $this->config->item("base_url_asset")?>assets/admin/layout/js/mycustom.js"></script>

<!--<script type="text/javascript" src="< ?php echo $this->config->item("global_url")?>plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>-->
<script type="text/javascript" src="<?php echo $this->config->item("global_url")?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item("global_url")?>plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item("global_url")?>plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item("global_url")?>plugins/bootstrap-daterangepicker/moment.min.js"></script>
<script src="<?php echo $this->config->item("base_url_asset")?>assets/admin/pages/scripts/components-pickers.js"></script>

<!--<script src="<?php //echo base_url();?>assets/admin/ckeditor/ckeditor.js"></script>-->
<!--<script type="text/javascript" src="< ?php echo $this->config->item("base_url_asset")?>assets/ckeditor/ckeditor.js"></script>-->
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {    
   Metronic.init(); // init metronic core componets
   Layout.init(); // init layout
   QuickSidebar.init(); // init quick sidebar
   Demo.init(); // init demo features 
   //Index.init();   
   Index.initDashboardDaterange();
   //Index.initJQVMAP(); // init index page's custom scripts
   Index.initCalendar(); // init index page's custom scripts
   //Index.initCharts(); // init index page's custom scripts
   //Index.initChat();
  // Index.initMiniCharts();
   //Index.initIntro();
   TableManaged.init();
   ComponentsDropdowns.init();
   
	ComponentsPickers.init();
	$('.datetime-picker').datepicker({
		rtl: Metronic.isRTL(),
		format: 'yyyy-mm-dd',
		autoclose: true
	});
	$('#course_date').datepicker({
    	format: 'mm-dd-yyyy'
	});
	 UIAlertDialogApi.init();

	
});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>