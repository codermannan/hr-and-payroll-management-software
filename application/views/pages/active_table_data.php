<input disabled type="hidden" id="recNum" value="<?php echo $rec ?>" />
<table cellspacing="1" cellpadding="1" class="sample1" style="font-family: Arial; font-size: 14px">
    <thead>
        <tr>
            <th width="60" style="text-align: left">Id</th>
            <th width="120" style="text-align: left">Season</th>
            <th width="120" style="text-align: left">Section</th>
            <th width="400" style="text-align: left">Description</th>
            <th width="110" style="text-align: left">Measurement</th>
            <th width="70" style="text-align: left">Rates</th>
            <th width="120" style="text-align: left">Action</th>
            
        </tr>
    </thead>
    <tbody>
<?php 
    foreach ($query as $qry => $row):
   
?>
         
    <tr>
        <td style="text-align: left"><?= $row[$tableFeild1]; ?></td>
        <td style="text-align: left"><?= $row[$tableFeild2]; ?></td>
        <td style="text-align: left"><?= $row[$tableFeild4]; ?></td>
        <td style="text-align: left">
            <?= $row[$tableFeild3]; ?> 
            <?= $row[$tableFeild5]; ?> 
            <?= $row[$tableFeild6]; ?> 
            <?= $row[$tableFeild2]; ?>
            <?= $row[$tableFeild9]; ?>
        </td>
        <td style="text-align: left"><?= $row[$tableFeild8]; ?></td>
        <td style="text-align: right"><?= $row[$tableFeild10]; ?> BDT</td>
        <td>
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
