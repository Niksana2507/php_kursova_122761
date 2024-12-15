<?php

require_once('../functions.php');
require_once('../db.php');

$flash = [];
if (isset($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
}




// Check if the form is submitted via POST

    // Sanitize and retrieve form data
    $name = $_POST['name'] ?? '';
    $artist_name = $_POST['artist_name'] ?? '';
    $genre = $_POST['genre'] ?? '';
    $price = $_POST['price'] ?? '';
    $image_URL = $_POST['image_URL'] ?? '';
    $owner_id = $_SESSION['owner_id'] ?? null;

    // Validate the required fields
    if (
        mb_strlen($name) <= 0 || mb_strlen($artist_name) <= 0 || 
        mb_strlen($genre) <= 0 || mb_strlen($price) <= 0 || 
        mb_strlen($image_URL) <= 0
    ) {
        $_SESSION['flash']['message']['type'] = 'danger';
        $_SESSION['flash']['message']['text'] = "Моля попълнете всички полета!";
        header('Location: ../albums/album-add.php');
        exit;
    }

    // Validate that the owner_id exists
    if (!$owner_id) {
        $_SESSION['flash']['message']['type'] = 'danger';
        $_SESSION['flash']['message']['text'] = "Моля, влезте в системата, за да добавите албум.";
        header('Location: ../web/index_without_profile.php?page=home');
        exit;
    }

    // Insert data into the database
    try {
        $query = "INSERT INTO albums (name, artist_name, genre, price, image_url, owner_id) 
                  VALUES (:name, :artist_name, :genre, :price, :image_URL, :owner_id)";
        $stmt = $pdo->prepare($query);
        $params = [
            ':name' => $name,
            ':artist_name' => $artist_name,
            ':genre' => $genre,
            ':price' => $price,
            ':image_URL' => $image_URL,
            ':owner_id' => $owner_id
        ];

        if ($stmt->execute($params)) {
            // Success message
            $_SESSION['flash']['message']['type'] = 'success';
            $_SESSION['flash']['message']['text'] = "Албумът беше добавен успешно!";
            header('Location: ../web/index_with_profile.php');
            exit;
        } else {
            // Failure message
            throw new Exception("Грешка при добавяне на албума.");
        }
    } catch (Exception $e) {
        $_SESSION['flash']['message']['type'] = 'danger';
        $_SESSION['flash']['message']['text'] = $e->getMessage();
        header('Location: ../albums/album-add.php');
        exit;
    }

?>
