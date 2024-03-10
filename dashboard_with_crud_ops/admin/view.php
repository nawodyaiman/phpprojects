<?php
include('authenticate.php');
include('includings/header.php');

?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Users</h1>
    <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
            <li class="breadcrumb-item active">Users</li>
    </ol>

    <div class="row">
        <div class="col-md12">
            <div class="card">
                <div class="class-header">
                <h4>Edit Users</h4>

                </div>
                <div class="card-body">
                <?php
                    if(isset($_GET['id']))
                    {
                        $pro_id=$_GET['id'];
                        $project= "SELECT * FROM projetc WHERE pro_id='$pro_id' ";
                        $projects_run= mysqli_query($con,$project);

                        if(mysqli_num_rows($projects_run) > 0)
                        {
                            foreach($projects_run as $user)
                            {
                                ?>
                                 <h5>Project Name</h5>
                                <?=$user['pro_name'];?>
                       
                               
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

<?php
include('includings/footer.php');
include('includings/scripts.php');
?>
