<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="shortcut icon" type="x-icon" href="assets/img/Logo/NotedGo1.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Noted App</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Karla:ital,wght@0,200..800;1,200..800&family=Major+Mono+Display&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
      rel="stylesheet"
    />
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
        color: #6a00ff;
      }

      .feature-item {
        background: rgb(245, 251, 255);
        padding: 1rem;
        border-radius: 0.5rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
      }

      .feature-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
      }

      /* Eye Feature */
      .box {
        display: flex;
      }

      .box .eye {
        position: relative;
        width: 120px;
        height: 120px;
        display: block;
        background-color: #fff;
        margin: 0 20px;
        border-radius: 50%;
        box-shadow: 0 5px 45px rgba(0, 0, 0, 0.2), inset 0 0 15px #c0c0c0, inset 0 0 25px #4a4a4a;
      }

      .box .eye::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 35px;
        transform: translate(-50%, -50%);
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: #000;
        border: 10px solid #e098ff;
        box-sizing: border-box;
      }
      /* End of Eye Feature */

      .bg-image-1{
        background-image: url('assets/img/BG/bg-1.avif');
        background-size: cover;
        background-repeat: no-repeat;
      }
      .bg-image-2{
        background-image: url('assets/img/BG/bg-2.avif');
        background-size: cover;
        background-repeat: no-repeat;
      }

    </style>
  </head>
  <body class="mb-5 snow">
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

    <!-- Landing Section -->
    <section class="h-full flex items-center justify-center bg-image-1 py-20">
      <div class="container mx-auto px-4 text-center">
        <h1 class="text-3xl md:text-5xl font-bold text-6a00ff mb-6">Welcome to NotedApp</h1>
        <p class="text-lg md:text-2xl text-black mb-8">Your ultimate tool to track and manage your mood, habits, and more.</p>
        <div class="flex justify-center">
          <button class="bg-white text-6a00ff font-semibold py-3 px-8 rounded-lg shadow-lg hover:bg-gray-100 transition duration-300">Get Started</button>
        </div>
        <div class="mt-12 flex justify-center items-center">
          <div class="box">
            <div class="eye"></div>
            <div class="eye"></div>
          </div>
        </div>
      </div>
      <script>
        document.querySelector("body").addEventListener("mousemove", eyeball);
        function eyeball() {
          const eye = document.querySelectorAll(".eye");
          eye.forEach(function (eye) {
            let x = eye.getBoundingClientRect().left + eye.clientWidth / 2;
            let y = eye.getBoundingClientRect().top + eye.clientWidth / 2;

            let radian = Math.atan2(event.pageX - x, event.pageY - y);
            let rotation = radian * (180 / Math.PI) * -1 + 270;
            eye.style.transform = "rotate(" + rotation + "deg)";
          });
        }
      </script>
    </section>

    <!-- Introduction Section -->
    <section class="h-full flex items-center justify-center px-10 py-24">
      <div class="container mx-auto px-4 flex md:flex-row flex-col justify-center items-center">
        <div class="max-w-3xl mx-auto">
          <h2 class="text-3xl font-bold mb-6">Track Your Mood with NotedGo</h2>
          <p class="text-lg text-gray-700 text-justify">
            NotedGo is a personal note-taking app designed to help users note down and manage their moods effectively. This app not only allows you to write a diary, but also provides a customized approach based on your current mood: happy,
            sad, or empty. With NotedGo, you can observe your mood patterns, understand yourself better, and build positive habits through the intuitive habit tracking feature. NotedGo also allows users to customize the appearance of the app according to their preferences, making it more unique and tailored to
            individual lifestyles. Unlike other note-taking apps, NotedGo focuses on users' mental health, helping them overcome various emotions through specially designed psychological questions and inspirational quotes. Each month, you
            can view a mood graph that provides an accumulative picture of how you felt throughout the month, helping you reflect and plan better for the future.
          </p>
        </div>
        <img src="assets/img/Icon/notes.png" class="mx-5 w-full py-10" alt="Notes Icon" />
      </div>
    </section>

    <!-- Key Features Section -->
    <section class="h-full flex items-center bg-image-2 py-20">
      <div class="container mx-auto px-4 flex flex-wrap">
        <div class="max-w-3xl mx-auto text-center">
          <h3 class="text-5xl mb-10 text-white">Key Features:</h3>
          <ul class="text-left text-lg text-gray-700 space-y-6 flex flex-wrap">
            <li class="feature-item">
              <h4 class="font-bold">Mood Logging</h4>
              <p class="text-lg text-gray-700 text-justify">
                NotedGo lets you note down your feelings and thoughts easily. Every time you open the app, you can choose your mood at that time - happy, sad, or empty. Based on these choices, the app will adjust the display and questions
                it provides to help you better express your feelings. This feature ensures that every note you take is relevant and supports your mental health, helping you understand and manage your emotions in a better way.
              </p>
            </li>

            <li class="feature-item">
              <h4 class="font-bold">Habit Tracking</h4>
              <p class="text-lg text-gray-700 text-justify">
                This app is not only for recording your mood, but also helps you build positive habits. You can mark certain notes as habits and track them every day. NotedGo lets you set up to 10 habits at once, giving you flexibility in
                choosing the habits you want to build or maintain. You can also update or delete habits as needed, ensuring that your list of habits is always relevant and easy to follow.
              </p>
            </li>

            <li class="feature-item">
              <h4 class="font-bold">Monthly Chart</h4>
              <p class="text-lg text-gray-700 text-justify">
                One of the excellent features of NotedGo is the monthly graph which shows the distribution of your mood throughout the month. This graph helps you see your mood patterns, providing insight into the days when you feel happy,
                sad, or empty. With clear and informative visualizations, you can analyze your mood trends and make the necessary changes to improve your mental well-being.
              </p>
            </li>

            <li class="feature-item">
              <h4 class="font-bold">Inspirational Quotes</h4>
              <p class="text-lg text-gray-700 text-justify">
                NotedGo also provides different inspirational quotes for every mood. When you feel happy, sad, or empty, this application will display relevant quotes to provide encouragement or peace. This feature is designed to provide
                additional emotional support, helping you feel better and more motivated to continue recording and managing your mood.
              </p>
            </li>
          </ul>
        </div>
      </div>
    </section>

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
              <a href="index.php" class="link">Main</a>
              <a href="login.php" class="link">Login</a>
              <a href="register.php" class="link">Register</a>
            </nav>
          </div>
        </div>
      </div>
      <hr class="footer-divider my-8" />
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


