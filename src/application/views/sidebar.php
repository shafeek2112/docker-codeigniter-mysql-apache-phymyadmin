<?php
$arrMenu = get_rolewise_priviledge();
//$default_homepage = get_default_homepage();
$controller_name = "";
$controller_name = $this->router->fetch_class();
$menu = '';
$function_name = $this->router->fetch_method();
?>
<aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
              <?php 
                if ($this->session->userdata('login_type') == 'teacher'){
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
          <img style="width: 80%;" src="<?php  if(file_exists($profile_picture_75)){ print base_url($profile_picture_75) ; }else{ echo base_url('images/noimage.jpg'); } ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $this->session->userdata('first_name');  ?></p>
        </div>
      </div>
<?php
if( $this->session->userdata('login_type') == 'corporate')
{
  ?>	
     <ul class="sidebar-menu" data-widget="tree">
       <li <?php if($controller_name == 'corporate_portal'){ ?> class = 'active' <?php } ?> ><a href="<?php echo base_url().'corporate_portal'; ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>

       <li class="treeview"  <?php if(isset($function_name) &&  $function_name == 'document'){ ?> class = 'menu-open active' <?php } ?>>
              <a href="#">
                <i class="fa fa-folder"></i> <span><?php echo $this->lang->line('document'); ?> </span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" <?php if(isset($function_name) && $function_name == 'document'){ ?> style="display: block; <?php } ?> ">
                <li><a href="<?php echo site_url('corporate_portal/document'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('learning_material'); ?></a></li>
              </ul>
            </li>

        <li class="treeview  "  <?php if(isset($menu) &&  $menu == 'Course'){ ?> class = 'menu-open active' <?php } ?>>
              <a href="#">
                <i class="fa fa-inbox"></i> <span>Student Management</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" <?php if($function_name == 'student_list' || $function_name == 'add_course' || $function_name == 'course' || $function_name == 'schedule' || $function_name == 'academic_history' || $function_name == 'makeup_list'){ ?>  style="display: block; <?php } ?> ">

                <li <?php if(isset($function_name) &&  $function_name == 'student_list'){ ?> class = 'active' <?php } ?> ><a href="<?php echo site_url('corporate_portal/student_list'); ?>"><i class="fa fa-circle-o"></i>Student List</a></li>

                <li <?php if(isset($function_name) &&  $function_name == 'add_course'){ ?> class = 'active' <?php } ?>><a href="<?php echo site_url('corporate_portal/add_course'); ?>"><i class="fa fa-circle-o"></i>Course Registrtion</a></li>

                <li <?php if(isset($function_name) &&  $function_name == 'course'){ ?> class = 'active' <?php } ?> ><a href="<?php echo site_url('corporate_portal/course'); ?>"><i class="fa fa-circle-o"></i>Course </a></li>

                <li <?php if(isset($function_name) &&  $function_name == 'schedule'){ ?> class = 'active' <?php } ?> ><a href="<?php echo site_url('corporate_portal/schedule'); ?>"><i class="fa fa-circle-o"></i>Schedule</a></li>

                <li <?php if(isset($function_name) &&  $function_name == 'academic_history'){ ?> class = 'active' <?php } ?>><a href="<?php echo site_url('corporate_portal/academic_history'); ?>"><i class="fa fa-circle-o"></i>Academic History</a></li>

                 <li <?php if(isset($function_name) &&  $function_name == 'makeup_list'){ ?> class = 'active' <?php } ?>><a href="<?php echo site_url('corporate_portal/makeup_list'); ?>"><i class="fa fa-circle-o"></i> Makeup List</a></li>

              </ul>
            </li>

            <li class="treeview  "  <?php if(isset($menu) &&  $menu == 'Invoice Payment'){ ?> class = 'menu-open active' <?php } ?>>
              <a href="#">
                <i class="fa fa-inbox"></i> <span>Invoice Payment</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" <?php if($function_name == 'invoice' || $function_name == 'refund_invoice' || $function_name == 'miscellaneous_invoice_listing' || $function_name == 'payment_history'){ ?> style="display: block; <?php } ?> ">

                <li <?php if(isset($function_name) &&  $function_name == 'invoice'){ ?> class = 'active' <?php } ?>><a href="<?php echo site_url('corporate_portal/invoice'); ?>"><i class="fa fa-circle-o"></i>Invoice</a></li>

                <li <?php if(isset($function_name) &&  $function_name == 'refund_invoice'){ ?> class = 'active' <?php } ?>><a href="<?php echo site_url('corporate_portal/refund_invoice'); ?>"><i class="fa fa-circle-o"></i>Refund Invoice</a></li>

                <li <?php if(isset($function_name) &&  $function_name == 'miscellaneous_invoice_listing'){ ?> class = 'active' <?php } ?>><a href="<?php echo site_url('corporate_portal/miscellaneous_invoice_listing'); ?>"><i class="fa fa-circle-o"></i>Miscellaneous Invoice</a></li>

                <li <?php if(isset($function_name) &&  $function_name == 'payment_history'){ ?> class = 'active' <?php } ?>><a href="<?php echo site_url('corporate_portal/payment_history'); ?>"><i class="fa fa-circle-o"></i>Payment History</a></li>
              </ul>
            </li>

             <li class="treeview"  <?php if(isset($function_name) &&  $function_name == 'system_email'){ ?> class = 'menu-open active' <?php } ?>>
              <a href="#">
                <i class="fa fa-envelope"></i> <span><?php echo $this->lang->line('system_email'); ?> </span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" <?php if(isset($function_name) && $function_name == 'system_email'){ ?> style="display: block; <?php } ?> ">
                <li <?php if(isset($function_name) &&  $function_name == 'system_email'){ ?> class = 'active' <?php } ?>><a href="<?php echo site_url('corporate_portal/system_email'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('email'); ?></a></li>
              </ul>
            </li>

            <li <?php if($controller_name == 'userguide'){ ?> class = 'active' <?php } ?> >
              <a href="#"><i class="fa fa-file-o"></i><span>Userguide</span>
              </a>
            </li>
      
    </ul>

