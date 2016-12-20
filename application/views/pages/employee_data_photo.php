<input disabled type="hidden" id="recNum" value="<?php echo $rec ?>" />
<table class="sample1" cellspacing="2" cellpadding="3">
    <tr>
        <th style="text-align: left; width: 100px;">Thumb View</th>
        <th style="text-align: left; width: 60px;">Id</th>
        <th style="text-align: left; width: 120px;">Code</th>
        <th style="text-align: left; width: 170px;">Name</th>
        <th style="text-align: left; width: 170px;">Designation</th>
        <th style="text-align: left; width: 315px;">Action</th>
    </tr>
</table>
<?php 
    foreach ($query as $qry => $row):
?>
<form action="<?php echo base_url();?>photo/do_upload" enctype="multipart/form-data" method="post">
    <table class="sample1" cellspacing="1" cellpadding="1">
        <tr>
            <td style="text-align: center;width: 100px;">
                <img alt="Photo" src="<?php echo base_url();?>uploads/<?= $row[$tableFeild1]; ?>/<?= $row[$tableFeild6]; ?>" style="width: 50px;height: 50px;" />
            </td>
            <td style="text-align: left;width: 60px;"><?= $row[$tableFeild1]; ?></td>
            <td style="text-align: left;width: 120px;"><?= $row[$tableFeild2].$row[$tableFeild3] ; ?></td>
            <td style="text-align: left;width: 170px;"><?= $row[$tableFeild4];?></td>
            <td style="text-align: left;width: 170px;"><?= $row[$tableFeild5]; ?></td>
            <input type="text" hidden="hidden" name="empId" id="empId" value="<?= $row[$tableFeild1]; ?>" />
            <td style="text-align: left; "><input type="file" name="userfile" /></td>
            <td style="text-align: right; "><input type="submit" value="upload" /></td>
        </tr>
    </table>
</form>
<?php endforeach; ?>