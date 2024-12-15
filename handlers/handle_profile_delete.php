<?php
require_once('../db.php');
require_once('../functions.php');


// Check if user is logged in
if (!isset($_SESSION['owner_id'])) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = 'Няма активен потребител!';
    header('Location: ../web/index_without_profile.php');
    exit;
}

try {
    $owner_id = $_SESSION['owner_id'];
    
    // Begin transaction
    $pdo->beginTransaction();

    // Delete all albums associated with this user
    $delete_albums = "DELETE FROM albums WHERE owner_id = :owner_id";
    $stmt_albums = $pdo->prepare($delete_albums);
    $stmt_albums->execute([':owner_id' => $owner_id]);

    // Delete user profile
    $delete_profile = "DELETE FROM profile WHERE owner_id = :owner_id";
    $stmt_profile = $pdo->prepare($delete_profile);
    $stmt_profile->execute([':owner_id' => $owner_id]);

    // Commit the transaction
    $pdo->commit();

    // Clear session
    session_destroy();

    // Set success message
    session_start(); // Restart session to set flash message
    $_SESSION['flash']['message']['type'] = 'success';
    $_SESSION['flash']['message']['text'] = 'Профилът беше изтрит успешно!';

    // Redirect to home page
    header('Location: ../web/index_without_profile.php');
    exit;

} catch (Exception $e) {
    // Rollback the transaction on error
    $pdo->rollBack();
    
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = 'Грешка при изтриване на профила!';
    header('Location: ../profiles/profile-details.php');
    exit;
}
?>
