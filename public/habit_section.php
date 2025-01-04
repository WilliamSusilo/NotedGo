<?php
session_start();
require "connection.php";

// Ambil user_id dari sesi
$user_id = $_SESSION["user_id"] ?? '';

// Ambil habit yang dimiliki user
$habits = [];
$sql_habits = "SELECT * FROM habits INNER JOIN notes ON habits.note_id = notes.note_id INNER JOIN users ON habits.user_id = users.user_id WHERE habits.user_id = ?";
$stmt_habits = $conn->prepare($sql_habits);
$stmt_habits->bind_param('s', $user_id);
$stmt_habits->execute();
$result_habits = $stmt_habits->get_result();
while ($row_habits = $result_habits->fetch_assoc()) {
    $habits[] = $row_habits;
}
$stmt_habits->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="assets/img/Logo/NotedGo1.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habits Section</title>
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
            background-image: url('assets/img/BG/bg-2.avif');
            background-size: cover;
            background-repeat: no-repeat;
        }

        .centered-div {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .futuristic-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .drop-shadow-lg {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1), 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .elevated {
            position: relative;
            z-index: 1;
            border-radius: 0.75rem;
        }

        .elevated:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(0, 0, 0, 0.1) 100%);
            border-radius: 0.75rem;
            z-index: -1;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }

        .futuristic {
            position: relative;
            overflow: hidden;
        }

        .futuristic::before {
            content: "";
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(to right bottom, #483d8b, #8a2be2, #483d8b);
            filter: blur(20px);
            z-index: -1;
        }

        .futuristic:hover::before {
            filter: blur(40px);
        }

        .shadow-2xl {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}


    </style>
</head>

<body class="bg-white mb-5">

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

        <!-- Habits Section -->
        <section class="mb-8">
            <div class="centered-div">
                <div class="relative w-full md:w-1/3 bg-white p-5 rounded-lg shadow-xl text-black futuristic-card elevated drop-shadow-lg">
                    <h2 class="text-4xl font-bold mb-4 text-center">Your Habits</h2>
                    <p class="text-md mb-5 text-center">User ID: <?= htmlspecialchars($user_id); ?></p>
                </div>
            </div>
            <?php if (empty($habits)) : ?>
                <div class="flex justify-center items-center mt-10">
                    <div class="mb-8 bg-white p-6 rounded-lg shadow-lg max-w-md">
                        <p class="text-center text-red-600 font-bold">The List of Habits is Still Empty!</p>
                    </div>
                </div>
            <?php else : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-4">
                <?php foreach ($habits as $habit) : ?>
                    <div class="bg-gradient-to-r from-purple-600 to-indigo-700 block p-6 rounded-lg shadow-xl hover:shadow-2xl transition duration-300 transform hover:scale-105 futuristic">
                        <p class="text-black font-bold text-center text-lg w-full md:w-1/5 bg-yellow-400 px-2 py-1 mb-5 rounded"><?= htmlspecialchars($habit["username"]); ?></p>
                        <p class="text-sm text-white">Category: <?= htmlspecialchars($habit["category"]); ?></p>
                        <p class="text-lg font-semibold text-white">Habit ID: <?= htmlspecialchars(substr($habit["habit_id"], -3)); ?></p>
                        <p class="text-lg text-white"><?= htmlspecialchars($habit["title"]); ?></p>
                        <a class="bg-white text-purple-600 py-2 px-4 rounded-lg shadow-md hover:shadow-lg transition duration-300 mt-4 inline-block" href="delete_habit.php?habit_id=<?= $habit['habit_id'] ?>" onclick="return confirm('Are you sure you want to delete this habit?')">Delete</a>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>


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
