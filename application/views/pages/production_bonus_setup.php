<?php $this->load->view('template/header');?>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/table-css.css" />
<script type="text/javascript">
$(document).ready(function() {
    $('#searchTable').dataTable( {
        "pagingType": "full_numbers"
    } );
} );
</script>
<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php $this->load->view('template/menu');?>
        <!---------------->
        
        <div id="page-wrapper">
            <h4>Production Bonus Setup Panel</h4>
            <div class="row">
                <div class="col-lg-12">
                    <?php if(isset($successInsered)){?>
                        <div class="alert alert-success" role="alert"><?php echo $successInsered;?></div>
                    <?php 
                        }
                        if(isset($errorInsered))
                        {
                    ?>
                        <div class="alert alert-danger" role="alert"><?php echo $errorInsered;?></div>
                    <?php }?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <!-- /.col-lg-4 -->
                <div class="col-lg-8">
                    <div class="panel panel-info">
                        <div class="panel-heading ">
                            Production Bonus Search Panel
                        </div>
                        <div class="panel-body">
                            <div id="searchPanel">
                                <table id="searchTable">
                                    <thead>
                                        <tr>
                                            <th width="100" style="text-align: left">Designation</th>
                                            <th width="150" style="text-align: left">Bonus Title</th>
                                            <th width="150" style="text-align: left">Bonus Starting Range</th>
                                            <th width="150" style="text-align: left">Bonus Ending Range</th>
                                            <th width="100" style="text-align: left">Bonus Percentage</th>
                                            <th width="100" style="text-align: left">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <?php foreach ($productionBonusSetupTableData as $values):?>
                                            <tr>
                                                <td><?php echo $values['designation_name'];?></td>
                                                <td><?php echo $values['production_bonus_setup_title'];?></td>
                                                <td><?php echo $values['production_bonus_setup_start'];?></td>
                                                <td><?php echo $values['production_bonus_setup_end'];?></td>
                                                <td><?php echo $values['production_bonus_setup_percentage'];?></td>
                                                <td>
                                                    <table style="width: 100%; border: none;">
                                                        <tr>
                                                            <td style="text-align: left;"><a href="<?php echo base_url();?>production_bonus_setup/viewEdit/<?php echo $values['production_bonus_setup_id'];?>" title="Edit"><img alt="edit" src="<?php echo base_url();?>images/edit.png" /></a></td>
                                                            <td style="text-align: right;"><a href="<?php echo base_url();?>production_bonus_setup/delete/<?php echo $values['production_bonus_setup_id'];?>" title="Delete"><img alt="edit" src="<?php echo base_url();?>images/delete.png" /></a></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <?php endforeach;?>
                                     </tbody>    
                                </table>
                            </div>
                        </div>
                        <div class="panel-footer">
                            
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-4 -->
                <div class="col-lg-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Production Bonus Entry Panel
                        </div>
                        <?php if(validation_errors()) echo '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>'; if(isset($errorMessage)) echo '<div class="alert alert-danger" role="alert">'.$errorMessage.'</div>';?>
                        <?php
                            $attributes = array('name' => 'form-production-bonus-setup', 'id' => 'form-production-bonus-setup', 'class' => 'form-production-bonus-setup');
                            if(isset($production_bonus_setup_id))
                            {
                                echo form_open("production_bonus_setup/edit", $attributes);
                                echo "<input type='text' hidden name='systemId' id='systemId' value='".$production_bonus_setup_id."' />";
                            }
                            else
                            {
                                echo form_open("production_bonus_setup/submitData", $attributes);
                            }
                        ?>
                        <div class="panel-body">
                            <table id="entry-panel">
                                <tr>
                                    <td>Select Designation</td>
                                    <td>
                                        <select  name="designation" id="designation" required>
                                            <option disabled>Select designation</option>
                                            <?php 
                                                if(isset($designation))
                                                {
                                                    if(isset($designation_id))
                                                    {
                                                        
                                            ?>            
                                                        <option value="<?php echo $designation_id;?>" selected><?php echo $designation_name;?></option>
                                            <?php        
                                                        
                                                    }
                                                    foreach ($designation as $key => $row):
                                            ?>
                                                    <option value="<?php echo $row['designation_id'];?>"><?php echo $row['designation_name'];?></option>
                                            <?php
                                                    endforeach;
                                                }
                                                else
                                                {
                                            ?>        
                                                    <option value='0'>Designation Not Found</option>
                                            <?php } ?>        
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Bonus Title</td>
                                    <td><input type="text" placeholder="Bonus Title" name="bonusTitle" id="bonusTitle" required value="<?php if(isset($production_bonus_setup_title)) echo $production_bonus_setup_title;?>" /></td>
                                </tr>
                                <tr>
                                    <td>Bonus From</td>
                                    <td><input type="text" placeholder="Bonus Ending Range" name="bonusStart" id="bonusStart" value="<?php if(isset($production_bonus_setup_start)) echo $production_bonus_setup_start;?>" required /></td>
                                </tr>
                                <tr>
                                    <td>Bonus To</td>
                                    <td><input type="text" placeholder="Bonus Starting Range" name="bonusEnd" id="bonusEnd" value="<?php if(isset($production_bonus_setup_end)) echo $production_bonus_setup_end;?>" required /></td>
                                </tr>
                                <tr>
                                    <td>Bonus percentage (%)</td>
                                    <td><input type="text" placeholder="Bonus Percentage" name="bonusPercentage" id="bonusPercentage" value="<?php if(isset($production_bonus_setup_percentage)) echo $production_bonus_setup_percentage;?>" required /></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                    <?php
                                    if(isset($production_bonus_setup_id))
                                    {
                                        $submitButton = array(
                                            'name' => 'submit',
                                            'id' => 'submit',
                                            'value' => 'Update',
                                            'type' => 'submit',
                                            'class' => 'btn btn-success'
                                        );

                                        echo form_submit($submitButton);
                                    }
                                    else 
                                    {
                                        $submitButton = array(
                                            'name' => 'submit',
                                            'id' => 'submit',
                                            'value' => 'Submit',
                                            'type' => 'submit',
                                            'class' => 'btn btn-success'
                                        );

                                        echo form_submit($submitButton);
                                    }
                                    ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <?php echo form_close();?>
                        <div class="panel-footer" style="text-align: right;">
                            <?php if(isset($production_bonus_setup_id)){?>
                                  <a href="<?php echo base_url();?>production_bonus_setup">New Entry</a>
                            <?php }?>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
<?php $this->load->view('template/footer');?>