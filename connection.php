
<?php
    // // Connection details
    // $host = 'localhost';
    // $port = '5432';
    // $dbname = 'docpoint_';
    // $user = 'postgres';
    // $password = '7796797012';

    // // Create connection string
    // $conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";

    // // Connect to the PostgreSQL database
    // $database = pg_connect($conn_string);

    // if ($database) {
    //     // echo "Connected to the PostgreSQL database successfully!";
    // } else {
    //     echo "Connection failed!";
    // }
?>


<?php
    try {
        // Connect to PostgreSQL
        $dsn = "pgsql:host=localhost;port=5432;dbname=docpoint_";
        $pdo = new PDO($dsn, 'postgres', '7796797012');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
?>
