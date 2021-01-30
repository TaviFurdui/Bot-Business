<?php

    require_once('connect.php');

    if(isset($_SESSION['email']) && isset($_SESSION['password']) && isset($_SESSION['username']))
    {
        $email = $_SESSION['email'] ;
        $password = $_SESSION['password'];
        $username = $_SESSION['username'];

        $stmt = $conexiune->prepare("SELECT * FROM users WHERE email=? AND password=?");
        $stmt->bind_param('ss', $email, $password);

        $stmt->execute();

        $stmt -> store_result();
        $no = $stmt->num_rows;

        if($no > 0){
            header("Location: index.php");
        }
        else{}

        $stmt->close();
    }

    if(isset($_POST['login']))
    {
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $hash = md5($password);

        $stmt = $conexiune->prepare("SELECT * FROM users WHERE email=? AND password=?");
        $stmt->bind_param('ss', $email, $hash);

        $stmt->execute();

        $stmt -> store_result();
        $no = $stmt->num_rows;

        if($no > 0)
        {
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $hash;
        }

        $stmt->close();
        header("Location: index.php");
    }

    if(isset($_POST['sign-up']))
    {
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $hash = md5($password);

        $stmt = $conexiune->prepare("INSERT INTO users(username, email, password) VALUES(?, ?, ?)");
        $stmt->bind_param('sss', $username, $email, $hash);

        $stmt->execute();

        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $hash;
    }
?>