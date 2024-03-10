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
                        $user_id=$_GET['id'];
                        $users= "SELECT * FROM user WHERE id='$user_id' ";
                        $users_run= mysqli_query($con,$users);

                        if(mysqli_num_rows($users_run) > 0)
                        {
                            foreach($users_run as $user)
                            {
                                ?>
                                 
                       
                                <form action="code.php" method="POST">
                                    <input type="text" type="hidden" name="id" value ="<?=$user['ID'];?>"

                                    <div class="row">
                                        <div class="col-md-5 md-3">
                                        <label for=""> First Name</label>
                                        <input type="text" required name="fname" value="<?=$user['fname'];?>" class="form-control"> 

                                    </div>
                                    <div class="col-md-5 md-3">
                                        <label for=""> Last Name</label>
                                        <input type="text" required name="lname" value="<?=$user['lname'];?>" class="form-control"> 

                                    </div>
                                    <div class="col-md-5 md-3">
                                        <label for=""> Email Address</label>
                                        <input type="text" required name="email" value="<?=$user['email'];?>" class="form-control"> 

                                    </div>
                                    <div class="col-md-5 md-3">
                                        <label for=""> Password</label>
                                        <input type="text" required name="password" class="form-control"> 

                                    </div>
                                    <div class="col-md-5 md-3">
                                        <label for=""> Role As</label>
                                        <select name="role_as" required class="form-control">
                                            <option value="">--Select Role--</option> 
                                            <option value="1"<?=$user['role_as']=='1' ? 'selected':''?> >Admin</option>
                                            <option value="0"<?=$user['role_as']=='0' ? 'selected':''?>>User</option>
                                        </select>



                                    </div>
                                    <div class="col-md-5 md-3">
                                        <label for=""> Status</label>
                                        <input type="checkbox" name="status" <?=$user['status'] == '1' ? 'checked':''?>width="70px" height="70px" /> 

                                    </div>
                                    <div class="col-md-5  md-3">
                                        <button type="submit" class="btn btn-primary" name="update_user">Update User </button> 

                                    </div>
                                        

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

<?php
include('includings/footer.php');
include('includings/scripts.php');
?>
