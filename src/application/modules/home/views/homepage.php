<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        <?php echo $this->lang->line('dashboard'); ?>	
        </h1>
    </section>
    <!-- Main content -->
    <?php if($this->session->userdata('role_id') == '1') { ?> 

    <section class="content">
        

        <div class="row">
            <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $this->lang->line('revenue_from_each_course'); ?></h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <canvas id="pieChart" style="height: 265px; width: 530px;" width="530" height="265"></canvas>
                </div>
            <!-- /.box-body -->
             </div>
          <!-- /.box -->
        </div>
        <div class="col-md-6">
            <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $this->lang->line('revenue_over_time'); ?></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="barChart" style="height: 230px; width: 510px;" width="510" height="230"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>

        </div>
        <div class="row">

          <div class="col-md-12"> 
            <div class="box box-default" style="display: none;">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $this->lang->line('today_s_class_and_attendance_sheets'); ?></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
                 <div class="box-body">
              <div class="row">
               
                <!-- /.col -->
               
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            </div>
          </div>
        </div>
        </div>
    </section>

     <?php } ?> 
  <!-- /.content -->
</div>
