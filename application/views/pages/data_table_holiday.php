<input disabled type="hidden" id="recNum" value="<?php echo $rec ?>" />
<table cellspacing="1" cellpadding="1" class="sample1" style="font-family: Arial; font-size: 14px">
    <thead>
        <tr>
            <th width="100" style="text-align: left">Code</th>
            <th width="250" style="text-align: left">Name</th>
            <?php if(isset($tableFeild3)){?>
            <th width="250" style="text-align: left">From</th>
            <?php }?>
            <?php if(isset($tableFeild4)){?>
            <th width="250" style="text-align: left">To</th>
            <?php }?>
            <th width="60" style="text-align: left">Action</th>
            
        </tr>
    </thead>
    <tbody>
<?php foreach ($query as $qry => $row):?>
         
    <tr>
        <td style="text-align: left"><?= $row[$tableFeild1]; ?></td>
        <td style="text-align: left"><?= $row[$tableFeild2]; ?></td>
        <?php
            $originalDate1 = $row[$tableFeild3];
            $newDate1 = date("d.m.Y", strtotime($originalDate1));
        ?>
        <td style="text-align: left"><?= $newDate1; ?></td>
        <?php
            $originalDate2 = $row[$tableFeild4];
            $newDate2 = date("d.m.Y", strtotime($originalDate2));
        ?>
        <td style="text-align: left"><?= $newDate2; ?></td>
        
        <td style="text-align: left">
            <table style="width: 100%; border: none;">
                <tr>
                    <td style="text-align: left;"><a href="<?php echo base_url();echo $controllerName;?>/viewEdit/<?= $row[$tableFeild1]; ?>" title="Edit"><img alt="edit" src="<?php echo base_url();?>images/edit.png" /></a></td>
                    <td style="text-align: right;"><a href="<?php echo base_url();echo $controllerName;?>/delete/<?= $row[$tableFeild1]; ?>" title="Delete"><img alt="edit" src="<?php echo base_url();?>images/delete.png" /></a></td>
                </tr>
            </table>
        </td>
    </tr>
    
<?php endforeach; ?>
    </tbody>
</table>
