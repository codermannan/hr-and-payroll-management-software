<input disabled type="hidden" id="recNum" value="<?php echo $rec ?>" />
<table cellspacing="1" cellpadding="1" class="sample1" style="font-family: Arial; font-size: 14px">
    <thead>
        <tr>
            <th style="text-align: left">Code</th>
            <th style="text-align: left">Unit Name</th>
            <th style="text-align: left">Floor Name</th>
            <th style="text-align: left">Section Name</th>
            <th style="text-align: left">Sub Section Name</th>
            <th style="text-align: left">Incharge Name</th>
            <th style="text-align: left">Guage Name</th>
            <th style="text-align: left">Action</th>
            
        </tr>
    </thead>
    <tbody>
<?php foreach ($query as $qry => $row):?>
         
    <tr>
        <td style="text-align: left"><?= $row[$tableFeild1]; ?></td>
        <td style="text-align: left"><?= $row[$tableFeild2]; ?></td>
        <td style="text-align: left"><?= $row[$tableFeild3]; ?></td>
        <td style="text-align: left"><?= $row[$tableFeild4]; ?></td>
        <td style="text-align: left"><?= $row[$tableFeild5]; ?></td>
        <td style="text-align: left"><?= $row[$tableFeild6]; ?></td>
        <td style="text-align: left"><?= $row[$tableFeild7]; ?></td>
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
