<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
            header("location: ../login.php");
        }

    }else{
        header("location: ../login.php");
    }
    
    
    if($_POST){
        //import database
        include("../connection.php");

        $title=$_POST["title"];
        $docid=$_POST["docid"];
        $nop=$_POST["nop"];
        $date=$_POST["date"];
        $time=$_POST["time"];

        $stmt = $pdo->prepare("
            INSERT INTO schedule(docid,title,scheduledate,scheduletime,nop)
            VALUES( :docid , :title , :date , :time , :nop );
        ");
        $stmt->execute([
            ':docid' => $docid,
            ':title' => $title,
            ':date' => $date,
            ':time' => $time,
            ':nop' => $nop

        ]);

        // $sql="insert into schedule (docid,title,scheduledate,scheduletime,nop) values ($docid,'$title','$date','$time',$nop);";
        $result= $stmt->fetchAll(PDO :: FETCH_ASSOC);
        header("location: schedule.php?action=session-added&title=$title");
        
    }


?>