<?php }
else if( $this->session->userdata('login_type') == 'student'){
  ?>
      <ul class="sidebar-menu" data-widget="tree">
           <li <?php if(isset($controller_name) && $controller_name== 'student_portal'){ ?> class = 'active' <?php } ?>>
              <a href="<?php echo base_url().'student_portal/'; ?>">
                <i class="fa fa-dashboard"></i><span>Dashboard</span>
              </a>
           </li>

           <li class="treeview"  <?php if(isset($function_name) &&  $function_name == 'document'){ ?> class = 'menu-open active' <?php } ?>>
              <a href="#">
                <i class="fa fa-folder"></i> <span><?php echo $this->lang->line('document'); ?> </span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" <?php if(isset($function_name) && $function_name == 'document'){ ?> style="display: block; <?php } ?> ">
                <li <?php if(isset($function_name) &&  $function_name == 'document'){ ?> class = 'active' <?php } ?>><a href="<?php echo site_url('student_portal/document'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('learning_material'); ?></a></li>
              </ul>
            </li>

            <li class="treeview  "<?php if(isset($function_name) &&  $function_name == 'course'){ ?> class = 'menu-open active' <?php } ?>>
              <a href="#">
                <i class="fa fa-inbox"></i> <span>My Course</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" <?php if($function_name == 'course' || $function_name == 'add_course' || $function_name == 'schedule' || $function_name == 'academic_history' || $function_name == 'makeup_list'){ ?> style="display: block; <?php } ?> ">

                <li <?php if(isset($function_name) &&  $function_name == 'course'){ ?> class = 'active' <?php } ?> ><a href="<?php echo site_url('student_portal/course'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('course');?></a></a></li>

                <li <?php if(isset($function_name) &&  $function_name == 'add_course'){ ?> class = 'active' <?php } ?> ><a href="<?php echo site_url('student_portal/add_course'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('course_registration');?></a></a></li>

                <li <?php if(isset($function_name) &&  $function_name == 'schedule'){ ?> class = 'active' <?php } ?> ><a href="<?php echo site_url('student_portal/schedule'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('schedule');?></a></a></li>
                <li <?php if(isset($function_name) &&  $function_name == 'academic_history'){ ?> class = 'active' <?php } ?> ><a href="<?php echo site_url('student_portal/academic_history'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('academic_history');?></a></a></li>
                 <li <?php if(isset($function_name) &&  $function_name == 'makeup_list'){ ?> class = 'active' <?php } ?>><a href="<?php echo site_url('student_portal/makeup_list'); ?>"><i class="fa fa-circle-o"></i> Makeup List</a></li>

              </ul>
            </li>

            <li class="treeview  "  <?php if(isset($menu) &&  $menu == 'Invoice Payment'){ ?> class = 'menu-open active' <?php } ?>>
              <a href="#">
                <i class="fa fa-inbox"></i> <span>Invoice Payment</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" <?php if($function_name == 'invoice' || $function_name == 'refund_invoice' || $function_name == 'miscellaneous_invoice_listing' || $function_name == 'payment_history' ){ ?> style="display: block; <?php } ?> ">

                <li <?php if(isset($function_name) &&  $function_name == 'invoice'){ ?> class = 'active' <?php } ?> ><a href="<?php echo site_url('student_portal/invoice'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('invoice');?></a></a></li>

                <li <?php if(isset($function_name) &&  $function_name == 'refund_invoice'){ ?> class = 'active' <?php } ?> ><a href="<?php echo site_url('student_portal/refund_invoice'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('refund_invoice');?></a></a></li>

                <li <?php if(isset($function_name) &&  $function_name == 'miscellaneous_invoice_listing'){ ?> class = 'active' <?php } ?> ><a href="<?php echo site_url('student_portal/miscellaneous_invoice_listing'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('miscellaneous_invoice');?></a></a></li>

                <li <?php if(isset($function_name) &&  $function_name == 'payment_history'){ ?> class = 'active' <?php } ?> ><a href="<?php echo site_url('student_portal/payment_history'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('payment_history');?></a></a></li>
              </ul>
            </li>

            <li class="treeview"  <?php if(isset($function_name) &&  $function_name == 'system_email'){ ?> class = 'menu-open active' <?php } ?>>
              <a href="#">
                <i class="fa fa-envelope"></i> <span><?php echo $this->lang->line('system_email'); ?> </span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" <?php if(isset($function_name) && $function_name == 'system_email'){ ?> style="display: block; <?php } ?> ">
                <li <?php if(isset($function_name) &&  $function_name == 'system_email'){ ?> class = 'active' <?php } ?>><a href="<?php echo site_url('student_portal/system_email'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('email'); ?></a></li>
              </ul>
            </li>


          <li <?php if($controller_name == 'userguide'){ ?> class = 'active' <?php } ?> >
              <a href="#"><i class="fa fa-file-o"></i><span>Userguide</span>
              </a>
            </li>
      </ul>

