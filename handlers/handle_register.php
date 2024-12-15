<?php

require_once('../functions.php');
require_once('../db.php');

$error = '';
foreach ($_POST as $key => $value) {
    if (empty($value)) {
        $error = 'Моля, попълнете всички полета!';
    }
}

if (mb_strlen($error) == 0) {
    $names = $_POST['names'] ?? '';
    $email = $_POST['email'] ?? '';
    $age = $_POST['age'] ?? '';
    $password = $_POST['password'] ?? '';
    $repeat_password = $_POST['repeat_password'] ?? '';

    // проверка дали потребителят вече съществува
    $sql = "SELECT owner_id FROM profile WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $row = $stmt->fetch();
    if ($row) {
        $error = 'Грешка при регистрация!';
    }
}

if (mb_strlen($error) == 0) {
    // проверка дали паролите съвпадат
    if ($password !== $repeat_password) {
        $error = 'Паролите не съвпадат!';
    }
}

if (mb_strlen($error) > 0) {
    $_SESSION['flash']['message']['text'] = $error;
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['data'] = $_POST;
    header("Location: ../web/index_without_profile.php?page=home");
    exit;
} else {
    $hash = password_hash($password, PASSWORD_ARGON2I);
    $sql_insert = "INSERT INTO profile (names, email, age, `password`) VALUES (:names, :email, :age, :hash)";
    $stmt_insert = $pdo->prepare($sql_insert);
    $stmt_insert->execute([':names' => $names, ':email' => $email, ':age' => $age, ':hash' => $hash]);

    if ($stmt_insert) {
        // Set session variables after successful registration
        $_SESSION['owner_id'] = $pdo->lastInsertId();
        $_SESSION['names'] = $names;

        $_SESSION['flash']['message']['text'] = "Успешна регистрация!";
        $_SESSION['flash']['message']['type'] = 'success';
        header("Location: ../web/index_with_profile.php");
        exit;
    } else {
        $error = 'Грешка при регистрация!';
        $_SESSION['flash']['message']['text'] = $error;
        $_SESSION['flash']['message']['type'] = 'danger';
        header("Location: ../web/index_without_profile.php?page=home&error=$error");
        exit;
    }
}

?>