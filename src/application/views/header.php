<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
function encrypt_ci($val){
	$ci =& get_instance();
	$ci -> load -> library('encrypt');
	$val = $ci -> encrypt -> encode($val);
	return strtr($val,'+/=','-_.');
}

function decrypt_ci($val){
	$ci =& get_instance();
	$ci -> load -> library('encrypt');
	$val = strtr($val,'-_.','+/=');
	return  $ci -> encrypt -> decode($val);
}
?>
<style>.display_none{display: none;}.form_error{display: none;color: red;}</style>
<header class="main-header">
  <a href="#" class="logo">
    <span class="logo-mini"><img src="<?php echo MASTER_URL."images/logo.png"; ?>" width="30" alt="FM"></span>
    <span class="logo-lg"><img src="<?php echo MASTER_URL."images/logo.png"; ?>" style="width: 80%;"></span>
  </a>
  <nav class="navbar navbar-static-top">
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
  			<li>
      				<?php
                $username = $this->session->userdata('first_name');
      				?>
      				<form action="https://project.dlideas.com/help_center/index/" method="post" target="_blank">
      					<input type="hidden" name="url" value="https://wmi.dlideas.com">
      					<input type="hidden" name="SessionUserName" value="<?php echo $username; ?>">
      					<input type="hidden" name="project" value="WMIUAT">
      					<input type="submit" name="submit" value="Help Center" style="color: #f6f7f9 !important;font-size:16px;background: none;border: 0;margin: 12px 0 0 0;font-weight: bold;">
      				</form>
  			</li>
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <?php 
            if($this->session->userdata('login_type') == 'corporate') {
                    $profile_picture = get_teacher_profile_pic();
                    $profile_picture_75 = $profile_picture;
             }elseif($this->session->userdata('login_type') == 'student'){
                     $profile_picture = get_student_profile_pic();
                     $profile_picture_75 = $profile_picture;
             }else{
                    $profile_picture = get_profile_pic();
                    $profile_picture_75 = $profile_picture[75];
             }
            ?>
            <img src="<?php  if(file_exists($profile_picture_75)){ print base_url($profile_picture_75) ; }else{ echo base_url('images/noimage.jpg'); } ?>" class="user-image" alt="User Image">
            <span class="hidden-xs"><?php echo  $username ;  ?></span>
          </a>
          <ul class="dropdown-menu">
            <li class="user-header">
            <?php 
              if ($this->session->userdata('login_type') == 'corporate') {
                          $profile_picture = get_teacher_profile_pic();
                           $profile_picture_75 = $profile_picture;
             }elseif($this->session->userdata('login_type') == 'student'){
                         $profile_picture = get_student_profile_pic();
                         $profile_picture_75 = $profile_picture;
             }else{
                $profile_picture = get_profile_pic();
                $profile_picture_75 = $profile_picture[75];
             }
            ?>
              <img src="<?php  if(file_exists($profile_picture_75)){ print base_url($profile_picture_75) ; }else{ echo base_url('images/noimage.jpg'); } ?>" class="img-circle" alt="User Image">
              <p>
               <?php echo $username ;  ?>
              </p>
            </li>
            <li class="user-footer">
                <?php
                if ($this->session->userdata('login_type') == 'corporate') {
                  ?>
                    <div class="pull-left header_box_btn1">
                       <a href="<?php print site_url('profile/corporate_profile/'.encrypt_decrypt('e', $this->session->userdata('user_id'))); ?>" class="btn btn-success btn-flat"><?php echo $this->lang->line('my_profile');?></a>
                    </div>
                     <div class="pull-left header_box_btn2">
                      <a href="<?php print site_url('corporate_portal/change_password'); ?>"data-toggle="modal" data-target="#modal-default"   class="btn btn-success btn-flat"><?php echo $this->lang->line('change_password');?></a> 
                      </div>
                    <div class="pull-right header_box_btn3">
                      <a href="<?php print site_url('auth/client_logout'); ?>" class="btn btn-danger btn-flat"><?php echo $this->lang->line('sign_out');?></a>
                    </div>
                 <?php
                }elseif($this->session->userdata('login_type') =='student'){
                ?>
                    <div class="pull-left header_box_btn1">
                    <a href="<?php print site_url('profile/student_profile/'.encrypt_decrypt('e', $this->session->userdata('user_id'))); ?>" class="btn btn-success btn-flat"><?php echo $this->lang->line('my_profile');?></a> 
                    </div>
                    <div class="pull-left header_box_btn2">
                      <a href="<?php print site_url('student_portal/change_password'); ?>"data-toggle="modal" data-target="#modal-default"   class="btn btn-success btn-flat"><?php echo $this->lang->line('change_password');?></a> 
                      </div>
                    <div class="pull-right header_box_btn3">
                      <a href="<?php print site_url('auth/client_logout'); ?>" class="btn btn-danger btn-flat"><?php echo $this->lang->line('sign_out');?></a>
                    </div>
                <?php
                }elseif($this->session->userdata('login_type') =='agent'){
                ?>
                    <div class="pull-left header_box_btn1">
                       <a href="<?php print site_url('profile/agent_profile/'.encrypt_decrypt('e', $this->session->userdata('user_id'))); ?>" class="btn btn-success btn-flat"><?php echo $this->lang->line('my_profile');?></a>
                    </div>
                     <div class="pull-left header_box_btn2">
                      <a href="<?php print site_url('agent_portal/change_password'); ?>"data-toggle="modal" data-target="#modal-default"   class="btn btn-success btn-flat"><?php echo $this->lang->line('change_password');?></a> 
                      </div>
                    <div class="pull-left header_box_btn3">
                      <a href="<?php print site_url('auth/client_logout'); ?>" class="btn btn-danger btn-flat"><?php echo $this->lang->line('sign_out');?></a>
                    </div>

                    <?php
                }elseif($this->session->userdata('login_type') =='tutor'){
                ?>
                    <div class="pull-left header_box_btn1">
                       <a href="<?php print site_url('trainer_portal/profile/'.encrypt_decrypt('e', $this->session->userdata('user_id'))); ?>" class="btn btn-success btn-flat"><?php echo $this->lang->line('my_profile');?></a>
                    </div>
                    <div class="pull-left header_box_btn2">
                      <a href="<?php print site_url('trainer_portal/change_password'); ?>"data-toggle="modal" data-target="#modal-default"   class="btn btn-success btn-flat"><?php echo $this->lang->line('change_password');?></a> 
                      </div>
                    
                    <div class="pull-left header_box_btn3">
                      <a href="<?php print site_url('auth/logout'); ?>" class="btn btn-danger btn-flat"><?php echo $this->lang->line('sign_out');?></a>
                    </div>
                <?php
                }
                else{
                ?>
                    <div class="pull-left">
                      <a href="<?php print site_url('profile/'.encrypt_decrypt('e', $this->session->userdata('user_id'))); ?>" class="btn btn-success btn-flat">My Profile</a>
                    </div>

                    <div class="pull-right">
                      <a href="<?php print site_url('auth/logout'); ?>" class="btn btn-danger btn-flat">Sign out</a>
                    </div>
                     <?php
                }
                ?>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>