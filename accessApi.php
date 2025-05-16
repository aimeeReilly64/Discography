<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Discogs Release Viewer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee+Spice&display=swap" rel="stylesheet">
</head>
<body>
<?php
$consumerKey    = "VWmkjkUzClwEzYbtgxJz";
$consumerSecret = "fZXDFbPoTcLgcPUYkdONPfjrtsjuJjvl";

$upc = trim($_POST['barcode'] ?? '');
if (empty($upc)) {
    die("<div class='main-content'>
            <div class='context-box'>
                <p>No barcode provided. Please scan a valid barcode.</p>
                <p><a href='manualAdd.php' class='button2'>Manually Add Data</a></p>
            </div>
          </div>
          <a href='scanBarcode.php' class='button'>Rescan into Collection</a>
          <a href='admin.php' class='button'>Admin</a>
          <a href='viewCollection.php' class='button'>View Collection</a>");
}

$searchUrl = "https://api.discogs.com/database/search?" . http_build_query([
    'barcode' => $upc,
    'key'     => $consumerKey,
    'secret'  => $consumerSecret,
]);

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL            => $searchUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_USERAGENT      => 'Discogs/1.0',
    CURLOPT_SSL_VERIFYPEER => false,
]);
$response = curl_exec($ch);
if ($response === false) {
    $error = curl_error($ch);
    curl_close($ch);
    die("<p>cURL Error during search: $error</p>");
}
curl_close($ch);

$searchData = json_decode($response, true);
if (empty($searchData['results'])) {
    echo "<div class='main-content'>
            <div class='context-box'>
                <p>No results found for UPC: " . htmlspecialchars($upc) . ".</p>
                <p><a href='manualAdd.php' class='button2'>Manually Add Data</a></p>
            </div>
          </div>";
    exit;
}

$firstResult = $searchData['results'][0];
$releaseId   = $firstResult['id'];
$releaseUrl  = "https://api.discogs.com/releases/{$releaseId}";

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL            => $releaseUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_USERAGENT      => 'Discogs/1.0',
    CURLOPT_SSL_VERIFYPEER => false,
]);
$responseRelease = curl_exec($ch);
if ($responseRelease === false) {
    $error = curl_error($ch);
    curl_close($ch);
    die("<p>cURL Error during release fetch: $error</p>");
}
curl_close($ch);

$releaseData = json_decode($responseRelease, true);

$albumName = $releaseData['title'] ?? 'Unknown Album';
$albumYear = $releaseData['year'] ?? 'Unknown Year';
$bandName  = isset($releaseData['artists'][0]['name']) ? $releaseData['artists'][0]['name'] : 'Unknown Band';
$images    = $releaseData['images'] ?? [];

$imageUrl = "";
if (!empty($images) && isset($images[0]['uri'])) {
    $imageUrl = $images[0]['uri'];
}

$serverName = "sql5.freesqldatabase.com";
$userName = "sql5779219";
$passWord = "lemk21KrSt";
$dbName = "sql5779219";
$table = "VinylRecords";

$conn = new mysqli($serverName, $userName, $passWord, $dbName, 3306);
if ($conn->connect_error) {
    die("<p>Connection failed: " . $conn->connect_error . "</p>");
}

if (!empty($upc)) {
    $sql = "INSERT INTO $table (upc_code, band_name, album_name, album_year, album_artwork) 
            VALUES ('$upc', '$bandName', '$albumName', '$albumYear', '$imageUrl')";
    if ($conn->query($sql) !== true) {
        echo "<p>Error inserting data: " . $conn->error . "</p>";
    }
}
$conn->close();
?>

<div class="main-content">
    <div class="context-box">
        <h1>Discogs Release Details</h1>
    </div>
    <div class="context-box2">
        <p class="text"><strong>Band:</strong> <?php echo htmlspecialchars($bandName); ?></p>
        <p class="text"><strong>Album:</strong> <?php echo htmlspecialchars($albumName); ?></p>
        <p class="text"><strong>Year:</strong> <?php echo htmlspecialchars($albumYear); ?></p>
    </div>
    <div class="context-box2">
        <?php if (!empty($imageUrl)): ?>
            <img src="<?php echo htmlspecialchars($imageUrl); ?>" alt="Album artwork for <?php echo htmlspecialchars($albumName); ?>" style="max-width: 600px; width: 100%; border: 1px solid #ccc;">
        <?php else: ?>
            <p>No image available for this release.</p>
        <?php endif; ?>
    </div>

        <a href="scanBarcode.php" class="button">Scan into Collection</a>
        <a href="admin.php" class="button">Admin</a>
        <a href="viewCollection.php" class="button">View Collection</a>

</div>
</body>
</html>
