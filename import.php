<?php
    session_start();
    require_once 'connect.php';

    if (!empty ($_POST['name']) && !empty ($_POST['type']) && !empty ($_POST['number_empl']) && !empty ($_POST['salary']) && isset ($_POST['name']) && isset ($_POST['type']) && isset ($_POST['number_empl']) && isset ($_POST['salary']))
    {
        $name = $_POST['name'];
        $type = $_POST['type'];
        $number_empl = $_POST['number_empl'];
        $salary = $_POST['salary'];

        $sql = "INSERT INTO form (name, type, number_empl, salary,user) VALUES ('$name','$type','$number_empl','$salary','".$_SESSION['email']."')";
        $result = mysqli_query($conexiune,$sql);

        require 'import-excel.php';
        require 'location.php';
        header ("Location: form.php?info=ok");
    }
    else 
    {
        header ("Location: form.php?info=eroare");
    }
?>