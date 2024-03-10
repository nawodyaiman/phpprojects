<?php
 include ('authenticate.php'); 
 if(isset($_POST['update_user']))
 {
    $user_id=$_POST['id'];
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $role_as=$_POST['role_as'];
    $status=$_POST['status'] = true ? '1':'0';

    $query= "UPDATE user SET fname='$fname', lname='$lname', email='$email',password='$password',role_as='$role_as',status='$status'
                WHERE ID=$user_id";
    $query_run=mysqli_query($con,$query);

    if($query_run)
    {
         $_SESSION['message']= "You are logged in";
            header("Location: index.php");
            exit(0);
    }

 }
 ?>