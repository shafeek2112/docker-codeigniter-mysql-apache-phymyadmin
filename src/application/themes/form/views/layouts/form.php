<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php print $template['title']; ?> | <?php print Settings_model::$db_config['site_title']; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="Shortcut Icon" href="<?php print MASTER_URL; ?>images/favicon.ico" type="image/x-icon" />
  <link rel="Bookmark" href="<?php print MASTER_URL; ?>images/favicon.ico" type="image/x-icon" />
  <link rel="icon" href="<?php print MASTER_URL; ?>images/favicon.ico" type="image/x-icon" />
  
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php print MASTER_URL; ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php print MASTER_URL; ?>assets/bower_components/font-awesome/css/font-awesome.min.css">

  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php print MASTER_URL; ?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php print MASTER_URL; ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  
  <link rel="stylesheet" href="<?php print MASTER_URL; ?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php print MASTER_URL; ?>assets/bower_components/select2/dist/css/select2.min.css">
  
  <link rel="stylesheet" href="<?php print MASTER_URL; ?>assets/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php print MASTER_URL; ?>assets/dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php print MASTER_URL; ?>assets/plugins/iCheck/square/blue.css">
   <link rel="stylesheet" href="<?php print MASTER_URL; ?>assets/plugins/timepicker/bootstrap-timepicker.min.css">
 <!-- Full calendar -->
 <link rel="stylesheet" href="<?php print MASTER_URL; ?>assets/bower_components/fullcalendar-2.3.1/fullcalendar.min.css">


    <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?php print MASTER_URL; ?>assets/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <link rel="stylesheet" href="<?php print MASTER_URL; ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="<?php print MASTER_URL; ?>css/themes/<?php print Settings_model::$db_config['default_theme']; ?>/custom.css?v=<?=strtotime('now')?>" type="text/css" media="screen" />
  <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.js'></script>
  <script src="<?php print MASTER_URL; ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
  <script>var base_url = '<?php echo MASTER_URL ?>';</script>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

	<?php 
	$controller_name = $this->router->fetch_class();
	?>
	<?php
	$this->load->view('generic/js_base_url',array('controller_name'=>$controller_name));
	$this->load->view('generic/js_language_files');
	?>
</head>
<body class="hold-transition skin-blue layout-boxed sidebar-mini">
<div class="modal modal-success fade" id="modal-success">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">SUCCESS!</h4>
		  </div>
		  <div class="modal-body">
			<p>Data Saved Successfully&hellip;</p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-outline"data-dismiss="modal">OK</button>
		  </div>
		</div>
		<!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
	</div>
	
	<div class="modal modal-danger fade" id="modal-danger">
		<div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Error</h4>
			  </div>
			  <div class="modal-body">
				<p></p>
			  </div>
			  <div class="modal-footer">
				<!--<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-outline"data-dismiss="modal">OK</button>-->
			  </div>
			</div>
		<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	  <div class="wrapper" style="background-color:#ecf0f5 !important" >
  	<?php 
    print $template['body'];
   
    ?>
  </div>
  <script src="<?php print MASTER_URL; ?>assets/plugins/jQueryUI/jquery-ui.min.js" type="text/javascript"></script>
  
   
  <!-- Bootstrap 3.3.7 -->
  <script src="<?php print MASTER_URL; ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- Select2 -->
  <script src="<?php print MASTER_URL; ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>
  <!-- FastClick -->
  <script src="<?php print MASTER_URL; ?>assets/bower_components/fastclick/lib/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php print MASTER_URL; ?>assets/dist/js/adminlte.min.js"></script>
  
  <script type="text/javascript" src="<?php print MASTER_URL; ?>js/jquery.cookie.js"></script>
  <script src="<?php print MASTER_URL; ?>assets/plugins/mapplic/js/mapplic.js"></script>  
  <script src="<?php print MASTER_URL; ?>assets/plugins/modernizr.custom.js" type="text/javascript"></script>
  <script src="<?php print MASTER_URL; ?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
   
  <script src="<?php print MASTER_URL; ?>assets/bower_components/ckeditor/ckeditor.js"></script>
  <script src="<?php print MASTER_URL; ?>assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
  <script src="<?php print MASTER_URL; ?>/js/jquery.validate.js" type="text/javascript"></script>
  <script src="<?php print MASTER_URL; ?>assets/plugins/iCheck/icheck.min.js"></script>
  <script src="<?php print MASTER_URL; ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="<?php print MASTER_URL; ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<!-- date-range-picker -->
<script src="<?php print MASTER_URL; ?>assets/bower_components/moment/min/moment.min.js"></script>
<script src="<?php print MASTER_URL; ?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="<?php print MASTER_URL; ?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="<?php print MASTER_URL; ?>assets/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<script src="<?php print MASTER_URL; ?>assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
  <script type="text/javascript" src="<?php echo autoVersioning('js/custom.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo autoVersioning('js/validation.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo autoVersioning('js/system_common.js'); ?>"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?php print MASTER_URL; ?>assets/dist/js/demo.js"></script>

  <!-- Full calendar -->
 <script src="<?php print MASTER_URL; ?>assets/bower_components/fullcalendar-2.3.1/fullcalendar.js"></script>
<script src="<?php print MASTER_URL; ?>assets/bower_components/fullcalendar-columns/fullcalendar-columns.js"></script>

</body>
</html>