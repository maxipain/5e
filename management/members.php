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
                        <h1 class="m-0 text-dark">Members</h1>
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
                                <h3 class="card-title">Featured team</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <a href="add_member" class="btn btn-outline-info btn-md" style="margin-bottom:10px;">Add new</a>
                               <div class="table-responsive">
                                   <table class="table table-bordered table-striped">
                                       <thead>
                                       <tr>
                                           <th>Image</th>
                                           <th>Names</th>
                                           <th>Role</th>
                                           <th>Description</th>
                                           <th>Facebook</th>
                                           <th>Twitter</th>
                                           <th>Linkedlin</th>
                                           <th>Edit/Delete</th>
                                       </tr>
                                       </thead>
                                       <tbody>
                                       <?php
                                       $get_service = $obj->fetch_all_records('team');
                                       foreach($get_service as $row)
                                       {
                                           ?>
                                           <tr>

                                               <td><img src="<?= $row['image'] ?>" alt="<?= $row['name'] ?>" height="100px" width="100px"></td>
                                               <td><?=$row['name']?></td>
                                               <td><?=$row['title']?></td>
                                               <td><?=$row['description']?></td>
                                               <td><?=$row['facebook']?></td>
                                               <td><?=$row['twitter']?></td>
                                               <td><?=$row['linkedin']?></td>
                                               <td>
                                                   <a href="update_member?id=<?=$row['id']?>" class="btn btn-sm btn-info"><span class="fa fa-edit"></span></a>
                                                   <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#delete<?=$row['id']?>"><span class="fa fa-trash"></span></button>
                                               </td>
                                           </tr>

                                           <!--          delete modal-->
                                           <div class="modal fade" id="delete<?=$row['id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                               <div class="modal-dialog" role="document">
                                                   <div class="modal-content">
                                                       <div class="modal-header">
                                                           <h5 class="modal-title" id="exampleModalLabel">Delete prompt</h5>
                                                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                               <span aria-hidden="true">&times;</span>
                                                           </button>
                                                       </div>
                                                       <div class="modal-body">
                                                           <div class="alert alert-danger">
                                                               Are you sure you want to remove this service?
                                                           </div>
                                                       </div>
                                                       <div class="modal-footer">
                                                           <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" METHOD="POST">
                                                               <input type="hidden" name="image" value="<?=$row['image']?>">
                                                               <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                               <button  class="btn btn-primary" type="submit" name="delete" value="<?=$row['id']?>">Delete</button>
                                                           </form>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>

                                           <!-- end delete modal-->

                                           <!-- edit modal-->
                                           <div class="modal fade" id="edit<?=$row['id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                               <div class="modal-dialog" role="document">
                                                   <div class="modal-content">
                                                       <div class="modal-header">
                                                           <h5 class="modal-title" id="exampleModalLabel">Add new service</h5>
                                                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                               <span aria-hidden="true">&times;</span>
                                                           </button>
                                                       </div>
                                                       <div class="modal-body">
                                                           <form action="" METHOD="POST">
                                                               <label>Name</label>
                                                               <input type="text" class="form-control" name="heading" placeholder="eg Accounting" required="required" value="<?=$row['heading']?>"/>
                                                               <label>Icon</label>
                                                               <input type="text" class="form-control" name="icon" placeholder="eg fa fas strolling" value="<?=$row['icon']?>">
                                                               <label>Description</label>
                                                               <textarea name="body"  cols="30" rows="10"
                                                                         class="form-control" required="required">
                                                                <?=$row['body']?>

                                                    </textarea>
                                                       </div>
                                                       <div class="modal-footer">
                                                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                           <button type="submit" class="btn btn-primary" name="update" value="<?=$row['id']?>">Update</button>
                                                           </form>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>

                                           <!--end add modal-->
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
