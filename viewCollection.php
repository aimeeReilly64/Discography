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
//you cannot change any info on this page, but you can see the whole collection and rotate through it
//albums to be displayed on the screen by showing the album cover artwork.
//On hover of the image it will display the name of the band, album, and year.
//Please Add the ability to sort the list by band, album name, and year in ascending or descending order.

$serverName = "sql5.freesqldatabase.com";
$userName = "sql5779219";
$passWord = "lemk21KrSt";
$dbName = "sql5779219";
$table = "VinylRecords";

$conn = new mysqli($serverName, $userName, $passWord, $dbName, 3306);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$validSortColumns = ['band_name', 'album_name', 'album_year'];
$sortBy = in_array($_GET['sortBy'] ?? '', $validSortColumns) ? $_GET['sortBy'] : 'band_name';
$sortOrder = ($_GET['sortOrder'] ?? '') === 'DESC' ? 'DESC' : 'ASC';

$sql = "SELECT * FROM $table WHERE removed = 0 ORDER BY $sortBy $sortOrder";
$result = $conn->query($sql);

echo "<div class='main-content'>
        <div class='context-box'>
            <h1>Your Collection</h1>
        </div>
<form method='GET' style='margin-bottom: 20px;'>
    <label for='sortBy'>Sort by:</label>
    <select name='sortBy' id='sortBy'>
        <option value='band_name'" . ($sortBy === 'band_name' ? ' selected' : '') . ">Band</option>
        <option value='album_name'" . ($sortBy === 'album_name' ? ' selected' : '') . ">Album Name</option>
        <option value='album_year'" . ($sortBy === 'album_year' ? ' selected' : '') . ">Year</option>
    </select>

    <select name='sortOrder' id='sortOrder'>
        <option value='ASC'" . ($sortOrder === 'ASC' ? ' selected' : '') . ">Ascending</option>
        <option value='DESC'" . ($sortOrder === 'DESC' ? ' selected' : '') . ">Descending</option>
    </select>

    <button type='submit' class='button'>Sort</button>
</form>
        <div id='record-container'>";

// Show records
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = htmlspecialchars($row["id"]);
        $bandName = htmlspecialchars($row["band_name"]);
        $albumName = htmlspecialchars($row["album_name"]);
        $albumYear = htmlspecialchars($row["album_year"]);
        $albumArtwork = htmlspecialchars($row["album_artwork"]);

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
            </div>
        </div>";
    }
} else {
    echo "<p>No records found.</p>";
}
// close
echo "</div> <!-- end #record-container -->
      </div> <!-- end .main-content -->";

$conn->close();
?>


<!-- navigation -->
<a href="scanBarcode.php" class="button">Scan into Collection</a>
<a href="admin.php" class="button">Admin</a>

</body>
</html>
