<?php
require_once('../db.php');
require_once('../functions.php');

    $id = $_POST['id'] ?? '';
    $name = $_POST['name'] ?? '';
    $artist_name = $_POST['artist_name'] ?? '';
    $genre = $_POST['genre'] ?? '';
    $price = $_POST['price'] ?? '';
    $image_URL = $_POST['image_URL'] ?? '';

    // Validation
    if (empty($name) || empty($artist_name) || empty($genre) || empty($price) || empty($image_URL)) {
        $_SESSION['flash']['message']['type'] = 'danger';
        $_SESSION['flash']['message']['text'] = "Моля, попълнете всички полета!";
        header("Location: ../albums/album-edit.php?pk=$id");
        exit;
    }

    // Update Query
    $sql = "UPDATE albums SET name = :name, artist_name = :artist_name, genre = :genre, price = :price, image_URL = :image_URL WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    $params = [
        ':id' => $id,
        ':name' => $name,
        ':artist_name' => $artist_name,
        ':genre' => $genre,
        ':price' => $price,
        ':image_URL' => $image_URL
    ];

    if ($stmt->execute($params)) {
        $_SESSION['flash']['message']['type'] = 'success';
        $_SESSION['flash']['message']['text'] = "Албумът беше успешно променен!";
        header("Location: ../web/index_with_profile.php");
        exit;
    } else {
        $_SESSION['flash']['message']['type'] = 'danger';
        $_SESSION['flash']['message']['text'] = "Грешка при редактиране на албума!";
        header("Location: ../albums/album-edit.php?pk=$id");
        exit;
    }
?>
