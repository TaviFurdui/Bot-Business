<?php
    session_start();
    $connect = new PDO('mysql:host=localhost;dbname=tech', 'root', 'root');

    if(isset($_POST["title"]))
    {
        $query = "
        INSERT INTO events 
        (title, start_event, end_event, user) 
        VALUES (:title, :start_event, :end_event, :user)
        ";
        $statement = $connect->prepare($query);
        $statement->execute(
            array(
                ':title'  => $_POST['title'],
                ':start_event' => $_POST['start'],
                ':end_event' => $_POST['end'],
                ':user' => $_SESSION['email']
            )
        );
    }
?>
