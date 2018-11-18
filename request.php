<?php
session_start();
require_once ('header.php');
$profile = showProfile();
$id = $_GET['id'];
$request = displayRequest($id);
//    print_r($request);

if ($request != "Error") {
    ?>

    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <div class="container">
        <br>
        <?php

            if (isset($_POST['presidentApprove']))
            {
                echo presidentApproval($id);
            }

            if (isset($_POST['finSecApprove']))
            {
                echo finSecApproval($id);
            }
        ?>
        <?php
            if ($position['position'] == 3) {
                if ($request['request']['president_approval'] == 2)
                {
        ?>
        <div class="row">
            <div class="col-xs-2">
                <div align="left">
                    <div class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <button type="button" class="btn btn-primary">Approve</button>
                        </a>
                        <div class="dropdown-menu">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Approve Request</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <p>
                                        Are you sure you want to approve this request??
                                    </p>
                                </div>
                                <form action="" method="POST">
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary" name="presidentApprove">
                                            Approve
                                        </button>
                                    </div>
                                </form>
                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-8">

            </div>
            <div class="col-xs-2">
                <div class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <button type="button" class="btn btn-danger">Disapprove</button>
                    </a>
                    <div class="dropdown-menu">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Disapprove Request</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <p>
                                    Are you sure you want to disapprove this request??
                                </p>
                            </div>
                            <form action="" method="POST">
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary" name="disapprove">
                                        disapprove
                                    </button>
                                </div>
                            </form>
                            <!-- /.box-body -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
                }
        ?>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Details of Request</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-2">
                        <div class="form-group">
                            <label for="exampleInputAmount">Request_Type</label><br>
                            <?php echo $request['request']['request_type']; ?>
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <div class="form-group">
                            <label for="exampleInputAmount">Amount</label><br>
                            <?php echo $request['request']['amount']; ?>
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <div class="form-group">
                            <label for="exampleInputAmount">Date Requested:</label><br>
                            <?php echo $request['request']['requested_at']; ?>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group">
                            <label for="exampleInputImageSlip">Approved by Financial Secretary:</label><br>
                            <?php
                            $finSecReqApproval = readFinSecRequestApproval($id);
                            if ($request['request']['fin_sec_approval'] == 2) {
                                echo "Pending Financial Secretary's approval";
                            } elseif ($request['request']['fin_sec_approval'] == 1) {
                                echo "Yes, by " ?> <strong><?php echo $finSecReqApproval['approved_by']; ?></strong>
                                <br> <?php echo "at "; ?>
                                <strong><?php echo $finSecReqApproval['approved_date']; ?> </strong>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group">
                            <label for="exampleInputImageSlip">Approved by President:</label><br>
                            <?php
                            $presidentReqApproval = readPresidentRequestApproval($id);
                            if ($request['request']['president_approval'] == 2) {
                                echo "Pending your approval";
                            } elseif ($request['request']['president_approval'] == 1) {
                                echo "Yes, by " ?> <strong><?php echo $presidentReqApproval['approved_by']; ?></strong>
                                <br> <?php echo "at "; ?>
                                <strong><?php echo $presidentReqApproval['approved_date']; ?> </strong>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <br>
                    <?php if ($request['request']['slip_image'] != "null") {
                        ?>
                        <div align="center">
                            <div class="form-group">
                                <label for="exampleInputImageSlip">Image Slip</label><br>
                                <?php $new = $request['request']['slip_image'];
                                echo "<img src=\"dist/img/slips/$new\" alt=\"Slip Image\" style=\"width: 800px\"/>"; ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Members Details</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-3">
                        <div class="form-group">
                            <label for="exampleInputEmail">Email:</label><br>
                            <?php echo $request['member']['email']; ?>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group">
                            <label for="exampleInputFullName">Full Name:</label><br>
                            <?php echo $request['member_details']['first_name']; ?>
                            <?php echo $request['member_details']['last_name']; ?>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group">
                            <label for="exampleAddress">Address:</label><br>
                            <?php echo $request['member_details']['address']; ?>,
                            <?php echo $request['member_details']['city']; ?>,
                            <?php echo $request['member_details']['state']; ?>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group">
                            <label for="exampleInputEmail">Date Joined:</label><br>
                            <?php echo $request['member']['joined']; ?>
                        </div>
                    </div>
                </div>
                <br>
                <div align="center">
                    <div class="form-group">
                        <label for="exampleInputImageSlip">User Image;</label><br>
                        <?php $new = $request['member_details']['image'];
                        echo "<img src=\"dist/img/$new\" class=\"img-circle\" alt=\"User's Image\"/>"; ?>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>

        <?php
    } elseif ($position['position'] == 5) {
        if ($request['request']['fin_sec_approval'] == 2) {
            ?>
            <div class="row">
                <div class="col-xs-2">
                    <div align="left">
                        <div class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <button type="button" class="btn btn-primary">Approve</button>
                            </a>
                            <div class="dropdown-menu">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Approve Request</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <p>
                                            Are you sure you want to approve this request??
                                        </p>
                                    </div>
                                    <form action="" method="POST">
                                        <div class="box-footer">
                                            <button type="submit" class="btn btn-primary" name="finSecApprove">Approve
                                            </button>

                                        </div>

                                    </form>
                                    <!-- /.box-body -->
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xs-8"></div>
                <div class="col-xs-2">
                    <div class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <button type="button" class="btn btn-danger">Disapprove</button>
                        </a>
                        <div class="dropdown-menu">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Disapprove Request</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <p>
                                        Are you sure you want to disapprove this request??
                                    </p>
                                </div>
                                <form action="" method="POST">
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary" name="finSecDisapprove">
                                            disapprove
                                        </button>

                                    </div>

                                </form>
                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } ?>


        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Details of Request</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-2">
                        <div class="form-group">
                            <label for="exampleInputAmount">Request_Type</label><br>
                            <?php echo $request['request']['request_type']; ?>
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <div class="form-group">
                            <label for="exampleInputAmount">Amount</label><br>
                            <?php echo $request['request']['amount']; ?>
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <div class="form-group">
                            <label for="exampleInputAmount">Date Requested:</label><br>
                            <?php echo $request['request']['requested_at']; ?>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group">
                            <label for="exampleInputImageSlip">Approved by You:</label><br>
                            <?php
                            if ($request['request']['fin_sec_approval'] == 2) {
                                echo "Pending your approval";
                            } elseif ($request['request']['fin_sec_approval'] == 1) {
                                echo "Approved by you";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group">
                            <label for="exampleInputImageSlip">Approved by President:</label><br>
                            <?php
                            if ($request['request']['president_approval'] == 2) {
                                echo "Pending President's Approval";

                            } elseif ($request['request']['president_approval'] == 1) {
                                echo "Approved by President";
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <br>
                <?php if ($request['request']['slip_image'] != "null") {
                    ?>
                    <div align="center">
                        <div class="form-group">
                            <label for="exampleInputImageSlip">Image Slip</label><br>
                            <?php $new = $request['request']['slip_image'];
                            echo "<img src=\"dist/img/slips/$new\" alt=\"Slip Image\" style=\"width: 800px\"/>"; ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Members Details</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-3">
                        <div class="form-group">
                            <label for="exampleInputEmail">Email:</label><br>
                            <?php echo $request['member']['email']; ?>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group">
                            <label for="exampleInputFullName">Full Name:</label><br>
                            <?php echo $request['member_details']['first_name']; ?>
                            , <?php echo $request['member_details']['last_name']; ?>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group">
                            <label for="exampleAddress">Address:</label><br>
                            <?php echo $request['member_details']['address']; ?>,
                            <?php echo $request['member_details']['city']; ?>,
                            <?php echo $request['member_details']['state']; ?>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group">
                            <label for="exampleInputEmail">Date Joined:</label><br>
                            <?php echo $request['member']['joined']; ?>
                        </div>
                    </div>
                </div>
                <br>
                <div align="center">
                    <div class="form-group">
                        <label for="exampleInputImageSlip">User Image;</label><br>
                        <?php $new = $request['member_details']['image'];
                        echo "<img src=\"dist/img/$new\" class=\"img-circle\" alt=\"User's Image\"/>"; ?>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <?php
    } else {
        echo "Access restricted";
    }


?>
    </div>
<?php
}

else {
    echo "Error";
}
?>





<?php require_once ('footer.php');?>
<script src="main.js" type="text/javascript"></script>