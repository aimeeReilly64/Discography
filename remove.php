<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Album</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class ='context-box'>
    <p class="text">Your album was removed successfully.</p>
</div>
    <?php
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


        // Remove an item from DB
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            $sql = "UPDATE $table SET removed = 1 WHERE id = $id";
            $result = $conn->query($sql);
            echo '<div id = record-container>';
            if ($conn->query($sql) === TRUE) {
                // Displaying the list again after removal
                $sql = "SELECT * FROM $table";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // echo "<form method='POST' action='viewCollection.php'>";
                    while ($row = $result->fetch_assoc()) {
                        if ($row["removed"] == "0") {
                            $id = $row["id"];
                            $upc = $row["upc_code"];
                            $bandName = $row["band_name"];
                            $albumName = $row["album_name"];
                            $albumYear = $row["album_year"];
                            $albumArtwork = $row["album_artwork"];
                            echo "
          <div class='record-card'>

            <div class='image-wrapper'>
                <img src='$albumArtwork' alt='Album artwork for $albumName' />
                <div class='hover-details'>
                    <strong>ID:</strong> $id<br>
                    <strong>Artist Name:</strong> $bandName<br>
                    <strong>Album Name:</strong> $albumName<br>
                    <strong>Album Year:</strong> $albumYear<br>
                </div>
            </div><br/>
            <a href='remove.php?id=" . $row["id"] . "' class='button2'>Remove</a><br>
        </div>";
                            echo "<a href='admin.php'></a>";
                        }
                    }
         }}       }
                echo '</div>';

    $conn ->close();
    ?>
<!-- navigation -->
    <a href="viewCollection.php" class="button">View Collection</a>
    <a href="scanBarcode.php" class="button">Scan into Collection</a>
    <a href="admin.php" class="button">Admin</a>
</body>
</html>