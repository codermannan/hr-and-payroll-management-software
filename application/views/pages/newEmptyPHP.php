<!DOCTYPE html>
<html>
    <body>
        <table>
            <tr>
                <th>Thumb View</th>
                <th>Id</th>
                <th>Code</th>
                <th>Name</th>
                <th>Designation</th>
                <th>Action</th>
            </tr>
        </table>
        <?php 
            foreach ($query as $qry => $row):
        ?>
        <form>
            <table>
                <tr>
                    <td style="text-align: left"><?= $row[$tableFeild1]; ?><input type="text" hidden="hidden" name="empId" id="empId" value="<?= $row[$tableFeild1]; ?>" /></td>
                    <td style="text-align: left"><?= $row[$tableFeild6]; ?></td>
                    <td style="text-align: left"><?= $row[$tableFeild2]; ?></td>
                    <td style="text-align: left"><?= $row[$tableFeild3];?></td>
                    <td style="text-align: left"><?= $row[$tableFeild4]; ?></td>
                    <td style="text-align: left">
                        <table style="width: 100%; border: none;">
                            <tr>
                                <td style="text-align: left;"><input type="file" name="userfile" size="20" /></td>
                                <td style="text-align: left;"><input type="submit" value="upload" /></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
        <?php endforeach; ?>
    </body>
</html>
