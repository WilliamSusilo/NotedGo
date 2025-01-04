<?php
session_start();
require "connection.php";

if (isset($_POST["login"])) {
    $user_id = $_POST["user_id"];
    $loginUsername = $_POST["loginUsername"];
    $loginPassword = $_POST["loginPassword"];

    // Menggunakan prepared statements
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $loginUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    // Debugging: Tampilkan hasil dari query
    $num_rows = $result->num_rows;

    if ($num_rows === 1) {
        $row = $result->fetch_assoc();

        if ($loginPassword === $row['pass']) {
            $_SESSION["login"] = true;
            $_SESSION["user_id"] = $row['user_id'];
            $_SESSION["username"] = $loginUsername;

            header("Location: dashboard.php");
            exit;
        } 
    } 
    $error = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="assets/img/Logo/NotedGo1.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NotedGo</title>
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

      .login-container {
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
<body class="bg-white mb-5 snow">
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

    <section class="login-container py-7 bg-image-1">
        <div class="container mx-auto px-4">
            <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-lg h-5/6 flex flex-col ">
                <h2 class="text-2xl font-bold mb-10 text-center">Login to NotedGo</h2>
                <form action="" method="POST" class="space-y-4">
                    <?php
                    $no = 1;
                    ?>
                    <input type="hidden" name="user_id" value="<?= $no++; ?>">
                    
                    <div class="flex flex-col justify-center items-center ">
                        <div class="w-5/6 mb-10">
                            <div class="form-group mb-6">
                                <label for="loginUsername" class="form-label block text-gray-600 mb-2">Username</label>
                                <input type="text" id="loginUsername" name="loginUsername" class="form-input w-full px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" required>
                            </div>
                            <div class="form-group mb-6">
                                <label for="loginPassword" class="form-label block text-gray-600 mb-2">Password</label>
                                <input type="password" id="loginPassword" name="loginPassword" class="form-input w-full px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" required>
                            </div>

                            <?php if (isset($error)) : ?>
                            <p style="color: red; font-style: italic;">Incorrect Username or Password!</p>
                            <?php endif; ?>
                        </div>
                        <button type="submit" name="login" class="w-1/3 flex flex-row justify-center items-center font-bold section-title text-white py-2 px-4 rounded-lg hover:bg-purple-500 transition duration-300">Login</button>
                    </div>


                    
                </form>
            </div>
        </div>
    </section>

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
