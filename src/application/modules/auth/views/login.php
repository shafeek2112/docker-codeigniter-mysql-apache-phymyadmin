<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="login-box">
  <div class="login-logo">
    <a href="#"><img src="<?php echo MASTER_URL."images/logo.png" ?>" width="300"></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Welcome to Wavelink Maritime Institute</p>


       <?php print form_open('auth/login/validate', 'id="form-login" class="p-t-15" role="form"') ."\r\n"; ?>
       <div class="row">
       <?php
            if (Settings_model::$db_config['login_enabled'] == 0)
            { ?>
              <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php print $this->lang->line('login_disabled') ?>
              </div> <?php
            }else{
              if ($this->session->flashdata('errormessage')) { ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <?php print $this->session->flashdata('errormessage'); ?>
                </div>
              <?php
              } else if ($this->session->flashdata('message'))  {
              ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <?php print $this->session->flashdata('message'); ?>
                </div>
              <?php
              }
            }
            ?>
          </div>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Username Or Email" name="username" id="login_username">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password" id="login_password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit"  class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <a href="#" id="forgot_password_link">Forget Password</a><br>
      <div id="forgot_password_div" class="m-t-20" style="display:none;">
      <?php print form_open('auth/forgot_password/send_password', array('id' => 'password_form', 'class' => 'membership_form')) ."\r\n"; ?> 
          <p>Enter your email address below and we'll send a special reset password link to your inbox.</p>
          <div class="form-group form-group-default">
            <label>Email</label>
            <div class="controls">
              <?php print form_input(array('name' => 'email', 'id' => 'email', 'class' => 'form-control', 'placeholder' => $this->lang->line('your_email'))); ?>
            </div>
          </div>
          <?php print form_submit(array('name' => 'forgot_password_submit', 'value' => $this->lang->line('send_password'), 'id' => 'forgot_password_submit', 'class' => 'btn btn-primary btn-cons m-t-10')); ?>
      <?php print form_close() ."\r\n"; ?>
      </div>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- END Login Right Container-->
<script>
$(function()
{
  $('#form-login').validate()
})
</script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
