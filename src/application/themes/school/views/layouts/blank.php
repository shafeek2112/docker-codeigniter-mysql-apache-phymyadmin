<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php print $template['title']; ?> | Wavelink Maritime</title>
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

  <link rel="stylesheet" href="<?php print MASTER_URL; ?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
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
  <script >var base_url = '<?php echo MASTER_URL ?>'; var filter_col_data = new Array();</script>
  <script>

    var base_url = '<?php echo MASTER_URL ?>'; 
    var filter_col_data = new Array();
    $(document).ready(function() {
     $.extend( true, $.fn.dataTable.defaults, {

            "bStateSave": true,
            fnStandingRedraw : true,
            "dom": "Cl <'table-responsive'rt><'row'<'col-sm-5'i> <'col-sm-7'p>>",     
            iDisplayLength: 25,
            "order": [[ 0, "desc" ]]
            
      });
  });
  
  </script>
    <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
           <div class="modal-content">
             <div class="modal-header">
                <h4>Loading....</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button><br />
              </div>
              <div class="modal-body"><div style="text-align:center;"><i class="fa fa-spinner fa fa-5x fa-spin" id="animate-icon"></i></div></div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div> 
          </div>
        </div>

        <div class="modal fade modal-child" id="modal-large" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog" style="width : 50% !important;">
           <div class="modal-content">
             <div class="modal-header">
                <h4>Loading....</h4>
                <button type="button" class="close cancel_slot_event" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button><br />
              </div>
              <div class="modal-body"><div style="text-align:center;"><i class="fa fa-spinner fa fa-5x fa-spin" id="animate-icon"></i></div></div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default cancel_slot_event" data-dismiss="modal">Close</button>
              </div>
            </div> 
          </div>
        </div>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  
  
   <link rel="stylesheet" href="<?php print MASTER_URL; ?>assets/plugins/FixedHeader/css/fixedHeader.bootstrap.min.css">
   

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

	<?php 
	$controller_name = $this->router->fetch_class();
	?>
	<?php
	$this->load->view('generic/js_base_url',array('controller_name'=>$controller_name));
	$this->load->view('generic/js_language_files');
	?>
</head>
<?php
$page_title = '';
$breadcrumb_arr = array();
$arrMenu = get_rolewise_priviledge();
if($arrMenu){
  /*foreach ($arrMenu as $key => $val){
    foreach ($arrMenu[$key]['sub_menu'] as $key1 => $val1){
      foreach ($val1 as $key2 => $val2){
        if($controller_name == $key2){
          $page_title = $this->lang->line($key);
          $breadcrumb_arr[] = array('title' => $page_title,'link' => '');
        }
      }
    }

    if(isset($arrMenu[$key]['sub_menu']) && $arrMenu[$key]['parent_id'] != '0'){
      foreach ($arrMenu[$key]['sub_menu'] as $key1 => $val1){ 
        foreach ($val1 as $key2 => $val2){ 
          $current = "";
          if($controller_name == $key2){
            $page_title = $this->lang->line($val2);
            $breadcrumb_arr[] = array('title' => $page_title,'link' => $key2);
          }
        }
      }
    }
  }*/
} 
if($controller_name == "profile") {
  $page_title = 'Profile';
  $breadcrumb_arr[] = array('title' => $page_title,'link' =>'');
}
if($controller_name == "login" || $controller_name == "client_login" || $controller_name == "teacher_login" ) { ?>
    <body class="hold-transition login-page"> <?php
  }else { ?>
    <body class="hold-transition skin-blue sidebar-mini"> <?php
  }
?>
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

  <div class="wrapper">
  	<?php 
    // print $template['partials']['header'];

    // print $template['partials']['sidebar'];
    print $template['body'];
    // print $template['partials']['footer'];
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
  <script src="<?php print MASTER_URL; ?>/js/additional-methods.js" type="text/javascript"></script>
  <script src="<?php print MASTER_URL; ?>assets/plugins/iCheck/icheck.min.js"></script>
  <script src="<?php print MASTER_URL; ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="<?php print MASTER_URL; ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<!-- date-range-picker -->
<script src="<?php print MASTER_URL; ?>assets/bower_components/moment/min/moment.min.js"></script>
<script src="<?php print MASTER_URL; ?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php print MASTER_URL; ?>assets\bower_components\bootstrap-notify-master\bootstrap-notify.js"></script>

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


  <!-- Dashboard Chart-->
<script src="<?php print MASTER_URL; ?>assets/bower_components/chart.js/Chart.js"></script>



<script src="<?php print MASTER_URL; ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
 <script src="<?php print MASTER_URL; ?>assets/plugins/FixedHeader/js/dataTables.fixedHeader.min.js"></script>

<script type="text/javascript" src="<?php print MASTER_URL; ?>js/fnStandingRedraw.js"></script>
<script type="text/javascript" src="<?php print MASTER_URL; ?>js/js-signature.js"></script>
  
</body>
</html>
<script type="text/javascript">
  
</script>