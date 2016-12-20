        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            
            <!-- Top Bar -->
            <?php $this->load->view('template/top-bar');?>
            <!-------------->
            <div class="navbar-default sidebar" role="navigation">
               <div id="MainMenu">
                <div class="list-group panel">
                    <a href="#demo3" class="list-group-item list-group-item-info" data-toggle="collapse" data-parent="#MainMenu">Setup</a>
                    <div class="collapse" id="demo3">
                            <a href="<?php echo base_url();?>unit" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Unit</a>
                            <a href="<?php echo base_url();?>floor" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Floor</a>
                            <a href="<?php echo base_url();?>section" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Section</a>
                            <a href="<?php echo base_url();?>subsection" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Subsection</a>
                            <a href="<?php echo base_url();?>incharge" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Incharge</a>
                            <a href="<?php echo base_url();?>supervisor" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Supervisor</a>
                            <a href="<?php echo base_url();?>major_parts" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Major Parts</a>
                            <a href="<?php echo base_url();?>employee_type" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Employee Type</a>
                            <a href="<?php echo base_url();?>designation" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Designation</a>
                            <a href="<?php echo base_url();?>currency" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Currency</a>
                            <a href="<?php echo base_url();?>shift" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Shift</a>
                            <a href="<?php echo base_url();?>guage" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Gauge</a>
                            <a href="<?php echo base_url();?>block" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Block/Line</a>
                            <a href="<?php echo base_url();?>leave" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Leave Settings</a>
                            <a href="<?php echo base_url();?>production_bonus_setup" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Production Bonus Setup</a>
                            <a href="<?php echo base_url();?>attendance_bonus_setup" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Attendance Bonus Setup</a>                           
<!--                            
                            
                            <a href="<?php echo base_url();?>attendance" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Attendance Setting</a>
                            <a href="<?php echo base_url();?>leave" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Leave Settings</a>
                            <a href="<?php echo base_url();?>holiday" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Holliday Settings</a>-->
     <!--                         <a href="javascript:;" class="list-group-item">Subitem 2</a>
                            <a href="javascript:;" class="list-group-item">Subitem 3</a>
                          <a href="#SubMenu1" class="list-group-item" data-toggle="collapse" data-parent="#SubMenu1">Subitem 1 <i class="fa fa-caret-down"></i></a>
                            <div class="collapse list-group-submenu" id="SubMenu1">
                                <a href="#" class="list-group-item" data-parent="#SubMenu1">Subitem 1 a</a>
                                <a href="#" class="list-group-item" data-parent="#SubMenu1">Subitem 2 b</a>
                                <a href="#SubSubMenu1" class="list-group-item" data-toggle="collapse" data-parent="#SubSubMenu1">Subitem 3 c <i class="fa fa-caret-down"></i></a>
                                <div class="collapse list-group-submenu list-group-submenu-1" id="SubSubMenu1">
                                    <a href="#" class="list-group-item" data-parent="#SubSubMenu1">Sub sub item 1</a>
                                    <a href="#" class="list-group-item" data-parent="#SubSubMenu1">Sub sub item 2</a>
                                </div>
                                <a href="#" class="list-group-item" data-parent="#SubMenu1">Subitem 4 d</a>
                            </div>-->

                        </div>
                    <a href="#demo4" class="list-group-item list-group-item-info" data-toggle="collapse" data-parent="#MainMenu">Employee Settings</a>
                        <div class="collapse" id="demo4">
                            <a href="<?php echo base_url();?>employee" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Employee Entry</a>
                            <a href="<?php echo base_url();?>photo" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Photo Upload</a>
                            <a href="<?php echo base_url();?>barcode" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Barcode</a>
                            <a href="<?php echo base_url();?>employee_transfer" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Employee Transfer</a>
                            <a href="#" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Employee Promotion</a>
                            <a href="#" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Issue Employee Bar Code</a>
                            <a href="<?php echo base_url();?>daily_attendance" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Daily Employee Attendance</a>
                        </div>
                    <a href="#demo5" class="list-group-item list-group-item-info" data-toggle="collapse" data-parent="#MainMenu">Product Settings</a>
                        <div class="collapse" id="demo5">
                            <a href="<?php echo base_url();?>product_section" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Product Section</a>
                            <a href="<?php echo base_url();?>buyer" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Product Buyer</a>
                            <a href="<?php echo base_url();?>season" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Product Season</a>
                            <a href="<?php echo base_url();?>style" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Product Style</a>
                            <a href="<?php echo base_url();?>size" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Product Size</a>
                            <a href="<?php echo base_url();?>product_operation" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Product Operation</a>
                            <a href="<?php echo base_url();?>production_entry" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Production Entry</a>
                            <a href="<?php echo base_url();?>production_view" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Production View</a>
                            <a href="<?php echo base_url();?>active" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Activate/Deactivate </a>
                        </div>
                    <a href="#demo6" class="list-group-item list-group-item-info" data-toggle="collapse" data-parent="#MainMenu">Salary Settings</a>
                        <div class="collapse" id="demo6">
                            <a href="<?php echo base_url();?>salary_type" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;" data-parent="#SubMenu1">Salary Head</a>
                            <a href="<?php echo base_url();?>salary_earning" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;" data-parent="#SubMenu1">Salary Earning Head</a>
                            <a href="<?php echo base_url();?>salary_deduct" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;" data-parent="#SubMenu1">Salary Deduction Head</a>
                            <a href="<?php echo base_url();?>attendance_bonus" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Attendance Bonus</a>
                            <a href="<?php echo base_url();?>overtime_bonus" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Overtime Bonus</a>
                            <a href="<?php echo base_url();?>production_bonus" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Production Bonus</a>
                            <a href="<?php echo base_url();?>salary_sheet" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;" data-parent="#SubMenu1">Salary Sheet</a>
                            <a href="<?php echo base_url();?>salary_sheet_view" class="list-group-item" style="height: 25px;padding-top: 3px;padding-bottom: 3px;">Salary Report</a>
                        </div>
                </div>
            </div>
        </div>
            <!-- /.navbar-static-side -->
    </nav>