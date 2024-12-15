<?php
require_once(__DIR__ . '/../config.php');
require_once(ROOT_PATH . '/database/config/db_config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $room_id = $_POST['room_id'];
    $movie_id = $_POST['movie_id'];
    $number_of_seats = $_POST['number_of_seats'];
    $timezone = $_POST['timezone']; // Dynamic timezone passed as input

    // Calculate total amount
    $sql = "SELECT price_per_seat FROM rooms WHERE room_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $room_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $room = mysqli_fetch_assoc($result);
    $price_per_seat = $room['price_per_seat'];

    $total_amount = $number_of_seats * $price_per_seat;

    // Insert reservation into the database
    $sqlInsert = "INSERT INTO reservations (`user_id`, `room_id`, `movie_id`, `number_of_seats`, `timezone`, `total_amount`, `status`, `created_at`) 
                  VALUES (?, ?, ?, ?, ?, ?, 'pending', NOW())";

    $stmtInsert = mysqli_prepare($conn, $sqlInsert);

    if (!$stmtInsert) {
        die("Prepare failed: " . mysqli_error($conn));
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmtInsert, 'iiissd', $user_id, $room_id, $movie_id, $number_of_seats, $timezone, $total_amount);

    // Execute the statement
    if (mysqli_stmt_execute($stmtInsert)) {
        header("Location: " . BASE_URL . "/views/reservation_success.php?room_id=" . $room_id);
        exit();
    } else {
        die("Reservation failed: " . mysqli_error($conn));
    }

    // Close the statement and connection
    mysqli_stmt_close($stmtInsert);
    mysqli_close($conn);
}
?>
