<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
} ?>
<style type="text/css">
    .checkbox input[type=checkbox]{
        margin-left: 0;
    }
</style>
<script type="text/javascript" src="<?php print MASTER_URL; ?>js/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo autoVersioning('js/validation.js'); ?>"></script>
<script type="text/javascript" src="<?php echo autoVersioning('js/system_common.js'); ?>"></script>

<div class="content-wrapper">
	<section class="content-header">
    	<ol class="breadcrumb">
			<li><a href="<?=base_url()?>"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line('home'); ?></a></li>
			<li><a><?php echo $this->lang->line('system_config'); ?></a></li>
			<li class="active"><?php echo $this->lang->line('add_config');?></li>
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

			<div class="col-md-12">

				<div class="panel bg-white">
					<?php echo $this->load->view('generic/flash_error'); ?>
					<div class="box-header with-border">
						<h3 class="box-title">
                            <?php 
                              echo $this->lang->line('add_config');
                            ?>
                        </h3>
					</div>

					<div class="panel-body no-border" style="">
					
						<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
							print form_open_multipart('system_config/add_system_config/', array('id' => 'system_config_form_datatable','name'=>'formmain')) ."\r\n";
						?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group form-group-default required">
					                <?php print form_label($this->lang->line('paypal_email'), 'paypal_email'); ?><label><span class="text-red">&nbsp;*</span></label>
					                <?php print form_input(array('placeholder'=> $this->lang->line('paypal_email'), 'name' => 'paypal_email', 'type' => 'email','id' => 'paypal_email', 'class' => 'form-control'  , 'autocomplete' => 'off', 'value' => ($rowdata)?$rowdata['paypal_email']:'')); ?>
					            </div>
                            </div>
                            
                            <div class="col-sm-6">
                                <div class="form-group form-group-default required">
					                <?php print form_label($this->lang->line('sender_email'), 'sender_email'); ?><label><span class="text-red">&nbsp;*</span></label>
					                <?php print form_input(array('placeholder'=> $this->lang->line('sender_email'), 'name' => 'sender_email', 'type' => 'email','id' => 'sender_email', 'class' => 'form-control'  , 'autocomplete' => 'off', 'value' => ($rowdata)?$rowdata['sender_email']:''  )); ?>
					            </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group form-group-default required">
					                <?php print form_label($this->lang->line('receiver_email'), 'receiver_email'); ?><label><span class="text-red">&nbsp;*</span></label>
					                <?php print form_input(array('placeholder'=> $this->lang->line('receiver_email'), 'name' => 'receiver_email','type' => 'email', 'id' => 'receiver_email', 'class' => 'form-control'  , 'autocomplete' => 'off', 'value' => ($rowdata)?$rowdata['receiver_email']:'')); ?>
					            </div>
                            </div>
                            
                            <div class="col-sm-6">
                                <div class="form-group form-group-default required">
					                <?php print form_label($this->lang->line('refund_fees'), 'refund_fees'); ?><label><span class="text-red">&nbsp;*</span></label>
					                <?php print form_input(array('placeholder'=> $this->lang->line('cancellation_fees'), 'name' => 'cancellation_fees', 'id' => 'cancellation_fees', 'class' => 'form-control'  , 'autocomplete' => 'off', 'value' => ($rowdata)?$rowdata['cancellation_fees']:'')); ?>
					            </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group form-group-default required">
					                <?php print form_label($this->lang->line('paypal_processing_fees'), 'paypal_processing_fees'); ?> (%)<label><span class="text-red">&nbsp;*</span></label>
					                <?php print form_input(array('placeholder'=> $this->lang->line('paypal_processing_fees'), 'name' => 'paypal_processing_fees', 'id' => 'paypal_processing_fees', 'class' => 'form-control'  , 'autocomplete' => 'off', 'value' => ($rowdata)?$rowdata['paypal_processing_fees']:'')); ?>
					            </div>
                            </div>
                            
                            <div class="col-sm-6">
                                <div class="form-group form-group-default required">
					                <?php print form_label($this->lang->line('subsidy_claim_reminder_days'), 'subsidy_claim_reminder_days'); ?><label><span class="text-red">&nbsp;*</span></label>
					                <?php print form_input(array('placeholder'=> $this->lang->line('subsidy_claim_reminder_days'), 'name' => 'subsidy_claim_reminder_days', 'id' => 'subsidy_claim_reminder_days', 'class' => 'form-control'  , 'autocomplete' => 'off', 'value' => ($rowdata)?$rowdata['subsidy_claim_reminder_days']:'')); ?>
					            </div>
                            </div>
                            <div class="clear"></div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group form-group-default required">
					                <?php print form_label($this->lang->line('certificate_name'), 'certificate_name'); ?><label><span class="text-red">&nbsp;*</span></label>
					                <?php print form_input(array('placeholder'=> $this->lang->line('certificate_name'), 'name' => 'name', 'id' => 'name', 'class' => 'form-control'  , 'autocomplete' => 'off', 'value' => ($rowdata)?$rowdata['name']:'')); ?>
					            </div>
                            </div>
                            
                            <div class="col-sm-6">
                                <div class="form-group form-group-default required">
					                <?php print form_label($this->lang->line('certificate_address'), 'certificate_address'); ?><label><span class="text-red">&nbsp;*</span></label>
					                <?php print form_textarea(array('name' => 'address','placeholder'=> $this->lang->line('certificate_address'), 'id' => 'address', 'value' => ($rowdata)?$rowdata['address']:$this->session->flashdata('address'), 'class' => 'form-control','maxlength' => '225')); ?>
					            </div>
                            </div>
                            <div class="clear"></div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group form-group-default required">
					                <?php print form_label($this->lang->line('certificate_footer'), 'certificate_footer'); ?><label><span class="text-red">&nbsp;*</span></label>
					                <?php print form_textarea(array('name' => 'certificate_footer','placeholder'=> $this->lang->line('certificate_footer'), 'id' => 'certificate_footer', 'value' => ($rowdata)?$rowdata['certificate_footer']:$this->session->flashdata('certificate_footer'), 'class' => 'form-control','maxlength' => '225')); ?>
					                
					            </div>
                            </div>
                            <div class="clear"></div>
                        </div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="box-footer">
								<button type="submit" id="system_config_submit" class="btn btn-info footer_btn save_btn"><?= $this->lang->line('save') ?></button> 
							</div>
						</div>	     
					</div>
				<?php print form_close() . "\r\n"; ?>
				</div>
			</div>
		</div>
	</section>
</div>


