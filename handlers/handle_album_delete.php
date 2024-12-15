<?php
require_once('../db.php'); 
require_once('../functions.php');


    $album_id = $_POST['id'] ?? null;

    if (!$album_id) {
        $_SESSION['flash']['message']['type'] = 'danger';
        $_SESSION['flash']['message']['text'] = 'Невалидно ID!';
        header('Location: ../web/index_with_profile.php');
        exit;
    }

    // Delete the album
    $query = "DELETE FROM albums WHERE id = :id";
    $stmt = $pdo->prepare($query);

    if ($stmt->execute([':id' => $album_id])) {
        $_SESSION['flash']['message']['type'] = 'success';
        $_SESSION['flash']['message']['text'] = 'Албумът е изтрит успешно!';
        header('Location: ../web/index_with_profile.php');
        exit;
    } else {
        $_SESSION['flash']['message']['type'] = 'danger';
        $_SESSION['flash']['message']['text'] = 'Грешка при изтриване!';
        header("Location: ../albums/album-delete.php?pk=$id");
        exit;
    }

