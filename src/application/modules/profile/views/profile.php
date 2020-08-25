<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 


$arrListUserAction = get_priviledge_action("list_user","",false);
?>
<script>

var add_default_box = true;

<?php 

if($user_id > 0){ ?>

	add_default_box = false;

	<?php

}?>

</script>
<script type="text/javascript" src="<?php print MASTER_URL; ?>js/jquery.form.js"></script>


  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<section class="content-header">
    	<ol class="breadcrumb">
			<li><a href="<?=base_url()?>"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line('home'); ?></a></li>
			<li><?php echo $this->lang->line('users'); ?></li>
			<li><a href="<?=base_url()?>list_user"><?php echo $this->lang->line('user_p_heading'); ?></a></li>
			<li class="active"><?php echo $this->lang->line('user_profile'); ?></li>
		</ol>
	</section>
	
 <?php $this->load->view('generic/flash_error'); ?>
    <!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box-header">
				  <!--  -->
				 </div>   
			</div>
		</div>
	  
      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">

     <!--          <img class="profile-user-img img-responsive img-circle" src="../../dist/img/user4-128x128.jpg" alt="User profile picture">

              <h3 class="profile-username text-center">Nina Mcintire</h3>

              <p class="text-muted text-center">Software Engineer</p>

              <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
                        <?php
          print form_open('profile/upload_profile_pic/'.$user_id.'/0', array('id' => 'uploadpic_form')) ."\r\n";
            print form_upload(array('name' => 'uploadpic', 'id' => 'uploadpic', 'value' => '', 'onchange'=>'previewUploadImg(this)', 'style'=>'display:none;'));
          print form_close(); ?>
          <div class="form-group">
            <div class="fileinput fileinput-new" data-provides="fileinput">
            <img src="<?php  
              if(isset($profile_picture_75)){
              
                echo $profile_picture_75; }
              else{ 
                echo base_url('images/noimage.jpg'); } ?>" class="profile-user-img img-responsive img-circle" alt="User Image">

                <h3 class="profile-username text-center"><?php echo $user_data->first_name.' '.$user_data->middle_name.' '.$user_data->last_name; ?></h3>                  
                            
              <a href="javascript:void(0)" class="btn btn-primary btn-block" onclick="changepic();"><?php print $this->lang->line('pro_p_change_pic'); ?></a>
            </div><br>
            </div>
          </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#settings"  data-toggle="tab"><?php echo $this->lang->line('personal_info'); ?></a></li>
              <li><a href="#edit_settings"  data-toggle="tab"><?php echo $this->lang->line('settings'); ?></a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="settings" aria-expanded="true">
             
              <?php print form_open('profile/update_account/0', array('id' => 'profile_form','class' => 'form-horizontal')) ."\r\n"; ?>
                  <div class="form-group">
                      <?php
                      $attributes = array(
                       'class' => 'col-sm-3 control-label', // external or internal css
                        );
                      ?>
                   <?php print form_label($this->lang->line('user_p_username'), 'reg_username',$attributes); ?>
              
                    <div class="col-sm-9">
                         <?php print form_input(array('name' => 'reg_username', 'id' => 'reg_username', 'value' => ($user_data) ? $user_data->username : $this->session->flashdata('username'), 'class' => 'form-control','readonly'=>'readonly','maxlength'=>'255')); ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <?php
                      $attributes = array(
                       'class' => 'col-sm-3 control-label', // external or internal css
                        );
                      ?>
                     <?php print form_label($this->lang->line('user_p_first_name'), 'reg_first_name',$attributes); ?>
                    <div class="col-sm-9">
                        <?php print form_input(array('name' => 'first_name', 'id' => 'reg_first_name', 'value' => ($user_data) ? $user_data->first_name : $this->session->flashdata('first_name'), 'class' => 'form-control','maxlength'=>'255')); ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <?php
                      $attributes = array(
                       'class' => 'col-sm-3 control-label', // external or internal css
                        );
                      ?>
                    <?php print form_label($this->lang->line('user_p_middle_name'), 'reg_middle_name',$attributes); ?>
                    <div class="col-sm-9">
                      <?php print form_input(array('name' => 'middle_name', 'id' => 'reg_middle_name', 'value' => ($user_data) ? $user_data->middle_name : $this->session->flashdata('middle_name'), 'class' => 'form-control','maxlength'=>'255')); ?>
                    </div>
                  </div>
                  <div class="form-group">
                        <?php
                      $attributes = array(
                       'class' => 'col-sm-3 control-label', // external or internal css
                        );
                      ?>
                     <?php print form_label($this->lang->line('user_p_last_name'), 'reg_last_name',$attributes); ?>
                    <div class="col-sm-9">
                      <?php print form_input(array('name' => 'last_name', 'id' => 'reg_last_name', 'value' => ($user_data) ? $user_data->last_name : $this->session->flashdata('last_name'), 'class' => 'form-control','maxlength'=>'255')); ?>
                  </div>
                </div>
                <div class="form-group">
                         <?php
                      $attributes = array(
                       'class' => 'col-sm-3 control-label', // external or internal css
                        );
                      ?>
                  <?php print form_label('Gender', 'gender',$attributes); ?>
                  <div class="col-sm-9">
                 <?php  print form_dropdown('gender',$gender_list,($user_data)?$user_data->gender:'0','id="gender" class="form-control select2"'); ?>
                    </div>
                <!-- /.input group -->
                  </div>
                  <div class="form-group">
                            <?php
                      $attributes = array(
                       'class' => 'col-sm-3 control-label' // external or internal css
                
                        );
                      ?>
                    <?php print form_label($this->lang->line('user_p_birth_date'), 'birth_date',$attributes); ?>
                    <div class="col-sm-9">
                      <?php print form_input(array('name' => 'birth_date', 'id' => 'show_dp', 'value' => ($user_data)?make_dp_date($user_data->birth_date):$this->session->flashdata('birth_date'), 'class' => 'form-control','id' => 'datepicker')); ?>
                    </div>
                  </div>
                    <div class="form-group">
                                   <?php
                      $attributes = array(
                       'class' => 'col-sm-3 control-label' // external or internal css
                
                        );
                      ?>
                      <?php print form_label($this->lang->line('user_p_email_address'), 'reg_email',$attributes); ?>
                    <div class="col-sm-9">
                       <?php print form_input(array('name' => 'email', 'id' => 'reg_email', 'value' => ($user_data)?$user_data->email:$this->session->flashdata('email'), 'class' => 'form-control')); ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <?php
                      $attributes = array(
                       'class' => 'col-sm-3 control-label' // external or internal css
                
                        );
                      ?>
                    <?php print form_label('Email 2', 'email_2',$attributes); ?>
                    <div class="col-sm-9">
                      <?php print form_input(array('name' => 'email_2', 'id' => 'email_2', 'value' => ($user_data) ? $user_data->email_2 : $this->session->flashdata('email_2'), 'class' => 'form-control')); ?>
                    </div>
                  </div>
                  <div class="form-group">
                        <?php
                      $attributes = array(
                       'class' => 'col-sm-3 control-label' // external or internal css
                
                        );
                      ?>
                     <?php print form_label('Contact number 1', 'reg_contact_number_1',$attributes); ?>
                    <div class="col-sm-9">
                       <?php print form_input(array('name' => 'contact_number_1', 'id' => 'reg_contact_number_1', 'value' => ($user_data)?$user_data->contact_number_1:$this->session->flashdata('contact_number_1'), 'class' => 'form-control','maxlength'=>"50")); ?>
                     
                    </div>
                  </div>
                   <div class="form-group">
                              <?php
                      $attributes = array(
                       'class' => 'col-sm-3 control-label' // external or internal css
                
                        );
                      ?>
                    <?php print form_label('Contact number 2', 'reg_contact_number_2',$attributes); ?>
                    <div class="col-sm-9">
                       <?php print form_input(array('name' => 'contact_number_2', 'id' => 'reg_contact_number_2', 'value' => ($user_data)?$user_data->contact_number_2:$this->session->flashdata('contact_number_2'), 'class' => 'form-control','maxlength'=>"50")); ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <?php
                      $attributes = array(
                       'class' => 'col-sm-3 control-label' // external or internal css
                
                        );
                      ?>
                    <?php print form_label('Nationality', 'nationality',$attributes); ?>
                    <div class="col-sm-9">
                        <?php  print form_dropdown('nationality',$nationality_list,($user_data)?$user_data->nationality:'0','id="nationality" class="full-width form-control"'); ?>
                    </div>
                  </div>
                  <div class="form-group">
                               <?php
                      $attributes = array(
                       'class' => 'col-sm-3 control-label' // external or internal css
                
                        );
                      ?>
                    <?php print form_label('Marital Status', 'marital_status',$attributes); ?>
                    <div class="col-sm-9">
                      <?php print form_input(array('name' => 'marital_status', 'id' => 'marital_status', 'value' => ($user_data)?$user_data->marital_status:$this->session->flashdata('marital_status'), 'class' => 'form-control','maxlength'=>"10")); ?>
                     
                    </div>
                  </div>
                    <div class="form-group">
                    <?php
                      $attributes = array(
                       'class' => 'col-sm-3 control-label' // external or internal css
                
                        );
                      ?>
                       <?php print form_label('Skype ID', 'skype_id',$attributes); ?>
                    <div class="col-sm-9">
                       <?php print form_input(array('name' => 'skype_id', 'id' => 'skype_id', 'value' => ($user_data)?$user_data->skype_id:$this->session->flashdata('skype_id'), 'class' => 'form-control')); ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <?php
                      $attributes = array(
                       'class' => 'col-sm-3 control-label' // external or internal css
                
                        );
                      ?>
                       <?php print form_label('Notes', 'notes',$attributes); ?>
                    <div class="col-sm-9">
                       <?php print form_input(array('name' => 'notes', 'id' => 'notes', 'value' => ($user_data)?$user_data->notes:$this->session->flashdata('notes'), 'class' => 'form-control')); ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <?php print form_hidden('user_id', $user_id); ?>
                      <!-- <button type="submit" class="btn btn-danger">Submit</button> -->
                      <input type="submit" name="submit" id="profile_submit" value="<?php echo $this->lang->line('submit');?>" class="btn btn-primary btn-cons pull-right">
                    </div>
                  </div>
              <!--   </form> -->
                <?php print form_close(); ?>
              </div>
			  
			  <div class="tab-pane" id="edit_settings" aria-expanded="true">
				<?php print form_open('profile/update_settings', array('id' => 'profile_form_update','class' => 'form-horizontal')) ."\r\n"; ?>
				<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
				
				<div class="form-group">        
						<?php
						$attributes = array(
                       'class' => 'col-sm-3 control-label' // external or internal css
                
                        );
						
                      ?>
						<?php print form_label($this->lang->line('system_display_date_format'), 'system_display_date_format',$attributes); ?>
					<div class="col-sm-6">
						<select name="user_system_date_format" id="user_system_date_format" class="form-control Select2PresetDateFormat" style="width:100% !important;">
							<option value="<?= (!empty($user_system_date_format))?$user_system_date_format:"Y-m-d H:i:s"?>"><?php echo preset_date_format($user_system_date_format,1); ?></option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-3">
					
					</div>
					<div class="col-sm-6">
						<input type="submit" name="update_user_setting" id="update_user_setting" value="<?php echo $this->lang->line('update') ?>" class="btn btn-primary"/>
					</div>
				</div>
				
				<?php print form_close(); ?>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
<script>
  $(function () {
    
    //Date picker
    $('#datepicker').datepicker({
     autoclose: true,
      format:'D,dd MM yyyy'
    })

  
  })
</script>
