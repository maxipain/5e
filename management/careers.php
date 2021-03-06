<?php
session_start();
if(!$_SESSION['admin'])
{
    header('location:login');
}
else{

    include_once 'functions/actions.php';
    $obj = new DataOperations();
    $error = $success = '';

    if(isset($_POST['delete']))
    {
        $id=$obj->con->real_escape_string(htmlentities($_POST['delete']));
        $image = $_POST['image'];
        $where=array("id"=>$id);
        unlink($image);
        if($obj->delete_record("team",$where))
        {
            $success="Team member has been removed";
        }
    }
}
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php include_once 'includes/resources.php'?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <?php include_once 'includes/navigation.php'?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include_once 'includes/sidebar.php'?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Careers</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">

                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Careers</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <a href="add_career" class="btn btn-outline-info btn-md" style="margin-bottom:10px;">Add new</a>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Date posted</th>
                                            <th>Deadline</th>
                                            <th>Contract</th>
                                            <th>Document</th>
                                            <th>State</th>
                                            <th>Edit/Delete</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $get_service = $obj->fetch_all_records('careers');
                                        foreach($get_service as $row)
                                        {
                                            $state = $row['state'];
                                            if($state == 1)
                                            {
                                                $job = 'active';
                                            }
                                            if($state == 0)
                                            {
                                                $job = 'inactive';
                                            }
                                            ?>
                                            <tr>
                                                <td><?=$row['title']?></td>
                                                <td><?=$row['date']?></td>
                                                <td><?=$row['deadline']?></td>
                                                <td><?=$row['contract']?></td>
                                                <td>
                                                <?php 
                                                if($row['media']){
                                                    ?>
                                                    <a target="_blank" href="<?=$row['media']?>"><?=$row['media']?></a>
                                                    <?php
                                                }
                                                else{
                                                    echo "Not uploaded";
                                                }
                                                ?>
                                                </td>
                                                <td><?=$job?></td>
                                                <td>
                                                    <a href="update_career?id=<?=$row['id']?>" class="btn btn-sm btn-info"><span class="fa fa-edit"></span></a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include "includes/footer.php";?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<?php include_once 'includes/scripts.php'?>
</body>
</html>
