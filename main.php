<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>撮影した写真一覧</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <h1>撮影した写真一覧</h1>
        <div class="navigation-buttons">
            <a href="index.php" class="nav-button">新しく撮影する</a>
        </div>
        <div class="gallery">
            <?php
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $perPage = 12;
            $start = ($page - 1) * $perPage;

            $images = glob('uploads/*.{jpg,jpeg,png}', GLOB_BRACE);
            $totalImages = count($images);
            $totalPages = ceil($totalImages / $perPage);
            $images = array_slice($images, $start, $perPage);

            if (empty($images)) {
                echo '<p>まだ写真がありません。</p>';
            } else {
                foreach ($images as $image) {
                    echo '<div class="image-container">';
                    echo '<img src="' . $image . '" alt="撮影した写真">';
                    echo '<p class="image-date">' . date("Y/m/d H:i", filemtime($image)) . '</p>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
</body>

</html>