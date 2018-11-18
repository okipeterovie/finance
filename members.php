<?php
session_start();
require_once ('header.php');?>
<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
<div class="container">
    <br>
    <?php
    if (isset($_POST['addUser']))
    {
        $email = $_POST['email'];
        $pass = $_POST['pwd'];
        $cpass = $_POST['cpwd'];
        $message = addUser($email, $pass, $cpass);

        echo $message;
    }
    ?>
    <div align="left">
        <div class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <button type="button" class="btn btn-primary" >Add New Committee Member</button>
            </a>
            <div class="dropdown-menu">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add a committee member</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="POST">

                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword" name="pwd" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputConfirmPassword">Confirm Password</label>
                            <input type="password" class="form-control" id="exampleInputCPassword" name="cpwd" placeholder="Password">
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" name="addUser" class="btn btn-primary">Submit</button>

                        <button type="button" class="btn btn-danger" id="closeAddCommittee">Cancel</button>
                    </div>


                </form>
                <!-- /.box-body -->
            </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">List of Members</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Email</th>
                            <th>Committee Chairman</th>
                            <th>Created_At</th>
                            <th>Deleted</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = "SELECT * FROM users";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>


                        <tr>
                            <td><a href="member.php?id=<?php echo $row['id'];?>"><?php echo $row['email'];?></a></td>
                            <td>
                                <?php
                                    if ($row['current_position']==1)
                                    {
                                        echo "Admin";
                                    }
                                    elseif ($row['current_position']==2) {echo "Committee";}?></td>
                            <td><?php echo $row['created_at'];?></td>
                            <td><?php if ($row['deleted']==1){echo "Yes";} else {echo "No";} ?></td>
                        </tr>
                        <?php }
                        }?>
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

<div class="blank" style="display:none" id="blank"></div>
<div style="display: none" id="userForm">
    <div class="air-card" style="padding:15px; width:500px; margin:0 auto; border-radius:5px">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Add a committee member</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">

                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">File input</label>
                        <input type="file" id="exampleInputFile">

                        <p class="help-block">Example block-level help text here.</p>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"> Check me out
                        </label>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>

                    <button type="button" class="btn btn-danger" id="closeAddCommittee">Cancel</button>
                </div>


            </form>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
