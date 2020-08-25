<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
?>
<script type="text/javascript" src="<?php print MASTER_URL; ?>js/jquery.form.js"></script>
<div class="row">
  <div class="col-sm-12"><?php $this->load->view('generic/flash_error'); ?></div>
</div>
  <div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
    	<ol class="breadcrumb">
			<li><a href="<?=base_url()?>"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line('home'); ?></a></li>
			<li><?php echo $this->lang->line('users'); ?></li>
			<li><a href="<?=base_url()?>list_user"><?php echo $this->lang->line('user_p_heading'); ?></a></li>
			<li class="active"><?php echo $this->lang->line('view_profile'); ?></li>
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
        <div class="col-md-3">
          <div class="box box-primary">
            <div class="box-body box-profile">
          <div class="form-group">
            <div class="fileinput fileinput-new" data-provides="fileinput">
      
                <img class="profile-user-img img-responsive img-circle" src="<?php echo $profile_picture_150; ?>" width="150" height="150" id="previewimg"/>

                <h3 class="profile-username text-center"><?php echo $user_data->first_name.' '.$user_data->middle_name.' '.$user_data->last_name; ?></h3>                  
                        
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
                       <?php print form_label($this->lang->line('user_p_full_name'), 'reg_first_name',array('class'=>'control-label col-sm-3')); ?>
                    <div class="col-sm-9">
                      <?php print $user_data->first_name.' '.$user_data->middle_name.' '.$user_data->last_name; ?>
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
                    <?php
                     if($user_data->gender == 'M')
                      { echo 'Male'; }
                    elseif ($user_data->gender == 'F') {
                          echo 'Female';
                    }?>
                
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
                      <?php print make_user_system_date_only($user_data->birth_date); ?>
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
                        <?php print $user_data->email; ?>
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
                       <?php print $user_data->email_2; ?>
                    </div>
                  </div>
                  <div class="form-group">
                        <?php
                      $attributes = array(
                       'class' => 'col-sm-3 control-label' // external or internal css
                
                        );
                      ?>
                    <?php print form_label($this->lang->line('country'), 'country',$attributes); ?>
                    <div class="col-sm-9">
                      <?php 
                      if(!empty($country_data)){
                        print $country_data['country']; 
                      }
                      ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <?php
                      $attributes = array(
                       'class' => 'col-sm-3 control-label' // external or internal css
                
                        );
                      ?>
                    <?php print form_label($this->lang->line('center'), 'center',$attributes); ?>
                    <div class="col-sm-9">
                      <?php 
                        $center_name = array();
                        if(isset($center_data) && !empty($center_data) && count($center_data) > 0){
                          foreach ($center_data as $_center_data) {
                            $center_name[] = $_center_data['center_name'];
                          }
                        }
                        print implode(",",$center_name);; ?>
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
                      <?php print $user_data->contact_number_1; ?>   
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
                      <?php print $user_data->contact_number_2; ?> 
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
                       <?php print $user_data->nationality; ?> 
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
                       <?php print $user_data->marital_status; ?> 
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
                      <?php print $user_data->skype_id; ?> 
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