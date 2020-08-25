<script type="text/javascript" src="<?php print MASTER_URL; ?>js/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo autoVersioning('js/validation.js'); ?>"></script>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
print form_open('language_setting/add/'.$id, array('id' => 'add_language_datatable','name'=>'formmain')) ."\r\n";
?>
<div class="modal-header clearfix text-left">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	<h4 class="modal-title"><?php echo $this->lang->line('edit_language'); ?></h4>
</div>
<div class="modal-body">
	<?php $this->load->view('generic/flash_error'); ?>
	<div class="containerfdfdf"></div>
	
	<div class="row">
        <div class="col-sm-12">
            <div class="form-group form-group-default ">
                <?php print form_label($this->lang->line('lang_key_info'), 'lang_key_info'); ?>
                <?php print form_input(array('name' => 'lang_key_info', 'id' => 'lang_key_info', 'value' => ($rowdata) ? $rowdata->lang_key_info : $this->session->flashdata('lang_key_info'), 'class' => 'form-control', 'readonly' => 'readonly')); ?>
            </div>
        </div>
        <div class="clear"></div>
    </div>	
	
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group form-group-default ">
                <?php print form_label($this->lang->line('english'), 'english'); ?>
                <?php print form_input(array('name' => 'english', 'id' => 'english', 'value' => ($rowdata) ? $rowdata->english : $this->session->flashdata('english'), 'class' => 'form-control')); ?>
            </div>
        </div>
        <div class="clear"></div>
    </div>	
	
	<div class="row">
        <div class="col-sm-12">
            <div class="form-group form-group-default ">
                <?php print form_label($this->lang->line('chinese'), 'chinese'); ?>
                <?php print form_input(array('name' => 'chinese', 'id' => 'chinese', 'value' => ($rowdata) ? $rowdata->chinese : $this->session->flashdata('chinese'), 'class' => 'form-control')); ?>
            </div>
        </div>
        <div class="clear"></div>
    </div>
	<div class="row">
        <div class="col-sm-12">
            <div class="form-group form-group-default ">
                <?php print form_label($this->lang->line('thai'), 'thai'); ?>
                <?php print form_input(array('name' => 'thai', 'id' => 'thai', 'value' => ($rowdata) ? $rowdata->thai : $this->session->flashdata('thai'), 'class' => 'form-control')); ?>
            </div>
        </div>
        <div class="clear"></div>
    </div>
	<div class="row">
        <div class="col-sm-12">
            <div class="form-group form-group-default ">
                <?php print form_label($this->lang->line('vietnamese'), 'vietnamese'); ?>
                <?php print form_input(array('name' => 'vietnamese', 'id' => 'vietnamese', 'value' => ($rowdata) ? $rowdata->vietnamese : $this->session->flashdata('vietnamese'), 'class' => 'form-control')); ?>
            </div>
        </div>
        <div class="clear"></div>
    </div>
	<div class="row">
        <div class="col-sm-12">
            <div class="form-group form-group-default ">
                <?php print form_label($this->lang->line('filipino'), 'filipino'); ?>
                <?php print form_input(array('name' => 'filipino', 'id' => 'filipino', 'value' => ($rowdata) ? $rowdata->filipino : $this->session->flashdata('filipino'), 'class' => 'form-control')); ?>
            </div>
        </div>
        <div class="clear"></div>
    </div>
	<div class="row">
        <div class="col-sm-12">
            <div class="form-group form-group-default ">
                <?php print form_label($this->lang->line('burmese'), 'burmese'); ?>
                <?php print form_input(array('name' => 'burmese', 'id' => 'burmese', 'value' => ($rowdata) ? $rowdata->burmese : $this->session->flashdata('burmese'), 'class' => 'form-control')); ?>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
	<input type="hidden" name="user_id" value="<?=$id?>">
	<input type="submit" name="student_submit" id="lang_submit" value="<?php echo $this->lang->line('edit'); ?>" class="btn btn-primary pull-left popup_button"/>
</div>	
<?php	
print form_close() ."\r\n";
?>
