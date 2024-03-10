<?php
include('authenticate.php');
include('includings/header.php');

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $users = "DELETE FROM user WHERE id='$user_id'";
    $users_run = mysqli_query($con, $users);

    if (!$users_run) {
        $_SESSION['message']= "YOur ID is not in the Database";
            header("Location: delete.php");
            exit(0); 
    } else {
        
        echo 'Data has been deleted succesfully';
    }
}

?>
<?php
include('includings/footer.php');
include('includings/scripts.php');
?>


                    