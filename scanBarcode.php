<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discography by Mitch, Aimee + Chloe</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee+Spice&display=swap" rel="stylesheet">
</head>
<body>
<?php
//scan form for barcode
if ($_SERVER["REQUEST_METHOD"] != "POST") {
   echo '<div class=context-box>';
   echo         '<h1>Scan & Collect</h1><br/>';
    echo '</div>';
    echo '<div class=context-box2>';
    echo '<form action="accessApi.php" method="POST" onload="">';
    echo '<br/><br/><input type="text" name="barcode"/><br/><br/><input type="submit" class="button" value="Scan"/>';
    echo '</form><br/><br/>';
    echo' </div>';
}
echo'
<!-- navigation -->
<a href="scanBarcode.php" class="button">Scan into Collection</a>
<a href="admin.php" class="button">Admin</a>
<a href="viewCollection.php" class="button">View Collection</a>

</body>
</html>
 ';