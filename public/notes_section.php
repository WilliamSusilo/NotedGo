<?php
session_start();
require "connection.php";

// Ambil user_id dari sesi
$user_id = $_SESSION["user_id"] ??'';

// Ambil catatan baru yang dibuat dalam satu hari terakhir
$new_notes = [];
$sql_new = "SELECT * FROM notes WHERE user_id = ? AND DATEDIFF(NOW(), created_at) < 1";
$stmt_new = $conn->prepare($sql_new);
$stmt_new->bind_param('s', $user_id);
$stmt_new->execute();
$result_new = $stmt_new->get_result();
while ($row_new = $result_new->fetch_assoc()) {
    $new_notes[] = $row_new;
}
$stmt_new->close();

// Ambil catatan ongoing (tidak baru)
$ongoing_notes = [];
$sql_ongoing = "SELECT * FROM notes WHERE user_id = ? AND DATEDIFF(NOW(), created_at) >= 1";
$stmt_ongoing = $conn->prepare($sql_ongoing);
$stmt_ongoing->bind_param('s', $user_id);
$stmt_ongoing->execute();
$result_ongoing = $stmt_ongoing->get_result();
while ($row_ongoing = $result_ongoing->fetch_assoc()) {
    $ongoing_notes[] = $row_ongoing;
}
$stmt_ongoing->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="assets/img/Logo/NotedGo1.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes Section</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: "Karla", monospace;
        }

        .futuristic-purple {
            background: linear-gradient(to right, #f6f5ff, #994fff);
        }

        .section-title {
            background-color: #6a00ff;
        }

        .bg-image-1 {
            background-image: url('assets/img/BG/bg-4.avif');
            background-size: cover;
            background-repeat: no-repeat;
        }
    </style>
</head>

<body class="bg-gray-100 mb-5">

    <!-- Header and Navbar -->
    <header class="futuristic-purple px-5 py-4">
      <div class="container mx-auto flex justify-between items-center px-4">
        <a href="dashboard.php">
            <img src="assets/img/Logo/NotedGo2.png" class="w-40 py-0" alt="NotedGo Logo" />
        </a>
        <nav class="hidden md:block">
            <a href="dashboard.php" class="text-white font-semibold text-xl hover:underline">Back to Dashboard</a>
        </nav>
        <!-- Mobile Navbar Button -->
        <div class="md:hidden">
          <button id="mobile-menu-button" class="text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
          </button>
        </div>
      </div>
    </header>
    <!-- Mobile Navbar -->
    <div id="mobile-menu" class="hidden md:hidden">
      <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
        <a href="dashboard.php" class="text-black block px-3 py-2 rounded-md text-base font-medium hover:bg-purple-500">Back to Dashboard</a>
    </div>
    </div>


    <!-- Main Content -->
    <main class="container mx-auto px-10 pt-28 pb-10 h-full bg-image-1">
        <!-- New Notes Section -->
        <section class="mb-8 px-10 py-10 bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-5">New Notes (Created within 1 Day)</h2>
            <?php if (empty($new_notes)) : ?>
                <p class="text-gray-500">The New Notes was Still Empty!</p>
            <?php else : ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php foreach ($new_notes as $note) :
                        $mood_color = '';
                        switch ($note['mood']) {
                            case 'happy':
                                $mood_color = 'yellow';
                                break;
                            case 'sad':
                                $mood_color = 'blue';
                                break;
                            case 'empty':
                                $mood_color = 'gray';
                                break;
                        }
                    ?>
                        <div class="bg-<?php echo $mood_color; ?>-400 block p-4 rounded-lg shadow-md hover:bg-<?php echo $mood_color; ?>-500 transition duration-300 transform hover:scale-105">
                            <a href="detail_note.php?note_id=<?= $note["note_id"]; ?>">
                                <p class="text-sm text-white font-bold"><?= $note["category"]; ?></p>
                                <p class="text-xl font-semibold"><?= $note["title"]; ?></p>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <hr class="footer-divider my-8 w-5/6 border-solid border-white border-t-2 mx-auto" />

        <!-- Ongoing Notes Section -->
        <section class="mb-8 px-10 py-10 bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-5">Ongoing Notes (Created More than 1 Day Ago)</h2>
            <?php if (empty($ongoing_notes)) : ?>
                <p class="text-gray-500">The Ongoing Notes was Still Empty!</p>
            <?php else : ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php foreach ($ongoing_notes as $note) :
                        $mood_color = '';
                        switch ($note['mood']) {
                            case 'happy':
                                $mood_color = 'yellow';
                                break;
                            case 'sad':
                                $mood_color = 'blue';
                                break;
                            case 'empty':
                                $mood_color = 'gray';
                                break;
                        }
                    ?>
                        <div class="bg-<?php echo $mood_color; ?>-400 block p-4 rounded-lg shadow-md hover:bg-<?php echo $mood_color; ?>-500 transition duration-300 transform hover:scale-105">
                            <a href="detail_note.php?note_id=<?= $note["note_id"]; ?>">
                            <p class="text-sm text-white font-bold"><?= $note["category"]; ?></p>
                            <p class="text-xl font-semibold"><?= $note["title"]; ?></p>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer mt-20 px-10 pb-0 mb-0">
        <div class="container mx-auto flex flex-col md:flex-row items-center justify-between px-4">
            <div class="footer-content flex flex-col md:flex-row md:justify-between w-full md:w-4/5 lg:w-full">
            <div class="links mb-8 md:mb-0">
                <h2 class="text-2xl mb-4">Noted App</h2>
                <div class="social-links flex gap-2">
                <a href="#" class="bg-blue-500 px-2 py-1 rounded-lg transition duration-300 hover:bg-blue-700"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="bg-blue-500 px-2 py-1 rounded-lg transition duration-300 hover:bg-blue-700"><i class="fab fa-twitter"></i></a>
                <a href="#" class="bg-blue-500 px-2 py-1 rounded-lg transition duration-300 hover:bg-blue-700"><i class="fab fa-instagram"></i></a>
                <a href="#" class="bg-blue-500 px-2 py-1 rounded-lg transition duration-300 hover:bg-blue-700"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
            <div class="links mb-8 md:mb-0">
                <p class="font-semibold mb-2">Information</p>
                <ul>
                <li>Jakarta Utara, Indonesia</li>
                <li>notedapp@gmail.com</li>
                </ul>
            </div>
            <div class="links">
                <p class="font-semibold mb-2">Navigation</p>
                <nav class="flex flex-col">
                    <a href="dashboard.php" class="link">Dashboard</a>
                    <a href="mood_selection.php" class="link">Mood Selection</a>
                    <a href="notes_section.php" class="link">List of Notes</a>
                    <a href="habit_section.php" class="link">List of Habits</a>
                    <a href="logout.php" class="link">Logout</a>
                </nav>
            </div>
            </div>
        </div>
        <hr class="footer-divider my-8" />
        <p class="copyright text-center text-gray-700">&copy; 2024 Noted App - William Susilo</p>
    </footer>

    <script>
      document.getElementById('mobile-menu-button').addEventListener('click', function () {
        document.getElementById('mobile-menu').classList.toggle('hidden');
      });
    </script>

</body>

</html>
