<?php $tempId = 0; $loopCount = 0; $salaryHeadName = "";?>
<input disabled type="hidden" id="recNum" value="<?php echo $rec ?>" />
<table cellspacing="1" cellpadding="1" class="sample1" style="font-family: Arial; font-size: 14px; width: 100%;">
    <thead>
        <tr>
            <th style="text-align: left">Employee Type</th>
            <?php foreach ($salaryTypeQuery as $qry => $row):?>
                <th style="text-align: left"><?php echo $row[$tableFeild5]; ?></th>
            <?php endforeach;?>
            <th style="text-align: left">Action</th>
        </tr>
    </thead>
    <tbody>
            
            <?php foreach ($employeeQuery as $key => $value) {?>
                <tr>
                    <td><?php echo $value[$tableFeild2]; ?></td>
                    <?php foreach ($query as $key1 => $value1){?>
                            <?php if($value1[$tableFeild1] == $value[$tableFeild1]){?>
                                  <td><?php echo $value1[$tableFeild4]; ?></td>

                            <?php }?>
                    <?php }?>
                    <td style="text-align: left">
                        <table style="width: 100%; border: none;">
                            <tr>
                                <td style="text-align: left;"><a href="<?php echo base_url();echo $controllerName;?>/viewEdit/<?php echo $value[$tableFeild1]; ?>" title="Edit"><img alt="edit" src="<?php echo base_url();?>images/edit.png" /></a></td>
                                <td style="text-align: right;"><a href="<?php echo base_url();echo $controllerName;?>/delete/<?php echo $value[$tableFeild1]; ?>" title="Delete"><img alt="edit" src="<?php echo base_url();?>images/delete.png" /></a></td>
                            </tr>
                        </table>
                    </td>            
                </tr>
            <?php }?>
            
            
    </tbody>
</table>
