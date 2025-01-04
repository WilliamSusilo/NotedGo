<?php
session_start();
require_once 'connection.php';

// Debug: Untuk memeriksa data yang diterima dari form
var_dump($_POST);

if (isset($_POST['tambah'])) {
    $note_id = $_POST['note_id'];
    $user_id = $_SESSION["user_id"];
    $mood = $_POST["mood"];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST["category"];

    $q = $conn->prepare("UPDATE notes SET user_id = ?, mood = ?, title = ?, content = ?, category = ? WHERE note_id = ?");
    $q->bind_param('ssssss', $user_id, $mood, $title, $content, $category, $note_id);

    if ($q->execute()) {
        echo "<script>alert('Data Changed Successfully'); window.location.href='notes_section.php'</script>";
    } else {
        echo "<script>alert('Data Fail to Changed'); window.location.href='notes_section.php'</script>";
    }
} else {
    header('Location: notes_section.php');
}
?>
