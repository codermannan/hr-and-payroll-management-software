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

function closeFunction()
{
    var checkedValue = null;
    document.getElementById('productOperation_<?php echo $employeeID;?>').innerHTML = "";
    document.getElementById('hiddenOperationIdField_<?php echo $employeeID;?>').innerHTML = "";
    document.getElementById('hiddenQuantityField_<?php echo $employeeID;?>').innerHTML = "";
    var inputElements = document.getElementsByClassName('operationId');
    //alert(inputElements.length);
    for(var i=0; inputElements[i]; ++i)
    {
        if(inputElements[i].checked)
        {
            checkedValue = inputElements[i].value;
            $('#productOperation_<?php echo $employeeID;?>').append("Operation: " +$('#productionDescription_'+checkedValue).val()+ "");
            $('#productOperation_<?php echo $employeeID;?>').append("&nbsp;&nbsp;&nbsp;Quantity: " +$('#quantity_'+checkedValue).val()+ "<br />");
            $('#hiddenOperationIdField_<?php echo $employeeID;?>').append(checkedValue+ " ");
            $('#hiddenQuantityField_<?php echo $employeeID;?>').append($('#quantity_'+checkedValue).val()+ " ");
        }
    }
    
    $('#cboxClose').click();
    
}

</script>
<body>
    <!-- /.row -->
    <div class="row">

        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Production Operation List Panel 
                </div>

                <div class="panel-body">
                    <div id="searchPanel">
                        <table id="searchOperationTable">
                            <thead>
                                <tr>
                                    <th width="70" style="text-align: center;">Select</th>
                                    <th width="60" style="text-align: left">Id</th>
                                    <th width="450" style="text-align: left">Description</th>
                                    <th width="110" style="text-align: left">Measurement</th>
                                    <th width="70" style="text-align: left">Rates</th>
                                    <th width="70" style="text-align: left">Quantity</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $attributes = array('name' => 'form-operation', 'id' => 'form-operation', 'class' => 'form-operation');
                                    echo form_open("product_operation/submitData", $attributes);
                                ?>
                                <?php foreach ($productionOperation as $key => $row):?>
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="checkbox" id="operationId" class="operationId" value="<?= $row['operation_id']; ?>" />
                                    </td>
                                    <td><?php echo $row['operation_id'];?></td>
                                    <td>
                                        <?php echo $row['buyer_name']." ".$row['style_name']." ".$row['guage_size']." ".$row['product_section_name']." ".$row['size_name']." ".$row['major_parts'];?>
                                        <input id="productionDescription_<?php echo $row['operation_id'];?>" name="productionDescription_<?php echo $row['operation_id'];?>" type="text" hidden value="<?php echo $row['buyer_name']." ".$row['style_name']." ".$row['guage_size']." ".$row['product_section_name']." ".$row['size_name']." ".$row['major_parts'];?>" />
                                    </td>
                                    <td><?php echo $row['measurement_name'];?></td>
                                    <td><?php echo $row['rate'];?></td>
                                    <td><input type="text" name="quantity_<?php echo $row['operation_id'];?>" id="quantity_<?php echo $row['operation_id'];?>" /></td>
                                </tr>
                                <?php endforeach;?>
                             </tbody>    
                        </table>
                    </div>
                </div>
                <div class="panel-footer" style="text-align: right;">
                    <?php
                                        
                        $submitButton = array(
                            'name' => 'submit',
                            'id' => 'submit',
                            'value' => 'Apply',
                            'type' => 'submit',
                            'class' => 'btn btn-success',
                            'onclick' => 'closeFunction()',
                        );

                        echo form_submit($submitButton);

                    ?>
                </div>
                <?php echo form_close();?>
            </div>
        </div>
        <!-- /.col-lg-4 -->
    </div>
        
</body>
