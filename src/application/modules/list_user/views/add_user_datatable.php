<script type="text/javascript" src="<?php print MASTER_URL; ?>js/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo autoVersioning('js/validation.js'); ?>"></script>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
print form_open('list_user/add/'.$id, array('id' => 'add_user_form_datatable','name'=>'formmain')) ."\r\n";
?>
<div class="modal-header clearfix text-left">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	<h4 class="modal-title"><?php if(!$id){ echo $this->lang->line('add_user'); }else{ echo $this->lang->line('edit_user'); } ?></h4>
</div>
<div class="modal-body">
	<?php $this->load->view('generic/flash_error'); ?>
	<div class="containerfdfdf"></div>
    <div class="row">
        <div class="col-sm-4">
        	<input type="hidden" name="u_id" id="u_id" value="<?php echo   ($id) ? $id : ''; ?>">
            <div class="form-group form-group-default required">
                <?php print form_label($this->lang->line('user_p_first_name'), 'reg_first_name'); ?><label><span class="text-red">&nbsp;*</span></label>
                <?php print form_input(array('name' => 'first_name', 'id' => 'reg_first_name', 'value' => ($rowdata) ? $rowdata->first_name : $this->session->flashdata('first_name'), 'class' => 'form-control','maxlength'=>'255')); ?>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group form-group-default ">
                <?php print form_label($this->lang->line('user_p_middle_name'), 'reg_middle_name'); ?>
                <?php print form_input(array('name' => 'middle_name', 'id' => 'reg_middle_name', 'value' => ($rowdata) ? $rowdata->middle_name : $this->session->flashdata('middle_name'), 'class' => 'form-control','maxlength'=>'255')); ?>
            </div>
        </div>
        
        <div class="col-sm-4">
            <div class="form-group form-group-default required">
                <?php print form_label($this->lang->line('user_p_last_name'), 'reg_last_name'); ?><label><span class="text-red">&nbsp;*</span></label>
                <?php print form_input(array('name' => 'last_name', 'id' => 'reg_last_name', 'value' => ($rowdata) ? $rowdata->last_name : $this->session->flashdata('last_name'), 'class' => 'form-control','maxlength'=>'255')); ?>
            </div>
        </div>
        <div class="clear"></div>
    </div>	
	<div class="row">
		
		<div class="col-sm-6">
			<div class="form-group form-group-default required">
				<?php print form_label($this->lang->line('user_p_email_address'), 'reg_email'); ?><label><span class="text-red">&nbsp;*</span></label>
				<?php print form_input(array('name' => 'email', 'id' => 'email', 'value' => ($rowdata)?$rowdata->email:$this->session->flashdata('email'), 'class' => 'form-control','maxlength'=>'50')); ?>
			</div>
		</div>

		<div class="col-sm-6">
            <div class="form-group form-group-default">
            	<?php print form_label($this->lang->line('email_2'), 'email_2'); ?>
            	<?php print form_input(array('name' => 'email_2', 'id' => 'email_2', 'value' => ($rowdata) ? $rowdata->email_2 : $this->session->flashdata('email_2'), 'class' => 'form-control','maxlength'=>'50')); ?>
            </div>
        </div>
		<div class="clear"></div>
	</div>
	<div class="row">            
        <div class="col-sm-6">
			<div class="form-group form-group-default form-group-default-select2">
				<?php print form_label($this->lang->line('gender'), 'gender'); ?>
				<?php  print form_dropdown('gender',$gender_list,($rowdata)?$rowdata->gender:'0','id="gender" class="form-control"'); ?>
            </div>
		</div>
		<div class="col-sm-6">
			<div class="form-group form-group-default input-group col-sm-12">
				<?php print form_label($this->lang->line('user_p_birth_date'), 'birth_date'); ?>
				<?php print form_input(array('name' => 'birth_date', 'id' => 'show_dp', 'value' => ($rowdata)?make_dp_date($rowdata->birth_date):$this->session->flashdata('birth_date'), 'class' => 'form-control')); ?>
				<!-- <span class="input-group-addon"><i class="fa fa-calendar"></i></span> -->
			</div>
		</div>
		<div class="clear"></div>
	</div>
	
	<div class="row">            
        <div class="col-sm-12">
			<div class="form-group form-group-default input-group col-sm-12">
				<?php print form_label($this->lang->line('system_display_date_format'), 'system_display_date_format'); ?>
				<select name="user_system_date_format" id="user_system_date_format" class="form-control Select2PresetDateFormat" maxlength='30'>
					<option value="<?= (!empty($rowdata) && !empty($rowdata->user_system_date_format))?$rowdata->user_system_date_format:"Y-m-d H:i:s"?>"><?= ($rowdata)?preset_date_format($rowdata->user_system_date_format,1):"" ?></option>
				</select>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	
	<div class="row">            
		<div class="col-sm-4">
			<div class="form-group form-group-default ">
				<?php print form_label($this->lang->line('contact_no_1'), 'reg_contact_number_1'); ?>
				<?php print form_input(array('name' => 'contact_number_1', 'id' => 'reg_contact_number_1', 'value' => ($rowdata)?$rowdata->contact_number_1:$this->session->flashdata('contact_number_1'), 'class' => 'form-control','maxlength'=>'10')); ?>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group form-group-default ">
				<?php print form_label($this->lang->line('contact_no_2'), 'reg_contact_number_2'); ?>
				<?php print form_input(array('name' => 'contact_number_2', 'id' => 'reg_contact_number_2', 'value' => ($rowdata)?$rowdata->contact_number_2:$this->session->flashdata('contact_number_2'), 'class' => 'form-control','maxlength'=>'10')); ?>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group form-group-default form-group-default-select2 required">
				<?php print form_label($this->lang->line('user_p_role'), 'reg_user_roll_id'); ?><label><span class="text-red">&nbsp;*</span></label>
				<?php  print form_dropdown('user_roll_id',$other_user_roll,($rowdata)?$rowdata->user_roll_id:'1','id="user_roll_id" class="form-control" disabled="disabled"'); ?>
				<input type="hidden" name="user_roll_id" value="<?php if(!empty($rowdata)){ echo $rowdata->user_roll_id; } else { echo '1'; }  ?>">
            </div>
		</div>
		<div class="clear"></div>
	</div>
	<?php if(!$id){ ?>
	<div class="row">
		<div class="col-sm-4">
			<div class="form-group form-group-default required">
				<?php print form_label($this->lang->line('user_p_username'), 'reg_username'); ?><label><span class="text-red">&nbsp;*</span></label>
				<?php print form_input(array('name' => 'username', 'id' => 'reg_username', 'value' => ($rowdata)?$rowdata->username:$this->session->flashdata('username'), 'class' => 'form-control qtip_username','maxlength'=>'255')); ?>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group form-group-default required">
				<?php print form_label($this->lang->line('password'), 'reg_password'); ?><label><span class="text-red">&nbsp;*</span></label>
				<?php print form_password(array('name' => 'password', 'id' => 'reg_password', 'class' => 'form-control qtip_password')); ?>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group form-group-default required">
				<?php print form_label($this->lang->line('confirm_password'), 'password_confirm'); ?><label><span class="text-red">&nbsp;*</span></label>
				<?php print form_password(array('name' => 'password_confirm', 'id' => 'password_confirm', 'class' => 'form-control')); ?>
			</div>
		</div>	
		<div class="clear"></div>
	</div>
	<?php } ?>
	<?php if($id){ ?>
	<div id="error_div"></div>
	<div id="message_div"></div>
	<div class="row">
		<div class="col-sm-4">
			<div class="form-group form-group-default required">
				<?php print form_label($this->lang->line('password'), 'reg_password'); ?><label><span class="text-red">&nbsp;*</span></label>
				<?php print form_password(array('name' => 'user_password', 'id' => 'user_password', 'class' => 'form-control qtip_password')); ?>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group form-group-default required">
				<?php print form_label($this->lang->line('confirm_password'), 'password_confirm'); ?><label><span class="text-red">&nbsp;*</span></label>
				<?php print form_password(array('name' => 'user_password_confirm', 'id' => 'user_password_confirm', 'class' => 'form-control')); ?>
			</div>
		</div>	
		<div class="col-sm-4">
			<input type="submit" name="btn_user_password_update" id="btn_user_password_update" value="Update Password" class="btn btn-primary"/>
		</div>	
		<div class="clear"></div>
	</div>
	<?php } ?>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	<input type="hidden" name="user_id" value="<?=$id?>">
	<input type="submit" name="student_submit" id="user_submit" value="<?php if(!$id){ echo $this->lang->line('save'); }else{ echo $this->lang->line('update'); } ?>" class="pull-left popup_button btn btn-primary"/>
</div>	
<?php	
print form_close() ."\r\n";
?>
<script>
  $(function () {
    
    //Date picker
    $('#show_dp').datepicker({
     autoclose: true,
      format:'D,dd MM yyyy'
    })

  
  })
</script>