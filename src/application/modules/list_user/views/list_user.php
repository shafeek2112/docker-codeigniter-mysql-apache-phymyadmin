<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script type="text/javascript" src="<?php print MASTER_URL; ?>js/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo autoVersioning('js/grid/list_user.js'); ?>"></script>

<div class="content-wrapper">
	<section class="content-header">
    	<ol class="breadcrumb">
			<li><a href="<?=base_url()?>"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line('home'); ?></a></li>
			<li><?php echo $this->lang->line('users'); ?></li>
			<li class="active"><?php echo $this->lang->line('user_p_heading'); ?></li>
		</ol>
	</section>
	
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <div class="box-header">
              <!--  -->
             </div>   
         </div>
      </div>
      
      <p id="successmsg"></p>
       <?php $this->load->view('generic/flash_error'); ?>
        <div class="row">
        <div class="col-xs-12">
             <div class="box">
                 <div class="box-header">
                    <h3 class="box-title"> Users</h3>
                      <div class="box-tools pull-right">
                        <?php
                        if($this->session->userdata('role_id') == '1' || in_array("add_user",$this->arrAction)) { ?>
                          <a href="list_user/add" class="btn btn-success margin-r-5" data-toggle="modal" data-target="#modal-default" ><?php echo $this->lang->line('add_new'); ?> <i class="fa fa-plus"></i></a>
                            <?php
                        }
                        if($this->session->userdata('role_id') == '1' || in_array("export_xls",$this->arrAction)) { ?>
                                     <?php
                          print form_open_multipart('list_user/export_to_excel/', array('id' => 'export_file','name'=>'formmain', 'target'=>'download_iframe','class' => 'pull-right')) ."\r\n";
                          ?>
                            <input type="submit" name="submit" value="<?php echo $this->lang->line('export_xls'); ?>" class="btn btn-info pull-right">
                      <?php print form_close() . "\r\n"; ?> <?php 
                        } ?>
                     </div>
                  </div>

            <div class="box-body">
              <div class="table-responsive" style="overflow-y: hidden;">
              <table  id="grid_other_user" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th></th>
                  <th><?php echo $this->lang->line('username'); ?></th>
                    <th><?php echo $this->lang->line('staff_name'); ?></th>
                    <th><?php echo $this->lang->line('email_1'); ?></th>
                    <th><?php echo $this->lang->line('email_2'); ?></th>
                    <th><?php echo $this->lang->line('date_birth'); ?></th>
                    <th><?php echo $this->lang->line('contact_no_1'); ?></th>
                    <th><?php echo $this->lang->line('contact_no_2'); ?></th>
                    <th><?php echo $this->lang->line('user_p_role'); ?></th>
                    <th><?php echo $this->lang->line('created_by'); ?></th>
                    <th><?php echo $this->lang->line('created_date'); ?></th>
                    <th><?php echo $this->lang->line('updated_by'); ?></th>
                    <th><?php echo $this->lang->line('updated_date'); ?></th>
                    
                </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
