<?php 
$host = "localhost";
$username="root";
$password="";
$database="project1";

$con = mysqli_connect("$host","$username","$password","$database");

if(!$con)
{
    header("Location:errors/dberrors.php");
    die();

}

?>