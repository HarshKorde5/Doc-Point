<?php

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
            header("location: ../login.php");
        }

    }else{
        header("location: ../login.php");
    }
    
    
    if($_GET){
        //import database
        include("../connection.php");

        $id = $_GET["id"];

        $stmt = $pdo->prepare("
            SELECT * FROM doctor
            WHERE docid = :id ;
        ");
        $stmt->execute([
            ':id' => $id
        ]);

        $result = $stmt->fetchAll(PDO :: FETCH_ASSOC);
        
        // $result001= $database->query("select * from doctor where docid=$id;");

        $email = $result[0]["docemail"];

        
        $stmt = $pdo->prepare("
            DELETE FROM webuser
            WHERE email = :email ;
        ");
        $stmt->execute([
            ':email' => $email
        ]);

        // $sql= $database->query("delete from webuser where email='$email';");

        
        $stmt = $pdo->prepare("
            DELETE FROM doctor
            WHERE docemail = :email ;
        ");
        $stmt->execute([
            ':email' => $email
        ]);

        // $sql= $database->query("delete from doctor where docemail='$email';");

        //print_r($email);
        header("location: doctors.php");
    }


?>