<?php } elseif( $this->session->userdata('login_type') == 'agent')
{
  ?>  
     <ul class="sidebar-menu" data-widget="tree">
       <li <?php if($controller_name == 'agent_portal'){ ?> class = 'active' <?php } ?> ><a href="<?php echo base_url().'agent_portal'; ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>

       <li class="treeview"  <?php if(isset($function_name) &&  $function_name == 'document'){ ?> class = 'menu-open active' <?php } ?>>
              <a href="#">
                <i class="fa fa-folder"></i> <span><?php echo $this->lang->line('document'); ?> </span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" <?php if(isset($function_name) && $function_name == 'document'){ ?> style="display: block; <?php } ?> ">
                <li <?php if(isset($function_name) &&  $function_name == 'document'){ ?> class = 'active' <?php } ?> ><a href="<?php echo site_url('agent_portal/document'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('learning_material'); ?></a></li>
              </ul>
            </li>

        <li class="treeview  "  <?php if(isset($menu) &&  $menu == 'Course'){ ?> class = 'menu-open active' <?php } ?>>
              <a href="#">
                <i class="fa fa-inbox"></i> <span>Client Company & Student<br/> Management</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" <?php if($function_name == 'corporate_list' || $function_name == 'student_list' || $function_name == 'add_course' || $function_name == 'course' || $function_name == 'schedule' || $function_name == 'academic_history' ){ ?> style="display: block; <?php } ?> ">

                <li <?php if(isset($function_name) &&  $function_name == 'corporate_list'){ ?> class = 'active' <?php } ?>><a href="<?php echo site_url('agent_portal/corporate_list'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('corporate_list');?></a></li>

                <li <?php if(isset($function_name) &&  $function_name == 'student_list'){ ?> class = 'active' <?php } ?> ><a href="<?php echo site_url('agent_portal/student_list'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('student_list');?></a></li>

                <li <?php if(isset($function_name) &&  $function_name == 'add_course'){ ?> class = 'active' <?php } ?> ><a href="<?php echo site_url('agent_portal/add_course'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('course_registration');?></a></li>

                <li <?php if(isset($function_name) &&  $function_name == 'course'){ ?> class = 'active' <?php } ?> ><a href="<?php echo site_url('agent_portal/course'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('course');?> </a></li>

                <li <?php if(isset($function_name) &&  $function_name == 'schedule'){ ?> class = 'active' <?php } ?>><a href="<?php echo site_url('agent_portal/schedule'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('schedule');?></a></li>

                <li <?php if(isset($function_name) &&  $function_name == 'academic_history'){ ?> class = 'active' <?php } ?>><a href="<?php echo site_url('agent_portal/academic_history'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('academic_history');?></a></li>
              </ul>
            </li>

            <li class="treeview  "  <?php if(isset($menu) &&  $menu == 'Invoice Payment'){ ?> class = 'menu-open active' <?php } ?>>
              <a href="#">
                <i class="fa fa-inbox"></i> <span>Invoice Payment</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" <?php if($function_name == 'invoice' || $function_name == 'refund_invoice' || $function_name == 'miscellaneous_invoice_listing' || $function_name == 'payment_history'){ ?>  style="display: block; <?php } ?> ">

                <li <?php if(isset($function_name) &&  $function_name == 'invoice'){ ?> class = 'active' <?php } ?> ><a href="<?php echo site_url('agent_portal/invoice'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('invoice');?></a></li>

                <li <?php if(isset($function_name) &&  $function_name == 'refund_invoice'){ ?> class = 'active' <?php } ?> ><a href="<?php echo site_url('agent_portal/refund_invoice'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('refund_invoice');?></a></li>

                <li <?php if(isset($function_name) &&  $function_name == 'miscellaneous_invoice_listing'){ ?> class = 'active' <?php } ?> ><a href="<?php echo site_url('agent_portal/miscellaneous_invoice_listing'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('miscellaneous_invoice');?></a></li>

                <li <?php if(isset($function_name) &&  $function_name == 'payment_history'){ ?> class = 'active' <?php } ?>><a href="<?php echo site_url('agent_portal/payment_history'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('payment_history');?></a></li>
              </ul>
            </li>

            <li class="treeview"  <?php if(isset($function_name) &&  $function_name == 'system_email'){ ?> class = 'menu-open active' <?php } ?>>
              <a href="#">
                <i class="fa fa-envelope"></i> <span><?php echo $this->lang->line('system_email'); ?> </span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" <?php if(isset($function_name) && $function_name == 'system_email'){ ?> style="display: block; <?php } ?> ">
                <li <?php if(isset($function_name) &&  $function_name == 'system_email'){ ?> class = 'active' <?php } ?>><a href="<?php echo site_url('agent_portal/system_email'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('email'); ?></a></li>
              </ul>
            </li>

            <li <?php if($controller_name == 'userguide'){ ?> class = 'active' <?php } ?> >
              <a href="#"><i class="fa fa-file-o"></i><span>Userguide</span>
              </a>
            </li>
      </ul>

