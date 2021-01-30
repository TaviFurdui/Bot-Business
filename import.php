<?php
    session_start();
    require_once 'connect.php';

    if (!empty ($_POST['name']) && !empty ($_POST['type']) && !empty ($_POST['number_empl']) && !empty ($_POST['salary']) && isset ($_POST['name']) && isset ($_POST['type']) && isset ($_POST['number_empl']) && isset ($_POST['salary']))
    {
        $name = $_POST['name'];
        $type = $_POST['type'];
        $number_empl = $_POST['number_empl'];
        $salary = $_POST['salary'];

        $sql = "INSERT INTO form (name, type, number_empl, salary,user) VALUES ('$name','$type','$number_empl','$salary','".$_SESSION['username']."')";
        $result = mysqli_query($conexiune,$sql);

        header ("Location: form.php?info=ok");
        require 'import-excel.php';
        require 'location.php';
    }
    else 
    {
        header ("Location: form.php?info=eroare");
    }
?>