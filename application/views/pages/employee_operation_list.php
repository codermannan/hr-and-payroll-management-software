<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.11.1.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/table-css.css" />
<style>
#searchOperationTable {
        width: 100%;
    }
    
#searchOperationTable th {
        border: 1px solid #c4c4c4; 
        height: 25px; 
        font-size: 11px;
        font-family: verdana;
        padding: 4px 4px 4px 4px; 
        border-radius: 4px; 
        -moz-border-radius: 4px; 
        -webkit-border-radius: 4px; 
        box-shadow: 0px 0px 8px #d9d9d9; 
        -moz-box-shadow: 0px 0px 8px #d9d9d9; 
        -webkit-box-shadow: 0px 0px 8px #d9d9d9; 
    }
  #searchOperationTable td {
        border: 1px solid #7bc1f7; 
         //height: 10px; 
        font-size: 11px;
        font-family: verdana;
        padding: 0px 5px 0px 5px; 
        border-radius: 4px; 
        -moz-border-radius: 4px; 
        -webkit-border-radius: 4px; 
        box-shadow: 0px 0px 8px #d9d9d9; 
        -moz-box-shadow: 0px 0px 8px #d9d9d9; 
        -webkit-box-shadow: 0px 0px 8px #d9d9d9; 
    }
   #searchOperationTable input[type="text"]
    {
        border: 1px solid #c4c4c4; 
        height: 22px; 
        width: 60px; 
        font-size: 11px;
        font-family: verdana;
        padding: 4px 4px 4px 4px; 
        border-radius: 4px; 
        -moz-border-radius: 4px; 
        -webkit-border-radius: 4px; 
        box-shadow: 0px 0px 8px #d9d9d9; 
        -moz-box-shadow: 0px 0px 8px #d9d9d9; 
        -webkit-box-shadow: 0px 0px 8px #d9d9d9; 
    }
    #searchOperationTable input[type="text"]:focus
    {
        outline: none; 
        border: 1px solid #7bc1f7; 
        box-shadow: 0px 0px 8px #7bc1f7; 
        -moz-box-shadow: 0px 0px 8px #7bc1f7; 
        -webkit-box-shadow: 0px 0px 8px #7bc1f7; 
    }
    
</style>
<script type="text/javascript">

$(document).ready(function() {
    $('#searchOperationTable').dataTable( {
        "pagingType": "full_numbers"
    } );
    
} );



</script>
<body>
    <!-- /.row -->
    <div class="row">

        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                   Employee Production Operation Lists 
                </div>

                <div class="panel-body">
                    <div id="searchPanel">
                        <table id="searchOperationTable">
                            <thead>
                                <tr>
                                    <th width="50" style="text-align: left">ID</th>
                                    <th width="60" style="text-align: left">Section</th>
                                    <th width="400" style="text-align: left">Description</th>
                                    <th width="60" style="text-align: left">Measure</th>
                                    <th width="50" style="text-align: left">Rate</th>
                                    <th width="70" style="text-align: left">Quantity</th>
                                    <th width="100" style="text-align: left">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $attributes = array('name' => 'form-operation', 'id' => 'form-operation', 'class' => 'form-operation');
                                    echo form_open("product_operation/submitData", $attributes);
                                ?>
                                <?php foreach ($employeeProductionOperation as $key => $row):?>
                                <tr>
                                    <td><?php echo $row['production_operation_id'];?></td>
                                    <td><?php echo $row['product_section_name'];?></td>
                                    <td>
                                        <?php echo $row['buyer_name']." ".$row['style_name']." ".$row['guage_size']." ".$row['product_section_name']." ".$row['size_name']." ".$row['major_parts'];?>
                                    </td>
                                    <td><?php echo $row['measurement_name'];?></td>
                                    <td><?php echo $row['rate'];?></td>
                                    <td><?php echo $row['production_quantity'];?></td>
                                    <td><?php $d=strtotime($row['operation_date']);echo date('d.m.Y', $d);?></td>
                                </tr>
                                <?php endforeach;?>
                             </tbody>    
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-lg-4 -->
    </div>
        
</body>
