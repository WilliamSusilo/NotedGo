<?php
session_start();
require "connection.php";

$user_id = $_SESSION['user_id']; 

// Fetch user data from the database
$user_query = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$user_id'");
$users = mysqli_fetch_array($user_query);

// Check if the user data is valid before proceeding
if ($users) {
    // Generate new note ID
    $no = mysqli_query($conn, "SELECT note_id FROM notes WHERE user_id = '$user_id' ORDER BY note_id DESC LIMIT 1");
    $not_id = mysqli_fetch_array($no);
    $id = $not_id['note_id'] ?? '';
    $urut = substr($id, 6, 3);
    $tambah = $urut ? (int)$urut + 1 : 1;
    $usr = (int) substr($users["user_id"], -3);

    $format = sprintf("NT%03d%03d", $usr, $tambah);

    // Generate new habit ID
    $no_habit = mysqli_query($conn, "SELECT habit_id FROM habits WHERE user_id = '$user_id' ORDER BY habit_id DESC LIMIT 1");
    $hab_id = mysqli_fetch_array($no_habit);
    $id_ = $hab_id['habit_id'] ?? '';
    $urut_ = substr($id_, 7, 3);
    $tambah_ = $urut_ ? (int)$urut_ + 1 : 1;

    $format_ = sprintf("HB%03d%03d", $usr, $tambah_);

    // Now you can use $format and $format_ as needed
} else {
    // Handle the case where the user data is not found
    echo "User data not found";
}


// Check if mood parameter is set and valid
$mood = $_GET['mood'] ?? 'happy';
$moods = ['happy', 'sad', 'empty'];
if (!in_array($mood, $moods)) {
    header('Location: dashboard.php');
    exit();
}

// Set session variables
$_SESSION['mood'] = $mood;
$_SESSION['category'] = $_GET['category'] ?? 'general'; // default category if not set

// Fetch quotes based on mood (replace with actual fetching logic)
$quotes = [
    'happy' => [
        "The only way to find true happiness is to risk being completely cut open. - Chuck Palahniuk",
        "Happiness depends upon ourselves. - Aristotle",
        "The purpose of our lives is to be happy. - Dalai Lama",
    ],
    'sad' => [
        "Tears come from the heart and not from the brain. - Leonardo da Vinci",
        "There is no greater sorrow than to recall happiness in times of misery. - Dante Alighieri",
        "Sadness flies away on the wings of time. - Jean de La Fontaine",
    ],
    'empty' => [
        "Feeling empty is a natural part of being human. - Aditi Bose",
        "The soul that sees beauty may sometimes walk alone. - Johann Wolfgang von Goethe",
        "Sometimes you need to sit lonely on the floor in a quiet room in order to hear your own voice and not let it drown in the noise of others. - Charlotte Eriksson",
    ],
];

// Select a random quote for the selected mood
$random_quote = $quotes[$mood][array_rand($quotes[$mood])];

// Function to update mood counts
function update_mood_counts($conn, $user_id) {
    $moods = ['happy', 'sad', 'empty'];
    foreach ($moods as $mood) {
        $sql = "SELECT COUNT(*) AS count FROM notes WHERE user_id = ? AND mood = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $user_id, $mood);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'];

        $update_sql = "UPDATE users SET $mood = ? WHERE user_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param('is', $count, $user_id);
        $update_stmt->execute();
        $update_stmt->close();
    }
}

