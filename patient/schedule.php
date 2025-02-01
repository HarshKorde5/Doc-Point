<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Sessions</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table{
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
    
    
    //echo $userid;
    //echo $username;
    
    date_default_timezone_set('Asia/Kolkata');

    $today = date('Y-m-d');

    // echo($today);

 //echo $userid;
 ?>
 <div class="container">
     <div class="menu">
     <table class="menu-container" border="0">
             <tr>
                 <td style="padding:10px" colspan="2">
                     <table border="0" class="profile-container">
                         <tr>
                             <td width="30%" style="padding-left:20px" >
                                 <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                             </td>
                             <td style="padding:0px;margin:0px;">
                                 <p class="profile-title"><?php echo substr($username,0,13)  ?>..</p>
                                 <p class="profile-subtitle"><?php echo substr($useremail,0,22)  ?></p>
                             </td>
                         </tr>
                         <tr>
                             <td colspan="2">
                                 <a href="../logout.php" ><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                             </td>
                         </tr>
                 </table>
                 </td>
             </tr>
             <tr class="menu-row" >
                    <td class="menu-btn menu-icon-home " >
                        <a href="index.php" class="non-style-link-menu "><div><p class="menu-text">Home</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="doctors.php" class="non-style-link-menu"><div><p class="menu-text">All Doctors</p></a></div>
                    </td>
                </tr>
                
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session menu-active menu-icon-session-active">
                        <a href="schedule.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Scheduled Sessions</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">My Bookings</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></a></div>
                    </td>
                </tr>
                
            </table>
        </div>

        <?php
                $query = "                
                    SELECT 
                        *
                    FROM 
                        schedule
                    INNER JOIN 
                        doctor 
                    ON 
                        schedule.docid = doctor.docid
                    WHERE 
                        schedule.scheduledate >=  :today
                    ORDER BY 
                        schedule.scheduledate ASC;
                ";
                $params = [
                    ':today' => $today
                ];

                // print_r($result);
                // echo($result[0]['docemail']);
                // $sqlmain= "select * from schedule inner join doctor on schedule.docid=doctor.docid where schedule.scheduledate>='$today'  order by schedule.scheduledate asc";

                $sqlpt1="";
                $insertkey="";
                $q='';
                $searchtype="All";

                if($_POST){
                        // print_r($_POST);
                        
                    if(!empty($_POST["search"])){
                            /*TODO: make and understand */
                            $keyword=$_POST["search"];

                            $query = "
                                SELECT 
                                    *
                                FROM 
                                    schedule
                                INNER JOIN 
                                    doctor 
                                ON 
                                    schedule.docid = doctor.docid
                                WHERE 
                                    schedule.scheduledate >= :today 
                                    AND (
                                        doctor.docname = :keyword
                                        OR doctor.docname LIKE :keyword || '%'
                                        OR doctor.docname LIKE '%' || :keyword
                                        OR doctor.docname LIKE '%' || :keyword || '%'
                                        OR schedule.title = :keyword
                                        OR schedule.title LIKE :keyword || '%'
                                        OR schedule.title LIKE '%' || :keyword
                                        OR schedule.title LIKE '%' || :keyword || '%'
                                        OR schedule.scheduledate::TEXT = :keyword
                                        OR schedule.scheduledate::TEXT LIKE :keyword || '%'
                                        OR schedule.scheduledate::TEXT LIKE '%' || :keyword
                                        OR schedule.scheduledate::TEXT LIKE '%' || :keyword || '%'
                                    )
                                ORDER BY 
                                    schedule.scheduledate ASC;
                            ";

                            // $stmt->bindParam(':today', $today, PDO::PARAM_STR);
                            // $stmt->bindValue(':keyword', $keyword, PDO::PARAM_STR);
                            $params = [
                                ':today' => $today,
                                ':keyword' => $keyword
                            ];

                            
                            // $sqlmain= "select * from schedule inner join doctor on schedule.docid=doctor.docid where schedule.scheduledate>='$today' and (doctor.docname='$keyword' or doctor.docname like '$keyword%' or doctor.docname like '%$keyword' or doctor.docname like '%$keyword%' or schedule.title='$keyword' or schedule.title like '$keyword%' or schedule.title like '%$keyword' or schedule.title like '%$keyword%' or schedule.scheduledate like '$keyword%' or schedule.scheduledate like '%$keyword' or schedule.scheduledate like '%$keyword%' or schedule.scheduledate='$keyword' )  order by schedule.scheduledate asc";
                            //echo $sqlmain;
                            $insertkey = $keyword;
                            $searchtype="Search Result : ";
                            $q='"';
                        }

                    }
                $stmt = $pdo->prepare($query);
                foreach ($params as $key => $value) {
                    $stmt->bindValue($key, $value, PDO::PARAM_STR);
                }
                $stmt->execute();
                $result= $stmt->fetchAll(PDO :: FETCH_ASSOC);

                ?>
                  
        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <tr >
                    <td width="13%" >
                    <a href="schedule.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td >
                            <form action="" method="post" class="header-search">

                                <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Doctor name or Email or Date (YYYY-MM-DD)" list="doctors" value="<?php  echo $insertkey ?>">&nbsp;&nbsp;
                                        
                                    <?php
                                            echo '<datalist id="doctors">';

                                            $stmt = $pdo->prepare("
                                                SELECT DISTINCT *
                                                FROM doctor;
                                            ");
                                            $stmt->execute();
                                            $list11 = $stmt->fetchAll(PDO :: FETCH_ASSOC);
                                            

                                            $stmt = $pdo->prepare("
                                                SELECT DISTINCT ON (title) *
                                                FROM schedule
                                                ORDER BY title, scheduleid;
                                            ");
                                            
                                            $stmt->execute();
                                            $list12 = $stmt->fetchAll(PDO :: FETCH_ASSOC);
                                            

                                            foreach ($list11 as $row00) {
                                                
                                                // for ($y=0;$y<$list11->num_rows;$y++){
                                                // $row00=$list11->fetch_assoc();
                                                $d=$row00["docname"];
                                               
                                                echo "<option value='$d'><br/>";
                                               
                                            };
                                            
                                            foreach ($list12 as $row00) {
                                                
                                                // for ($y=0;$y<$list12->num_rows;$y++){
                                                // $row00=$list12->fetch_assoc();
                                                $d=$row00["title"];
                                               
                                                echo "<option value='$d'><br/>";
                                            };

                                        echo ' </datalist>';
                                    ?>
                                        
                                
                                    <input type="Submit" value="Search" class="login-btn btn-primary btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                            </form>
                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Today's Date
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php 
                                
                                echo $today;

                            ?>
                        </p>
                    </td>
                    <td width="10%">
                        <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>


                </tr>
                
                
                <tr>
                    <td colspan="4" style="padding-top:10px;width: 100%;" >
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)"><?php echo $searchtype." Sessions"."(".count($result).")"; ?> </p>
                        <p class="heading-main12" style="margin-left: 45px;font-size:22px;color:rgb(49, 49, 49)"><?php echo $q.$insertkey.$q ; ?> </p>
                    </td>
                    
                </tr>
                
                
                
                <tr>
                   <td colspan="4">
                       <center>
                        <div class="abc scroll">
                        <table width="100%" class="sub-table scrolldown" border="0" style="padding: 50px;border:none">
                            
                        <tbody>
                        
                            <?php

                                
                                

                                if(!$result){
                                    echo '<tr>
                                    <td colspan="4">
                                    <br><br><br><br>
                                    <center>
                                    <img src="../img/notfound.svg" width="25%">
                                    
                                    <br>
                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We  couldnt find anything related to your keywords !</p>
                                    <a class="non-style-link" href="schedule.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Sessions &nbsp;</font></button>
                                    </a>
                                    </center>
                                    <br><br><br><br>
                                    </td>
                                    </tr>';
                                    
                                }
                                else{
                                    //echo $result->num_rows;
                                    foreach ($result as $row) {
                                        
                                    // for ( $x=0; $x<($result->num_rows);$x++){
                                    echo "<tr>";
                                    // for($q1=0;$q1<3;$q1++){
                                        // $row=$result->fetch_assoc();
                                        
                                        if (!isset($row)){
                                            break;
                                        };
                                        $scheduleid=$row["scheduleid"];
                                        $title=$row["title"];
                                        $docname=$row["docname"];
                                        $scheduledate=$row["scheduledate"];
                                        $scheduletime=$row["scheduletime"];

                                        if($scheduleid==""){
                                            break;
                                        }

                                        echo '
                                        <td style="width: 25%;">
                                                <div  class="dashboard-items search-items"  >
                                                
                                                    <div style="width:100%">
                                                            <div class="h1-search">
                                                                '.substr($title,0,21).'
                                                            </div><br>
                                                            <div class="h3-search">
                                                                '.substr($docname,0,30).'
                                                            </div>
                                                            <div class="h4-search">
                                                                '.$scheduledate.'<br>Starts: <b>@'.substr($scheduletime,0,5).'</b> (24h)
                                                            </div>
                                                            <br>
                                                            <a href="booking.php?id='.$scheduleid.'" ><button  class="login-btn btn-primary-soft btn "  style="padding-top:11px;padding-bottom:11px;width:100%"><font class="tn-in-text">Book Now</font></button></a>
                                                    </div>
                                                            
                                                </div>
                                            </td>';

                                    // }
                                    echo "</tr>";
                                    
                                    
                                    // echo '<tr>
                                    //     <td> &nbsp;'.
                                    //     substr($title,0,30)
                                    //     .'</td>
                                        
                                    //     <td style="text-align:center;">
                                    //         '.substr($scheduledate,0,10).' '.substr($scheduletime,0,5).'
                                    //     </td>
                                    //     <td style="text-align:center;">
                                    //         '.$nop.'
                                    //     </td>

                                    //     <td>
                                    //     <div style="display:flex;justify-content: center;">
                                        
                                    //     <a href="?action=view&id='.$scheduleid.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-view"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">View</font></button></a>
                                    //    &nbsp;&nbsp;&nbsp;
                                    //    <a href="?action=drop&id='.$scheduleid.'&name='.$title.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-delete"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Cancel Session</font></button></a>
                                    //     </div>
                                    //     </td>
                                    // </tr>';
                                    
                                }
                            }
                                 
                            ?>
 
                            </tbody>

                        </table>
                        </div>
                        </center>
                   </td> 
                </tr>
                       
                        
                        
            </table>
        </div>
    </div>

    </div>

</body>
</html>