<?php
session_start();
require 'connect.php';

$sql = "SELECT * FROM location WHERE user LIKE '".$_SESSION['username']."'";
$result = mysqli_query($conexiune, $sql);
$locations = array();
$counter = 0;
while($row = mysqli_fetch_array($result)) 
{
    $counter++;
    $locations[] = $row;
}
for ($i = 0; $i < $counter; $i++)
{
    echo json_encode(floatval($locations[$i][1]) );
    echo ' ';
}

?>