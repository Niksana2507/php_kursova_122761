<?php
// boilerplate index
require_once('../functions.php');
require_once('../db.php');

$page = $_GET['page'] ?? 'home';

$flash = [];
if (isset($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
}

// debug($flash);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>Моето музикално приложение</title>
    <!-- Static Load -->
    <link rel="stylesheet" href="../css/style.css"/>
</head>

<body>
<div id="box">
    <!-- Navigation Bar -->
    <header>
        <nav>
            <img src="../images/headphones.png" alt="headphones"/>
            <a href="?page=home" class="<?php echo ($page == 'home' ? 'active' : ''); ?>">Начало</a>
            <ul></ul>
        </nav>
    </header>
    <!-- End Navigation Bar -->
                <!-- Main Content -->
                <!--Home Page-->
                <div class="container-inline">
                    <section id="welcomePage">
                        <div id="welcome-message">
                            <h1>Добре дошли в</h1>
                            <h1>Моето музикално приложение!</h1>
                        </div>
                        <div class="music-img">
                            <img src="../images/musicIcons.webp" alt="music-icon"/>
                        </div>
                    </section>

                    <!-- Registration -->
                    <section id="registerPage">
                        <form action="../handlers/handle_register.php" method="POST">
                            <fieldset>
                                <legend>Профил</legend>
                                <!-- Registration Form -->
                                <label for="names">Име:</label>
                                <input type="text" id="names" name="names" required>

                                <label for="email">Имейл:</label>
                                <input type="email" id="email" name="email" required>

                                <label for="age">Възраст:</label>
                                <input type="number" id="age" name="age" required>

                                <label for="password">Парола:</label>
                                <input type="password" id="password" name="password" required>

                                <label for="repeat_password">Повтори парола:</label>
                                <input type="password" id="repeat_password" name="repeat_password" required>

                                <!-- Button to Create Profile -->
                                <button type="submit" class="register">Регистрация</button>
                            </fieldset>
                        </form>
                    </section>
                </div>
    <!-- Footer -->
    <footer>
        <div>&copy;Nikolay Nikov. All rights reserved.</div>
    </footer>
    <!-- End Footer -->
</div>
</body>
</html>




