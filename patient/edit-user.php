
    <?php
    
    

    //import database
    include("../connection.php");



    if($_POST){

        //print_r($_POST);
        $stmt = $pdo->prepare("
            SELECT
                *
            FROM
                webuser;
        ");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $name=$_POST['name'];
        $nic=$_POST['nic'];
        $oldemail=$_POST["oldemail"];
        $address=$_POST['address'];
        $email=$_POST['email'];
        $tele=$_POST['Tele'];
        $password=$_POST['password'];
        $cpassword=$_POST['cpassword'];
        $id=$_POST['id00'];
        
        if ($password==$cpassword){
            $error='3';

            $sqlmain= "
                SELECT patient.pid 
                FROM patient 
                INNER JOIN webuser 
                ON patient.pemail = webuser.email 
                WHERE webuser.email = :email ;
            ";

            $stmt = $pdo->prepare($sqlmain);
            $stmt->execute([
                ':email' => $email
            ]);
            $result = $stmt->fetchAll(PDO :: FETCH_ASSOC);
            //$resultqq= $database->query("select * from doctor where docid='$id';");
            if(count($result)==1){
                $id2=$result[0]["pid"];
            }else{
                $id2=$id;
            }
            

            if($id2!=$id){
                $error='1';
                //$resultqq1= $database->query("select * from doctor where docemail='$email';");
                //$did= $resultqq1->fetch_assoc()["docid"];
                //if($resultqq1->num_rows==1){
                    
            }else{

                $stmt = $pdo->prepare("
                    UPDATE patient
                    SET 
                        pemail = :1 ,
                        pname = :2,
                        ppassword = :3 ,
                        pnic = :4 ,
                        ptel = :5 ,
                        paddress = :6
                    WHERE pid = :7 ;

                ");

                $stmt->execute([
                    ':1' => $email,
                    ':2' => $name,
                    ':3' => $password,
                    ':4' => $nic,
                    ':5' => $tele,
                    ':6' => $address,
                    ':7' => $id 
                ]);


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
    

    header("location: settings.php?action=edit&error=".$error."&id=".$id);
    ?>
    
   

</body>
</html>