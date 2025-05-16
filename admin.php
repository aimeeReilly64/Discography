<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discography by Aimee</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee+Spice&display=swap" rel="stylesheet">
</head>
<body>

<?php
$serverName = "sql5.freesqldatabase.com";
$userName = "sql5779219";
$passWord = "lemk21KrSt";
$dbName = "sql5779219";
$table = "VinylRecords";

$conn = new mysqli($serverName, $userName, $passWord, $dbName, 3306);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET["id"])) {
    $id = intval($_GET["id"]);
    $stmt = $conn->prepare("UPDATE $table SET removed = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<p class='success-message'>Record removed successfully.</p>";
    }
    $stmt->close();
}

echo "<div class='main-content'>
        <div class='context-box'>
            <h1>Modify Collection</h1>
        </div>";

echo "<div id='record-container'>";

$sql = "SELECT * FROM $table WHERE removed = 0";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row["id"];
        $upc = htmlspecialchars($row["upc_code"]);
        $bandName = htmlspecialchars($row["band_name"]);
        $albumName = htmlspecialchars($row["album_name"]);
        $albumYear = htmlspecialchars($row["album_year"]);
        $albumArtwork = htmlspecialchars($row["album_artwork"]);

        echo "<div class='record-card'>";
        echo "  <div class='image-wrapper'>";
        echo "      <img src='" . $albumArtwork . "' alt='Album artwork for " . $albumName . "' />";
        echo "      <div class='hover-details'>";
        echo "          <strong>ID:</strong> " . $id . "<br>";
        echo "          <strong>UPC:</strong> " . $upc . "<br>";
        echo "          <strong>Artist Name:</strong> " . $bandName . "<br>";
        echo "          <strong>Album Name:</strong> " . $albumName . "<br>";
        echo "          <strong>Album Year:</strong> " . $albumYear . "<br>";
        echo "      </div>";
        echo "  </div><br/>";
        echo "  <a href='modify.php?id=" . $id . "' class='button2'>Modify</a>";
        echo "  <a href='remove.php?id=" . $id . "'  class='button2'>Remove</a>";
        echo "  </form>";
        echo "</div>";
    }
} else {
    echo "<p>No records found in the collection.</p>";
}

echo "</div></div>";

$conn->close();
?>

<br/><br/>
<a href="scanBarcode.php" class="button">Scan into Collection</a>
<a href="viewCollection.php" class="button">View Collection</a>

</body>
</html>
