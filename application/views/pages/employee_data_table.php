<input disabled type="hidden" id="recNum" value="<?php echo $rec ?>" />
<table cellspacing="1" cellpadding="1" class="sample1" style="font-family: Arial; font-size: 14px">
    <thead>
        <tr>
            <th width="170" style="text-align: left">Id</th>
            <th width="170" style="text-align: left">Employee Code</th>
            <th width="170" style="text-align: left">Employee Name</th>
            <th width="170" style="text-align: left">Designation</th>
            <th width="170" style="text-align: left">Joining Date</th>
            <th width="170" style="text-align: left">Action</th>
        </tr>
    </thead>
    <tbody>
<?php 
    foreach ($query as $qry => $row):
   
?>
         
    <tr>
        <td style="text-align: left"><?= $row[$tableFeild1]; ?></td>
        <td style="text-align: left"><?= $row[$tableFeild2]; ?>-<?= $row[$tableFeild3]; ?></td>
        <td style="text-align: left"><?= $row[$tableFeild4]; ?></td>
        <td style="text-align: left"><?= $row[$tableFeild5]; ?></td>
        <td style="text-align: left"><?= $row[$tableFeild6]; ?></td>
        <td style="text-align: left">
            <a href="<?php echo base_url();?>employee/viewEdit/<?= $row[$tableFeild1]; ?>">Edit</a>&nbsp;
            <a href="<?php echo base_url();?>employee/delete/<?= $row[$tableFeild1]; ?>">Delete</a>
        </td>
    </tr>
<?php endforeach; ?>
    </tbody>
</table>
