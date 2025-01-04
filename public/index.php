<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="shortcut icon" type="x-icon" href="assets/img/Logo/NotedGo1.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Noted App</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet" />

    <style>
      body {
        font-family: "Karla", monospace;
      }

      .light {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        background: radial-gradient(circle at var(--x) var(--y), transparent 10%, rgba(0, 0, 0, 0.95) 20%);
      }
      .section-title {
        background-color: #6a00ff;
      }
    </style>
  </head>
  <body class="bg-black flex items-center justify-center min-h-screen text-white">
    <section class="text-center">
      <h2 class="text-5xl md:text-9xl lg:text-7xl font-bold mb-10">Welcome to Noted App!</h2>
      <img src="assets/img/Logo/NotedGo1.png" class="w-80 mx-auto mb-8" alt="NotedGo Logo" />
      <a href="landing.php" class="text-lg md:text-xl lg:text-3xl px-10 py-5 font-bold section-title text-white rounded-full hover:bg-blue-500 transition duration-300">Open The App</a>
    </section>
    <div class="light"></div>

    <script>
      var pos = document.documentElement;
      pos.addEventListener("mousemove", (e) => {
        pos.style.setProperty("--x", e.clientX + "px");
        pos.style.setProperty("--y", e.clientY + "px");
      });
    </script>
  </body>
</html>
