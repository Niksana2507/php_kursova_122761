<?php
require_once('../db.php'); 
require_once('../functions.php');

$page = $_GET['page'] ?? 'home';

$flash = [];
if (isset($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
}


$stmt = $pdo->prepare("SELECT * FROM profile WHERE owner_id = ?");
$stmt->execute([$_SESSION['owner_id']]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt_albums = $pdo->prepare("SELECT COUNT(*) as album_count FROM albums WHERE owner_id = ?");
$stmt_albums->execute([$_SESSION['owner_id']]);
$album_count = $stmt_albums->fetch(PDO::FETCH_ASSOC)['album_count'];

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
            <div class="profilePage">
                <img
                        src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png"
                        alt="Profile Image"
                />
            </div>

            <div class="profileText">
                <!-- Profile Info -->
                <h1>Потребител: <?php echo($profile['names']); ?></h1>
                <h1>Имейл: <?php echo ($profile['email']); ?></h1>
                <h1>Години: <?php echo ($profile['age']); ?></h1>
                <h1>Албуми: <?php echo $album_count; ?></h1>
            </div>

            <div class="actionBtn">
                <!-- Button for Deleting the Profile -->
                <a href="../profiles/profile-delete.php" class="remove">Изтрий</a>
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






