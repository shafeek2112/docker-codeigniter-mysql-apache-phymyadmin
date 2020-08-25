<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
$search_data = $this->session->userdata('language_export_var');
?>
<script type="text/javascript">
  var filter_col_data = new Array();
  <?php
  if (is_array($search_data) && isset($search_data['global_search'])) {
    unset($search_data['global_search']);
  }
  if (is_array($search_data) && count($search_data) > 0) {
    ?>
    <?php
    foreach ($search_data as $filter_col => $filter_col_value) {
      if (!empty($filter_col)) { ?>
        filter_col_data.push({'filter_col' : '<?php echo $filter_col?>','filter_col_value' : '<?php echo $filter_col_value?>'});
        <?php
      }
    }
    ?>
    <?php
  }
  ?>
</script>
<script type="text/javascript" src="<?php print MASTER_URL; ?>js/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo autoVersioning('js/grid/language_setting.js'); ?>"></script>
<div class="content-wrapper">
	<section class="content-header">
    	<ol class="breadcrumb">
			<li><a href="<?=base_url()?>"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line('home'); ?></a></li>
			<li><?php echo $this->lang->line('settings'); ?></li>
			<li class="active"><?php echo $this->lang->line('language_setting'); ?></li>
		</ol>
	</section>
	
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <div class="box-header">
              
             </div>   
         </div>
      </div>
      
        <div class="row">
        <div class="col-xs-12">
             <div class="box">
                 <div class="box-header">
                    <h3 class="box-title"> <?php echo $this->lang->line('language_setting'); ?></h3>
                      <div class="box-tools pull-right">
                        <?php
                        if($this->session->userdata('role_id') == '1' || in_array("add",$this->arrAction)) { ?>
                          <a href="<?php echo base_url(); ?>language_setting/update" class="btn btn-success margin-r-5"><?php echo $this->lang->line('update'); ?> <i class="fa fa-plus"></i></a>
                            <?php
                        }
                        if($this->session->userdata('role_id') == '1' || in_array("export_xls",$this->arrAction)) { ?>
                                     <?php
                          print form_open_multipart('language_setting/export_to_excel/', array('id' => 'export_file','name'=>'formmain', 'target'=>'download_iframe','class' => 'pull-right')) ."\r\n";
                          ?>
                            <input type="submit" name="submit" value="<?php echo $this->lang->line('export_xls'); ?>" class="btn btn-info pull-right">
                      <?php print form_close() . "\r\n"; ?> <?php 
                        } ?>
                     </div>
                  </div>

            <div class="box-body">
				<div class="row form-group">
                    <div class="col-md-4">
                        <div class="form-group form-group-default required">    
                          <!--   <input type="text" name="lang_key_info" id="lang_key_info" class="from form-control filter" data-column = '1' placeholder=""> -->
                             <?php print form_input(array('name' => 'lang_key_info','class' => 'form-control filter', 'placeholder' => $this->lang->line('lang_key_info') , 'data-column' => '2','value' => (is_array($search_data)&&isset($search_data['lang_key_info']))?$search_data['lang_key_info']:'', 'id' => 'lang_key_info')); ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                      <a href="<?php echo base_url('language_setting/clear_language'); ?>" class="btn btn-warning margin-r-5" ><?php echo $this->lang->line('clearFilter'); ?></a>
                    </div>
                </div>
              <table  id="grid_other_language_setting" class="table table-bordered table-striped">
                <thead>
                <tr>
                  	<th>#</th>
                    <th></th>
                    <th><?php echo $this->lang->line('lang_key_info'); ?></th>
                    <th><?php echo $this->lang->line('english'); ?></th>
                    <th><?php echo $this->lang->line('chinese'); ?></th>
                    <th><?php echo $this->lang->line('thai'); ?></th>
                    <th><?php echo $this->lang->line('vietnamese'); ?></th>
                    <th><?php echo $this->lang->line('filipino'); ?></th>
                    <th><?php echo $this->lang->line('burmese'); ?></th>
                    
                </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>