<?php

session_start();
require "connection.php";

if(isset($_POST["action"]))
{
    if($_POST["action"] == 'insert')
    {
        // Bagian insert tidak diperlukan untuk menampilkan mood dari tabel users, jadi kita bisa mengabaikannya atau menghapusnya
    }

    if($_POST["action"] == 'fetch')
    {
        if(isset($_SESSION['user_id']))
        {
            $user_id = $_SESSION['user_id'];

            $query = "
            SELECT 
                'Happy' as mood, SUM(happy) as total FROM users WHERE user_id = '$user_id'
            UNION
            SELECT 
                'Sad' as mood, SUM(sad) as total FROM users WHERE user_id = '$user_id'
            UNION
            SELECT 
                'Empty' as mood, SUM(empty) as total FROM users WHERE user_id = '$user_id'
            ";

            $result = $conn->query($query);

            $data = array();

            foreach($result as $row)
            {
                $data[] = array(
                    'mood'          => $row["mood"],
                    'total'         => $row["total"],
                    'color'         => '#' . rand(100000, 999999)
                );
            }

            echo json_encode($data);
        }
        else
        {
            echo "User ID not set in session.";
        }
    }
}
?>
