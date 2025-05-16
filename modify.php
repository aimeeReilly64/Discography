<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discography by Aimee</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee+Spice&display=swap" rel="stylesheet">
    <script src="accessApi.php"></script>
</head>
<body>
    <?php
  $serverName = "sql5.freesqldatabase.com";
$userName = "sql5779219";
$passWord = "lemk21KrSt";
$dbName = "sql5779219";
$table = "VinylRecords";

    // Create connection with the specified port (3306)
    $conn = new mysqli($serverName, $userName, $passWord, $dbName, 3306);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch data with id
    if (isset($_GET["id"])) { 
        $id = $_GET["id"];     
        $sql = "SELECT * FROM $table WHERE id = $id";
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
                }
            }
        }
    }
    ?>
    <?php 
    // Modify data
     if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = htmlspecialchars($_POST["id"]);
        $upc = htmlspecialchars($_POST["upc"]);
        $bandName = htmlspecialchars($_POST["bandName"]);
        $albumName = htmlspecialchars($_POST["albumName"]);
        $albumYear = htmlspecialchars($_POST["albumYear"]);
        $images = htmlspecialchars($_POST["images"]);


        $sql = "UPDATE $table SET 
            upc_code='$upc', 
            band_name='$bandName', 
            album_name='$albumName', 
            album_year='$albumYear', 
            album_artwork='$images'
            WHERE id=$id";

        // Display the modified list
        if ($conn->query($sql) === true) {
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


                    }
                }
            }

            echo "<a href='admin.php' class='adminBtn'>Go Back to Admin</a>";
        
        }
    } else {
         echo "<div class='main-content'>
        <div class='context-box'>
            <h1>Modify Album</h1>
        </div> ";
         echo '<div class="context-box2">';
        // This is the form for modifying the fields
        echo "<form action='modify.php' method='POST'>";
        echo "<input type='hidden' name='id' value='".htmlspecialchars($id)."'><br/><br/>";
        echo "<label for='upc' class='text'>Barcode:</label> ";
        echo "<input type='text' id='upc' name='upc' placeholder='Enter UPC' value='".htmlspecialchars($upc)."'><br/><br/>";
        echo "<label for='bandName' class='text'>Band Name:</label> ";
        echo "<input type='text' id='bandName' name='bandName' placeholder='Enter Band Name' value='". htmlspecialchars($bandName)."'><br/><br/>";
        echo "<label for='albumName' class='text'>Album Name:</label> ";
        echo "<input type='text' id='albumName' name='albumName' placeholder='Enter Album Name' value='".htmlspecialchars($albumName)."'><br/><br/>";
        echo "<label for='albumYear' class='text'>Album Year:</label> ";
        echo "<input type='text' id='albumYear' name='albumYear' placeholder='Enter Album Year' value='".htmlspecialchars($albumYear)."'><br/><br/>";
        echo "<label for='images' class='text'>Album Artwork:</label> ";
        echo "<input type='text' id='images' name='images' placeholder='Enter Album Artwork' value='".htmlspecialchars($images)."'><br/><br/>";
        echo "<input class='button2' type='submit' value='Modify Data'/>";
        echo "</form>";
    }
echo '</div>';
    $conn->close();
    echo '</div>';
     ?>
    <!-- navigation -->
    <a href="scanBarcode.php" class="button">Scan into Collection</a>
    <a href="admin.php" class="button">Admin</a>

</body>
</html>