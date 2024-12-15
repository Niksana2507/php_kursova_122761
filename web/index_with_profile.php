<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//Debugging outputs (uncomment to test)
//var_dump($_SESSION);
require_once('../functions.php');
require_once('../db.php');

// Check if session 'owner_id' is set
$profile = null;
if (isset($_SESSION['owner_id'])) {
    // Fetch user profile
    $stmt = $pdo->prepare("SELECT * FROM profile WHERE owner_id = ?");
    $stmt->execute([$_SESSION['owner_id']]);
    $profile = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fetch all albums
$albums = [];
$stmt = $pdo->query("SELECT * FROM albums");
$albums = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Debugging outputs (uncomment to test)
// var_dump($_SESSION);
// var_dump($profile);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>Моето Музикално приложение</title>
    <link rel="stylesheet" href="../css/style.css"/>
</head>

<body>
<div id="box">
    <!-- Navigation Bar -->
    <header>
        <nav>
            <img src="../images/headphones.png" alt="headphones"/>
            <a href="?page=home" class="nav-link">Начало</a>
            <?php if ($profile): ?>
                <!-- Navigation for logged-in users -->
                <ul>
                <?php echo '<span class="text-light me-3">Здравей, ' . htmlspecialchars($_SESSION['names']) . '</span>'; ?>
                    <li><a href="../albums/album-add.php">Добави Албум</a></li>
                    <li><a href="../profiles/profile-details.php">Профил</a></li>
                </ul>
            <?php endif; ?>
        </nav>
    </header>

    <!-- Main Content -->
    <section id="catalogPage">
        <?php if (empty($albums)): ?>
            <!-- If No Albums -->
            <p>Няма албуми в каталога!</p>
        <?php else: ?>
            <!-- If Albums Exist -->
            <h1>Всички албуми</h1>
            <?php foreach ($albums as $album): ?>
                <div class="card-box">
                    <img src="<?php echo htmlspecialchars($album['image_URL'] ?? ''); ?>" alt="Cover Image"/>
                    <div>
                        <div class="text-center">
                            <p class="name">Name: <?php echo htmlspecialchars($album['name']); ?></p>
                            <p class="artist">Artist: <?php echo htmlspecialchars($album['artist_name']); ?></p>
                            <p class="genre">Genre: <?php echo htmlspecialchars($album['genre']); ?></p>
                            <p class="price">Price: <?php echo htmlspecialchars($album['price']); ?></p>
                        </div>
                        <div class="btn-group">
                            <a href="../albums/album-details.php?pk=<?php echo $album['id']; ?>">Детайли</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>

    <!-- Footer -->
    <footer>
        <div>&copy;Nikolay Nikov. All rights reserved.</div>
    </footer>
</div>
</body>
</html>
