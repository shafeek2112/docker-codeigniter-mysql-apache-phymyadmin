<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
} ?>
<style type="text/css">
    .checkbox input[type=checkbox]{
        margin-left: 0;
    }
</style>
<div class="content-wrapper">
	<section class="content-header">
    	<ol class="breadcrumb">
			<li><a href="<?=base_url()?>"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line('home'); ?></a></li>
			<li><?php echo $this->lang->line('users'); ?></li>
			<li class="active"><?php echo $this->lang->line('add_pri'); ?></li>
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
				<?php $this->load->view('generic/flash_error'); ?>
				<div class="panel-heading">
					<div class="panel-title"><h3><?php echo $this->lang->line('add_pri'); ?></h3></div>
				</div>
				<div class="panel-body no-border" style="">
					<?php print form_open(base_url()."add_privilege/add", array('id' => 'add_privilege_form', 'name' => 'add_privilege_form')) .
							"\r\n"; ?>
					<input type="hidden" id="csrf_token_id" name="csrf_token_id" value="<?php echo $this->security->get_csrf_hash(); ?>">
					<div class="row ">
						<div class="col-md-12">
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group">
										<?php print form_label($this->lang->line('privi_p_user_role'), 'reg_user_roll_id'); ?><label><span class="text-red">&nbsp;*</span></label>
										<?php print form_dropdown('user_roll_id', $user_roll, $this->session->flashdata('user_roll_id'),
												'id="reg_user_roll_id" class="form-control select2-wrapper" onchange="checked_action(this.value)"');
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="row ">
						<div class="col-sm-12">
							<div class="btn-group">
								<button class="btn btn-default" type="button" id="view_all"><?php echo $this->lang->line('view'); ?></button>
								<button class="btn btn-default" type="button" id="add_all"><?php echo $this->lang->line('add'); ?></button>
								<button class="btn btn-default" type="button" id="edit_all"><?php echo $this->lang->line('edit'); ?></button>
								<button class="btn btn-default" type="button" id="check_delete_all"><?php echo $this->lang->line('delete'); ?></button>
								<button class="btn btn-default" type="button" id="check_all"><?php echo $this->lang->line('check_all'); ?></button>
								<button class="btn btn-default" type="button" id="uncheck_all"><?php echo $this->lang->line('uncheck_all'); ?></button>
							</div>
						</div>
					</div>
					
					<div class="row ">
						<div class="col-md-12">
							
							<table class="table table-hover">
								<tr>
								  <th>Menu</th>
								  <th>Privileges</th>
								</tr>
									<?php
									if(isset($arrMenu["parent_menu"]) && count($arrMenu["parent_menu"]) > 0) 
									{   
										foreach($arrMenu["parent_menu"] as $menu_key => $parent_menu) 
										{
											if(isset($arrMenu["first_child_menu"]) && count($arrMenu["first_child_menu"]) > 0 
													&& isset($arrMenu["first_child_menu"][$menu_key]) && count($arrMenu["first_child_menu"][$menu_key]) > 0) 
											{
												?>
												<tr>
													<td><strong><?php echo $this->lang->line($parent_menu['lang_menu_name']); ?></strong></td>
													<td>
														<?php
														if(isset($arrMenu["permission_name"]) && array_key_exists($parent_menu['menu_id'],$arrMenu["permission_name"]))
														{
														?>
															<div class="checkbox check-success">
														<?php		
															foreach($arrMenu["permission_name"][$parent_menu['menu_id']] AS $menu_action_id=>$permission_name)
															{														
																$menu_act_id = $menu_action_id.'_' .$permission_name;
																echo form_checkbox('action[]', $menu_act_id, false,
																		'id="chkbox_' . $menu_act_id .
																		'" style="display:none1;"  class="check check_'.$permission_name.'" ');
																echo '<label for="chkbox_' . $menu_act_id . '">' .$this->lang->line($permission_name).
																		'</label>&nbsp;&nbsp;';
															}
														?>
															</div>
														<?php	
														}
														?>	
													</td>
												</tr>
												<?php
												foreach($arrMenu["first_child_menu"][$menu_key] as $fmenu_key => $first_child_menu) 
												{
													if(isset($arrMenu["second_child_menu"]) && count($arrMenu["second_child_menu"]) > 0 
																&& isset($arrMenu["second_child_menu"][$fmenu_key]) && count($arrMenu["second_child_menu"][$fmenu_key]) > 0) 
													{
													?>
														<tr>
															<td style="padding-left: 80px;"><strong><?php echo $this->lang->line($first_child_menu['lang_menu_name']); ?></strong></td>
															<td>
																<?php
																if(isset($arrMenu["permission_name"]) && array_key_exists($first_child_menu['menu_id'],$arrMenu["permission_name"]))
																{
																?>
																	<div class="checkbox check-success">
																<?php		
																	foreach($arrMenu["permission_name"][$first_child_menu['menu_id']] AS $menu_action_id=>$permission_name)
																	{														
															?>
																		<div class="checkbox check-success">
																			<?php
																			$menu_act_id = $menu_action_id.'_' .$permission_name;
																	
																			echo form_checkbox('action[]', $menu_act_id, false,
																					'id="chkbox_' . $menu_act_id .
																					'" style="display:none1;"  class="check check_'.$permission_name.'" ');
																			echo '<label for="chkbox_' . $menu_act_id . '">' .$this->lang->line($permission_name).
																					'</label>&nbsp;&nbsp;'; 
																	}
																?>
																	</div>
																<?php	
																}
																?>	
															</td>
														</tr>
														<?php
														foreach($arrMenu["second_child_menu"][$fmenu_key] as $smenu_key => $second_child_menu) 
														{
														?>	
															<tr>
																<td style="padding-left: 160px;"><?php echo $this->lang->line($second_child_menu['lang_menu_name']); ?></td>
																<td>
																	<?php
																	if(isset($arrMenu["permission_name"]) && array_key_exists($second_child_menu['menu_id'],$arrMenu["permission_name"]))
																	{
																	?>
																		<div class="checkbox check-success">
																	<?php	
																		foreach($arrMenu["permission_name"][$second_child_menu['menu_id']] AS $menu_action_id=>$permission_name)
																		{														
																			$menu_act_id = $menu_action_id.'_' .$permission_name;
																			echo form_checkbox('action[]', $menu_act_id, false,
																					'id="chkbox_' . $menu_act_id .
																					'" style="display:none1;"  class="check check_'.$permission_name.'" ');
																			echo '<label for="chkbox_' . $menu_act_id . '">' .$this->lang->line($permission_name).
																					'</label>&nbsp;&nbsp;'; 
																		}
																	?>
																		</div>
																	<?php	
																	}
																	?>	
																</td>
															</tr>
														<?php
														}
														?>
														<?php
													}
													else
													{
													?>
														<tr>
															<td style="padding-left: 80px;"><?php echo $this->lang->line($first_child_menu['lang_menu_name']); ?></td>
															<td>
																<?php
																if(isset($arrMenu["permission_name"]) && array_key_exists($first_child_menu['menu_id'],$arrMenu["permission_name"]))
																{
																?>
																	<div class="checkbox check-success">
																<?php		
																	foreach($arrMenu["permission_name"][$first_child_menu['menu_id']] AS $menu_action_id=>$permission_name)
																	{														
																		$menu_act_id = $menu_action_id.'_' .$permission_name;
																		echo form_checkbox('action[]', $menu_act_id, false,
																				'id="chkbox_' . $menu_act_id .
																				'" style="display:none1;"  class="check check_'.$permission_name.'" ');
																		echo '<label for="chkbox_' . $menu_act_id . '">' .$this->lang->line($permission_name).
																				'</label>&nbsp;&nbsp;'; 
																	}
																?>
																	</div>
																<?php	
																}
																?>	
															</td>
														</tr>
													<?php	
													}
												}
											}
											else
											{
											?>
												<tr>
													<td><strong><?php echo $this->lang->line($parent_menu['lang_menu_name']); ?></strong></td>
													<td>
														<?php
														if(isset($arrMenu["permission_name"]) && array_key_exists($parent_menu['menu_id'],$arrMenu["permission_name"]))
														{
														?>
															<div class="checkbox check-success">
														<?php	
															foreach($arrMenu["permission_name"][$parent_menu['menu_id']] AS $menu_action_id=>$permission_name)
															{														
																$menu_act_id = $menu_action_id.'_' .$permission_name;
																echo form_checkbox('action[]', $menu_act_id, false,
																		'id="chkbox_' . $menu_act_id .
																		'" style="display:none1;"  class="check check_'.$permission_name.'" ');
																echo '<label for="chkbox_' . $menu_act_id . '">' .$this->lang->line($permission_name).
																		'</label>&nbsp;&nbsp;'; 
															}
														?>
															</div>
														<?php	
														}
														?>
													</td>
												</tr>
											<?php	
											}
										} 
									}
									?>
							</table>			
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-12">
							<div class="row m-t-20 text-center">
								<div class="form-group">
									<?php
						 if($this->session->userdata('role_id') == '1' || in_array("add",$this->arrAction)) {
									print form_submit(array('name' => 'add_privilege_submit',
													'id' => 'add_privilege_submit', 'value' => $this->lang->line('privi_p_btn'),
													'class' => 'btn btn-primary btn-cons')) . "<br />\r\n";
													} ?> 
								</div>
							</div>
						</div>
					</div>

					<?php print form_close() . "\r\n"; ?>
				</div>
			</div>
		</div>
	</div>
	</section>
</div>