<?php
    session_start();
    $connect = new PDO('mysql:host=localhost;dbname=tech', 'root', 'root');
    
    $data = array();

    $email = $_SESSION['email'];
    $query = "SELECT * FROM events WHERE user = '$email'";

    $statement = $connect->prepare($query);

    $statement->execute();

    $result = $statement->fetchAll();

    foreach($result as $row)
    {
        $data[] = array(
            'id'   => $row["id"],
            'title'   => $row["title"],
            'start'   => $row["start_event"],
            'end'   => $row["end_event"],
            'user' => $row["user"]
        );
    }

    echo json_encode($data);
?>