<?php }

else if( $this->session->userdata('login_type') == 'tutor'){
  ?>
      <ul class="sidebar-menu" data-widget="tree">
           <li <?php if(isset($controller_name) && $controller_name== 'trainer_portal'){ ?> class = 'active' <?php } ?>>
              <a href="<?php echo base_url().'trainer_portal/profile'; ?>">
                <i class="fa fa-user"></i><span><?php echo $this->lang->line('profile'); ?></span>
              </a>
           </li>

            <li class="treeview  "  <?php if(isset($function_name) &&  $function_name == 'document'){ ?> class = 'menu-open active' <?php } ?>>
              <a href="#">
                <i class="fa fa-folder"></i> <span><?php echo $this->lang->line('document'); ?> </span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" <?php if(isset($function_name) && $function_name == 'document'){ ?> style="display: block; <?php } ?> ">
                <li <?php if(isset($function_name) &&  $function_name == 'document'){ ?> class = 'active' <?php } ?> ><a href="<?php echo site_url('trainer_portal/document'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('learning_material'); ?></a></li>
              </ul>
            </li>

            <li class="treeview  "  <?php if(isset($menu) &&  $menu == 'Invoice Payment'){ ?> class = 'menu-open active' <?php } ?>>
              <a href="#">
                <i class="fa fa-calendar"></i> <span> <?php echo $this->lang->line('schedule'); ?>  </span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" <?php if($function_name == 'schedule_list' || $controller_name == 'attendance' || $function_name == 'calendar' ){ ?>  style="display: block; <?php } ?> ">

                <li <?php if(isset($function_name) &&  $function_name == 'schedule_list'){ ?> class = 'active' <?php } ?> ><a href="<?php echo site_url('trainer_portal/schedule_list'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('schedule'); ?></a></li>

                <li <?php if(isset($controller_name) &&   $controller_name == 'attendance'){ ?> class = 'active' <?php } ?>><a href="<?php echo site_url('attendance'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('attendance'); ?></a></li>

                <li <?php if(isset($function_name) &&  $function_name == 'calendar'){ ?> class = 'active' <?php } ?>><a href="<?php echo site_url('trainer_portal/calendar'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('calendar'); ?></a></li>
                <li <?php if(isset($function_name) &&  $function_name == 'reject_request_list'){ ?> class = 'active' <?php } ?>><a href="<?php echo site_url('trainer_portal/reject_request_list'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('reject_request_list'); ?></a></li>
                
              </ul>
            </li>

            <li class="treeview  "  <?php if(isset($menu) &&  $menu == 'Invoice Payment'){ ?> class = 'menu-open active' <?php } ?>>
              <a href="#">
                <i class="fa fa-calendar-check-o"></i> <span> <?php echo $this->lang->line('attendance_and_leave'); ?>  </span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
               <ul class="treeview-menu" <?php if($function_name == 'attendance' || $controller_name == 'trainer_attendance' || $function_name == 'leave' ){ ?>  style="display: block; <?php } ?> ">

               <li <?php if(isset($function_name) &&  $function_name == 'attendance'){ ?> class = 'active' <?php } ?> ><a href="<?php echo site_url('trainer_portal/attendance'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('attendance_record');  ?></a></li>
               <li <?php if(isset($function_name) &&  $function_name == 'trainer_attendance'){ ?> class = 'active' <?php } ?> ><a href="<?php echo site_url('trainer_portal/trainer_attendance'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('mark_attendance');  ?></a></li>
                 <li <?php if(isset($function_name) &&  $function_name == 'leave'){ ?> class = 'active' <?php } ?> ><a href="<?php echo site_url('trainer_portal/leave'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('leave');  ?></a></li>
                
              </ul>
            </li>
            <li <?php if(isset($controller_name) && $controller_name== 'academic_management'){ ?> class = 'active' <?php } ?>>
              <a href="<?php echo base_url().'academic_management/index'; ?>">
                <i class="fa fa-user"></i><span><?php echo $this->lang->line('add_assessment'); ?></span>
              </a>
            </li>

            <li class="treeview"  <?php if(isset($function_name) &&  $function_name == 'post_course_evaluation'){ ?> class = 'menu-open active' <?php } ?>>
              <a href="#">
                <i class="fa fa-envelope"></i> <span><?php echo $this->lang->line('post_course_evaluation'); ?> </span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" <?php if(isset($function_name) && $function_name == 'evaluation_report'){ ?> style="display: block; <?php } ?> ">
                <li <?php if(isset($function_name) &&  $function_name == 'evaluation_report'){ ?> class = 'active' <?php } ?>><a href="<?php echo site_url('post_course_evaluation/evaluation_report'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('student_evaluation_report_list'); ?></a></li>
              </ul>
            </li>
             <li class="treeview"  <?php if(isset($function_name) &&  $function_name == 'system_email'){ ?> class = 'menu-open active' <?php } ?>>
              <a href="#">
                <i class="fa fa-envelope"></i> <span><?php echo $this->lang->line('system_email'); ?> </span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" <?php if(isset($function_name) && $function_name == 'system_email'){ ?> style="display: block; <?php } ?> ">
                <li <?php if(isset($function_name) &&  $function_name == 'system_email'){ ?> class = 'active' <?php } ?>><a href="<?php echo site_url('trainer_portal/system_email'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('email'); ?></a></li>
              </ul>
            </li>

            <li class="treeview"  <?php if(isset($function_name) &&  $function_name == 'trainer_payroll'){ ?> class = 'menu-open active' <?php } ?>>
              <a href="#">
                <i class="fa fa-money"></i> <span><?php echo $this->lang->line('payroll'); ?> </span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" <?php if(isset($function_name) && $function_name == 'payment_history'){ ?> style="display: block; <?php } ?> ">
                <li <?php if(isset($function_name) &&  $function_name == 'system_email'){ ?> class = 'active' <?php } ?>><a href="<?php echo site_url('trainer_portal/trainer_payroll'); ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('payment_list'); ?></a></li>
              </ul>
            </li>

            <!-- <li <?php if(isset($menu) && $menu== 'Profile'){ ?> class = 'active' <?php } ?>>
              <a href="#">
                <i class="fa fa-user"></i><span><?php echo $this->lang->line('declaration_record');  ?></span>
              </a>
           </li> -->
      </ul>

