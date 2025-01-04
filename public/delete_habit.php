<?php
require_once 'connection.php';

if (isset($_GET['habit_id'])) {
  $habit_id = $_GET['habit_id'];

  // Mulai transaksi
  $conn->begin_transaction();

  try {
    // Hapus data dari tabel habits
    $q = $conn->query("DELETE FROM habits WHERE habit_id = '$habit_id'");

    if ($q) {
      // Commit transaksi
      $conn->commit();
      echo "<script>alert('Habit Deleted Successfully'); window.location.href='habit_section.php'</script>";
    } else {
      // Rollback transaksi
      $conn->rollback();
      echo "<script>alert('Failed to Delete Habit'); window.location.href='habit_section.php'</script>";
    }
  } catch (Exception $e) {
    // Rollback transaksi jika terjadi kesalahan
    $conn->rollback();
    echo "<script>alert('Failed to Delete Habit: " . $e->getMessage() . "'); window.location.href='habit_section.php'</script>";
  }
} else {
  // Apabila Mencoba Akses Langsung ke File Ini akan Diredirect ke Halaman habit_section.php
  header('Location: habit_section.php');
}
?>
