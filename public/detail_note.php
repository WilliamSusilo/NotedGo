<?php
session_start();
require "connection.php";

if (isset($_GET['note_id'])) {
  $note_id = $_GET['note_id'];

$q = $conn->query("SELECT * FROM notes WHERE note_id = '$note_id'");

foreach ($q as $dt) :

// Query untuk mengambil data catatan berdasarkan note_id
$sql = "SELECT * FROM notes WHERE note_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $note_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Memastikan hanya user yang memiliki catatan tersebut yang dapat melihat detailnya
if ($row["user_id"] != $_SESSION["user_id"]) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="assets/img/Logo/NotedGo1.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Note</title>
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
            background-image: url('assets/img/BG/bg-1.avif');
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
            <a href="dashboard.php" class="text-white font-semibold text-xl hover:underline pr-7">Back to Dashboard</a>
            <a href="notes_section.php" class="text-white font-semibold text-xl hover:underline">Back to List of Notes</a>
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
        <a href="notes_section.php" class="text-black block px-3 py-2 rounded-md text-base font-medium hover:bg-purple-500">Back to List of Notes</a>
    </div>
    </div>

    <!-- Main Content -->
    <main class="container px-10 pt-10 md:pt-28 pb-10 h-full bg-image-1 mx-auto">

        <!-- Note Detail Section -->
        <section class="mb-8 bg-gradient-to-br from-purple-500 to-purple-700 text-white rounded-lg shadow-lg p-8">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-3xl font-bold"><?= $row["title"]; ?></h2>
                    <p class="text-sm text-gray-200">Category: <?= $row["category"]; ?></p>
                </div>
                <div class="text-sm text-gray-200">
                    <p>Mood : <?= ucfirst($row["mood"]); ?></p>
                    <p>Created : <?= $row["created_at"]; ?></p>
                </div>
            </div>
            <hr class="border border-gray-400 mb-4">
            <p class="text-lg mb-5"><?= $row["content"]; ?></p>
            <button id="editButton" class="bg-white text-purple-500 py-1 px-4 rounded-lg shadow-md hover:shadow-lg transition duration-300">Edit</button>
            <a class="bg-white text-purple-500 py-1 px-4 rounded-lg shadow-md hover:shadow-lg transition duration-300" href="delete_note.php?note_id=<?= $row['note_id'] ?>" onclick="return confirm('Are you sure you want to delete this data?')">Delete</a>
        </section>

        <!-- Form Edit Section -->
        <section id="editSection" class="hidden mb-8 bg-gradient-to-br from-purple-500 to-purple-700 text-white rounded-lg shadow-lg p-8">
            <form action="update_note.php" method="post">
                <input type="hidden" name="note_id" value="<?= $row["note_id"]; ?>">
                <div class="mb-4">
                    <label for="title" class="block text-lg  font-bold text-white mb-2">Title</label>
                    <input type="text" name="title" id="title" class="w-full bg-purple-600 bg-opacity-50 border border-gray-300 rounded-lg text-white p-2 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent" value="<?= $row["title"]; ?>" required>
                </div>
                <div class="mb-4">
                    <label for="content" class="block text-lg  font-bold text-white mb-2">Content</label>
                    <textarea name="content" id="content" rows="6" class="w-full bg-purple-600 bg-opacity-50 border border-gray-300 rounded-lg text-white p-2 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent" required><?= $row["content"]; ?></textarea>
                </div>
                <div>
                    <input type="hidden" id="mood" name="mood" value="<?= $row["mood"]; ?>">
                </div>
                <div>
                    <input type="hidden" id="category" name="category" value="<?= $row["category"]; ?>">
                </div>
                <button type="submit" name="tambah" class="bg-white text-purple-500 py-1 px-4 rounded-lg shadow-md hover:shadow-lg transition duration-300">Save Changes</button>
            </form>
        </section>


        <script>
            const editButton = document.getElementById('editButton');
            const editSection = document.getElementById('editSection');

            editButton.addEventListener('click', function() {
                editSection.classList.toggle('hidden');
            });
        </script>
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
<?php
  endforeach;
}