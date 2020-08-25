<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script type="text/javascript" src="<?php print MASTER_URL; ?>js/jquery.form.js"></script>

<?php
if ($this->session->flashdata('passport_number') == '') { ?>
<div class="modal fade fill-in" id="modalFillIn" tabindex="-1" role="dialog" aria-hidden="true">
  <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
    <i class="pg-close"></i>
  </button> -->
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Candidate ID Verification Check</h4>
      </div>
      <div class="modal-body">
        <form id="passport_validator_register">
          <div class="row">
            <div class="col-md-9 " id="errordiv">
              <div class="form-group form-group-default input-group required">
                <span class="input-group-addon">
                  <?php  print form_dropdown('nationality',$nationality_list,($user_data)?$user_data->nationality:'','id="nationality" class="cs-select cs-skin-slide cs-transparent" data-init-plugin="cs-select"'); ?>
                </span>
                <?php print form_label('Passport number', 'passport_number'); ?>
                <?php print form_input(array('name' => 'passport_number', 'id' => 'passport_number', 'value' => ($user_data) ? $user_data->passport_number : $this->session->flashdata('passport_number'), 'class' => 'form-control')); ?>
              </div>
            </div>
            <div class="col-md-3 no-padding sm-m-t-10 sm-text-center">
              <button type="button" class="btn btn-primary btn-lg btn-duplicate btn-large fs-15"><i class="pg-search"></i> <span class="bold">Search</span></button>
              
            </div>
          </div>
		  <div class="row">
            <div class="col-md-12">
				<div class="checkbox check-success" id="terms_condition_div">
                    <input type="checkbox" value="1" id="checkbox2" name="terms_condition">
                    <label for="checkbox2"><strong>By Checking this box, I confirm the Following:</strong></label>
                </div>
            </div>
          </div>
		  <div class="row">
            <div class="col-md-12">
				<p>
					1. All details entered are true and accurate.<br />
					2. All documents uploaded are valid and authentic.<br />
					3. I authorized EDUGUIDE to use all of the supplied information for recruitment purposes.<br />
				</p>
            </div>
          </div>
        </form>
        <p id="passport_validator_msg" class="text-center sm-text-center hinted-text p-t-10 p-r-10"><b>This Step is Absolutely Mandatory!</b><br>If there is no match for your Passport, you will be be taken to the next step to proceed with adding your personal details.</p>
        <p id="ac_but_register" class="text-center sm-text-center hinted-text p-t-10 p-r-10">
          <button type="button" class="btn btn-primary btn-cons btn-animated from-left fa fa-paper-plane ctn_register" style="display:none;"> <span>Continue</span> </button>
          <button type="button" class="btn btn-info btn-cons fs-15 btn-animated from-left fa fa-times" onclick="window.location='<?= base_url('auth/login')?>'"><span class="bold">Cancel</span></button>
        </p>
      </div>
      <div class="modal-footer">
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $('#modalFillIn').modal({
      backdrop: 'static',
      keyboard: false
    });
  });
</script>

