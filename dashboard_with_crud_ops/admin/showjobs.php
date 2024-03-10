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
                <h4>Posted Jobs</h4>

                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <div style="float: right;">
                    <a href="edit.php" class="btn btn-success" style="margin-bottom: 10px;"> Create a Project </a>
                        </div>

                        <thead>
                            <tr>
                            <th>ID</th>
                                <th>Project Details</th>
                                
                                <th style="text-align: center;">Status</th>
                                
                                <th style="text-align: center;">Delete project</th>
                          
                                
                            </tr>
                            <div style="float: left; margin-right: 10px;">
                        <!-- Search form -->
                        <form method="GET" action="search.php">
                            <div class="form-group">
                                <input type="text" name="search" class="form-control" placeholder="Search..." style="width: 150px;">
                            
                            <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </form>
                    </div>
                        </thead>
                        <tbody>
                            <?php
                             $query = "SELECT projetc.pro_id, projetc.pro_name, user.ID, user.fname
                             FROM projetc
                             INNER JOIN user ON projetc.ID = user.ID";
                             $query_run=mysqli_query($con,$query);

                             if(mysqli_num_rows($query_run)> 0)
                             {
                                foreach($query_run as $row)
                                {
                                    ?>
                                        <tr>
                                        <td><?= $row['pro_id'];?></td>
                                        <td><?= $row['pro_name'];?></td>
                                       
                                        <td style="text-align: center;"><a href="edit.php ?id=<?=$row['ID'];?>" class="btn btn-success"> Pending</a></td>
                                        <td style="text-align: center;"><a href="view.php ?id=<?=$row['ID'];?>"  class="btn btn-success"> View </button></td>
                                        
                                    
                                    
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