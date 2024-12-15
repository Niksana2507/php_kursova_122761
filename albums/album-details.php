<?php
require_once('../db.php'); 
require_once('../functions.php');

$page = $_GET['page'] ?? 'home';

$flash = [];
if (isset($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
}

if (isset($flash['message'])) {
    echo '
        <div class="alert alert-' . $flash['message']['type'] . '">
            ' . $flash['message']['text'] . '
        </div>
    ';
}

if (isset($_GET['pk']) && is_numeric($_GET['pk'])) {
    $album_id = $_GET['pk'];

    // Fetch the specific album
    $stmt = $pdo->prepare("SELECT * FROM albums WHERE id = ?");
    $stmt->execute([$album_id]);
    $albums = $stmt->fetch(PDO::FETCH_ASSOC);
} 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>Моето Музикално приложение</title>
    <!-- Static Load -->
    <link rel="stylesheet" href="../css/style.css"/>
</head>

<body>
<div id="box">
    <!-- Navigation Bar -->
    <header>
        <nav>
            <img src="../images/headphones.png" alt="headphones"/>
            <a href="../web/index_with_profile.php">Начало</a>
            <ul></ul>
                <ul>
                    <!--Only for user with created profile-->
                    <li><a href="../albums/album-add.php">Добави албум</a></li>
                    <li><a href="../profiles/profile-details.php">Профил</a></li>
                </ul>
        </nav>
    </header>
    <!-- End Navigation Bar -->
    <!-- Main Content -->
    <!-- Catalog with Albums-->
    <section id="detailsPage">
        <div class="wrapper">
            <div class="albumCover">
                <!-- Album Image -->
                <img src="<?php echo htmlspecialchars($albums['image_URL']); ?>" alt="Cover Image">
            </div>

            <div class="albumInfo">
                <div class="albumText">
                    <!-- Album Info -->
                    <h1>Име: <?php echo htmlspecialchars($albums['name']); ?></h1>
                    <h3>Изпълнител: <?php echo htmlspecialchars($albums['artist_name']); ?></h3>
                    <h4>Жанр: <?php echo htmlspecialchars($albums['genre']); ?></h4>
                    <h4>Цена: <?php echo htmlspecialchars($albums['price']); ?></h4>
                </div>

                <div class="actionBtn">
                    <!-- Album Buttons -->
                    <a href="album-edit.php?id=<?php echo $albums['id']; ?>" class="edit">Промени</a>
                    <a href="album-delete.php?id=<?php echo $albums['id']; ?>" class="remove">Изтрий</a>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer>
        <div>&copy;Nikolay Nikov. All rights reserved.</div>
    </footer>
    <!-- End Footer -->
</div>
</body>
</html>