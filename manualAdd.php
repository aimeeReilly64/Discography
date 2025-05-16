<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manually Add Data</title>
    <link rel="stylesheet" href="styles.css">
    <style>

        .addDataBtn {
        display: inline-block;
        padding: 8px 12px;
        margin-top: 10px;
        background-color: #0b3060;
        color: #ffffff;
        border-radius: 5px;
        text-decoration: none;
        transition: background 0.3s;
        cursor: pointer;
    }

    </style>
</head>
<?php 
    /* Old DB credentials
    $serverName = "localhost";
    $userName = "root";
    $passWord = '';
    $dbName = "VinylDatabase";
    $table="VinylRecords";
    */
   $serverName = "sql5.freesqldatabase.com";
$userName = "sql5779219";
$passWord = "lemk21KrSt";
$dbName = "sql5779219";
$table = "VinylRecords";
    
    // 3306 just specifies the port number we should connect on
    $conn = new mysqli($serverName, $userName, $passWord, $dbName, 3306);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>
<body>
    <h1>Manually Add Data</h1>
    <?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $upc = htmlspecialchars($_POST["upc"]);
        $bandName = htmlspecialchars($_POST["bandName"]);
        $albumName = htmlspecialchars($_POST["albumName"]);
        $albumYear = htmlspecialchars($_POST["albumYear"]);
        $images = htmlspecialchars($_POST["images"]);

        // Save album info to DB
        // The test record successfully added to DB
        $sql = "insert into $table (upc_code, band_name, album_name, album_year, album_artwork) values ('$upc', '$bandName', '$albumName', '$albumYear', '$images')";

        if ($conn->query($sql) === true) {
            echo 'Data saved successfully!<br/><br/> <a href="admin.php" class="button">Admin</a><br/>';
            
        } else {
            echo "Error! ".$sql."<br/>" . $conn->error;
        }

        $conn->close();
    } else {
        echo '<form action="manualAdd.php" method="POST">';
        echo '<label for="upc">UPC:</label> ';
        echo '<input type="text" id="upc" name="upc" placeholder="Enter UPC"><br/><br/>';
        echo '<label for="bandName">Band Name:</label> ';
        echo '<input type="text" id="bandName" name="bandName" placeholder="Enter Band Name"><br/><br/>';
        echo '<label for="albumName">Album Name:</label> ';
        echo '<input type="text" id="albumName" name="albumName" placeholder="Enter Album Name"><br/><br/>';
        echo '<label for="albumYear">Album Year:</label> ';
        echo '<input type="text" id="albumYear" name="albumYear" placeholder="Enter Album Year"><br/><br/>';
        // Should we add Album Artwork as well?
        echo '<label for="images">Album Artwork:</label> ';
        echo '<input type="text" id="images" name="images" placeholder="Enter Album Artwork"><br/><br/>';
        echo '<input class="addDataBtn" type="submit" value="Add Data"/>';
        echo '</form>';
    }
    
    
    
    ?>
</body>
</html>