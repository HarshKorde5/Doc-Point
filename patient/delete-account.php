<?php

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='p'){
            header("location: ../login.php");
        }else{
            $useremail=$_SESSION["user"];
        }

    }else{
        header("location: ../login.php");
    }
    

    //import database
    include("../connection.php");
    
    $stmt = $pdo->prepare("
        SELECT
            *
        FROM
            patient
        WHERE
            pemail = :email ;
    ");

    $stmt->execute([
        ':email' => $useremail
    ]);

    $userrow = $stmt->fetchAll(PDO :: FETCH_ASSOC);

    $userid= $userrow[0]["pid"];
    $username=$userrow[0]["pname"];


    
    if($_GET){
        //import database
        include("../connection.php");
        $id=$_GET["id"];

        $stmt = $pdo->prepare("
            SELECT
                *
            FROM
                patient
            WHERE
                pid = :pid ;
        ");

        $stmt->execute([
            ':pid' => $id
        ]);

        $result001 = $stmt->fetchAll(PDO :: FETCH_ASSOC);

        $email= $result001[0]["pemail"];


        $sqlmain= "delete from webuser where email= :mail ;";
        $stmt = $pdo->prepare($sqlmain);
        $stmt->execute([
            ':mail' => $email
        ]);
        $result = $stmt->fetchAll(PDO :: FETCH_ASSOC);


        $sqlmain= "delete from patient where pemail=:mail";
        $stmt = $pdo->prepare($sqlmain);
        $stmt->execute([
            ':mail' => $email
        ]);
        $result = $stmt->fetchAll(PDO :: FETCH_ASSOC);

        //print_r($email);
        header("location: ../logout.php");
    }


?>