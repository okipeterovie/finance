<?php
session_start();
require_once ('header.php');?>
<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
<div class="container">
    <br>
    <?php
    if (($position['position']==3) || ($position['position']==4)) {
        $id = $_GET['id'];
        $member = showMember($id);
        if ($member != "Error") {
            $memberDetails = showMemberDetails($id);
            $memberAcctBal = showUserAccountBalance($id);
            ?>
            <div class="row">
                <div class="col-xs-6">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Personal Details</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div align="center">
                                <?php $new = $memberDetails["image"];
                                echo "<img src=\"dist/img/$new\" class=\"img-circle\" alt=\"Profile Image\" />"; ?>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="exampleInputFirstName">User Email:</label>
                                        <input type="text" class="form-control" value="<?php echo $member['email']; ?>"
                                               disabled>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="exampleInputFirstName">User Position:</label>
                                        <input type="text" class="form-control"
                                               value="<?php echo setPosition($member['position']); ?>" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="exampleInputFirstName">Joined At:</label>
                                        <input type="text" class="form-control" value="<?php echo $member['joined']; ?>"
                                               disabled>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="exampleInputFirstName">Created By:</label>
                                        <input type="text" class="form-control"
                                               value="<?php echo $member['created_by']; ?>" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="exampleInputFirstName">Deleted:</label>
                                        <input type="text" class="form-control"
                                               value="<?php echo $member['deleted']; ?>" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="exampleInputFirstName">First Name:</label>
                                        <input type="text" class="form-control"
                                               value="<?php echo $memberDetails['first_name']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="exampleInputFirstName">Last Name:</label>
                                        <input type="text" class="form-control"
                                               value="<?php echo $memberDetails['last_name']; ?>" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="exampleInputFirstName">Address:</label>
                                        <input type="text" class="form-control"
                                               value="<?php echo $memberDetails['address']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="exampleInputFirstName">City:</label>
                                        <input type="text" class="form-control"
                                               value="<?php echo $memberDetails['city']; ?>" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="exampleInputFirstName">State:</label>
                                        <input type="text" class="form-control"
                                               value="<?php echo $memberDetails['state']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="exampleInputFirstName">Details Updated Last:</label>
                                        <input type="text" class="form-control"
                                               value="<?php echo $memberDetails['updated_at']; ?>" disabled>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                        </div>
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Account Details</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="exampleInputFirstName">Account Balance:</label>
                                        <input type="text" class="form-control"
                                               value="<?php echo $memberAcctBal['account_balance']; ?>" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">

                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Financial History</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Slip Image</th>
                                    <th>Amount</th>
                                    <th>Created_At</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $sql = "SELECT * FROM pending_financial_requests WHERE user_id = '" . $id . "'";
                                $result = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                        <tr>
                                            <td>
                                                <a href="request.php?id=<?php echo $row['id']; ?>">
                                                    <button type="submit" class="btn btn-info">See Details</button>
                                                </a>
                                            </td>
                                            <td>
                                                <?php echo $row['request_type']; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $new = $row['slip_image'];

                                                if ($new != "null") {
                                                    echo "<img src=\"dist/img/slips/$new\" style=\"width: 150px\" alt=\"Slip Image\" />";
                                                } else {
                                                    echo "null";
                                                } ?>
                                            </td>
                                            <td><?php echo $row['amount']; ?></td>
                                        </tr>
                                        <?php

                                    }
                                }
                                ?>

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Email</th>
                                    <th>Super Admin</th>
                                    <th>Created_At</th>
                                    <th>Deleted</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <?php
        } else {
            echo "User doesn't exist";
        }
    }
    else
    {echo "Access Restricted";}
    ?>
        </div>
        <!-- /.col -->

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
