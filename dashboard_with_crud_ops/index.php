<?php 
session_start(); 
include('includings/header.php');
include('includings/navbar.php');
?>



<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php include("message.php"); ?>
                <h3>hello</h3>
                <button class="btn btn-primary">Login</button>
            </div>
        </div>
    </div>
</div>



<?php   include('includings/footer.php');
       
?>