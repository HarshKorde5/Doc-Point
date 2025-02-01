<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/login.css">
        
    <title>Login</title>
</head>
<body>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
    <?php

        session_start();

        $_SESSION["user"]="";
        $_SESSION["usertype"]="";
        
        // Set the new timezone
        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d');

        $_SESSION["date"]=$date;
        

        //import database
        include("connection.php");

        if($_POST){

            $email=$_POST['useremail'];
            // echo"$email<br>";
            $password=$_POST['userpassword'];
            // echo"$password<br>";
            
            $error='<label for="promter" class="form-label"></label>';

            // Use prepared statement to avoid SQL injection
            $stmt = $pdo->prepare("SELECT * FROM webuser WHERE email = :email");
            $stmt->execute([':email' => $email]);
        
            // Fetch results
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    // print_r($result); // Display results

            // if ($result) {
            //     print_r($result[0]['usertype']); // Display results
            // } else {
            //     echo "No user found.";
            // }
        
            // $result= $database->query("select * from webuser where email='$email'");

            if($result){
                // if ($result) {
                    // print_r($result); // Display results

                $utype = $result[0]['usertype'];

                if ($utype=='p'){
                    //TODO
                            
                    $stmt = $pdo->prepare("SELECT * FROM patient WHERE pemail = :email and ppassword = :pass");
                    $stmt->execute([':email' => $email , ':pass' => $password]);
                    $checker = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // $checker = $database->query("select * from patient where pemail='$email' and ppassword='$password'");
                    if($checker){


                        //   Patient dashbord
                        $_SESSION['user']=$email;
                        $_SESSION['usertype']='p';
                        
                        header('location: patient/index.php');

                    }else{
                        $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                    }

                }elseif($utype=='a'){
                    //TODO
                    
                    $stmt = $pdo->prepare("SELECT * FROM admin WHERE aemail = :email and apassword = :pass");
                    $stmt->execute([':email' => $email , ':pass' => $password]);
                    $checker = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // $checker = $database->query("select * from admin where aemail='$email' and apassword='$password'");
                    if ($checker){


                        //   Admin dashbord
                        $_SESSION['user']=$email;
                        $_SESSION['usertype']='a';
                        
                        header('location: admin/index.php');

                    }else{
                        $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                    }


                }elseif($utype=='d'){
                    //TODO
                    
                    $stmt = $pdo->prepare("SELECT * FROM doctor WHERE docemail = :email and docpassword = :pass");
                    $stmt->execute([':email' => $email , ':pass' => $password]);
                    $checker = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // $checker = $database->query("select * from doctor where docemail='$email' and docpassword='$password'");
                    if ($checker){


                        //   doctor dashbord
                        $_SESSION['user']=$email;
                        $_SESSION['usertype']='d';
                        header('location: doctor/index.php');

                    }else{
                        $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                    }

                }
                
            }else{
                $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">We cant found any account for this email.</label>';
            }
            
        }else{
            $error='<label for="promter" class="form-label">&nbsp;</label>';
        }

    ?>
    
    <center>
        <div class="container">
            <table border="0" style="margin: 0;padding: 0;width: 60%;">
                <tr>
                    <td>
                        <p class="header-text">Welcome Back!</p>
                    </td>
                </tr>
                <div class="form-body">
                    <form action="" method="POST" >
                        <tr>
                            <td>
                                <p class="sub-text">Login with your details to continue</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td">
                                <label for="useremail" class="form-label">Email: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td">
                                <input type="email" name="useremail" class="input-text" placeholder="Email Address" required>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td">
                                <label for="userpassword" class="form-label">Password: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td">
                                <input type="Password" name="userpassword" class="input-text" placeholder="Password" required>
                            </td>
                        </tr>
                        <tr>
                            <td><br>
                            <?php echo $error ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="submit" value="Login" class="login-btn btn-primary btn">
                            </td>
                        </tr>
                    </form>
                </div>
                <tr>
                    <td>
                        <br>
                        <label for="" class="sub-text" style="font-weight: 280;">Don't have an account&#63; </label>
                        <a href="signup.php" class="hover-link1 non-style-link">Sign Up</a>
                        <br><br><br>
                    </td>
                </tr>                                     
            </table>
        </div>  
    </center>

</body>
</html>