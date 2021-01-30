<?php
    session_start();
    require_once("connect.php");

    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $day = isset($_POST['day']) ? $_POST['day'] : '';
    $month = isset($_POST['month']) ? $_POST['month'] : '';
    $year = isset($_POST['year']) ? $_POST['year'] : '';
    $first_hour = isset($_POST['first_hour']) ? $_POST['first_hour'] : '';
    $last_hour = isset($_POST['last_hour']) ? $_POST['last_hour'] : '';

    // echo 'Zi: ' . $name;

    $month = date('m', strtotime($month));
    $start_date = $year . '-' . $month . '-' . $day . ' ' . $first_hour;
    $end_date = $year . '-' . $month . '-' . $day . ' ' . $last_hour;

    $stmt = $conexiune -> prepare("INSERT INTO events (title, start_event, end_event, user) VALUES(?, ?, ?, ?)");
    $stmt->bind_param('ssss', $name, $start_date, $end_date, $_SESSION['username']);
    $stmt->execute();
?>