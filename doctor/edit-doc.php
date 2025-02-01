        <?php
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        ?>
    <?php
    
    

    //import database
    include("../connection.php");



    if($_POST){
        // print_r($_POST);
        // $result= $database->query("select * from webuser");

        $name = $_POST['name'];
        $nic = $_POST['nic'];
        $oldemail = $_POST["oldemail"];
        $spec = $_POST['spec'];
        $email = $_POST['email'];
        $tele = $_POST['Tele'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        $id = $_POST['id00'];
        
        if ($password==$cpassword){
            $error='3';
    
            $stmt = $pdo->prepare("
                SELECT doctor.docid
                FROM doctor
                INNER JOIN webuser ON doctor.docemail = webuser.email
                WHERE webuser.email = :email ;
            ");

            $stmt->execute([
                ':email' => $email
            ]);

            $result = $stmt->fetchAll(PDO :: FETCH_ASSOC);
            
            // $result= $database->query("select doctor.docid from doctor inner join webuser on doctor.docemail=webuser.email where webuser.email='$email';");
            //$resultqq= $database->query("select * from doctor where docid='$id';");

            if($result){
                $id2=$result[0]["docid"];
            }else{
                $id2=$id;
            }
            
            // echo $id2."jdfjdfdh";

            if($id2!=$id){
                $error='1';
                //$resultqq1= $database->query("select * from doctor where docemail='$email';");
                //$did= $resultqq1->fetch_assoc()["docid"];
                //if($resultqq1->num_rows==1){
                    
            }else{

                //$sql1="insert into doctor(docemail,docname,docpassword,docnic,doctel,specialties) values('$email','$name','$password','$nic','$tele',$spec);";

                $stmt = $pdo->prepare("
                    UPDATE doctor
                    SET 
                        docemail = :1 ,
                        docname = :2,
                        docpassword = :3 ,
                        docnic = :4 ,
                        doctel = :5 ,
                        specialties = :6
                    WHERE docid = :7 ;

                ");

                $stmt->execute([
                    ':1' => $email,
                    ':2' => $name,
                    ':3' => $password,
                    ':4' => $nic,
                    ':5' => $tele,
                    ':6' => $spec,
                    ':7' => $id 
                ]);


                // $sql1="update doctor set docemail='$email',docname='$name',docpassword='$password',docnic='$nic',doctel='$tele',specialties=$spec where docid=$id ;";
                // $database->query($sql1);
                
                $stmt = $pdo->prepare("
                    UPDATE webuser
                    SET
                        email = :1 
                    WHERE
                        email = :2 ;
                ");

                $stmt->execute([
                    ':1' => $email,
                    ':2' => $oldemail
                ]);
                
                // $sql1="update webuser set email='$email' where email='$oldemail' ;";
                // $database->query($sql1);
                //echo $sql1;
                //echo $sql2;
                $error= '4';
                
                if($email != $oldemail){
                    $error = '5';
                }
            }
            
        }else{
            $error='2';
        }
    
    
        
        
    }else{
        //header('location: signup.php');
        $error='3';
    }
    

    header("location: settings.php?action=edit&error=".$error."&id=".$id2);
    ?>
    
   

</body>
</html>