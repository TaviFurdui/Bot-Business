<?php
    session_start();
    require 'connect.php';
    if (!empty ($_POST['lat']) && !empty ($_POST['lng']) && isset ($_POST['lat']) && isset ($_POST['lng']))
    {
        $lat = $_POST['lat'];
        $lng = $_POST['lng'];

        $sql = "INSERT INTO location (lat,lng,user) VALUES ('$lat','$lng','".$_SESSION['email']."')";
        $result = mysqli_query($conexiune,$sql);
    }
    else 
    {
        header ("Location: form.php?info=eroare");
    }
?>