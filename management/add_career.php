
<?php

session_start();
if(!$_SESSION['admin'])
{
    header('location:login');
}
else{

    include_once 'functions/actions.php';
    $obj = new DataOperations();
    $error = $success = $title= $description = $deadline = '';


    if(isset($_POST['submit'])){

        $description = $_POST['description'];
        $title = $obj->con->real_escape_string(htmlspecialchars($_POST['title']));
        $state = $obj->con->real_escape_string(htmlspecialchars($_POST['state']));
        $contract = $obj->con->real_escape_string(htmlspecialchars($_POST['contract']));
        $deadline = $obj->con->real_escape_string(htmlspecialchars($_POST['deadline']));
        $state = $obj->con->real_escape_string(htmlspecialchars($_POST['state']));
        $date = date("d-M-Y");


        if($_FILES['document']['tmp_name'])
        {

            if($_FILES['document']['size'] > 5000000) { //5 MB (size is also in bytes)
                $error = "document is too large. Maximum file size is 5 mb";


            } else if($_FILES['document']['size'] > 1) {

                //save document to folder and database

                //rename file before uploading
                $filename   = uniqid() . "_" . time(); // 5dab1961e93a7_1571494241
                $extension  = pathinfo( $_FILES["document"]["name"], PATHINFO_EXTENSION ); // jpg,pdf
                $basename   = $filename . '.' . $extension; // 5dab1961e93a7_1571494241.jpg
                $source       = $_FILES["document"]["tmp_name"];
                $document = "documents/" . $basename;

                /* move the file */
                move_uploaded_file( $source, $document );

                $data = array('title'=>$title,'description'=>$description,'media'=>$document,'date'=>$date,'contract'=>$contract,'state'=>$state,'deadline'=>$deadline);

            }

        }
        else{
            $data = array('title'=>$title,'description'=>$description,'date'=>$date,'contract'=>$contract,'state'=>$state,'deadline'=>$deadline);
        }
        


        if($obj->insert_record('careers',$data))
        {
            $success = "Posting added successfully";
            $title= $description = $deadline = '';
        }
        else{
            $error = "Error adding post";
            $error = mysqli_error($obj->con);
        }

    }




}
?>
<!DOCTYPE html>
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
        <section class="content-header">
            <ol class="breadcrumb">
                <li><a href="careers"><i class="fa fa-dashboard"></i> Careers/</a></li>
                <li class="active">Add career</li>
            </ol>
        </section>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-md-12">
                        <?php

                        if($error)
                        {
                            $obj->errorDisplay($error);
                        }
                        if($success)
                        {
                            $obj->successDisplay($success);
                        }

                        ?>

                    </div>
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Add career</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" method="post" action="" enctype="multipart/form-data">
                            
                                <div class="card-body">
                                
                                    <div class="form-group  col-md-6">
                                    <p>Fields marked with (<span class="text-danger">*</span>) are required</p>
                                        <label for="exampleInputEmail1">Title<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="eg Procurement officer" name="title" required="required" value="<?=$title?>">
                                    </div>

                                    <div class="form-group" style="margin-left:8px;">
                                        <label for="exampleInputEmail1">Description<span class="text-danger">*</span></label>
                                        <textarea class="textarea" placeholder="Place some text here" required="required"
                                                  style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="description">
                                        <?=$description?>
                                    </textarea>
                                    </div>

                                    <div class="form-group  col-md-6">
                                        <label>Job type<span class="text-danger">*</span></label>
                                        <select class="form-control" name="contract">
                                            <option value="full time">full time</option>
                                            <option value="part time">part time</option>
                                            <option value="contract">contract</option>
                                        </select>
                                    </div>

                                    <div class="form-group  col-md-6" >
                                        <label>State<span class="text-danger">*</span></label>
                                        <select class="form-control" name="state" required="required">
                                            <option value="1">active</option>
                                            <option value="0">inactive</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="exampleInputEmail1">Application deadline<span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="exampleInputEmail1" name="deadline" required="required" value="<?=$deadline?>" >
                                    </div>

                                    <div class="form-group  col-md-6">
                                        <label for="exampleInputFile">Upload pdf attachment</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="exampleInputFile" name="document" accept="application/pdf">
                                                <label class="custom-file-label" for="exampleInputFile">Document</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
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
