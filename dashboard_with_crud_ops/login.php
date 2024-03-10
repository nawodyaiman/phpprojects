<?php  
session_start();
include('includings/header.php');
include('includings/navbar.php');
?>



<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">

                <?php include ('message.php'); ?>

                <div class="card">
                    <div class="card-header">
                        <h4>Login</h4>
                    </div>
                    <div class="card-body">
                        <form action="logininfo.php" method="POST">
                            <div class="form-group mb-3">
                                <label>E mail Addres</label>
                                <input required ="email" name="email" placeholder="Enter Emain Addres" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label>Password</label>
                                <input required type="password" name="password" placeholder="Enter your password" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" name="login_btn" class="btn btn-primary"> Login Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php   include('includings/footer.php');
       
?>