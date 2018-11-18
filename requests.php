<?php
session_start();
require_once ('header.php');
?>
<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
<div class="container">
    <br>
    <?php
    if ($position['position']==3) {
        ?>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">List of Requests Awaiting Approval</h3>
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
                    <?php $sql = "SELECT * FROM pending_financial_requests WHERE president_approval = 2 and fin_sec_approval = 1";
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

        <div class="box">
            <div class="box-header">
                <h3 class="box-title">List of Approved</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="example3" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Type</th>
                        <th>Slip Image</th>
                        <th>Amount</th>
                        <th>Created_At</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $sql = "SELECT * FROM pending_financial_requests WHERE president_approval = 1";
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

        <div class="box">
            <div class="box-header">
                <h3 class="box-title">List of Not Approved</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="example5" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Type</th>
                        <th>Slip Image</th>
                        <th>Amount</th>
                        <th>Created_At</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $sql = "SELECT * FROM pending_financial_requests WHERE president_approval = 3";
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
        <?php
    }
    elseif ($position['position']==5) {
    ?>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">List of Requests Awaiting Approval</h3>
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
                <?php $sql = "SELECT * FROM pending_financial_requests WHERE fin_sec_approval = 2";
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

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">List of Approved</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="example3" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Type</th>
                    <th>Slip Image</th>
                    <th>Amount</th>
                    <th>Created_At</th>
                </tr>
                </thead>
                <tbody>
                <?php $sql = "SELECT * FROM pending_financial_requests WHERE fin_sec_approval = 1";
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

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">List of Not Approved</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="example5" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Type</th>
                    <th>Slip Image</th>
                    <th>Amount</th>
                    <th>Created_At</th>
                </tr>
                </thead>
                <tbody>
                <?php $sql = "SELECT * FROM pending_financial_requests WHERE fin_sec_approval = 3";
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
    <?php
    }
    ?>
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

    $(function () {
        $("#example5").DataTable();
        $('#example6').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>