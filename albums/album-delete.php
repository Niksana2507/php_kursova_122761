<?php
require_once('../db.php'); 
require_once('../functions.php');

$page = $_GET['page'] ?? 'home';
$album_id = $_GET['id'] ?? null;

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
    <!--Delete Page-->
    <section class="editPage">
        <form action="../handlers/handle_album_delete.php" method="POST">
            <fieldset>
                <legend>Изтрий Албума</legend>
                <input type="hidden" name="id" value="<?php echo ($album_id); ?>">
                <div class="container">
                    <p>Искаш да изтриеш албума?</p>
                    <div class="actionBtn"><a href="../web/index_with_profile.php" class="remove">Отказ</a></div>
                    <button class="delete-album" type="submit">Изтрий</button>
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