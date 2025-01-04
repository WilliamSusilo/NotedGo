<?php
session_start();
$user_id = $_SESSION['user_id']; 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="assets/img/Logo/NotedGo1.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - NotedGo</title>
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

        /* Colors */
        :root {
            --deep-blue: hsl(220, 30%, 20%);
            --jet-black: hsl(0, 0%, 10%);
            --futuristic-gray: hsl(240, 1%, 17%);
            --white: hsl(0, 0%, 100%);
            --futuristic-blue: hsl(200, 80%, 60%);
        }

        /* Sidebar Styles */
        .sidebar {
            background-color: var(--deep-blue);
            color: var(--white);
            width: 16rem; /* 256px */
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding: 1.5rem; /* 24px */
        }

        .sidebar h2 {
            font-size: 1.25rem; /* 20px */
            font-weight: bold;
            margin-bottom: 1rem; /* 16px */
        }


        .sidebar img {
            width: 9rem; /* 144px */
            padding: 0; /* reset padding */
            margin: 0 auto; /* center image */
        }

        img {
            filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.5)); /* Adjust the values as needed */
        }

    </style>
    <!-- Include Chart.js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
</head>

<body class="bg-white">
    <!-- Header -->
    <header class="futuristic-purple px-5 py-2 fixed top-0 w-full z-50">
        <div class="container mx-auto flex justify-between items-center px-4">
            <a href="dashboard.php">
                <img src="assets/img/Logo/NotedGo2.png" class="w-36 py-0" alt="NotedGo Logo" />
            </a>
            <a href="logout.php" class="text-white font-semibold text-xl hover:underline ml-4">Logout</a>
        </div>
    </header>

    <!-- Sidebar and Main Content Wrapper -->
    <div class="flex">

        <!-- Sidebar -->
        <aside class="sidebar text-white bg-black w-16 md:w-64 min-h-screen fixed left-0 h-full">
            <div class="px-3 pt-16 ">
                <h2 class="text-xl font-bold mb-4">Menu</h2>
                <nav class="space-y-2">
                    <a href="dashboard.php" class="block py-2 px-4 rounded hover:bg-gray-300 hover:text-black">Dashboard</a>
                    <a href="mood_selection.php" class="block py-2 px-4 rounded hover:bg-gray-300 hover:text-black">Add Note</a>
                    <a href="notes_section.php" class="block py-2 px-4 rounded hover:bg-gray-300 hover:text-black">List of Notes</a>
                    <a href="habit_section.php" class="block py-2 px-4 rounded hover:bg-gray-300 hover:text-black">List of Habits</a>
                    <a href="logout.php" class="block py-2 px-4 rounded hover:bg-gray-300 hover:text-black">Logout</a>
                </nav>
            </div>
            <div class="flex flex-col justify-center items-center pt-5 pb-10 md:hidden">
                <img src="assets/img/Icon/people-1.png" class="w-36 py-0" alt="NotedGo Logo" />
            </div>
        </aside>


        <!-- Main Content -->
        <main class="ml-64 md:ml-64 pt-16 mb-5 w-full">
            <!-- Monthly Stats Section -->
            <section>
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-4xl mx-auto">
                    <h2 class="text-3xl font-bold mb-10 text-center">Monthly Mood Statistics</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white border border-gray-200 rounded-lg shadow">
                            <div class="bg-gray-100 p-4 border-b border-gray-200 rounded-t-lg text-center">Pie Chart</div>
                            <div class="p-4">
                                <div class="chart-container pie-chart">
                                    <canvas id="pie_chart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white border border-gray-200 rounded-lg shadow">
                            <div class="bg-gray-100 p-4 border-b border-gray-200 rounded-t-lg text-center">Doughnut Chart</div>
                            <div class="p-4">
                                <div class="chart-container pie-chart">
                                    <canvas id="doughnut_chart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="bg-white border border-gray-200 rounded-lg shadow">
                            <div class="bg-gray-100 p-4 border-b border-gray-200 rounded-t-lg text-center">Bar Chart</div>
                            <div class="p-4">
                                <div class="chart-container pie-chart">
                                    <canvas id="bar_chart"></canvas>
                                </div>
                            </div>
                        </div>
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

        </main>
    </div>

    <script>
    $(document).ready(function () {
        var user_id = "<?php echo $user_id; ?>";  // Mengambil user_id dari session PHP

        makechart(user_id);

        function makechart(user_id) {
            $.ajax({
                url: "data.php",
                method: "POST",
                data: {
                    action: 'fetch',
                    user_id: user_id
                },
                dataType: "JSON",
                success: function (data) {
                    console.log(data);

                    var mood = [];
                    var total = [];
                    var color = [];

                    for (var count = 0; count < data.length; count++) {
                        mood.push(data[count].mood);
                        total.push(data[count].total);
                        color.push(data[count].color);
                    }

                    var chart_data = {
                        labels: mood,
                        datasets: [{
                            label: 'Total',
                            backgroundColor: color,
                            color: '#fff',
                            data: total
                        }]
                    };

                    var options = {
                        responsive: true,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    min: 0
                                }
                            }]
                        }
                    };

                    var pie_chart = $('#pie_chart');
                    var doughnut_chart = $('#doughnut_chart');
                    var bar_chart = $('#bar_chart');

                    new Chart(pie_chart, {
                        type: 'pie',
                        data: chart_data
                    });

                    new Chart(doughnut_chart, {
                        type: 'doughnut',
                        data: chart_data
                    });

                    new Chart(bar_chart, {
                        type: 'bar',
                        data: chart_data,
                        options: options
                    });
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            })
        }
    });
</script>


</body>

</html>
