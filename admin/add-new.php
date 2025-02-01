<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/animations.css">  
        <link rel="stylesheet" href="../css/main.css">  
        <link rel="stylesheet" href="../css/admin.css">
            
        <title>Doctor</title>
        <style>
            .popup{
                animation: transitionIn-Y-bottom 0.5s;
            }
        </style>
    </head>
    <body>
        <?php
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        ?>
        <?php

        //learn from w3schools.com

        session_start();

        if(isset($_SESSION["user"])){
            if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
                header("location: ../login.php");
            }

        }else{
            header("location: ../login.php");
        }
        
        

        //import database
        include("../connection.php");



        if($_POST){
            //print_r($_POST);
            // $stmt = $pdo->prepare("
            //     SELECT * FROM webuser;
            // ");
            // $stmt->execute();
            // $result = $stmt->fetchAll(PDO :: FETCH_ASSOC);

            // $result= $database->query("select * from webuser");

            $name=$_POST['name'];

            $nic=$_POST['nic'];

            $spec=$_POST['spec'];

            $email=$_POST['email'];

            $tele=$_POST['Tele'];

            $password=$_POST['password'];

            $cpassword=$_POST['cpassword'];
            
            if ($password==$cpassword){

                $error='3';

                $stmt = $pdo->prepare("
                    SELECT * FROM webuser
                    WHERE email = :email;
                ");
                $stmt->execute([
                    ':email' => $email
                ]);

                $result = $stmt->fetchAll(PDO :: FETCH_ASSOC);
                // $list1 = $stmt->fetchAll(PDO::FETCH_ASSOC);


                // $result= $database->query("select * from webuser where email='$email';");
                if($result){
                    $error='1';
                }else{
                    $stmt = $pdo->prepare("
                        INSERT INTO doctor(docemail,docname,docpassword,docnic,doctel,specialties)
                        VALUES( :docemail , :docname , :docpassword , :docnic , :doctel , :specialties );                    
                    ");
                    $stmt->execute([
                        ':docemail' => $email,
                        ':docname' => $name,
                        ':docpassword' => $password,
                        ':docnic' => $nic,
                        ':doctel' => $tele,
                        ':specialties' => $spec
                    ]);

                    // $result = $stmt->fetchAll(PDO :: FETCH_ASSOC);

                    // $sql1="insert into doctor(docemail,docname,docpassword,docnic,doctel,specialties) values('$email','$name','$password','$nic','$tele',$spec);";


                    $stmt = $pdo->prepare("
                        INSERT INTO webuser
                        VALUES(:email,:type);
                    ");
                    $stmt->execute([
                        ':email' => $email,
                        ':type' => 'd'
                    ]);
                    $result = $stmt->fetchAll(PDO :: FETCH_ASSOC);
                    
                    // $sql2="insert into webuser values('$email','d')";
                    // $database->query($sql1);
                    // $database->query($sql2);

                    //echo $sql1;
                    //echo $sql2;
                    $error= '4';
                    
                }

            }else{
                $error='2';
            }        
            
        }else{
            //header('location: signup.php');
            $error='3';
        }
        

        header("location: doctors.php?action=add&error=".$error);
        
        ?>
    </body>
</html>