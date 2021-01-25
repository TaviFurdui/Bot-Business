<?php
    require 'connect.php';
    if (!empty ($_POST['lat']) && !empty ($_POST['lng']) && isset ($_POST['lat']) && isset ($_POST['lng']))
    {
        $lat = $_POST['lat'];
        $lng = $_POST['lng'];

        $sql = "INSERT INTO location (lat,lng) VALUES ('$lat','$lng')";
        $result = mysqli_query($conexiune,$sql);
    }
    else 
    {
        header ("Location: form.php?info=eroare");
    }
?>