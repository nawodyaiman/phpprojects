<?php
include ('authenticate.php');

if (isset($_POST['post_job'])) {
    $pid = $_POST['pid'];
    $pd = $_POST['pd'];
    $eid = $_POST['eid'];

    $query = "INSERT INTO projetc (pro_id, pro_name, ID) VALUES ('$pid', '$pd', $eid)";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $_SESSION['message'] = "Successfully updated";
        header("Location: index.php");
        exit(0);
    } else {
        echo "Error in updating database";
    }
}
?>
