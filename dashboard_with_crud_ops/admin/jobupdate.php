<?php
include('authenticate.php');
include('includings/header.php');

?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Users</h1>
    <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
            <li class="breadcrumb-item active">Post jobs</li>
    </ol>

    <div class="row">
        <div class="col-md12">
            <div class="card">
                <div class="class-header">
                <h4>Update Jobs</h4>

                </div>
                <!DOCTYPE html>
<html>
<head>
    <style>
        /* Style the form container */
        .form-container {
            max-width: 750px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f7f7f7;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        /* Style the form inputs and labels */
        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        /* Style the submit button */
        .btn-primary {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
                <div class="card-body">
                    <?php
                    if(isset($_GET['id']))
                    {
                        $user_id=$_GET['id'];
                        $users= "SELECT * FROM user WHERE id='$user_id' ";
                        $users_run= mysqli_query($con,$users);

                        if(mysqli_num_rows($users_run) > 0)
                        {
                            foreach($users_run as $user)
                            {
                                ?>
                                 
                       
                                <form action="ucode.php" method="POST">
                                    

                                <div class="form-container">
        <form action="ucode.php" method="POST">
            <div class="form-group">
                <label for="pid">Project ID</label>
                <input type="text" required name="pid" id="pid">
            </div>
            <div class="form-group">
                <label for="pd">Project Details</label>
                <input type="text" required name="pd" id="pd">
            </div>
            <div class="form-group">
                <label for="eid">Employee Id</label>
                <input type="text" required name="eid" id="eid" value="<?=$user['ID'];?>">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" name="post_job" id="post_job">Post Job</button>
            </div>
        </form>
                                <?php
                            }

                        }
                        else 
                        {

                            ?>   
                            <h4>No record found</h4>
                            <?php
                        }

                    }
                ?>
                               
                            
    

                </div>
            </div>


        </div>
    </div>
</div>
</body>

<?php
include('includings/footer.php');
include('includings/scripts.php');
?>
