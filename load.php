<?php
    $connect = new PDO('mysql:host=localhost;dbname=tech', 'root', 'root');

    $data = array();

    $query = "SELECT * FROM events ORDER BY id WHERE user LIKE '".$_SESSION['username']."'";

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