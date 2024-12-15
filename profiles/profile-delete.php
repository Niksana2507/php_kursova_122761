<?php
require_once('../db.php'); 
require_once('../functions.php');

$page = $_GET['page'] ?? 'home';


$flash = [];
if (isset($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
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
            <div class="profileText">
                <!-- Delete Profile Form -->
                <h1>Искаш да изтриеш профила?</h1>
                <form action="../handlers/handle_profile_delete.php" method="POST">
                    <!-- Confirm Button -->
                    <div class="actionBtn"><a href="../web/index_with_profile.php" class="remove">Отказ</a></div>
                    <button class="delete-profile" type="submit">Изтрий</button>
                </form>
                <!-- End Delete Profile Form -->
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