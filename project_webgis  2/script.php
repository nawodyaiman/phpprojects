<?php
$connection = mysqli_connect("localhost", "root", "", "geo_data");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the SQL query from the URL parameter
$sqlQuery = $_GET['sqlQuery'];

$res = mysqli_query($connection, $sqlQuery);

if (!$res) {
    die("Query failed: " . mysqli_error($connection));
}

$dataPoints = array();

while ($row = mysqli_fetch_assoc($res)) {
    $dataPoints[] = array("y" => $row["Amount"], "label" => $row["Year"]);
}

// Close the database connection
mysqli_close($connection);

// Output the data as JSON
header('Content-Type: application/json');
echo json_encode($dataPoints, JSON_NUMERIC_CHECK);
?>
