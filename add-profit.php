<?php
    session_start();
    require_once("connect.php");

    $costs = isset($_POST['costs']) ? $_POST['costs'] : '';
    $earnings= isset($_POST['earnings']) ? $_POST['earnings'] : '';
    $date = isset($_POST['date']) ? $_POST['date'] : '';


    $stmt = $conexiune -> prepare("INSERT INTO profit (costs, earnings, date, user) VALUES(?, ?, ?, ?)");
    $stmt->bind_param('ddss', $costs, $earnings, $date, $_SESSION['username']);
    $stmt->execute();
?>