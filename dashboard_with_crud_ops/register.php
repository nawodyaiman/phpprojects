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
                        <h4>Register With Us</h4>
                    </div>
                    <div class="card-body">
                        <form action="registerinfo.php" method="POST">
                            <div class="form-group mb-3">
                                <label>First Name</label>
                                <input required type="fn" name="fname" placeholder="Enter first name" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label>Last Name</label>
                                <input required type="ln" name="lname"placeholder="Enter last name" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label>E mail Address</label>
                                <input required type="email" name="mail" placeholder="Enter your Email" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label>Password</label>
                                <input required type="password" name="pwd" placeholder="Enter your Password" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label>Confirm Password</label>
                                <input required type="password" name="cpwd" placeholder="Confirm your Password" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <button type="submit" name="register-btn" class="btn btn-primary"> Register Now</button>
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