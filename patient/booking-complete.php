<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
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

    if($_POST){
        if(isset($_POST["booknow"])){
            $scheduleid=$_POST["scheduleid"];

            $stmt = $pdo->prepare("
                SELECT
                    *
                FROM
                    appointment
                WHERE
                    pid = :pid AND scheduleid = :sid ;
            ");
            $stmt->execute([
                ':pid' => $userid,
                'sid' => $scheduleid
            ]);

            $result= $stmt->fetchAll(PDO :: FETCH_ASSOC);

            if(!$result){
                

                $apponum=$_POST["apponum"];
                $scheduleid=$_POST["scheduleid"];
                $date=$_POST["date"];

                $stmt = $pdo->prepare("
                    INSERT INTO appointment (pid, apponum, scheduleid, appodate) 
                    VALUES (:userid, :apponum, :scheduleid, :appodate);
                ");
                $stmt->execute([
                    ':userid' => $userid,
                    ':apponum' => $apponum,
                    ':scheduleid' => $scheduleid,
                    ':appodate' => $date
                ]);

                $result= $stmt->fetchAll(PDO :: FETCH_ASSOC);
                //echo $apponom;
                header("location: appointment.php?action=booking-added&id=".$apponum."&titleget=none");
            }else{
                $bookedapponum = $result[0]['apponum'];
                header("location: appointment.php?action=already-booked&id=".$bookedapponum."&titleget=none");
            }

        }
    }
 ?>