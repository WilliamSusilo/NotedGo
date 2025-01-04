<?php
require_once 'connection.php';

if (isset($_GET['note_id'])) {
  $note_id = $_GET['note_id'];

  // Mulai transaksi
  $conn->begin_transaction();

  try {
    // Hapus referensi di tabel habits
    $q1 = $conn->query("DELETE FROM habits WHERE note_id = '$note_id'");

    // Hapus data dari tabel notes
    $q2 = $conn->query("DELETE FROM notes WHERE note_id = '$note_id'");

    if ($q1 && $q2) {
      // Commit transaksi
      $conn->commit();
      echo "<script>alert('Data Deleted Successfully'); window.location.href='notes_section.php'</script>";
    } else {
      // Rollback transaksi
      $conn->rollback();
      echo "<script>alert('Data Fail to Delete'); window.location.href='notes_section.php'</script>";
    }
  } catch (Exception $e) {
    // Rollback transaksi jika terjadi kesalahan
    $conn->rollback();
    echo "<script>alert('Data Fail to Delete: " . $e->getMessage() . "'); window.location.href='notes_section.php'</script>";
  }
} else {
  // Apabila Mencoba Akses Langsung ke File Ini akan Diredirect ke Halaman Index
  header('Location: notes_section.php');
}
?>
