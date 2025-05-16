<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Collection for Admin</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php 

        $serverName = "sql5.freesqldatabase.com";
        $userName = "sql5771684";
        $passWord = "Cm1WHF4X6S";
        $dbName = "sql5771684";
        $table = "VinylRecords";
        
        // 3306 just specifies the port number we should connect on
        $conn = new mysqli($serverName, $userName, $passWord, $dbName, 3306);
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
                 
        $sql = "SELECT * FROM $table";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // echo "<form method='POST' action='viewCollection.php'>";
            while ($row = $result->fetch_assoc()) {
                if($row["removed"] == "0") { 
                    $id = $row["id"];
                    $upc = $row["upc_code"];
                    $bandName = $row["band_name"];
                    $albumName = $row["album_name"];
                    $albumYear = $row["album_year"];
                    $images = $row["album_artwork"];
                    echo "
                    <div class='record-card'>

            <div class='image-wrapper'>
                <img src='$images' alt='Album artwork for '$images'' />
                <div class='hover-details'>
                    <strong>ID:</strong> $id<br>
                    <strong>Artist Name:</strong> $bandName<br>
                    <strong>Album Name:</strong> $albumName<br>
                    <strong>Album Year:</strong> $albumYear<br>
                </div>
            </div><br/>
             <a href='modify.php?id=". $id ."' class ='button2' >Modify</a> | <a href='remove.php?id=". $row["id"] ."' class='button2'>Remove</a><br>
        </div>";
            echo "<a href='admin.php'></a>";
                    
                }
            }
        }
        $conn ->close();
    ?>
</body>
</html>