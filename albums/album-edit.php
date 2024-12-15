<?php
require_once('../db.php'); 
require_once('../functions.php');

$page = $_GET['page'] ?? 'home';
$album_id = $_GET['id'];
$albums = null;

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

$stmt = $pdo->prepare("SELECT * FROM albums WHERE id = ?");
$stmt->execute([$album_id]);
$albums = $stmt->fetch(PDO::FETCH_ASSOC);

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
    <!--Edit Page-->
    <section class="editPage">
        <form action="../handlers/handle_album_edit.php" method="POST">
            <fieldset>
                <legend>Редактирай албум</legend>
                <input type="hidden" name="id" value="<?php echo ($albums['id']); ?>">
                <div class="container">
                    <!-- Form for Editing Album -->
                    <label for="name">Име на албум:</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($albums['name']); ?>" required>

                        <label for="artist_name">Име на изпълнител:</label>
                        <input type="text" id="artist_name" name="artist_name" value="<?php echo htmlspecialchars($albums['artist_name']); ?>" required>

                        <label for="genre">Жанр:</label>
                        <input type="text" id="genre" name="genre" value="<?php echo htmlspecialchars($albums['genre']); ?>" required>

                        <label for="price">Цена:</label>
                        <input type="number" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($albums['price']); ?>" required>

                        <label for="image_URL">Снимка URL:</label>
                        <input type="url" id="image_URL" name="image_URL" value="<?php echo htmlspecialchars($albums['image_URL']); ?>" required>

                        <button class="edit-album" type="submit">Редактирай</button>
 
                </div>
            </fieldset>
        </form>
    </section>

    <!-- Footer -->
    <footer>
        <div>&copy;Nikolay Nikov. All rights reserved.</div>
    </footer>
    <!-- End Footer -->
</div>
</body>
</html>