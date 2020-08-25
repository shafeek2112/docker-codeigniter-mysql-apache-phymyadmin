<script type="text/javascript" src="<?php print MASTER_URL; ?>js/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo autoVersioning('js/validation.js'); ?>"></script>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
print form_open( base_url('student/change_password/'.$id) , array('id' => 'add_change_password_form_datatable','name'=>'formmain')) ."\r\n";
?>	
<div class="modal-header clearfix text-left">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	<h4 class="modal-title"><?php echo $this->lang->line('change_password'); ?></h4>
</div>
<div class="modal-body">
	<?php $this->load->view('generic/flash_error'); ?>
	<div class="containerfdfdf"></div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group form-group-default required">
                <label><?php print form_label($this->lang->line('password'), 'password'); ?> <span class="text-red">&nbsp;*</span></label>
                <?php print form_input(array('name' => 'password', 'id' => 'password','class' => 'form-control','type'=>'password')); ?>
            </div>
        </div>
        <div class="col-sm-6">
			<div class="form-group form-group-default required">
				<label><?php print form_label($this->lang->line('confirm_password'), 'confirm_password'); ?><span class="text-red">&nbsp;*</span> </label>
                <?php print form_input(array('name' => 'confirm_password', 'id' => 'confirm_password', 'class' => 'form-control','type'=>'password')); ?>
              
			</div>
		</div>

        <div class="clear"></div>
    </div>	
</div>

	
<div class="modal-footer">
	<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	<input type="hidden" name="user_id" value="<?=$id?>">
	<input type="submit" name="student_submit" id="change_submit" value="<?php echo $this->lang->line('save'); ?>" class="btn btn-primary"/>
</div>	
<?php	
print form_close() ."\r\n";
?>