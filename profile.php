<?php
session_start();
require_once ('header.php');
$position = showPosition();
$profile = showProfile();

if (isset($_POST['updateProfile']))
{
    $fname =$_POST['fname'];
    $lname = $_POST['lname'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $image = $_FILES['profileImage'];
    $message = updateProfile($fname, $lname, $address, $city, $state, $image);

    echo $message;
}

if (isset($_POST['deposit']))
{
    $amount = $_POST['depositAmount'];
    $image = $_FILES['depositSlip'];
    $deposit = depositRequests($amount, $image);
    echo $deposit;
}

if (isset($_POST['withdraw']))
{
    $amount = $_POST['withdrawAmount'];
    $withdraw = withdrawRequests($amount);
    echo $withdraw['message'];
}
if (isset($_POST['loan']))
{
    $amount = $_POST['loanAmount'];
    $loan = loanRequests($amount);
    echo $loan['message'];
}
?>
<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
<div class="container">
    <br>
    <div class="row">
        <div class="col-xs-6">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Financial Details</h3>
                </div>

                <div class="box-body">
                    <?php
                    $bal = showAccountBalance();?>
                    <!-- /.box-header -->
                    <div align="center">
                        <h4><strong>Account Balance:</strong></h4>
                        <p><?php echo $bal["account_balance"];?></p>
                    </div>
                    <br>
                    <div align="center">
                        <button type="button" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#loanModal">Request for Loan</button><br><br>
                        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#depositModal">Deposit</button>
                        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#withdrawModal">Withdraw</button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="depositModal" role="dialog">
                        <div class="modal-dialog">
                            <!-- Deposit Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Deposit Funds</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label for="exampleInputAmount">Amount (in naira)</label>
                                                <input type="number" class="form-control" id="depositAmount" name="depositAmount">
                                            </div>
                                        </div>

                                        <div class="box-body">
                                            <div class="form-group">
                                                <label for="exampleInputDepositSlip">Picture of Bank Deposit Slip</label><br>
                                                <div class="form-group">
                                                    <input type="file" id="depositSlip" name="depositSlip">
                                                    <div style="width: inherit; height: inherit">
                                                        <img src="" id="previewDepositSlip" style="width: 500px">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="deposit">Deposit</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="modal fade" id="withdrawModal" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Modal Header</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label for="exampleInputAmount">Amount (in naira)</label>
                                                <input type="number" class="form-control" id="withdrawAmount" name="withdrawAmount">
                                            </div>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="withdraw">Withdraw</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="modal fade" id="loanModal" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Modal Header</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label for="exampleInputAmount">Amount (in naira)</label>
                                                <input type="number" class="form-control" id="loanAmount" name="loanAmount">
                                            </div>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="loan">Request for Loan</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
            <!-- /.box -->
        <div class="col-xs-6">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Personal Details</h3>
                </div>
                <!-- /.box-header -->


                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="exampleInputFirstName">Created By:</label>
                                <input type="text" class="form-control" value="<?php echo $profile['created_by'];?>" disabled>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="exampleInputFirstName">Created By:</label>
                                <input type="text" class="form-control" value="<?php echo $profile['president_approval_date'];?>" disabled>
                            </div>
                        </div>
                    </div>
                    <!-- form start -->
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="exampleInputFirstName">First Name</label>
                                        <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $profile['first_name'];?>">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="exampleInputLastName">Last Name</label>
                                        <input type="text" class="form-control" id="lname" name="lname" value="<?php echo $profile['last_name'];?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <label for="exampleInputAddress">Address</label>
                                        <input type="text" class="form-control" id="address" name="address" value="<?php echo $profile['address'];?>">
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <label for="exampleInputCity">City</label>
                                        <input type="text" class="form-control" id="city" name="city" value="<?php echo $profile['city'];?>">
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <label for="exampleInputState">State</label>
                                        <input type="text" class="form-control" id="state" name="state" value="<?php echo $profile['state'];?>">
                                    </div>
                                </div>
                            </div>
                            <div align="center">
                                <label for="exampleInputProfileImage">Profile Image</label><br>
                                <?php  $new = $profile["image"]; echo "<img src=\"dist/img/$new\" class=\"img-circle\" alt=\"Profile Image\" />";?>
                                <div class="form-group">
                                    <input type="file" id="profileImage" name="profileImage">
                                </div>
                                <div style="width: inherit; height: inherit">
                                    <img src="" id="preview" style="width: 300px">
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" name="updateProfile">Update</button>
                        </div>
                    </form>
            </div>
            <!-- /.box -->

        </div>
        <!-- /.col -->

    </div>

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
                <?php $sql = "SELECT * FROM pending_financial_requests WHERE user_id = '" . $position['id'] . "'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td>
                                <ul class="nav navbar-nav">
                                    <!-- User Account: style can be found in dropdown.less -->
                                    <li class="dropdown user user-menu">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <button type="submit" class="btn btn-info">See Details</button>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <!-- Menu Body -->
                                            <li class="user-body">
                                                <div class="row">
                                                    <div class="col-xs-6 text-center">
                                                        <a href="#">Date:</a><br>
                                                        <?php echo $row['requested_at'];?>
                                                    </div>
                                                    <div class="col-xs-6 text-center">
                                                        <a href="#">Sales</a>
                                                    </div>
                                                </div>
                                                <!-- /.row -->
                                            </li>
                                            <!-- Menu Footer-->
                                            <li class="user-footer">
                                                <div class="pull-left">
                                                    <a href="profile.php"class="btn btn-default btn-flat">Profile</a>
                                                </div>
                                                <div class="pull-right">
                                                    <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <?php echo $row['request_type'];?>
                            </td>
                            <td>
                                <?php
                                $new = $row['slip_image'];

                                if ($new!="null"){
                                    echo "<img src=\"dist/img/slips/$new\" style=\"width: 150px\" alt=\"Slip Image\" />";}
                                else
                                {echo "null";}?>
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

    $(function () {
        $("#example3").DataTable();
        $('#example4').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>