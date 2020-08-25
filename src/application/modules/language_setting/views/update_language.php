<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
} ?>
<style type="text/css">
    .checkbox input[type=checkbox]{
        margin-left: 0;
    }
</style>
<div class="content-wrapper">
	<section class="content-header">
    	<ol class="breadcrumb">
			<li><a href="<?=base_url()?>"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line('home'); ?></a></li>
			<li><?php echo $this->lang->line('settings'); ?></li>
			<li><a href="<?=base_url()?>language_setting"><?php echo $this->lang->line('language_setting'); ?></a></li>
			<li class="active"><?php echo $this->lang->line('bulk_update'); ?></li>
		</ol>
	</section>
	
	<section class="content">
	<div class="row">
        <div class="col-xs-12">
            <div class="box-header">
              <!--  -->
             </div>   
         </div>
      </div>
	<div class="row">
		
		<div class="col-md-8">

			<div class="panel bg-white">
				<?php echo $this->load->view('generic/flash_error'); ?>
				<div class="panel-heading">
					<div class="panel-title"><h3><?php echo $this->lang->line('bulk_update'); ?></h3></div>
				</div>
				<div class="panel-body no-border" style="">
					<?php
						print form_open_multipart('language_setting/export_to_excel/', array('id' => 'export_file','name'=>'formmain', 'target'=>'download_iframe','class' => 'pull-left')) ."\r\n";
					?>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group form-group-default">
									<?php print form_label($this->lang->line('language_bulk_update_step1'), 'language_bulk_update_step1'); ?>
									<?php print form_submit(array('name' => 'submit','id' => 'submit', 'value' => $this->lang->line('export_xls'),
										'class' => 'btn btn-info','style'=>'display: block;'))."<br />\r\n"; ?> 
								
							</div>
						</div>
					</div>
					<?php 
						print form_close() . "\r\n";
					?>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group form-group-default">
									<?php print form_label($this->lang->line('language_bulk_update_step2'), 'language_bulk_update_step2'); ?>
							</div>
						</div>
					</div>
					<?php
					print form_open_multipart('language_setting/bulk_update/', array('id' => 'update_language_form','name'=>'formmain')) ."\r\n";
					?>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group form-group-default">
								<?php print form_label($this->lang->line('language_bulk_update_step3'), 'language_bulk_update_step3'); ?>
								<?php print  form_upload(array('name' => 'csvfile', 'id' => 'csvfile', 'value' => '', 'required' => 'required')); ?>
							</div>
						</div>
						<div class="clear"></div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<br/>
								<a href="<?=base_url('language_setting')?>" class="btn btn-default footer_btn" ><?php echo $this->lang->line('back'); ?></a>
								<a  href="javascript:void(0)" class="btn btn-default btn_reload footer_btn"><?=$this->lang->line('cancel')?></a>
								<?php print form_submit(array('name' => 'add_privilege_submit','id' => 'language_setting_submit', 'value' => $this->lang->line('submit'),'class' => 'btn btn-primary footer_btn')) . "<br />\r\n"; ?> 
							</div>
						</div>
					</div>

					<?php print form_close() . "\r\n"; ?>
				</div>
			</div>
		</div>
		<div class="col-md-4">&nbsp;</div>
	</div>
	</section>
</div>