<?php
}else{ ?>
<div class="row">
  <div class="col-sm-12"><?php $this->load->view('generic/flash_error'); ?></div>
</div>
<div id="rootwizard_register">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm">
    <li class="active">
      <a data-toggle="tab" href="#tab1"><i class="fa fa-shopping-cart tab-icon"></i> <span>Personal Info</span></a>
    </li>
    <li class="">
      <a data-toggle="tab" href="#tab3"><i class="fa pg-note tab-icon"></i> <span>Documents</span></a>
    </li>
  </ul>
  <?php print form_open_multipart('auth/register', array('id' => 'add_profile_form_register','class' => 'form-no-horizontal-spacing')) ."\r\n"; ?>
  <div class="tab-content bg-white add-profile-pg">
    <div class="tab-pane slide-left padding-20 active" id="tab1">
      <div class="containerfdfdf"></div> 
      <div class="row row-same-height">
        <div class="col-sm-3 b-r b-dashed b-grey sm-b-b">
          <div class="padding-30 m-t-50">            
            <?php
            //print form_open('profile/upload_profile_pic/'.$user_id.'/0', array('id' => 'uploadpic_form')) ."\r\n";
              //print form_upload(array('name' => 'uploadpic', 'id' => 'uploadpic', 'value' => '', 'onchange'=>'previewUploadImg(this)', 'style'=>'display:none;'));
            //print form_close(); ?>
            <div class="form-group">
              <div class="fileinput fileinput-new" data-provides="fileinput">
                <h2>&nbsp;</h2>
                <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                  <img src="<?php echo $profile_picture_150; ?>" width="150" height="150" id="previewimg"/>                  
                </div>                
                <!-- <a href="javascript:void(0)" class="btn default btn-file" onclick="changepic();"><?php print $this->lang->line('pro_p_change_pic'); ?></a> -->
              </div>
            </div>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
          </div>
        </div>
        <div class="col-sm-9">
          <div class="padding-30">
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group form-group-default required">
                    <?php print form_label($this->lang->line('user_p_first_name'), 'reg_first_name'); ?>
                    <?php print form_input(array('name' => 'first_name', 'id' => 'reg_first_name', 'value' => ($user_data) ? $user_data->first_name : $this->session->flashdata('first_name'), 'class' => 'form-control')); ?>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group form-group-default ">
                    <?php print form_label($this->lang->line('user_p_middle_name'), 'reg_middle_name'); ?>
                    <?php print form_input(array('name' => 'middle_name', 'id' => 'reg_middle_name', 'value' => ($user_data) ? $user_data->middle_name : $this->session->flashdata('middle_name'), 'class' => 'form-control')); ?>
                </div>
              </div>                    
              <div class="col-sm-4">
                <div class="form-group form-group-default required">
                    <?php print form_label($this->lang->line('user_p_last_name'), 'reg_last_name'); ?>
                    <?php print form_input(array('name' => 'last_name', 'id' => 'reg_last_name', 'value' => ($user_data) ? $user_data->last_name : $this->session->flashdata('last_name'), 'class' => 'form-control')); ?>
                </div>
              </div>
              <div class="clear"></div>
            </div>  

            <div class="row">            
              <div class="col-sm-6">
                <div class="form-group form-group-default form-group-default-select2">
                  <?php print form_label('Gender', 'gender'); ?>
                  <?php  print form_dropdown('gender',$gender_list,($user_data)?$user_data->gender:'0','id="gender" class="full-width"'); ?>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group form-group-default input-group col-sm-12">
                  <?php print form_label($this->lang->line('user_p_birth_date'), 'birth_date'); ?>
                  <?php print form_input(array('name' => 'birth_date', 'id' => 'show_dp', 'value' => ($user_data)?make_dp_date($user_data->birth_date):$this->session->flashdata('birth_date'), 'class' => 'form-control')); ?>
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
              </div>
              <div class="clear"></div>
            </div>
            
			<div class="row">
				<div class="col-sm-4">
				  <div class="form-group form-group-default form-group-default-select2 required">
					<?php print form_label('Nationality', 'nationality'); ?>
					<?php  print form_dropdown('nationality',$nationality_list,($user_data)?$user_data->nationality:$this->session->flashdata('nationality'),'id="nationality" class="full-width"'); ?>
				  </div>
				</div>
				<div class="clear"></div>
			</div>
            
			<div class="row">
            <div class="col-sm-4">
              <div class="form-group form-group-default form-group-default-select2">
                <?php print form_label('Marital status', 'marital_status'); ?>
                <?php  print form_dropdown('marital_status',$marital_status_list,($user_data)?$user_data->marital_status:'0','id="marital_status" class="full-width"'); ?>
              </div>
            </div>
		    	<div class="col-sm-4">
            <div class="clear"></div>
          </div>
        </div>
		  
			<div class="row">                    
              <div class="col-sm-6">
                <div class="form-group form-group-default required">
                  <?php print form_label($this->lang->line('user_p_email_address'), 'email'); ?>
                  <?php print form_input(array('name' => 'email', 'id' => 'email', 'value' => ($user_data)?$user_data->email:$this->session->flashdata('email'), 'class' => 'form-control')); ?>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group form-group-default">
                  <?php print form_label('Email 2', 'email_2'); ?>
                  <?php print form_input(array('name' => 'email_2', 'id' => 'email_2', 'value' => ($user_data) ? $user_data->email_2 : $this->session->flashdata('email_2'), 'class' => 'form-control')); ?>
                </div>
              </div>
              <div class="clear"></div>
            </div>
			
			<div class="row">
              <div class="col-sm-6">
                <div class="form-group form-group-default required">
                  <?php print form_label($this->lang->line('user_p_password'), 'reg_password'); ?>
                  <?php print form_password(array('name' => 'password', 'id' => 'reg_password', 'class' => 'form-control qtip_password')); ?>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group form-group-default required">
                  <?php print form_label($this->lang->line('user_p_confirm_password'), 'password_confirm'); ?>
                  <?php print form_password(array('name' => 'password_confirm', 'id' => 'password_confirm', 'class' => 'form-control')); ?>
                </div>
              </div>  
              <div class="clear"></div>
            </div>
			
			<div class="row">            
              <div class="col-sm-4">
                <div class="form-group form-group-default required">
                  <?php print form_label('Contact number 1', 'reg_contact_number_1'); ?>
                  <?php print form_input(array('name' => 'contact_number_1', 'id' => 'reg_contact_number_1', 'value' => ($user_data)?$user_data->contact_number_1:$this->session->flashdata('contact_number_1'), 'class' => 'form-control')); ?>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group form-group-default ">
                  <?php print form_label('Contact number 2', 'reg_contact_number_2'); ?>
                  <?php print form_input(array('name' => 'contact_number_2', 'id' => 'reg_contact_number_2', 'value' => ($user_data)?$user_data->contact_number_2:$this->session->flashdata('contact_number_2'), 'class' => 'form-control')); ?>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group form-group-default ">
                  <?php print form_label('Skype ID', 'skype_id'); ?>
                  <?php print form_input(array('name' => 'skype_id', 'id' => 'skype_id', 'value' => ($user_data)?$user_data->skype_id:$this->session->flashdata('skype_id'), 'class' => 'form-control')); ?>
                </div>
              </div>
              <div class="clear"></div>
            </div>
			
            <div class="row">
               <div class="col-sm-12">
                <div class="form-group form-group-default form-group-default-select2">
                  <?php print form_label('Languages', 'language_known'); ?>
				  <?php  
					$language_known = array();
					if(isset($user_data)){
						$language_known = (!empty($user_data->language_known)) ? explode(',', $user_data->language_known) : array();
					}	
					else{
						$language_known = $this->session->flashdata('language_known');
					}
					print form_multiselect('language_known[]',$language_known_list,$language_known,'id="language_known" class="full-width" data-init-plugin="select2" multiple'); 
					?>
                </div>
              </div>
              <div class="clear"></div>
            </div>
			
			<?php

			if(!empty($user_qualification))
			{
			?>
				<div class="row">
				<div class="col-md-12">
					<div id="portlet-linear-color" class="panel panel-default">
						<div class="panel-heading ">
							<div class="panel-title">Qualifications
							</div>
							<div class="panel-controls">
								<a href="#" class="portlet-collapse bold" data-toggle="collapse" style="font-size: 12px;">
									<button class="btn btn-success btn-rounded btn-xs" id="add_qualification_div">
										<i class="fa fa-plus-circle"></i> ADD NEW
									</button>
								</a>
							</div>
						</div>
						<div class="panel-body">
							<div id="no_qualification" style="display:none;">
								<h3><span class="semi-bold">Awaiting</span> Submission</h3>
								<p></p>
							</div>
						<ol id="qualifications">
			<?php
				foreach($user_qualification as $qualification)
				{ ?>
			  <li>

				<div class="row">
					<div class="col-md-11 col-sm-height col-top">
				
				<div class="row">
				  <div class="col-md-6">
					<div class="form-group form-group-default form-group-default-select2">
						<?php 
							print form_label('Qualification', 'qualification_id'); 
							print form_dropdown('qualifications[qualification_id][]',$qualifications_list,$qualification['qualification_id'],'id="qualification_id" class="full-width"');
						?>
					</div>
				  </div>
				  <div class="col-md-6">
					<div class="form-group form-group-default input-group col-sm-12">
						<?php 
							print form_label('Graduation year', 'graduation_year'); 
							print form_input(array('name' => 'qualifications[graduation_year][]', 'id' => 'date_year', 'value' => $qualification['graduation_year'], 'class' => 'form-control')); 
						?> 
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
					</div>
				  </div>
				  <div class="clear"></div>
				</div>
				<div class="row">
				  <div class="col-md-6">
					<div class="form-group form-group-default">
						<?php 
							print form_label('Subject', 'subject'); 
							print form_input(array('name' => 'qualifications[subject][]', 'id' => 'subject', 'value' => $qualification['subject'], 'class' => 'form-control')); 
						?>
					</div>
				  </div>
				  <div class="col-md-6">
					<div class="form-group form-group-default">
						<?php 
							print form_label('Institute', 'institute'); 
							print form_input(array('name' => 'qualifications[institute][]', 'id' => 'institute', 'value' => $qualification['institute'], 'class' => 'form-control')); 
						?>
					</div>
				  </div>
				  <div class="clear"></div>
				</div>
			 </div>    
		
			<div class="col-md-1 col-sm-height col-middle">
		   <div class="btn-group">
	<button type="button" class="btn btn-danger" onclick="javascript:deleteMulBox(this);">
	<span class="p-t-5 p-b-5">
	<i class="fa fa-trash-o fs-16"></i>
	</span>
	<br>
	<span class="fs-11 font-montserrat text-uppercase">Delete</span>
	</button>
	</div>
	 </div>
			

			
			</div>             
										   
			  </li>
			  <?php

					}
				?>
					</ol>
					</div>
					</div>
				</div>
				</div>
				
				<?php
				}
				else
				{
				?>
					<div class="row">
						<div class="col-md-12">
							<div id="portlet-linear-color" class="panel panel-default">
								<div class="panel-heading ">
									<div class="panel-title">Qualifications
									</div>
									<div class="panel-controls">
										<a href="#" class="portlet-collapse bold" data-toggle="collapse" style="font-size: 12px;">
											<button class="btn btn-success btn-rounded btn-xs" id="add_qualification_div">
												<i class="fa fa-plus-circle"></i> ADD NEW
											</button>
										</a>
									</div>
								</div>
								<div class="panel-body">
									<div id="no_qualification">
										<h3><span class="semi-bold">Awaiting</span> Submission</h3>
										<p></p>
									</div>
									<ol id="qualifications">
									
									</ol>
								</div>
							</div>
						</div>
					</div>
				<?php	
				}	
				?>
			
				<div class="hide" id="qualification_main_sample">
					<li>

				<div class="row">
					<div class="col-md-11 col-sm-height col-top">
					
						
						<div class="row">
						  <div class="col-md-6">
							<div class="form-group form-group-default form-group-default-select2">
								<?php 
									print form_label('Qualification', 'qualification_id'); 
									print form_dropdown('qualifications[qualification_id][]',$qualifications_list,'0','id="qualification_id" class="full-width"');
								?>
							</div>
						  </div>
						  <div class="col-md-6">
							<div class="form-group form-group-default input-group col-sm-12">
								<?php 
									print form_label('Graduation year', 'graduation_year'); 
									print form_input(array('name' => 'qualifications[graduation_year][]', 'id' => 'date_year', 'value' => '', 'class' => 'form-control')); 
								?> 
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
							</div>
						  </div>
						  <div class="clear"></div>
						</div>
						<div class="row">
						  <div class="col-md-6">
							<div class="form-group form-group-default">
								<?php 
									print form_label('Subject', 'subject'); 
									print form_input(array('name' => 'qualifications[subject][]', 'id' => 'subject', 'value' => '', 'class' => 'form-control')); 
								?>
							</div>
						  </div>
						  <div class="col-md-6">
							<div class="form-group form-group-default">
								<?php 
									print form_label('Institute', 'institute'); 
									print form_input(array('name' => 'qualifications[institute][]', 'id' => 'institute', 'value' => '', 'class' => 'form-control')); 
								?>
							</div>
						  </div>
				  <div class="clear"></div>
				</div>
			 </div>    
		
			<div class="col-md-1 col-sm-height col-middle">
		   <div class="btn-group">
	<button type="button" class="btn btn-danger" onclick="javascript:deleteMulBox(this);">
	<span class="p-t-5 p-b-5">
	<i class="fa fa-trash-o fs-16"></i>
	</span>
	<br>
	<span class="fs-11 font-montserrat text-uppercase">Delete</span>
	</button>
	</div>
	 </div>
			

			
			</div>             
										   
			  </li>
				</div>
			
			<?php
			if(!empty($user_experience))
			{ 
			?>
				<div class="row">
				<div class="col-md-12">
					<div id="portlet-linear-color" class="panel panel-default">
						<div class="panel-heading ">
							<div class="panel-title">Work Experience
							</div>
							<div class="panel-controls">
								<a href="#" class="portlet-collapse bold" data-toggle="collapse" style="font-size: 12px;">
									<button class="btn btn-success btn-rounded btn-xs" id="add_experience_div">
										<i class="fa fa-plus-circle"></i> ADD NEW
									</button>
								</a>
							</div>
						</div>
						<div class="panel-body">
							<div id="no_experience" style="display:none;">
								<h3><span class="semi-bold">Awaiting</span> Submission</h3>
								<p></p>
							</div>
						<ol id="experiences">
			<?php
				foreach($user_experience as $experience)
				{ 
			?>
			   
					<li>

				<div class="row">
					<div class="col-md-11 col-sm-height col-top">
			   
				<div class="row">
				  <div class="col-md-6">
					<div class="form-group form-group-default">
						<?php 
						print form_label('Organization', 'company'); 
						print form_input(array('name' => 'experience[company][]', 'id' => 'company', 'value' => $experience['company'], 'class' => 'form-control')); 
						?>
					</div>
				  </div>
				  <div class="col-md-6">
					<div class="form-group form-group-default">
						<?php 
						print form_label('Position', 'position');
						print form_input(array('name' => 'experience[position][]', 'id' => 'position', 'value' => $experience['position'], 'class' => 'form-control')); 
						?>
					</div>
				  </div>
				  <div class="clear"></div>
				</div>
				
				<div class="row">
				  <div class="col-md-6">
			   
				   <div class="row">
				  <div class="col-md-6">              
				   
					<div class="form-group form-group-default input-group col-sm-12">
					<?php 
					print form_label('Start date', 'start_date');
					print form_input(array('name' => 'experience[start_date][]', 'id' => 'show_dp', 'value' => make_dp_date($experience['start_date']), 'class' => 'form-control')); 
					?> 
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					</div>
				  </div>
				  <div class="col-md-6">
					<div class="form-group form-group-default input-group col-sm-12">
						<?php 
						print form_label('End Date', 'end_date');
						print form_input(array('name' => 'experience[end_date][]', 'id' => 'show_dp', 'value' => make_dp_date($experience['end_date']), 'class' => 'form-control')); 
						?> 
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					</div>
				  </div>
				  <div class="clear"></div>
				</div>
				</div>
				
				
				<div class="col-md-6">
					<div class="form-group form-group-default">
						<?php 
						print form_label('Country/Location', 'location');
						print form_input(array('name' => 'experience[location][]', 'id' => 'location', 'value' => $experience['location'], 'class' => 'form-control')); 
						?>
					</div>
				  </div>
				  <div class="clear"></div>
				</div>
			 </div>    
		
			<div class="col-md-1 col-sm-height col-middle">
		   <div class="btn-group">
	<button type="button" class="btn btn-danger" onclick="javascript:deleteMulBoxExp(this);">
	<span class="p-t-5 p-b-5">
	<i class="fa fa-trash-o fs-16"></i>
	</span>
	<br>
	<span class="fs-11 font-montserrat text-uppercase">Delete</span>
	</button>
	</div>
	 </div>
			

			
			</div>             
										   
			  </li>
			  <?php

				}

			?>
					</ol>
					</div>
					</div>
				</div>
				</div>
				
			<?php
			}
			else
			{
			?>
				<div class="row">
					<div class="col-md-12">
						<div id="portlet-linear-color" class="panel panel-default">
							<div class="panel-heading ">
								<div class="panel-title">Work Experience
								</div>
								<div class="panel-controls">
									<a href="#" class="portlet-collapse bold" data-toggle="collapse" style="font-size: 12px;">
										<button class="btn btn-success btn-rounded btn-xs" id="add_experience_div">
											<i class="fa fa-plus-circle"></i> ADD NEW
										</button>
									</a>
								</div>
							</div>
							<div class="panel-body">
								<div id="no_experience">
									<h3><span class="semi-bold">Awaiting</span> Submission</h3>
									<p></p>
								</div>
								<ol id="experiences">
								
								</ol>
							</div>
						</div>
					</div>
				</div>
			<?php	
			}	
			?>
			
			<div class="hide" id="experience_main_sample">
			  <li>
			   
				<div class="row">
					<div class="col-md-11 col-sm-height col-top">
			   
				<div class="row">
				  <div class="col-md-6">
					<div class="form-group form-group-default">
						<?php 
						print form_label('Organization', 'company'); 
						print form_input(array('name' => 'experience[company][]', 'id' => 'company', 'value' => '', 'class' => 'form-control')); 
						?>
					</div>
				  </div>
				  <div class="col-md-6">
					<div class="form-group form-group-default">
						<?php 
						print form_label('Position', 'position');
						print form_input(array('name' => 'experience[position][]', 'id' => 'position', 'value' => '', 'class' => 'form-control')); 
						?>
					</div>
				  </div>
				  <div class="clear"></div>
				</div>

				<div class="row">
				  <div class="col-md-6">
			   
				   <div class="row">
				  <div class="col-md-6">  
				   
					<div class="form-group form-group-default input-group col-sm-12">
					<?php 
					print form_label('Start date', 'start_date');
					print form_input(array('name' => 'experience[start_date][]', 'id' => 'show_dp', 'value' => '', 'class' => 'form-control')); 
					?> 
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					</div>
				  </div>
				  <div class="col-md-6">
					<div class="form-group form-group-default input-group col-sm-12">
						<?php 
						print form_label('End Date', 'end_date');
						print form_input(array('name' => 'experience[end_date][]', 'id' => 'show_dp', 'value' => '', 'class' => 'form-control')); 
						?> 
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					</div>
				  </div>
				  <div class="clear"></div>
				</div>
				</div>
				
				
				<div class="col-md-6">
					<div class="form-group form-group-default">
						<?php 
						print form_label('Country/Location', 'location');
						print form_input(array('name' => 'experience[location][]', 'id' => 'location', 'value' => '', 'class' => 'form-control')); 
						?>
					</div>
				  </div>

				  <div class="clear"></div>
				</div>
			 </div>    
		
			<div class="col-md-1 col-sm-height col-middle">
				<div class="btn-group">
					<button type="button" class="btn btn-danger" onclick="javascript:deleteMulBoxExp(this);">
						<span class="p-t-5 p-b-5">
						<i class="fa fa-trash-o fs-16"></i>
						</span>
						<br>
						<span class="fs-11 font-montserrat text-uppercase">Delete</span>
					</button>
				</div>
			</div>                         
			  </li>
			</div>
			
			
			
			<div class="row">                    
			<div class="col-sm-12">
			  <div class="form-group form-group-default">
				<?php 
				print form_label('Additional Skills and Experience', 'description');
				 $data_text_desc = array(
								'name'        => 'additional_skills_experience',
								'id'          => 'additional_skills_experience',
								'value'       => ($user_data)?$user_data->additional_skills_experience:'',
								'rows'        => '5',
								'cols'        => '10',
								'class'       => 'form-control1 b-transparent-white full-width'
							);

				print form_textarea($data_text_desc);
				?>
			  </div>
			</div>
			<div class="clear"></div>
		  </div>
		  
          </div>
        </div>
      </div>
    </div>
    
    <div class="tab-pane slide-left padding-20" id="tab3">
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <?php print form_label('Photo', 'photo'); ?>
            <input type="file" name="photo[]" id="photo" class="form-control input-sm"  multiple>
          </div>
        </div>
        <div class="clear"></div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <?php print form_label('Organization CV', 'company_cv'); ?>
            <input type="file" name="company_cv[]" id="company_cv" class="form-control input-sm"  multiple>
          </div>
        </div>
        <div class="clear"></div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <?php print form_label('Personal CV', 'personal_cv'); ?>
            <input type="file" name="personal_cv[]" id="personal_cv" class="form-control input-sm"  multiple>
          </div>
        </div>
        <div class="clear"></div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <?php print form_label('Passport', 'passport'); ?>
            <input type="file" name="passport[]" id="passport" class="form-control input-sm"  multiple>
          </div>
        </div>
        <div class="clear"></div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <?php print form_label('Degree 1', 'degree_1'); ?>
            <input type="file" name="degree_1[]" id="degree_1" class="form-control input-sm"  multiple>
          </div>
        </div>
        <div class="clear"></div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <?php print form_label('Degree 2', 'degree_2'); ?>
            <input type="file" name="degree_2[]" id="degree_2" class="form-control input-sm"  multiple>
          </div>
        </div>
        <div class="clear"></div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <?php print form_label('Teaching Certification 1', 'teaching_certification_1'); ?>
            <input type="file" name="teaching_certification_1[]" id="teaching_certification_1" class="form-control input-sm"  multiple>
          </div>
        </div>
        <div class="clear"></div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <?php print form_label('Teaching Certification 2', 'teaching_certification_2'); ?>
            <input type="file" name="teaching_certification_2[]" id="teaching_certification_2" class="form-control input-sm"  multiple>
          </div>
        </div>
        <div class="clear"></div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <?php print form_label('Reference 1', 'reference_1'); ?>
            <input type="file" name="reference_1[]" id="reference_1" class="form-control input-sm"  multiple>
          </div>
        </div>
        <div class="clear"></div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <?php print form_label('Reference 2', 'reference_2'); ?>
            <input type="file" name="reference_2[]" id="reference_2" class="form-control input-sm"  multiple>
          </div>
        </div>
        <div class="clear"></div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <?php print form_label('Additional', 'additional'); ?>
            <input type="file" name="additional[]" id="additional" class="form-control input-sm"  multiple>
          </div>
        </div>
        <div class="clear"></div>
      </div>
    </div>
    
    <div class="padding-20 bg-white">
      <ul class="pager wizard">
        <li class="next">
          <button class="btn btn-primary btn-cons btn-animated from-left fa fa-check pull-right" type="button">
            <span>Next</span>
          </button>
        </li>
        <li class="next finish hidden">
          <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-primary btn-cons btn-animated from-left fa fa-cog pull-right" />
        </li>
        <li class="previous first hidden">
          <button class="btn btn-default btn-cons btn-animated from-left fa fa-cog pull-right" type="button">
            <span>First</span>
          </button>
        </li>
        <li class="previous">
          <button class="btn btn-default btn-cons pull-right" type="button">
            <span>Previous</span>
          </button>
        </li>
      </ul>      
    </div>
  </div>
  <?php print form_close(); ?>
</div>

<?php
} ?>