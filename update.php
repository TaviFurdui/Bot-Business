<?php
    $connect = new PDO('mysql:host=localhost;dbname=tech', 'root', 'root');

    if(isset($_POST["id"]))
    {
    $query = "
    UPDATE events 
    SET title=:title, start_event=:start_event, end_event=:end_event 
    WHERE id=:id AND user LIKE '".$_SESSION['email']."'
    ";
    $statement = $connect->prepare($query);
    $statement->execute(
        array(
            ':title'  => $_POST['title'],
            ':start_event' => $_POST['start'],
            ':end_event' => $_POST['end'],
            ':id'   => $_POST['id']
            )
        );
    }
?>
