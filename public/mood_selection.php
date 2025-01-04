<?php
session_start();

if(isset($_GET['mood'])) {
    $_SESSION['mood'] = $_GET['mood'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="assets/img/Logo/NotedGo1.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Note - NotedGo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Custom styles can still be added here if needed */
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
            background-image: url('assets/img/BG/bg-3.avif');
            background-size: cover;
            background-repeat: no-repeat;
        }

    </style>
</head>
<body class="bg-white">
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
    <main class="container mx-auto px-4 pt-20 md:pt-32 h-72">
        <!-- Mood Selection Section -->
        <section class="mb-8">
            <div class="container mx-auto text-center">
                <p class="text-2xl font-semibold mb-7">Choose your Mood Right Now</p>
                <div class="flex flex-col md:flex-row justify-center items-center gap-5">
                    <a href="add_note.php?mood=happy" class="block bg-yellow-400 hover:bg-yellow-500 text-white font-bold text-xl md:text-3xl py-3 md:py-5 px-6 md:px-7 rounded-lg transition duration-300 transform hover:scale-110 shadow-xl">Happy</a>
                    <a href="add_note.php?mood=sad" class="block bg-blue-400 hover:bg-blue-500 text-white font-bold text-xl md:text-3xl py-3 md:py-5 px-6 md:px-7 rounded-lg transition duration-300 transform hover:scale-110 shadow-xl">Sad</a>
                    <a href="add_note.php?mood=empty" class="block bg-gray-400 hover:bg-gray-500 text-white font-bold text-xl md:text-3xl py-3 md:py-5 px-6 md:px-7 rounded-lg transition duration-300 transform hover:scale-110 shadow-xl">Empty</a>
                </div>
            </div>
        </section>
    </main>
    
    <footer class="footer mt-44 md:mt-20 px-10 mb-0">
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
