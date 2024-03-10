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
            <?php include('message.php');
            ?>
            <div class="card">
                <div class="class-header">
                <h4>Registered Users</h4>

                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Authority</th>
                                <th>Edit</th>
                                <th>Delete</th>
                                <th>Post a job</th>
                                <th>View Jobs</th>
                          
                                
                            </tr>
                        
                        </thead>
                            <tbody>
                            <?php
                             $query = "SELECT * FROM user";
                             $query_run=mysqli_query($con,$query);

                             if(mysqli_num_rows($query_run)> 0)
                             {
                                foreach($query_run as $row)
                                {
                                    ?>
                                        <tr>
                                        <td><?= $row['ID'];?></td>
                                        <td><?= $row['fname'];?></td>
                                        <td><?= $row['lname'];?></td>
                                        <td><?= $row['email'];?></td>
                                        <td>
                                            <?php
                                            if($row['role_as']=='1')
                                            {
                                                echo 'Admin';
                                            }elseif($row['role_as']=='0')
                                            {
                                                echo 'User';
                                            }


                                            ?>
                                        </td>
                                    
                                        <td><a href="edit.php ?id=<?=$row['ID'];?>" class="btn btn-success"> Edit</a></td>
                                        <td><a href="delete.php ?id=<?=$row['ID'];?>"  class="btn btn-danger"> Delete</button></td>
                                        <td><a href="jobupdate.php ?id=<?=$row['ID'];?>" class="btn btn-success"> Post a Job</a></td>
                                        <td><a href="edit.php ?id=<?=$row['ID'];?>" class="btn btn-success"> View Jobs</a></td>
                                        </tr>



                                    <?php
                                }

                             }
                             else
                             {
                                ?>
                                <tr>
                                    <td colspan="6"> No Record Found </td>
                                    
                                </tr>
                                <?php
                             }
                            ?>
                            
                        </tbody>

                    </table>

                    

                </div>

                 
            </div>
        </div>


    </div>
</div>

<?php
include('includings/footer.php');
include('includings/scripts.php');
?>