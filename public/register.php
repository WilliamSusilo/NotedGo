<?php
session_start();
require "connection.php";

$no = mysqli_query($conn, "SELECT user_id FROM users ORDER BY user_id DESC");

$usr_id = mysqli_fetch_array($no);
$id = $usr_id['user_id']?? '';

$urut = substr($id, 7, 3);
$tambah = (int) $urut + 1;
$bln = date("m");
$thn = date("y");

if(strlen($tambah) == 1){
    $format = "UR".$bln.$thn."00".$tambah;
} else if (strlen($tambah) == 2) {
    $format = "UR".$bln.$thn."0".$tambah;
} else {
    $format = "UR".$bln.$thn.$tambah;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $registPassword = $_POST["registPassword"];

    // Validasi untuk memastikan username dan email unik
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Debugging: Username atau email sudah digunakan
        $error = true;
    } else {
        // Menyimpan data ke database
        $stmt = $conn->prepare("INSERT INTO users (user_id, username, email, pass) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $user_id, $username, $email, $registPassword);

        if ($stmt->execute()) {
            // Redirect ke halaman login setelah berhasil register
            header("Location: login.php");
            exit;
        } else {
            // Debugging: Gagal menyimpan data ke database
            $error = true;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="assets/img/Logo/NotedGo1.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - NotedGo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <!-- SnowFall -->
    <script src="js/snowfall.min.js"></script>
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

        .bg-image-1{
            background-image: url('assets/img/BG/bg-3.avif');
            background-size: cover;
            background-repeat: no-repeat;
        }

        .register-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(80vh - 4rem);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-input {
            box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.1), 0 3px 5px rgba(0, 0, 0, 0.2);
            background: linear-gradient(145deg, #e6e6e6, #ffffff);
            transition: all 0.3s ease-in-out;
        }

        .form-input:focus {
            box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.2), 0 0 10px rgba(156, 39, 176, 0.5);
            background: linear-gradient(145deg, #d4d4d4, #f0f0f0);
        }
    </style>
</head>
<body class="bg-gray-100 mb-5 snow">
    <!-- Header and Navbar -->
    <header class="futuristic-purple px-5 py-4">
      <div class="container mx-auto flex justify-between items-center px-4">
        <a href="landing.php">
            <img src="assets/img/Logo/NotedGo2.png" class="w-40 py-0" alt="NotedGo Logo" />
        </a>
        <nav class="hidden md:block">
          <a href="login.php" class="text-white font-semibold text-xl hover:underline">Login</a>
          <a href="register.php" class="text-white font-semibold text-xl hover:underline ml-4">Register</a>
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
        <a href="login.php" class="text-black block px-3 py-2 rounded-md text-base font-medium hover:bg-purple-500">Login</a>
        <a href="register.php" class="text-black block px-3 py-2 rounded-md text-base font-medium hover:bg-purple-500">Register</a>
      </div>
    </div>

    <!-- Register Section -->
    <section class="register-container py-5 bg-image-1">
        <div class="container mx-auto px-4">
            <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-lg h-5/6 flex flex-col">
                <h2 class="text-2xl font-bold mb-10 text-center">Create an Account</h2>
                <form action="" method="POST" class="space-y-4">
                    <div class="flex flex-col justify-center items-center">
                        <div class="w-5/6 mb-10">
                            <div class="form-group mb-6">
                                <label for="user_id" class="form-label block text-gray-600 mb-2">User ID</label>
                                <input type="text" id="user_id" name="user_id" value="<?php echo $format;?>" readonly class="form-input w-full px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" required>
                            </div>
                            <div class="form-group mb-6">
                                <label for="username" class="form-label block text-gray-600 mb-2">Username</label>
                                <input type="text" id="username" name="username" class="form-input w-full px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" required>
                            </div>
                            <div class="form-group mb-6">
                                <label for="email" class="form-label block text-gray-600 mb-2">Email Address</label>
                                <input type="email" id="email" name="email" class="form-input w-full px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" required>
                            </div>
                            <div class="form-group mb-6">
                                <label for="registPassword" class="form-label block text-gray-600 mb-2">Password</label>
                                <input type="password" id="registPassword" name="registPassword" class="form-input w-full px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" required>
                            </div>

                            <?php if (isset($error)) : ?>
                            <p style="color: red; font-style: italic;">Username atau email sudah digunakan!</p>
                            <?php endif; ?>
                        </div>
                        <button type="submit" name="tambah" class="w-1/3 flex flex-row justify-center font-bold items-center section-title text-white py-2 px-4 rounded-lg hover:bg-purple-500 transition duration-300">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <hr class="footer-divider mb-8" />
        <p class="copyright text-center text-gray-700">&copy; 2024 Noted App - William Susilo</p>
    </footer>

    <!-- Javascript -->
    <script>
      document.getElementById('mobile-menu-button').addEventListener('click', function () {
        document.getElementById('mobile-menu').classList.toggle('hidden');
      });
    </script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/gsap.min.js"
        integrity="sha512-gmwBmiTVER57N3jYS3LinA9eb8aHrJua5iQD7yqYCKa5x6Jjc7VDVaEA0je0Lu0bP9j7tEjV3+1qUm6loO99Kw=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    ></script>
    <script src="js/script.js"></script>
</body>
</html>