// Memeriksa Tombol Tambah Sudah Diklik atau Belum
if(isset($_POST['tambah'])){

    // Mengambil Data dari Formulir
    $note_id = htmlspecialchars($_POST['note_id']);
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);
    $category = htmlspecialchars($_POST['category']);
    $is_habit = isset($_POST['is_habit']) ? 1 : 0; // Mengambil nilai checkbox

    // Mengambil user_id dari sesi
    $user_id = $_SESSION["user_id"];

    // Memeriksa jumlah habit yang dimiliki user
    $habit_check_sql = "SELECT COUNT(*) AS habit_count FROM habits WHERE user_id = ?";
    $habit_check_stmt = $conn->prepare($habit_check_sql);
    $habit_check_stmt->bind_param('s', $user_id);
    $habit_check_stmt->execute();
    $habit_check_result = $habit_check_stmt->get_result();
    $habit_check_row = $habit_check_result->fetch_assoc();
    $habit_count = $habit_check_row['habit_count'];

    if ($habit_count >= 10 && $is_habit) {
        echo '<script>alert("You can Only Have a Maximum of 10 Habits.");</script>';
    } else {
        // Memasukkan catatan baru ke dalam tabel notes
        $sql = "INSERT INTO notes (note_id, user_id, mood, title, content, category) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }

        $stmt->bind_param('ssssss', $note_id, $user_id, $_SESSION['mood'], $title, $content, $category);
        $execute = $stmt->execute();

        // Mengecek Apakah Query Berhasil Disimpan
        if($execute) {
            // Update nilai mood di tabel users
            update_mood_counts($conn, $user_id);

            // Jika checkbox untuk habit dicentang, masukkan catatan ke dalam tabel habit
            if ($is_habit) {
                $habit_sql = "INSERT INTO habits (habit_id, user_id, note_id, title) VALUES (?, ?, ?, ?)";
                $habit_stmt = $conn->prepare($habit_sql);

                if ($habit_stmt === false) {
                    die('Prepare failed: ' . $conn->error);
                }

                $habit_id = $format_; // Assign the generated habit ID
                $habit_stmt->bind_param('ssss', $habit_id, $user_id, $note_id, $title);
                $habit_execute = $habit_stmt->execute();

                if (!$habit_execute) {
                    echo 'Habit Execute failed: ' . $habit_stmt->error;
                }

                $habit_stmt->close();
            }

            header('Location: dashboard.php?status=sukses');
        } else {
            echo 'Execute failed: ' . $stmt->error;
        }

        $stmt->close();
    }

    $habit_check_stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="assets/img/Logo/NotedGo1.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mood Selection - NotedGo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Custom styles */
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

        section {
            margin-bottom: 2rem;
        }

        blockquote {
            color: #4b5563;
        }

        input[type="text"],
        input[type="password"],
        textarea,
        select {
            width: 100%;
            padding: 0.75rem;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            outline: none;
        }


        @media (min-width: 640px) {
            main {
                padding: 4rem 0;
            }

            section {
                margin-bottom: 4rem;
            }

            blockquote {
                font-size: 1.1rem;
            }

            input[type="text"],
            input[type="password"],
            textarea,
            select {
                padding: 1rem;
            }

            button {
                padding: 1rem 2rem;
            }
        }
    </style>
</head>
<body class="mb-5">

    <!-- Header and Navbar -->
    <header class="futuristic-purple px-5 py-4">
      <div class="container mx-auto flex justify-between items-center px-4">
        <a href="dashboard.php">
            <img src="assets/img/Logo/NotedGo2.png" class="w-40 py-0" alt="NotedGo Logo" />
        </a>
        <nav class="hidden md:block">
            <a href="dashboard.php" class="text-white font-semibold text-xl hover:underline pr-7">Back to Dashboard</a>
            <a href="mood_selection.php" class="text-white font-semibold text-xl hover:underline">Back to Mood Selection</a>
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
        <a href="mood_selection.php" class="text-black block px-3 py-2 rounded-md text-base font-medium hover:bg-purple-500">Back to Mood Selection</a>
    </div>
    </div>

    <!-- Main Content -->
    <main class="pt-32 pb-10 mx-auto px-12 md:px-24 bg-image-1">

        <!-- Mood Quote Section -->
        <section class="mb-8 ">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-bold mb-4">Your <?= ucfirst($mood) ?> Mood Quote</h2>
                <blockquote class="italic text-gray-600"><?= htmlspecialchars($random_quote) ?></blockquote>
            </div>
        </section>

        <!-- Add Note Section -->
        <section class="mb-8">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-bold mb-4">Add New Note</h2>
                <form action="" method="POST" class="space-y-4">
                    <div>
                        <input type="text" id="note_id" name="note_id" value="<?php echo $format;?>" readonly class="w-full border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500" required>
                    </div> 
                    <div>
                        <label for="title" class="block text-gray-600">Title</label>
                        <input type="text" id="title" name="title" class="w-full border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500" required>
                    </div>
                    <div>
                        <label for="category">Kategori: </label>
                        <select name="category" id="category" class="w-full border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
                            <option value="" disabled selected>Pilih</option>
                            <option value="Task">Task</option>
                            <option value="Study">Study</option>
                            <option value="Hobby">Hobby</option>
                            <option value="Money">Money</option>
                            <option value="Health">Health</option>
                            <option value="Career">Career</option>
                            <option value="Family">Family</option>
                            <option value="Self Improvement">Self Improvement</option>
                        </select>
                    </div>
                    <div>
                        <label for="content" class="block text-gray-600">Content</label>
                        <textarea id="content" name="content" class="w-full border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500" required></textarea>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="is_habit" name="is_habit" class="mr-2">
                        <label for="is_habit" class="text-gray-600">Mark as habit</label>
                    </div>
                    <button type="submit" name="tambah" class="w-full bg-purple-700 text-lg font-bold text-white px-4 py-3 rounded-lg hover:bg-purple-500">Add Note</button>
                    </form>
            </div>
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
