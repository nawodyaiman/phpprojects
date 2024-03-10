<?php
session_start();
include('admin/config/dbcon.php'); 

if(isset($_POST['register-btn']))
{
    $fname= mysqli_real_escape_string($con, $_POST['fname']);
    $lname=mysqli_real_escape_string($con, $_POST['lname']);
    $mail=mysqli_real_escape_string($con, $_POST['mail']);
    $pwd=mysqli_real_escape_string($con, $_POST['pwd']);
    $cpwd=mysqli_real_escape_string($con, $_POST['cpwd']);

    if($pwd==$cpwd)
    {
        //mail checking
        $checkemail = "SELECT email FROM user WHERE email='$mail'";
        $checkemail_run= mysqli_query($con,$checkemail);

        if(mysqli_num_rows($checkemail_run)>0) 
        {
            $_SESSION['message']="Mail already exists";
            header("Location:register.php");
            exit(0);  
        }
        else
        {
          $user_query = "INSERT INTO user(fname,lname,email,password)VALUES('$fname','$lname','$mail','$pwd')";
          $user_query_run= mysqli_query($con,$user_query);

          if($user_query_run)
          {
            $_SESSION['message']="Sucessfully registerd";
            header("Location:showregister.php");
            exit(0); 
          }
          else
          {
            $_SESSION['message']="Something went wrong";
            header("Location:register.php");
            exit(0); 

          }

        }

    }
    else
    {
        $_SESSION['message']="Passwords do not match with each other";
        header("Location:register.php");
        exit(0);

    }

}


else
{
    header("Location: register.php");
    exit(0);
}


?>