<?php }

else{
	?>
	      <ul class="sidebar-menu" data-widget="tree">
        <?php
			$arrControllerMenuKeys = array();
			if(isset($arrMenu["controller"]) && count($arrMenu["controller"]) > 0 && isset($arrMenu["controller"][$controller_name]) && count($arrMenu["controller"][$controller_name]) > 0){
				$arrControllerMenuKeys = $arrMenu["controller"][$controller_name];
			}
		    if(isset($arrMenu["parent_menu"]) && count($arrMenu["parent_menu"]) > 0){   
				foreach($arrMenu["parent_menu"] as $menu_key => $parent_menu){
					$current = '';
                    $current_open = '';
                    $menu_open = '';
                    $active = '';
					
					if(in_array($menu_key,$arrControllerMenuKeys)){
						$menu_open = 'menu-open';
						$active = 'active';
					}
					?>
					
					<?php
					if(isset($arrMenu["first_child_menu"]) && count($arrMenu["first_child_menu"]) > 0 
							&& isset($arrMenu["first_child_menu"][$menu_key]) && count($arrMenu["first_child_menu"][$menu_key]) > 0){
						?>
						<li class=" treeview <?php echo $menu_open; ?> <?php echo $active; ?> ">
							<a href="#">
								<i class="<?php echo $parent_menu['icon']; ?>"></i> <span> <?php echo wordwrap($this->lang->line($parent_menu['lang_menu_name']),30,"<br>\n"); ?></span>
								<span class="pull-right-container">
								  <i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">	
						<?php
						foreach($arrMenu["first_child_menu"][$menu_key] as $fmenu_key => $first_child_menu){
							$menu_open = '';
							$active = '';
              $data_toggle = '';
              $data_target = '';

              if($first_child_menu['controller'] == 'quotation_management' && $first_child_menu['default_action'] == 'add'  ||  $first_child_menu['controller'] == 'consultancy_project' && $first_child_menu['default_action'] == 'add_consultancy_project'  ){
                  $data_target = 'data-target="#modal-default"';
                  $data_toggle = 'data-toggle="modal"';
              }


							if(in_array($fmenu_key,$arrControllerMenuKeys)){
								$menu_open = 'menu-open';
								$active = 'active';
							}
                    ?>
						
							<?php
							if(isset($arrMenu["second_child_menu"]) && count($arrMenu["second_child_menu"]) > 0 
										&& isset($arrMenu["second_child_menu"][$fmenu_key]) && count($arrMenu["second_child_menu"][$fmenu_key]) > 0){
							?>
								<li class="treeview <?php echo $menu_open; ?> <?php echo $active; ?> ">
									<a href="#">
										<i class="<?php echo $first_child_menu['icon']; ?>"></i>  <?php echo wordwrap($this->lang->line($first_child_menu['lang_menu_name']),30,"<br>\n"); ?>
										<span class="pull-right-container">
										  <i class="fa fa-angle-left pull-right"></i>
										</span>
									</a>
									<ul class="treeview-menu">
								<?php
								foreach($arrMenu["second_child_menu"][$fmenu_key] as $smenu_key => $second_child_menu){
									$menu_open = '';
									$active = '';
									if(in_array($smenu_key,$arrControllerMenuKeys)){
										$menu_open = 'menu-open';
										$active = 'active';
									}
									?>								
										<li class="<?php echo $active; ?> ">
											<a href="<?php print site_url($second_child_menu['controller']."/".$second_child_menu['default_action']); ?>" <?=$data_target?> <?=$data_toggle?>>
												<i class="<?php echo $second_child_menu['icon']; ?>"></i> <?php echo wordwrap($this->lang->line($second_child_menu['lang_menu_name']),30,"<br>\n"); ?> 
											</a>
										</li>
									<?php
								}
								?>
									</ul>
								</li>	
								<?php
							}
							else
							{
							?>
								<li class="<?php echo $menu_open; ?> <?php echo $active; ?> ">
									<a href="<?php print site_url($first_child_menu['controller']."/".$first_child_menu['default_action']); ?>" <?=$data_target?> <?=$data_toggle?>>
										<i class="<?php echo $first_child_menu['icon']; ?>"></i>  <?php echo wordwrap($this->lang->line($first_child_menu['lang_menu_name']),30,"<br>\n"); ?>
									</a>
								</li>
							<?php	
							}
						}
						?>
							</ul> 
						</li> 
					 <?php
                    }
					else
					{
					?>
						<li class="<?php echo $menu_open; ?> <?php echo $active; ?> ">
							<a href="<?php print site_url($parent_menu['controller']."/".$parent_menu['default_action']); ?>">
								<i class="<?php echo $parent_menu['icon']; ?>"></i> <span><?php echo wordwrap($this->lang->line($parent_menu['lang_menu_name']),30,"<br>\n"); ?></span>
							</a>
						</li>
					<?php	
					}
                } 
            }
            ?>
       
      </ul>
	<?php
} ?>
    </section>
</aside>
