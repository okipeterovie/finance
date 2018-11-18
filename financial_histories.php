<?php
session_start();
require_once ('header.php');?>
<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
<div class="container">
    <br>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Complete Lists of Processed Requests</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Request Type</th>
                            <th>Slip Image</th>
                            <th>Amount</th>
                            <th>Requested By</th>
                            <th>Date Requested</th>
                            <th>Approved By</th>
                            <th>Position</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = "SELECT * FROM financial_history";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>


                                <tr>
                                    <td>
                                        <a href="request.php?id=<?php echo $row['type_id'];?>">
                                            <button type="submit" class="btn btn-info">See Details</button>
                                        </a>
                                    </td>
                                    <td><?php echo $row['request_type'];?></td>
                                    <td><?php
                                        $new = $row['slip_image'];

                                        if ($new != "null") {
                                            echo "<img src=\"dist/img/slips/$new\" style=\"width: 150px\" alt=\"Slip Image\" />";
                                        } else {
                                            echo "null";
                                        } ?>
                                    </td>
                                    <td><?php echo $row['amount'];?></td>
                                    <td><?php echo $row['requested_by'];?></td>
                                    <td><?php echo $row['requested_date'];?></td>
                                    <td><?php echo $row['approved_by'];?></td>
                                    <td><?php echo $row['approved_position'];?></td>
                                </tr>
                            <?php }
                        }?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th>Request Type</th>
                            <th>Slip Image</th>
                            <th>Amount</th>
                            <th>Requested By</th>
                            <th>Date Requested</th>
                            <th>Approved By</th>
                            <th>Position</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
</div>

<?php require_once ('footer.php');?>
<script src="main.js" type="text/javascript"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- page script -->
<script>
    $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>